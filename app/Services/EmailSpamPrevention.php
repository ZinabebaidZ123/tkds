<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class EmailSpamPrevention
{
    /**
     * Configure anti-spam SMTP settings
     */
    public static function configureAntiSpamSMTP()
    {
        try {
            // Set SMTP configuration for anti-spam
            Config::set([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => env('MAIL_HOST', 'mail.tkds.email'),
                'mail.mailers.smtp.port' => env('MAIL_PORT', 465),
                'mail.mailers.smtp.encryption' => env('MAIL_ENCRYPTION', 'ssl'),
                'mail.mailers.smtp.username' => env('MAIL_USERNAME', 'ai@tkds.email'),
                'mail.mailers.smtp.password' => env('MAIL_PASSWORD', 'Ichn2020'),
                'mail.from.address' => env('MAIL_FROM_ADDRESS', 'ai@tkds.email'),
                'mail.from.name' => env('MAIL_FROM_NAME', 'TKDS Media'),
                
                // Additional anti-spam settings
                'mail.mailers.smtp.timeout' => 30,
                'mail.mailers.smtp.auth_mode' => null,
                'mail.mailers.smtp.verify_peer' => false,
                'mail.mailers.smtp.verify_peer_name' => false,
                'mail.mailers.smtp.allow_self_signed' => true,
            ]);

            Log::info('Anti-spam SMTP configuration applied successfully');
            
        } catch (\Exception $e) {
            Log::error('Failed to configure anti-spam SMTP settings', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Check sending rate limit
     */
    public static function checkSendingRate($identifier, $maxAttempts = 20, $minutes = 60)
    {
        $key = 'email_rate_limit_' . $identifier;
        $attempts = Cache::get($key, 0);
        
        if ($attempts >= $maxAttempts) {
            Log::warning('Email sending rate limit exceeded', [
                'identifier' => $identifier,
                'attempts' => $attempts,
                'max_attempts' => $maxAttempts
            ]);
            return false;
        }
        
        Cache::put($key, $attempts + 1, now()->addMinutes($minutes));
        return true;
    }

    /**
     * Clean spam words from message content
     */
    public static function cleanSpamWords($message)
    {
        // Common spam trigger words to clean/replace
        $spamWords = [
            'free money' => 'complimentary service',
            'click here' => 'please visit',
            'urgent' => 'important',
            'limited time' => 'special offer',
            'guarantee' => 'assurance',
            'no obligation' => 'no commitment required',
            '100% free' => 'complimentary',
            'act now' => 'take action',
            'call now' => 'contact us',
            'buy now' => 'purchase',
        ];
        
        $cleanMessage = $message;
        foreach ($spamWords as $spam => $replacement) {
            $cleanMessage = str_ireplace($spam, $replacement, $cleanMessage);
        }
        
        // Remove excessive exclamation marks
        $cleanMessage = preg_replace('/!{2,}/', '!', $cleanMessage);
        
        // Remove excessive capitalization
        $cleanMessage = preg_replace('/[A-Z]{4,}/', function($matches) {
            return ucfirst(strtolower($matches[0]));
        }, $cleanMessage);
        
        return $cleanMessage;
    }

    /**
     * Create professional subject line
     */
    public static function createProfessionalSubject($itemName, $priority = 'normal')
    {
        $prefix = $priority === 'high' ? '[Priority]' : '[Inquiry]';
        $timestamp = date('M j');
        
        return "{$prefix} Service Request: {$itemName} - {$timestamp}";
    }

    /**
     * Add anti-spam headers to email message
     */
    public static function addAntiSpamHeaders($message, $priority = 'normal')
    {
        // Add professional headers
        $message->getHeaders()
            ->addTextHeader('X-Mailer', 'TKDS Media Contact System')
            ->addTextHeader('X-Auto-Response-Suppress', 'All')
            ->addTextHeader('List-Unsubscribe', '<mailto:unsubscribe@tkds.email>')
            ->addTextHeader('X-Entity', 'TKDS Media')
            ->addTextHeader('Organization', 'TKDS Media');
            
        // Add priority headers if high priority
        if ($priority === 'high') {
            $message->getHeaders()
                ->addTextHeader('X-Priority', '1')
                ->addTextHeader('Importance', 'High');
        }
        
        // Add authentication headers
        $message->getHeaders()
            ->addTextHeader('X-Originating-IP', request()->ip())
            ->addTextHeader('X-Source', 'Contact Form');
    }

    /**
     * Log email sending attempts
     */
    public static function logEmailSending($recipient, $subject, $status = 'sent')
    {
        Log::info('Email sending logged', [
            'recipient' => $recipient,
            'subject' => $subject,
            'status' => $status,
            'timestamp' => now()->toISOString(),
            'server_ip' => request()->server('SERVER_ADDR'),
            'user_agent' => request()->userAgent()
        ]);
    }

    /**
     * Validate email configuration
     */
    public static function validateEmailConfig()
    {
        $requiredConfigs = [
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME'),
            'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
        ];
        
        $missingConfigs = [];
        foreach ($requiredConfigs as $key => $value) {
            if (empty($value)) {
                $missingConfigs[] = $key;
            }
        }
        
        if (!empty($missingConfigs)) {
            Log::error('Missing email configuration', [
                'missing_configs' => $missingConfigs
            ]);
            return false;
        }
        
        return true;
    }
}