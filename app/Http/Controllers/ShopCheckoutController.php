<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopCart;
use App\Models\ShopOrder;
use App\Models\ShopOrderItem;
use App\Models\User;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;

class ShopCheckoutController extends Controller
{
    private $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login')
                ->with('message', 'Please login to continue with checkout');
        }

        $user = auth()->user();
        $identifiers = [
            'user_id' => $user->id,
            'session_id' => session()->getId()
        ];

        $cartItems = ShopCart::getCartItems($identifiers['user_id'], $identifiers['session_id']);

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.cart')
                ->with('error', 'Your cart is empty');
        }

        // Validate all items are still available
        foreach ($cartItems as $item) {
            if (!$item->product->canPurchase()) {
                return redirect()->route('shop.cart')
                    ->with('error', "Product '{$item->product->name}' is no longer available");
            }

            if (!$item->canAddQuantity(0)) { // Check current quantity is valid
                return redirect()->route('shop.cart')
                    ->with('error', "Product '{$item->product->name}' doesn't have enough stock");
            }
        }

        $cartSummary = $this->getCartSummary($cartItems);

        // Get user's billing and shipping addresses
        $billingAddresses = $user->billingInfo()->get();
        $shippingAddresses = $user->shippingInfo()->get();

        return view('shop.checkout', compact(
            'cartItems',
            'cartSummary',
            'billingAddresses',
            'shippingAddresses'
        ));
    }

    public function process(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $user = auth()->user();
        $identifiers = [
            'user_id' => $user->id,
            'session_id' => session()->getId()
        ];

        $cartItems = ShopCart::getCartItems($identifiers['user_id'], $identifiers['session_id']);

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ]);
        }

        // Enhanced validation with better error messages
        $request->validate([
            'billing_address' => 'required|array',
            'billing_address.first_name' => 'required|string|max:255',
            'billing_address.last_name' => 'required|string|max:255',
            'billing_address.email' => 'required|email|max:255',
            'billing_address.phone' => 'nullable|string|max:20',
            'billing_address.address_line_1' => 'required|string|max:255',
            'billing_address.address_line_2' => 'nullable|string|max:255',
            'billing_address.city' => 'required|string|max:100',
            'billing_address.state' => 'nullable|string|max:100',
            'billing_address.postal_code' => 'required|string|max:20',
            'billing_address.country' => 'required|string|max:100',
            'shipping_address' => 'nullable|array',
            'payment_method' => 'required|in:stripe',
            'terms_accepted' => 'required|accepted'
        ], [
            'billing_address.first_name.required' => 'First name is required',
            'billing_address.last_name.required' => 'Last name is required',
            'billing_address.email.required' => 'Email address is required',
            'billing_address.email.email' => 'Please enter a valid email address',
            'billing_address.address_line_1.required' => 'Address is required',
            'billing_address.city.required' => 'City is required',
            'billing_address.postal_code.required' => 'Postal code is required',
            'billing_address.country.required' => 'Country is required',
            'payment_method.required' => 'Please select a payment method',
            'terms_accepted.required' => 'You must accept the terms and conditions',
            'terms_accepted.accepted' => 'You must accept the terms and conditions'
        ]);

        try {
            DB::beginTransaction();

            $cartSummary = $this->getCartSummary($cartItems);

            // Prepare billing address - ensure all required fields
            $billingAddress = $request->input('billing_address');
            $billingAddress['name'] = trim($billingAddress['first_name'] . ' ' . $billingAddress['last_name']);

            // Handle shipping address
            $shippingAddress = $request->input('shipping_address');
            if (empty($shippingAddress)) {
                // Use billing address for shipping
                $shippingAddress = $billingAddress;
            } else {
                $shippingAddress['name'] = trim($shippingAddress['first_name'] . ' ' . $shippingAddress['last_name']);
            }

            // Create order
            $order = ShopOrder::create([
                'order_number' => ShopOrder::generateOrderNumber(),
                'user_id' => $user->id,
                'status' => ShopOrder::STATUS_PENDING,
                'payment_status' => ShopOrder::PAYMENT_PENDING,
                'payment_method' => $request->payment_method,
                'subtotal' => $cartSummary['subtotal'],
                'tax_amount' => $cartSummary['tax_amount'],
                'shipping_amount' => $cartSummary['shipping_cost'],
                'total_amount' => $cartSummary['total'],
                'currency' => 'USD',
                'billing_address' => $billingAddress,
                'shipping_address' => $shippingAddress,
                'notes' => $request->notes
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                ShopOrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product->id,
                    'product_name' => $cartItem->product->name,
                    'product_sku' => $cartItem->product->sku,
                    'product_type' => $cartItem->product->type,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->getPrice(),
                    'total' => $cartItem->getSubtotal()
                ]);

                // Reduce stock for physical products
                if ($cartItem->product->isPhysical()) {
                    $cartItem->product->reduceStock($cartItem->quantity);
                }
            }

            // Create Stripe Checkout Session
            $stripeSession = $this->createStripeCheckoutSession($order, $cartItems);

            $order->update([
                'stripe_session_id' => $stripeSession->id
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'checkout_url' => $stripeSession->url,
                'order_id' => $order->id
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Please check your information and try again.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Checkout process failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Checkout failed. Please try again.'
            ], 500);
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('shop.index')
                ->with('error', 'Invalid checkout session');
        }

        $order = ShopOrder::findByStripeSessionId($sessionId);

        if (!$order || $order->user_id !== auth()->id()) {
            return redirect()->route('shop.index')
                ->with('error', 'Order not found');
        }

        // Clear cart after successful payment
        if ($order->isPaid()) {
            $identifiers = [
                'user_id' => auth()->id(),
                'session_id' => session()->getId()
            ];
            ShopCart::clearCart($identifiers['user_id'], $identifiers['session_id']);
        }

        return view('shop.checkout-success', compact('order'));
    }

    public function cancel(Request $request)
    {
        $sessionId = $request->get('session_id');

        if ($sessionId) {
            $order = ShopOrder::findByStripeSessionId($sessionId);

            if ($order && $order->user_id === auth()->id() && $order->canCancel()) {
                $order->update(['status' => ShopOrder::STATUS_CANCELLED]);

                // Restore stock for cancelled order
                foreach ($order->items as $item) {
                    if ($item->isPhysical()) {
                        $item->product->restoreStock($item->quantity);
                    }
                }
            }
        }

        return redirect()->route('shop.cart')
            ->with('message', 'Checkout was cancelled. Your items are still in your cart.');
    }

    private function createStripeCheckoutSession(ShopOrder $order, $cartItems)
    {
        $lineItems = [];

        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->name,
                        'description' => $item->product->short_description,
                        'images' => [$item->product->getFeaturedImageUrl()],
                        'metadata' => [
                            'product_id' => $item->product->id,
                            'product_type' => $item->product->type,
                            'sku' => $item->product->sku
                        ]
                    ],
                    'unit_amount' => $item->product->getPrice() * 100, // Convert to cents
                ],
                'quantity' => $item->quantity,
            ];
        }

        // Add shipping as line item if applicable
        if ($order->shipping_amount > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Shipping',
                        'description' => 'Standard shipping'
                    ],
                    'unit_amount' => $order->shipping_amount * 100,
                ],
                'quantity' => 1,
            ];
        }

        // Add tax as line item if applicable
        if ($order->tax_amount > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Tax',
                        'description' => 'Sales tax'
                    ],
                    'unit_amount' => $order->tax_amount * 100,
                ],
                'quantity' => 1,
            ];
        }

        $sessionData = [
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('shop.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('shop.checkout.cancel') . '?session_id={CHECKOUT_SESSION_ID}',
            'customer_email' => $order->billing_address['email'],
            'billing_address_collection' => 'auto',
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'user_id' => $order->user_id
            ]
        ];

        // Add shipping address collection for physical products
        if ($order->hasPhysicalProducts()) {
            $sessionData['shipping_address_collection'] = [
                'allowed_countries' => ['US', 'CA', 'GB', 'AU', 'DE', 'FR', 'IT', 'ES']
            ];
        }

        return Session::create($sessionData);
    }

    private function getCartSummary($cartItems)
    {
        $subtotal = $cartItems->sum(function ($item) {
            return $item->getSubtotal();
        });

        $itemsCount = $cartItems->sum('quantity');

        // Calculate shipping
        $hasPhysicalProducts = $cartItems->contains(function ($item) {
            return $item->product->isPhysical();
        });

        $shippingCost = 0;
        if ($hasPhysicalProducts && $subtotal < 100) {
            $shippingCost = 15.00;
        }

        // Calculate tax (8% for physical products)
        $physicalSubtotal = $cartItems->filter(function ($item) {
            return $item->product->isPhysical();
        })->sum(function ($item) {
            return $item->getSubtotal();
        });

        $taxAmount = $physicalSubtotal * 0.08;

        $total = $subtotal + $shippingCost + $taxAmount;

        return [
            'items_count' => $itemsCount,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'has_physical_products' => $hasPhysicalProducts
        ];
    }
}
