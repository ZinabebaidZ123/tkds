<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    use HasFactory;

    protected $table = 'about_settings';

    protected $fillable = [
        'hero_badge_text',
        'hero_title',
        'hero_subtitle', 
        'hero_description',
        'mission_title',
        'mission_content',
        'innovation_title',
        'innovation_content',
        'stat_1_number',
        'stat_1_label',
        'stat_2_number',
        'stat_2_label',
        'video_enabled',
        'video_url',
        'video_thumbnail',
        'uptime_percentage',
        'latency_time',
        'quality_level',
        'meta_title',
        'meta_description',
        'status'
    ];

    protected $casts = [
        'video_enabled' => 'boolean',
    ];

    // Get the single instance (there should only be one record)
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            // Create default settings if none exist
            $settings = self::create([
                'hero_badge_text' => 'About Us',
                'hero_title' => 'Leading the Future of Digital Broadcasting',
                'hero_subtitle' => 'We\'re pioneering the next generation of streaming and broadcasting technology',
                'hero_description' => 'At TKDS Media, we believe that every story deserves to be told and every audience deserves quality content.',
                'mission_title' => 'Our Mission',
                'mission_content' => 'At TKDS Media, we believe that every story deserves to be told and every audience deserves quality content.',
                'innovation_title' => 'Innovation at Our Core',
                'innovation_content' => 'We\'re constantly pushing the boundaries of what\'s possible in live streaming and broadcasting.',
                'stat_1_number' => '10K+',
                'stat_1_label' => 'Active Users',
                'stat_2_number' => '50+',
                'stat_2_label' => 'Countries',
                'uptime_percentage' => '99.9%',
                'latency_time' => '<1s',
                'quality_level' => '4K',
                'meta_title' => 'TKDS Media - About Us',
                'meta_description' => 'Leading digital broadcasting solutions with professional streaming.',
                'status' => 'active'
            ]);
        }
        
        return $settings;
    }

    // Check if settings are active
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // Get video thumbnail URL
    public function getVideoThumbnailUrl(): string
    {
        if ($this->video_thumbnail && filter_var($this->video_thumbnail, FILTER_VALIDATE_URL)) {
            return $this->video_thumbnail;
        }
        
        if ($this->video_thumbnail) {
            return asset('storage/' . $this->video_thumbnail);
        }

        return asset('images/video-placeholder.jpg');
    }
}