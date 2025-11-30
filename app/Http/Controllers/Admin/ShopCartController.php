<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopCart;
use Illuminate\Http\Request;

class ShopCartController extends Controller
{
    public function index(Request $request)
    {
        $query = ShopCart::with(['product', 'user']);

        // Search functionality
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhereHas('product', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $carts = $query->orderBy('created_at', 'desc')->paginate(20);

        // Stats
        $stats = [
            'total_carts' => ShopCart::count(),
            'user_carts' => ShopCart::whereNotNull('user_id')->count(),
            'guest_carts' => ShopCart::whereNull('user_id')->count(),
            'abandoned_carts' => ShopCart::where('created_at', '<', now()->subHours(24))->count(),
            'total_value' => $this->calculateTotalCartValue(),
        ];

        return view('admin.shop.carts.index', compact('carts', 'stats'));
    }

    public function abandoned(Request $request)
    {
        $query = ShopCart::with(['product', 'user'])
                        ->where('created_at', '<', now()->subHours(24));

        // Only show carts older than 24 hours
        if ($request->filled('hours')) {
            $hours = (int) $request->hours;
            $query->where('created_at', '<', now()->subHours($hours));
        }

        $abandonedCarts = $query->orderBy('created_at', 'desc')->paginate(20);

        // Group by user/session
        $groupedCarts = $abandonedCarts->groupBy(function($cart) {
            return $cart->user_id ?: $cart->session_id;
        });

        return view('admin.shop.carts.abandoned', compact('abandonedCarts', 'groupedCarts'));
    }

    public function destroy(ShopCart $cart)
    {
        try {
            $cart->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cart item deleted successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Cart deletion failed', [
                'cart_id' => $cart->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete cart item'
            ], 500);
        }
    }

    private function calculateTotalCartValue(): float
    {
        return ShopCart::with('product')->get()->sum(function($cart) {
            return $cart->product ? $cart->product->getPrice() * $cart->quantity : 0;
        });
    }
}