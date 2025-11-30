{{-- File: resources/views/shop/category.blade.php --}}
@extends('layouts.app')

@section('title', $category->name . ' - Shop - TKDS Media')
@section('meta_description', $category->description ?: 'Browse our ' . $category->name . ' collection of professional broadcasting equipment')

@section('content')

<!-- Breadcrumbs -->
<section class="bg-dark-light py-4 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">Home</a>
            <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
            <a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">Shop</a>
            <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
            <span class="text-white">{{ $category->name }}</span>
        </nav>
    </div>
</section>

<!-- Category Header -->
<section class="py-16 bg-gradient-to-br from-dark via-dark-light to-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            @if($category->image)
                <div class="w-24 h-24 mx-auto mb-6 rounded-2xl overflow-hidden border-4 border-primary/20">
                    <img src="{{ $category->getImageUrl() }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-primary to-secondary rounded-2xl flex items-center justify-center">
                    <i class="{{ $category->icon ?? 'fas fa-cube' }} text-white text-3xl"></i>
                </div>
            @endif
            
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4">{{ $category->name }}</h1>
            
            @if($category->description)
                <p class="text-xl text-gray-300 max-w-3xl mx-auto mb-8">{{ $category->description }}</p>
            @endif
            
            <div class="flex items-center justify-center space-x-6 text-sm text-gray-400">
                <span>{{ $products->total() }} products</span>
                <span>•</span>
                <span>Professional grade equipment</span>
                <span>•</span>
                <span>Worldwide shipping</span>
            </div>
        </div>
    </div>
</section>

<!-- Filters & Sorting -->
<section class="py-8 bg-dark border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between space-y-6 lg:space-y-0">
            
            <!-- Category Stats -->
            <div class="flex items-center space-x-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary">{{ $products->total() }}</div>
                    <div class="text-xs text-gray-400">Products</div>
                </div>
                
                @if($category->activeProducts()->physical()->count() > 0)
                    <div class="text-center">
                        <div class="text-2xl font-bold text-secondary">{{ $category->activeProducts()->physical()->count() }}</div>
                        <div class="text-xs text-gray-400">Physical</div>
                    </div>
                @endif
                
                @if($category->activeProducts()->software()->count() > 0)
                    <div class="text-center">
                        <div class="text-2xl font-bold text-accent">{{ $category->activeProducts()->software()->count() }}</div>
                        <div class="text-xs text-gray-400">Software</div>
                    </div>
                @endif
            </div>
            
            <!-- Filter Buttons -->
            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('shop.category', $category->slug) }}" 
                   class="filter-btn {{ !request('type') ? 'active' : '' }} px-4 py-2 rounded-lg font-medium transition-all duration-300">
                    All Products
                </a>
                
                @if($category->activeProducts()->physical()->count() > 0)
                    <a href="{{ route('shop.category', $category->slug) }}?type=physical" 
                       class="filter-btn {{ request('type') === 'physical' ? 'active' : '' }} px-4 py-2 rounded-lg font-medium transition-all duration-300">
                        <i class="fas fa-box mr-2"></i>Physical Products
                    </a>
                @endif
                
                @if($category->activeProducts()->software()->count() > 0)
                    <a href="{{ route('shop.category', $category->slug) }}?type=software" 
                       class="filter-btn {{ request('type') === 'software' ? 'active' : '' }} px-4 py-2 rounded-lg font-medium transition-all duration-300">
                        <i class="fas fa-download mr-2"></i>Software
                    </a>
                @endif
            </div>

            <!-- Sort & Search -->
            <div class="flex items-center space-x-4">
                <!-- Search in Category -->
                <form method="GET" class="relative">
                    @foreach(request()->except(['search']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <input type="text" name="search" placeholder="Search in {{ $category->name }}..." 
                           value="{{ request('search') }}"
                           class="pl-10 pr-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary w-64">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </form>
                
                <!-- Sort Options -->
                <form method="GET" class="flex items-center">
                    @foreach(request()->except(['sort']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    
                    <select name="sort" onchange="this.form.submit()" 
                            class="px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="featured" {{ request('sort') === 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="price-low" {{ request('sort') === 'price-low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price-high" {{ request('sort') === 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                    </select>
                </form>
                
                <!-- Results Info -->
                <div class="text-gray-400 text-sm">
                    {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
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
            @include('shop.partials.product-grid', ['products' => $products])

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
                    @if(request('search'))
                        No products found for "{{ request('search') }}" in {{ $category->name }}. Try different keywords.
                    @elseif(request('type'))
                        No {{ request('type') }} products available in this category.
                    @else
                        No products available in this category yet.
                    @endif
                </p>
                <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                    @if(request()->hasAny(['search', 'type']))
                        <a href="{{ route('shop.category', $category->slug) }}" 
                           class="inline-flex items-center px-6 py-3 bg-white/10 text-white rounded-xl hover:bg-white/20 transition-all duration-300">
                            <i class="fas fa-times mr-2"></i>
                            Clear Filters
                        </a>
                    @endif
                    <a href="{{ route('shop.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Browse All Products
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Related Categories -->
@if($categories->where('id', '!=', $category->id)->count() > 0)
<section class="py-20 bg-dark-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Explore Other Categories</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">Discover more professional equipment categories</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($categories->where('id', '!=', $category->id)->take(6) as $relatedCategory)
                <a href="{{ route('shop.category', $relatedCategory->slug) }}" 
                   class="group text-center p-6 bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 hover:border-primary/30 transition-all duration-300 hover:transform hover:-translate-y-2"
                   data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    
                    @if($relatedCategory->image)
                        <div class="w-16 h-16 mx-auto mb-4 rounded-xl overflow-hidden">
                            <img src="{{ $relatedCategory->getImageUrl() }}" alt="{{ $relatedCategory->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                    @else
                        <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="{{ $relatedCategory->icon ?? 'fas fa-cube' }} text-white text-2xl"></i>
                        </div>
                    @endif
                    
                    <h3 class="text-white font-semibold mb-2 group-hover:text-primary transition-colors duration-300">{{ $relatedCategory->name }}</h3>
                    <p class="text-gray-400 text-sm">{{ $relatedCategory->getProductsCount() }} products</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="py-20 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">You Might Also Like</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">Popular products from {{ $category->name }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($relatedProducts as $product)
                @include('shop.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Category Features -->
<section class="py-20 bg-gradient-to-r from-primary/10 to-secondary/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-black text-white mb-4">Why Choose Our {{ $category->name }}?</h2>
            <p class="text-gray-300 max-w-2xl mx-auto">Professional grade equipment trusted by industry leaders</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center group" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-award text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Professional Grade</h3>
                <p class="text-gray-400">Industry-standard equipment for professional broadcasting</p>
            </div>
            
            <div class="text-center group" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-gradient-to-r from-secondary to-accent rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-shipping-fast text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Fast Shipping</h3>
                <p class="text-gray-400">Quick delivery worldwide with tracking</p>
            </div>
            
            <div class="text-center group" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-gradient-to-r from-accent to-primary rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Expert Support</h3>
                <p class="text-gray-400">24/7 technical support from industry experts</p>
            </div>
            
            <div class="text-center group" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-gradient-to-r from-primary to-accent rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Warranty Included</h3>
                <p class="text-gray-400">Comprehensive warranty on all products</p>
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
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.filter-btn.active,
.filter-btn:hover {
    background: linear-gradient(to right, #C53030, #E53E3E);
    color: white;
    border-color: #C53030;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(197, 48, 48, 0.3);
}

/* Category header animation */
.category-header {
    background: linear-gradient(135deg, rgba(197, 48, 48, 0.1), rgba(229, 62, 62, 0.1));
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit search form on input (with debounce)
    let searchTimeout;
    const searchInput = document.querySelector('input[name="search"]');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    }
    
    // Initialize cart functionality
    if (typeof initializeCart === 'function') {
        initializeCart();
    }
});
</script>

@endsection