<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use App\Services\StripeService;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    private $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function index()
    {
        $plans = PricingPlan::active()
                          ->showInPricing()
                          ->ordered()
                          ->get();

        $featuredPlan = PricingPlan::active()
                                 ->popular()
                                 ->first();

        return view('pricing', compact('plans', 'featuredPlan'));
    }

    public function show(PricingPlan $pricingPlan)
    {
        if (!$pricingPlan->isActive()) {
            abort(404);
        }

        $relatedPlans = PricingPlan::active()
                                 ->where('id', '!=', $pricingPlan->id)
                                 ->ordered()
                                 ->limit(3)
                                 ->get();

        return view('pricing.show', compact('pricingPlan', 'relatedPlans'));
    }

    public function getPlansApi()
    {
        $plans = PricingPlan::active()
                          ->showInPricing()
                          ->ordered()
                          ->get();

        return response()->json([
            'success' => true,
            'data' => $plans->map(function($plan) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'slug' => $plan->slug,
                    'description' => $plan->description,
                    'short_description' => $plan->short_description,
                    'price_monthly' => $plan->price_monthly,
                    'price_yearly' => $plan->price_yearly,
                    'formatted_price_monthly' => $plan->getFormattedPriceMonthly(),
                    'formatted_price_yearly' => $plan->getFormattedPriceYearly(),
                    'yearly_savings' => $plan->getYearlySavings(),
                    'yearly_savings_percentage' => $plan->getYearlySavingsPercentage(),
                    'features' => $plan->getFeatures(),
                    'is_popular' => $plan->isPopular(),
                    'is_featured' => $plan->isFeatured(),
                    'color' => $plan->color,
                    'icon' => $plan->icon,
                    'can_purchase' => $plan->canPurchase(),
                    'trial_days' => $plan->trial_days,
                    'support_level' => $plan->support_level,
                ];
            })
        ]);
    }
}