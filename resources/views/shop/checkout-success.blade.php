@extends('layouts.app')

@section('title', 'Order Confirmed - TKDS Media')
@section('meta_description', 'Your order has been successfully placed')

@section('content')

<!-- Success Header -->
<section class="bg-dark py-20 mt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        
        <!-- Success Animation -->
        <div class="mx-auto h-24 w-24 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mb-8 animate-pulse" data-aos="zoom-in">
            <i class="fas fa-check text-4xl text-white"></i>
        </div>

        <!-- Success Message -->
        <div data-aos="fade-up" data-aos-delay="200">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4">
                Order Confirmed!
            </h1>
            <p class="text-xl text-gray-300 mb-8">
                Thank you for your purchase. Your order has been successfully placed.
            </p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10 text-left" data-aos="fade-up" data-aos-delay="400">
            <div class="grid md:grid-cols-2 gap-8">
                
                <!-- Order Info -->
                <div>
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                        <i class="fas fa-receipt mr-3 text-primary"></i>
                        Order Information
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Order Number:</span>
                            <span class="text-white font-semibold">{{ $order->order_number }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Order Date:</span>
                            <span class="text-white">{{ $order->created_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Payment Status:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                <i class="fas fa-check-circle mr-1"></i>
                                Paid
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Total Amount:</span>
                            <span class="text-xl font-bold text-primary">{{ $order->getFormattedTotal() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Customer Info -->
                <div>
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                        <i class="fas fa-user mr-3 text-secondary"></i>
                        Customer Information
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-gray-400 text-sm">Name</p>
                            <p class="text-white font-semibold">{{ $order->billing_address['name'] ?? ($order->billing_address['first_name'] . ' ' . $order->billing_address['last_name']) }}</p>
                        </div>
                        
                        <div>
                            <p class="text-gray-400 text-sm">Email</p>
                            <p class="text-white">{{ $order->billing_address['email'] }}</p>
                        </div>
                        
                        @if(!empty($order->billing_address['phone']))
                        <div>
                            <p class="text-gray-400 text-sm">Phone</p>
                            <p class="text-white">{{ $order->billing_address['phone'] }}</p>
                        </div>
                        @endif
                        
                        <div>
                            <p class="text-gray-400 text-sm">Billing Address</p>
                            <p class="text-white text-sm">
                                {{ $order->billing_address['address_line_1'] }}<br>
                                @if(!empty($order->billing_address['address_line_2']))
                                    {{ $order->billing_address['address_line_2'] }}<br>
                                @endif
                                {{ $order->billing_address['city'] }}, {{ $order->billing_address['state'] }} {{ $order->billing_address['postal_code'] }}<br>
                                {{ $order->billing_address['country'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10 mt-8" data-aos="fade-up" data-aos-delay="600">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                <i class="fas fa-shopping-bag mr-3 text-accent"></i>
                Order Items ({{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }})
            </h2>
            
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center space-x-4 p-4 bg-white/5 rounded-xl">
                    <!-- Product Image -->
                    <div class="flex-shrink-0">
                        <img src="{{ $item->product?->getFeaturedImageUrl() ?? 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=80&h=80&fit=crop' }}" 
                             alt="{{ $item->product_name }}" 
                             class="w-16 h-16 object-cover rounded-lg border border-white/20">
                    </div>
                    
                    <!-- Product Info -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-white font-semibold">{{ $item->product_name }}</h3>
                        <p class="text-gray-400 text-sm">SKU: {{ $item->product_sku }}</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                {{ $item->product_type === 'software' ? 'bg-purple-500/20 text-purple-400' : 'bg-blue-500/20 text-blue-400' }}">
                                <i class="fas fa-{{ $item->product_type === 'software' ? 'download' : 'box' }} mr-1"></i>
                                {{ $item->product_type === 'software' ? 'Digital Download' : 'Physical Product' }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Quantity & Price -->
                    <div class="text-right">
                        <p class="text-white font-semibold">{{ $item->getFormattedTotal() }}</p>
                        <p class="text-gray-400 text-sm">Qty: {{ $item->quantity }} × {{ $item->getFormattedPrice() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Order Summary -->
            <div class="border-t border-white/10 pt-6 mt-6">
                <div class="space-y-2 max-w-md ml-auto">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Subtotal:</span>
                        <span class="text-white">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    
                    @if($order->shipping_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-400">Shipping:</span>
                        <span class="text-white">${{ number_format($order->shipping_amount, 2) }}</span>
                    </div>
                    @endif
                    
                    @if($order->tax_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-400">Tax:</span>
                        <span class="text-white">${{ number_format($order->tax_amount, 2) }}</span>
                    </div>
                    @endif
                    
                    <div class="border-t border-white/10 pt-2">
                        <div class="flex justify-between">
                            <span class="text-lg font-bold text-white">Total:</span>
                            <span class="text-lg font-bold text-primary">{{ $order->getFormattedTotal() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Digital Downloads Section -->
        @if($order->hasDigitalProducts())
        <div class="bg-gradient-to-r from-purple-500/10 to-blue-500/10 rounded-2xl p-8 border border-purple-500/20 mt-8" data-aos="fade-up" data-aos-delay="800">
            <div class="text-center mb-6">
                <i class="fas fa-download text-4xl text-purple-400 mb-4"></i>
                <h2 class="text-xl font-bold text-white mb-2">Digital Downloads Available</h2>
                <p class="text-gray-300">Your download links have been sent to your email address.</p>
            </div>
            
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('user.downloads') }}" 
                   class="inline-flex items-center px-6 py-3 bg-purple-500 text-white rounded-xl font-semibold hover:bg-purple-600 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-download mr-2"></i>
                    View Downloads
                </a>
                
                <a href="mailto:{{ $order->billing_address['email'] }}" 
                   class="inline-flex items-center px-6 py-3 bg-white/10 text-white rounded-xl font-semibold hover:bg-white/20 transition-all duration-300">
                    <i class="fas fa-envelope mr-2"></i>
                    Check Email
                </a>
            </div>
        </div>
        @endif

        <!-- Next Steps -->
        <div class="grid md:grid-cols-3 gap-6 mt-12" data-aos="fade-up" data-aos-delay="1000">
            
            <!-- Track Order -->
            @if($order->hasPhysicalProducts())
            <div class="bg-white/5 backdrop-blur-xl rounded-xl p-6 border border-white/10">
                <div class="text-center">
                    <i class="fas fa-shipping-fast text-3xl text-primary mb-4"></i>
                    <h3 class="text-lg font-bold text-white mb-2">Track Your Order</h3>
                    <p class="text-gray-400 text-sm mb-4">We'll send you tracking information once your order ships.</p>
                    <a href="{{ route('user.orders.show', $order) }}" 
                       class="inline-flex items-center text-primary hover:text-secondary transition-colors duration-200">
                        <span>View Order Details</span>
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            @endif

            <!-- Order History -->
            <div class="bg-white/5 backdrop-blur-xl rounded-xl p-6 border border-white/10">
                <div class="text-center">
                    <i class="fas fa-history text-3xl text-secondary mb-4"></i>
                    <h3 class="text-lg font-bold text-white mb-2">Order History</h3>
                    <p class="text-gray-400 text-sm mb-4">View all your past orders and download receipts.</p>
                    <a href="{{ route('user.orders') }}" 
                       class="inline-flex items-center text-primary hover:text-secondary transition-colors duration-200">
                        <span>View All Orders</span>
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <!-- Continue Shopping -->
            <div class="bg-white/5 backdrop-blur-xl rounded-xl p-6 border border-white/10">
                <div class="text-center">
                    <i class="fas fa-shopping-bag text-3xl text-accent mb-4"></i>
                    <h3 class="text-lg font-bold text-white mb-2">Continue Shopping</h3>
                    <p class="text-gray-400 text-sm mb-4">Discover more amazing products in our store.</p>
                    <a href="{{ route('shop.index') }}" 
                       class="inline-flex items-center text-primary hover:text-secondary transition-colors duration-200">
                        <span>Browse Products</span>
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Support -->
        <div class="mt-12 p-6 bg-white/5 backdrop-blur-xl rounded-xl border border-white/10" data-aos="fade-up" data-aos-delay="1200">
            <div class="text-center">
                <h3 class="text-lg font-bold text-white mb-2">Need Help?</h3>
                <p class="text-gray-400 mb-4">
                    If you have any questions about your order, please don't hesitate to contact us.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('contact') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-headset mr-2"></i>
                        Contact Support
                    </a>
                    
                    <a href="mailto:support@tkdsmedia.com" 
                       class="inline-flex items-center px-6 py-3 bg-white/10 text-white rounded-xl font-semibold hover:bg-white/20 transition-all duration-300">
                        <i class="fas fa-envelope mr-2"></i>
                        Email Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Email Confirmation -->
<section class="bg-dark-light py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-blue-500/10 border border-blue-500/20 rounded-2xl p-8" data-aos="fade-up">
            <i class="fas fa-envelope-open text-4xl text-blue-400 mb-4"></i>
            <h2 class="text-2xl font-bold text-white mb-4">Confirmation Email Sent</h2>
            <p class="text-gray-300 mb-6">
                We've sent a detailed order confirmation to <strong>{{ $order->billing_address['email'] }}</strong>
                with your receipt and download links (if applicable).
            </p>
            <p class="text-sm text-gray-400">
                <i class="fas fa-info-circle mr-1"></i>
                If you don't see the email, please check your spam folder or contact support.
            </p>
        </div>
    </div>
</section>

<script>
// Trigger success analytics events
document.addEventListener('DOMContentLoaded', function() {
    // Google Analytics Enhanced Ecommerce
    if (typeof gtag !== 'undefined') {
        gtag('event', 'purchase', {
            transaction_id: '{{ $order->order_number }}',
            value: {{ $order->total_amount }},
            currency: '{{ $order->currency }}',
            items: [
                @foreach($order->items as $item)
                {
                    item_id: '{{ $item->product_id }}',
                    item_name: '{{ addslashes($item->product_name) }}',
                    category: '{{ addslashes($item->product->category?->name ?? "Uncategorized") }}',
                    quantity: {{ $item->quantity }},
                    price: {{ $item->price }}
                }{{ !$loop->last ? ',' : '' }}
                @endforeach
            ]
        });
    }

    // Facebook Pixel Purchase Event
    if (typeof fbq !== 'undefined') {
        fbq('track', 'Purchase', {
            value: {{ $order->total_amount }},
            currency: '{{ $order->currency }}',
            content_ids: [
                @foreach($order->items as $item)
                '{{ $item->product_id }}'{{ !$loop->last ? ',' : '' }}
                @endforeach
            ],
            content_type: 'product',
            num_items: {{ $order->items->sum('quantity') }}
        });
    }

    // Show celebration animation
    setTimeout(() => {
        const successIcon = document.querySelector('.fa-check');
        if (successIcon) {
            successIcon.style.animation = 'bounce 1s infinite';
        }
    }, 1000);
});
</script>

@endsection