@extends('admin.layouts.app')

@section('title', 'Review Moderation Queue')
@section('page-title', 'Review Moderation Queue')

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
                <h2 class="text-2xl font-bold text-gray-900">Review Moderation Queue</h2>
                <p class="text-gray-600 text-sm mt-1">{{ $pendingReviews->total() }} reviews pending approval</p>
            </div>
        </div>
        <div class="flex space-x-4">
            @if($pendingReviews->count() > 0)
                <button onclick="bulkApprove()" 
                        class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200">
                    <i class="fas fa-check-double mr-2"></i>
                    Approve All
                </button>
                <button onclick="bulkReject()" 
                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-200">
                    <i class="fas fa-times-circle mr-2"></i>
                    Reject All
                </button>
            @endif
            <a href="{{ route('admin.shop.reviews.analytics') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors duration-200">
                <i class="fas fa-chart-bar mr-2"></i>
                Analytics
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    @if($pendingReviews->count() > 0)
        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-400 p-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-clock text-yellow-500 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-yellow-800 font-bold text-lg">⏰ Reviews Awaiting Moderation</h3>
                    <p class="text-yellow-700 mt-1">
                        <strong>{{ $pendingReviews->total() }}</strong> reviews are waiting for your approval. 
                        Quick moderate them below to maintain customer engagement.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Moderation Queue -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        @if($pendingReviews->count() > 0)
            <!-- Bulk Actions Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" id="selectAll" 
                               class="w-5 h-5 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2">
                        <label for="selectAll" class="text-sm font-medium text-gray-700">Select All</label>
                        <span class="text-sm text-gray-500">({{ $pendingReviews->count() }} reviews on this page)</span>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="bulkApproveSelected()" 
                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200 disabled:opacity-50"
                                id="bulkApproveBtn" disabled>
                            <i class="fas fa-check mr-2"></i>
                            Approve Selected
                        </button>
                        <button onclick="bulkRejectSelected()" 
                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 disabled:opacity-50"
                                id="bulkRejectBtn" disabled>
                            <i class="fas fa-times mr-2"></i>
                            Reject Selected
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="divide-y divide-gray-100">
                @foreach($pendingReviews as $review)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200" data-review-id="{{ $review->id }}">
                        <div class="flex items-start space-x-4">
                            <!-- Selection Checkbox -->
                            <div class="flex-shrink-0 pt-1">
                                <input type="checkbox" class="review-checkbox w-5 h-5 text-primary bg-gray-100 border-gray-300 rounded" 
                                       value="{{ $review->id }}">
                            </div>

                            <!-- Customer Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                            </div>

                            <!-- Review Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <!-- Customer Info -->
                                        <div class="flex items-center space-x-4 mb-3">
                                            <h4 class="text-lg font-semibold text-gray-900">{{ $review->user->name }}</h4>
                                            <span class="text-sm text-gray-500">{{ $review->user->email }}</span>
                                            <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>

                                        <!-- Product Info -->
                                        <div class="flex items-center space-x-3 mb-4">
                                            <img src="{{ $review->product->getFeaturedImageUrl() }}" 
                                                 alt="{{ $review->product->name }}" 
                                                 class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                            <div>
                                                <h5 class="font-medium text-gray-900">{{ $review->product->name }}</h5>
                                                <p class="text-sm text-gray-600">{{ $review->product->category?->name }}</p>
                                            </div>
                                        </div>

                                        <!-- Rating -->
                                        <div class="flex items-center space-x-2 mb-3">
                                            <div class="flex items-center space-x-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-lg"></i>
                                                @endfor
                                            </div>
                                            <span class="text-lg font-semibold text-gray-900">{{ $review->rating }}/5</span>
                                            <span class="text-sm text-gray-500">
                                                ({{ $review->rating == 5 ? 'Excellent' : ($review->rating == 4 ? 'Good' : ($review->rating == 3 ? 'Average' : ($review->rating == 2 ? 'Poor' : 'Very Poor'))) }})
                                            </span>
                                        </div>

                                        <!-- Review Title -->
                                        @if($review->title)
                                            <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $review->title }}</h3>
                                        @endif

                                        <!-- Review Content -->
                                        @if($review->comment)
                                            <div class="bg-gray-50 rounded-xl p-4 border-l-4 border-blue-400 mb-4">
                                                <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $review->comment }}</p>
                                            </div>
                                        @endif

                                        <!-- Review Metadata -->
                                        <div class="flex items-center space-x-6 text-sm text-gray-500">
                                            @if($review->order)
                                                <span class="flex items-center">
                                                    <i class="fas fa-receipt mr-1"></i>
                                                    Verified Purchase: {{ $review->order->order_number }}
                                                </span>
                                            @else
                                                <span class="flex items-center text-orange-600">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Unverified Purchase
                                                </span>
                                            @endif
                                            <span class="flex items-center">
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ $review->created_at->format('M j, Y \a\t g:i A') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="flex flex-col space-y-2 ml-4">
                                        <button onclick="quickModerate({{ $review->id }}, 'approved')" 
                                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200 text-sm font-medium">
                                            <i class="fas fa-check mr-1"></i>
                                            Approve
                                        </button>
                                        <button onclick="quickModerate({{ $review->id }}, 'rejected')" 
                                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 text-sm font-medium">
                                            <i class="fas fa-times mr-1"></i>
                                            Reject
                                        </button>
                                        <a href="{{ route('admin.shop.reviews.show', $review) }}" 
                                           class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 text-sm font-medium text-center">
                                            <i class="fas fa-eye mr-1"></i>
                                            Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $pendingReviews->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-check-circle text-4xl text-green-500"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">All Caught Up! 🎉</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">
                    No reviews are pending moderation. Great job keeping up with customer feedback!
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('admin.shop.reviews.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                        <i class="fas fa-list mr-2"></i>
                        View All Reviews
                    </a>
                    <a href="{{ route('admin.shop.reviews.analytics') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors duration-200">
                        <i class="fas fa-chart-bar mr-2"></i>
                        View Analytics
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Moderation Tips -->
    @if($pendingReviews->count() > 0)
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-lightbulb text-blue-500 mr-3"></i>
                Moderation Tips
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-check text-green-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Approve When:</h4>
                            <p class="text-sm text-gray-600">Review is constructive, honest, and follows community guidelines</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-star text-green-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Verified Purchases:</h4>
                            <p class="text-sm text-gray-600">Give priority to reviews from verified purchasers</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-times text-red-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Reject When:</h4>
                            <p class="text-sm text-gray-600">Review contains spam, inappropriate content, or fake information</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-exclamation text-yellow-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Be Consistent:</h4>
                            <p class="text-sm text-gray-600">Apply the same standards to all reviews for fairness</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
// Checkbox functionality
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const reviewCheckboxes = document.querySelectorAll('.review-checkbox');
    const bulkApproveBtn = document.getElementById('bulkApproveBtn');
    const bulkRejectBtn = document.getElementById('bulkRejectBtn');

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        reviewCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkButtons();
    });

    // Individual checkbox functionality
    reviewCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(reviewCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(reviewCheckboxes).some(cb => cb.checked);
            
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
            
            updateBulkButtons();
        });
    });

    function updateBulkButtons() {
        const checkedCount = Array.from(reviewCheckboxes).filter(cb => cb.checked).length;
        const hasSelection = checkedCount > 0;
        
        bulkApproveBtn.disabled = !hasSelection;
        bulkRejectBtn.disabled = !hasSelection;
    }
});

// Quick moderation
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
                // Remove the review from the list
                const reviewElement = document.querySelector(`[data-review-id="${reviewId}"]`);
                reviewElement.style.transition = 'all 0.3s ease';
                reviewElement.style.transform = 'translateX(100%)';
                reviewElement.style.opacity = '0';
                
                setTimeout(() => {
                    reviewElement.remove();
                    // Check if page is empty
                    if (document.querySelectorAll('[data-review-id]').length === 0) {
                        location.reload();
                    }
                }, 300);
                
                // Show success message
                showNotification(`Review ${actionText} successfully!`, 'success');
            } else {
                showNotification(`Failed to ${actionText} review`, 'error');
            }
        })
        .catch(error => {
            showNotification(`Error: ${error.message}`, 'error');
        });
    }
}

// Bulk actions
function bulkApproveSelected() {
    const selectedIds = getSelectedReviewIds();
    if (selectedIds.length === 0) return;
    
    if (confirm(`Are you sure you want to approve ${selectedIds.length} selected reviews?`)) {
        bulkModerate(selectedIds, 'approve');
    }
}

function bulkRejectSelected() {
    const selectedIds = getSelectedReviewIds();
    if (selectedIds.length === 0) return;
    
    if (confirm(`Are you sure you want to reject ${selectedIds.length} selected reviews?`)) {
        bulkModerate(selectedIds, 'reject');
    }
}

function bulkApprove() {
    if (confirm('Are you sure you want to approve ALL pending reviews on this page?')) {
        const allIds = Array.from(document.querySelectorAll('[data-review-id]')).map(el => el.dataset.reviewId);
        bulkModerate(allIds, 'approve');
    }
}

function bulkReject() {
    if (confirm('Are you sure you want to reject ALL pending reviews on this page?')) {
        const allIds = Array.from(document.querySelectorAll('[data-review-id]')).map(el => el.dataset.reviewId);
        bulkModerate(allIds, 'reject');
    }
}

function getSelectedReviewIds() {
    return Array.from(document.querySelectorAll('.review-checkbox:checked')).map(cb => cb.value);
}

function bulkModerate(reviewIds, action) {
    fetch('{{ route("admin.shop.reviews.bulk-actions") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            action: action,
            review_ids: reviewIds
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification(`Error: ${error.message}`, 'error');
    });
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
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>
@endsection