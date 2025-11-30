{{-- File: resources/views/user/orders/index.blade.php --}}
@extends('layouts.user')

@section('title', 'My Orders - TKDS Media')
@section('meta_description', 'View and track your order history')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark via-dark-light to-dark">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-white mb-2">My Orders</h1>
                <p class="text-gray-400">Track your order history and downloads</p>
            </div>
            
            <!-- Filters -->
            <div class="mt-4 sm:mt-0">
                <form method="GET" class="flex space-x-4">
                    <select name="status" class="px-4 py-2 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">All Orders</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                        <i class="fas fa-filter"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white/5 backdrop-blur-xl rounded-xl p-4 border border-white/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Orders</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['total_orders'] }}</p>
                    </div>
                    <i class="fas fa-shopping-cart text-primary text-2xl"></i>
                </div>
            </div>
            
            <div class="bg-white/5 backdrop-blur-xl rounded-xl p-4 border border-white/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Completed</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['completed_orders'] }}</p>
                    </div>
                    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                </div>
            </div>
            
            <div class="bg-white/5 backdrop-blur-xl rounded-xl p-4 border border-white/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Spent</p>
                        <p class="text-2xl font-bold text-white">${{ number_format($stats['total_spent'], 0) }}</p>
                    </div>
                    <i class="fas fa-dollar-sign text-secondary text-2xl"></i>
                </div>
            </div>
            
            <div class="bg-white/5 backdrop-blur-xl rounded-xl p-4 border border-white/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Downloads</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['total_downloads'] }}</p>
                    </div>
                    <i class="fas fa-download text-accent text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10 hover:border-primary/30 transition-all duration-300">
                        
                        <!-- Order Header -->
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-6">
                                <div>
                                    <h3 class="text-lg font-bold text-white">Order {{ $order->order_number }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $order->created_at->format('M j, Y g:i A') }}</p>
                                </div>
                                <div>
                                    @php $statusBadge = $order->getStatusBadge() @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusBadge['class'] }}">
                                        <i class="{{ $statusBadge['icon'] }} mr-1"></i>
                                        {{ $statusBadge['text'] }}
                                    </span>
                                </div>
                                <div>
                                    @php $paymentBadge = $order->getPaymentStatusBadge() @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $paymentBadge['class'] }}">
                                        <i class="{{ $paymentBadge['icon'] }} mr-1"></i>
                                        {{ $paymentBadge['text'] }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mt-4 lg:mt-0 text-right">
                                <p class="text-2xl font-bold text-primary">{{ $order->getFormattedTotal() }}</p>
                                <p class="text-gray-400 text-sm">{{ $order->items->count() }} items</p>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="space-y-4 mb-6">
                            @foreach($order->items as $item)
                                <div class="flex items-center space-x-4 p-4 bg-white/5 rounded-xl">
                                    <img src="{{ $item->product?->getFeaturedImageUrl() ?? 'https://via.placeholder.com/80x80' }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="w-16 h-16 object-cover rounded-lg border border-white/20">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-white truncate">{{ $item->product_name }}</h4>
                                        <p class="text-gray-400 text-sm">{{ $item->product_sku }}</p>
                                        <div class="flex items-center space-x-4 mt-1">
                                            <span class="text-sm text-gray-400">Qty: {{ $item->quantity }}</span>
                                            <span class="text-sm text-gray-400">{{ $item->getFormattedPrice() }} each</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-white">{{ $item->getFormattedTotal() }}</p>
                                        @if($item->isSoftware())
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mt-1">
                                                <i class="fas fa-download mr-1"></i>Digital
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                                <i class="fas fa-box mr-1"></i>Physical
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Actions -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('user.orders.show', $order) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>
                                    View Details
                                </a>
                                
                                @if($order->hasDigitalProducts() && $order->isPaid())
                                    <a href="{{ route('user.downloads') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors duration-200">
                                        <i class="fas fa-download mr-2"></i>
                                        Downloads
                                    </a>
                                @endif
                                
                                @if($order->canCancel())
                                    <button onclick="cancelOrder({{ $order->id }})" 
                                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancel Order
                                    </button>
                                @endif
                            </div>
                            
                            <!-- Tracking Info -->
                            @if($order->isShipped() || $order->isDelivered())
                                <div class="text-right">
                                    @if($order->shipped_at)
                                        <p class="text-sm text-gray-400">Shipped: {{ $order->shipped_at->format('M j, Y') }}</p>
                                    @endif
                                    @if($order->delivered_at)
                                        <p class="text-sm text-gray-400">Delivered: {{ $order->delivered_at->format('M j, Y') }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-shopping-cart text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">No Orders Found</h3>
                <p class="text-gray-400 mb-6 max-w-md mx-auto">You haven't placed any orders yet. Start shopping to see your order history here.</p>
                <a href="{{ route('shop.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function cancelOrder(orderId) {
    if (confirm('Are you sure you want to cancel this order? This action cannot be undone.')) {
        fetch(`/user/orders/${orderId}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to cancel order');
            }
        })
        .catch(error => {
            alert('Something went wrong. Please try again.');
        });
    }
}
</script>
@endsection