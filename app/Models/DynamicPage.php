<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicPage extends Model
{
    use HasFactory;

    protected $table = 'dynamic_pages';

    protected $fillable = [
        'page_name',
        'page_slug',
        'page_title',
        'page_description',
        'status',
        'sections_order',
         'is_active',

        // Header
        'header_logo_image',
        'header_logo_text',
        'header_logo_subtitle',
        'header_button_text',
        'header_phone',
        'header_status',

        // Hero
        'hero_title_part1',
        'hero_title_part2',
        'hero_title_part3',
        'hero_subtitle',
        'hero_description',
        'hero_button_text',
        'hero_button_url',
        'discount_percentage',
        'offer_end_date',
        'hero_status',

        // Why choose us
        'why_choose_title',
        'why_choose_subtitle',
        'why_choose_description',
        'why_choose_left_image',
        'why_choose_background_image',
        'why_choose_button_text',
        'why_choose_button_url',
        'why_choose_cards',
        'why_choose_status',

        // Services
        'services_title',
        'services_subtitle',
        'services_status',

        // Packages
        'packages_title',
        'packages_subtitle',
        'packages_status',

        // Products (SaaS)
        'products_title',
        'products_subtitle',
        'products_status',

        // Shop Products
        'shop_products_title',
        'shop_products_subtitle',
        'shop_products_status',

        // Video
        'video_title',
        'video_subtitle',
        'video_url',
        'video_file',
        'video_thumbnail',
        'video_info_title',
        'video_info_description',
        'video_status',

        // Clients
        'clients_title',
        'clients_subtitle',
        'clients_logos',
        'clients_status',

        // Reviews
        'reviews_title',
        'reviews_subtitle',
        'reviews_items',
        'reviews_status',

        // Contact
        'contact_title',
        'contact_subtitle',
        'contact_whatsapp',
        'contact_email',
        'contact_phone',
        'contact_status',

        'footer_logo_image',
        'footer_logo_text',
        'footer_logo_subtitle',
        'footer_title_line1',
        'footer_title_line2',
        'footer_description',
        'footer_discount_badge_text',
        'footer_discount_badge_subtext',
        'footer_copyright',
        'footer_powered_by',
        'footer_social_links',
        'footer_status',
    ];

    protected $casts = [
        'offer_end_date'        => 'datetime',
        'why_choose_cards'      => 'array',
        'clients_logos'         => 'array',
        'reviews_items'         => 'array',
        'footer_social_links'   => 'array',
         'sections_order' => 'array',
        'is_active' => 'boolean', 
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'dynamic_page_services', 'dynamic_page_id', 'service_id')
            ->withPivot([
                'custom_icon',
                'custom_background',
                'discount_badge',
                'read_more_button_text',
                'read_more_button_url',
                'sort_order',
                'status',
            ])
            ->withTimestamps()
            ->orderBy('pivot_sort_order');
    }

    public function pricingPlans()
    {
        return $this->belongsToMany(PricingPlan::class, 'dynamic_page_pricing_plans', 'dynamic_page_id', 'pricing_plan_id')
            ->withPivot([
                'discount_percentage',
                'is_featured',
                'sort_order',
                'status',
            ])
            ->withTimestamps()
            ->orderBy('pivot_sort_order');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'dynamic_page_products', 'dynamic_page_id', 'product_id')
            ->withPivot([
                'discount_percentage',
                'order_button_text',
                'order_button_url',
                'sort_order',
                'status',
            ])
            ->withTimestamps()
            ->orderBy('pivot_sort_order');
    }

    public function shopProducts()
    {
        return $this->belongsToMany(ShopProduct::class, 'dynamic_page_shop_products', 'dynamic_page_id', 'shop_product_id')
            ->withPivot([
                'discount_percentage',
                'order_button_text',
                'order_button_url',
                'sort_order',
                'status',
            ])
            ->withTimestamps()
            ->orderBy('pivot_sort_order');
    }

    public function getSectionsStatusAttribute()
    {
        return [
            'header'        => $this->header_status,
            'hero'          => $this->hero_status,
            'why_choose'    => $this->why_choose_status,
            'services'      => $this->services_status,
            'packages'      => $this->packages_status,
            'products'      => $this->products_status,
            'shop_products' => $this->shop_products_status,
            'video'         => $this->video_status,
            'clients'       => $this->clients_status,
            'reviews'       => $this->reviews_status,
            'contact'       => $this->contact_status,
            'footer'        => $this->footer_status,
        ];
    }

    public function getIsFullyActiveAttribute()
    {
        return collect($this->sections_status)->every(function ($status) {
            return $status === 'active';
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWithSectionActive($query, $section)
    {
        $field = $section . '_status';
        return $query->where($field, 'active');
    }

    public function getSectionsOrderAttribute($value)
    {
        if (!$value) {
            return [
                'header', 'hero', 'why_choose', 'services', 
                'packages', 'products', 'shop_products', 'video', 'clients', 
                'reviews', 'contact', 'footer'
            ];
        }
        return is_string($value) ? json_decode($value, true) : $value;
    }

  public function isSectionActive($section)
    {
        $statusField = $section . '_status';
        return $this->$statusField === 'active';
    }

      public function getActiveSectionsAttribute()
    {
        $sectionsOrder = $this->sections_order;
        $activeSections = [];
        
        foreach ($sectionsOrder as $section) {
            if ($this->isSectionActive($section)) {
                $activeSections[] = $section;
            }
        }
        
        return $activeSections;
    }

    public function hasActiveSection($section)
    {
        return $this->isSectionActive($section);
    }


    public function isAvailable()
    {
        if (!$this->is_active) {
            return false;
        }
        
        if ($this->offer_end_date) {
            return now()->lessThan($this->offer_end_date);
        }
        
        return true;
    }


    public function getTimeRemaining()
    {
        if (!$this->offer_end_date || $this->isExpired()) {
            return null;
        }
        
        return $this->offer_end_date->diffForHumans();
    }

       public function isExpired()
    {
        if (!$this->offer_end_date) {
            return false;
        }
        
        return now()->greaterThan($this->offer_end_date);
    }
        public function scopeAvailable($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('offer_end_date')
                  ->orWhere('offer_end_date', '>', now());
            });
    }

}