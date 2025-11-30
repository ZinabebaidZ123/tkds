<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $table = 'contact_settings';

    protected $fillable = [
        'hero_badge_text',
        'hero_title',
        'hero_subtitle',
        'form_title',
        'office_address',
        'office_phone',
        'office_email',
        'support_email',
        'sales_email',
        'monday_friday_hours',
        'saturday_hours',
        'sunday_hours',
        'emergency_support',
        'emergency_text',
        'social_twitter',
        'social_linkedin',
        'social_youtube',
        'social_instagram',
        'social_facebook',
        'google_maps_embed',
        'auto_reply_enabled',
        'auto_reply_subject',
        'auto_reply_message',
        'notification_emails',
        'meta_title',
        'meta_description',
        'status'
    ];

    protected $casts = [
        'emergency_support' => 'boolean',
        'auto_reply_enabled' => 'boolean',
    ];

    // Get the single instance (there should only be one record)
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            // Create default settings if none exist
            $settings = self::create([
                'hero_badge_text' => 'Contact Us',
                'hero_title' => 'Let\'s Start Your Broadcasting Journey',
                'hero_subtitle' => 'Ready to transform your content strategy? Our experts are here to help you every step of the way',
                'form_title' => 'Send us a Message',
                'office_phone' => '+1 (555) 123-4567',
                'office_email' => 'info@tkdsmedia.com',
                'support_email' => 'support@tkdsmedia.com',
                'sales_email' => 'sales@tkdsmedia.com',
                'monday_friday_hours' => '9:00 AM - 6:00 PM',
                'saturday_hours' => '10:00 AM - 4:00 PM',
                'sunday_hours' => 'Emergency Only',
                'emergency_support' => true,
                'emergency_text' => '24/7 Emergency Support Available',
                'auto_reply_enabled' => true,
                'auto_reply_subject' => 'Thank you for contacting TKDS Media',
                'auto_reply_message' => 'Thank you for reaching out to us. We have received your message and will get back to you within 24 hours.',
                'notification_emails' => 'admin@tkdsmedia.com',
                'meta_title' => 'Contact Us - TKDS Media',
                'meta_description' => 'Get in touch with TKDS Media for professional broadcasting solutions. Contact our experts today.',
                'status' => 'active'
            ]);
        }
        
        return $settings;
    }

    // Check if settings are active
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getNotificationEmailsArray(): array
    {
        if (!$this->notification_emails) {
            return [];
        }
        
        return array_map('trim', explode(',', $this->notification_emails));
    }

    public function getSocialLinks(): array
    {
        $links = [];
        
        if ($this->social_twitter) {
            $links['twitter'] = [
                'url' => $this->social_twitter,
                'icon' => 'fab fa-twitter',
                'name' => 'Twitter'
            ];
        }
        
        if ($this->social_linkedin) {
            $links['linkedin'] = [
                'url' => $this->social_linkedin,
                'icon' => 'fab fa-linkedin',
                'name' => 'LinkedIn'
            ];
        }
        
        if ($this->social_youtube) {
            $links['youtube'] = [
                'url' => $this->social_youtube,
                'icon' => 'fab fa-youtube',
                'name' => 'YouTube'
            ];
        }
        
        if ($this->social_instagram) {
            $links['instagram'] = [
                'url' => $this->social_instagram,
                'icon' => 'fab fa-instagram',
                'name' => 'Instagram'
            ];
        }
        
        if ($this->social_facebook) {
            $links['facebook'] = [
                'url' => $this->social_facebook,
                'icon' => 'fab fa-facebook',
                'name' => 'Facebook'
            ];
        }
        
        return $links;
    }
}