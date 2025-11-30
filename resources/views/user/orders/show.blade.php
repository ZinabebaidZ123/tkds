@extends('layouts.user')

@section('title', 'Order #' . $order->order_number . ' - TKDS Media')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark via-dark-light to-dark py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8" data-aos="fade-up">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-white mb-2">Order #{{ $order->order_number }}</h1>
                    <p class="text-gray-400">Placed on {{ $order->created_at->format('M j, Y \a\t g:i A') }}</p>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    @if($order->canCancel())
                    <button onclick="cancelOrder()" 
                            class="inline-flex items-center px-4 py-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>Cancel Order
                    </button>
                    @endif
                    
                    @if($order->isPaid())
                    <a href="{{ route('user.orders.invoice', $order->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-all duration-300">
                        <i class="fas fa-download mr-2"></i>Download Invoice
                    </a>
                    @endif
                    
                    <a href="{{ route('user.orders') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-all duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Orders
                    </a>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            
            <!-- Order Details - Left Column -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Order Status Card -->
                <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10" data-aos="fade-up">
                    <h2 class="text-xl font-bold text-white mb-6">Order Status</h2>
                    
                    <!-- Status Badges -->
                    <div class="flex flex-wrap gap-3 mb-8">
                        @php $statusBadge = $order->getStatusBadge(); @endphp
                        <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium {{ $statusBadge['class'] }}">
                            <i class="{{ $statusBadge['icon'] }} mr-2"></i>
                            {{ $statusBadge['text'] }}
                        </span>
                        
                        @php $paymentBadge = $order->getPaymentStatusBadge(); @endphp
                        <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium {{ $paymentBadge['class'] }}">
                            <i class="{{ $paymentBadge['icon'] }} mr-2"></i>
                            {{ $paymentBadge['text'] }}
                        </span>
                    </div>

                    <!-- Progress Tracker -->
                    <div class="relative">
                        @php
                            $steps = [
                                ['status' => 'pending', 'title' => 'Order Placed', 'completed' => true],
                                ['status' => 'processing', 'title' => 'Processing', 'completed' => in_array($order->status, ['processing', 'shipped', 'delivered'])],
                                ['status' => 'shipped', 'title' => 'Shipped', 'completed' => in_array($order->status, ['shipped', 'delivered'])],
                                ['status' => 'delivered', 'title' => 'Delivered', 'completed' => $order->status === 'delivered']
                            ];
                        @endphp
                        
                        <div class="flex justify-between relative">
                            <!-- Progress Line -->
                            <div class="absolute top-5 left-5 right-5 h-0.5 bg-gray-600"></div>
                            
                            @foreach($steps as $index => $step)
                            <div class="flex flex-col items-center relative z-10">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mb-3 transition-all duration-300 {{ $step['completed'] ? 'bg-primary text-white shadow-lg shadow-primary/50' : 'bg-gray-600 text-gray-400' }}">
                                    <i class="fas fa-{{ $step['completed'] ? 'check' : 'circle' }}"></i>
                                </div>
                                <span class="text-sm font-medium {{ $step['completed'] ? 'text-white' : 'text-gray-400' }} text-center">{{ $step['title'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Items Card -->
                <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="text-xl font-bold text-white mb-6">Order Items ({{ $order->items->count() }} items)</h2>
                    
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center space-x-4 p-4 bg-white/5 rounded-xl border border-white/10 hover:border-primary/30 transition-all duration-300">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                <img src="{{ $item->product?->getFeaturedImageUrl() ?? 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=80&h=80&fit=crop' }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="w-16 h-16 object-cover rounded-lg border border-white/20">
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-semibold truncate">{{ $item->product_name }}</h3>
                                <p class="text-gray-400 text-sm">SKU: {{ $item->product_sku }}</p>
                                
                                <div class="flex items-center space-x-2 mt-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        {{ $item->product_type === 'software' ? 'bg-purple-500/20 text-purple-400' : 'bg-blue-500/20 text-blue-400' }}">
                                        <i class="fas fa-{{ $item->product_type === 'software' ? 'download' : 'box' }} mr-1"></i>
                                        {{ $item->product_type === 'software' ? 'Digital' : 'Physical' }}
                                    </span>
                                    
                                    @if($item->product)
                                    <a href="{{ route('shop.product', $item->product->slug) }}" 
                                       class="text-primary hover:text-secondary transition-colors duration-200 text-sm font-medium">
                                        View Product →
                                    </a>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Quantity & Price -->
                            <div class="text-right">
                                <p class="text-white font-bold text-lg">{{ $item->getFormattedTotal() }}</p>
                                <p class="text-gray-400 text-sm">{{ $item->quantity }} × {{ $item->getFormattedPrice() }}</p>
                                
                                @if($item->product_type === 'software' && $order->isPaid())
                                <a href="{{ route('user.downloads') }}" 
                                   class="inline-flex items-center mt-2 px-3 py-1 bg-purple-500/20 text-purple-400 rounded-lg hover:bg-purple-500/30 transition-all duration-200 text-sm">
                                    <i class="fas fa-download mr-1"></i>
                                    Download
                                </a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Downloads Section -->
                @if($downloadableItems->count() > 0)
                <div class="bg-gradient-to-r from-purple-500/10 to-blue-500/10 rounded-2xl p-6 border border-purple-500/20" data-aos="fade-up" data-aos-delay="400">
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                        <i class="fas fa-download mr-3 text-purple-400"></i>
                        Digital Downloads ({{ $downloadableItems->count() }} items)
                    </h2>
                    
                    @if($order->isPaid())
                    <div class="space-y-3">
                        @foreach($downloadableItems as $item)
                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-purple-400/20">
                            <div>
                                <h3 class="text-white font-medium">{{ $item->product_name }}</h3>
                                <p class="text-purple-300 text-sm">Digital Download • Ready for download</p>
                            </div>
                            <a href="{{ route('user.downloads') }}" 
                               class="inline-flex items-center px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors duration-200 font-medium">
                                <i class="fas fa-download mr-2"></i>Download
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <i class="fas fa-clock text-4xl text-yellow-400 mb-4"></i>
                        <h3 class="text-xl font-semibold text-yellow-300 mb-2">Downloads Pending</h3>
                        <p class="text-yellow-200">Downloads will be available after payment confirmation</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">
                    
                    <!-- Order Summary Card -->
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="text-xl font-bold text-white mb-6">Order Summary</h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Subtotal:</span>
                                <span class="text-white font-semibold">${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            
                            @if($order->shipping_amount > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Shipping:</span>
                                <span class="text-white font-semibold">${{ number_format($order->shipping_amount, 2) }}</span>
                            </div>
                            @endif
                            
                            @if($order->tax_amount > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Tax:</span>
                                <span class="text-white font-semibold">${{ number_format($order->tax_amount, 2) }}</span>
                            </div>
                            @endif
                            
                            <div class="border-t border-white/20 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-bold text-white">Total:</span>
                                    <span class="text-xl font-bold text-primary">{{ $order->getFormattedTotal() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Addresses Card -->
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="text-xl font-bold text-white mb-6">Addresses</h2>
                        
                        <!-- Billing Address -->
                        <div class="mb-6">
                            <h3 class="text-white font-semibold mb-3 flex items-center">
                                <i class="fas fa-credit-card mr-2 text-blue-400"></i>
                                Billing Address
                            </h3>
                            <div class="text-gray-300 text-sm bg-white/5 rounded-lg p-3 border border-white/10">
                                <p class="font-medium">{{ $order->billing_address['name'] ?? ($order->billing_address['first_name'] . ' ' . $order->billing_address['last_name']) }}</p>
                                <p>{{ $order->billing_address['address_line_1'] }}</p>
                                @if(!empty($order->billing_address['address_line_2']))
                                <p>{{ $order->billing_address['address_line_2'] }}</p>
                                @endif
                                <p>{{ $order->billing_address['city'] }}, {{ $order->billing_address['state'] }} {{ $order->billing_address['postal_code'] }}</p>
                                <p>{{ $order->billing_address['country'] }}</p>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        @if($order->hasPhysicalProducts())
                        <div>
                            <h3 class="text-white font-semibold mb-3 flex items-center">
                                <i class="fas fa-shipping-fast mr-2 text-green-400"></i>
                                Shipping Address
                            </h3>
                            <div class="text-gray-300 text-sm bg-white/5 rounded-lg p-3 border border-white/10">
                                <p class="font-medium">{{ $order->shipping_address['name'] ?? ($order->shipping_address['first_name'] . ' ' . $order->shipping_address['last_name']) }}</p>
                                <p>{{ $order->shipping_address['address_line_1'] }}</p>
                                @if(!empty($order->shipping_address['address_line_2']))
                                <p>{{ $order->shipping_address['address_line_2'] }}</p>
                                @endif
                                <p>{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['postal_code'] }}</p>
                                <p>{{ $order->shipping_address['country'] }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10" data-aos="fade-up" data-aos-delay="500">
                        <h2 class="text-xl font-bold text-white mb-6">Quick Actions</h2>
                        
                        <div class="space-y-3">
                            @if($order->hasPhysicalProducts() && !$order->isCancelled())
                            <button onclick="trackOrder()" 
                                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-all duration-300 font-medium">
                                <i class="fas fa-shipping-fast mr-2"></i>Track Order
                            </button>
                            @endif
                            
                            <button onclick="reorder()" 
                                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-500/20 text-green-400 rounded-lg hover:bg-green-500/30 transition-all duration-300 font-medium">
                                <i class="fas fa-redo mr-2"></i>Reorder Items
                            </button>
                            
                            {{-- @if($order->canRefund())
                            <button onclick="requestReturn()" 
                                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-yellow-500/20 text-yellow-400 rounded-lg hover:bg-yellow-500/30 transition-all duration-300 font-medium">
                                <i class="fas fa-undo mr-2"></i>Request Return
                            </button>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function cancelOrder() {
    if (!confirm('Are you sure you want to cancel this order?')) return;
    
    fetch('{{ route("user.orders.cancel", $order->id) }}', {
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
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
    });
}

function reorder() {
    fetch('{{ route("user.orders.reorder", $order->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = '{{ route("shop.cart") }}';
        } else {
            alert(data.message || 'Failed to reorder');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
    });
}

function trackOrder() {
    fetch('{{ route("user.orders.track", $order->id) }}')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show tracking modal or redirect to tracking page
            alert('Tracking info: ' + JSON.stringify(data.tracking));
        } else {
            alert('Tracking information not available yet');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Unable to fetch tracking information');
    });
}

function requestReturn() {
    if (!confirm('Are you sure you want to request a return for this order?')) return;
    
    const reason = prompt('Please provide a reason for the return:');
    if (!reason) return;
    
    fetch('{{ route("user.orders.return", $order->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            reason: reason,
            items: [
                @foreach($order->items as $item)
                {
                    item_id: {{ $item->id }},
                    quantity: {{ $item->quantity }}
                }{{ !$loop->last ? ',' : '' }}
                @endforeach
            ]
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message || 'Failed to request return');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
    });
}
</script>

@endsection