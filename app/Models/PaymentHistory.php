<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;

    protected $table = 'payment_history';

    protected $fillable = [
        'user_id',
        'subscription_id',
        'stripe_payment_intent_id',
        'stripe_invoice_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'description',
        'receipt_url',
        'invoice_pdf',
        'refund_amount',
        'refunded_at',
        'failure_reason',
        'metadata',
        'processed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'refunded_at' => 'datetime',
        'processed_at' => 'datetime',
        'metadata' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class, 'subscription_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSucceeded($query)
    {
        return $query->where('status', 'succeeded');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    public function scopeCanceled($query)
    {
        return $query->where('status', 'canceled');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('processed_at', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ]);
    }

    public function scopeThisYear($query)
    {
        return $query->whereBetween('processed_at', [
            now()->startOfYear(),
            now()->endOfYear()
        ]);
    }

    public function scopeLastDays($query, $days = 30)
    {
        return $query->where('processed_at', '>=', now()->subDays($days));
    }

    // Methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isSucceeded(): bool
    {
        return $this->status === 'succeeded';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    public function isCanceled(): bool
    {
        return $this->status === 'canceled';
    }

    public function getFormattedAmount(): string
    {
        $symbol = match ($this->currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $this->currency . ' '
        };

        return $symbol . number_format($this->amount, 2);
    }

    public function getFormattedRefundAmount(): string
    {
        if (!$this->refund_amount) {
            return 'No refund';
        }

        $symbol = match ($this->currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $this->currency . ' '
        };

        return $symbol . number_format($this->refund_amount, 2);
    }

    public function getStatusBadge(): array
    {
        return match ($this->status) {
            'succeeded' => [
                'text' => 'Succeeded',
                'class' => 'bg-green-100 text-green-800',
                'icon' => 'fas fa-check-circle'
            ],
            'pending' => [
                'text' => 'Pending',
                'class' => 'bg-yellow-100 text-yellow-800',
                'icon' => 'fas fa-clock'
            ],
            'failed' => [
                'text' => 'Failed',
                'class' => 'bg-red-100 text-red-800',
                'icon' => 'fas fa-times-circle'
            ],
            'refunded' => [
                'text' => 'Refunded',
                'class' => 'bg-blue-100 text-blue-800',
                'icon' => 'fas fa-undo'
            ],
            'canceled' => [
                'text' => 'Canceled',
                'class' => 'bg-gray-100 text-gray-800',
                'icon' => 'fas fa-ban'
            ],
            default => [
                'text' => ucfirst($this->status),
                'class' => 'bg-gray-100 text-gray-800',
                'icon' => 'fas fa-question-circle'
            ]
        };
    }

    public function getPaymentMethodIcon(): string
    {
        return match ($this->payment_method) {
            'card', 'visa', 'mastercard', 'amex' => 'fas fa-credit-card',
            'paypal' => 'fab fa-paypal',
            'apple_pay' => 'fab fa-apple-pay',
            'google_pay' => 'fab fa-google-pay',
            'bank_transfer', 'ach' => 'fas fa-university',
            default => 'fas fa-money-bill'
        };
    }

    public function canRefund(): bool
    {
        return $this->isSucceeded() && !$this->refund_amount;
    }

    public function getNetAmount(): float
    {
        return $this->amount - ($this->refund_amount ?? 0);
    }

    public function getFormattedNetAmount(): string
    {
        $symbol = match ($this->currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $this->currency . ' '
        };

        return $symbol . number_format($this->getNetAmount(), 2);
    }

    // Static methods
    public static function findByStripeId(string $stripePaymentIntentId): ?self
    {
        return self::where('stripe_payment_intent_id', $stripePaymentIntentId)->first();
    }

    public static function getTotalRevenue(): float
    {
        return self::succeeded()->sum('amount');
    }

    public static function getMonthlyRevenue(): float
    {
        return self::succeeded()->thisMonth()->sum('amount');
    }

    public static function getYearlyRevenue(): float
    {
        return self::succeeded()->thisYear()->sum('amount');
    }

    public static function getFailureRate(): float
    {
        $total = self::whereIn('status', ['succeeded', 'failed'])->count();
        $failed = self::failed()->count();
        
        return $total > 0 ? ($failed / $total) * 100 : 0;
    }

    public static function getAverageTransactionAmount(): float
    {
        return self::succeeded()->avg('amount') ?? 0;
    }
}