@extends('layouts.app')

@section('title', 'Professional Broadcasting Equipment Shop - TKDS Media')
@section('meta_description', 'Shop professional broadcasting equipment, streaming gear, and media production tools. Premium quality products with worldwide shipping.')

@section('content')

<!-- Hero Section -->
<section class="relative py-32 bg-gradient-to-br from-dark via-dark-light to-dark overflow-hidden mt-20">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-gradient-to-r from-primary via-secondary to-accent rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/3 right-1/4 w-80 h-80 bg-gradient-to-l from-accent via-primary to-secondary rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-lg rounded-full px-8 py-4 border border-primary/20 mb-8">
                <i class="fas fa-shopping-bag text-primary text-xl"></i>
                <span class="text-sm font-semibold tracking-wider uppercase text-primary">Professional Equipment Store</span>
            </div>
            
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-white mb-8 leading-tight">
                Broadcast 
                <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">Equipment</span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed mb-12">
                Professional broadcasting equipment, streaming gear, and production tools. 
                Everything you need to create <span class="text-primary font-semibold">broadcast-quality content</span>
            </p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto relative" data-aos="fade-up" data-aos-delay="200">
                <form action="{{ route('shop.search') }}" method="GET" class="relative">
                    <input type="text" name="q" id="searchInput" placeholder="Search for cameras, microphones, lighting..." 
                           value="{{ request('q') }}"
                           class="w-full px-6 py-4 pl-14 pr-20 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                    <i class="fas fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-primary to-secondary text-white px-6 py-2 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-dark-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Shop by Category</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">Browse our comprehensive collection of professional equipment</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('shop.category', $category->slug) }}" 
                   class="group text-center p-6 bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 hover:border-primary/30 transition-all duration-300 hover:transform hover:-translate-y-2"
                   data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $category->icon ?? 'fas fa-cube' }} text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2 group-hover:text-primary transition-colors duration-300">{{ $category->name }}</h3>
                    <p class="text-gray-400 text-sm">{{ $category->getProductsCount() }} products</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Filters & Sorting -->
<section class="py-8 bg-dark border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between space-y-6 lg:space-y-0">
            <!-- Filter Buttons -->
            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('shop.index') }}" 
                   class="filter-btn {{ !request('category') && !request('type') ? 'active' : '' }} px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                    All Products
                </a>
                <a href="{{ route('shop.index', ['type' => 'physical']) }}" 
                   class="filter-btn {{ request('type') === 'physical' ? 'active' : '' }} px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                    Physical Products
                </a>
                <a href="{{ route('shop.index', ['type' => 'software']) }}" 
                   class="filter-btn {{ request('type') === 'software' ? 'active' : '' }} px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                    Software
                </a>
                <a href="{{ route('shop.index', ['featured' => 1]) }}" 
                   class="filter-btn {{ request('featured') ? 'active' : '' }} px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                    Featured
                </a>
            </div>

            <!-- Sort & View Options -->
            <div class="flex items-center space-x-4">
                <form method="GET" class="flex items-center space-x-4">
                    @foreach(request()->except(['sort']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    
                    <select name="sort" onchange="this.form.submit()" 
                            class="px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="featured" {{ request('sort') === 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="price-low" {{ request('sort') === 'price-low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price-high" {{ request('sort') === 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Highest Rated</option>
                    </select>
                </form>
                
                <div class="text-gray-400">
                    Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="py-20 bg-dark min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($products->count() > 0)
            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="productsGrid">
                @foreach($products as $product)
                    @include('shop.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $products->appends(request()->query())->links('shop.partials.pagination') }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-search text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">No Products Found</h3>
                <p class="text-gray-400 mb-6 max-w-md mx-auto">
                    @if(request('q'))
                        No products found for "{{ request('q') }}". Try different keywords.
                    @else
                        No products available in this category.
                    @endif
                </p>
                <a href="{{ route('shop.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Browse All Products
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Featured Categories Showcase -->
@if($featuredProducts->count() > 0)
<section class="py-20 bg-dark-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Featured Products</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">Hand-picked professional equipment trusted by industry leaders</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredProducts as $product)
                @include('shop.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Stats & Trust Indicators -->
<section class="py-20 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center group" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-shipping-fast text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Free Shipping</h3>
                <p class="text-gray-400">Free worldwide shipping on orders over $500</p>
            </div>
            
            <div class="text-center group" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-gradient-to-r from-secondary to-accent rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Expert Support</h3>
                <p class="text-gray-400">24/7 technical support from industry professionals</p>
            </div>
            
            <div class="text-center group" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-gradient-to-r from-accent to-primary rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Warranty Protection</h3>
                <p class="text-gray-400">Extended warranty on all professional equipment</p>
            </div>
            
            <div class="text-center group" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-gradient-to-r from-primary to-accent rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-undo text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Easy Returns</h3>
                <p class="text-gray-400">30-day hassle-free return policy</p>
            </div>
        </div>
    </div>
</section>



<!-- Cart Sidebar -->
@include('shop.partials.cart-sidebar')

<style>
.filter-btn {
    background: rgba(255, 255, 255, 0.1);
    color: #9CA3AF;
}

.filter-btn.active,
.filter-btn:hover {
    background: linear-gradient(to right, #C53030, #E53E3E);
    color: white;
}

.text-gradient {
    background: linear-gradient(135deg, #C53030, #E53E3E, #FC8181);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart functionality
    initializeCart();
    
    // Search functionality
    initializeSearch();
    
    // Product interactions
    initializeProductActions();
});

function initializeCart() {
    // Cart functionality will be handled by cart-sidebar.js
    console.log('Cart initialized');
}

function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.closest('form').submit();
            }
        });
    }
}

function initializeProductActions() {
    // Add to cart buttons
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            addToCart(this.dataset.productId);
        });
    });
    
    // Quick view buttons
    document.querySelectorAll('.quick-view-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            showQuickView(this.dataset.productId);
        });
    });
    
    // Wishlist buttons
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            toggleWishlist(this.dataset.productId);
        });
    });
}

function addToCart(productId) {
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
            updateCartUI(data);
            showNotification('Product added to cart!', 'success');
        } else {
            showNotification(data.message || 'Failed to add product to cart', 'error');
        }
    })
    .catch(error => {
        showNotification('Something went wrong', 'error');
    });
}

function showQuickView(productId) {
    // Find the product element to get the slug
    const productElement = document.querySelector(`[data-product-id="${productId}"]`);
    let productSlug = null;
    
    // Try to find the slug from the product link or data attribute
    if (productElement) {
        // First try to get from data-product-slug attribute
        productSlug = productElement.dataset.productSlug;
        
        // If not found, try to extract from product link
        if (!productSlug) {
            const productLink = productElement.querySelector('a[href*="/shop/product/"]');
            if (productLink) {
                const href = productLink.getAttribute('href');
                const matches = href.match(/\/shop\/product\/([^\/]+)/);
                if (matches) {
                    productSlug = matches[1];
                }
            }
        }
    }
    
    // If we still can't find the slug, make an API call to get product data by ID
    if (!productSlug) {
        console.warn('Could not find product slug, fetching product data by ID');
        fetch(`/shop/api?product_id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    const product = data.data[0];
                    showQuickViewModal(product.slug);
                } else {
                    showNotification('Product not found', 'error');
                }
            })
            .catch(error => {
                console.error('Error fetching product:', error);
                showNotification('Error loading product', 'error');
            });
        return;
    }
    
    showQuickViewModal(productSlug);
}

function showQuickViewModal(productSlug) {
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

function toggleWishlist(productId) {
    // Implementation for wishlist toggle
    console.log('Toggle wishlist for product:', productId);
}

function updateCartUI(data) {
    // Update cart count and total
    const cartCount = document.getElementById('cartCount');
    const cartTotal = document.getElementById('cartTotal');
    
    if (cartCount) cartCount.textContent = data.cart_count;
    if (cartTotal) cartTotal.textContent = data.cart_total;
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle mr-2"></i>
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
</script>

@endsection