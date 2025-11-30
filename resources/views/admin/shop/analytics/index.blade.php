{{-- File: resources/views/admin/shop/analytics.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Shop Analytics')
@section('page-title', 'Shop Analytics')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Shop Analytics</h2>
            <p class="text-gray-600 text-sm mt-1">Track your shop performance and sales</p>
        </div>
        <div class="flex space-x-4">
            <select id="periodFilter" class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                <option value="7">Last 7 Days</option>
                <option value="30" selected>Last 30 Days</option>
                <option value="90">Last 90 Days</option>
                <option value="365">Last Year</option>
            </select>
            <a href="{{ route('admin.shop.analytics.export') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Export Report
            </a>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Revenue</p>
                    <p class="text-3xl font-bold">${{ number_format($stats['total_revenue'], 0) }}</p>
                    <p class="text-blue-200 text-xs mt-1">+12% from last month</p>
                </div>
                <i class="fas fa-dollar-sign text-4xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Orders</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_orders']) }}</p>
                    <p class="text-green-200 text-xs mt-1">+8% from last month</p>
                </div>
                <i class="fas fa-shopping-cart text-4xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Avg Order Value</p>
                    <p class="text-3xl font-bold">${{ number_format($stats['avg_order_value'], 0) }}</p>
                    <p class="text-purple-200 text-xs mt-1">+5% from last month</p>
                </div>
                <i class="fas fa-chart-line text-4xl text-purple-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">New Customers</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['new_customers']) }}</p>
                    <p class="text-orange-200 text-xs mt-1">+15% from last month</p>
                </div>
                <i class="fas fa-users text-4xl text-orange-200"></i>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Revenue Chart -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Revenue Trend</h3>
                <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option>Daily</option>
                    <option>Weekly</option>
                    <option>Monthly</option>
                </select>
            </div>
            <div class="h-80">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Orders Chart -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Orders Overview</h3>
                <div class="flex space-x-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-1"></div>
                        Completed
                    </span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></div>
                        Pending
                    </span>
                </div>
            </div>
            <div class="h-80">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Products & Categories -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Top Products -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Top Selling Products</h3>
            <div class="space-y-4">
                @foreach($topProducts as $product)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $product->getFeaturedImageUrl() }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-12 h-12 object-cover rounded-lg">
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $product->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $product->category?->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">{{ $product->total_sold }} sold</p>
                            <p class="text-sm text-gray-500">${{ number_format($product->total_revenue, 0) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Revenue by Category -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Revenue by Category</h3>
            <div class="space-y-4">
                @foreach($revenueByCategory as $category)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 rounded-full" style="background-color: {{ $category->color ?? '#6366f1' }}"></div>
                            <span class="font-medium text-gray-900">{{ $category->name }}</span>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">${{ number_format($category->revenue, 0) }}</p>
                            <div class="w-24 bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-primary h-2 rounded-full" style="width: {{ ($category->revenue / $totalRevenue) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
            <a href="{{ route('admin.shop.orders.index') }}" 
               class="text-primary hover:text-secondary transition-colors duration-200 text-sm font-medium">
                View All Orders <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
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
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($revenueChartData['labels']) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode($revenueChartData['data']) !!},
            borderColor: '#C53030',
            backgroundColor: 'rgba(197, 48, 48, 0.1)',
            tension: 0.4,
            fill: true
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
                }
            }
        }
    }
});


// Orders Chart
const ordersCtx = document.getElementById('ordersChart').getContext('2d');
new Chart(ordersCtx, {
    type: 'doughnut',
    data: {
        labels: ['Completed', 'Pending', 'Cancelled'],
        datasets: [{
            data: {!! json_encode($ordersChartData) !!},
            backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});


// Period filter functionality
document.getElementById('periodFilter').addEventListener('change', function() {
    const period = this.value;
    window.location.href = `${window.location.pathname}?period=${period}`;
});
</script>
@endsection