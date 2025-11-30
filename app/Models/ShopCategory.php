<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'parent_id',
        'sort_order',
        'is_featured',
        'status',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'parent_id' => 'integer',
        'sort_order' => 'integer',
        'is_featured' => 'boolean'
    ];

    // Status Constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    // Relationships
    public function products()
    {
        return $this->hasMany(ShopProduct::class, 'category_id');
    }

    public function activeProducts()
    {
        return $this->hasMany(ShopProduct::class, 'category_id')->active()->inStock();
    }

    public function parent()
    {
        return $this->belongsTo(ShopCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ShopCategory::class, 'parent_id');
    }

    public function activeChildren()
    {
        return $this->hasMany(ShopCategory::class, 'parent_id')->active();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isFeatured(): bool
    {
        return $this->is_featured;
    }

    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }

    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    public function getImageUrl(): string
    {
        if ($this->image && filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=300&h=200&fit=crop';
    }

    public function getProductsCount(): int
    {
        return $this->activeProducts()->count();
    }

public function getRouteKeyName()
{
    return 'id';
}

    // Static Methods
    public static function getMainCategories()
    {
        return self::active()->parent()->ordered()->get();
    }

    public static function getFeaturedCategories($limit = 6)
    {
        return self::active()->featured()->ordered()->limit($limit)->get();
    }
}