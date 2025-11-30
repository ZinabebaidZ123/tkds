<?php

// App/Models/Occasion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Occasion extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'discount_percentage',
        'discount_text',
        'discount_starts_at',
        'discount_ends_at',
        'meta_title',
        'meta_description',
        'featured_image',
        'status',
        'is_featured',
        'sort_order'
    ];

    protected $casts = [
        'discount_percentage' => 'decimal:2',
        'discount_starts_at' => 'datetime',
        'discount_ends_at' => 'datetime',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function sections(): HasMany
    {
        return $this->hasMany(OccasionSection::class)->orderBy('sort_order');
    }

    public function packageDiscounts(): HasMany
    {
        return $this->hasMany(OccasionPackageDiscount::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return route('occasions.show', $this->slug);
    }

    public function getIsActiveDiscountAttribute(): bool
    {
        if (!$this->discount_starts_at || !$this->discount_ends_at) {
            return false;
        }

        $now = now();
        return $now >= $this->discount_starts_at && $now <= $this->discount_ends_at;
    }

    public function getDiscountTimeRemainingAttribute(): array
    {
        if (!$this->discount_ends_at) {
            return ['expired' => true];
        }

        $now = now();
        $endTime = $this->discount_ends_at;

        if ($now >= $endTime) {
            return ['expired' => true];
        }

        $diff = $endTime->diff($now);

        return [
            'expired' => false,
            'days' => $diff->d,
            'hours' => $diff->h,
            'minutes' => $diff->i,
            'seconds' => $diff->s,
            'total_seconds' => $endTime->timestamp - $now->timestamp
        ];
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getEnabledSections()
    {
        return $this->sections()->where('is_enabled', true)->orderBy('sort_order')->get();
    }

    public function getSectionByType(string $type): ?OccasionSection
    {
        return $this->sections()->where('section_type', $type)->where('is_enabled', true)->first();
    }

    public function getDiscountedPricingPlans()
    {
        return $this->packageDiscounts()
            ->with('pricingPlan')
            ->where('is_enabled', true)
            ->get()
            ->map(function ($discount) {
                $plan = $discount->pricingPlan;
                if (!$plan) return null;

                $monthlyPrice = $plan->price_monthly;
                $yearlyPrice = $plan->price_yearly;

                if ($discount->monthly_discount && $monthlyPrice) {
                    $monthlyPrice = $discount->discount_type === 'percentage'
                        ? $monthlyPrice * (1 - $discount->monthly_discount / 100)
                        : $monthlyPrice - $discount->monthly_discount;
                }

                if ($discount->yearly_discount && $yearlyPrice) {
                    $yearlyPrice = $discount->discount_type === 'percentage'
                        ? $yearlyPrice * (1 - $discount->yearly_discount / 100)
                        : $yearlyPrice - $discount->yearly_discount;
                }

                return [
                    'plan' => $plan,
                    'original_monthly_price' => $plan->price_monthly,
                    'original_yearly_price' => $plan->price_yearly,
                    'discounted_monthly_price' => max(0, $monthlyPrice),
                    'discounted_yearly_price' => max(0, $yearlyPrice),
                    'monthly_discount' => $discount->monthly_discount,
                    'yearly_discount' => $discount->yearly_discount,
                    'discount_type' => $discount->discount_type,
                    'headline' => $discount->discount_headline
                ];
            })
            ->filter();
    }
}
