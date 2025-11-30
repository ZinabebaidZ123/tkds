@extends('admin.layouts.app')

@section('title', 'Blog Analytics')
@section('page-title', 'Blog Analytics')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Blog Analytics</h2>
            <p class="text-gray-600 text-sm mt-1">Monitor your blog performance and insights</p>
        </div>
        <div class="flex items-center space-x-3">
            <select id="periodFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <option value="7">Last 7 Days</option>
                <option value="30" selected>Last 30 Days</option>
                <option value="90">Last 90 Days</option>
                <option value="365">Last Year</option>
            </select>
            <button onclick="refreshData()" class="px-4 py-2 bg-primary hover:bg-secondary text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-sync-alt mr-2"></i>
                Refresh
            </button>
        </div>
    </div>

    <!-- Main Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Posts -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Posts</p>
                    <p class="text-3xl font-bold">{{ number_format($totalPosts) }}</p>
                    <p class="text-blue-200 text-xs mt-1">All time</p>
                </div>
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-newspaper text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Published Posts -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Published</p>
                    <p class="text-3xl font-bold">{{ number_format($publishedPosts) }}</p>
                    <p class="text-green-200 text-xs mt-1">{{ $totalPosts > 0 ? round(($publishedPosts / $totalPosts) * 100, 1) : 0 }}% of total</p>
                </div>
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Draft Posts -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Drafts</p>
                    <p class="text-3xl font-bold">{{ number_format($draftPosts) }}</p>
                    <p class="text-yellow-200 text-xs mt-1">{{ $totalPosts > 0 ? round(($draftPosts / $totalPosts) * 100, 1) : 0 }}% of total</p>
                </div>
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-edit text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Views -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Views</p>
                    <p class="text-3xl font-bold">{{ number_format($totalViews) }}</p>
                    <p class="text-purple-200 text-xs mt-1">All published posts</p>
                </div>
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-eye text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Categories -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Categories</h3>
                <span class="text-2xl font-bold text-primary">{{ $totalCategories }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center">
                    <i class="fas fa-folder text-white text-sm"></i>
                </div>
                <span class="text-gray-600 text-sm">Active categories</span>
            </div>
        </div>

        <!-- Tags -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Tags</h3>
                <span class="text-2xl font-bold text-secondary">{{ $totalTags }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-gradient-to-r from-secondary to-accent rounded-lg flex items-center justify-center">
                    <i class="fas fa-tags text-white text-sm"></i>
                </div>
                <span class="text-gray-600 text-sm">Active tags</span>
            </div>
        </div>

        <!-- Authors -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Authors</h3>
                <span class="text-2xl font-bold text-accent">{{ $totalAuthors }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-gradient-to-r from-accent to-primary rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white text-sm"></i>
                </div>
                <span class="text-gray-600 text-sm">Active authors</span>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Posts Over Time Chart -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Posts Published Over Time</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-primary rounded-full"></div>
                    <span class="text-sm text-gray-600">Published Posts</span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="postsChart"></canvas>
            </div>
        </div>

        <!-- Views Distribution Chart -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Views Distribution</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full"></div>
                    <span class="text-sm text-gray-600">Post Views</span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="viewsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Posts & Popular Posts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Posts -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">Recent Posts</h3>
                    <a href="{{ route('admin.blog.posts.index') }}" class="text-primary hover:text-secondary text-sm font-medium">
                        View All
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentPosts->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentPosts->take(5) as $post)
                            <div class="flex items-start space-x-4 p-4 hover:bg-gray-50 rounded-xl transition-colors duration-200">
                                <img src="{{ $post->getFeaturedImageUrl() }}" 
                                     alt="{{ $post->title }}"
                                     class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-1">
                                        <a href="{{ route('admin.blog.posts.show', $post) }}" class="hover:text-primary">
                                            {{ $post->title }}
                                        </a>
                                    </h4>
                                    <div class="flex items-center space-x-4 text-xs text-gray-500">
                                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                                        @if($post->category)
                                            <span class="px-2 py-1 rounded-full text-xs" 
                                                  style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }};">
                                                {{ $post->category->name }}
                                            </span>
                                        @endif
                                        <span class="px-2 py-1 rounded-full text-xs {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : ($post->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-newspaper text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No posts found</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Popular Posts -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">Most Popular Posts</h3>
                    <a href="{{ route('admin.blog.posts.index', ['sort' => 'popular']) }}" class="text-primary hover:text-secondary text-sm font-medium">
                        View All
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($popularPosts->count() > 0)
                    <div class="space-y-4">
                        @foreach($popularPosts->take(5) as $index => $post)
                            <div class="flex items-start space-x-4 p-4 hover:bg-gray-50 rounded-xl transition-colors duration-200">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    {{ $index + 1 }}
                                </div>
                                <img src="{{ $post->getFeaturedImageUrl() }}" 
                                     alt="{{ $post->title }}"
                                     class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-1">
                                        <a href="{{ route('admin.blog.posts.show', $post) }}" class="hover:text-primary">
                                            {{ $post->title }}
                                        </a>
                                    </h4>
                                    <div class="flex items-center space-x-4 text-xs text-gray-500">
                                        <span><i class="fas fa-eye mr-1"></i>{{ number_format($post->view_count) }}</span>
                                        <span><i class="fas fa-heart mr-1"></i>{{ number_format($post->like_count) }}</span>
                                        <span>{{ $post->published_at ? $post->published_at->format('M d') : 'Draft' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-fire text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No popular posts found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Categories Performance -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Categories Performance</h3>
        </div>
        <div class="p-6">
            @php
                $categoryStats = \App\Models\BlogCategory::active()
                    ->withCount(['posts', 'activePosts'])
                    ->withSum('activePosts', 'view_count')
                    ->orderBy('active_posts_sum_view_count', 'desc')
                    ->limit(10)
                    ->get();
            @endphp
            
            @if($categoryStats->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <th class="pb-4">Category</th>
                                <th class="pb-4">Posts</th>
                                <th class="pb-4">Published</th>
                                <th class="pb-4">Total Views</th>
                                <th class="pb-4">Avg Views</th>
                                <th class="pb-4">Performance</th>
                            </tr>
                        </thead>
                        <tbody class="space-y-2">
                            @foreach($categoryStats as $category)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                                 style="background: linear-gradient(135deg, {{ $category->color }}20, {{ $category->color }}40);">
                                                <i class="{{ $category->icon }}" style="color: {{ $category->color }};"></i>
                                            </div>
                                            <span class="font-medium text-gray-900">{{ $category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-gray-600">{{ $category->posts_count }}</td>
                                    <td class="py-4 text-gray-600">{{ $category->active_posts_count }}</td>
                                    <td class="py-4 text-gray-600">{{ number_format($category->active_posts_sum_view_count ?: 0) }}</td>
                                    <td class="py-4 text-gray-600">
                                        {{ $category->active_posts_count > 0 ? number_format(($category->active_posts_sum_view_count ?: 0) / $category->active_posts_count) : 0 }}
                                    </td>
                                    <td class="py-4">
                                        @php
                                            $performance = $totalViews > 0 ? (($category->active_posts_sum_view_count ?: 0) / $totalViews) * 100 : 0;
                                        @endphp
                                        <div class="flex items-center space-x-2">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                <div class="h-2 rounded-full bg-gradient-to-r from-primary to-secondary" 
                                                     style="width: {{ min(100, $performance * 2) }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-600">{{ number_format($performance, 1) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-chart-bar text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No category data available</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl p-8 text-white">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-bold mb-2">Ready to Create?</h3>
            <p class="text-white/80">Start writing your next amazing blog post</p>
        </div>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('admin.blog.posts.create') }}" 
               class="inline-flex items-center space-x-2 px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl transition-all duration-300 font-medium">
                <i class="fas fa-plus"></i>
                <span>New Post</span>
            </a>
            <a href="{{ route('admin.blog.categories.index') }}" 
               class="inline-flex items-center space-x-2 px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl transition-all duration-300 font-medium">
                <i class="fas fa-folder"></i>
                <span>Manage Categories</span>
            </a>
            <a href="{{ route('admin.blog.authors.index') }}" 
               class="inline-flex items-center space-x-2 px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl transition-all duration-300 font-medium">
                <i class="fas fa-users"></i>
                <span>Manage Authors</span>
            </a>
            <a href="{{ route('admin.blog.tags.index') }}" 
               class="inline-flex items-center space-x-2 px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl transition-all duration-300 font-medium">
                <i class="fas fa-tags"></i>
                <span>Manage Tags</span>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
});

function initializeCharts() {
    // Posts Over Time Chart
    const postsCtx = document.getElementById('postsChart').getContext('2d');
    
    // Sample data - replace with actual data from backend
    const postsData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Posts Published',
            data: [5, 8, 12, 7, 15, 20, 18, 25, 22, 19, 30, 28],
            borderColor: '#C53030',
            backgroundColor: 'rgba(197, 48, 48, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    };

    new Chart(postsCtx, {
        type: 'line',
        data: postsData,
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

    // Views Distribution Chart
    const viewsCtx = document.getElementById('viewsChart').getContext('2d');
    
const viewsData = {
        labels: ['0-100 views', '100-500 views', '500-1K views', '1K-5K views', '5K+ views'],
        datasets: [{
            label: 'Posts',
            data: [15, 25, 18, 12, 8],
            backgroundColor: [
                'rgba(197, 48, 48, 0.8)',
                'rgba(229, 62, 62, 0.8)',
                'rgba(252, 129, 129, 0.8)',
                'rgba(147, 51, 234, 0.8)',
                'rgba(79, 70, 229, 0.8)'
            ],
            borderColor: [
                '#C53030',
                '#E53E3E',
                '#FC8181',
                '#9333EA',
                '#4F46E5'
            ],
            borderWidth: 2
        }]
    };

    new Chart(viewsCtx, {
        type: 'doughnut',
        data: viewsData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
}

// Refresh data function
function refreshData() {
    const refreshBtn = document.querySelector('button[onclick="refreshData()"]');
    const originalText = refreshBtn.innerHTML;
    
    refreshBtn.disabled = true;
    refreshBtn.innerHTML = '<i class="fas fa-sync-alt fa-spin mr-2"></i>Refreshing...';
    
    // Simulate data refresh
    setTimeout(() => {
        refreshBtn.disabled = false;
        refreshBtn.innerHTML = originalText;
        
        // Show success notification
        showNotification('Data refreshed successfully!', 'success');
        
        // You can add actual data refresh logic here
        // location.reload();
    }, 2000);
}

// Period filter change
document.getElementById('periodFilter').addEventListener('change', function() {
    const period = this.value;
    console.log('Period changed to:', period + ' days');
    
    // Add your period filter logic here
    // This would typically make an AJAX request to get filtered data
    
    showNotification(`Filtering data for last ${period} days`, 'info');
});

// Notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Auto-refresh data every 5 minutes
setInterval(() => {
    refreshData();
}, 300000);
</script>
@endpush
