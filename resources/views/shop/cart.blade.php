{{-- File: resources/views/shop/cart.blade.php --}}
@extends('layouts.app')

@section('title', 'Shopping Cart - TKDS Media')
@section('meta_description', 'Review your selected products and proceed to checkout')

@section('content')

<!-- Breadcrumbs -->
<section class="bg-dark-light py-4 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">Home</a>
            <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
            <a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">Shop</a>
            <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
            <span class="text-white">Shopping Cart</span>
        </nav>
    </div>
</section>

<!-- Cart Content -->
<section class="py-16 bg-dark min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Cart Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h1 class="text-3xl md:text-4xl font-black text-white mb-4">Shopping Cart</h1>
            <p class="text-gray-400">Review your items and proceed to checkout</p>
        </div>

        <div id="cartPageContent">
            <!-- Cart items will be loaded here -->
            <div class="text-center py-16">
                <div class="animate-spin w-8 h-8 border-2 border-primary border-t-transparent rounded-full mx-auto mb-4"></div>
                <p class="text-gray-400">Loading cart...</p>
            </div>
        </div>
    </div>
</section>

<!-- Cart Content Template -->
<template id="cartContentTemplate">
    <div class="grid lg:grid-cols-3 gap-12">
        
        <!-- Cart Items -->
        <div class="lg:col-span-2">
<div class="bg-white/5 backdrop-blur-xl rounded-xl p-3 md:p-6 border border-white/10">
                <!-- Cart Items Header -->
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/10">
                    <h2 class="text-xl font-bold text-white">Cart Items</h2>
                    <button id="clearCartBtn" class="text-red-400 hover:text-red-300 transition-colors duration-200 text-sm">
                        <i class="fas fa-trash mr-1"></i>
                        Clear Cart
                    </button>
                </div>

                <!-- Items List -->
                <div id="cartItemsList" class="space-y-6">
                    <!-- Cart items will be inserted here -->
                </div>
            </div>

            <!-- Continue Shopping -->
            <div class="mt-8">
                <a href="{{ route('shop.index') }}" 
                   class="inline-flex items-center space-x-2 text-primary hover:text-secondary transition-colors duration-200">
                    <i class="fas fa-arrow-left"></i>
                    <span>Continue Shopping</span>
                </a>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="lg:col-span-1">
<div class="bg-white/5 backdrop-blur-xl rounded-xl p-3 md:p-6 border border-white/10 sticky top-8">
                    <h2 class="text-xl font-bold text-white mb-6">Order Summary</h2>

                <!-- Summary Details -->
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Subtotal (<span id="itemsCount">0</span> items):</span>
                        <span id="subtotalAmount" class="text-white font-semibold">$0.00</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-400">Shipping:</span>
                        <span id="shippingAmount" class="text-white">Calculated at checkout</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-400">Tax:</span>
                        <span id="taxAmount" class="text-white">Calculated at checkout</span>
                    </div>

                    <div class="border-t border-white/10 pt-4">
                        <div class="flex justify-between">
                            <span class="text-lg font-bold text-white">Total:</span>
                            <span id="totalAmount" class="text-lg font-bold text-primary">$0.00</span>
                        </div>
                    </div>
                </div>

                <!-- Promo Code -->
                <div class="mb-6">
                    <div class="flex space-x-2">
                        <input type="text" id="promoCode" placeholder="Promo code" 
                               class="flex-1 px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary">
                        <button id="applyPromoBtn" 
                                class="px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300">
                            Apply
                        </button>
                    </div>
                </div>

                <!-- Checkout Button -->
                <button id="proceedCheckoutBtn" 
                        class="w-full bg-gradient-to-r from-primary to-secondary text-white py-4 rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl mb-4">
                    <i class="fas fa-lock mr-2"></i>
                    Secure Checkout
                </button>

                <!-- Security Badges -->
                <div class="grid grid-cols-3 gap-4 text-center text-xs text-gray-400">
                    <div>
                        <i class="fas fa-shield-alt text-green-400 text-lg mb-1"></i>
                        <p>SSL Secured</p>
                    </div>
                    <div>
                        <i class="fas fa-lock text-green-400 text-lg mb-1"></i>
                        <p>Safe Payment</p>
                    </div>
                    <div>
                        <i class="fas fa-undo text-green-400 text-lg mb-1"></i>
                        <p>Easy Returns</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- Empty Cart Template -->
<template id="emptyCartTemplate">
    <div class="text-center py-16">
        <div class="mx-auto h-32 w-32 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-8">
            <i class="fas fa-shopping-cart text-6xl text-primary"></i>
        </div>
        <h2 class="text-2xl font-bold text-white mb-4">Your cart is empty</h2>
        <p class="text-gray-400 mb-8 max-w-md mx-auto">
            Looks like you haven't added any items to your cart yet. 
            Start shopping to fill it up!
        </p>
        <a href="{{ route('shop.index') }}" 
           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
            <i class="fas fa-shopping-bag mr-2"></i>
            Start Shopping
        </a>
    </div>
</template>

<!-- Cart Item Template -->
<template id="cartItemTemplate">
    <div class="cart-item flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6 p-6 bg-white/5 rounded-xl border border-white/10">
        <!-- Product Image -->
        <div class="flex-shrink-0">
            <img class="item-image w-24 h-24 md:w-32 md:h-32 object-cover rounded-xl border border-white/20" src="" alt="">
        </div>

        <!-- Product Info -->
        <div class="flex-1 min-w-0">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                <div class="flex-1 mb-4 md:mb-0">
                    <h3 class="item-name text-lg font-bold text-white mb-1"></h3>
                    <p class="item-category text-gray-400 text-sm mb-2"></p>
                    <div class="item-type-badge inline-flex items-center px-2 py-1 rounded-full text-xs font-medium mb-2">
                        <i class="item-type-icon mr-1"></i>
                        <span class="item-type-text"></span>
                    </div>
                    <p class="item-sku text-gray-500 text-xs"></p>
                </div>

                <!-- Price & Quantity -->
                <div class="flex flex-col md:items-end space-y-4">
                    <!-- Price -->
                    <div class="text-right">
                        <p class="item-price text-xl font-bold text-primary mb-1"></p>
                        <p class="item-original-price text-sm text-gray-400 line-through" style="display: none;"></p>
                    </div>

                    <!-- Quantity Controls -->
                    <div class="flex items-center space-x-3">
                        <button class="decrease-qty w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center text-white hover:bg-red-500/20 hover:text-red-400 transition-all duration-300">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="item-quantity text-white font-semibold w-12 text-center text-lg"></span>
                        <button class="increase-qty w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center text-white hover:bg-green-500/20 hover:text-green-400 transition-all duration-300">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    <!-- Subtotal & Remove -->
                    <div class="flex items-center justify-between md:justify-end space-x-4">
                        <div class="text-right">
                            <p class="text-sm text-gray-400">Subtotal:</p>
                            <p class="item-subtotal text-lg font-bold text-white"></p>
                        </div>
                        <button class="remove-item w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center text-red-400 hover:bg-red-500/30 hover:text-red-300 transition-all duration-300">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
class CartPage {
    constructor() {
        this.items = [];
        this.summary = {};
        this.init();
    }

    init() {
        this.loadCart();
        this.bindEvents();
    }

    bindEvents() {
        // Clear cart
        document.addEventListener('click', (e) => {
            if (e.target.closest('#clearCartBtn')) {
                this.clearCart();
            }
        });

        // Proceed to checkout
        document.addEventListener('click', (e) => {
            if (e.target.closest('#proceedCheckoutBtn')) {
                this.proceedToCheckout();
            }
        });

        // Apply promo code
        document.addEventListener('click', (e) => {
            if (e.target.closest('#applyPromoBtn')) {
                this.applyPromoCode();
            }
        });
    }

    async loadCart() {
        try {
            const response = await fetch('{{ route("shop.cart.items") }}');
            const data = await response.json();
            
            if (data.success) {
                this.items = data.items;
                this.summary = data.summary;
                this.renderCart();
            } else {
                this.renderEmptyCart();
            }
        } catch (error) {
            console.error('Failed to load cart:', error);
            this.showNotification('Failed to load cart', 'error');
        }
    }

    renderCart() {
        const container = document.getElementById('cartPageContent');
        
        if (this.items.length === 0) {
            this.renderEmptyCart();
            return;
        }

        // Use cart content template
        const template = document.getElementById('cartContentTemplate');
        const content = template.content.cloneNode(true);
        
        container.innerHTML = '';
        container.appendChild(content);

        // Render items
        this.renderItems();
        
        // Update summary
        this.updateSummary();
    }

    renderEmptyCart() {
        const container = document.getElementById('cartPageContent');
        const template = document.getElementById('emptyCartTemplate');
        const content = template.content.cloneNode(true);
        
        container.innerHTML = '';
        container.appendChild(content);
    }

    renderItems() {
        const itemsList = document.getElementById('cartItemsList');
        const itemTemplate = document.getElementById('cartItemTemplate');
        
        itemsList.innerHTML = '';

        this.items.forEach(item => {
            const itemElement = itemTemplate.content.cloneNode(true);
            
            // Populate item data
            itemElement.querySelector('.item-image').src = item.product_image;
            itemElement.querySelector('.item-image').alt = item.product_name;
            itemElement.querySelector('.item-name').textContent = item.product_name;
            itemElement.querySelector('.item-category').textContent = item.product_category || 'Uncategorized';
            itemElement.querySelector('.item-sku').textContent = `SKU: ${item.product_id}`;
            itemElement.querySelector('.item-price').textContent = item.product_price;
            itemElement.querySelector('.item-quantity').textContent = item.quantity;
            itemElement.querySelector('.item-subtotal').textContent = item.subtotal;

            // Type badge
            const typeBadge = itemElement.querySelector('.item-type-badge');
            const typeIcon = itemElement.querySelector('.item-type-icon');
            const typeText = itemElement.querySelector('.item-type-text');
            
            if (item.product_type === 'software') {
                typeBadge.className = 'item-type-badge inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-500/20 text-purple-400';
                typeIcon.className = 'fas fa-download mr-1';
                typeText.textContent = 'Digital Download';
            } else {
                typeBadge.className = 'item-type-badge inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400';
                typeIcon.className = 'fas fa-box mr-1';
                typeText.textContent = 'Physical Product';
            }

            // Show original price if on sale
            if (item.original_price && item.original_price !== item.product_price) {
                const originalPriceEl = itemElement.querySelector('.item-original-price');
                originalPriceEl.textContent = item.original_price;
                originalPriceEl.style.display = 'block';
            }

            // Bind events
            const decreaseBtn = itemElement.querySelector('.decrease-qty');
            const increaseBtn = itemElement.querySelector('.increase-qty');
            const removeBtn = itemElement.querySelector('.remove-item');

            decreaseBtn.addEventListener('click', () => {
                const newQty = Math.max(0, item.quantity - 1);
                this.updateQuantity(item.product_id, newQty);
            });

            increaseBtn.addEventListener('click', () => {
                if (item.can_increase) {
                    this.updateQuantity(item.product_id, item.quantity + 1);
                } else {
                    this.showNotification('Cannot add more of this item', 'warning');
                }
            });

            removeBtn.addEventListener('click', () => {
                this.removeItem(item.product_id);
            });

            // Disable increase button if can't add more
            if (!item.can_increase) {
                increaseBtn.disabled = true;
                increaseBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }

            itemsList.appendChild(itemElement);
        });
    }

    updateSummary() {
        document.getElementById('itemsCount').textContent = this.summary.items_count || 0;
        document.getElementById('subtotalAmount').textContent = this.summary.subtotal_formatted || '$0.00';
        
        // Update shipping
        const shippingEl = document.getElementById('shippingAmount');
        if (this.summary.shipping_formatted) {
            shippingEl.textContent = this.summary.shipping_formatted;
        }

        // Update tax
        const taxEl = document.getElementById('taxAmount');
        if (this.summary.tax_formatted) {
            taxEl.textContent = this.summary.tax_formatted;
        }

        // Update total
        document.getElementById('totalAmount').textContent = this.summary.total_formatted || '$0.00';

        // Show shipping info if applicable
        if (this.summary.free_shipping_eligible) {
            this.showShippingInfo('🎉 You qualify for free shipping!', 'success');
        } else if (this.summary.free_shipping_remaining && this.summary.free_shipping_remaining > 0) {
            this.showShippingInfo(`Add $${this.summary.free_shipping_remaining.toFixed(2)} more for free shipping`, 'info');
        }
    }

    showShippingInfo(message, type) {
        // Add shipping info banner if it doesn't exist
        let banner = document.getElementById('shippingBanner');
        if (!banner) {
            banner = document.createElement('div');
            banner.id = 'shippingBanner';
            banner.className = 'mb-4 p-3 rounded-lg text-sm text-center';
            document.querySelector('.lg\\:col-span-1 .bg-white\\/5').insertBefore(banner, document.querySelector('.lg\\:col-span-1 .bg-white\\/5').firstChild);
        }

        const colors = {
            success: 'bg-green-500/20 text-green-400 border border-green-500/30',
            info: 'bg-blue-500/20 text-blue-400 border border-blue-500/30'
        };

        banner.className = `mb-4 p-3 rounded-lg text-sm text-center ${colors[type]}`;
        banner.textContent = message;
    }

    async updateQuantity(productId, quantity) {
        try {
            const response = await fetch('{{ route("shop.cart.update") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.loadCart(); // Reload cart
                if (data.item_removed) {
                    this.showNotification('Item removed from cart', 'info');
                }
            } else {
                this.showNotification(data.message || 'Failed to update cart', 'error');
            }
        } catch (error) {
            this.showNotification('Something went wrong', 'error');
        }
    }

    async removeItem(productId) {
        try {
            const response = await fetch('{{ route("shop.cart.remove") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.loadCart(); // Reload cart
                this.showNotification(data.message, 'success');
            } else {
                this.showNotification(data.message || 'Failed to remove item', 'error');
            }
        } catch (error) {
            this.showNotification('Something went wrong', 'error');
        }
    }

    async clearCart() {
        if (!confirm('Are you sure you want to clear your cart?')) return;

        try {
            const response = await fetch('{{ route("shop.cart.clear") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();
            
            if (data.success) {
                this.items = [];
                this.summary = {};
                this.renderEmptyCart();
                this.showNotification(data.message, 'success');
            }
        } catch (error) {
            this.showNotification('Failed to clear cart', 'error');
        }
    }

    proceedToCheckout() {
        if (this.items.length === 0) {
            this.showNotification('Your cart is empty', 'warning');
            return;
        }

        @auth
            window.location.href = '{{ route("shop.checkout") }}';
        @else
            // Redirect to login with return URL
            window.location.href = '{{ route("auth.login") }}?redirect={{ urlencode(route("shop.checkout")) }}';
        @endauth
    }

    applyPromoCode() {
        const promoCode = document.getElementById('promoCode').value.trim();
        if (!promoCode) {
            this.showNotification('Please enter a promo code', 'warning');
            return;
        }

        // For now, show a message that promo codes are coming soon
        this.showNotification('Promo code feature coming soon!', 'info');
    }

    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        };
        
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${colors[type]} text-white`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation' : 'info'}-circle mr-2"></i>
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
}

// Initialize cart page
document.addEventListener('DOMContentLoaded', function() {
    new CartPage();
});
</script>

@endsection