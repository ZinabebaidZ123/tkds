<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfectForCard extends Model
{
    use HasFactory;

    protected $table = 'perfect_for_cards';

    protected $fillable = [
        'title',
        'subtitle', 
        'icon',
        'background_color',
        'text_color',
        'border_color',
        'status',
        'sort_order'
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

    // Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getCardStyles(): string
    {
        return "background: {$this->background_color}; color: {$this->text_color}; border-color: {$this->border_color};";
    }
}