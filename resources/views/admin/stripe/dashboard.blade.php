@extends('admin.layouts.app')

@section('title', 'Stripe Dashboard')
@section('page-title', 'Stripe Analytics & Overview')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Stripe Dashboard</h2>
            <p class="text-gray-600 text-sm mt-1">Payment analytics and subscription management</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.stripe.settings') }}" 
               class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium transition-all duration-200">
                <i class="fas fa-cog mr-2"></i>
                Settings
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Subscribers</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['total_subscribers']) }}</p>
                </div>
                <i class="fas fa-users text-3xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Monthly Revenue</p>
                    <p class="text-2xl font-bold">${{ number_format($stats['monthly_revenue']) }}</p>
                </div>
                <i class="fas fa-chart-line text-3xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Yearly Revenue</p>
                    <p class="text-2xl font-bold">${{ number_format($stats['yearly_revenue']) }}</p>
                </div>
                <i class="fas fa-calendar text-3xl text-purple-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Failed Payments</p>
                    <p class="text-2xl font-bold">{{ $stats['failed_payments'] }}</p>
                </div>
                <i class="fas fa-exclamation-triangle text-3xl text-yellow-200"></i>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Subscription Trends -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Subscription Trends</h3>
                <p class="text-sm text-gray-600">Last 12 months</p>
            </div>
            <div class="p-6">
                <canvas id="subscriptionChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Revenue Trends -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Revenue Trends</h3>
                <p class="text-sm text-gray-600">Last 12 months</p>
            </div>
            <div class="p-6">
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Payments -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="px-6 py-4 border-b">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Payments</h3>
                    <a href="{{ route('admin.stripe.payments') }}" class="text-primary hover:text-secondary text-sm">View All</a>
                </div>
            </div>
            
            @if($recentPayments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentPayments as $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">
                                                {{ substr($payment->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $payment->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $payment->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $payment->getFormattedAmount() }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php $badge = $payment->getStatusBadge() @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badge['class'] }}">
                                            {{ $badge['text'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $payment->processed_at?->format('M j, Y') ?? 'Pending' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-credit-card text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No payments yet</h3>
                    <p class="text-gray-500">Payments will appear here once customers start subscribing.</p>
                </div>
            @endif
        </div>

        <!-- Quick Stats & Actions -->
        <div class="space-y-6">
            
            <!-- Performance Metrics -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Performance</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Success Rate</span>
                        <span class="font-semibold">{{ number_format(100 - ($stats['failed_payments'] / max($stats['successful_payments'], 1) * 100), 1) }}%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Avg Transaction</span>
                        <span class="font-semibold">${{ number_format($stats['average_transaction']) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">New This Month</span>
                        <span class="font-semibold">{{ $stats['new_subscribers_this_month'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.pricing-plans.index') }}" 
                       class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-tags text-primary mr-3"></i>
                            <span class="font-medium">Manage Plans</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                    
                    <a href="{{ route('admin.stripe.subscriptions') }}" 
                       class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-users text-blue-600 mr-3"></i>
                            <span class="font-medium">View Subscriptions</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                    
                    <a href="{{ route('admin.stripe.payments') }}" 
                       class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-credit-card text-green-600 mr-3"></i>
                            <span class="font-medium">Payment History</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Subscription Trends Chart
const subscriptionCtx = document.getElementById('subscriptionChart').getContext('2d');
new Chart(subscriptionCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($subscriptionTrends->pluck('month')) !!},
        datasets: [{
            label: 'New Subscriptions',
            data: {!! json_encode($subscriptionTrends->pluck('count')) !!},
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
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Revenue Trends Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($revenueTrends->pluck('month')) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode($revenueTrends->pluck('amount')) !!},
            backgroundColor: 'rgba(16, 185, 129, 0.8)',
            borderColor: '#10b981',
            borderWidth: 1
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
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                },
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>
@endpush