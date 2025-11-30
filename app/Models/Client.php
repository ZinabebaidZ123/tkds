<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'logo',
        'website_url',
        'category',
        'background_color',
        'hover_background_color',
        'border_color',
        'hover_scale',
        'opacity',
        'hover_opacity',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'hover_scale' => 'decimal:2',
        'opacity' => 'decimal:2',
        'hover_opacity' => 'decimal:2',
    ];

    // Categories
    const CATEGORIES = [
        'streaming' => 'Streaming Giants',
        'news_sports' => 'News & Sports',
        'tech_gaming' => 'Tech & Gaming',
        'other' => 'Other'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Get clients grouped by category for frontend display
    public static function getGroupedByCategory()
    {
        return self::active()
                   ->ordered()
                   ->get()
                   ->groupBy('category');
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getLogoUrl(): string
    {
        if ($this->logo && filter_var($this->logo, FILTER_VALIDATE_URL)) {
            return $this->logo;
        }
        
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }

        return asset('images/placeholder-logo.png');
    }

    public function getCategoryName(): string
    {
        return self::CATEGORIES[$this->category] ?? 'Other';
    }

    public function getStyleString(): string
    {
        $styles = [];
        
        if ($this->background_color) {
            $styles[] = "background-color: {$this->background_color}";
        }
        
        if ($this->border_color) {
            $styles[] = "border-color: {$this->border_color}";
        }

        if ($this->opacity) {
            $styles[] = "opacity: {$this->opacity}";
        }

        return implode('; ', $styles);
    }

    public function getHoverStyleString(): string
    {
        $styles = [];
        
        if ($this->hover_background_color) {
            $styles[] = "background-color: {$this->hover_background_color}";
        }

        if ($this->hover_opacity) {
            $styles[] = "opacity: {$this->hover_opacity}";
        }

        if ($this->hover_scale) {
            $styles[] = "transform: scale({$this->hover_scale})";
        }

        return implode('; ', $styles);
    }

    public function getAnimationClass(): string
    {
        return 'hover:scale-' . ($this->hover_scale >= 1.10 ? '110' : '105') . ' transition-all duration-500';
    }
}