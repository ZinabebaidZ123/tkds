<?php

namespace App\Models;

// app/Models/OccasionStat.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OccasionStat extends Model
{
    protected $fillable = [
        'occasion_id',
        'stat_number',
        'stat_label',
        'stat_description',
        'icon',
        'color_from',
        'color_to',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'sort_order' => 'integer'
    ];

    // Relationships
    public function occasion(): BelongsTo
    {
        return $this->belongsTo(Occasion::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Accessors
    public function getGradientClassAttribute()
    {
        $colorMap = [
            'primary' => 'from-primary',
            'secondary' => 'from-secondary',
            'accent' => 'from-accent',
            'blue' => 'from-blue-500',
            'green' => 'from-green-500',
            'purple' => 'from-purple-500',
            'orange' => 'from-orange-500',
            'red' => 'from-red-500'
        ];

        $fromColor = $colorMap[$this->color_from] ?? 'from-primary';
        $toColor = $colorMap[$this->color_to] ?? 'to-secondary';

        return "$fromColor $toColor";
    }

    public function getIconClassAttribute()
    {
        return $this->icon ?: 'fas fa-chart-bar';
    }
}