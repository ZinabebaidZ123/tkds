{{-- File: resources/views/admin/shop/carts/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Cart Management')
@section('page-title', 'Cart Management')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Cart Management</h2>
            <p class="text-gray-600 text-sm mt-1">Monitor customer shopping carts and abandoned carts</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.shop.carts.abandoned') }}" 
               class="inline-flex items-center px-4 py-2 bg-orange-500 text-white rounded-xl hover:bg-orange-600 transition-colors duration-200">
                <i class="fas fa-shopping-cart mr-2"></i>
                Abandoned Carts ({{ $stats['abandoned_carts'] }})
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Carts</p>
                    <p class="text-2xl font-bold">{{ $stats['total_carts'] }}</p>
                </div>
                <i class="fas fa-shopping-cart text-2xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">User Carts</p>
                    <p class="text-2xl font-bold">{{ $stats['user_carts'] }}</p>
                </div>
                <i class="fas fa-user text-2xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Guest Carts</p>
                    <p class="text-2xl font-bold">{{ $stats['guest_carts'] }}</p>
                </div>
                <i class="fas fa-user-secret text-2xl text-yellow-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Abandoned</p>
                    <p class="text-2xl font-bold">{{ $stats['abandoned_carts'] }}</p>
                </div>
                <i class="fas fa-clock text-2xl text-red-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Value</p>
                    <p class="text-2xl font-bold">${{ number_format($stats['total_value'], 0) }}</p>
                </div>
                <i class="fas fa-dollar-sign text-2xl text-purple-200"></i>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <form method="GET" class="flex space-x-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by customer name, email, or product..." 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.shop.carts.index') }}" 
                   class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Carts Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        @if($carts->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Quantity</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Price</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Added</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($carts as $cart)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    @if($cart->user)
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $cart->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $cart->user->email }}</div>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                                <i class="fas fa-user mr-1"></i>Registered
                                            </span>
                                        </div>
                                    @else
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">Guest User</div>
                                            <div class="text-xs text-gray-500">Session: {{ Str::limit($cart->session_id, 10) }}...</div>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-1">
                                                <i class="fas fa-user-secret mr-1"></i>Guest
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($cart->product)
                                        <div class="flex items-center space-x-3">
                                            <img src="{{ $cart->product->getFeaturedImageUrl() }}" 
                                                 alt="{{ $cart->product->name }}" 
                                                 class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ Str::limit($cart->product->name, 30) }}</div>
                                                <div class="text-xs text-gray-500">{{ $cart->product->sku ?: 'No SKU' }}</div>
                                                @if($cart->product->category)
                                                    <div class="text-xs text-gray-400">{{ $cart->product->category->name }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-sm text-red-600">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Product Deleted
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-gray-900">{{ $cart->quantity }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($cart->product)
                                        <span class="text-sm font-semibold text-gray-900">{{ $cart->product->getFormattedPrice() }}</span>
                                    @else
                                        <span class="text-sm text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($cart->product)
                                        <span class="text-sm font-bold text-gray-900">{{ $cart->getFormattedSubtotal() }}</span>
                                    @else
                                        <span class="text-sm text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $cart->created_at->format('M j, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $cart->created_at->format('g:i A') }}</div>
                                    <div class="text-xs text-gray-400">{{ $cart->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $hoursOld = $cart->created_at->diffInHours(now());
                                        $isAbandoned = $hoursOld >= 24;
                                    @endphp
                                    
                                    @if($isAbandoned)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Abandoned
                                        </span>
                                    @elseif($hoursOld >= 1)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-hourglass-half mr-1"></i>
                                            Inactive ({{ $hoursOld }}h)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-shopping-cart mr-1"></i>
                                            Active
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        @if($cart->user)
                                            <a href="{{ route('admin.users.show', $cart->user) }}" 
                                               class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                               title="View Customer">
                                                <i class="fas fa-user"></i>
                                            </a>
                                        @endif
                                        
                                        @if($cart->product)
                                            <a href="{{ route('admin.shop.products.show', $cart->product) }}" 
                                               class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                               title="View Product">
                                                <i class="fas fa-cube"></i>
                                            </a>
                                        @endif
                                        
                                        <button onclick="deleteCart({{ $cart->id }})" 
                                                class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                                title="Delete Cart Item">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $carts->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-shopping-cart text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No carts found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Shopping carts will appear here when customers add products.</p>
            </div>
        @endif
    </div>
</div>

<script>
function deleteCart(cartId) {
    if (confirm('Are you sure you want to delete this cart item?')) {
        fetch(`{{ route('admin.shop.carts.index') }}/${cartId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to delete cart item');
            }
        });
    }
}
</script>
@endsection