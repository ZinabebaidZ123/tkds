<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSeoSetting extends Model
{
    use HasFactory;

    protected $table = 'page_seo_settings';

    protected $fillable = [
        'page_route',
        'page_title',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'twitter_card_type',
        'canonical_url',
        'robots',
        'custom_head_code',
        'custom_body_code',
        'breadcrumbs',
        'schema_data',
        'priority',
        'change_frequency',
        'status'
    ];

    protected $casts = [
        'breadcrumbs' => 'array',
        'schema_data' => 'array',
        'priority' => 'decimal:1',
    ];

    // Get page SEO settings by route
    public static function getByRoute(string $route)
    {
        return self::where('page_route', $route)->where('status', 'active')->first();
    }

    // Get all active page settings
    public static function getAllActive()
    {
        return self::where('status', 'active')->get();
    }

    // Check if page is active
    public function isActive(): bool
    {
        return $this->status === 'active';
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

        // Fallback to global OG image
        $globalSettings = SeoSetting::getSettings();
        return $globalSettings->getOgImageUrl();
    }

    // Get Twitter image URL
    public function getTwitterImageUrl(): string
    {
        if ($this->twitter_image && filter_var($this->twitter_image, FILTER_VALIDATE_URL)) {
            return $this->twitter_image;
        }
        
        if ($this->twitter_image) {
            return asset('storage/' . $this->twitter_image);
        }

        // Fallback to OG image
        return $this->getOgImageUrl();
    }

    // Get canonical URL
    public function getCanonicalUrl(): string
    {
        if ($this->canonical_url) {
            return $this->canonical_url;
        }

        // Generate canonical URL based on route
        switch ($this->page_route) {
            case 'home':
                return url('/');
            case 'about':
                return route('about');
            case 'services':
                return route('services');
            case 'contact':
                return route('contact');
            case 'blog':
                return route('blog.index');
            case 'pricing':
                return route('pricing');
            default:
                return url('/' . $this->page_route);
        }
    }

    // Get breadcrumbs array
    public function getBreadcrumbs(): array
    {
        if ($this->breadcrumbs) {
            return $this->breadcrumbs;
        }

        // Generate default breadcrumbs
        return $this->generateDefaultBreadcrumbs();
    }

    // Generate default breadcrumbs
    private function generateDefaultBreadcrumbs(): array
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')]
        ];

        switch ($this->page_route) {
            case 'about':
                $breadcrumbs[] = ['name' => 'About Us', 'url' => route('about')];
                break;
            case 'services':
                $breadcrumbs[] = ['name' => 'Services', 'url' => route('services')];
                break;
            case 'contact':
                $breadcrumbs[] = ['name' => 'Contact', 'url' => route('contact')];
                break;
            case 'blog':
                $breadcrumbs[] = ['name' => 'Blog', 'url' => route('blog.index')];
                break;
            case 'pricing':
                $breadcrumbs[] = ['name' => 'Pricing', 'url' => route('pricing')];
                break;
        }

        return $breadcrumbs;
    }

    // Generate JSON-LD schema
    public function generateJsonLD(): array
    {
        $schema = $this->schema_data ?? [];
        
        // Add breadcrumbs schema if enabled
        $globalSettings = SeoSetting::getSettings();
        if ($globalSettings->breadcrumbs_enabled) {
            $breadcrumbs = $this->getBreadcrumbs();
            if (count($breadcrumbs) > 1) {
                $schema['breadcrumbs'] = [
                    '@context' => 'https://schema.org',
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => []
                ];

                foreach ($breadcrumbs as $index => $breadcrumb) {
                    $schema['breadcrumbs']['itemListElement'][] = [
                        '@type' => 'ListItem',
                        'position' => $index + 1,
                        'name' => $breadcrumb['name'],
                        'item' => $breadcrumb['url']
                    ];
                }
            }
        }

        return $schema;
    }

    // Get robots meta content
    public function getRobotsContent(): string
    {
        return $this->robots ?: 'index,follow';
    }

    // Get sitemap priority
    public function getSitemapPriority(): float
    {
        return (float) ($this->priority ?: 0.8);
    }

    // Get change frequency
    public function getChangeFrequency(): string
    {
        return $this->change_frequency ?: 'weekly';
    }
}