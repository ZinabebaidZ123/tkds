<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopProduct;
use App\Models\ShopCart;
use Illuminate\Http\Request;

class ShopCartController extends Controller
{
    private function getCartIdentifiers()
    {
        return [
            'user_id' => auth()->id(),
            'session_id' => session()->getId()
        ];
    }

    public function index()
    {
        $identifiers = $this->getCartIdentifiers();
        $cartItems = ShopCart::getCartItems($identifiers['user_id'], $identifiers['session_id']);
        
        $cartSummary = $this->getCartSummary($cartItems);

        return view('shop.cart', compact('cartItems', 'cartSummary'));
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:shop_products,id',
                'quantity' => 'integer|min:1|max:99'
            ]);

            $product = ShopProduct::find($request->product_id);
            
            if (!$product || !$product->canPurchase()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This product is not available for purchase'
                ]);
            }

            $quantity = $request->get('quantity', 1);
            $identifiers = $this->getCartIdentifiers();

            // Check if product already in cart
            $existingItem = ShopCart::forUserOrSession($identifiers['user_id'], $identifiers['session_id'])
                                   ->where('product_id', $product->id)
                                   ->first();

            if ($existingItem) {
                // Update quantity
                $newQuantity = $existingItem->quantity + $quantity;
                
                if (!$existingItem->canAddQuantity($quantity)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Not enough stock available. Only ' . 
                                    ($product->stock_quantity - $existingItem->quantity) . ' more items can be added.'
                    ]);
                }

                $existingItem->updateQuantity($newQuantity);
                $message = 'Product quantity updated in cart';
            } else {
                // Add new item
                $success = ShopCart::addToCart(
                    $product->id, 
                    $quantity, 
                    $identifiers['user_id'], 
                    $identifiers['session_id']
                );

                if (!$success) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unable to add product to cart. Please check stock availability.'
                    ]);
                }

                $message = 'Product added to cart successfully';
            }

            // Get updated cart info
            $cartCount = ShopCart::getCartCount($identifiers['user_id'], $identifiers['session_id']);
            $cartTotal = ShopCart::getCartTotal($identifiers['user_id'], $identifiers['session_id']);

            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => $cartCount,
                'cart_total' => '$' . number_format($cartTotal, 2),
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->getFormattedPrice(),
                    'image' => $product->getFeaturedImageUrl()
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Cart add error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:shop_products,id',
                'quantity' => 'required|integer|min:0|max:99'
            ]);

            $identifiers = $this->getCartIdentifiers();
            
            $cartItem = ShopCart::forUserOrSession($identifiers['user_id'], $identifiers['session_id'])
                               ->where('product_id', $request->product_id)
                               ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ]);
            }

            $newQuantity = $request->quantity;

            if ($newQuantity == 0) {
                $cartItem->delete();
                $message = 'Item removed from cart';
            } else {
                if (!$cartItem->updateQuantity($newQuantity)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Not enough stock available. Maximum available: ' . $cartItem->product->stock_quantity
                    ]);
                }
                $message = 'Cart updated successfully';
            }

            // Get updated cart info
            $cartItems = ShopCart::getCartItems($identifiers['user_id'], $identifiers['session_id']);
            $cartSummary = $this->getCartSummary($cartItems);

            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_summary' => $cartSummary,
                'cart_count' => $cartSummary['items_count'],
                'item_removed' => $newQuantity == 0
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Cart update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function remove(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:shop_products,id'
            ]);

            $identifiers = $this->getCartIdentifiers();
            
            $removed = ShopCart::removeFromCart(
                $request->product_id,
                $identifiers['user_id'],
                $identifiers['session_id']
            );

            if (!$removed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ]);
            }

            // Get updated cart info
            $cartItems = ShopCart::getCartItems($identifiers['user_id'], $identifiers['session_id']);
            $cartSummary = $this->getCartSummary($cartItems);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_summary' => $cartSummary,
                'cart_count' => $cartSummary['items_count']
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Cart remove error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function clear()
    {
        try {
            $identifiers = $this->getCartIdentifiers();
            
            ShopCart::clearCart($identifiers['user_id'], $identifiers['session_id']);

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'cart_count' => 0,
                'cart_total' => '$0.00'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Cart clear error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function count()
    {
        try {
            $identifiers = $this->getCartIdentifiers();
            $count = ShopCart::getCartCount($identifiers['user_id'], $identifiers['session_id']);

            return response()->json([
                'success' => true,
                'count' => $count
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Cart count error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'count' => 0
            ]);
        }
    }

    public function items()
    {
        try {
            $identifiers = $this->getCartIdentifiers();
            $cartItems = ShopCart::getCartItems($identifiers['user_id'], $identifiers['session_id']);
            
            return response()->json([
                'success' => true,
                'items' => $cartItems->map(function($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product->id,
                        'product_name' => $item->product->name,
                        'product_image' => $item->product->getFeaturedImageUrl(),
                        'product_price' => $item->product->getFormattedPrice(),
                        'product_type' => $item->product->type,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->getFormattedSubtotal(),
                        'can_increase' => $item->canAddQuantity(1),
                        'max_quantity' => $item->product->isSoftware() ? 99 : $item->product->stock_quantity,
                        'product_url' => route('shop.product', $item->product->slug)
                    ];
                }),
                'summary' => $this->getCartSummary($cartItems)
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Cart items error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'items' => [],
                'summary' => $this->getEmptyCartSummary()
            ]);
        }
    }

    // ✅ FIXED: getCartSummary method with proper error handling
    private function getCartSummary($cartItems)
    {
        try {
            $subtotal = $cartItems->sum(function($item) {
                return $item->getSubtotal();
            });

            $itemsCount = $cartItems->sum('quantity');
            
            // Calculate shipping (free for software products or orders over $100)
            $hasPhysicalProducts = $cartItems->contains(function($item) {
                return $item->product->isPhysical();
            });
            
            $shippingCost = 0;
            if ($hasPhysicalProducts && $subtotal < 100) {
                $shippingCost = 15.00; // Flat shipping rate
            }

            // Calculate tax (8% for physical products)
            $physicalSubtotal = $cartItems->filter(function($item) {
                return $item->product->isPhysical();
            })->sum(function($item) {
                return $item->getSubtotal();
            });
            
            $taxAmount = $physicalSubtotal * 0.08; // 8% tax on physical products

            $total = $subtotal + $shippingCost + $taxAmount;

            return [
                'items_count' => $itemsCount,
                'subtotal' => $subtotal,
                'subtotal_formatted' => '$' . number_format($subtotal, 2),
                'shipping_cost' => $shippingCost,
                'shipping_formatted' => $shippingCost > 0 ? '$' . number_format($shippingCost, 2) : 'Free',
                'tax_amount' => $taxAmount,
                'tax_formatted' => '$' . number_format($taxAmount, 2),
                'total' => $total,
                'total_formatted' => '$' . number_format($total, 2),
                'has_physical_products' => $hasPhysicalProducts,
                'free_shipping_eligible' => $subtotal >= 100,
                'free_shipping_remaining' => max(0, 100 - $subtotal)
            ];
        } catch (\Exception $e) {
            \Log::error('Cart summary error: ' . $e->getMessage());
            return $this->getEmptyCartSummary();
        }
    }

    // ✅ NEW: Empty cart summary for error handling
    private function getEmptyCartSummary()
    {
        return [
            'items_count' => 0,
            'subtotal' => 0,
            'subtotal_formatted' => '$0.00',
            'shipping_cost' => 0,
            'shipping_formatted' => 'Free',
            'tax_amount' => 0,
            'tax_formatted' => '$0.00',
            'total' => 0,
            'total_formatted' => '$0.00',
            'has_physical_products' => false,
            'free_shipping_eligible' => false,
            'free_shipping_remaining' => 100
        ];
    }
}