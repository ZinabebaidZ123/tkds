<?php

namespace App\Http\Controllers;

use App\Models\DynamicPage;
use App\Models\Service;
use App\Models\PricingPlan;
use App\Models\ShopProduct;
use Carbon\Carbon;

class OccasionFrontendController extends Controller
{
    public function index()
    {
        // Get first active dynamic page if slug not matched
        $page = DynamicPage::active()
            ->where('page_slug', 'special-occasions')
            ->first();

        if (! $page) {
            $page = DynamicPage::active()->firstOrFail();
        }

        $whyCards     = $page->why_choose_cards ?? [];
        $clientLogos  = $page->clients_logos ?? [];
        $reviewsItems = $page->reviews_items ?? [];

        $services = Service::active()->ordered()->get();
        $packages = PricingPlan::where('status', 'active')->get();
        $products = ShopProduct::where('status', 'active')->get();

        $countdownTarget = $page->offer_end_date
            ? Carbon::parse($page->offer_end_date)->toIso8601String()
            : null;

        return view('occasions', compact(
            'page',
            'whyCards',
            'clientLogos',
            'reviewsItems',
            'services',
            'packages',
            'products',
            'countdownTarget'
        ));
    }




public function show()
{
    $page = DynamicPage::where('page_slug', 'occasions') // أو أي slug تستخدمينه
            ->where('status', 'active')
            ->first();

    if (!$page) {
        abort(404);
    }

    // جلب البيانات الخاصة بكل قسم
    $services = $page->services()->where('pivot_status', 'active')->get();
    $packages = $page->pricingPlans()->where('pivot_status', 'active')->get(); 
    $products = $page->products()->where('pivot_status', 'active')->get();
    
    // الحصول على ترتيب الأقسام النشطة فقط
    $activeSections = $page->getActiveSectionsAttribute();
    
    return view('occasions', compact('page', 'services', 'packages', 'products', 'activeSections'));
}

public function getActiveSectionsAttribute()
{
    $sectionsOrder = $this->sections_order ?? [
        'header', 'hero', 'why_choose', 'services', 
        'packages', 'products', 'video', 'clients', 
        'reviews', 'contact', 'footer'
    ];
    
    $activeSections = [];
    
    foreach ($sectionsOrder as $section) {
        if ($this->isSectionActive($section)) {
            $activeSections[] = $section;
        }
    }
    
    return $activeSections;
}

public function isSectionActive($section)
{
    $statusField = $section . '_status';
    return $this->$statusField === 'active';
}

public function hasActiveSection($section)
{
    return $this->isSectionActive($section);
}
}
