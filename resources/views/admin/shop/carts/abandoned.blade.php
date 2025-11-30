{{-- File: resources/views/admin/shop/carts/abandoned.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Abandoned Carts')
@section('page-title', 'Abandoned Carts')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.shop.carts.index') }}" 
               class="p-2 text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Abandoned Carts</h2>
                <p class="text-gray-600 text-sm mt-1">Carts inactive for more than 24 hours</p>
            </div>
        </div>
        <div class="flex space-x-4">
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Hours inactive:</label>
                <select onchange="filterByHours(this.value)" 
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="24" {{ request('hours') == '24' ? 'selected' : '' }}>24+ hours</option>
                    <option value="48" {{ request('hours') == '48' ? 'selected' : '' }}>48+ hours</option>
                    <option value="72" {{ request('hours') == '72' ? 'selected' : '' }}>72+ hours</option>
                    <option value="168" {{ request('hours') == '168' ? 'selected' : '' }}>1+ week</option>
                </select>
            </div>
            <button onclick="sendRecoveryEmails()" 
                    class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                <i class="fas fa-envelope mr-2"></i>
                Send Recovery Emails
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Abandoned Carts</p>
                    <p class="text-3xl font-bold">{{ $groupedCarts->count() }}</p>
                </div>
                <i class="fas fa-shopping-cart text-4xl text-red-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Total Items</p>
                    <p class="text-3xl font-bold">{{ $abandonedCarts->sum('quantity') }}</p>
                </div>
                <i class="fas fa-cubes text-4xl text-orange-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Potential Revenue</p>
                    <p class="text-3xl font-bold">${{ number_format($abandonedCarts->sum(function($cart) { return $cart->getSubtotal(); }), 0) }}</p>
                </div>
                <i class="fas fa-dollar-sign text-4xl text-yellow-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Recovery Rate</p>
                    <p class="text-3xl font-bold">{{ number_format(15.3, 1) }}%</p>
                    <p class="text-purple-200 text-xs">Industry average</p>
                </div>
                <i class="fas fa-chart-line text-4xl text-purple-200"></i>
            </div>
        </div>
    </div>

    <!-- Abandoned Carts List -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        @if($groupedCarts->count() > 0)
            <div class="overflow-x-auto">
                @foreach($groupedCarts as $userId => $carts)
                    @php 
                        $customer = $carts->first()->user;
                        $totalValue = $carts->sum(function($cart) { return $cart->getSubtotal(); });
                        $totalItems = $carts->sum('quantity');
                        $oldestCart = $carts->sortBy('created_at')->first();
                    @endphp
                    
                    <div class="border-b border-gray-100 last:border-b-0">
                        <!-- Customer Header -->
                        <div class="bg-gray-50 px-6 py-4 cursor-pointer hover:bg-gray-100 transition-colors duration-200" 
                             onclick="toggleCart('{{ $userId }}')">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    @if($customer)
                                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($customer->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $customer->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $customer->email }}</p>
                                            <p class="text-xs text-gray-500">Customer since {{ $customer->created_at->format('M Y') }}</p>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center text-white">
                                            <i class="fas fa-user-slash"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">Guest User</h4>
                                            <p class="text-sm text-gray-600">Session: {{ substr($userId, 0, 12) }}...</p>
                                            <p class="text-xs text-gray-500">Anonymous visitor</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex items-center space-x-6">
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600">Items</p>
                                        <p class="font-bold text-gray-900">{{ $totalItems }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600">Value</p>
                                        <p class="font-bold text-gray-900">${{ number_format($totalValue, 2) }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600">Abandoned</p>
                                        <p class="font-bold text-gray-900">{{ $oldestCart->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        @if($customer)
                                            <button onclick="sendRecoveryEmail('{{ $customer->id }}')" 
                                                    class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50"
                                                    title="Send Recovery Email">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        @endif
                                        <button onclick="deleteAbandonedCart('{{ $userId }}')" 
                                                class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50"
                                                title="Delete Cart">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <i class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200" 
                                           id="chevron-{{ $userId }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cart Items (Initially Hidden) -->
                        <div id="cart-{{ $userId }}" class="hidden">
                            <div class="px-6 py-4">
                                <h5 class="text-sm font-semibold text-gray-700 mb-3">Cart Items ({{ $carts->count() }})</h5>
                                <div class="space-y-3">
                                    @foreach($carts as $cart)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div class="flex items-center space-x-4">
                                                @if($cart->product)
                                                    <img src="{{ $cart->product->getFeaturedImageUrl() }}" 
                                                         alt="{{ $cart->product->name }}" 
                                                         class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                                    <div>
                                                        <h6 class="font-medium text-gray-900">{{ $cart->product->name }}</h6>
                                                        <p class="text-sm text-gray-600">{{ $cart->product->getFormattedPrice() }} × {{ $cart->quantity }}</p>
                                                        @if($cart->product->category)
                                                            <p class="text-xs text-gray-500">{{ $cart->product->category->name }}</p>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-cube text-gray-400"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="font-medium text-gray-900">Product Unavailable</h6>
                                                        <p class="text-sm text-gray-600">Qty: {{ $cart->quantity }}</p>
                                                        <p class="text-xs text-red-500">Product may have been deleted</p>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="text-right">
                                                <p class="font-bold text-gray-900">{{ $cart->getFormattedSubtotal() }}</p>
                                                <p class="text-xs text-gray-500">Added {{ $cart->created_at->diffForHumans() }}</p>
                                                @if($cart->product && !$cart->product->isInStock())
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                                        Out of Stock
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Cart Actions -->
                                <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
                                    <div>
                                        <p class="text-sm text-gray-600">Total Cart Value</p>
                                        <p class="text-xl font-bold text-gray-900">${{ number_format($totalValue, 2) }}</p>
                                    </div>
                                    <div class="flex space-x-3">
                                        @if($customer)
                                            <button onclick="sendRecoveryEmail('{{ $customer->id }}')" 
                                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                                                <i class="fas fa-envelope mr-2"></i>
                                                Send Recovery Email
                                            </button>
                                        @endif
                                        <button onclick="convertToOrder('{{ $userId }}')" 
                                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200">
                                            <i class="fas fa-shopping-cart mr-2"></i>
                                            Convert to Order
                                        </button>
                                        <button onclick="deleteAbandonedCart('{{ $userId }}')" 
                                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200">
                                            <i class="fas fa-trash mr-2"></i>
                                            Delete Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $abandonedCarts->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-shopping-cart text-4xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Abandoned Carts! 🎉</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">
                    Great job! All customers are completing their purchases. No abandoned carts found.
                </p>
                <a href="{{ route('admin.shop.carts.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    View All Carts
                </a>
            </div>
        @endif
    </div>

    <!-- Recovery Tips -->
    @if($groupedCarts->count() > 0)
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-lightbulb text-yellow-500 mr-3"></i>
                Cart Recovery Strategies
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-envelope text-white text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Email Reminders</h4>
                        <p class="text-sm text-gray-600">Send personalized recovery emails with cart contents.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-percentage text-white text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Discount Offers</h4>
                        <p class="text-sm text-gray-600">Provide limited-time discounts to encourage completion.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clock text-white text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Urgency Creation</h4>
                        <p class="text-sm text-gray-600">Show limited stock or time-sensitive offers.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function toggleCart(userId) {
    const cartDiv = document.getElementById(`cart-${userId}`);
    const chevron = document.getElementById(`chevron-${userId}`);
    
    if (cartDiv.classList.contains('hidden')) {
        cartDiv.classList.remove('hidden');
        chevron.classList.add('rotate-180');
    } else {
        cartDiv.classList.add('hidden');
        chevron.classList.remove('rotate-180');
    }
}

function filterByHours(hours) {
    const url = new URL(window.location);
    url.searchParams.set('hours', hours);
    window.location.href = url.toString();
}

function sendRecoveryEmail(customerId) {
    if (confirm('Send cart recovery email to this customer?')) {
        // Implementation would go here
        alert('Recovery email feature would be implemented here');
    }
}

function sendRecoveryEmails() {
    if (confirm('Send recovery emails to all customers with abandoned carts?')) {
        // Implementation would go here
        alert('Bulk recovery email feature would be implemented here');
    }
}

function convertToOrder(userId) {
    if (confirm('Convert this abandoned cart to a manual order?')) {
        // Implementation would go here
        alert('Cart conversion feature would be implemented here');
    }
}

function deleteAbandonedCart(userId) {
    if (confirm('Are you sure you want to delete this abandoned cart? This action cannot be undone.')) {
        // Get all cart IDs for this user/session
        const cartItems = document.querySelectorAll(`#cart-${userId} [data-cart-id]`);
        const cartIds = Array.from(cartItems).map(item => item.dataset.cartId);
        
        // Delete each cart item
        Promise.all(cartIds.map(cartId => 
            fetch(`/admin/shop/carts/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
        )).then(() => {
            location.reload();
        }).catch(() => {
            alert('Failed to delete cart');
        });
    }
}

// Auto-refresh every 5 minutes to update abandonment times
setInterval(function() {
    location.reload();
}, 5 * 60 * 1000);
</script>
@endsection