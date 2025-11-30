<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'currency',
        'sku',
        'stock_quantity',
        'manage_stock',
        'in_stock',
        'type',
        'category_id',
        'featured_image',
        'gallery',
        'downloadable_files',
        'download_limit',
        'download_expiry_days',
        'is_featured',
        'is_popular',
        'status',
        'sort_order',
        'meta_title',
        'meta_description',
        'specifications',
        'features',
        'tags',
        'weight',
        'dimensions',
        'shipping_required',
        'views_count',
        'sales_count'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'manage_stock' => 'boolean',
        'in_stock' => 'boolean',
        'gallery' => 'array',
        'downloadable_files' => 'array',
        'download_limit' => 'integer',
        'download_expiry_days' => 'integer',
        'is_featured' => 'boolean',
        'is_popular' => 'boolean',
        'sort_order' => 'integer',
        'specifications' => 'array',
        'features' => 'array',
        'tags' => 'array',
        'dimensions' => 'array',
        'shipping_required' => 'boolean',
        'views_count' => 'integer',
        'sales_count' => 'integer'
    ];

    // Product Types - تركيز على Physical و Software فقط
    const TYPE_PHYSICAL = 'physical';
    const TYPE_SOFTWARE = 'software';

    const TYPES = [
        self::TYPE_PHYSICAL => 'Physical Product',
        self::TYPE_SOFTWARE => 'Software/Download'
    ];

    // Status Constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_OUT_OF_STOCK = 'out_of_stock';

    // Relationships
    public function category()
    {
        return $this->belongsTo(ShopCategory::class, 'category_id');
    }

    public function orderItems()
    {
        return $this->hasMany(ShopOrderItem::class, 'product_id');
    }

    public function downloads()
    {
        return $this->hasMany(ShopDownload::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(ShopReview::class, 'product_id');
    }

    public function cartItems()
    {
        return $this->hasMany(ShopCart::class, 'product_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope for getting products in stock
     */
    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('type', 'software')
                ->orWhere(function ($physicalQuery) {
                    $physicalQuery->where('type', 'physical')
                        ->where(function ($stockQuery) {
                            $stockQuery->where('manage_stock', false)
                                ->orWhere(function ($managedStockQuery) {
                                    $managedStockQuery->where('manage_stock', true)
                                        ->where('stock_quantity', '>', 0);
                                });
                        });
                });
        });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopePhysical($query)
    {
        return $query->where('type', self::TYPE_PHYSICAL);
    }

    public function scopeSoftware($query)
    {
        return $query->where('type', self::TYPE_SOFTWARE);
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
                ->orWhere('short_description', 'LIKE', "%{$term}%")
                ->orWhere('description', 'LIKE', "%{$term}%")
                ->orWhere('sku', 'LIKE', "%{$term}%")
                ->orWhereJsonContains('features', $term)
                ->orWhereHas('category', function ($categoryQuery) use ($term) {
                    $categoryQuery->where('name', 'LIKE', "%{$term}%");
                });
        });
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isInStock(): bool
    {
        if (!$this->manage_stock) {
            return $this->in_stock;
        }

        return $this->stock_quantity > 0;
    }

    public function isPhysical(): bool
    {
        return $this->type === self::TYPE_PHYSICAL;
    }

    public function isSoftware(): bool
    {
        return $this->type === self::TYPE_SOFTWARE;
    }

    public function isDownloadable(): bool
    {
        return $this->type === self::TYPE_SOFTWARE;
    }

    public function getFeaturedImageUrl(): string
    {
        if ($this->featured_image && filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
            return $this->featured_image;
        }

        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }

        return 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=300&fit=crop';
    }

    public function getGalleryImages(): array
    {
        if (!$this->gallery) {
            return [];
        }

        return collect($this->gallery)->map(function ($image) {
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                return $image;
            }
            return asset('storage/' . $image);
        })->toArray();
    }

    public function getPrice(): float
    {
        return $this->sale_price > 0 ? $this->sale_price : $this->price;
    }

    public function getFormattedPrice(): string
    {
        $price = $this->getPrice();
        $currency = $this->currency ?: 'USD';

        $symbol = match ($currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $currency . ' '
        };

        return $symbol . number_format($price, 2);
    }

    public function getFormattedOriginalPrice(): string
    {
        if (!$this->sale_price || $this->sale_price >= $this->price) {
            return '';
        }

        $currency = $this->currency ?: 'USD';
        $symbol = match ($currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $currency . ' '
        };

        return $symbol . number_format($this->price, 2);
    }

    public function getDiscountPercentage(): int
    {
        if (!$this->sale_price || $this->sale_price >= $this->price) {
            return 0;
        }

        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function getStockStatus(): string
    {
        if (!$this->isInStock()) {
            return 'Out of Stock';
        }

        if (!$this->manage_stock || $this->isSoftware()) {
            return 'In Stock';
        }

        if ($this->stock_quantity <= 5) {
            return 'Low Stock (' . $this->stock_quantity . ' left)';
        }

        return 'In Stock (' . $this->stock_quantity . ' available)';
    }

    public function getStockBadge(): array
    {
        if (!$this->isInStock()) {
            return [
                'text' => 'Out of Stock',
                'class' => 'bg-red-500/20 text-red-400',
                'icon' => 'fas fa-times-circle'
            ];
        }

        if ($this->isSoftware()) {
            return [
                'text' => 'Digital Download',
                'class' => 'bg-blue-500/20 text-blue-400',
                'icon' => 'fas fa-download'
            ];
        }

        if ($this->manage_stock && $this->stock_quantity <= 5) {
            return [
                'text' => 'Low Stock',
                'class' => 'bg-yellow-500/20 text-yellow-400',
                'icon' => 'fas fa-exclamation-triangle'
            ];
        }

        return [
            'text' => 'In Stock',
            'class' => 'bg-green-500/20 text-green-400',
            'icon' => 'fas fa-check-circle'
        ];
    }

    public function getTypeBadge(): array
    {
        return match ($this->type) {
            self::TYPE_PHYSICAL => [
                'text' => 'Physical Product',
                'class' => 'bg-gray-500/20 text-gray-400',
                'icon' => 'fas fa-box'
            ],
            self::TYPE_SOFTWARE => [
                'text' => 'Software Download',
                'class' => 'bg-purple-500/20 text-purple-400',
                'icon' => 'fas fa-download'
            ],
            default => [
                'text' => 'Product',
                'class' => 'bg-gray-500/20 text-gray-400',
                'icon' => 'fas fa-cube'
            ]
        };
    }

    public function getDownloadableFiles(): array
    {
        return $this->downloadable_files ?? [];
    }

    public function hasDownloadableFiles(): bool
    {
        return $this->isSoftware() && !empty($this->downloadable_files);
    }

    public function getAverageRating(): float
    {
        return $this->reviews()->approved()->avg('rating') ?? 0;
    }

    public function getReviewsCount(): int
    {
        return $this->reviews()->approved()->count();
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementSales(int $quantity = 1): void
    {
        $this->increment('sales_count', $quantity);
    }

    public function canPurchase(): bool
    {
        return $this->isActive() && $this->isInStock();
    }

    public function reduceStock(int $quantity): bool
    {
        if ($this->isSoftware() || !$this->manage_stock) {
            return true;
        }

        if ($this->stock_quantity >= $quantity) {
            $this->decrement('stock_quantity', $quantity);

            if ($this->stock_quantity <= 0) {
                $this->update(['in_stock' => false, 'status' => self::STATUS_OUT_OF_STOCK]);
            }

            return true;
        }

        return false;
    }

    public function restoreStock(int $quantity): void
    {
        if ($this->isSoftware() || !$this->manage_stock) {
            return;
        }

        $this->increment('stock_quantity', $quantity);

        if ($this->stock_quantity > 0 && !$this->in_stock) {
            $this->update(['in_stock' => true, 'status' => self::STATUS_ACTIVE]);
        }
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    // Static Methods
    public static function getPopularProducts($limit = 8)
    {
        return self::active()
            ->inStock()
            ->orderBy('sales_count', 'desc')
            ->orderBy('views_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function getFeaturedProducts($limit = 6)
    {
        return self::active()
            ->inStock()
            ->featured()
            ->ordered()
            ->limit($limit)
            ->get();
    }

    public static function getLatestProducts($limit = 12)
    {
        return self::active()
            ->inStock()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
