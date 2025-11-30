<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopProduct;
use App\Models\ShopOrder;
use App\Models\ShopCategory;
use App\Models\ShopReview;
use App\Models\User;
use Illuminate\Http\Request;

class ShopDashboardController extends Controller
{
    public function index()
    {
        // Quick Stats
        $stats = [
            'total_products' => ShopProduct::count(),
            'active_products' => ShopProduct::active()->count(),
            'total_orders' => ShopOrder::count(),
            'pending_orders' => ShopOrder::pending()->count(),
            'total_revenue' => ShopOrder::paid()->sum('total_amount'),
            'monthly_revenue' => ShopOrder::paid()
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->sum('total_amount'),
            'total_customers' => User::whereHas('orders')->count(),
            'pending_reviews' => ShopReview::pending()->count(),
            'low_stock_products' => ShopProduct::where('manage_stock', true)
                ->where('stock_quantity', '<=', 5)
                ->count(),
            'out_of_stock_products' => ShopProduct::where('status', 'out_of_stock')->count(),
        ];

        // Recent Orders
        $recentOrders = ShopOrder::with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Top Selling Products
        $topProducts = ShopProduct::withSum('orderItems', 'quantity')
            ->orderBy('order_items_sum_quantity', 'desc')
            ->limit(5)
            ->get();

        // Revenue Chart Data (Last 30 days)
        $revenueChart = ShopOrder::paid()
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.shop.dashboard', compact(
            'stats',
            'recentOrders', 
            'topProducts',
            'revenueChart'
        ));
    }
}