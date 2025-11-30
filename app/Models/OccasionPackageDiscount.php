<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OccasionPackageDiscount extends Model
{
    protected $fillable = [
        'occasion_id',
        'pricing_plan_id',
        'discount_type',
        'monthly_discount',
        'yearly_discount',
        'discount_headline',
        'is_enabled'
    ];

    protected $casts = [
        'monthly_discount' => 'decimal:2',
        'yearly_discount' => 'decimal:2',
        'is_enabled' => 'boolean'
    ];

    // Relationships
    public function occasion(): BelongsTo
    {
        return $this->belongsTo(Occasion::class);
    }

    public function pricingPlan(): BelongsTo
    {
        return $this->belongsTo(PricingPlan::class);
    }
}
