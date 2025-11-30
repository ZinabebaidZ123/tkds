<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'payment_status',
        'payment_method',
        'stripe_payment_intent_id',
        'stripe_session_id',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'billing_address',
        'shipping_address',
        'notes',
        'shipped_at',
        'delivered_at'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime'
    ];

    // Order Status Constants
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';

    // Payment Status Constants
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_FAILED = 'failed';
    const PAYMENT_REFUNDED = 'refunded';
    const PAYMENT_PARTIALLY_REFUNDED = 'partially_refunded';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(ShopOrderItem::class, 'order_id');
    }

    public function downloads()
    {
        return $this->hasMany(ShopDownload::class, 'order_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    public function scopeCompleted($query)
    {
        return $query->whereIn('status', [self::STATUS_DELIVERED, self::STATUS_SHIPPED]);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_PAID);
    }

    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_PENDING);
    }

    // Methods
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    public function isShipped(): bool
    {
        return $this->status === self::STATUS_SHIPPED;
    }

    public function isDelivered(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isRefunded(): bool
    {
        return $this->status === self::STATUS_REFUNDED;
    }

    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function isUnpaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PENDING;
    }

    public function hasDigitalProducts(): bool
    {
        return $this->items()->where('product_type', 'software')->exists();
    }

    public function hasPhysicalProducts(): bool
    {
        return $this->items()->where('product_type', 'physical')->exists();
    }

    public function getFormattedTotal(): string
    {
        $symbol = match($this->currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $this->currency . ' '
        };

        return $symbol . number_format($this->total_amount, 2);
    }

    public function getStatusBadge(): array
    {
        return match($this->status) {
            self::STATUS_PENDING => [
                'text' => 'Pending',
                'class' => 'bg-yellow-500/20 text-yellow-400',
                'icon' => 'fas fa-clock'
            ],
            self::STATUS_PROCESSING => [
                'text' => 'Processing',
                'class' => 'bg-blue-500/20 text-blue-400',
                'icon' => 'fas fa-cog fa-spin'
            ],
            self::STATUS_SHIPPED => [
                'text' => 'Shipped',
                'class' => 'bg-purple-500/20 text-purple-400',
                'icon' => 'fas fa-shipping-fast'
            ],
            self::STATUS_DELIVERED => [
                'text' => 'Delivered',
                'class' => 'bg-green-500/20 text-green-400',
                'icon' => 'fas fa-check-circle'
            ],
            self::STATUS_CANCELLED => [
                'text' => 'Cancelled',
                'class' => 'bg-red-500/20 text-red-400',
                'icon' => 'fas fa-times-circle'
            ],
            self::STATUS_REFUNDED => [
                'text' => 'Refunded',
                'class' => 'bg-gray-500/20 text-gray-400',
                'icon' => 'fas fa-undo'
            ],
            default => [
                'text' => 'Unknown',
                'class' => 'bg-gray-500/20 text-gray-400',
                'icon' => 'fas fa-question'
            ]
        };
    }

    public function getPaymentStatusBadge(): array
    {
        return match($this->payment_status) {
            self::PAYMENT_PAID => [
                'text' => 'Paid',
                'class' => 'bg-green-500/20 text-green-400',
                'icon' => 'fas fa-check-circle'
            ],
            self::PAYMENT_PENDING => [
                'text' => 'Pending',
                'class' => 'bg-yellow-500/20 text-yellow-400',
                'icon' => 'fas fa-clock'
            ],
            self::PAYMENT_FAILED => [
                'text' => 'Failed',
                'class' => 'bg-red-500/20 text-red-400',
                'icon' => 'fas fa-times-circle'
            ],
            self::PAYMENT_REFUNDED => [
                'text' => 'Refunded',
                'class' => 'bg-gray-500/20 text-gray-400',
                'icon' => 'fas fa-undo'
            ],
            self::PAYMENT_PARTIALLY_REFUNDED => [
                'text' => 'Partially Refunded',
                'class' => 'bg-orange-500/20 text-orange-400',
                'icon' => 'fas fa-undo'
            ],
            default => [
                'text' => 'Unknown',
                'class' => 'bg-gray-500/20 text-gray-400',
                'icon' => 'fas fa-question'
            ]
        };
    }

    public function canCancel(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PROCESSING]);
    }

    public function canRefund(): bool
    {
        return $this->isPaid() && !$this->isRefunded();
    }

    public function markAsPaid(): void
    {
        $this->update([
            'payment_status' => self::PAYMENT_PAID,
            'status' => self::STATUS_PROCESSING
        ]);

        // Create downloads for software products
        $this->createDownloads();
    }

    public function createDownloads(): void
    {
        foreach ($this->items()->where('product_type', 'software')->get() as $item) {
            $product = ShopProduct::find($item->product_id);
            
            if ($product && $product->hasDownloadableFiles()) {
                foreach ($product->getDownloadableFiles() as $file) {
                    ShopDownload::create([
                        'user_id' => $this->user_id,
                        'order_id' => $this->id,
                        'product_id' => $product->id,
                        'file_name' => $file['name'] ?? 'Download',
                        'file_path' => $file['path'] ?? '',
                        'file_size' => $file['size'] ?? null,
                        'download_token' => \Str::random(40),
                        'downloads_remaining' => $product->download_limit,
                        'expires_at' => $product->download_expiry_days > 0 
                            ? now()->addDays($product->download_expiry_days) 
                            : null
                    ]);
                }
            }
        }
    }

    // Static Methods
    public static function generateOrderNumber(): string
    {
        do {
            $number = 'TK' . date('Ymd') . '-' . strtoupper(\Str::random(6));
        } while (self::where('order_number', $number)->exists());

        return $number;
    }

    public static function findByStripeSessionId(string $sessionId): ?self
    {
        return self::where('stripe_session_id', $sessionId)->first();
    }

    public static function findByStripePaymentIntentId(string $paymentIntentId): ?self
    {
        return self::where('stripe_payment_intent_id', $paymentIntentId)->first();
    }
}