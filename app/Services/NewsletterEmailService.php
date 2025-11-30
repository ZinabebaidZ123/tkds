<?php

namespace App\Services;

use App\Models\Newsletter;
use App\Models\BlogPost;
use App\Mail\NewBlogPostNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class NewsletterEmailService
{
    public function sendNewPostNotification(BlogPost $post): array
    {
        try {
            Log::info('Starting newsletter notification process', [
                'post_id' => $post->id,
                'post_title' => $post->title
            ]);

            // Configure SMTP first
            $this->configureSMTP();
            
            // Get only ACTIVE subscribers
            $subscribers = Newsletter::where('status', 'active')->get();
            
            if ($subscribers->isEmpty()) {
                Log::warning('No active newsletter subscribers found', [
                    'post_id' => $post->id,
                    'post_title' => $post->title,
                    'total_subscribers' => Newsletter::count(),
                    'active_subscribers' => 0
                ]);
                
                return [
                    'success' => true,
                    'sent_count' => 0,
                    'total_subscribers' => Newsletter::count(),
                    'active_subscribers' => 0,
                    'message' => 'No active subscribers found to send to'
                ];
            }

            Log::info('Found subscribers to notify', [
                'post_id' => $post->id,
                'total_subscribers' => Newsletter::count(),
                'active_subscribers' => $subscribers->count()
            ]);

            $sentCount = 0;
            $failedCount = 0;
            $errors = [];

            foreach ($subscribers as $subscriber) {
                try {
                    Log::debug('Attempting to send to subscriber', [
                        'subscriber_email' => $subscriber->email,
                        'subscriber_id' => $subscriber->id,
                        'subscriber_status' => $subscriber->status
                    ]);

                    // Send the email
                    Mail::to($subscriber->email)->send(new NewBlogPostNotification($post));
                    $sentCount++;
                    
                    // Update last sent timestamp
                    $subscriber->update(['last_sent_at' => now()]);
                    
                    Log::info('Newsletter email sent successfully', [
                        'post_id' => $post->id,
                        'subscriber_email' => $subscriber->email,
                        'subscriber_id' => $subscriber->id,
                        'sent_count' => $sentCount
                    ]);
                    
                } catch (\Exception $e) {
                    $failedCount++;
                    $errors[] = [
                        'email' => $subscriber->email,
                        'error' => $e->getMessage()
                    ];
                    
                    Log::error('Failed to send newsletter email', [
                        'subscriber_email' => $subscriber->email,
                        'subscriber_id' => $subscriber->id,
                        'post_id' => $post->id,
                        'error' => $e->getMessage(),
                        'error_trace' => $e->getTraceAsString()
                    ]);
                }
                
                // Small delay to avoid overwhelming SMTP server
                usleep(100000); // 0.1 second delay
            }

            Log::info('Newsletter campaign completed', [
                'post_id' => $post->id,
                'post_title' => $post->title,
                'total_subscribers' => Newsletter::count(),
                'active_subscribers' => $subscribers->count(),
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
                'success_rate' => $subscribers->count() > 0 ? round(($sentCount / $subscribers->count()) * 100, 2) . '%' : '0%'
            ]);

            return [
                'success' => true,
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
                'total_subscribers' => Newsletter::count(),
                'active_subscribers' => $subscribers->count(),
                'message' => "Newsletter sent to {$sentCount} out of {$subscribers->count()} active subscribers" . 
                            ($failedCount > 0 ? " ({$failedCount} failed)" : ""),
                'errors' => $errors
            ];

        } catch (\Exception $e) {
            Log::error('Newsletter service critical error', [
                'post_id' => $post->id,
                'post_title' => $post->title,
                'error' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'sent_count' => 0,
                'failed_count' => 0,
                'total_subscribers' => Newsletter::count(),
                'active_subscribers' => 0,
                'message' => 'Critical error in newsletter service: ' . $e->getMessage(),
                'errors' => []
            ];
        }
    }

    private function configureSMTP(): void
    {
        try {
            // Clear any existing mail config
            Config::set('mail.default', null);
            
            // Set new SMTP configuration
            Config::set([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => 'mail.tkds.email',
                'mail.mailers.smtp.port' => 465,
                'mail.mailers.smtp.encryption' => 'ssl',
                'mail.mailers.smtp.username' => 'ai@tkds.email',
                'mail.mailers.smtp.password' => 'Ichn2020',
                'mail.mailers.smtp.timeout' => 60,
                'mail.mailers.smtp.verify_peer' => false,
                'mail.mailers.smtp.verify_peer_name' => false,
                'mail.from.address' => 'ai@tkds.email',
                'mail.from.name' => 'TKDS Media Blog'
            ]);

            Log::info('SMTP configuration applied successfully', [
                'host' => 'mail.tkds.email',
                'port' => 465,
                'encryption' => 'ssl',
                'username' => 'ai@tkds.email',
                'from_address' => 'ai@tkds.email',
                'from_name' => 'TKDS Media Blog'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to configure SMTP', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception('SMTP configuration failed: ' . $e->getMessage());
        }
    }

    // Helper method to get active subscriber count
    public function getActiveSubscriberCount(): int
    {
        try {
            $count = Newsletter::where('status', 'active')->count();
            Log::info('Active newsletter subscriber count check', [
                'active_subscribers' => $count,
                'total_subscribers' => Newsletter::count()
            ]);
            return $count;
        } catch (\Exception $e) {
            Log::error('Error getting active subscriber count', [
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }

    // Helper method to test email configuration
    public function testEmailConfiguration(): array
    {
        try {
            $this->configureSMTP();
            
            // Test with a simple mail
            $testRecipient = 'ai@tkds.email'; // Send test to yourself
            
            Mail::raw('This is a test email to verify SMTP configuration.', function($message) use ($testRecipient) {
                $message->to($testRecipient)
                        ->subject('SMTP Configuration Test - ' . now()->format('Y-m-d H:i:s'));
            });
            
            Log::info('SMTP test email sent successfully', [
                'test_recipient' => $testRecipient
            ]);
            
            return [
                'success' => true,
                'message' => 'Test email sent successfully to ' . $testRecipient
            ];
            
        } catch (\Exception $e) {
            Log::error('SMTP test failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'SMTP test failed: ' . $e->getMessage()
            ];
        }
    }
}