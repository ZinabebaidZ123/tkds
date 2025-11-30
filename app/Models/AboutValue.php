<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutValue extends Model
{
    use HasFactory;

    protected $table = 'about_values';

    protected $fillable = [
        'title',
        'description',
        'icon',
        'color_from',
        'color_to',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'sort_order' => 'integer',
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

    // Get all active values ordered by sort_order
    public static function getActiveOrdered()
    {
        return self::active()
                   ->ordered()
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getGradientClass(): string
    {
        return "from-{$this->color_from} to-{$this->color_to}";
    }

    public function getIconHtml(): string
    {
        return "<i class=\"{$this->icon}\"></i>";
    }
}