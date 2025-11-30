<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class OccasionContentBlock extends Model
{
    protected $fillable = [
        'occasion_section_id',
        'block_type',
        'title',
        'content',
        'image_path',
        'gallery_images',
        'button_text',
        'button_link',
        'button_style',
        'settings',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'settings' => 'array',
        'sort_order' => 'integer'
    ];

    // العلاقات
    public function section(): BelongsTo
    {
        return $this->belongsTo(OccasionSection::class, 'occasion_section_id');
    }

    // أنواع البلوكات المتاحة
    public static function getBlockTypes()
    {
        return [
            'heading' => [
                'name' => 'عنوان',
                'icon' => 'fas fa-heading',
                'description' => 'عنوان رئيسي أو فرعي'
            ],
            'paragraph' => [
                'name' => 'نص',
                'icon' => 'fas fa-paragraph',
                'description' => 'فقرة نصية'
            ],
            'list' => [
                'name' => 'قائمة',
                'icon' => 'fas fa-list-ul',
                'description' => 'قائمة منقطة أو مرقمة'
            ],
            'image' => [
                'name' => 'صورة',
                'icon' => 'fas fa-image',
                'description' => 'صورة واحدة'
            ],
            'gallery' => [
                'name' => 'معرض صور',
                'icon' => 'fas fa-images',
                'description' => 'مجموعة من الصور'
            ],
            'button' => [
                'name' => 'زر',
                'icon' => 'fas fa-hand-pointer',
                'description' => 'زر تفاعلي مع رابط'
            ],
            'video' => [
                'name' => 'فيديو',
                'icon' => 'fas fa-play-circle',
                'description' => 'مقطع فيديو مع تحكم'
            ],
            'testimonial' => [
                'name' => 'شهادة عميل',
                'icon' => 'fas fa-quote-left',
                'description' => 'آراء وتقييمات العملاء'
            ],
            'stat' => [
                'name' => 'إحصائية',
                'icon' => 'fas fa-chart-bar',
                'description' => 'رقم مع وصف'
            ]
        ];
    }

    // أنماط الأزرار المتاحة
    public static function getButtonStyles()
    {
        return [
            'primary' => 'أساسي',
            'secondary' => 'ثانوي',
            'outline' => 'مفرغ',
            'ghost' => 'شفاف',
            'gradient' => 'متدرج',
            'glow' => 'متوهج'
        ];
    }

    // حصول على رابط الصورة
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return Storage::url($this->image_path);
        }
        return null;
    }

    // حصول على روابط معرض الصور
    public function getGalleryUrlsAttribute()
    {
        if ($this->gallery_images && is_array($this->gallery_images)) {
            return array_map(function($image) {
                return Storage::url($image);
            }, $this->gallery_images);
        }
        return [];
    }

    // حصول على إعدادات محددة
    public function getSetting($key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }

    // تحديث إعدادات
    public function updateSettings(array $newSettings)
    {
        $currentSettings = $this->settings ?? [];
        $this->update([
            'settings' => array_merge($currentSettings, $newSettings)
        ]);
    }

    // التحقق من حالة النشاط
    public function isActive()
    {
        return $this->status === 'active';
    }

    // حصول على كلاس CSS للزر
    public function getButtonCssClass()
    {
        $baseClasses = 'inline-flex items-center justify-center px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105';
        
        switch ($this->button_style) {
            case 'primary':
                return $baseClasses . ' bg-gradient-to-r from-primary to-secondary text-white hover:from-secondary hover:to-primary shadow-lg hover:shadow-xl';
            case 'secondary':
                return $baseClasses . ' bg-gray-600 text-white hover:bg-gray-700';
            case 'outline':
                return $baseClasses . ' border-2 border-primary text-primary hover:bg-primary hover:text-white';
            case 'ghost':
                return $baseClasses . ' text-primary hover:bg-primary hover:text-white';
            case 'gradient':
                return $baseClasses . ' bg-gradient-to-r from-purple-500 to-pink-500 text-white hover:from-pink-500 hover:to-purple-500';
            case 'glow':
                return $baseClasses . ' bg-primary text-white glow-effect hover:shadow-2xl';
            default:
                return $baseClasses . ' bg-primary text-white hover:bg-secondary';
        }
    }

    // تصدير البيانات للفرونت
    public function toFrontendArray()
    {
        return [
            'id' => $this->id,
            'type' => $this->block_type,
            'title' => $this->title,
            'content' => $this->content,
            'image_url' => $this->image_url,
            'gallery_urls' => $this->gallery_urls,
            'button_text' => $this->button_text,
            'button_link' => $this->button_link,
            'button_css_class' => $this->getButtonCssClass(),
            'settings' => $this->settings,
            'sort_order' => $this->sort_order
        ];
    }
}


