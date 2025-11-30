<?php
// File: app/Http/Controllers/Admin/StripeController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StripeSettings;
use App\Models\UserSubscription;
use App\Models\PaymentHistory;
use App\Services\StripeService;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    private $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function settings()
    {
        $settings = StripeSettings::getSettings();
        
        $stats = [
            'total_subscribers' => UserSubscription::active()->count(),
            'monthly_revenue' => PaymentHistory::getMonthlyRevenue(),
            'yearly_revenue' => PaymentHistory::getYearlyRevenue(),
            'total_revenue' => PaymentHistory::getTotalRevenue(),
            'average_transaction' => PaymentHistory::getAverageTransactionAmount(),
            'failure_rate' => PaymentHistory::getFailureRate(),
        ];

        return view('admin.stripe.settings', compact('settings', 'stats'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'environment' => 'required|in:sandbox,live',
            'live_public_key' => 'nullable|string|starts_with:pk_live_',
            'live_secret_key' => 'nullable|string|starts_with:sk_live_',
            'sandbox_public_key' => 'nullable|string|starts_with:pk_test_',
            'sandbox_secret_key' => 'nullable|string|starts_with:sk_test_',
            'webhook_secret' => 'nullable|string|starts_with:whsec_',
            'default_currency' => 'required|string|size:3',
            'collect_billing_address' => 'boolean',
            'collect_shipping_address' => 'boolean',
            'enable_tax_calculation' => 'boolean',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $settings = StripeSettings::getSettings();
            
            $settings->update([
                'environment' => $request->environment,
                'live_public_key' => $request->live_public_key,
                'live_secret_key' => $request->live_secret_key,
                'sandbox_public_key' => $request->sandbox_public_key,
                'sandbox_secret_key' => $request->sandbox_secret_key,
                'webhook_secret' => $request->webhook_secret,
                'default_currency' => strtoupper($request->default_currency),
                'collect_billing_address' => $request->boolean('collect_billing_address'),
                'collect_shipping_address' => $request->boolean('collect_shipping_address'),
                'enable_tax_calculation' => $request->boolean('enable_tax_calculation'),
                'status' => $request->status
            ]);

            return redirect()->route('admin.stripe.settings')
                           ->with('success', 'Stripe settings updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Stripe settings update failed', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                           ->withErrors(['error' => 'Failed to update settings: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    public function dashboard()
    {
        $stats = [
            'total_subscribers' => UserSubscription::active()->count(),
            'new_subscribers_this_month' => UserSubscription::active()
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count(),
            'monthly_revenue' => PaymentHistory::getMonthlyRevenue(),
            'yearly_revenue' => PaymentHistory::getYearlyRevenue(),
            'total_revenue' => PaymentHistory::getTotalRevenue(),
            'failed_payments' => PaymentHistory::failed()
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count(),
            'successful_payments' => PaymentHistory::succeeded()
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count(),
            'average_transaction' => PaymentHistory::getAverageTransactionAmount(),
        ];

        // Recent transactions
        $recentPayments = PaymentHistory::with(['user', 'subscription.pricingPlan'])
                                       ->orderBy('created_at', 'desc')
                                       ->limit(10)
                                       ->get();

        // Subscription trends (last 12 months)
        $subscriptionTrends = collect(range(0, 11))->map(function($i) {
            $date = now()->subMonths($i);
            return [
                'month' => $date->format('M Y'),
                'count' => UserSubscription::whereBetween('created_at', [
                    $date->startOfMonth()->copy(),
                    $date->endOfMonth()->copy()
                ])->count()
            ];
        })->reverse()->values();

        // Revenue trends (last 12 months)
        $revenueTrends = collect(range(0, 11))->map(function($i) {
            $date = now()->subMonths($i);
            return [
                'month' => $date->format('M Y'),
                'amount' => PaymentHistory::succeeded()
                    ->whereBetween('processed_at', [
                        $date->startOfMonth()->copy(),
                        $date->endOfMonth()->copy()
                    ])->sum('amount')
            ];
        })->reverse()->values();

        return view('admin.stripe.dashboard', compact(
            'stats',
            'recentPayments',
            'subscriptionTrends',
            'revenueTrends'
        ));
    }

    public function subscriptions(Request $request)
    {
        $query = UserSubscription::with(['user', 'pricingPlan']);

        // Search
        if ($request->search) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->plan_id) {
            $query->where('pricing_plan_id', $request->plan_id);
        }

        // Filter by billing cycle
        if ($request->billing_cycle) {
            $query->where('billing_cycle', $request->billing_cycle);
        }

        $subscriptions = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.stripe.subscriptions', compact('subscriptions'));
    }

    public function payments(Request $request)
    {
        $query = PaymentHistory::with(['user', 'subscription.pricingPlan']);

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('stripe_payment_intent_id', 'like', '%' . $request->search . '%')
                  ->orWhere('stripe_invoice_id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQ) use ($request) {
                      $userQ->where('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('processed_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.stripe.payments', compact('payments'));
    }

    public function testConnection()
    {
        try {
            $settings = $this->stripeService->getSettings();
            
            if (!$settings->isConfigured()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stripe is not properly configured'
                ], 400);
            }

            // Test the connection by trying to retrieve account info
            \Stripe\Stripe::setApiKey($settings->getSecretKey());
            $account = \Stripe\Account::retrieve();

            return response()->json([
                'success' => true,
                'message' => 'Connection successful!',
                'account_id' => $account->id,
                'country' => $account->country,
                'currency' => $account->default_currency
            ]);

        } catch (\Exception $e) {
            \Log::error('Stripe connection test failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateWebhookUrl()
    {
        $webhookUrl = route('stripe.webhook');
        
        return response()->json([
            'success' => true,
            'webhook_url' => $webhookUrl,
            'events' => [
                'invoice.payment_succeeded',
                'invoice.payment_failed',
                'customer.subscription.updated',
                'customer.subscription.deleted',
                'checkout.session.completed',
            ]
        ]);
    }
}