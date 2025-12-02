<?php

namespace App\Http\Controllers;

use App\Models\DynamicPage;
use App\Models\Service;
use App\Models\PricingPlan;
use App\Models\ShopProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; 

class OccasionFrontendController extends Controller
{
public function index()
{
    $page = DynamicPage::with(['services', 'pricingPlans', 'products', 'shopProducts'])
        ->where('page_slug', 'special-occasions')
        ->available() 
        ->first();

    if (!$page) {
        $page = DynamicPage::with(['services', 'pricingPlans', 'products', 'shopProducts'])
            ->available() 
            ->first();
    }

    if (!$page) {
        return view('occasions-no-offers');
    }

    if (!$page->isAvailable()) {
        return view('occasions-no-offers');
    }

    $activeSections = $page->getActiveSectionsAttribute();

    // Get selected items only with active pivot status
    $services = $page->services()
        ->wherePivot('status', 'active')
        ->orderBy('pivot_sort_order', 'asc')
        ->orderBy('services.sort_order', 'asc')
        ->get();

    $packages = $page->pricingPlans()
        ->wherePivot('status', 'active')
        ->orderBy('pivot_sort_order', 'asc')
        ->orderBy('pricing_plans.sort_order', 'asc')
        ->get();

    $products = $page->products()
        ->wherePivot('status', 'active')
        ->orderBy('pivot_sort_order', 'asc')
        ->orderBy('products.sort_order', 'asc')
        ->get();

    $shopProducts = $page->shopProducts()
        ->wherePivot('status', 'active')
        ->orderBy('pivot_sort_order', 'asc')
        ->orderBy('shop_products.sort_order', 'asc')
        ->get();

    \Log::info('Frontend data loaded:', [
        'page_id' => $page->id,
        'page_name' => $page->page_name,
        'is_active' => $page->is_active,
        'is_available' => $page->isAvailable(),
        'is_expired' => $page->isExpired(),
        'offer_end_date' => $page->offer_end_date?->toDateTimeString(),
        'services_count' => $services->count(),
        'packages_count' => $packages->count(),
        'products_count' => $products->count(),
        'shop_products_count' => $shopProducts->count(),
        'active_sections' => $activeSections
    ]);

    // Get additional data
    $whyCards = $page->why_choose_cards ?? [];
    
    // Get clients grouped by category
    try {
        $clientsByCategory = \App\Models\Client::getGroupedByCategory();
    } catch (\Exception $e) {
        \Log::warning('Failed to load clients: ' . $e->getMessage());
        $clientsByCategory = collect();
    }

    $reviewsItems = $page->reviews_items ?? [];

    // Setup countdown target
    $countdownTarget = null;
    if ($page->offer_end_date && !$page->isExpired()) {
        $countdownTarget = Carbon::parse($page->offer_end_date)->toIso8601String();
    }

    // Return the view with all data
    return view('occasions', compact(
        'page',
        'activeSections',
        'services',
        'packages', 
        'products',
        'shopProducts',
        'whyCards',
        'clientsByCategory',
        'reviewsItems',
        'countdownTarget'
    ));
}

    public function show()
    {
        return $this->index();
    }
}