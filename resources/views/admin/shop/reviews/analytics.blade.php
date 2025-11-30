@extends('admin.layouts.app')

@section('title', 'Shop Reviews Analytics')
@section('page-title', 'Shop Reviews Analytics')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.shop.reviews.index') }}" 
               class="p-2 text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Reviews Analytics</h2>
                <p class="text-gray-600 text-sm mt-1">Insights and statistics about customer reviews</p>
            </div>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.shop.reviews.moderation') }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition-colors duration-200">
                <i class="fas fa-clock mr-2"></i>
                Moderation Queue
                @if($stats['pending_reviews'] > 0)
                    <span class="ml-2 bg-yellow-700 text-yellow-100 px-2 py-1 rounded-full text-xs">
                        {{ $stats['pending_reviews'] }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.shop.reviews.export') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Export Data
            </a>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Reviews</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_reviews']) }}</p>
                    <p class="text-blue-200 text-xs mt-1">
                        +{{ $stats['this_month'] }} this month
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Approved Reviews</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['approved_reviews']) }}</p>
                    <p class="text-green-200 text-xs mt-1">
                        {{ $stats['total_reviews'] > 0 ? round(($stats['approved_reviews'] / $stats['total_reviews']) * 100, 1) : 0 }}% approval rate
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Average Rating</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['average_rating'], 1) }}</p>
                    <div class="flex items-center mt-1">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round($stats['average_rating']) ? 'text-yellow-200' : 'text-yellow-400/50' }} text-sm"></i>
                        @endfor
                    </div>
                </div>
                <div class="w-12 h-12 bg-yellow-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star-half-alt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Pending Reviews</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['pending_reviews']) }}</p>
                    <p class="text-purple-200 text-xs mt-1">
                        {{ $stats['total_reviews'] > 0 ? round(($stats['pending_reviews'] / $stats['total_reviews']) * 100, 1) : 0 }}% pending
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-400 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Rating Distribution -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Rating Distribution</h3>
                <div class="text-sm text-gray-500">
                    {{ number_format($stats['approved_reviews']) }} approved reviews
                </div>
            </div>
            
            <div class="space-y-4">
                @foreach([5,4,3,2,1] as $rating)
                    @php
                        $count = $ratingDistribution[$rating]['count'];
                        $percentage = $ratingDistribution[$rating]['percentage'];
                    @endphp
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-1 w-20">
                            <span class="text-sm font-medium text-gray-700">{{ $rating }}</span>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-3">
                                <div class="flex-1 bg-gray-200 rounded-full h-3">
                                    <div class="h-3 rounded-full transition-all duration-500 {{ $rating >= 4 ? 'bg-green-500' : ($rating == 3 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="text-sm text-gray-600 w-16 text-right">
                                    {{ $percentage }}%
                                </div>
                            </div>
                        </div>
                        <div class="text-sm font-medium text-gray-900 w-12 text-right">
                            {{ $count }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Reviews Trend -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Reviews Trend</h3>
                <div class="text-sm text-gray-500">Last 30 days</div>
            </div>
            
            <div class="h-64">
                <canvas id="reviewsTrendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Reviewed Products & Most Active Reviewers -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Top Reviewed Products -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Top Reviewed Products</h3>
                <a href="{{ route('admin.shop.products.index') }}" 
                   class="text-sm text-primary hover:text-secondary font-medium">
                    View All Products →
                </a>
            </div>
            
            <div class="space-y-4">
                @forelse($topReviewedProducts as $product)
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                        <img src="{{ $product->getFeaturedImageUrl() }}" 
                             alt="{{ $product->name }}" 
                             class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-medium text-gray-900 truncate">{{ $product->name }}</h4>
                            <div class="flex items-center space-x-2 mt-1">
                                <div class="flex items-center space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= round($product->reviews_avg_rating) ? 'text-yellow-400' : 'text-gray-300' }} text-xs"></i>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600">
                                    {{ number_format($product->reviews_avg_rating, 1) }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-gray-900">{{ $product->reviews_count }}</div>
                            <div class="text-xs text-gray-500">reviews</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No product reviews yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Most Active Reviewers -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Most Active Reviewers</h3>
                <a href="{{ route('admin.users.index') }}" 
                   class="text-sm text-primary hover:text-secondary font-medium">
                    View All Users →
                </a>
            </div>
            
            <div class="space-y-4">
                @forelse($topReviewers as $reviewer)
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($reviewer->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-medium text-gray-900 truncate">{{ $reviewer->name }}</h4>
                            <p class="text-sm text-gray-600 truncate">{{ $reviewer->email }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-gray-900">{{ $reviewer->shop_reviews_count }}</div>
                            <div class="text-xs text-gray-500">reviews</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No active reviewers yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Reviews -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Recent Reviews</h3>
            <a href="{{ route('admin.shop.reviews.index') }}" 
               class="text-sm text-primary hover:text-secondary font-medium">
                View All Reviews →
            </a>
        </div>
        
        @if($recentReviews->count() > 0)
            <div class="space-y-4">
                @foreach($recentReviews as $review)
                    <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-xl hover:border-primary hover:shadow-md transition-all duration-200">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2 mb-2">
                                <h4 class="font-medium text-gray-900">{{ $review->user->name }}</h4>
                                <span class="text-gray-500">•</span>
                                <div class="flex items-center space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                @php $statusBadge = $review->getStatusBadge() @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusBadge['class'] }}">
                                    {{ $statusBadge['text'] }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-700 mb-2">
                                <span class="font-medium">{{ $review->product->name }}</span>
                                @if($review->title)
                                    - {{ $review->title }}
                                @endif
                            </p>
                            @if($review->comment)
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $review->comment }}</p>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.shop.reviews.show', $review) }}" 
                               class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($review->isPending())
                                <button onclick="quickModerate({{ $review->id }}, 'approved')" 
                                        class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button onclick="quickModerate({{ $review->id }}, 'rejected')" 
                                        class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Reviews Yet</h3>
                <p class="text-gray-500 mb-6">Customer reviews will appear here once they start reviewing products.</p>
                <a href="{{ route('admin.shop.products.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                    <i class="fas fa-cube mr-2"></i>
                    Manage Products
                </a>
            </div>
        @endif
    </div>

    <!-- Performance Insights -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 border border-blue-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-lightbulb text-blue-500 mr-3"></i>
            Review Performance Insights
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Average Response Time -->
            <div class="bg-white rounded-xl p-4 border border-gray-200">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-blue-600"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Response Time</h4>
                        <p class="text-sm text-gray-600">Average moderation speed</p>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900">
                    @if($stats['pending_reviews'] > 0)
                        <span class="text-orange-500">{{ $stats['pending_reviews'] }} pending</span>
                    @else
                        <span class="text-green-500">All caught up!</span>
                    @endif
                </div>
            </div>

            <!-- Review Quality -->
            <div class="bg-white rounded-xl p-4 border border-gray-200">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-star text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Review Quality</h4>
                        <p class="text-sm text-gray-600">Average rating score</p>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900">
                    @if($stats['average_rating'] >= 4)
                        <span class="text-green-500">Excellent</span>
                    @elseif($stats['average_rating'] >= 3)
                        <span class="text-yellow-500">Good</span>
                    @else
                        <span class="text-red-500">Needs Attention</span>
                    @endif
                </div>
            </div>

            <!-- Engagement Rate -->
            <div class="bg-white rounded-xl p-4 border border-gray-200">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-purple-600"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Monthly Growth</h4>
                        <p class="text-sm text-gray-600">This month vs last month</p>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900">
                    @if($stats['this_month'] > 0)
                        <span class="text-green-500">+{{ $stats['this_month'] }}</span>
                    @else
                        <span class="text-gray-500">No new reviews</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Items -->
        @if($stats['pending_reviews'] > 0 || $stats['average_rating'] < 3)
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                <h4 class="font-medium text-yellow-800 mb-2 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Action Items
                </h4>
                <ul class="text-sm text-yellow-700 space-y-1">
                    @if($stats['pending_reviews'] > 0)
                        <li>• {{ $stats['pending_reviews'] }} reviews are pending moderation</li>
                    @endif
                    @if($stats['average_rating'] < 3)
                        <li>• Average rating is below 3.0 - consider investigating product quality</li>
                    @endif
                    @if($stats['rejected_reviews'] > $stats['approved_reviews'] * 0.1)
                        <li>• High rejection rate detected - review moderation guidelines</li>
                    @endif
                </ul>
            </div>
        @endif
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Reviews Trend Chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('reviewsTrendChart').getContext('2d');
    
    const trendData = @json($reviewsTrend);
    const labels = trendData.map(item => {
        const date = new Date(item.date);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    });
    const data = trendData.map(item => item.count);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Reviews per Day',
                data: data,
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3B82F6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
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
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6B7280'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        color: '#6B7280',
                        precision: 0
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});

// Quick moderation functions
function quickModerate(reviewId, action) {
    const actionText = action === 'approved' ? 'approve' : 'reject';
    
    if (confirm(`Are you sure you want to ${actionText} this review?`)) {
        fetch(`{{ route('admin.shop.reviews.index') }}/${reviewId}/quick-moderate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ action: action })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showNotification(`Review ${actionText} successfully!`, 'success');
                
                // Optionally reload the page or update the UI
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(`Failed to ${actionText} review`, 'error');
            }
        })
        .catch(error => {
            showNotification(`Error: ${error.message}`, 'error');
        });
    }
}

// Notification system
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center space-x-2">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Animate out and remove
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Auto-refresh pending count every 30 seconds
setInterval(function() {
    fetch('{{ route("admin.shop.reviews.index") }}?ajax=1')
        .then(response => response.json())
        .then(data => {
            if (data.pending_count !== undefined) {
                // Update any pending count displays
                const pendingElements = document.querySelectorAll('[data-pending-count]');
                pendingElements.forEach(el => {
                    el.textContent = data.pending_count;
                    if (data.pending_count > 0) {
                        el.classList.remove('hidden');
                    } else {
                        el.classList.add('hidden');
                    }
                });
            }
        })
        .catch(error => {
            console.log('Auto-refresh failed:', error);
        });
}, 30000);
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Custom scrollbar for charts */
.chart-container::-webkit-scrollbar {
    height: 6px;
}

.chart-container::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.chart-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.chart-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endsection