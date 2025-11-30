{{-- File: resources/views/shop/partials/product-grid.blade.php --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="productGrid">
    @forelse($products as $product)
        <div class="product-item group" data-product-id="{{ $product->id }}" data-aos="fade-up" data-aos-delay="{{ ($loop->index * 100) }}">
            <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-primary/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20">
                
                <!-- Product Image -->
                <div class="relative h-64 overflow-hidden group/image">
                    <img src="{{ $product->getFeaturedImageUrl() }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover group-hover/image:scale-110 transition-transform duration-700"
                         loading="lazy">
                    
                    <!-- Overlay on hover -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Product Badges -->
                    <div class="absolute top-4 left-4 space-y-2">
                        @php $stockBadge = $product->getStockBadge() @endphp
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $stockBadge['class'] }}">
                            <i class="{{ $stockBadge['icon'] }} mr-1"></i>
                            {{ $stockBadge['text'] }}
                        </span>
                        
                        @if($product->is_featured)
                            <span class="block px-3 py-1 bg-gradient-to-r from-primary to-secondary text-white text-xs font-bold rounded-full">
                                <i class="fas fa-star mr-1"></i>Featured
                            </span>
                        @endif
                        
                        @if($product->getDiscountPercentage() > 0)
                            <span class="block px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full animate-pulse">
                                <i class="fas fa-fire mr-1"></i>-{{ $product->getDiscountPercentage() }}%
                            </span>
                        @endif
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="absolute top-4 right-4 space-y-2 opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0 transition-all duration-300">

                        
                        <button class="quick-view-btn w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-primary/30 hover:text-primary transition-all duration-300 transform hover:scale-110"
                                data-product-id="{{ $product->id }}" 
                                title="Quick View"
                                onclick="showQuickView({{ $product->id }})">
                            <i class="fas fa-eye"></i>
                        </button>
                        
                        {{-- <button class="compare-btn w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-blue-500/30 hover:text-blue-400 transition-all duration-300 transform hover:scale-110"
                                data-product-id="{{ $product->id }}" 
                                title="Add to Compare"
                                onclick="addToCompare({{ $product->id }})">
                            <i class="fas fa-balance-scale"></i>
                        </button> --}}
                    </div>

                    <!-- Quick Add to Cart -->
                    <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                        @if($product->canPurchase())
                            <button class="add-to-cart-btn w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg" 
                                    data-product-id="{{ $product->id }}"
                                    onclick="addToCart({{ $product->id }})">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                        @else
                            <button class="w-full bg-gray-600 text-gray-400 py-3 rounded-xl font-semibold cursor-not-allowed" disabled>
                                <i class="fas fa-ban mr-2"></i>
                                Out of Stock
                            </button>
                        @endif
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="p-6">
                    <!-- Category & Type -->
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-gray-400">{{ $product->category?->name ?? 'Uncategorized' }}</span>
                        @php $typeBadge = $product->getTypeBadge() @endphp
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $typeBadge['class'] }}">
                            <i class="{{ $typeBadge['icon'] }} mr-1"></i>
                            {{ $typeBadge['text'] }}
                        </span>
                    </div>
                    
                    <!-- Product Name -->
                    <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary transition-colors duration-300 line-clamp-2 min-h-[3.5rem]">
                        <a href="{{ route('shop.product', $product->slug) }}" class="hover:no-underline">
                            {{ $product->name }}
                        </a>
                    </h3>
                    
                    <!-- Rating -->
                    @if($product->getReviewsCount() > 0)
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="flex space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $product->getAverageRating())
                                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                                    @elseif($i - 0.5 <= $product->getAverageRating())
                                        <i class="fas fa-star-half-alt text-yellow-400 text-sm"></i>
                                    @else
                                        <i class="fas fa-star text-gray-400 text-sm"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-400">
                                {{ number_format($product->getAverageRating(), 1) }} 
                                ({{ $product->getReviewsCount() }})
                            </span>
                        </div>
                    @else
                        <div class="mb-4">
                            <span class="text-sm text-gray-400">No reviews yet</span>
                        </div>
                    @endif
                    
                    <!-- Price -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl font-black text-primary">{{ $product->getFormattedPrice() }}</span>
                            @if($product->getFormattedOriginalPrice())
                                <span class="text-lg text-gray-400 line-through">{{ $product->getFormattedOriginalPrice() }}</span>
                            @endif
                        </div>
                        @if($product->getDiscountPercentage() > 0)
                            <span class="bg-red-500 text-white px-2 py-1 rounded text-sm font-bold pulse-animation">
                                -{{ $product->getDiscountPercentage() }}%
                            </span>
                        @endif
                    </div>
                    
                    <!-- Short Description or Features -->
                    @if($product->short_description)
                        <p class="text-sm text-gray-400 mb-4 line-clamp-2">{{ $product->short_description }}</p>
                    @elseif($product->features && count($product->features) > 0)
                        <ul class="text-sm text-gray-400 space-y-1 mb-4">
                            @foreach(array_slice($product->features, 0, 2) as $feature)
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-400 mr-2 mt-0.5 flex-shrink-0 text-xs"></i>
                                    <span class="line-clamp-1">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    
                    <!-- Stock Status -->
                    @if($product->isPhysical() && $product->manage_stock && $product->stock_quantity <= 10)
                        <div class="mb-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-400">Stock:</span>
                                <span class="text-orange-400 font-medium">{{ $product->stock_quantity }} left</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-1.5 mt-1">
                                <div class="bg-gradient-to-r from-orange-500 to-red-500 h-1.5 rounded-full transition-all duration-500" 
                                     style="width: {{ min(($product->stock_quantity / 20) * 100, 100) }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Product Actions Footer -->
                <div class="px-6 pb-6 pt-0">
                    <div class="flex space-x-3">
                        <a href="{{ route('shop.product', $product->slug) }}" 
                           class="flex-1 text-center px-4 py-3 bg-white/10 text-white rounded-xl hover:bg-white/20 transition-all duration-300 text-sm font-medium group">
                            <i class="fas fa-eye mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                            View Details
                        </a>
                        
                        @if($product->canPurchase())
                            <button class="add-to-cart-btn flex-1 text-center px-4 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 text-sm font-medium transform hover:scale-105"
                                    data-product-id="{{ $product->id }}"
                                    onclick="addToCart({{ $product->id }})">
                                <i class="fas fa-cart-plus mr-2"></i>
                                Add to Cart
                            </button>
                        @else
                            <button class="flex-1 text-center px-4 py-3 bg-gray-600 text-gray-400 rounded-xl cursor-not-allowed text-sm font-medium" disabled>
                                <i class="fas fa-ban mr-2"></i>
                                Unavailable
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <!-- Empty State -->
        <div class="col-span-full text-center py-16">
            <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-search text-4xl text-primary"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">No Products Found</h3>
            <p class="text-gray-400 mb-6 max-w-md mx-auto">
                We couldn't find any products matching your criteria. Try adjusting your filters or search terms.
            </p>
            <a href="{{ route('shop.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i>
                Browse All Products
            </a>
        </div>
    @endforelse
</div>

<!-- Loading State for AJAX -->
<div id="productGridLoading" class="hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @for($i = 1; $i <= 8; $i++)
            <div class="animate-pulse">
                <div class="bg-white/5 rounded-2xl overflow-hidden">
                    <div class="h-64 bg-gray-700"></div>
                    <div class="p-6 space-y-4">
                        <div class="h-4 bg-gray-700 rounded w-1/2"></div>
                        <div class="h-6 bg-gray-700 rounded"></div>
                        <div class="h-4 bg-gray-700 rounded w-3/4"></div>
                        <div class="flex space-x-3">
                            <div class="flex-1 h-10 bg-gray-700 rounded"></div>
                            <div class="flex-1 h-10 bg-gray-700 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>

<style>
/* Product Grid Animations */
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

.pulse-animation {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Enhanced hover effects */
.product-item:hover .add-to-cart-btn {
    transform: translateY(0) scale(1.02);
}

.product-item .quick-view-btn:hover,
.product-item .wishlist-btn:hover,
.product-item .compare-btn:hover {
    transform: scale(1.15);
    backdrop-filter: blur(20px);
}

/* Staggered animation for grid items */
.product-item:nth-child(1) { animation-delay: 0s; }
.product-item:nth-child(2) { animation-delay: 0.1s; }
.product-item:nth-child(3) { animation-delay: 0.2s; }
.product-item:nth-child(4) { animation-delay: 0.3s; }
.product-item:nth-child(5) { animation-delay: 0.4s; }
.product-item:nth-child(6) { animation-delay: 0.5s; }
.product-item:nth-child(7) { animation-delay: 0.6s; }
.product-item:nth-child(8) { animation-delay: 0.7s; }

/* Loading animation */
@keyframes shimmer {
    0% {
        background-position: -200px 0;
    }
    100% {
        background-position: calc(200px + 100%) 0;
    }
}

.animate-shimmer {
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    background-size: 200px 100%;
    animation: shimmer 1.5s infinite;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .product-item .quick-actions {
        opacity: 1;
        transform: translateX(0);
    }
    
    .product-item .quick-add-cart {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Focus states for accessibility */
.add-to-cart-btn:focus,
.quick-view-btn:focus,
.wishlist-btn:focus,
.compare-btn:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(197, 48, 48, 0.3);
}
</style>

<script>
// Global functions for product interactions
function addToCart(productId) {
    const button = document.querySelector(`[data-product-id="${productId}"].add-to-cart-btn`);
    const originalHTML = button.innerHTML;
    
    // Update button state
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Adding...';
    button.disabled = true;
    
    fetch('{{ route("shop.cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart UI if cart sidebar exists
            if (typeof loadCartData === 'function') {
                loadCartData();
            }
            
            // Show success state
            button.innerHTML = '<i class="fas fa-check mr-2"></i>Added!';
            button.classList.add('bg-green-500');
            
            // Reset after 2 seconds
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('bg-green-500');
                button.disabled = false;
            }, 2000);
            
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message || 'Failed to add to cart', 'error');
            button.innerHTML = originalHTML;
            button.disabled = false;
        }
    })
    .catch(error => {
        showNotification('Something went wrong', 'error');
        button.innerHTML = originalHTML;
        button.disabled = false;
    });
}

function showQuickView(productId) {
    // Find the product element to get the slug
    const productElement = document.querySelector(`[data-product-id="${productId}"]`);
    let productSlug = null;
    
    // Try to find the slug from the product link
    const productLink = productElement.querySelector('a[href*="/shop/product/"]');
    if (productLink) {
        const href = productLink.getAttribute('href');
        const matches = href.match(/\/shop\/product\/([^\/]+)/);
        if (matches) {
            productSlug = matches[1];
        }
    }
    
    // If we can't find the slug, fall back to using ID (not recommended but works)
    if (!productSlug) {
        console.warn('Could not find product slug, using ID instead');
        productSlug = productId;
    }
    
    // Create modal backdrop
    const modal = document.createElement('div');
    modal.id = 'quickViewModal';
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="bg-dark rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-white">Quick View</h3>
                    <button onclick="closeQuickView()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="quickViewContent" class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-primary text-2xl mb-4"></i>
                    <p class="text-gray-400">Loading product details...</p>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
    
    // Load product data using slug
    fetch(`/shop/product/${productSlug}/quick-view`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderQuickView(data.product);
            } else {
                document.getElementById('quickViewContent').innerHTML = `
                    <p class="text-red-400">Failed to load product details</p>
                `;
            }
        })
        .catch(error => {
            console.error('Quick view error:', error);
            document.getElementById('quickViewContent').innerHTML = `
                <p class="text-red-400">Error loading product details</p>
            `;
        });
}


function closeQuickView() {
    const modal = document.getElementById('quickViewModal');
    if (modal) {
        modal.remove();
        document.body.style.overflow = 'auto';
    }
}

function renderQuickView(product) {
    const content = document.getElementById('quickViewContent');
    content.innerHTML = `
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="space-y-4">
                <img src="${product.featured_image}" alt="${product.name}" class="w-full h-80 object-cover rounded-xl">
                ${product.gallery && product.gallery.length > 0 ? `
                    <div class="grid grid-cols-4 gap-2">
                        ${product.gallery.slice(0, 4).map(img => `
                            <img src="${img}" alt="${product.name}" class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-75 transition-opacity">
                        `).join('')}
                    </div>
                ` : ''}
            </div>
            
            <!-- Product Info -->
            <div class="text-left space-y-4">
                <div>
                    <span class="text-sm text-gray-400">${product.category || 'Uncategorized'}</span>
                    <h3 class="text-2xl font-bold text-white mt-1">${product.name}</h3>
                </div>
                
                ${product.rating > 0 ? `
                    <div class="flex items-center space-x-2">
                        <div class="flex space-x-1">
                            ${Array.from({length: 5}, (_, i) => `
                                <i class="fas fa-star ${i < Math.floor(product.rating) ? 'text-yellow-400' : 'text-gray-400'} text-sm"></i>
                            `).join('')}
                        </div>
                        <span class="text-sm text-gray-400">${product.rating} (${product.reviews_count} reviews)</span>
                    </div>
                ` : ''}
                
                <div class="flex items-center space-x-4">
                    <span class="text-3xl font-black text-primary">${product.formatted_price}</span>
                    ${product.original_price ? `<span class="text-xl text-gray-400 line-through">${product.original_price}</span>` : ''}
                    ${product.discount_percentage > 0 ? `<span class="bg-red-500 text-white px-2 py-1 rounded text-sm font-bold">-${product.discount_percentage}%</span>` : ''}
                </div>
                
                ${product.short_description ? `<p class="text-gray-300">${product.short_description}</p>` : ''}
                
                ${product.features && product.features.length > 0 ? `
                    <div>
                        <h4 class="text-white font-semibold mb-2">Key Features:</h4>
                        <ul class="space-y-1">
                            ${product.features.slice(0, 5).map(feature => `
                                <li class="flex items-start text-sm text-gray-300">
                                    <i class="fas fa-check text-green-400 mr-2 mt-0.5 flex-shrink-0"></i>
                                    ${feature}
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                ` : ''}
                
                <div class="flex space-x-4 pt-4">
                    ${product.can_purchase ? `
                        <button onclick="addToCart(${product.id})" class="flex-1 bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Add to Cart
                        </button>
                    ` : `
                        <button class="flex-1 bg-gray-600 text-gray-400 py-3 rounded-xl font-semibold cursor-not-allowed" disabled>
                            <i class="fas fa-ban mr-2"></i>
                            Unavailable
                        </button>
                    `}
                    <a href="${product.url}" class="flex-1 bg-white/10 text-white py-3 rounded-xl font-semibold hover:bg-white/20 transition-all duration-300 text-center">
                        View Full Details
                    </a>
                </div>
            </div>
        </div>
    `;
}



function showNotification(message, type = 'success') {
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

// Close quick view on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeQuickView();
    }
});

// Close quick view on background click
document.addEventListener('click', function(e) {
    if (e.target.id === 'quickViewModal') {
        closeQuickView();
    }
});
</script>