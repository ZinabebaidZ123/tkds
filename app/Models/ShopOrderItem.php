<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_sku',
        'product_type',
        'quantity',
        'price',
        'total'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }

    // Methods
    public function isPhysical(): bool
    {
        return $this->product_type === 'physical';
    }

    public function isSoftware(): bool
    {
        return $this->product_type === 'software';
    }

    public function getFormattedPrice(): string
    {
        $currency = $this->order->currency ?? 'USD';
        $symbol = match($currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $currency . ' '
        };

        return $symbol . number_format($this->price, 2);
    }

    public function getFormattedTotal(): string
    {
        $currency = $this->order->currency ?? 'USD';
        $symbol = match($currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $currency . ' '
        };

        return $symbol . number_format($this->total, 2);
    }
}