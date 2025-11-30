<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastingSolution extends Model
{
    use HasFactory;

    protected $table = 'broadcasting_solutions';

    protected $fillable = [
        'title_part1',
        'title_part2', 
        'subtitle',
        'title',
        'description',
        'image',
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

    public function getImageUrl(): string
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        return asset('storage/' . $this->image);
    }

    // Get formatted title
    public function getFormattedTitle(): string
    {
        if ($this->title_part1 && $this->title_part2) {
            return $this->title_part1 . ' ' . $this->title_part2;
        }
        
        return $this->title_part1 ?: $this->title;
    }

    // Get section title with styling
    public function getSectionTitle(): string
    {
        if ($this->title_part1 && $this->title_part2) {
            return $this->title_part1 . ' <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">' . $this->title_part2 . '</span>';
        }
        
        return $this->title_part1 ?: 'Our <span class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">Broadcasting</span>';
    }
}