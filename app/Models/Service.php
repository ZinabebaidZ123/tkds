<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon',
        'image',
        'color_from',
        'color_to',
        'border_color',
        'route_name',
        'external_url',
        'features',
        'meta_title',
        'meta_description',
        'contact_email',
        'status',
        'is_featured',
        'sort_order',
        'hero_title',
        'hero_subtitle',
        'hero_description',
        'hero_image',
        'hero_badge_text',
        'hero_badge_color',
        'page_content',
        'key_features',
        'benefits',
        'use_cases',
        'platforms',
        'cta_title',
        'cta_description',
        'cta_button_text',
        'cta_button_link',
        'related_services',
        'section_title_part1',
        'section_title_part2',
        'section_subtitle'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'features' => 'array',
        'key_features' => 'array',
        'benefits' => 'array',
        'use_cases' => 'array',
        'platforms' => 'array',
        'related_services' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeWithContactEmail($query)
    {
        return $query->whereNotNull('contact_email')->where('contact_email', '!=', '');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isFeatured(): bool
    {
        return $this->is_featured;
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

        return asset('images/service-placeholder.png');
    }

    public function getHeroImageUrl(): string
    {
        if ($this->hero_image && filter_var($this->hero_image, FILTER_VALIDATE_URL)) {
            return $this->hero_image;
        }
        
        if ($this->hero_image) {
            return asset('storage/' . $this->hero_image);
        }

        if ($this->image && filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        $defaultImages = [
            'streaming' => 'images/streaming-illustration.svg',
            'ott-apps' => 'images/ott-apps-hero.svg',
            'graphic-design' => 'images/graphic-design-hero.svg',
            'cloud-servers' => 'images/Cloud-hosting-amico.svg',
            'radio-podcast' => 'images/Podcast-cuate.svg',
            'ott-platform' => 'images/ott-plateform.svg',
            'streaming-service' => 'images/Server-bro.svg',
            'sports-production' => 'images/Fans-bro.svg'
        ];

        return asset($defaultImages[$this->slug] ?? 'images/service-hero-default.jpg');
    }

    public function getFeatures(): array
    {
        if (is_string($this->features)) {
            return json_decode($this->features, true) ?: [];
        }
        return is_array($this->features) ? $this->features : [];
    }

    public function getKeyFeatures(): array
    {
        if (is_string($this->key_features)) {
            return json_decode($this->key_features, true) ?: [];
        }
        return is_array($this->key_features) ? $this->key_features : [];
    }

    public function getBenefits(): array
    {
        if (is_string($this->benefits)) {
            return json_decode($this->benefits, true) ?: [];
        }
        return is_array($this->benefits) ? $this->benefits : [];
    }

    public function getUseCases(): array
    {
        if (is_string($this->use_cases)) {
            return json_decode($this->use_cases, true) ?: [];
        }
        return is_array($this->use_cases) ? $this->use_cases : [];
    }

    public function getPlatforms(): array
    {
        if (is_string($this->platforms)) {
            return json_decode($this->platforms, true) ?: [];
        }
        return is_array($this->platforms) ? $this->platforms : [];
    }

    public function getRelatedServices(): array
    {
        if (is_string($this->related_services)) {
            return json_decode($this->related_services, true) ?: [];
        }
        return is_array($this->related_services) ? $this->related_services : [];
    }

    public function getUrl(): string
    {
        if ($this->external_url) {
            return $this->external_url;
        }
        
        if ($this->route_name && \Route::has($this->route_name)) {
            return route($this->route_name);
        }
        
        return route('services.show', $this->slug);
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

    public function getHeroTitle(): string
    {
        return $this->hero_title ?? $this->title;
    }

    public function getHeroDescription(): string
    {
        return $this->hero_description ?? $this->description;
    }

    public function getHeroBadgeText(): string
    {
        return $this->hero_badge_text ?? $this->title;
    }

    public function getCtaTitle(): string
    {
        return $this->cta_title ?? 'Ready to Get Started?';
    }

    public function getCtaDescription(): string
    {
        return $this->cta_description ?? 'Transform your business with our professional ' . strtolower($this->title) . ' solutions.';
    }

    public function getCtaButtonText(): string
    {
        return $this->cta_button_text ?? 'Get Started Today';
    }

    /**
     * Get the section title with HTML formatting
     */
    public function getSectionTitle(): string
    {
        $part1 = $this->section_title_part1 ?? 'Achieve Your';
        $part2 = $this->section_title_part2 ?? 'Goals';
        
        return $part1 . ' <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">' . $part2 . '</span>';
    }

    /**
     * Get the section subtitle
     */
    public function getSectionSubtitle(): string
    {
        return $this->section_subtitle ?? 'Our Services';
    }

    /**
     * Get section title data for admin management
     */
    public static function getSectionTitleData(): array
    {
        $firstService = self::active()->ordered()->first();
        
        return [
            'title_part1' => $firstService->section_title_part1 ?? 'Achieve Your',
            'title_part2' => $firstService->section_title_part2 ?? 'Goals',
            'subtitle' => $firstService->section_subtitle ?? 'Our Services'
        ];
    }
}