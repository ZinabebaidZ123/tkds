{{-- File: resources/views/admin/shop/reviews/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Review Details')
@section('page-title', 'Review Details')

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
                <h2 class="text-2xl font-bold text-gray-900">Review #{{ $review->id }}</h2>
                <p class="text-gray-600 text-sm mt-1">Submitted {{ $review->created_at->format('M j, Y \a\t g:i A') }}</p>
            </div>
        </div>
        <div class="flex space-x-4">
            @if($review->isPending())
                <button onclick="updateReviewStatus({{ $review->id }}, 'approved')" 
                        class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200">
                    <i class="fas fa-check mr-2"></i>
                    Approve Review
                </button>
                <button onclick="updateReviewStatus({{ $review->id }}, 'rejected')" 
                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Reject Review
                </button>
            @endif
            
            <button onclick="deleteReview({{ $review->id }})" 
                    class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-xl hover:bg-gray-600 transition-colors duration-200">
                <i class="fas fa-trash mr-2"></i>
                Delete
            </button>
        </div>
    </div>

    <!-- Review Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Review Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Review Content Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $review->user->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $review->user->email }}</p>
                            <p class="text-gray-500 text-xs">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    @php $statusBadge = $review->getStatusBadge() @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusBadge['class'] }}">
                        <i class="{{ $statusBadge['icon'] }} mr-2"></i>
                        {{ $statusBadge['text'] }}
                    </span>
                </div>

                <!-- Rating -->
                <div class="mb-6">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="flex items-center space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-xl"></i>
                            @endfor
                        </div>
                        <span class="text-lg font-semibold text-gray-900">{{ $review->rating }}/5</span>
                    </div>
                    
                    @if($review->title)
                        <h4 class="text-xl font-semibold text-gray-900 mb-3">{{ $review->title }}</h4>
                    @endif
                </div>

                <!-- Review Text -->
                @if($review->comment)
                    <div class="prose max-w-none">
                        <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-primary">
                            <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $review->comment }}</p>
                        </div>
                    </div>
                @endif

                <!-- Admin Notes -->
                @if($review->admin_notes)
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                        <h5 class="text-sm font-semibold text-yellow-800 mb-2">
                            <i class="fas fa-sticky-note mr-1"></i>
                            Admin Notes
                        </h5>
                        <p class="text-yellow-700 text-sm">{{ $review->admin_notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Order Information -->
            @if($review->order)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-receipt text-primary mr-3"></i>
                        Order Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600">Order Number</p>
                            <a href="{{ route('admin.shop.orders.show', $review->order) }}" 
                               class="text-lg font-semibold text-primary hover:text-secondary">
                                {{ $review->order->order_number }}
                            </a>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Order Date</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $review->order->created_at->format('M j, Y') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Order Total</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $review->order->getFormattedTotal() }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Order Status</p>
                            @php $orderBadge = $review->order->getStatusBadge() @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $orderBadge['class'] }}">
                                {{ $orderBadge['text'] }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Product Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-cube text-primary mr-3"></i>
                    Product Reviewed
                </h3>
                
                <div class="space-y-4">
                    <img src="{{ $review->product->getFeaturedImageUrl() }}" 
                         alt="{{ $review->product->name }}" 
                         class="w-full h-48 object-cover rounded-xl border border-gray-200">
                    
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $review->product->name }}</h4>
                        <p class="text-gray-600 text-sm">{{ $review->product->category?->name }}</p>
                        <p class="text-lg font-bold text-primary mt-2">{{ $review->product->getFormattedPrice() }}</p>
                    </div>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.shop.products.show', $review->product) }}" 
                           class="flex-1 text-center px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                            View Product
                        </a>
                        <a href="{{ route('admin.shop.products.edit', $review->product) }}" 
                           class="flex-1 text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                            Edit Product
                        </a>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user text-primary mr-3"></i>
                    Customer Details
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $review->user->name }}</h4>
                            <p class="text-gray-600 text-sm">{{ $review->user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Joined</p>
                            <p class="font-semibold text-gray-900">{{ $review->user->created_at->format('M j, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Total Orders</p>
                            <p class="font-semibold text-gray-900">{{ $review->user->orders()->count() }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.users.show', $review->user) }}" 
                       class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                        View Customer Profile
                    </a>
                </div>
            </div>

            <!-- Other Reviews by Customer -->
            @if($userReviews->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-star text-primary mr-3"></i>
                        Other Reviews by {{ $review->user->name }}
                    </h3>
                    
                    <div class="space-y-3">
                        @foreach($userReviews as $otherReview)
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $otherReview->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                    @php $otherStatusBadge = $otherReview->getStatusBadge() @endphp
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $otherStatusBadge['class'] }}">
                                        {{ $otherStatusBadge['text'] }}
                                    </span>
                                </div>
                                <p class="text-sm font-medium text-gray-900">{{ $otherReview->product->name }}</p>
                                <p class="text-xs text-gray-600">{{ $otherReview->created_at->format('M j, Y') }}</p>
                                <a href="{{ route('admin.shop.reviews.show', $otherReview) }}" 
                                   class="text-xs text-primary hover:text-secondary">View →</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Other Reviews for Product -->
            @if($productReviews->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-comments text-primary mr-3"></i>
                        Other Reviews for this Product
                    </h3>
                    
                    <div class="space-y-3">
                        @foreach($productReviews as $otherReview)
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $otherReview->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-600">{{ $otherReview->created_at->format('M j') }}</span>
                                </div>
                                <p class="text-sm font-medium text-gray-900">{{ $otherReview->user->name }}</p>
                                @if($otherReview->title)
                                    <p class="text-xs text-gray-700 font-medium">{{ Str::limit($otherReview->title, 30) }}</p>
                                @endif
                                <a href="{{ route('admin.shop.reviews.show', $otherReview) }}" 
                                   class="text-xs text-primary hover:text-secondary">View →</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4" id="modalTitle">Update Review Status</h3>
        <form id="statusForm">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes (Optional)</label>
                    <textarea id="adminNotes" rows="3" 
                              placeholder="Add notes about this status change..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary"></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" onclick="closeStatusModal()" 
                        class="px-4 py-2 text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" id="confirmButton"
                        class="px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentAction = null;
let currentReviewId = null;

function updateReviewStatus(reviewId, status) {
    currentAction = status;
    currentReviewId = reviewId;
    
    const modal = document.getElementById('statusModal');
    const title = document.getElementById('modalTitle');
    const button = document.getElementById('confirmButton');
    
    if (status === 'approved') {
        title.textContent = 'Approve Review';
        button.textContent = 'Approve';
        button.className = 'px-4 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600';
    } else {
        title.textContent = 'Reject Review';
        button.textContent = 'Reject';
        button.className = 'px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600';
    }
    
    modal.classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.getElementById('adminNotes').value = '';
    currentAction = null;
    currentReviewId = null;
}

document.getElementById('statusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const adminNotes = document.getElementById('adminNotes').value;
    
    fetch(`{{ route('admin.shop.reviews.index') }}/${currentReviewId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: currentAction,
            admin_notes: adminNotes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to update review status');
        }
    });
});

function deleteReview(reviewId) {
    if (confirm('Are you sure you want to delete this review? This action cannot be undone.')) {
        fetch(`{{ route('admin.shop.reviews.index') }}/${reviewId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route('admin.shop.reviews.index') }}';
            } else {
                alert('Failed to delete review');
            }
        });
    }
}
</script>
@endsection