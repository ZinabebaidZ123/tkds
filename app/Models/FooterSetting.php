<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    protected $table = 'footer_settings';

    protected $fillable = [
        'newsletter_enabled',
        'newsletter_title',
        'newsletter_subtitle',
        'newsletter_placeholder',
        'newsletter_button_text',
        'newsletter_privacy_text',
        'company_name',
        'company_tagline',
        'company_description',
        'contact_email',
        'contact_phone',
        'support_hours',
        'social_twitter',
        'social_linkedin',
        'social_youtube',
        'social_instagram',
        'social_facebook',
        'social_tiktok',
        'show_services_section',
        'show_company_section',
        'show_legal_section',
        'show_social_media',
        'show_trust_badges',
        'copyright_text',
        'footer_subtitle',
        'ssl_secured_text',
        'iso_certified_text',
        'global_cdn_text',
        'back_to_top_text',
        'status'
    ];

    protected $casts = [
        'newsletter_enabled' => 'boolean',
        'show_services_section' => 'boolean',
        'show_company_section' => 'boolean',
        'show_legal_section' => 'boolean',
        'show_social_media' => 'boolean',
        'show_trust_badges' => 'boolean',
    ];

    // Get the single instance
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            $settings = self::create([]);
        }
        
        return $settings;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getSocialLinks(): array
    {
        $links = [];
        
        if ($this->social_twitter) {
            $links['twitter'] = [
                'url' => $this->social_twitter,
                'icon' => 'fab fa-twitter',
                'name' => 'Twitter',
                'color' => '#1DA1F2'
            ];
        }
        
        if ($this->social_linkedin) {
            $links['linkedin'] = [
                'url' => $this->social_linkedin,
                'icon' => 'fab fa-linkedin',
                'name' => 'LinkedIn',
                'color' => '#0077B5'
            ];
        }
        
        if ($this->social_youtube) {
            $links['youtube'] = [
                'url' => $this->social_youtube,
                'icon' => 'fab fa-youtube',
                'name' => 'YouTube',
                'color' => '#FF0000'
            ];
        }
        
        if ($this->social_instagram) {
            $links['instagram'] = [
                'url' => $this->social_instagram,
                'icon' => 'fab fa-instagram',
                'name' => 'Instagram',
                'color' => '#E4405F'
            ];
        }
        
        if ($this->social_facebook) {
            $links['facebook'] = [
                'url' => $this->social_facebook,
                'icon' => 'fab fa-facebook',
                'name' => 'Facebook',
                'color' => '#1877F2'
            ];
        }
             if ($this->social_tiktok) {
            $links['فiktok'] = [
                'url' => $this->social_tiktok,
                'icon' => 'fab fa-tiktok',
                'name' => 'Tiktok',
                'color' => '#EE1D52'
            ];
        }
        
        return $links;
    }
}