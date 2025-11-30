<!-- Cart Toggle Button (Fixed position) -->
<button id="cartToggleBtn" 
        class="fixed bottom-6 right-6 z-40 w-16 h-16 bg-gradient-to-r from-primary to-secondary text-white rounded-full shadow-2xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-110 flex items-center justify-center group">
    <div class="relative">
        <i class="fas fa-shopping-cart text-xl group-hover:scale-110 transition-transform duration-300"></i>
        <span id="cartCount" 
              class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center transform scale-0 transition-transform duration-300">
            0
        </span>
    </div>
</button>

<!-- Cart Sidebar -->
<div id="cartSidebar" class="fixed top-0 right-0 h-full w-96 bg-gradient-to-b from-dark via-dark-light to-dark backdrop-blur-xl border-l border-white/10 transform translate-x-full transition-transform duration-500 z-50 flex flex-col">
    
    <!-- Cart Header -->
    <div class="p-6 border-b border-white/10 flex-shrink-0">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-shopping-cart mr-3 text-primary"></i>
                Shopping Cart
            </h3>
            <button id="closeCartBtn" 
                    class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-red-500/20 hover:text-red-400 transition-all duration-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mt-2">
            <span id="cartItemsCount" class="text-sm text-gray-400">0 items</span>
        </div>
    </div>
    
    <!-- Cart Items Container -->
    <div class="flex-1 overflow-y-auto custom-scrollbar">
        <div id="cartItems" class="p-6">
            <!-- Cart items will be dynamically loaded here -->
            <div id="emptyCartMessage" class="text-center text-gray-400 py-12">
                <i class="fas fa-shopping-cart text-4xl mb-4 opacity-50"></i>
                <p class="text-lg font-medium mb-2">Your cart is empty</p>
                <p class="text-sm">Add some products to get started!</p>
            </div>
        </div>
    </div>
    
    <!-- Cart Footer -->
    <div id="cartFooter" class="p-6 border-t border-white/10 bg-dark-light/50 flex-shrink-0 hidden">
        <!-- Cart Summary -->
        <div class="space-y-4 mb-6">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-400">Subtotal:</span>
                <span id="cartSubtotal" class="text-white font-semibold">$0.00</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-400">Shipping:</span>
                <span id="cartShipping" class="text-white font-semibold">Free</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-400">Tax:</span>
                <span id="cartTax" class="text-white font-semibold">$0.00</span>
            </div>
            <div class="border-t border-white/10 pt-4">
                <div class="flex items-center justify-between text-lg">
                    <span class="text-white font-bold">Total:</span>
                    <span id="cartTotal" class="text-primary font-black text-xl">$0.00</span>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="{{ route('shop.cart') }}" 
               class="w-full inline-flex items-center justify-center px-6 py-3 bg-white/10 text-white rounded-xl font-semibold hover:bg-white/20 transition-all duration-300">
                <i class="fas fa-shopping-cart mr-2"></i>
                View Cart
            </a>
            
            @auth
                <a href="{{ route('shop.checkout') }}" 
                   id="checkoutBtn"
                   class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-credit-card mr-2"></i>
                    Proceed to Checkout
                </a>
            @else
                <a href="{{ route('auth.login') }}" 
                   class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login to Checkout
                </a>
            @endauth
            
            <button id="clearCartBtn" 
                    class="w-full px-6 py-2 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl transition-all duration-300 text-sm font-medium">
                <i class="fas fa-trash mr-2"></i>
                Clear Cart
            </button>
        </div>
    </div>
</div>

<!-- Cart Overlay -->
<div id="cartOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm opacity-0 invisible transition-all duration-300 z-40"></div>

<!-- Cart Item Template -->
<template id="cartItemTemplate">
    <div class="cart-item flex items-center space-x-4 p-4 bg-white/5 rounded-xl mb-4 border border-white/10" data-product-id="">
        <img src="" alt="" class="w-16 h-16 object-cover rounded-lg border border-white/20">
        <div class="flex-1 min-w-0">
            <h4 class="text-white font-semibold text-sm mb-1 line-clamp-2"></h4>
            <p class="text-gray-400 text-xs mb-2"></p>
            <div class="flex items-center justify-between">
                <span class="text-primary font-bold text-sm"></span>
                <div class="flex items-center space-x-2">
                    <button class="quantity-decrease w-8 h-8 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-red-500/20 hover:text-red-400 transition-all duration-300">
                        <i class="fas fa-minus text-xs"></i>
                    </button>
                    <span class="quantity-display text-white font-semibold w-8 text-center"></span>
                    <button class="quantity-increase w-8 h-8 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-green-500/20 hover:text-green-400 transition-all duration-300">
                        <i class="fas fa-plus text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
        <button class="remove-item w-8 h-8 bg-white/10 rounded-full flex items-center justify-center text-gray-400 hover:bg-red-500/20 hover:text-red-400 transition-all duration-300">
            <i class="fas fa-times text-xs"></i>
        </button>
    </div>
</template>

<style>
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: rgba(197, 48, 48, 0.5) rgba(255, 255, 255, 0.1);
}

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(197, 48, 48, 0.5);
    border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(197, 48, 48, 0.8);
}

.cart-item {
    animation: slideInRight 0.3s ease-out;
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeCart();
});

let cart = {
    items: [],
    total: 0,
    subtotal: 0,
    tax: 0,
    shipping: 0
};

function initializeCart() {
    // Load cart from session/API
    loadCartData();
    
    // Bind event listeners
    bindCartEvents();
    
    // Update UI
    updateCartUI();
}

function bindCartEvents() {
    // Toggle cart sidebar
    document.getElementById('cartToggleBtn')?.addEventListener('click', openCart);
    document.getElementById('closeCartBtn')?.addEventListener('click', closeCart);
    document.getElementById('cartOverlay')?.addEventListener('click', closeCart);
    
    // Clear cart
    document.getElementById('clearCartBtn')?.addEventListener('click', clearCart);
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCart();
        }
    });
}

function openCart() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('cartOverlay');
    
    sidebar.classList.remove('translate-x-full');
    overlay.classList.remove('opacity-0', 'invisible');
    document.body.style.overflow = 'hidden';
    
    // Load fresh cart data
    loadCartData();
}

function closeCart() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('cartOverlay');
    
    sidebar.classList.add('translate-x-full');
    overlay.classList.add('opacity-0', 'invisible');
    document.body.style.overflow = 'auto';
}

function loadCartData() {
    fetch('{{ route("shop.cart.items") }}', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cart.items = data.items;
            cart.summary = data.summary;
            updateCartUI();
        }
    })
    .catch(error => {
        console.error('Error loading cart data:', error);
    });
}

function updateCartUI() {
    const cartItems = document.getElementById('cartItems');
    const emptyMessage = document.getElementById('emptyCartMessage');
    const cartFooter = document.getElementById('cartFooter');
    const cartCount = document.getElementById('cartCount');
    const cartItemsCount = document.getElementById('cartItemsCount');
    
    // Update cart count badge
    const totalItems = cart.items.reduce((total, item) => total + item.quantity, 0);
    if (cartCount) {
        cartCount.textContent = totalItems;
        cartCount.classList.toggle('scale-100', totalItems > 0);
        cartCount.classList.toggle('scale-0', totalItems === 0);
    }
    
    if (cartItemsCount) {
        cartItemsCount.textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''}`;
    }
    
    if (cart.items.length === 0) {
        // Show empty message
        emptyMessage?.classList.remove('hidden');
        cartFooter?.classList.add('hidden');
        return;
    }
    
    // Hide empty message and show cart items
    emptyMessage?.classList.add('hidden');
    cartFooter?.classList.remove('hidden');
    
    // Render cart items
    if (cartItems) {
        cartItems.innerHTML = '';
        cart.items.forEach(item => {
            const itemElement = createCartItemElement(item);
            cartItems.appendChild(itemElement);
        });
    }
    
    // Update totals
    if (cart.summary) {
        updateCartTotals(cart.summary);
    }
}

function createCartItemElement(item) {
    const template = document.getElementById('cartItemTemplate');
    const clone = template.content.cloneNode(true);
    const itemElement = clone.querySelector('.cart-item');
    
    // Set product data
    itemElement.dataset.productId = item.product_id;
    
    // Set image
    const img = itemElement.querySelector('img');
    img.src = item.product_image;
    img.alt = item.product_name;
    
    // Set product info
    itemElement.querySelector('h4').textContent = item.product_name;
    itemElement.querySelector('p').textContent = item.product_type === 'software' ? 'Digital Download' : 'Physical Product';
    itemElement.querySelector('.text-primary').textContent = item.product_price;
    itemElement.querySelector('.quantity-display').textContent = item.quantity;
    
    // Bind quantity controls
    const decreaseBtn = itemElement.querySelector('.quantity-decrease');
    const increaseBtn = itemElement.querySelector('.quantity-increase');
    const removeBtn = itemElement.querySelector('.remove-item');
    
    decreaseBtn.addEventListener('click', () => updateQuantity(item.product_id, item.quantity - 1));
    increaseBtn.addEventListener('click', () => updateQuantity(item.product_id, item.quantity + 1));
    removeBtn.addEventListener('click', () => removeFromCart(item.product_id));
    
    return itemElement;
}

function updateQuantity(productId, newQuantity) {
    if (newQuantity < 1) {
        removeFromCart(productId);
        return;
    }
    
    fetch('{{ route("shop.cart.update") }}', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadCartData(); // Refresh cart
            showNotification('Cart updated successfully', 'success');
        } else {
            showNotification(data.message || 'Failed to update cart', 'error');
        }
    })
    .catch(error => {
        showNotification('Something went wrong', 'error');
    });
}

function removeFromCart(productId) {
    fetch('{{ route("shop.cart.remove") }}', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadCartData(); // Refresh cart
            showNotification('Item removed from cart', 'success');
        } else {
            showNotification(data.message || 'Failed to remove item', 'error');
        }
    })
    .catch(error => {
        showNotification('Something went wrong', 'error');
    });
}

function clearCart() {
    if (!confirm('Are you sure you want to clear your cart?')) return;
    
    fetch('{{ route("shop.cart.clear") }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cart.items = [];
            updateCartUI();
            showNotification('Cart cleared successfully', 'success');
        } else {
            showNotification(data.message || 'Failed to clear cart', 'error');
        }
    })
    .catch(error => {
        showNotification('Something went wrong', 'error');
    });
}

function updateCartTotals(summary) {
    document.getElementById('cartSubtotal').textContent = summary.subtotal_formatted;
    document.getElementById('cartShipping').textContent = summary.shipping_formatted;
    document.getElementById('cartTax').textContent = summary.tax_formatted;
    document.getElementById('cartTotal').textContent = summary.total_formatted;
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    
    notification.className = `fixed top-4 right-4 z-[60] px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => notification.classList.remove('translate-x-full'), 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Global function to add to cart from other pages
window.addToCart = function(productId, quantity = 1) {
    fetch('{{ route("shop.cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadCartData(); // Refresh cart
            showNotification('Product added to cart!', 'success');
            
            // Update add to cart button
            const btn = document.querySelector(`[data-product-id="${productId}"].add-to-cart-btn`);
            if (btn) {
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check mr-2"></i>Added!';
                btn.classList.add('bg-green-500');
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove('bg-green-500');
                }, 2000);
            }
        } else {
            showNotification(data.message || 'Failed to add product to cart', 'error');
        }
    })
    .catch(error => {
        showNotification('Something went wrong', 'error');
    });
};
</script>
@endpush