<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutTimeline extends Model
{
    use HasFactory;

    protected $table = 'about_timeline';

    protected $fillable = [
        'year',
        'title',
        'description',
        'color',
        'position',
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

    // Get all active timeline items ordered by sort_order
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

    public function isLeftPosition(): bool
    {
        return $this->position === 'left';
    }

    public function isRightPosition(): bool
    {
        return $this->position === 'right';
    }

    public function getColorClass(): string
    {
        $colors = [
            'primary' => 'bg-primary',
            'secondary' => 'bg-secondary', 
            'accent' => 'bg-accent',
        ];

        return $colors[$this->color] ?? 'bg-primary';
    }
}