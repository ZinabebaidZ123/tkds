<?php

namespace App\Services;

use App\Models\StripeSettings;
use App\Models\User;
use App\Models\PricingPlan;
use App\Models\UserSubscription;
use App\Models\PaymentHistory;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\PaymentIntent;
use Stripe\Invoice;
use Stripe\Product;
use Stripe\Price;
use Exception;
use Log;

class StripeService
{
    private $stripeSettings;
    
    public function __construct()
    {
        $this->stripeSettings = StripeSettings::getSettings();
        $this->initializeStripe();
    }

    private function initializeStripe()
    {
        if (!$this->stripeSettings) {
            throw new Exception('Stripe settings not configured');
        }

        $secretKey = $this->stripeSettings->getSecretKey();

        if (!$secretKey) {
            throw new Exception('Stripe secret key not configured');
        }

        Stripe::setApiKey($secretKey);
    }

    public function getPublicKey(): string
    {
        return $this->stripeSettings->getPublicKey();
    }

    public function getSettings(): StripeSettings
    {
        return $this->stripeSettings;
    }

    // Customer Management
    public function createCustomer(User $user): Customer
    {
        try {
            $customer = Customer::create([
                'email' => $user->email,
                'name' => $user->name,
                'phone' => $user->phone,
                'metadata' => [
                    'user_id' => $user->id,
                    'created_via' => 'tkds_media'
                ]
            ]);

            return $customer;
        } catch (Exception $e) {
            Log::error('Stripe customer creation failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Failed to create customer: ' . $e->getMessage());
        }
    }

    public function getOrCreateCustomer(User $user): Customer
    {
        try {
            // Try to find existing customer
            $customers = Customer::all([
                'email' => $user->email,
                'limit' => 1
            ]);

            if ($customers->data && count($customers->data) > 0) {
                return $customers->data[0];
            }

            // Create new customer if not found
            return $this->createCustomer($user);
        } catch (Exception $e) {
            Log::error('Stripe get or create customer failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Failed to get or create customer: ' . $e->getMessage());
        }
    }

    // ✅ IMPROVED SUBSCRIPTION CREATION WITH SANDBOX HANDLING
    public function createSubscription(User $user, PricingPlan $plan, string $cycle = 'monthly'): array
    {
        try {
            $customer = $this->getOrCreateCustomer($user);
            $priceId = $plan->getStripePriceId($cycle);

            if (!$priceId) {
                throw new Exception('Price ID not found for plan and cycle');
            }

            $subscriptionData = [
                'customer' => $customer->id,
                'items' => [
                    [
                        'price' => $priceId,
                    ],
                ],
                'payment_behavior' => 'default_incomplete',
                'expand' => ['latest_invoice.payment_intent'],
                'metadata' => [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'plan_name' => $plan->name,
                    'billing_cycle' => $cycle
                ]
            ];

            // Add trial period if available
            if ($plan->trial_days && $plan->trial_days > 0) {
                $subscriptionData['trial_period_days'] = $plan->trial_days;
            }

            $subscription = Subscription::create($subscriptionData);

            // ✅ DETERMINE INITIAL STATUS
            $initialStatus = 'incomplete';
            if ($subscription->status === 'trialing') {
                $initialStatus = 'trialing';
            } elseif ($subscription->status === 'active') {
                $initialStatus = 'active';
            }

            // ✅ FOR SANDBOX MODE - MORE LENIENT STATUS HANDLING
            if ($this->stripeSettings->isSandbox() && $subscription->status === 'incomplete') {
                // In sandbox mode, if there's no payment required (free plan or trial), mark as active
                if ($plan->getPrice($cycle) == 0 || ($plan->trial_days && $plan->trial_days > 0)) {
                    $initialStatus = $plan->trial_days > 0 ? 'trialing' : 'active';
                }
            }

            // Create local subscription record
            $localSubscription = UserSubscription::create([
                'user_id' => $user->id,
                'pricing_plan_id' => $plan->id,
                'stripe_subscription_id' => $subscription->id,
                'stripe_customer_id' => $customer->id,
                'stripe_price_id' => $priceId,
                'billing_cycle' => $cycle,
                'status' => $initialStatus,
                'current_period_start' => $subscription->current_period_start ? 
                    date('Y-m-d H:i:s', $subscription->current_period_start) : null,
                'current_period_end' => $subscription->current_period_end ? 
                    date('Y-m-d H:i:s', $subscription->current_period_end) : null,
                'trial_end' => $subscription->trial_end ? 
                    date('Y-m-d H:i:s', $subscription->trial_end) : null,
                'amount' => $plan->getPrice($cycle) ?? 0,
                'currency' => $plan->currency,
            ]);

            Log::info('Subscription created', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'stripe_subscription_id' => $subscription->id,
                'local_status' => $initialStatus,
                'stripe_status' => $subscription->status,
                'is_sandbox' => $this->stripeSettings->isSandbox()
            ]);

            return [
                'subscription' => $subscription,
                'local_subscription' => $localSubscription,
                'client_secret' => $subscription->latest_invoice->payment_intent->client_secret ?? null,
            ];
        } catch (Exception $e) {
            Log::error('Stripe subscription creation failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'cycle' => $cycle,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Failed to create subscription: ' . $e->getMessage());
        }
    }

    public function cancelSubscription(UserSubscription $subscription, bool $immediately = false): bool
    {
        try {
            $stripeSubscription = Subscription::retrieve($subscription->stripe_subscription_id);
            
            if ($immediately) {
                $stripeSubscription->cancel();
                $subscription->update([
                    'status' => 'canceled',
                    'canceled_at' => now()
                ]);
            } else {
                $stripeSubscription->cancel_at_period_end = true;
                $stripeSubscription->save();
                $subscription->update(['status' => 'active']); // Still active until period end
            }

            return true;
        } catch (Exception $e) {
            Log::error('Stripe subscription cancellation failed', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function resumeSubscription(UserSubscription $subscription): bool
    {
        try {
            $stripeSubscription = Subscription::retrieve($subscription->stripe_subscription_id);
            $stripeSubscription->cancel_at_period_end = false;
            $stripeSubscription->save();

            $subscription->update([
                'status' => 'active',
                'canceled_at' => null
            ]);

            return true;
        } catch (Exception $e) {
            Log::error('Stripe subscription resume failed', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    // Product and Price Management
    public function createProduct(PricingPlan $plan): Product
    {
        try {
            $product = Product::create([
                'name' => $plan->name,
                'description' => $plan->description,
                'metadata' => [
                    'plan_id' => $plan->id,
                    'plan_slug' => $plan->slug
                ]
            ]);

            $plan->update(['stripe_product_id' => $product->id]);
            return $product;
        } catch (Exception $e) {
            Log::error('Stripe product creation failed', [
                'plan_id' => $plan->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Failed to create product: ' . $e->getMessage());
        }
    }

    public function createPrice(PricingPlan $plan, string $cycle = 'monthly'): Price
    {
        try {
            $productId = $plan->stripe_product_id;
            if (!$productId) {
                $product = $this->createProduct($plan);
                $productId = $product->id;
            }

            $amount = $cycle === 'yearly' ? $plan->price_yearly : $plan->price_monthly;
            if (!$amount) {
                throw new Exception('Price not set for cycle: ' . $cycle);
            }

            $price = Price::create([
                'product' => $productId,
                'unit_amount' => $amount * 100, // Convert to cents
                'currency' => strtolower($plan->currency),
                'recurring' => [
                    'interval' => $cycle === 'yearly' ? 'year' : 'month',
                ],
                'metadata' => [
                    'plan_id' => $plan->id,
                    'plan_slug' => $plan->slug,
                    'billing_cycle' => $cycle
                ]
            ]);

            // Update plan with price ID
            $priceIdField = $cycle === 'yearly' ? 'stripe_price_id_yearly' : 'stripe_price_id_monthly';
            $plan->update([$priceIdField => $price->id]);

            return $price;
        } catch (Exception $e) {
            Log::error('Stripe price creation failed', [
                'plan_id' => $plan->id,
                'cycle' => $cycle,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Failed to create price: ' . $e->getMessage());
        }
    }

    // Payment Management
    public function createPaymentIntent(float $amount, string $currency = 'usd', User $user = null): PaymentIntent
    {
        try {
            $paymentIntentData = [
                'amount' => $amount * 100, // Convert to cents
                'currency' => strtolower($currency),
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ];

            if ($user) {
                $customer = $this->getOrCreateCustomer($user);
                $paymentIntentData['customer'] = $customer->id;
                $paymentIntentData['metadata'] = [
                    'user_id' => $user->id,
                    'user_email' => $user->email
                ];
            }

            return PaymentIntent::create($paymentIntentData);
        } catch (Exception $e) {
            Log::error('Stripe payment intent creation failed', [
                'amount' => $amount,
                'currency' => $currency,
                'user_id' => $user?->id,
                'error' => $e->getMessage()
            ]);
            throw new Exception('Failed to create payment intent: ' . $e->getMessage());
        }
    }

    // ✅ IMPROVED WEBHOOK HANDLING WITH SANDBOX CONSIDERATIONS
    public function handleWebhook(array $eventData): bool
    {
        try {
            $eventType = $eventData['type'];
            $object = $eventData['data']['object'];

            Log::info('Processing webhook', [
                'event_type' => $eventType,
                'object_id' => $object['id'] ?? 'unknown',
                'is_sandbox' => $this->stripeSettings->isSandbox()
            ]);

            switch ($eventType) {
                case 'invoice.payment_succeeded':
                    return $this->handlePaymentSucceeded($object);
                
                case 'invoice.payment_failed':
                    return $this->handlePaymentFailed($object);
                
                case 'customer.subscription.updated':
                    return $this->handleSubscriptionUpdated($object);
                
                case 'customer.subscription.deleted':
                    return $this->handleSubscriptionDeleted($object);
                
                case 'checkout.session.completed':
                    return $this->handleCheckoutCompleted($object);
                
                default:
                    Log::info('Unhandled Stripe webhook event', ['type' => $eventType]);
                    return true;
            }
        } catch (Exception $e) {
            Log::error('Stripe webhook handling failed', [
                'event_type' => $eventData['type'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    private function handlePaymentSucceeded(array $invoice): bool
    {
        try {
            $subscription = UserSubscription::findByStripeId($invoice['subscription']);
            if (!$subscription) {
                Log::warning('Subscription not found for payment succeeded', [
                    'stripe_subscription_id' => $invoice['subscription']
                ]);
                return false;
            }

            // Create payment record
            PaymentHistory::create([
                'user_id' => $subscription->user_id,
                'subscription_id' => $subscription->id,
                'stripe_invoice_id' => $invoice['id'],
                'stripe_payment_intent_id' => $invoice['payment_intent'],
                'amount' => $invoice['amount_paid'] / 100,
                'currency' => strtoupper($invoice['currency']),
                'status' => 'succeeded',
                'receipt_url' => $invoice['receipt_number'] ?? null,
                'processed_at' => now(),
            ]);

            // ✅ UPDATE SUBSCRIPTION STATUS TO ACTIVE
            if (in_array($subscription->status, ['incomplete', 'past_due'])) {
                $subscription->update(['status' => 'active']);
                
                Log::info('Subscription updated to active after payment', [
                    'subscription_id' => $subscription->id,
                    'user_id' => $subscription->user_id
                ]);
            }

            return true;
        } catch (Exception $e) {
            Log::error('Handle payment succeeded failed', [
                'invoice_id' => $invoice['id'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    private function handlePaymentFailed(array $invoice): bool
    {
        try {
            $subscription = UserSubscription::findByStripeId($invoice['subscription']);
            if (!$subscription) {
                return false;
            }

            PaymentHistory::create([
                'user_id' => $subscription->user_id,
                'subscription_id' => $subscription->id,
                'stripe_invoice_id' => $invoice['id'],
                'stripe_payment_intent_id' => $invoice['payment_intent'],
                'amount' => $invoice['amount_due'] / 100,
                'currency' => strtoupper($invoice['currency']),
                'status' => 'failed',
                'failure_reason' => $invoice['last_finalization_error']['message'] ?? 'Payment failed',
                'processed_at' => now(),
            ]);

            // Update subscription status
            $subscription->update(['status' => 'past_due']);
            
            return true;
        } catch (Exception $e) {
            Log::error('Handle payment failed failed', [
                'invoice_id' => $invoice['id'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    private function handleSubscriptionUpdated(array $subscription): bool
    {
        try {
            $localSubscription = UserSubscription::findByStripeId($subscription['id']);
            if (!$localSubscription) {
                return false;
            }

            $updateData = [
                'status' => $subscription['status'],
                'current_period_start' => date('Y-m-d H:i:s', $subscription['current_period_start']),
                'current_period_end' => date('Y-m-d H:i:s', $subscription['current_period_end']),
            ];

            if ($subscription['trial_end']) {
                $updateData['trial_end'] = date('Y-m-d H:i:s', $subscription['trial_end']);
            }

            $localSubscription->update($updateData);

            Log::info('Local subscription updated from webhook', [
                'subscription_id' => $localSubscription->id,
                'new_status' => $subscription['status']
            ]);

            return true;
        } catch (Exception $e) {
            Log::error('Handle subscription updated failed', [
                'subscription_id' => $subscription['id'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    private function handleSubscriptionDeleted(array $subscription): bool
    {
        try {
            $localSubscription = UserSubscription::findByStripeId($subscription['id']);
            if (!$localSubscription) {
                return false;
            }

            $localSubscription->update([
                'status' => 'canceled',
                'canceled_at' => now()
            ]);

            return true;
        } catch (Exception $e) {
            Log::error('Handle subscription deleted failed', [
                'subscription_id' => $subscription['id'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    // ✅ NEW METHOD FOR CHECKOUT COMPLETION
    private function handleCheckoutCompleted(array $session): bool
    {
        try {
            if (isset($session['subscription'])) {
                $subscription = UserSubscription::findByStripeId($session['subscription']);
                if ($subscription && $subscription->status === 'incomplete') {
                    $subscription->update(['status' => 'active']);
                    
                    Log::info('Subscription activated from checkout', [
                        'subscription_id' => $subscription->id,
                        'session_id' => $session['id']
                    ]);
                }
            }
            return true;
        } catch (Exception $e) {
            Log::error('Handle checkout completed failed', [
                'session_id' => $session['id'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    // Settings Management
    public function updateSettings(array $data): bool
    {
        try {
            $this->stripeSettings->update($data);
            $this->initializeStripe();
            return true;
        } catch (Exception $e) {
            Log::error('Stripe settings update failed', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}