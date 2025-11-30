<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopOrder;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use App\Models\User;
use App\Models\ShopReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', '30'); // days
        $startDate = now()->subDays($period);
        $endDate = now();

        // Overview Statistics
        $stats = $this->getOverviewStats($startDate, $endDate);
        
        // Revenue Analytics
        $revenueData = $this->getRevenueAnalytics($startDate, $endDate);
        
        // Product Analytics
        $productData = $this->getProductAnalytics($startDate, $endDate);
        
        // Customer Analytics
        $customerData = $this->getCustomerAnalytics($startDate, $endDate);
        
        // Order Analytics
        $orderData = $this->getOrderAnalytics($startDate, $endDate);

        // Top Products - FIXED QUERY
        $topProducts = ShopProduct::select([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.featured_image',
                'shop_products.price',
                'shop_products.category_id'
            ])
            ->join('shop_order_items', 'shop_products.id', '=', 'shop_order_items.product_id')
            ->join('shop_orders', 'shop_order_items.order_id', '=', 'shop_orders.id')
            ->where('shop_orders.payment_status', 'paid')
            ->whereBetween('shop_orders.created_at', [$startDate, $endDate])
            ->groupBy([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.featured_image',
                'shop_products.price',
                'shop_products.category_id'
            ])
            ->selectRaw('SUM(shop_order_items.quantity) as total_sold, SUM(shop_order_items.total) as total_revenue')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->with('category')
            ->get();

        // Revenue by Category - FIXED QUERY
        $revenueByCategory = ShopCategory::select([
                'shop_categories.id',
                'shop_categories.name'
            ])
            ->join('shop_products', 'shop_categories.id', '=', 'shop_products.category_id')
            ->join('shop_order_items', 'shop_products.id', '=', 'shop_order_items.product_id')
            ->join('shop_orders', 'shop_order_items.order_id', '=', 'shop_orders.id')
            ->where('shop_orders.payment_status', 'paid')
            ->whereBetween('shop_orders.created_at', [$startDate, $endDate])
            ->groupBy('shop_categories.id', 'shop_categories.name')
            ->selectRaw('SUM(shop_order_items.total) as revenue, COUNT(shop_order_items.id) as orders')
            ->orderBy('revenue', 'desc')
            ->get();

        // Calculate total revenue for percentage calculation
        $totalRevenue = $revenueByCategory->sum('revenue');

        // Recent Orders
        $recentOrders = ShopOrder::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Prepare chart data
        $revenueChartData = [
            'labels' => $revenueData['daily_revenue']->pluck('date')->map(function($date) {
                return \Carbon\Carbon::parse($date)->format('M j');
            }),
            'data' => $revenueData['daily_revenue']->pluck('revenue')
        ];

        $ordersChartData = [
            $orderData['orders_by_status']['completed'] ?? 0,
            $orderData['orders_by_status']['pending'] ?? 0,
            $orderData['orders_by_status']['cancelled'] ?? 0
        ];

        return view('admin.shop.analytics.index', compact(
            'stats', 'revenueData', 'productData', 'customerData', 
            'orderData', 'period', 'topProducts', 'revenueByCategory',
            'totalRevenue', 'recentOrders', 'revenueChartData', 'ordersChartData'
        ));
    }

    public function revenue(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = now()->subDays($period);
        $endDate = now();

        // Daily revenue for chart
        $dailyRevenue = ShopOrder::paid()
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Monthly revenue comparison
        $monthlyRevenue = ShopOrder::paid()
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        // Revenue by payment method
        $revenueByPaymentMethod = ShopOrder::paid()
            ->selectRaw('payment_method, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('payment_method')
            ->orderBy('revenue', 'desc')
            ->get();

        // Revenue by category - FIXED QUERY
        $revenueByCategory = DB::table('shop_orders')
            ->join('shop_order_items', 'shop_orders.id', '=', 'shop_order_items.order_id')
            ->join('shop_products', 'shop_order_items.product_id', '=', 'shop_products.id')
            ->join('shop_categories', 'shop_products.category_id', '=', 'shop_categories.id')
            ->where('shop_orders.payment_status', 'paid')
            ->whereBetween('shop_orders.created_at', [$startDate, $endDate])
            ->select([
                'shop_categories.id',
                'shop_categories.name',
                DB::raw('SUM(shop_order_items.total) as revenue'),
                DB::raw('COUNT(shop_order_items.id) as orders')
            ])
            ->groupBy('shop_categories.id', 'shop_categories.name')
            ->orderBy('revenue', 'desc')
            ->get();

        // Average order value trend
        $avgOrderValue = ShopOrder::paid()
            ->selectRaw('DATE(created_at) as date, AVG(total_amount) as avg_value')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        return view('admin.shop.analytics.revenue', compact(
            'dailyRevenue', 'monthlyRevenue', 'revenueByPaymentMethod', 
            'revenueByCategory', 'avgOrderValue', 'period'
        ));
    }

    public function products(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = now()->subDays($period);
        $endDate = now();

        // Best selling products - FIXED QUERY
        $bestSelling = ShopProduct::select([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.featured_image',
                'shop_products.price',
                'shop_products.category_id'
            ])
            ->join('shop_order_items', 'shop_products.id', '=', 'shop_order_items.product_id')
            ->join('shop_orders', 'shop_order_items.order_id', '=', 'shop_orders.id')
            ->where('shop_orders.payment_status', 'paid')
            ->whereBetween('shop_orders.created_at', [$startDate, $endDate])
            ->groupBy([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.featured_image',
                'shop_products.price',
                'shop_products.category_id'
            ])
            ->selectRaw('SUM(shop_order_items.quantity) as total_sold, SUM(shop_order_items.total) as total_revenue')
            ->orderBy('total_sold', 'desc')
            ->limit(20)
            ->with('category')
            ->get();

        // Most revenue generating products - FIXED QUERY
        $topRevenue = ShopProduct::select([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.featured_image',
                'shop_products.price',
                'shop_products.category_id'
            ])
            ->join('shop_order_items', 'shop_products.id', '=', 'shop_order_items.product_id')
            ->join('shop_orders', 'shop_order_items.order_id', '=', 'shop_orders.id')
            ->where('shop_orders.payment_status', 'paid')
            ->whereBetween('shop_orders.created_at', [$startDate, $endDate])
            ->groupBy([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.featured_image',
                'shop_products.price',
                'shop_products.category_id'
            ])
            ->selectRaw('SUM(shop_order_items.total) as total_revenue, SUM(shop_order_items.quantity) as total_sold')
            ->orderBy('total_revenue', 'desc')
            ->limit(20)
            ->with('category')
            ->get();

        // Low performing products - FIXED QUERY
        $lowPerforming = ShopProduct::where('status', 'active')
            ->leftJoin(DB::raw('(
                SELECT shop_order_items.product_id, SUM(shop_order_items.quantity) as total_sold
                FROM shop_order_items
                INNER JOIN shop_orders ON shop_order_items.order_id = shop_orders.id
                WHERE shop_orders.payment_status = "paid"
                AND shop_orders.created_at BETWEEN "' . $startDate . '" AND "' . $endDate . '"
                GROUP BY shop_order_items.product_id
            ) as sales'), 'shop_products.id', '=', 'sales.product_id')
            ->select([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.featured_image',
                'shop_products.price',
                'shop_products.category_id',
                DB::raw('COALESCE(sales.total_sold, 0) as total_sold')
            ])
            ->orderBy('total_sold', 'asc')
            ->limit(20)
            ->with('category')
            ->get();

        // Product views vs sales - FIXED QUERY
        $viewsVsSales = ShopProduct::select([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.featured_image',
                'shop_products.price',
                'shop_products.category_id',
                'shop_products.views_count'
            ])
            ->leftJoin(DB::raw('(
                SELECT shop_order_items.product_id, SUM(shop_order_items.quantity) as total_sold
                FROM shop_order_items
                INNER JOIN shop_orders ON shop_order_items.order_id = shop_orders.id
                WHERE shop_orders.payment_status = "paid"
                AND shop_orders.created_at BETWEEN "' . $startDate . '" AND "' . $endDate . '"
                GROUP BY shop_order_items.product_id
            ) as sales'), 'shop_products.id', '=', 'sales.product_id')
            ->selectRaw('
                COALESCE(sales.total_sold, 0) as total_sold,
                CASE 
                    WHEN shop_products.views_count > 0 
                    THEN ROUND((COALESCE(sales.total_sold, 0) / shop_products.views_count) * 100, 2) 
                    ELSE 0 
                END as conversion_rate
            ')
            ->orderBy('conversion_rate', 'desc')
            ->limit(20)
            ->with('category')
            ->get();

        // Category performance - FIXED QUERY
        $categoryPerformance = ShopCategory::select([
                'shop_categories.id',
                'shop_categories.name'
            ])
            ->join('shop_products', 'shop_categories.id', '=', 'shop_products.category_id')
            ->join('shop_order_items', 'shop_products.id', '=', 'shop_order_items.product_id')
            ->join('shop_orders', 'shop_order_items.order_id', '=', 'shop_orders.id')
            ->where('shop_orders.payment_status', 'paid')
            ->whereBetween('shop_orders.created_at', [$startDate, $endDate])
            ->groupBy('shop_categories.id', 'shop_categories.name')
            ->selectRaw('
                SUM(shop_order_items.quantity) as total_sold,
                SUM(shop_order_items.total) as total_revenue,
                COUNT(DISTINCT shop_products.id) as products_sold
            ')
            ->orderBy('total_revenue', 'desc')
            ->get();

        return view('admin.shop.analytics.products', compact(
            'bestSelling', 'topRevenue', 'lowPerforming', 
            'viewsVsSales', 'categoryPerformance', 'period'
        ));
    }

    public function customers(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = now()->subDays($period);
        $endDate = now();

        // Top customers by revenue - FIXED QUERY
        $topCustomers = User::select([
                'users.id',
                'users.name',
                'users.email',
                'users.created_at'
            ])
            ->join('shop_orders', 'users.id', '=', 'shop_orders.user_id')
            ->where('shop_orders.payment_status', 'paid')
            ->whereBetween('shop_orders.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
            ->selectRaw('
                SUM(shop_orders.total_amount) as total_spent,
                COUNT(shop_orders.id) as total_orders,
                AVG(shop_orders.total_amount) as avg_order_value
            ')
            ->orderBy('total_spent', 'desc')
            ->limit(20)
            ->get();

        // New customers trend
        $newCustomers = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Customer lifetime value - FIXED QUERY
        $customerLTV = User::select([
                'users.id',
                'users.name',
                'users.email',
                'users.created_at'
            ])
            ->join('shop_orders', 'users.id', '=', 'shop_orders.user_id')
            ->where('shop_orders.payment_status', 'paid')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
            ->selectRaw('
                SUM(shop_orders.total_amount) as lifetime_value,
                COUNT(shop_orders.id) as total_orders,
                MIN(shop_orders.created_at) as first_order_date,
                MAX(shop_orders.created_at) as last_order_date
            ')
            ->orderBy('lifetime_value', 'desc')
            ->limit(50)
            ->get();

        // Customer segmentation
        $customerSegments = $this->getCustomerSegmentation($startDate, $endDate);

        // Repeat customers - FIXED QUERY
        $repeatCustomers = User::select([
                'users.id',
                'users.name',
                'users.email',
                'users.created_at'
            ])
            ->join('shop_orders', 'users.id', '=', 'shop_orders.user_id')
            ->where('shop_orders.payment_status', 'paid')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
            ->selectRaw('COUNT(shop_orders.id) as order_count')
            ->having('order_count', '>', 1)
            ->orderBy('order_count', 'desc')
            ->limit(20)
            ->get();

        // Customer acquisition by month
        $customerAcquisition = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        return view('admin.shop.analytics.customers', compact(
            'topCustomers', 'newCustomers', 'customerLTV', 'customerSegments',
            'repeatCustomers', 'customerAcquisition', 'period'
        ));
    }

    public function inventory(Request $request)
    {
        // Low stock products
        $lowStock = ShopProduct::where('manage_stock', true)
            ->where('stock_quantity', '<=', 5)
            ->where('stock_quantity', '>', 0)
            ->with('category')
            ->orderBy('stock_quantity', 'asc')
            ->get();

        // Out of stock products
        $outOfStock = ShopProduct::where(function($q) {
                $q->where('status', 'out_of_stock')
                  ->orWhere(function($q2) {
                      $q2->where('manage_stock', true)
                         ->where('stock_quantity', 0);
                  });
            })
            ->with('category')
            ->get();

        // Stock movement - FIXED QUERY
        $stockMovement = ShopProduct::where('manage_stock', true)
            ->with('category')
            ->leftJoin(DB::raw('(
                SELECT shop_order_items.product_id, SUM(shop_order_items.quantity) as total_sold
                FROM shop_order_items
                INNER JOIN shop_orders ON shop_order_items.order_id = shop_orders.id
                WHERE shop_orders.payment_status = "paid"
                AND shop_orders.created_at >= "' . now()->subDays(30) . '"
                GROUP BY shop_order_items.product_id
            ) as sales'), 'shop_products.id', '=', 'sales.product_id')
            ->select([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.featured_image',
                'shop_products.price',
                'shop_products.stock_quantity',
                'shop_products.category_id',
                DB::raw('COALESCE(sales.total_sold, 0) as order_items_sum_quantity')
            ])
            ->orderBy('order_items_sum_quantity', 'desc')
            ->get();

        // Inventory value
        $inventoryValue = [
            'total_products' => ShopProduct::where('status', 'active')->count(),
            'total_value' => ShopProduct::where('status', 'active')->sum(DB::raw('price * COALESCE(stock_quantity, 1)')),
            'low_stock_count' => $lowStock->count(),
            'out_of_stock_count' => $outOfStock->count(),
            'physical_products' => ShopProduct::where('type', 'physical')->where('status', 'active')->count(),
            'digital_products' => ShopProduct::where('type', 'software')->where('status', 'active')->count(),
        ];

        return view('admin.shop.analytics.inventory', compact(
            'lowStock', 'outOfStock', 'stockMovement', 'inventoryValue'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'overview');
        $period = $request->get('period', '30');
        $startDate = now()->subDays($period);
        $endDate = now();

        switch ($type) {
            case 'revenue':
                return $this->exportRevenue($startDate, $endDate);
            case 'products':
                return $this->exportProducts($startDate, $endDate);
            case 'customers':
                return $this->exportCustomers($startDate, $endDate);
            default:
                return $this->exportOverview($startDate, $endDate);
        }
    }

    // Helper Methods

    private function getOverviewStats($startDate, $endDate): array
    {
        return [
            'total_revenue' => ShopOrder::paid()->whereBetween('created_at', [$startDate, $endDate])->sum('total_amount'),
            'total_orders' => ShopOrder::whereBetween('created_at', [$startDate, $endDate])->count(),
            'avg_order_value' => ShopOrder::paid()->whereBetween('created_at', [$startDate, $endDate])->avg('total_amount'),
            'new_customers' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_products_sold' => DB::table('shop_order_items')
                ->join('shop_orders', 'shop_order_items.order_id', '=', 'shop_orders.id')
                ->where('shop_orders.payment_status', 'paid')
                ->whereBetween('shop_orders.created_at', [$startDate, $endDate])
                ->sum('shop_order_items.quantity'),
            'conversion_rate' => $this->calculateConversionRate($startDate, $endDate),
        ];
    }

    private function getRevenueAnalytics($startDate, $endDate): array
    {
        return [
            'daily_revenue' => ShopOrder::paid()
                ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get(),
            'revenue_by_category' => DB::table('shop_orders')
                ->join('shop_order_items', 'shop_orders.id', '=', 'shop_order_items.order_id')
                ->join('shop_products', 'shop_order_items.product_id', '=', 'shop_products.id')
                ->join('shop_categories', 'shop_products.category_id', '=', 'shop_categories.id')
                ->where('shop_orders.payment_status', 'paid')
                ->whereBetween('shop_orders.created_at', [$startDate, $endDate])
                ->select([
                    'shop_categories.id',
                    'shop_categories.name',
                    DB::raw('SUM(shop_order_items.total) as revenue')
                ])
                ->groupBy('shop_categories.id', 'shop_categories.name')
                ->orderBy('revenue', 'desc')
                ->get(),
        ];
    }

    private function getProductAnalytics($startDate, $endDate): array
    {
        $bestSellers = ShopProduct::select([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.featured_image',
                'shop_products.price',
                'shop_products.category_id'
            ])
            ->join('shop_order_items', 'shop_products.id', '=', 'shop_order_items.product_id')
            ->join('shop_orders', 'shop_order_items.order_id', '=', 'shop_orders.id')
            ->where('shop_orders.payment_status', 'paid')
            ->whereBetween('shop_orders.created_at', [$startDate, $endDate])
            ->groupBy([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.featured_image',
                'shop_products.price',
                'shop_products.category_id'
            ])
            ->selectRaw('SUM(shop_order_items.quantity) as total_sold')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        return [
            'best_sellers' => $bestSellers,
            'low_stock' => ShopProduct::where('manage_stock', true)
                ->where('stock_quantity', '<=', 5)
                ->where('stock_quantity', '>', 0)
                ->count(),
        ];
    }

    private function getCustomerAnalytics($startDate, $endDate): array
    {
        return [
            'new_customers' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'repeat_customers' => User::whereHas('orders', function($q) use ($startDate, $endDate) {
                $q->where('payment_status', 'paid')
                  ->whereBetween('created_at', [$startDate, $endDate]);
            })->withCount(['orders' => function($q) {
                $q->where('payment_status', 'paid');
            }])->having('orders_count', '>', 1)->count(),
        ];
    }

    private function getOrderAnalytics($startDate, $endDate): array
    {
        return [
            'orders_by_status' => ShopOrder::selectRaw('status, COUNT(*) as count')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray(),
            'daily_orders' => ShopOrder::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get(),
        ];
    }

    private function getCustomerSegmentation($startDate, $endDate): array
    {
        $segments = [
            'high_value' => User::whereHas('orders', function($q) {
                $q->where('payment_status', 'paid');
            })->withSum(['orders' => function($q) {
                $q->where('payment_status', 'paid');
            }], 'total_amount')->having('orders_sum_total_amount', '>', 1000)->count(),
            
            'medium_value' => User::whereHas('orders', function($q) {
                $q->where('payment_status', 'paid');
            })->withSum(['orders' => function($q) {
                $q->where('payment_status', 'paid');
            }], 'total_amount')->havingBetween('orders_sum_total_amount', [100, 1000])->count(),
            
            'low_value' => User::whereHas('orders', function($q) {
                $q->where('payment_status', 'paid');
            })->withSum(['orders' => function($q) {
                $q->where('payment_status', 'paid');
            }], 'total_amount')->having('orders_sum_total_amount', '<', 100)->count(),
        ];

        return $segments;
    }

    private function calculateConversionRate($startDate, $endDate): float
    {
        $totalVisitors = 1000; // You'll need to implement visitor tracking
        $totalOrders = ShopOrder::paid()->whereBetween('created_at', [$startDate, $endDate])->count();
        
        return $totalVisitors > 0 ? round(($totalOrders / $totalVisitors) * 100, 2) : 0;
    }

    private function exportOverview($startDate, $endDate)
    {
        $stats = $this->getOverviewStats($startDate, $endDate);
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="shop-overview-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($stats) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['Metric', 'Value']);
            
            foreach ($stats as $key => $value) {
                fputcsv($file, [ucwords(str_replace('_', ' ', $key)), $value]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportRevenue($startDate, $endDate)
    {
        $revenue = ShopOrder::paid()
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="revenue-report-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($revenue) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['Date', 'Revenue', 'Orders']);
            
            foreach ($revenue as $row) {
                fputcsv($file, [$row->date, $row->revenue, $row->orders]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportProducts($startDate, $endDate)
    {
        $products = ShopProduct::select([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.price',
                'shop_products.stock_quantity',
                'shop_products.category_id'
            ])
            ->leftJoin(DB::raw('(
                SELECT shop_order_items.product_id, SUM(shop_order_items.quantity) as total_sold
                FROM shop_order_items
                INNER JOIN shop_orders ON shop_order_items.order_id = shop_orders.id
                WHERE shop_orders.payment_status = "paid"
                AND shop_orders.created_at BETWEEN "' . $startDate . '" AND "' . $endDate . '"
                GROUP BY shop_order_items.product_id
            ) as sales'), 'shop_products.id', '=', 'sales.product_id')
            ->with('category')
            ->selectRaw('COALESCE(sales.total_sold, 0) as total_sold')
            ->orderBy('total_sold', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products-report-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['Product Name', 'Category', 'Price', 'Stock', 'Units Sold']);
            
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->name,
                    $product->category?->name,
                    $product->price,
                    $product->stock_quantity,
                    $product->total_sold
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportCustomers($startDate, $endDate)
    {
        $customers = User::select([
                'users.id',
                'users.name',
                'users.email',
                'users.created_at'
            ])
            ->leftJoin(DB::raw('(
                SELECT shop_orders.user_id, 
                       SUM(CASE WHEN shop_orders.payment_status = "paid" THEN shop_orders.total_amount ELSE 0 END) as total_spent,
                       COUNT(CASE WHEN shop_orders.payment_status = "paid" THEN shop_orders.id END) as total_orders
                FROM shop_orders
                GROUP BY shop_orders.user_id
            ) as order_stats'), 'users.id', '=', 'order_stats.user_id')
            ->selectRaw('
                COALESCE(order_stats.total_spent, 0) as total_spent,
                COALESCE(order_stats.total_orders, 0) as total_orders
            ')
            ->orderBy('total_spent', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="customers-report-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($customers) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['Name', 'Email', 'Total Orders', 'Total Spent', 'Joined Date']);
            
            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer->name,
                    $customer->email,
                    $customer->total_orders,
                    $customer->total_spent,
                    $customer->created_at->format('Y-m-d')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}