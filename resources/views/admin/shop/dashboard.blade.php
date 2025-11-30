{{-- File: resources/views/admin/shop/dashboard.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Shop Dashboard')
@section('page-title', 'Shop Dashboard')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Shop Overview</h2>
            <p class="text-gray-600 text-sm mt-1">Your complete shop performance at a glance</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.shop.products.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Add Product
            </a>
            <a href="{{ route('admin.shop.analytics') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                <i class="fas fa-chart-line mr-2"></i>
                View Analytics
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Revenue</p>
                    <p class="text-3xl font-bold">${{ number_format($stats['total_revenue'], 0) }}</p>
                    <p class="text-green-200 text-xs mt-1">This Month: ${{ number_format($stats['monthly_revenue'], 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-400 rounded-xl flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Orders</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_orders']) }}</p>
                    <p class="text-blue-200 text-xs mt-1">Pending: {{ $stats['pending_orders'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-400 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Products</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_products']) }}</p>
                    <p class="text-purple-200 text-xs mt-1">Active: {{ $stats['active_products'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-400 rounded-xl flex items-center justify-center">
                    <i class="fas fa-cube text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Customers</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_customers']) }}</p>
                    <p class="text-orange-200 text-xs mt-1">Who made purchases</p>
                </div>
                <div class="w-12 h-12 bg-orange-400 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Cards -->
    @if($stats['pending_reviews'] > 0 || $stats['low_stock_products'] > 0 || $stats['out_of_stock_products'] > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @if($stats['pending_reviews'] > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-clock text-yellow-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-yellow-800 font-medium">{{ $stats['pending_reviews'] }} Reviews Pending</p>
                    <p class="text-yellow-700 text-sm">Reviews waiting for moderation</p>
                    <a href="{{ route('admin.shop.reviews.moderation') }}" 
                       class="text-yellow-800 underline text-sm font-medium hover:text-yellow-900">
                        Review Now →
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if($stats['low_stock_products'] > 0)
        <div class="bg-orange-50 border-l-4 border-orange-400 p-4 rounded-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-orange-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-orange-800 font-medium">{{ $stats['low_stock_products'] }} Low Stock Items</p>
                    <p class="text-orange-700 text-sm">Products running low on inventory</p>
                    <a href="{{ route('admin.shop.inventory.low-stock') }}" 
                       class="text-orange-800 underline text-sm font-medium hover:text-orange-900">
                        Check Inventory →
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if($stats['out_of_stock_products'] > 0)
        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-times-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-red-800 font-medium">{{ $stats['out_of_stock_products'] }} Out of Stock</p>
                    <p class="text-red-700 text-sm">Products currently unavailable</p>
                    <a href="{{ route('admin.shop.inventory.index') }}?stock_level=out_of_stock" 
                       class="text-red-800 underline text-sm font-medium hover:text-red-900">
                        Restock Now →
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Charts and Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Revenue Trend (30 Days)</h3>
                <span class="text-sm text-gray-500">Last 30 days</span>
            </div>
            <div class="h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Top Selling Products</h3>
                <a href="{{ route('admin.shop.products.analytics') }}" 
                   class="text-primary hover:text-secondary text-sm font-medium">
                    View All →
                </a>
            </div>
            <div class="space-y-4">
                @forelse($topProducts as $product)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $product->getFeaturedImageUrl() }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-10 h-10 object-cover rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-900 text-sm">{{ Str::limit($product->name, 20) }}</h4>
                                <p class="text-xs text-gray-500">{{ $product->category?->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900 text-sm">{{ $product->order_items_sum_quantity ?? 0 }} sold</p>
                            <p class="text-xs text-gray-500">{{ $product->getFormattedPrice() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-cube text-gray-300 text-3xl mb-2"></i>
                        <p class="text-gray-500">No products sold yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
            <a href="{{ route('admin.shop.orders.index') }}" 
               class="text-primary hover:text-secondary text-sm font-medium">
                View All Orders →
            </a>
        </div>
        
        @if($recentOrders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Items</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.shop.orders.show', $order) }}" 
                                   class="font-medium text-primary hover:text-secondary">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-900">{{ $order->items->count() }} items</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-semibold text-gray-900">{{ $order->getFormattedTotal() }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @php $statusBadge = $order->getStatusBadge() @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusBadge['class'] }}">
                                    {{ $statusBadge['text'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-900">{{ $order->created_at->format('M j, Y') }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-8">
            <i class="fas fa-shopping-cart text-gray-300 text-3xl mb-2"></i>
            <p class="text-gray-500">No orders yet</p>
            <p class="text-gray-400 text-sm">Orders will appear here when customers start purchasing</p>
        </div>
        @endif
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueData = {!! json_encode($revenueChart) !!};

new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: revenueData.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        }),
        datasets: [{
            label: 'Revenue',
            data: revenueData.map(item => item.revenue),
            borderColor: '#C53030',
            backgroundColor: 'rgba(197, 48, 48, 0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#C53030',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        },
        elements: {
            point: {
                hoverRadius: 8
            }
        }
    }
});
</script>
@endsection