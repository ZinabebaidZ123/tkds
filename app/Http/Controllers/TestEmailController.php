<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Service;

class TestEmailController extends Controller
{
    public function testEmail(Request $request)
    {
        try {
            // Test basic email configuration
            $this->configureSMTP();
            
            // Get a service for testing
            $service = Service::first();
            if (!$service) {
                return response()->json([
                    'success' => false,
                    'message' => 'No service found for testing'
                ]);
            }

            $testEmailData = [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => 'Not provided',
                'customerMessage' => 'This is a test email to verify the email configuration is working correctly.',
                'payNow' => false,
                'itemType' => 'Service',
                'itemName' => $service->title,
                'itemId' => $service->id,
                'submittedAt' => now()->format('F j, Y g:i A'),
                'priority' => 'TEST'
            ];

            // Get the recipient email
            $recipientEmail = $service->contact_email ?: 'info@tkdsmedia.com';
            
            Log::info('Testing email configuration', [
                'service_id' => $service->id,
                'service_title' => $service->title,
                'service_contact_email' => $service->contact_email,
                'recipient_email' => $recipientEmail,
                'email_templates_exist' => [
                    'service_contact' => view()->exists('emails.service-contact'),
                    'auto_reply' => view()->exists('emails.service-contact-auto-reply')
                ]
            ]);

            // Test email sending
            Mail::send('emails.service-contact', $testEmailData, function ($message) use ($recipientEmail, $testEmailData) {
                $message->to($recipientEmail)
                        ->subject("[TEST] Email Configuration Test - {$testEmailData['itemName']}")
                        ->from('ai@tkds.email', 'TKDS Media Test');
            });

            Log::info('Test email sent successfully', [
                'recipient' => $recipientEmail,
                'service_title' => $service->title
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully',
                'details' => [
                    'recipient' => $recipientEmail,
                    'service' => $service->title,
                    'service_contact_email' => $service->contact_email,
                    'templates_exist' => view()->exists('emails.service-contact')
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Test email failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Test email failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkServiceEmails()
    {
        try {
            $services = Service::select('id', 'title', 'contact_email', 'status')->get();
            
            $results = $services->map(function($service) {
                return [
                    'id' => $service->id,
                    'title' => $service->title,
                    'contact_email' => $service->contact_email,
                    'has_contact_email' => !empty($service->contact_email),
                    'fallback_email' => 'info@tkdsmedia.com',
                    'final_recipient' => $service->contact_email ?: 'info@tkdsmedia.com',
                    'status' => $service->status
                ];
            });

            return response()->json([
                'success' => true,
                'services' => $results,
                'total_services' => $services->count(),
                'services_with_email' => $services->whereNotNull('contact_email')->count(),
                'services_without_email' => $services->whereNull('contact_email')->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to check service emails', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to check service emails: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkEmailConfig()
    {
        try {
            $this->configureSMTP();
            
            $config = [
                'mail_driver' => config('mail.default'),
                'smtp_host' => config('mail.mailers.smtp.host'),
                'smtp_port' => config('mail.mailers.smtp.port'),
                'smtp_encryption' => config('mail.mailers.smtp.encryption'),
                'smtp_username' => config('mail.mailers.smtp.username'),
                'from_address' => config('mail.from.address'),
                'from_name' => config('mail.from.name')
            ];

            return response()->json([
                'success' => true,
                'config' => $config,
                'templates_exist' => [
                    'service_contact' => view()->exists('emails.service-contact'),
                    'auto_reply' => view()->exists('emails.service-contact-auto-reply')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Config check failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function configureSMTP()
    {
        config([
            'mail.default'                 => 'smtp',
            'mail.mailers.smtp.host'       => 'mail.tkds.email',
            'mail.mailers.smtp.port'       => 465,
            'mail.mailers.smtp.encryption' => 'ssl',
            'mail.mailers.smtp.username'   => 'ai@tkds.email',
            'mail.mailers.smtp.password'   => 'Ichn2020',
            'mail.from.address'            => 'ai@tkds.email',
            'mail.from.name'               => 'TKDS Media Service Inquiry',
        ]);
    }
}