<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ShopOrder;
use App\Models\ShopDownload;
use App\Models\ShopReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopOrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Build query
        $query = ShopOrder::where('user_id', $user->id)
            ->with(['items.product']);

        // Apply status filter if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get orders with pagination
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calculate stats
        $stats = [
            'total_orders' => ShopOrder::where('user_id', $user->id)->count(),
            'completed_orders' => ShopOrder::where('user_id', $user->id)
                ->whereIn('status', ['delivered', 'shipped'])
                ->count(),
            'total_spent' => ShopOrder::where('user_id', $user->id)
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
            'total_downloads' => ShopDownload::where('user_id', $user->id)->count(),
        ];

        return view('user.orders.index', compact('orders', 'stats'));
    }

    public function show(ShopOrder $order)
    {
        // Check if user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        $order->load(['items.product', 'downloads']);

        // Get downloadable items
        $downloadableItems = $order->items()->where('product_type', 'software')->get();

        // Get reviews for this order's products
        $reviewedProductIds = ShopReview::where('user_id', auth()->id())
            ->where('order_id', $order->id)
            ->pluck('product_id')
            ->toArray();

        return view('user.orders.show', compact('order', 'downloadableItems', 'reviewedProductIds'));
    }

    public function cancel(ShopOrder $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if (!$order->canCancel()) {
            return response()->json([
                'success' => false,
                'message' => 'This order cannot be cancelled'
            ]);
        }

        try {
            $order->update(['status' => ShopOrder::STATUS_CANCELLED]);

            // Restore stock for cancelled items
            foreach ($order->items as $item) {
                if ($item->product && $item->isPhysical()) {
                    $item->product->restoreStock($item->quantity);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Order cancellation failed', [
                'order_id' => $order->id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order. Please contact support.'
            ], 500);
        }
    }

    public function reorder(ShopOrder $order)
    {
        // Check if order belongs to authenticated user
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $addedItems = [];
        $unavailableItems = [];

        foreach ($order->items as $item) {
            $product = $item->product;

            if (!$product || !$product->canPurchase()) {
                $unavailableItems[] = [
                    'name' => $item->product_name,
                    'reason' => 'Product no longer available'
                ];
                continue;
            }

            // Try to add to cart
            $success = \App\Models\ShopCart::addToCart(
                $product->id,
                $item->quantity,
                Auth::id(),
                session()->getId()
            );

            if ($success) {
                $addedItems[] = $item->product_name;
            } else {
                $unavailableItems[] = [
                    'name' => $item->product_name,
                    'reason' => 'Insufficient stock'
                ];
            }
        }

        $message = count($addedItems) > 0
            ? count($addedItems) . ' items added to cart'
            : 'No items could be added to cart';

        return response()->json([
            'success' => count($addedItems) > 0,
            'message' => $message,
            'added_items' => $addedItems,
            'unavailable_items' => $unavailableItems
        ]);
    }

    public function downloadInvoice(ShopOrder $order)
    {
        // Check if order belongs to authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if order is paid
        if (!$order->isPaid()) {
            abort(404, 'Invoice not available');
        }

        // Generate PDF invoice (you'd implement this based on your needs)
        // For now, redirect to a simple invoice view
        return view('user.orders.invoice', compact('order'));
    }

    public function trackOrder(ShopOrder $order)
    {
        // Check if order belongs to authenticated user
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $tracking = [
            'order_number' => $order->order_number,
            'status' => $order->status,
            'tracking_number' => $order->tracking_number ?? null,
            'estimated_delivery' => null, // You'd calculate this based on shipping method
            'timeline' => [
                [
                    'status' => 'Order Placed',
                    'date' => $order->created_at,
                    'completed' => true
                ],
                [
                    'status' => 'Payment Confirmed',
                    'date' => $order->isPaid() ? $order->created_at : null,
                    'completed' => $order->isPaid()
                ],
                [
                    'status' => 'Processing',
                    'date' => $order->isProcessing() ? $order->updated_at : null,
                    'completed' => in_array($order->status, ['processing', 'shipped', 'delivered'])
                ],
                [
                    'status' => 'Shipped',
                    'date' => $order->shipped_at,
                    'completed' => in_array($order->status, ['shipped', 'delivered'])
                ],
                [
                    'status' => 'Delivered',
                    'date' => $order->delivered_at,
                    'completed' => $order->isDelivered()
                ]
            ]
        ];

        return response()->json([
            'success' => true,
            'tracking' => $tracking
        ]);
    }

    public function requestReturn(ShopOrder $order, Request $request)
    {
        // Check if order belongs to authenticated user
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Check if order can be returned
        if (!$order->canRefund()) {
            return response()->json([
                'success' => false,
                'message' => 'This order cannot be returned'
            ]);
        }

        $request->validate([
            'reason' => 'required|string|max:500',
            'items' => 'array'
        ]);

        // In a real app, you'd create a return request record
        // For now, just return success
        return response()->json([
            'success' => true,
            'message' => 'Return request submitted successfully. We will contact you within 24 hours.'
        ]);
    }

    public function leaveReview(ShopOrder $order, Request $request)
    {
        // Check if order belongs to authenticated user
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'product_id' => 'required|exists:shop_products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|max:1000'
        ]);

        // Check if user purchased this product
        $orderItem = $order->items()
            ->where('product_id', $request->product_id)
            ->first();

        if (!$orderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in this order'
            ]);
        }

        // Check if user already reviewed this product
        $existingReview = ShopReview::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product'
            ]);
        }

        // Create review
        ShopReview::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully! It will be published after approval.'
        ]);
    }
}
