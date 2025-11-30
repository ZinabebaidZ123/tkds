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
}
