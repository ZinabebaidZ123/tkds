<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'rating',
        'title',
        'comment',
        'status',
        'helpful_count'
    ];

    protected $casts = [
        'rating' => 'integer',
        'helpful_count' => 'integer'
    ];

    // Status Constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // Relationships
    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    // Methods
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function getStarRating(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="fas fa-star text-yellow-400"></i>';
            } else {
                $stars .= '<i class="fas fa-star text-gray-300"></i>';
            }
        }
        return $stars;
    }

    public function getStatusBadge(): array
    {
        return match($this->status) {
            self::STATUS_APPROVED => [
                'text' => 'Approved',
                'class' => 'bg-green-500/20 text-green-400',
                'icon' => 'fas fa-check'
            ],
            self::STATUS_PENDING => [
                'text' => 'Pending',
                'class' => 'bg-yellow-500/20 text-yellow-400',
                'icon' => 'fas fa-clock'
            ],
            self::STATUS_REJECTED => [
                'text' => 'Rejected',
                'class' => 'bg-red-500/20 text-red-400',
                'icon' => 'fas fa-times'
            ],
            default => [
                'text' => 'Unknown',
                'class' => 'bg-gray-500/20 text-gray-400',
                'icon' => 'fas fa-question'
            ]
        };
    }
}