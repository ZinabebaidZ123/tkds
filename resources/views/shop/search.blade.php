{{-- File: resources/views/shop/search.blade.php --}}
@extends('layouts.app')

@section('title', 'Search Results for "' . $query . '" - TKDS Media Shop')
@section('meta_description', 'Search results for "' . $query . '" in our professional broadcasting equipment store')

@section('content')

<!-- Breadcrumbs -->
<section class="bg-dark-light py-4 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">Home</a>
            <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
            <a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">Shop</a>
            <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
            <span class="text-white">Search Results</span>
        </nav>
    </div>
</section>

<!-- Search Results Header -->
<section class="py-16 bg-gradient-to-br from-dark via-dark-light to-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-lg rounded-full px-8 py-4 border border-primary/20 mb-8">
                <i class="fas fa-search text-primary text-xl"></i>
                <span class="text-sm font-semibold tracking-wider uppercase text-primary">Search Results</span>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4">
                Results for 
                <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">"{{ $query }}"</span>
            </h1>
            
            <p class="text-xl text-gray-300 max-w-3xl mx-auto mb-8">
                Found {{ $products->total() }} products matching your search
            </p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto relative" data-aos="fade-up" data-aos-delay="200">
                <form action="{{ route('shop.search') }}" method="GET" class="relative">
                    <input type="text" name="q" id="searchInput" placeholder="Refine your search..." 
                           value="{{ $query }}"
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

<!-- Search Results Content -->
<section class="py-20 bg-dark min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($products->count() > 0)
            <!-- Results Summary -->
            <div class="flex flex-col lg:flex-row items-center justify-between mb-8" data-aos="fade-up">
                <div class="flex items-center space-x-6 mb-6 lg:mb-0">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary">{{ $products->total() }}</div>
                        <div class="text-xs text-gray-400">Products Found</div>
                    </div>
                    
                    @if($categories->count() > 0)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-secondary">{{ $categories->count() }}</div>
                            <div class="text-xs text-gray-400">Categories</div>
                        </div>
                    @endif
                </div>

                <!-- Sort Options -->
                <div class="flex items-center space-x-4">
                    <form method="GET" class="flex items-center space-x-4">
                        <input type="hidden" name="q" value="{{ $query }}">
                        
                        <select name="sort" onchange="this.form.submit()" 
                                class="px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="relevance" {{ request('sort') === 'relevance' ? 'selected' : '' }}>Most Relevant</option>
                            <option value="price-low" {{ request('sort') === 'price-low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price-high" {{ request('sort') === 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </form>
                    
                    <div class="text-gray-400 text-sm">
                        {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
                    </div>
                </div>
            </div>

            <!-- Found Categories (if any) -->
            @if($categories->count() > 0)
                <div class="mb-12" data-aos="fade-up">
                    <h2 class="text-2xl font-bold text-white mb-6">Matching Categories</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach($categories as $category)
                            <a href="{{ route('shop.category', $category->slug) }}" 
                               class="group text-center p-4 bg-white/5 backdrop-blur-xl rounded-xl border border-white/10 hover:border-primary/30 transition-all duration-300 hover:transform hover:-translate-y-1">
                                
                                @if($category->image)
                                    <div class="w-12 h-12 mx-auto mb-3 rounded-lg overflow-hidden">
                                        <img src="{{ $category->getImageUrl() }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    </div>
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                                        <i class="{{ $category->icon ?? 'fas fa-cube' }} text-white text-lg"></i>
                                    </div>
                                @endif
                                
                                <h3 class="text-white font-medium text-sm group-hover:text-primary transition-colors duration-300">{{ $category->name }}</h3>
                                <p class="text-gray-400 text-xs">{{ $category->getProductsCount() }} products</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Products Grid -->
            @include('shop.partials.product-grid', ['products' => $products])

            <!-- Pagination -->
            <div class="mt-16">
                {{ $products->appends(['q' => $query])->links('shop.partials.pagination') }}
            </div>
        @else
            <!-- No Results -->
            <div class="text-center py-16" data-aos="fade-up">
                <div class="mx-auto h-32 w-32 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-8">
                    <i class="fas fa-search text-6xl text-primary"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-4">No Products Found</h2>
                <p class="text-gray-400 mb-8 max-w-md mx-auto">
                    We couldn't find any products matching "{{ $query }}". 
                    Try different keywords or browse our categories.
                </p>

                <!-- Search Suggestions -->
                <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 max-w-2xl mx-auto mb-8">
                    <h3 class="text-xl font-bold text-white mb-6">Search Suggestions</h3>
                    <div class="grid md:grid-cols-2 gap-4 text-left">
                        <div>
                            <h4 class="text-white font-semibold mb-2">Try These Tips:</h4>
                            <ul class="space-y-1 text-gray-400 text-sm">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-400 mr-2 mt-0.5 flex-shrink-0"></i>
                                    Check your spelling
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-400 mr-2 mt-0.5 flex-shrink-0"></i>
                                    Use more general terms
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-400 mr-2 mt-0.5 flex-shrink-0"></i>
                                    Try different keywords
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-2">Popular Searches:</h4>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('shop.search', ['q' => 'camera']) }}" class="px-3 py-1 bg-primary/20 text-primary rounded-full text-sm hover:bg-primary hover:text-white transition-all duration-300">Camera</a>
                                <a href="{{ route('shop.search', ['q' => 'microphone']) }}" class="px-3 py-1 bg-primary/20 text-primary rounded-full text-sm hover:bg-primary hover:text-white transition-all duration-300">Microphone</a>
                                <a href="{{ route('shop.search', ['q' => 'lighting']) }}" class="px-3 py-1 bg-primary/20 text-primary rounded-full text-sm hover:bg-primary hover:text-white transition-all duration-300">Lighting</a>
                                <a href="{{ route('shop.search', ['q' => 'streaming']) }}" class="px-3 py-1 bg-primary/20 text-primary rounded-full text-sm hover:bg-primary hover:text-white transition-all duration-300">Streaming</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                    <a href="{{ route('shop.index') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Browse All Products
                    </a>
                    
                    @if($allCategories->count() > 0)
                        <a href="#categories" onclick="document.getElementById('categoriesSection').scrollIntoView({behavior: 'smooth'})" 
                           class="inline-flex items-center px-8 py-4 bg-white/10 text-white rounded-xl hover:bg-white/20 transition-all duration-300">
                            <i class="fas fa-th-large mr-2"></i>
                            Browse Categories
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Categories Section -->
@if($allCategories->count() > 0)
<section id="categoriesSection" class="py-20 bg-dark-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Browse Categories</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">Explore our comprehensive collection of professional equipment</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($allCategories as $category)
                <a href="{{ route('shop.category', $category->slug) }}" 
                   class="group text-center p-6 bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 hover:border-primary/30 transition-all duration-300 hover:transform hover:-translate-y-2"
                   data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    
                    @if($category->image)
                        <div class="w-16 h-16 mx-auto mb-4 rounded-xl overflow-hidden">
                            <img src="{{ $category->getImageUrl() }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                    @else
                        <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="{{ $category->icon ?? 'fas fa-cube' }} text-white text-2xl"></i>
                        </div>
                    @endif
                    
                    <h3 class="text-white font-semibold mb-2 group-hover:text-primary transition-colors duration-300">{{ $category->name }}</h3>
                    <p class="text-gray-400 text-sm">{{ $category->getProductsCount() }} products</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section class="py-20 bg-dark">
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

<!-- Cart Sidebar -->
@include('shop.partials.cart-sidebar')

<style>
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
    if (typeof initializeCart === 'function') {
        initializeCart();
    }
    
    // Auto-focus search input for refinement
    const searchInput = document.getElementById('searchInput');
    if (searchInput && window.location.search.includes('q=')) {
        // Position cursor at end of search term
        setTimeout(() => {
            searchInput.focus();
            searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
        }, 500);
    }
});
</script>

@endsection