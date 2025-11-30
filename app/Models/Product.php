<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'short_description',
        'icon',
        'image',
        'hero_image',
        'color_from',
        'color_to',
        'border_color',
        'category',
        'price',
        'currency',
        'pricing_model',
        'route_name',
        'external_url',
        'features',
        'specifications',
        'gallery',
        'demo_url',
        'video_url',
        'documentation_url',
        'github_url',
        'is_featured',
        'show_in_navbar',
        'show_in_homepage',
        'show_pricing',
        'status',
        'sort_order',
        'page_content',
        'hero_title',
        'hero_subtitle',
        'hero_description',
        'hero_badge_text',
        'hero_badge_color',
        'key_features',
        'benefits',
        'use_cases',
        'tech_stack',
        'system_requirements',
        'cta_title',
        'cta_description',
        'cta_button_text',
        'cta_button_link',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'title_part1',
        'title_part2',
        'subtitle_section',
        'contact_email'
    ];

    protected $casts = [
        'features' => 'array',
        'specifications' => 'array',
        'gallery' => 'array',
        'key_features' => 'array',
        'benefits' => 'array',
        'use_cases' => 'array',
        'tech_stack' => 'array',
        'system_requirements' => 'array',
        'is_featured' => 'boolean',
        'show_in_navbar' => 'boolean',
        'show_in_homepage' => 'boolean',
        'show_pricing' => 'boolean',
        'price' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    const CATEGORIES = [
        'saas' => 'SaaS Platform',
        'software' => 'Software',
        'hardware' => 'Hardware',
        'service' => 'Service'
    ];

    const PRICING_MODELS = [
        'free' => 'Free',
        'one_time' => 'One-time Purchase',
        'subscription' => 'Subscription',
        'quote' => 'Contact for Quote'
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_COMING_SOON = 'coming_soon';

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    public function scopeComingSoon($query)
    {
        return $query->where('status', self::STATUS_COMING_SOON);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeShowInNavbar($query)
    {
        return $query->where('show_in_navbar', true);
    }

    public function scopeShowInHomepage($query)
    {
        return $query->where('show_in_homepage', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeWithContactEmail($query)
    {
        return $query->whereNotNull('contact_email')->where('contact_email', '!=', '');
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    public function isComingSoon(): bool
    {
        return $this->status === self::STATUS_COMING_SOON;
    }

    public function isFeatured(): bool
    {
        return $this->is_featured;
    }

    public function showInNavbar(): bool
    {
        return $this->show_in_navbar;
    }

    public function showInHomepage(): bool
    {
        return $this->show_in_homepage;
    }

    public function hasContactEmail(): bool
    {
        return !empty($this->contact_email);
    }

    public function getContactEmail(): string
    {
        return $this->contact_email ?: config('mail.from.address', 'info@tkdsmedia.com');
    }

    public function getImageUrl(): string
    {
        if ($this->image && filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return asset('images/product-placeholder.png');
    }

    public function getHeroImageUrl(): string
    {
        if ($this->hero_image && filter_var($this->hero_image, FILTER_VALIDATE_URL)) {
            return $this->hero_image;
        }

        if ($this->hero_image) {
            return asset('storage/' . $this->hero_image);
        }

        return $this->getImageUrl();
    }

    public function getFeatures(): array
    {
        return $this->features ?: [];
    }

    public function getSpecifications(): array
    {
        return $this->specifications ?: [];
    }

    public function getGallery(): array
    {
        return $this->gallery ?: [];
    }

    public function getKeyFeatures(): array
    {
        return $this->key_features ?: [];
    }

    public function getBenefits(): array
    {
        return $this->benefits ?: [];
    }

    public function getUseCases(): array
    {
        return $this->use_cases ?: [];
    }

    public function getTechStack(): array
    {
        return $this->tech_stack ?: [];
    }

    public function getSystemRequirements(): array
    {
        return $this->system_requirements ?: [];
    }

    public function getUrl(): string
    {
        if ($this->external_url) {
            return $this->external_url;
        }

        if ($this->route_name && \Route::has($this->route_name)) {
            return route($this->route_name);
        }

        return route('products.show', $this->slug);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getGradientClass(): string
    {
        return "from-{$this->color_from} to-{$this->color_to}";
    }

    public function getBorderClass(): string
    {
        return "border-{$this->border_color}/50";
    }

    public function getHoverBorderClass(): string
    {
        return "hover:border-{$this->border_color}/50";
    }

    public function getButtonClass(): string
    {
        return "bg-{$this->color_from}/10 hover:bg-{$this->color_from} text-{$this->color_from} hover:text-white border border-{$this->color_from}/30 hover:border-{$this->color_from}";
    }

    public function getHeroBadgeColor(): string
    {
        return $this->hero_badge_color ?? $this->color_from ?? 'primary';
    }

    public function getCtaButtonLink(): string
    {
        return $this->cta_button_link ?? route('contact');
    }

    public function getSectionTitle(): string
    {
        $part1 = $this->title_part1 ?? 'Your Streaming Empire';
        $part2 = $this->title_part2 ?? 'Starts Here';
        
        return $part1 . ' <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">' . $part2 . '</span>';
    }

    public function getStatusBadge(): array
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => [
                'text' => 'Active',
                'class' => 'bg-green-100 text-green-800',
                'icon' => 'fas fa-check-circle'
            ],
            self::STATUS_INACTIVE => [
                'text' => 'Inactive',
                'class' => 'bg-red-100 text-red-800',
                'icon' => 'fas fa-times-circle'
            ],
            self::STATUS_COMING_SOON => [
                'text' => 'Coming Soon',
                'class' => 'bg-yellow-100 text-yellow-800',
                'icon' => 'fas fa-clock'
            ],
            default => [
                'text' => 'Unknown',
                'class' => 'bg-gray-100 text-gray-800',
                'icon' => 'fas fa-question-circle'
            ]
        };
    }

    public function getCategoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }

    public function getPricingModelLabel(): string
    {
        return self::PRICING_MODELS[$this->pricing_model] ?? ucfirst($this->pricing_model);
    }

    public function getFormattedPrice(): string
    {
        if (!$this->price) {
            return match ($this->pricing_model) {
                'free' => 'Free',
                'quote' => 'Contact for Quote',
                default => 'Price TBD'
            };
        }

        $currency = $this->currency ?: 'USD';
        $symbol = match ($currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $currency . ' '
        };

        $price = $symbol . number_format($this->price, 2);

        return match ($this->pricing_model) {
            'subscription' => $price . '/month',
            'one_time' => $price . ' (one-time)',
            default => $price
        };
    }

    public function getHeroTitle(): string
    {
        return $this->hero_title ?? $this->title;
    }

    public function getHeroSubtitle(): string
    {
        return $this->hero_subtitle ?? $this->subtitle ?? '';
    }

    public function getHeroDescription(): string
    {
        return $this->hero_description ?? $this->short_description ?? $this->description;
    }

    public function getHeroBadgeText(): string
    {
        return $this->hero_badge_text ?? $this->getCategoryLabel();
    }

    public function getCtaTitle(): string
    {
        return $this->cta_title ?? 'Ready to Get Started?';
    }

    public function getCtaDescription(): string
    {
        return $this->cta_description ?? 'Transform your business with our professional ' . strtolower($this->title) . ' solution.';
    }

    public function getCtaButtonText(): string
    {
        return $this->cta_button_text ?? 'Get Started Today';
    }

    public function getMetaTitle(): string
    {
        return $this->meta_title ?? $this->title . ' - TKDS Media';
    }

    public function getMetaDescription(): string
    {
        return $this->meta_description ?? $this->short_description ??
            substr(strip_tags($this->description), 0, 160);
    }

    public static function getNavbarProducts()
    {
        return self::active()
            ->showInNavbar()
            ->ordered()
            ->get();
    }

    public static function getHomepageProducts()
    {
        return self::active()
            ->showInHomepage()
            ->ordered()
            ->get();
    }

    public static function getFeaturedProducts()
    {
        return self::active()
            ->featured()
            ->ordered()
            ->get();
    }
}