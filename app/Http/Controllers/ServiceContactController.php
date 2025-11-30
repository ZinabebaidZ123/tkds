<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use App\Models\Service;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class ServiceContactController extends Controller
{
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255|min:2',
            'lastName' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20|min:10',
            'message' => 'required|string|max:2000|min:10',
            'payNow' => 'nullable|boolean',
            'item_type' => 'required|in:service,product',
            'item_id' => 'required|integer|min:1',
            'item_name' => 'required|string|max:255'
        ], [
            'firstName.required' => 'First name is required',
            'firstName.min' => 'First name must be at least 2 characters',
            'lastName.required' => 'Last name is required',
            'lastName.min' => 'Last name must be at least 2 characters',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'phone.min' => 'Phone number must be at least 10 characters',
            'message.required' => 'Message is required',
            'message.min' => 'Message must be at least 10 characters',
            'message.max' => 'Message cannot exceed 2000 characters',
            'item_type.required' => 'Item type is required',
            'item_type.in' => 'Invalid item type',
            'item_id.required' => 'Item ID is required',
            'item_id.integer' => 'Item ID must be a number',
            'item_name.required' => 'Item name is required'
        ]);

        if ($validator->fails()) {
            Log::warning('Service contact form validation failed', [
                'errors' => $validator->errors()->toArray(),
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Please correct the following errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Rate limiting check
            $rateLimitKey = 'service_contact_' . $request->ip();
            $recentSubmissions = Cache::get($rateLimitKey, 0);
            
            if ($recentSubmissions >= 3) {
                Log::warning('Rate limit exceeded for service contact form', [
                    'ip_address' => $request->ip(),
                    'submissions' => $recentSubmissions
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Too many submissions. Please wait 5 minutes before trying again.'
                ], 429);
            }

            $data = $validator->validated();
            
            $recipientData = $this->getRecipientData($data['item_type'], $data['item_id']);
            
            if (!$recipientData) {
                Log::error('Service/Product not found', [
                    'item_type' => $data['item_type'],
                    'item_id' => $data['item_id']
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'The requested service or product was not found.'
                ], 404);
            }

            // Use professional fallback email
            $recipientEmail = $recipientData['email'] ?: 'ai@tkds.email';
            
            if (!$recipientData['email']) {
                Log::warning('No specific contact email found, using fallback', [
                    'item_type' => $data['item_type'],
                    'item_id' => $data['item_id'],
                    'fallback_email' => $recipientEmail
                ]);
            }

            // Configure SMTP settings with anti-spam configuration
            $this->configureSMTP();

            // Clean message content and avoid spam trigger words
            $cleanMessage = $this->cleanMessageForAntiSpam($data['message']);

            // Generate reference ID
            $referenceId = 'TKDS-' . date('Ymd') . '-' . str_pad($data['item_id'], 4, '0', STR_PAD_LEFT) . '-' . substr(md5(time()), 0, 6);

            $emailData = [
                'name' => trim($data['firstName'] . ' ' . $data['lastName']),
                'email' => strtolower(trim($data['email'])),
                'phone' => $data['phone'] ?? 'Not provided',
                'customerMessage' => $cleanMessage, 
                'payNow' => $data['payNow'] ?? false,
                'itemType' => ucfirst($data['item_type']),
                'itemName' => $recipientData['name'],
                'itemId' => $data['item_id'],
                'submittedAt' => now()->format('F j, Y g:i A'),
                'priority' => ($data['payNow'] ?? false) ? 'high' : 'normal',
                'reference_id' => $referenceId
            ];

            // Check if email templates exist
            if (!view()->exists('emails.service-contact')) {
                Log::error('Email template not found: emails.service-contact');
                
                return response()->json([
                    'success' => false,
                    'message' => 'Email configuration error. Please contact support directly at ai@tkds.email'
                ], 500);
            }

            // Create anti-spam professional subject
            $professionalSubject = $this->createAntiSpamSubject($emailData['itemName'], $emailData['priority']);

            Log::info('Attempting to send email', [
                'recipient' => $recipientEmail,
                'subject' => $professionalSubject,
                'customer' => $emailData['email']
            ]);

            // Send email to recipient with anti-spam headers
            try {
                Mail::send('emails.service-contact', $emailData, function ($message) use ($recipientEmail, $emailData, $professionalSubject) {
                    $message->to($recipientEmail)
                            ->subject($professionalSubject)
                            ->from('ai@tkds.email', 'TKDS Media Contact Form')
                            // لا تستخدم replyTo مع إيميل العميل مباشرة
                            ->replyTo('ai@tkds.email', 'TKDS Media');
                    
                    // Add anti-spam headers
                    $headers = $message->getHeaders();
                    
                    // Professional headers
                    $headers->addTextHeader('X-Mailer', 'TKDS Media Contact System v1.0');
                    $headers->addTextHeader('X-Auto-Response-Suppress', 'All');
                    $headers->addTextHeader('List-Unsubscribe', '<mailto:unsubscribe@tkds.email>');
                    $headers->addTextHeader('X-Entity', 'TKDS Media LLC');
                    $headers->addTextHeader('Organization', 'TKDS Media');
                    
                    // Authentication headers
                    $headers->addTextHeader('X-Originating-IP', '[127.0.0.1]');
                    $headers->addTextHeader('X-Source', 'Contact Form');
                    $headers->addTextHeader('X-Customer-Email', $emailData['email']);
                    $headers->addTextHeader('X-Customer-Name', $emailData['name']);
                    
                    // Business headers
                    $headers->addTextHeader('X-Business-Category', 'Customer Inquiry');
                    $headers->addTextHeader('X-Message-Type', 'Business Communication');
                    
                    // Set priority properly
                    if ($emailData['priority'] === 'high') {
                        $message->priority(2); // Use 2 instead of 1 to avoid spam
                        $headers->addTextHeader('X-Priority', '2');
                        $headers->addTextHeader('Importance', 'High');
                    } else {
                        $headers->addTextHeader('X-Priority', '3');
                        $headers->addTextHeader('Importance', 'Normal');
                    }
                });

                Log::info('Service contact email sent successfully', [
                    'recipient' => $recipientEmail,
                    'customer' => $emailData['email'],
                    'priority' => $emailData['priority'],
                    'reference_id' => $emailData['reference_id'],
                    'subject' => $professionalSubject
                ]);

            } catch (Exception $e) {
                Log::error('Failed to send service contact email', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'recipient' => $recipientEmail,
                    'mail_config' => [
                        'host' => config('mail.mailers.smtp.host'),
                        'port' => config('mail.mailers.smtp.port'),
                        'username' => config('mail.mailers.smtp.username'),
                        'encryption' => config('mail.mailers.smtp.encryption')
                    ]
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send email to our team. Please try again or contact us directly at ai@tkds.email'
                ], 500);
            }

            // Send auto-reply to customer if template exists
            if (view()->exists('emails.service-contact-auto-reply')) {
                try {
                    Mail::send('emails.service-contact-auto-reply', $emailData, function ($message) use ($emailData) {
                        $message->to($emailData['email'], $emailData['name'])
                                ->subject("TKDS Media - Thank you for your inquiry (Ref: {$emailData['reference_id']})")
                                ->from('ai@tkds.email', 'TKDS Media')
                                ->replyTo('ai@tkds.email', 'TKDS Media Support');
                        
                        // Add professional headers for auto-reply
                        $headers = $message->getHeaders();
                        $headers->addTextHeader('X-Mailer', 'TKDS Media Auto-Reply System');
                        $headers->addTextHeader('X-Auto-Response-Suppress', 'OOF');
                        $headers->addTextHeader('Auto-Submitted', 'auto-replied');
                        $headers->addTextHeader('X-Message-Type', 'Auto-Reply');
                        $headers->addTextHeader('Organization', 'TKDS Media');
                    });

                    Log::info('Auto-reply email sent successfully', [
                        'customer' => $emailData['email'],
                        'reference_id' => $emailData['reference_id']
                    ]);

                } catch (Exception $e) {
                    Log::warning('Failed to send auto-reply email', [
                        'error' => $e->getMessage(),
                        'customer' => $emailData['email']
                    ]);
                }
            }

            // Update rate limiting counter
            Cache::put($rateLimitKey, $recentSubmissions + 1, now()->addMinutes(5));

            Log::info('Service contact form submitted successfully', [
                'customer_name' => $emailData['name'],
                'customer_email' => $emailData['email'],
                'item_type' => $data['item_type'],
                'item_id' => $data['item_id'],
                'item_name' => $emailData['itemName'],
                'priority' => $emailData['priority'],
                'recipient_email' => $recipientEmail,
                'reference_id' => $emailData['reference_id']
            ]);

            $responseMessage = $emailData['priority'] === 'high' 
                ? "Thank you for your inquiry! Our priority support team will contact you within 1 hour. Reference: {$emailData['reference_id']}"
                : "Thank you for your inquiry! We will contact you within 24 hours. Reference: {$emailData['reference_id']}";

            return response()->json([
                'success' => true,
                'message' => $responseMessage,
                'reference_id' => $emailData['reference_id'],
                'priority' => $emailData['priority']
            ]);

        } catch (Exception $e) {
            Log::error('Service contact form unexpected error', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later or contact us directly at ai@tkds.email'
            ], 500);
        }
    }

    /**
     * Configure SMTP settings with anti-spam configuration
     */
    private function configureSMTP()
    {
        try {
            Config::set([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => env('MAIL_HOST', 'mail.tkds.email'),
                'mail.mailers.smtp.port' => env('MAIL_PORT', 465),
                'mail.mailers.smtp.encryption' => env('MAIL_ENCRYPTION', 'ssl'),
                'mail.mailers.smtp.username' => env('MAIL_USERNAME', 'ai@tkds.email'),
                'mail.mailers.smtp.password' => env('MAIL_PASSWORD', 'Ichn2020'),
                'mail.from.address' => env('MAIL_FROM_ADDRESS', 'ai@tkds.email'),
                'mail.from.name' => env('MAIL_FROM_NAME', 'TKDS Media'),
                'mail.mailers.smtp.timeout' => 30,
                'mail.mailers.smtp.verify_peer' => false,
                'mail.mailers.smtp.verify_peer_name' => false,
                'mail.mailers.smtp.allow_self_signed' => true,
                // Anti-spam SMTP settings
                'mail.mailers.smtp.stream_options' => [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    ]
                ]
            ]);

            Log::debug('SMTP configuration applied successfully with anti-spam settings');
            
        } catch (Exception $e) {
            Log::error('Failed to configure SMTP settings', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Clean message content to avoid spam triggers
     */
    private function cleanMessageForAntiSpam($message)
    {
        // Remove spam trigger words and phrases
        $spamWords = [
            'urgent' => 'important',
            'free money' => 'financial assistance',
            'guaranteed' => 'assured',
            'limited time' => 'time-sensitive',
            'act now' => 'please respond',
            'click here' => 'please visit',
            'buy now' => 'purchase',
            'discount' => 'special offer',
            'winner' => 'selected',
        ];
        
        $cleanMessage = $message;
        foreach ($spamWords as $spam => $replacement) {
            $cleanMessage = str_ireplace($spam, $replacement, $cleanMessage);
        }
        
        // Remove excessive punctuation that triggers spam filters
        $cleanMessage = preg_replace('/!{2,}/', '!', $cleanMessage);
        $cleanMessage = preg_replace('/\?{2,}/', '?', $cleanMessage);
        
        // Remove excessive capitalization using preg_replace_callback
        $cleanMessage = preg_replace_callback('/[A-Z]{4,}/', function($matches) {
            return ucfirst(strtolower($matches[0]));
        }, $cleanMessage);
        
        // Clean HTML tags and normalize text
        $cleanMessage = strip_tags($cleanMessage);
        $cleanMessage = trim($cleanMessage);
        
        return $cleanMessage;
    }

    /**
     * Create anti-spam subject line
     */
    private function createAntiSpamSubject($itemName, $priority = 'normal')
    {
        $timestamp = date('M j, Y');
        
        // Avoid spam trigger words in subject
        if ($priority === 'high') {
            return "Business Inquiry: {$itemName} - {$timestamp}";
        } else {
            return "Service Inquiry: {$itemName} - {$timestamp}";
        }
    }

    private function getRecipientData($itemType, $itemId)
    {
        try {
            if ($itemType === 'service') {
                $service = DB::table('services')
                    ->select('id', 'title', 'contact_email')
                    ->where('id', $itemId)
                    ->where('status', 'active')
                    ->first();
                    
                if (!$service) {
                    Log::warning('Service not found or inactive', [
                        'service_id' => $itemId,
                        'item_type' => $itemType
                    ]);
                    return null;
                }
                
                Log::info('Retrieved service data from database', [
                    'service_id' => $service->id,
                    'title' => $service->title,
                    'contact_email' => $service->contact_email,
                    'has_email' => !empty($service->contact_email)
                ]);
                
                return [
                    'email' => $service->contact_email,
                    'name' => $service->title
                ];
                
            } elseif ($itemType === 'product') {
                $product = DB::table('products')
                    ->select('id', 'title', 'contact_email')
                    ->where('id', $itemId)
                    ->where('status', 'active')
                    ->first();
                    
                if (!$product) {
                    Log::warning('Product not found or inactive', [
                        'product_id' => $itemId,
                        'item_type' => $itemType
                    ]);
                    return null;
                }
                
                Log::info('Retrieved product data from database', [
                    'product_id' => $product->id,
                    'title' => $product->title,
                    'contact_email' => $product->contact_email,
                    'has_email' => !empty($product->contact_email)
                ]);
                
                return [
                    'email' => $product->contact_email,
                    'name' => $product->title
                ];
            }

            Log::warning('Invalid item type provided', ['item_type' => $itemType]);
            return null;
            
        } catch (Exception $e) {
            Log::error('Error getting recipient data', [
                'item_type' => $itemType,
                'item_id' => $itemId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function getItems()
    {
        try {
            $services = Service::active()
                              ->select('id', 'title', 'contact_email')
                              ->orderBy('title')
                              ->get()
                              ->map(function($service) {
                                  return [
                                      'id' => $service->id,
                                      'type' => 'service',
                                      'title' => $service->title,
                                      'has_contact_email' => !empty($service->contact_email)
                                  ];
                              });

            $products = Product::where('status', 'active')
                              ->select('id', 'title', 'contact_email')
                              ->orderBy('title')
                              ->get()
                              ->map(function($product) {
                                  return [
                                      'id' => $product->id,
                                      'type' => 'product', 
                                      'title' => $product->title,
                                      'has_contact_email' => !empty($product->contact_email)
                                  ];
                              });

            return response()->json([
                'success' => true,
                'data' => [
                    'services' => $services,
                    'products' => $products
                ]
            ]);

        } catch (Exception $e) {
            Log::error('Failed to fetch items for contact form', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load items.'
            ], 500);
        }
    }
}
