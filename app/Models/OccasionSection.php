<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OccasionSection extends Model
{
    protected $fillable = [
        'occasion_id',
        'section_type',
        'title',
        'subtitle',
        'content',
        'settings',
        'is_enabled',
        'sort_order'
    ];

    protected $casts = [
        'settings' => 'array',
        'is_enabled' => 'boolean'
    ];

    // Relationships
    public function occasion(): BelongsTo
    {
        return $this->belongsTo(Occasion::class);
    }

    // Scopes
    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // Methods
    public function getSetting(string $key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }

    public function setSetting(string $key, $value): void
    {
        $settings = $this->settings ?? [];
        data_set($settings, $key, $value);
        $this->settings = $settings;
    }

    public function getComponent(): string
    {
        $components = [
            'hero' => 'occasions.sections.hero',
            'packages' => 'occasions.sections.packages',
            'services' => 'occasions.sections.services',
            'stats' => 'occasions.sections.stats',
            'partners' => 'occasions.sections.partners',
            'clients' => 'occasions.sections.clients',
            'video' => 'occasions.sections.video',
            'testimonials' => 'occasions.sections.testimonials',
            'dynamic_content' => 'occasions.sections.dynamic-content',
            'countdown' => 'occasions.sections.countdown'
        ];

        return $components[$this->section_type] ?? 'occasions.sections.default';
    }
}