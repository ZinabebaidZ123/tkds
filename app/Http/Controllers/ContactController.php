<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Models\ContactSetting;
use App\Models\ContactFaq;
use App\Services\ReCaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    private ReCaptchaService $recaptchaService;

    public function __construct(ReCaptchaService $recaptchaService)
    {
        $this->recaptchaService = $recaptchaService;
    }

    public function index()
    {
        $settings = ContactSetting::getSettings();
        
        // Check if contact page is active
        if (!$settings->isActive()) {
            abort(404, 'Contact page is currently unavailable.');
        }
        
        $faqs = ContactFaq::active()->ordered()->get()->groupBy('category');
        
        return view('contact', compact('settings', 'faqs'));
    }

    public function store(Request $request)
    {
        try {
            // Base validation rules
            $rules = [
                'firstName' => 'required|string|max:255|min:2',
                'lastName' => 'required|string|max:255|min:2',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20|min:10',
                'service' => 'nullable|string|max:100',
                'budget' => 'nullable|string|max:50',
                'message' => 'required|string|max:2000|min:10',
            ];

            // Add reCAPTCHA validation if enabled
            $recaptchaRules = $this->recaptchaService->getValidationRule('contact');
            $rules = array_merge($rules, $recaptchaRules);

            $messages = [
                'firstName.required' => 'First name is required.',
                'firstName.min' => 'First name must be at least 2 characters.',
                'lastName.required' => 'Last name is required.',
                'lastName.min' => 'Last name must be at least 2 characters.',
                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'phone.min' => 'Phone number must be at least 10 characters.',
                'message.required' => 'Message is required.',
                'message.min' => 'Message must be at least 10 characters.',
                'message.max' => 'Message cannot exceed 2000 characters.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Rate limiting check - prevent spam
            $recentSubmissions = ContactSubmission::where('ip_address', $request->ip())
                                                ->where('created_at', '>=', now()->subMinutes(5))
                                                ->count();

            if ($recentSubmissions >= 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Too many submissions. Please wait a few minutes before trying again.'
                ], 429);
            }

            // Check for duplicate submissions (same email + similar message in last hour)
            $duplicateCheck = ContactSubmission::where('email', $request->email)
                                              ->where('created_at', '>=', now()->subHour())
                                              ->where('message', 'like', '%' . substr($request->message, 0, 50) . '%')
                                              ->first();

            if ($duplicateCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'A similar message from this email was already received recently.'
                ], 422);
            }

            // Create submission
            $submission = ContactSubmission::create([
                'first_name' => trim($request->firstName),
                'last_name' => trim($request->lastName),
                'email' => strtolower(trim($request->email)),
                'phone' => $request->phone ? preg_replace('/[^\d+\-\(\)\s]/', '', $request->phone) : null,
                'service_interest' => $request->service,
                'budget' => $request->budget,
                'message' => trim($request->message),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'unread'
            ]);

            Log::info('Contact submission created successfully', [
                'submission_id' => $submission->id,
                'name' => $submission->full_name,
                'email' => $submission->email,
                'recaptcha_enabled' => $this->recaptchaService->shouldShow('contact', $request)
            ]);

            $settings = ContactSetting::getSettings();

            // Send auto-reply if enabled
            if ($settings->auto_reply_enabled && $settings->auto_reply_message) {
                $this->sendAutoReply($submission, $settings);
            }

            // Send notification to admin
            $this->sendAdminNotification($submission, $settings);

            // Determine response message based on priority
            $responseMessage = 'Thank you for your message! We will get back to you soon.';
            
            if ($submission->getPriorityScore() >= 80) {
                $responseMessage = 'Thank you for your high-priority inquiry! Our team will contact you within 1 hour.';
            } elseif ($submission->getPriorityScore() >= 50) {
                $responseMessage = 'Thank you for your message! We will get back to you within 4 hours.';
            }

            return response()->json([
                'success' => true,
                'message' => $responseMessage,
                'submission_id' => $submission->id,
                'priority' => $submission->getPriorityLabel()
            ]);

        } catch (\Exception $e) {
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'email' => $request->email ?? 'N/A',
                'ip' => $request->ip(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Sorry, something went wrong. Please try again later or contact us directly.'
            ], 500);
        }
    }

    private function sendAutoReply($submission, $settings)
    {
        try {
            $emailData = [
                'submission' => $submission,
                'settings' => $settings,
                'subject' => $settings->auto_reply_subject ?? 'Thank you for contacting TKDS Media',
                'message' => $settings->auto_reply_message
            ];

            Mail::send('emails.contact-auto-reply', $emailData, function ($message) use ($submission, $settings) {
                $message->to($submission->email, $submission->full_name)
                        ->subject($settings->auto_reply_subject ?? 'Thank you for contacting TKDS Media')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            Log::info('Auto-reply email sent successfully', [
                'submission_id' => $submission->id,
                'email' => $submission->email
            ]);
        } catch (\Exception $e) {
            Log::error('Auto-reply email failed', [
                'submission_id' => $submission->id,
                'email' => $submission->email,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function sendAdminNotification($submission, $settings)
    {
        try {
            $notificationEmails = $settings->getNotificationEmailsArray();
            if (!empty($notificationEmails)) {
                $emailData = [
                    'submission' => $submission,
                    'settings' => $settings
                ];

                Mail::send('emails.contact-notification', $emailData, function ($message) use ($notificationEmails, $submission) {
                    $message->to($notificationEmails)
                            ->subject('New Contact Form Submission - ' . $submission->full_name)
                            ->from(config('mail.from.address'), config('mail.from.name'));
                    
                    // Set priority based on submission score
                    if ($submission->getPriorityScore() >= 80) {
                        $message->priority(1); // High priority
                    } elseif ($submission->getPriorityScore() >= 50) {
                        $message->priority(3); // Normal priority
                    } else {
                        $message->priority(5); // Low priority
                    }
                });
                
                Log::info('Notification email sent successfully', [
                    'submission_id' => $submission->id,
                    'recipients' => $notificationEmails,
                    'priority' => $submission->getPriorityLabel()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Notification email failed', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle AJAX contact form from homepage
     */
    public function ajaxStore(Request $request)
    {
        return $this->store($request);
    }

    /**
     * API endpoint for getting contact settings (for AJAX requests)
     */
    public function getSettings()
    {
        $settings = ContactSetting::getSettings();
        
        return response()->json([
            'success' => true,
            'data' => [
                'hero_title' => $settings->hero_title,
                'hero_subtitle' => $settings->hero_subtitle,
                'form_title' => $settings->form_title,
                'office_phone' => $settings->office_phone,
                'office_email' => $settings->office_email,
                'support_hours' => [
                    'monday_friday' => $settings->monday_friday_hours,
                    'saturday' => $settings->saturday_hours,
                    'sunday' => $settings->sunday_hours,
                    'emergency' => [
                        'enabled' => $settings->emergency_support,
                        'text' => $settings->emergency_text
                    ]
                ],
                'social_links' => $settings->getSocialLinks(),
                'is_active' => $settings->isActive(),
                'recaptcha' => $this->recaptchaService->getSettings()->getFrontendConfig()
            ]
        ]);
    }

    /**
     * Check contact form status (for monitoring)
     */
    public function status()
    {
        $settings = ContactSetting::getSettings();
        
        $stats = [
            'is_active' => $settings->isActive(),
            'auto_reply_enabled' => $settings->auto_reply_enabled,
            'total_submissions_today' => ContactSubmission::whereDate('created_at', today())->count(),
            'unread_submissions' => ContactSubmission::unread()->count(),
            'recent_submissions' => ContactSubmission::where('created_at', '>=', now()->subHour())->count(),
            'recaptcha_enabled' => $this->recaptchaService->getSettings()->isEnabledFor('contact')
        ];

        return response()->json([
            'success' => true,
            'status' => 'operational',
            'stats' => $stats
        ]);
    }
}