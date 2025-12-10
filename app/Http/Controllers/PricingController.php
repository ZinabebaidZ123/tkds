<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PricingController extends Controller
{
    private $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function index()
    {
        try {
            Log::info('PricingController@index - Start');

            $plans = PricingPlan::active()
                              ->showInPricing()
                              ->ordered()
                              ->get();

            $featuredPlan = PricingPlan::active()
                                     ->popular()
                                     ->first();

            // ✅ NEW: Get section title data from first plan
            $firstPlan = PricingPlan::getFirstPlan();
            
            $sectionData = [
                'title_part1' => $firstPlan->title_part1 ?? 'Choose Your',
                'title_part2' => $firstPlan->title_part2 ?? 'Perfect Plan',
                'subtitle' => $firstPlan->subtitle ?? 'Flexible pricing designed to scale with your needs, from startup to enterprise'
            ];

            Log::info('PricingController@index - Success', [
                'plans_count' => $plans->count(),
                'section_data' => $sectionData
            ]);

            return view('pricing', compact('plans', 'featuredPlan', 'sectionData'));

        } catch (\Exception $e) {
            Log::error('PricingController@index - Error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            // Fallback data in case of error
            $plans = collect([]);
            $featuredPlan = null;
            $sectionData = [
                'title_part1' => 'Choose Your',
                'title_part2' => 'Perfect Plan',
                'subtitle' => 'Flexible pricing designed to scale with your needs, from startup to enterprise'
            ];

            return view('pricing', compact('plans', 'featuredPlan', 'sectionData'));
        }
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
        try {
            $plans = PricingPlan::active()
                              ->showInPricing()
                              ->ordered()
                              ->get();

            // ✅ NEW: Get section data for API
            $firstPlan = PricingPlan::getFirstPlan();
            
            $response = [
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
                        'setup_fee' => $plan->setup_fee,
                        'has_setup_fee' => $plan->hasSetupFee(),
                        'formatted_setup_fee' => $plan->getFormattedSetupFee()
                    ];
                }),
                // ✅ NEW: Include section data in API response
                'section_data' => [
                    'title_part1' => $firstPlan->title_part1 ?? 'Choose Your',
                    'title_part2' => $firstPlan->title_part2 ?? 'Perfect Plan',
                    'subtitle' => $firstPlan->subtitle ?? 'Flexible pricing designed to scale with your needs, from startup to enterprise'
                ]
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('PricingController@getPlansApi - Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load pricing plans',
                'data' => [],
                'section_data' => [
                    'title_part1' => 'Choose Your',
                    'title_part2' => 'Perfect Plan',
                    'subtitle' => 'Flexible pricing designed to scale with your needs, from startup to enterprise'
                ]
            ], 500);
        }
    }
}