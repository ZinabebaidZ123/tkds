<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $table = 'hero_sections';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'main_button_text',
        'main_button_link',
        'second_button_text',
        'second_button_link',
        'background_image',
        'background_video',
        'text_color',
        'gradient_color_1',
        'gradient_color_2',
        'gradient_color_3',
        'status',
        'sort_order',
        'show_ai_badge',
        'show_rotating_cards',
        'show_particles',
        'ai_badge_text',
        'perfect_for_title',
        'perfect_for_subtitle',
        'custom_css'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'show_ai_badge' => 'boolean',
        'show_rotating_cards' => 'boolean',
        'show_particles' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getBackgroundImageUrl(): ?string
    {
        if (!$this->background_image) {
            return null;
        }

        if (filter_var($this->background_image, FILTER_VALIDATE_URL)) {
            return $this->background_image;
        }
        
        return asset('storage/' . $this->background_image);
    }

    public function getBackgroundVideoUrl(): ?string
    {
        if (!$this->background_video) {
            return null;
        }

        if (filter_var($this->background_video, FILTER_VALIDATE_URL)) {
            return $this->background_video;
        }
        
        return asset('storage/' . $this->background_video);
    }

    public function getGradientStyle(): string
    {
        return "background: linear-gradient(135deg, {$this->gradient_color_1}, {$this->gradient_color_2}, {$this->gradient_color_3});";
    }
}