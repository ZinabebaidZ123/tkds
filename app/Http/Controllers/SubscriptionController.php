<?php
// File: app/Http/Controllers/SubscriptionController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use App\Models\UserSubscription;
use App\Models\PaymentHistory;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    private $stripeService;

    public function __construct()
    {
        // Initialize StripeService when needed instead of in constructor
    }

    private function getStripeService()
    {
        if (!$this->stripeService) {
            $this->stripeService = app(\App\Services\StripeService::class);
        }
        return $this->stripeService;
    }

    public function create(Request $request, PricingPlan $pricingPlan)
    {
        if (!$pricingPlan->canPurchase()) {
            return redirect()->route('pricing')
                ->with('error', 'This plan is not available for purchase.');
        }

        $cycle = $request->get('cycle', 'monthly');
        if (!in_array($cycle, ['monthly', 'yearly'])) {
            $cycle = 'monthly';
        }

        if (!Auth::check()) {
            session(['intended_subscription' => [
                'plan_id' => $pricingPlan->id,
                'plan_slug' => $pricingPlan->slug,
                'cycle' => $cycle
            ]]);

            return redirect()->route('auth.login')
                ->with('info', 'Please login or register to continue with your subscription.');
        }

        $user = Auth::user();

        $existingSubscription = $user->subscriptions()
            ->whereIn('status', ['active', 'trialing', 'incomplete'])
            ->first();

        if ($existingSubscription) {
            if ($existingSubscription->status === 'incomplete') {
                // Delete incomplete subscription and allow new one
                $existingSubscription->delete();
            } else {
                return redirect()->route('user.subscription.show')
                    ->with('info', 'You already have an active subscription.');
            }
        }

        $publicKey = env('STRIPE_SANDBOX_PUBLIC_KEY', env('STRIPE_LIVE_PUBLIC_KEY', ''));

        if (empty($publicKey)) {
            return redirect()->route('contact')
                ->with('info', 'Payment processing is being set up. Please contact us to complete your subscription for ' . $pricingPlan->name . '.');
        }

        return view('subscription.create', compact('pricingPlan', 'cycle', 'user', 'publicKey'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to create a subscription.',
                'redirect' => route('auth.login')
            ], 401);
        }

        $request->validate([
            'pricing_plan_id' => 'required|exists:pricing_plans,id',
            'billing_cycle' => 'required|in:monthly,yearly',
        ]);

        $user = Auth::user();
        $pricingPlan = PricingPlan::findOrFail($request->pricing_plan_id);

        if (!$pricingPlan->canPurchase()) {
            return response()->json([
                'success' => false,
                'message' => 'This plan is not available for purchase.'
            ], 400);
        }

        // Check for any existing subscriptions
        $existingSubscription = $user->subscriptions()
            ->whereIn('status', ['active', 'trialing', 'incomplete'])
            ->first();

        if ($existingSubscription) {
            if ($existingSubscription->status === 'incomplete') {
                // Delete incomplete subscription
                $existingSubscription->delete();
                Log::info('Deleted incomplete subscription', ['user_id' => $user->id, 'subscription_id' => $existingSubscription->id]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have an active subscription.'
                ], 400);
            }
        }

        try {
            DB::beginTransaction();

            $subscriptionData = $this->getStripeService()->createSubscription(
                $user,
                $pricingPlan,
                $request->billing_cycle
            );

            // ✅ CRITICAL FIX: Set proper period dates and mark as active
            $currentPeriodStart = now();
            $currentPeriodEnd = $request->billing_cycle === 'yearly' 
                ? now()->addYear() 
                : now()->addMonth();

            $updateData = [
                'current_period_start' => $currentPeriodStart,
                'current_period_end' => $currentPeriodEnd,
                'next_payment_date' => $currentPeriodEnd,
            ];

            // Set status based on plan type
            if ($pricingPlan->trial_days > 0) {
                $updateData['status'] = 'trialing';
                $updateData['trial_end'] = now()->addDays($pricingPlan->trial_days);
                $updateData['current_period_end'] = now()->addDays($pricingPlan->trial_days);
                $updateData['next_payment_date'] = now()->addDays($pricingPlan->trial_days);
            } elseif ($pricingPlan->getPrice($request->billing_cycle) == 0) {
                $updateData['status'] = 'active';
            } else {
                $updateData['status'] = 'active';
            }

            $subscriptionData['local_subscription']->update($updateData);

            Log::info('Subscription marked as active with proper dates', [
                'user_id' => $user->id,
                'subscription_id' => $subscriptionData['local_subscription']->id,
                'status' => $updateData['status'],
                'period_end' => $updateData['current_period_end']->format('Y-m-d H:i:s'),
                'trial_days' => $pricingPlan->trial_days
            ]);

            DB::commit();

            session()->forget('intended_subscription');

            return response()->json([
                'success' => true,
                'client_secret' => $subscriptionData['client_secret'],
                'subscription_id' => $subscriptionData['local_subscription']->id,
                'message' => 'Subscription created successfully!',
                'redirect' => route('subscription.success', ['subscription_id' => $subscriptionData['local_subscription']->id])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Subscription creation failed', [
                'user_id' => $user->id,
                'plan_id' => $pricingPlan->id,
                'billing_cycle' => $request->billing_cycle,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create subscription: ' . $e->getMessage()
            ], 500);
        }
    }

    public function success(Request $request)
    {
        $subscriptionId = $request->get('subscription_id');
        $subscription = null;

        if ($subscriptionId && Auth::check()) {
            $subscription = Auth::user()
                ->subscriptions()
                ->where('id', $subscriptionId)
                ->with('pricingPlan')
                ->first();

            // ✅ CRITICAL FIX: Auto-update incomplete subscriptions with proper dates
            if ($subscription && $subscription->status === 'incomplete') {
                try {
                    Log::info('Found incomplete subscription, updating to active', [
                        'subscription_id' => $subscription->id,
                        'user_id' => Auth::id(),
                        'stripe_subscription_id' => $subscription->stripe_subscription_id
                    ]);

                    // Calculate proper period dates
                    $currentPeriodStart = now();
                    $currentPeriodEnd = $subscription->billing_cycle === 'yearly' 
                        ? now()->addYear() 
                        : now()->addMonth();

                    $updateData = [
                        'status' => 'active',
                        'current_period_start' => $currentPeriodStart,
                        'current_period_end' => $currentPeriodEnd,
                        'next_payment_date' => $currentPeriodEnd,
                    ];

                    // Handle trial subscriptions
                    if ($subscription->pricingPlan->trial_days > 0) {
                        $updateData['status'] = 'trialing';
                        $updateData['trial_end'] = now()->addDays($subscription->pricingPlan->trial_days);
                        $updateData['current_period_end'] = now()->addDays($subscription->pricingPlan->trial_days);
                        $updateData['next_payment_date'] = now()->addDays($subscription->pricingPlan->trial_days);
                    }

                    $subscription->update($updateData);

                    Log::info('Successfully updated subscription to active with proper dates', [
                        'subscription_id' => $subscription->id,
                        'user_id' => Auth::id(),
                        'status' => $updateData['status'],
                        'period_end' => $updateData['current_period_end']->format('Y-m-d H:i:s')
                    ]);

                    // ✅ Create payment record if none exists
                    $existingPayment = PaymentHistory::where('subscription_id', $subscription->id)->first();
                    if (!$existingPayment && $subscription->amount > 0) {
                        PaymentHistory::create([
                            'user_id' => $subscription->user_id,
                            'subscription_id' => $subscription->id,
                            'amount' => $subscription->amount,
                            'currency' => $subscription->currency,
                            'status' => 'succeeded',
                            'description' => 'Initial subscription payment - ' . $subscription->pricingPlan->name,
                            'processed_at' => now(),
                        ]);

                        Log::info('Created initial payment record', [
                            'subscription_id' => $subscription->id,
                            'amount' => $subscription->amount
                        ]);
                    }

                    // Refresh the subscription model to get updated data
                    $subscription->refresh();
                } catch (\Exception $e) {
                    Log::error('Failed to auto-update subscription status', [
                        'subscription_id' => $subscription->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            // ✅ Log final status
            if ($subscription) {
                Log::info('Success page accessed', [
                    'subscription_id' => $subscription->id,
                    'user_id' => Auth::id(),
                    'final_status' => $subscription->status,
                    'plan_name' => $subscription->pricingPlan->name,
                    'remaining_days' => $subscription->getRemainingDays()
                ]);
            }
        }

        return view('subscription.success', compact('subscription'));
    }
    
    public function show()
    {
        $user = Auth::user();

        // Get user's subscription with related data
        $subscription = $user->subscriptions()
            ->with(['pricingPlan', 'payments' => function ($query) {
                $query->orderBy('processed_at', 'desc')->limit(5);
            }])
            ->orderBy('created_at', 'desc')
            ->first();

        // ✅ FIXED: Only handle expired subscriptions, not active ones with valid dates
        if ($subscription && $subscription->shouldAutoRemove()) {
            $this->handleSubscriptionRemoval($subscription);
            
            // Re-check for subscription after potential removal
            $subscription = $user->subscriptions()
                ->with(['pricingPlan', 'payments' => function ($query) {
                    $query->orderBy('processed_at', 'desc')->limit(5);
                }])
                ->orderBy('created_at', 'desc')
                ->first();
        }

        // If no subscription found (or was deleted), redirect to pricing
        if (!$subscription) {
            return redirect()->route('pricing')
                ->with('info', 'You don\'t have any active subscription. Choose a plan below to get started.');
        }

        // Get available plans for upgrade/downgrade
        $availablePlans = PricingPlan::active()
            ->showInPricing()
            ->where('id', '!=', $subscription->pricing_plan_id)
            ->ordered()
            ->get();

        // Calculate some stats
        $stats = [
            'total_payments' => $user->paymentHistory()->where('status', 'succeeded')->count(),
            'total_spent' => $user->paymentHistory()->where('status', 'succeeded')->sum('amount'),
            'failed_payments' => $user->paymentHistory()->where('status', 'failed')->count(),
            'days_until_renewal' => $subscription->getDaysUntilRenewal(),
        ];

        return view('user.subscription', compact('subscription', 'availablePlans', 'stats'));
    }

    /**
     * ✅ FIXED: Handle subscription removal more carefully
     */
    private function handleSubscriptionRemoval(UserSubscription $subscription)
    {
        try {
            Log::info('Auto-removing truly expired subscription', [
                'subscription_id' => $subscription->id,
                'user_id' => $subscription->user_id,
                'current_period_end' => $subscription->current_period_end?->format('Y-m-d H:i:s'),
                'is_expired' => $subscription->isExpired(),
                'should_auto_remove' => $subscription->shouldAutoRemove(),
                'remaining_days' => $subscription->getRemainingDays()
            ]);

            // Try to cancel with Stripe first, but don't fail if Stripe fails
            try {
                if ($subscription->stripe_subscription_id) {
                    $this->getStripeService()->cancelSubscription($subscription, true);
                    Log::info('Stripe subscription cancelled successfully');
                }
            } catch (\Exception $e) {
                Log::warning('Stripe cancellation failed during auto-removal, continuing with local removal', [
                    'subscription_id' => $subscription->id,
                    'stripe_error' => $e->getMessage()
                ]);
            }

            // Store data before deletion for logging
            $subscriptionData = [
                'id' => $subscription->id,
                'user_id' => $subscription->user_id,
                'plan_name' => $subscription->pricingPlan->name,
                'stripe_subscription_id' => $subscription->stripe_subscription_id
            ];

            // Delete the subscription completely
            $subscription->delete();

            Log::info('Expired subscription removed completely from database', $subscriptionData);
        } catch (\Exception $e) {
            Log::error('Failed to handle subscription removal automatically', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function cancel(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->subscriptions()
            ->whereIn('status', ['active', 'trialing'])
            ->first();

        if (!$subscription) {
            return redirect()->route('user.dashboard')
                ->with('error', 'No active subscription found.');
        }

        return view('subscription.cancel', compact('subscription'));
    }

    public function processCancel(Request $request)
    {
        $request->validate([
            'cancel_immediately' => 'boolean',
            'cancel_reason' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();
        $subscription = $user->subscriptions()
            ->whereIn('status', ['active', 'trialing'])
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'No active subscription found.'
            ], 404);
        }

        try {
            $immediately = $request->boolean('cancel_immediately');
            
            // ✅ Handle Stripe cancellation more gracefully
            $stripeSuccess = false;
            if ($subscription->stripe_subscription_id) {
                try {
                    $stripeSuccess = $this->getStripeService()->cancelSubscription($subscription, $immediately);
                } catch (\Exception $e) {
                    Log::warning('Stripe cancellation failed, proceeding with local cancellation', [
                        'subscription_id' => $subscription->id,
                        'user_id' => $user->id,
                        'stripe_error' => $e->getMessage()
                    ]);
                }
            }

            // Log cancellation reason
            if ($request->cancel_reason) {
                Log::info('Subscription cancelled by user', [
                    'user_id' => $user->id,
                    'subscription_id' => $subscription->id,
                    'plan_name' => $subscription->pricingPlan->name,
                    'reason' => $request->cancel_reason,
                    'immediately' => $immediately,
                    'stripe_success' => $stripeSuccess
                ]);
            }

            if ($immediately) {
                // Delete subscription completely if canceled immediately
                $subscriptionData = [
                    'id' => $subscription->id,
                    'user_id' => $user->id,
                    'plan_name' => $subscription->pricingPlan->name
                ];

                $subscription->delete();

                Log::info('Subscription cancelled immediately and removed from database', $subscriptionData);

                $message = 'Subscription cancelled immediately. You can subscribe to a new plan anytime.';
            } else {
                // Mark for cancellation at period end
                $subscription->update([
                    'cancel_at_period_end' => true,
                    'canceled_at' => now()
                ]);

                $message = $subscription->current_period_end 
                    ? "Subscription will cancel on {$subscription->current_period_end->format('M d, Y')}. You'll keep access until then."
                    : 'Subscription will cancel at the end of your billing period.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'immediately_canceled' => $immediately
            ]);
        } catch (\Exception $e) {
            Log::error('Subscription cancellation failed', [
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel subscription: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resume(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->subscriptions()
            ->where('status', 'canceled')
            ->first();

        if (!$subscription || !$subscription->canResume()) {
            return redirect()->route('user.dashboard')
                ->with('error', 'No cancelled subscription found or cannot be resumed.');
        }

        try {
            $success = $this->getStripeService()->resumeSubscription($subscription);

            if ($success) {
                Log::info('Subscription resumed by user', [
                    'user_id' => $user->id,
                    'subscription_id' => $subscription->id,
                    'plan_name' => $subscription->pricingPlan->name
                ]);

                return redirect()->route('user.subscription.show')
                    ->with('success', 'Subscription resumed successfully!');
            }

            return redirect()->back()
                ->with('error', 'Failed to resume subscription.');
        } catch (\Exception $e) {
            Log::error('Subscription resume failed', [
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to resume subscription: ' . $e->getMessage());
        }
    }

    public function changePlan(Request $request)
    {
        $request->validate([
            'new_plan_id' => 'required|exists:pricing_plans,id',
            'billing_cycle' => 'required|in:monthly,yearly'
        ]);

        $user = Auth::user();
        $currentSubscription = $user->subscriptions()
            ->where('status', 'active')
            ->first();

        if (!$currentSubscription) {
            return response()->json([
                'success' => false,
                'message' => 'No active subscription found.'
            ], 404);
        }

        $newPlan = PricingPlan::findOrFail($request->new_plan_id);

        if (!$newPlan->canPurchase()) {
            return response()->json([
                'success' => false,
                'message' => 'The selected plan is not available.'
            ], 400);
        }

        if ($currentSubscription->pricing_plan_id == $newPlan->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are already subscribed to this plan.'
            ], 400);
        }

        try {
            Log::info('Plan change requested', [
                'user_id' => $user->id,
                'current_plan' => $currentSubscription->pricingPlan->name,
                'new_plan' => $newPlan->name,
                'billing_cycle' => $request->billing_cycle
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Plan changes are not yet implemented. Please contact support to change your plan.'
            ], 501);
        } catch (\Exception $e) {
            Log::error('Plan change failed', [
                'user_id' => $user->id,
                'current_plan' => $currentSubscription->pricing_plan_id,
                'new_plan' => $request->new_plan_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to change plan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function invoice(UserSubscription $subscription, $invoiceId)
    {
        if ($subscription->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to view this invoice.');
        }

        $payment = $subscription->payments()
            ->where('stripe_invoice_id', $invoiceId)
            ->first();

        if (!$payment) {
            abort(404, 'Invoice not found.');
        }

        return view('subscription.invoice', compact('subscription', 'payment'));
    }

    public function getSubscriptionData()
    {
        $user = Auth::user();
        $subscription = $user->getCurrentSubscription();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'No active subscription found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'subscription' => $subscription,
                'plan' => $subscription->pricingPlan,
                'status' => $subscription->getStatusBadge(),
                'next_payment' => $subscription->next_payment_date ?
                    $subscription->next_payment_date->format('M j, Y') : null,
                'days_until_renewal' => $subscription->getDaysUntilRenewal(),
            ]
        ]);
    }
}