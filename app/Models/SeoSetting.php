<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    use HasFactory;

    protected $table = 'seo_settings';

    protected $fillable = [
        'site_name',
        'site_tagline',
        'site_description',
        'site_keywords',
        'site_author',
        'site_logo',
        'favicon',
        'og_image',
        'twitter_username',
        'facebook_app_id',
        'google_analytics_id',
        'google_tag_manager_id',
        'facebook_pixel_id',
        'google_site_verification',
        'bing_site_verification',
        'yandex_site_verification',
        'robots_txt',
        'custom_head_code',
        'custom_body_code',
        'custom_footer_code',
        'schema_organization',
        'social_links',
        'contact_info',
        'business_hours',
        'address_info',
        'phone_numbers',
        'email_addresses',
        'languages',
        'default_language',
        'rtl_support',
        'theme_color',
        'background_color',
        'apple_touch_icon',
        'manifest_file',
        'sitemap_enabled',
        'sitemap_auto_generate',
        'breadcrumbs_enabled',
        'canonical_urls_enabled',
        'open_graph_enabled',
        'twitter_cards_enabled',
        'json_ld_enabled',
        'amp_enabled',
        'pwa_enabled',
        'status'
    ];

    protected $casts = [
        'schema_organization' => 'array',
        'social_links' => 'array',
        'contact_info' => 'array',
        'business_hours' => 'array',
        'address_info' => 'array',
        'phone_numbers' => 'array',
        'email_addresses' => 'array',
        'languages' => 'array',
        'rtl_support' => 'boolean',
        'sitemap_enabled' => 'boolean',
        'sitemap_auto_generate' => 'boolean',
        'breadcrumbs_enabled' => 'boolean',
        'canonical_urls_enabled' => 'boolean',
        'open_graph_enabled' => 'boolean',
        'twitter_cards_enabled' => 'boolean',
        'json_ld_enabled' => 'boolean',
        'amp_enabled' => 'boolean',
        'pwa_enabled' => 'boolean',
    ];

    // Get the single instance (there should only be one record)
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            // Create default settings if none exist
            $settings = self::create([
                'site_name' => 'TKDS Media',
                'site_tagline' => 'Your World, Live and Direct | Professional Broadcasting Solutions',
                'site_description' => 'TKDS Media offers premium streaming, production, and broadcasting solutions.',
                'site_keywords' => 'streaming, broadcasting, OTT platform, live streaming, video production',
                'site_author' => 'TKDS Media',
                'twitter_username' => '@tkdsmedia',
                'theme_color' => '#C53030',
                'background_color' => '#0a0a0a',
                'languages' => ['en'],
                'default_language' => 'en',
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

    // Get site logo URL
    public function getSiteLogoUrl(): string
    {
        if ($this->site_logo && filter_var($this->site_logo, FILTER_VALIDATE_URL)) {
            return $this->site_logo;
        }
        
        if ($this->site_logo) {
            return asset('storage/' . $this->site_logo);
        }

        return asset('images/logo.png');
    }

    // Get favicon URL
    public function getFaviconUrl(): string
    {
        if ($this->favicon && filter_var($this->favicon, FILTER_VALIDATE_URL)) {
            return $this->favicon;
        }
        
        if ($this->favicon) {
            return asset('storage/' . $this->favicon);
        }

        return asset('favicon.ico');
    }

    // Get OG image URL
    public function getOgImageUrl(): string
    {
        if ($this->og_image && filter_var($this->og_image, FILTER_VALIDATE_URL)) {
            return $this->og_image;
        }
        
        if ($this->og_image) {
            return asset('storage/' . $this->og_image);
        }

        return asset('images/tkds-og-image.jpg');
    }

    // Get Apple touch icon URL
    public function getAppleTouchIconUrl(): string
    {
        if ($this->apple_touch_icon && filter_var($this->apple_touch_icon, FILTER_VALIDATE_URL)) {
            return $this->apple_touch_icon;
        }
        
        if ($this->apple_touch_icon) {
            return asset('storage/' . $this->apple_touch_icon);
        }

        return asset('images/apple-touch-icon.png');
    }

    // Get social links array
    public function getSocialLinks(): array
    {
        return $this->social_links ?? [];
    }

    // Get contact info array
    public function getContactInfo(): array
    {
        return $this->contact_info ?? [];
    }

    // Get organization schema
    public function getOrganizationSchema(): array
    {
        $schema = $this->schema_organization ?? [];
        
        // Ensure required fields
        $schema['@context'] = 'https://schema.org';
        $schema['@type'] = 'Organization';
        $schema['name'] = $schema['name'] ?? $this->site_name;
        $schema['url'] = $schema['url'] ?? url('/');
        $schema['logo'] = $this->getSiteLogoUrl();
        
        return $schema;
    }

    // Generate robots.txt content
    public function generateRobotsTxt(): string
    {
        if ($this->robots_txt) {
            return $this->robots_txt;
        }

        return "User-agent: *\nAllow: /\nDisallow: /admin/\n\nSitemap: " . url('/sitemap.xml');
    }

    // Get all verification codes
    public function getVerificationCodes(): array
    {
        return [
            'google' => $this->google_site_verification,
            'bing' => $this->bing_site_verification,
            'yandex' => $this->yandex_site_verification,
        ];
    }

    // Get tracking codes
    public function getTrackingCodes(): array
    {
        return [
            'google_analytics' => $this->google_analytics_id,
            'google_tag_manager' => $this->google_tag_manager_id,
            'facebook_pixel' => $this->facebook_pixel_id,
        ];
    }
}