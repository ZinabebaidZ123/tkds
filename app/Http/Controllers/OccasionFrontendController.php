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
            ->first();

        if (!$page) {
            $page = DynamicPage::with(['services', 'pricingPlans', 'products', 'shopProducts'])
                ->where('status', 'active')
                ->first();
        }

        if (!$page) {
            abort(404, 'Dynamic page not found');
        }

        $activeSections = $page->getActiveSectionsAttribute();

        // Get selected items only
        $services = $page->services()->wherePivot('status', 'active')->orderBy('pivot_sort_order')->get();
        $packages = $page->pricingPlans()->wherePivot('status', 'active')->orderBy('pivot_sort_order')->get();
        $products = $page->products()->wherePivot('status', 'active')->orderBy('pivot_sort_order')->get();
        $shopProducts = $page->shopProducts()->wherePivot('status', 'active')->orderBy('pivot_sort_order')->get();

        \Log::info('Frontend data loaded:', [
            'page_id' => $page->id,
            'services_count' => $services->count(),
            'packages_count' => $packages->count(),
            'products_count' => $products->count(),
            'shop_products_count' => $shopProducts->count(),
            'active_sections' => $activeSections
        ]);

        $whyCards = $page->why_choose_cards ?? [];
        $clientsByCategory = \App\Models\Client::getGroupedByCategory();
        $reviewsItems = $page->reviews_items ?? [];

        $countdownTarget = $page->offer_end_date
            ? Carbon::parse($page->offer_end_date)->toIso8601String()
            : null;

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