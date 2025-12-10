<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price_monthly',
        'price_yearly',
        'setup_fee',
        'currency',
        'stripe_price_id_monthly',
        'stripe_price_id_yearly',
        'stripe_product_id',
        'features',
        'max_users',
        'max_projects',
        'storage_limit',
        'bandwidth_limit',
        'support_level',
        'trial_days',
        'icon',
        'color',
        'is_popular',
        'is_featured',
        'show_in_home',
        'show_in_pricing',
        'sort_order',
        'status',
        'meta_title',
        'meta_description',
        'title_part1',       
        'title_part2',       
        'subtitle'           
    ];

    protected $casts = [
        'features' => 'array',
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'setup_fee' => 'decimal:2', 
        'max_users' => 'integer',
        'max_projects' => 'integer',
        'trial_days' => 'integer',
        'sort_order' => 'integer',
        'is_popular' => 'boolean',
        'is_featured' => 'boolean',
        'show_in_home' => 'boolean',
        'show_in_pricing' => 'boolean',
    ];

//    : Section Title Methods
    public function getSectionTitle(): string
    {
        $part1 = $this->title_part1 ?? 'Choose Your';
        $part2 = $this->title_part2 ?? 'Perfect Plan';
        
        return $part1 . ' <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">' . $part2 . '</span>';
    }

    public function getSectionSubtitle(): string
    {
        return $this->subtitle ?? 'Flexible pricing designed to scale with your needs, from startup to enterprise';
    }

    // ✅ Static method to get first plan for section title management
    public static function getFirstPlan()
    {
        return self::active()->showInPricing()->ordered()->first();
    }

    // Relationships
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function activeSubscriptions()
    {
        return $this->hasMany(UserSubscription::class)->where('status', 'active');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeShowInHome($query)
    {
        return $query->where('show_in_home', true);
    }

    public function scopeShowInPricing($query)
    {
        return $query->where('show_in_pricing', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isPopular(): bool
    {
        return $this->is_popular;
    }

    public function isFeatured(): bool
    {
        return $this->is_featured;
    }

    public function showInHome(): bool
    {
        return $this->show_in_home;
    }

    public function showInPricing(): bool
    {
        return $this->show_in_pricing;
    }

    public function getFeatures(): array
    {
        return $this->features ?? [];
    }

    public function getFormattedPriceMonthly(): string
    {
        if (!$this->price_monthly) {
            return 'Free';
        }

        return $this->formatPrice($this->price_monthly) . '/month';
    }

    public function getFormattedPriceYearly(): string
    {
        if (!$this->price_yearly) {
            return 'Free';
        }

        return $this->formatPrice($this->price_yearly) . '/year';
    }

    public function getFormattedPrice(string $cycle = 'monthly'): string
    {
        $price = $cycle === 'yearly' ? $this->price_yearly : $this->price_monthly;
        
        if (!$price) {
            return 'Free';
        }

        return $this->formatPrice($price) . '/' . $cycle;
    }

    public function getFormattedSetupFee(): string
    {
        if (!$this->setup_fee || $this->setup_fee == 0) {
            return 'No Setup Fee';
        }

        return $this->formatPrice($this->setup_fee) . ' setup fee';
    }

    public function hasSetupFee(): bool
    {
        return $this->setup_fee && $this->setup_fee > 0;
    }

    private function formatPrice($price): string
    {
        $symbol = match ($this->currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $this->currency . ' '
        };

        $formattedPrice = $price == floor($price) ? number_format($price, 0) : number_format($price, 2);
        
        return $symbol . $formattedPrice;
    }

    public function getYearlySavings(): float
    {
        if (!$this->price_monthly || !$this->price_yearly) {
            return 0;
        }

        $monthlyTotal = $this->price_monthly * 12;
        return $monthlyTotal - $this->price_yearly;
    }

    public function getYearlySavingsPercentage(): int
    {
        if (!$this->price_monthly || !$this->price_yearly) {
            return 0;
        }

        $monthlyTotal = $this->price_monthly * 12;
        $savings = $monthlyTotal - $this->price_yearly;
        
        return round(($savings / $monthlyTotal) * 100);
    }

    public function getColorClass(): string
    {
        return match ($this->color) {
            'primary' => 'from-primary to-secondary',
            'secondary' => 'from-secondary to-accent',
            'accent' => 'from-accent to-primary',
            'blue' => 'from-blue-500 to-blue-600',
            'green' => 'from-green-500 to-green-600',
            'purple' => 'from-purple-500 to-purple-600',
            default => 'from-primary to-secondary'
        };
    }

    public function getBorderClass(): string
    {
        return match ($this->color) {
            'primary' => 'border-primary/50',
            'secondary' => 'border-secondary/50',
            'accent' => 'border-accent/50',
            'blue' => 'border-blue-500/50',
            'green' => 'border-green-500/50',
            'purple' => 'border-purple-500/50',
            default => 'border-primary/50'
        };
    }

    public function getPrice(string $cycle = 'monthly'): ?float
    {
        return $cycle === 'yearly' ? $this->price_yearly : $this->price_monthly;
    }

    public function getStripePriceId(string $cycle = 'monthly'): ?string
    {
        return $cycle === 'yearly' ? $this->stripe_price_id_yearly : $this->stripe_price_id_monthly;
    }

    public function hasStripeIntegration(): bool
    {
        return !empty($this->stripe_product_id) && 
               (!empty($this->stripe_price_id_monthly) || !empty($this->stripe_price_id_yearly));
    }

    public function canPurchase(): bool
    {
        return $this->isActive() && $this->showInPricing();
    }

    public function canProcessPayment(): bool
    {
        return $this->isActive() && $this->hasStripeIntegration();
    }

    public function canDisplay(): bool
    {
        return $this->isActive() && $this->showInPricing();
    }

    public function getSubscribersCount(): int
    {
        return $this->activeSubscriptions()->count();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getMetaTitle(): string
    {
        return $this->meta_title ?: $this->name . ' - TKDS Media Pricing';
    }

    public function getMetaDescription(): string
    {
        return $this->meta_description ?: $this->short_description ?: $this->description;
    }

    // Static methods for admin
    public static function getHomePlans()
    {
        return self::active()
            ->showInHome()
            ->ordered()
            ->get();
    }

    public static function getPricingPlans()
    {
        return self::active()
            ->showInPricing()
            ->ordered()
            ->get();
    }

    public static function getPopularPlans()
    {
        return self::active()
            ->popular()
            ->ordered()
            ->get();
    }

    public static function getFeaturedPlans()
    {
        return self::active()
            ->featured()
            ->ordered()
            ->get();
    }

    
}