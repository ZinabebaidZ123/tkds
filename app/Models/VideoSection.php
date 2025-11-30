<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VideoSection extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'video_type',
        'video_file',
        'video_url',
        'thumbnail',
        'autoplay',
        'loop',
        'muted',
        'controls',
        'background_color',
        'text_color',
        'overlay_enabled',
        'overlay_opacity',
        'button_text',
        'button_link',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'autoplay' => 'integer',
        'loop' => 'integer',
        'muted' => 'integer',
        'controls' => 'integer',
        'overlay_enabled' => 'integer',
        'overlay_opacity' => 'decimal:1',
        'sort_order' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * 🔥 الحل الصحيح - استخدام asset() بدلاً من Storage::url()
     */
    public function getVideoUrlAttribute($value)
    {
        // إذا كان النوع upload والملف موجود
        if ($this->video_type === 'upload' && $this->video_file) {
            // استخدام asset() مع storage/ للحصول على الرابط الصحيح
            return asset('storage/' . $this->video_file);
        }
        
        // إذا كان live stream، نرجع الـ URL المحفوظ
        return $value;
    }

    /**
     * 🔥 الحل الصحيح - استخدام asset() للـ thumbnail
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        
        return asset('images/video-placeholder.jpg'); 
    }

    /**
     * 🔥 الحل الصحيح - مصدر الفيديو للعرض
     */
    public function getVideoSourceAttribute()
    {
        if ($this->video_type === 'upload' && $this->video_file) {
            return asset('storage/' . $this->video_file);
        } elseif ($this->video_type === 'live_stream' && $this->attributes['video_url']) {
            return $this->attributes['video_url'];
        }
        
        return null;
    }

    public function getVideoTypeDisplayAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->video_type));
    }

    public function getStatusDisplayAttribute()
    {
        return ucfirst($this->status);
    }

    public function getStatusColorAttribute()
    {
        return $this->status === 'active' ? 'green' : 'red';
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isUpload()
    {
        return $this->video_type === 'upload';
    }

    public function isLiveStream()
    {
        return $this->video_type === 'live_stream';
    }

    public function hasVideo()
    {
        if ($this->video_type === 'upload') {
            return !empty($this->video_file) && Storage::disk('public')->exists($this->video_file);
        }
        
        if ($this->video_type === 'live_stream') {
            return !empty($this->attributes['video_url']);
        }
        
        return false;
    }

    public function hasThumbnail()
    {
        return !empty($this->thumbnail);
    }

    public function shouldAutoplay()
    {
        return (bool) $this->autoplay;
    }

    public function shouldLoop()
    {
        return (bool) $this->loop;
    }

    public function isMuted()
    {
        return (bool) $this->muted;
    }

    public function hasControls()
    {
        return (bool) $this->controls;
    }

    public function isOverlayEnabled()
    {
        return (bool) $this->overlay_enabled;
    }

    public function getVideoMimeType()
    {
        if ($this->video_type === 'upload' && $this->video_file) {
            $extension = pathinfo($this->video_file, PATHINFO_EXTENSION);
            
            switch (strtolower($extension)) {
                case 'mp4':
                    return 'video/mp4';
                case 'mov':
                    return 'video/quicktime';
                case 'webm':
                    return 'video/webm';
                case 'avi':
                    return 'video/x-msvideo';
                case 'wmv':
                    return 'video/x-ms-wmv';
                case 'flv':
                    return 'video/x-flv';
                case 'mkv':
                    return 'video/x-matroska';
                default:
                    return 'video/mp4'; 
            }
        }
        
        if ($this->video_type === 'live_stream') {
            return 'application/x-mpegURL'; 
        }
        
        return 'video/mp4';
    }

    public function getVideoTypeForHtml()
    {
        if ($this->video_type === 'live_stream') {
            return 'application/x-mpegURL';
        }
        
        return $this->getVideoMimeType();
    }
}