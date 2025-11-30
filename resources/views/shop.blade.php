@extends('layouts.app')

@section('title', 'TKDS Media - Professional Broadcasting Equipment Shop')
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
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search for cameras, microphones, lighting..." 
                           class="w-full px-6 py-4 pl-14 pr-20 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                    <i class="fas fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-primary to-secondary text-white px-6 py-2 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300">
                        Search
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filters & Categories -->
<section class="py-8 bg-dark-light border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center justify-between space-y-6 lg:space-y-0">
            <!-- Categories -->
            <div class="flex flex-wrap items-center space-x-2 md:space-x-4">
                <button class="category-btn active px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl font-semibold transition-all duration-300" data-category="all">
                    All Products
                </button>
                <button class="category-btn px-6 py-3 bg-white/10 text-gray-300 rounded-xl font-semibold hover:bg-primary/20 hover:text-white transition-all duration-300" data-category="cameras">
                    Cameras
                </button>
                <button class="category-btn px-6 py-3 bg-white/10 text-gray-300 rounded-xl font-semibold hover:bg-primary/20 hover:text-white transition-all duration-300" data-category="audio">
                    Audio
                </button>
                <button class="category-btn px-6 py-3 bg-white/10 text-gray-300 rounded-xl font-semibold hover:bg-primary/20 hover:text-white transition-all duration-300" data-category="lighting">
                    Lighting
                </button>
                <button class="category-btn px-6 py-3 bg-white/10 text-gray-300 rounded-xl font-semibold hover:bg-primary/20 hover:text-white transition-all duration-300" data-category="streaming">
                    Streaming
                </button>
            </div>

            <!-- Sort & Filter -->
            <div class="flex items-center space-x-4">
                <select id="sortSelect" class="px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="featured">Featured</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="newest">Newest First</option>
                    <option value="rating">Highest Rated</option>
                </select>
                
                <button id="gridToggle" class="p-3 bg-white/10 border border-white/20 rounded-xl text-white hover:bg-primary/20 transition-all duration-300">
                    <i class="fas fa-th-large"></i>
                </button>
                
                <button id="listToggle" class="p-3 bg-white/10 border border-white/20 rounded-xl text-gray-400 hover:bg-primary/20 hover:text-white transition-all duration-300">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="py-20 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Results Info -->
        <div class="flex items-center justify-between mb-8" data-aos="fade-up">
            <div class="text-gray-400">
                Showing <span id="resultsCount" class="text-white font-semibold">24</span> results
            </div>
            <div class="text-sm text-gray-400">
                <span id="currentPage" class="text-white">1</span> of <span id="totalPages" class="text-white">3</span> pages
            </div>
        </div>

        <!-- Products Grid -->
        <div id="productsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <!-- Product Card 1 -->
            <div class="product-card group" data-category="cameras" data-price="2499" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-primary/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20">
                    <!-- Product Image -->
                    <div class="relative h-64 overflow-hidden group">
                        <img src="https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=400&h=300&fit=crop" 
                             alt="Professional Camera" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Badges -->
                        <div class="absolute top-4 left-4 space-y-2">
                            <span class="inline-block px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">In Stock</span>
                            <span class="inline-block px-3 py-1 bg-primary text-white text-xs font-bold rounded-full">Bestseller</span>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="absolute top-4 right-4 space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">

                            <button class="quick-view-btn w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-primary/30 hover:text-primary transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <!-- Quick Add to Cart -->
                        <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <button class="add-to-cart-btn w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105" data-product-id="1">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-6">
                        <div class="text-sm text-gray-400 mb-2">Professional Cameras</div>
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-primary transition-colors duration-300">
                            Sony FX6 Full-Frame Cinema Camera
                        </h3>
                        
                        <!-- Rating -->
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="flex space-x-1">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                            </div>
                            <span class="text-sm text-gray-400">(127 reviews)</span>
                        </div>
                        
                        <!-- Price -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-2xl font-black text-primary">$2,499</span>
                                <span class="text-lg text-gray-400 line-through">$2,999</span>
                            </div>
                            <span class="bg-red-500 text-white px-2 py-1 rounded text-sm font-bold">-17%</span>
                        </div>
                        
                        <!-- Features -->
                        <ul class="text-sm text-gray-400 space-y-1">
                            <li><i class="fas fa-check text-green-400 mr-2"></i>4K 120fps recording</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>15+ stops dynamic range</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>Dual base ISO</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product Card 2 -->
            <div class="product-card group" data-category="audio" data-price="299" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-secondary/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-secondary/20">
                    <!-- Product Image -->
                    <div class="relative h-64 overflow-hidden group">
                        <img src="https://images.unsplash.com/photo-1590602847861-f357a9332bbc?w=400&h=300&fit=crop" 
                             alt="Professional Microphone" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Badges -->
                        <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">In Stock</span>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="absolute top-4 right-4 space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">

                            <button class="quick-view-btn w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-secondary/30 hover:text-secondary transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <!-- Quick Add to Cart -->
                        <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <button class="add-to-cart-btn w-full bg-gradient-to-r from-secondary to-accent text-white py-3 rounded-xl font-semibold hover:from-accent hover:to-primary transition-all duration-300 transform hover:scale-105" data-product-id="2">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-6">
                        <div class="text-sm text-gray-400 mb-2">Professional Audio</div>
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-secondary transition-colors duration-300">
                            Shure SM7B Dynamic Microphone
                        </h3>
                        
                        <!-- Rating -->
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="flex space-x-1">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-gray-400"></i>
                            </div>
                            <span class="text-sm text-gray-400">(89 reviews)</span>
                        </div>
                        
                        <!-- Price -->
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-2xl font-black text-secondary">$299</span>
                            </div>
                        </div>
                        
                        <!-- Features -->
                        <ul class="text-sm text-gray-400 space-y-1">
                            <li><i class="fas fa-check text-green-400 mr-2"></i>Broadcast quality sound</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>Internal shock isolation</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>Flat, wide-range frequency</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product Card 3 -->
            <div class="product-card group" data-category="lighting" data-price="199" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-accent/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-accent/20">
                    <!-- Product Image -->
                    <div class="relative h-64 overflow-hidden group">
                        <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400&h=300&fit=crop" 
                             alt="LED Light Panel" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Badges -->
                        <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-yellow-500 text-black text-xs font-bold rounded-full">Limited Stock</span>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="absolute top-4 right-4 space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">

                            <button class="quick-view-btn w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-accent/30 hover:text-accent transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <!-- Quick Add to Cart -->
                        <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <button class="add-to-cart-btn w-full bg-gradient-to-r from-accent to-primary text-white py-3 rounded-xl font-semibold hover:from-primary hover:to-secondary transition-all duration-300 transform hover:scale-105" data-product-id="3">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-6">
                        <div class="text-sm text-gray-400 mb-2">Professional Lighting</div>
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-accent transition-colors duration-300">
                            Aputure AL-MX Pocket LED Light
                        </h3>
                        
                        <!-- Rating -->
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="flex space-x-1">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                            </div>
                            <span class="text-sm text-gray-400">(156 reviews)</span>
                        </div>
                        
                        <!-- Price -->
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-2xl font-black text-accent">$199</span>
                            </div>
                        </div>
                        
                        <!-- Features -->
                        <ul class="text-sm text-gray-400 space-y-1">
                            <li><i class="fas fa-check text-green-400 mr-2"></i>Compact & portable</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>RGB + tunable white</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>App control</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product Card 4 -->
            <div class="product-card group" data-category="streaming" data-price="149" data-aos="fade-up" data-aos-delay="400">
                <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-primary/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20">
                    <!-- Product Image -->
                    <div class="relative h-64 overflow-hidden group">
                        <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=300&fit=crop" 
                             alt="Stream Deck" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Badges -->
                        <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">In Stock</span>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="absolute top-4 right-4 space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="quick-view-btn w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-primary/30 hover:text-primary transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <!-- Quick Add to Cart -->
                        <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <button class="add-to-cart-btn w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105" data-product-id="4">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-6">
                        <div class="text-sm text-gray-400 mb-2">Streaming Equipment</div>
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-primary transition-colors duration-300">
                            Elgato Stream Deck MK.2
                        </h3>
                        
                        <!-- Rating -->
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="flex space-x-1">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-gray-400"></i>
                            </div>
                            <span class="text-sm text-gray-400">(203 reviews)</span>
                        </div>
                        
                        <!-- Price -->
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-2xl font-black text-primary">$149</span>
                            </div>
                        </div>
                        
                        <!-- Features -->
                        <ul class="text-sm text-gray-400 space-y-1">
                            <li><i class="fas fa-check text-green-400 mr-2"></i>15 customizable keys</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>One-touch operation</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>Unlimited control</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- More products would be generated dynamically -->
            <!-- Product Cards 5-8 for demonstration -->
            <div class="product-card group" data-category="cameras" data-price="899" data-aos="fade-up" data-aos-delay="500">
                <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-primary/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20">
                    <div class="relative h-64 overflow-hidden group">
                        <img src="https://images.unsplash.com/photo-1606983340126-99ab4feaa64a?w=400&h=300&fit=crop" 
                             alt="DSLR Camera" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
 <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">In Stock</span>
                        </div>
                        
                        <div class="absolute top-4 right-4 space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="quick-view-btn w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-primary/30 hover:text-primary transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <button class="add-to-cart-btn w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105" data-product-id="5">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="text-sm text-gray-400 mb-2">DSLR Cameras</div>
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-primary transition-colors duration-300">
                            Canon EOS R5 Mirrorless Camera
                        </h3>
                        
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="flex space-x-1">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                            </div>
                            <span class="text-sm text-gray-400">(98 reviews)</span>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-2xl font-black text-primary">$899</span>
                            </div>
                        </div>
                        
                        <ul class="text-sm text-gray-400 space-y-1">
                            <li><i class="fas fa-check text-green-400 mr-2"></i>45MP full-frame sensor</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>8K video recording</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>In-body stabilization</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product 6 - Audio Interface -->
            <div class="product-card group" data-category="audio" data-price="349" data-aos="fade-up" data-aos-delay="600">
                <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-secondary/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-secondary/20">
                    <div class="relative h-64 overflow-hidden group">
                        <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400&h=300&fit=crop" 
                             alt="Audio Interface" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">In Stock</span>
                        </div>
                        
                        <div class="absolute top-4 right-4 space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="quick-view-btn w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-secondary/30 hover:text-secondary transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <button class="add-to-cart-btn w-full bg-gradient-to-r from-secondary to-accent text-white py-3 rounded-xl font-semibold hover:from-accent hover:to-primary transition-all duration-300 transform hover:scale-105" data-product-id="6">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="text-sm text-gray-400 mb-2">Audio Interfaces</div>
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-secondary transition-colors duration-300">
                            Focusrite Scarlett 2i2 (3rd Gen)
                        </h3>
                        
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="flex space-x-1">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-gray-400"></i>
                            </div>
                            <span class="text-sm text-gray-400">(245 reviews)</span>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-2xl font-black text-secondary">$349</span>
                            </div>
                        </div>
                        
                        <ul class="text-sm text-gray-400 space-y-1">
                            <li><i class="fas fa-check text-green-400 mr-2"></i>2 in / 2 out USB interface</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>High-performance converters</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>Low-latency monitoring</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product 7 - Tripod -->
            <div class="product-card group" data-category="cameras" data-price="129" data-aos="fade-up" data-aos-delay="700">
                <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-accent/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-accent/20">
                    <div class="relative h-64 overflow-hidden group">
                        <img src="https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=400&h=300&fit=crop" 
                             alt="Professional Tripod" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">In Stock</span>
                        </div>
                        
                        <div class="absolute top-4 right-4 space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">

                            <button class="quick-view-btn w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-accent/30 hover:text-accent transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <button class="add-to-cart-btn w-full bg-gradient-to-r from-accent to-primary text-white py-3 rounded-xl font-semibold hover:from-primary hover:to-secondary transition-all duration-300 transform hover:scale-105" data-product-id="7">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="text-sm text-gray-400 mb-2">Camera Accessories</div>
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-accent transition-colors duration-300">
                            Manfrotto Professional Tripod
                        </h3>
                        
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="flex space-x-1">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-gray-400"></i>
                            </div>
                            <span class="text-sm text-gray-400">(76 reviews)</span>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-2xl font-black text-accent">$129</span>
                            </div>
                        </div>
                        
                        <ul class="text-sm text-gray-400 space-y-1">
                            <li><i class="fas fa-check text-green-400 mr-2"></i>Carbon fiber construction</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>Maximum height 165cm</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>Quick release plate</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product 8 - Green Screen -->
            <div class="product-card group" data-category="lighting" data-price="79" data-aos="fade-up" data-aos-delay="800">
                <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-primary/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20">
                    <div class="relative h-64 overflow-hidden group">
                        <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop" 
                             alt="Green Screen" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">In Stock</span>
                        </div>
                        
                        <div class="absolute top-4 right-4 space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="quick-view-btn w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-primary/30 hover:text-primary transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <button class="add-to-cart-btn w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105" data-product-id="8">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="text-sm text-gray-400 mb-2">Studio Equipment</div>
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-primary transition-colors duration-300">
                            Collapsible Green Screen Background
                        </h3>
                        
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="flex space-x-1">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                            </div>
                            <span class="text-sm text-gray-400">(189 reviews)</span>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-2xl font-black text-primary">$79</span>
                            </div>
                        </div>
                        
                        <ul class="text-sm text-gray-400 space-y-1">
                            <li><i class="fas fa-check text-green-400 mr-2"></i>5x7 feet backdrop</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>Wrinkle-resistant fabric</li>
                            <li><i class="fas fa-check text-green-400 mr-2"></i>Easy setup & storage</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-16" data-aos="fade-up">
            <button id="loadMoreBtn" class="group inline-flex items-center space-x-4 px-10 py-5 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-xl text-white font-bold rounded-2xl border border-primary/30 hover:border-primary/60 hover:from-primary/20 hover:to-secondary/20 transition-all duration-500 hover:shadow-2xl hover:shadow-primary/20 transform hover:-translate-y-1">
                <i class="fas fa-plus text-primary text-xl"></i>
                <span class="text-lg">Load More Products</span>
                <i class="fas fa-arrow-down text-primary group-hover:translate-y-2 transition-transform duration-300"></i>
            </button>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-center space-x-2 mt-12" data-aos="fade-up">
            <button class="pagination-btn px-4 py-2 bg-white/10 text-gray-400 rounded-lg hover:bg-primary/20 hover:text-white transition-all duration-300" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="pagination-btn px-4 py-2 bg-gradient-to-r from-primary to-secondary text-white rounded-lg font-semibold">1</button>
            <button class="pagination-btn px-4 py-2 bg-white/10 text-gray-400 rounded-lg hover:bg-primary/20 hover:text-white transition-all duration-300">2</button>
            <button class="pagination-btn px-4 py-2 bg-white/10 text-gray-400 rounded-lg hover:bg-primary/20 hover:text-white transition-all duration-300">3</button>
            <span class="px-2 text-gray-400">...</span>
            <button class="pagination-btn px-4 py-2 bg-white/10 text-gray-400 rounded-lg hover:bg-primary/20 hover:text-white transition-all duration-300">12</button>
            <button class="pagination-btn px-4 py-2 bg-white/10 text-gray-400 rounded-lg hover:bg-primary/20 hover:text-white transition-all duration-300">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-dark-light">
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
                <h3 class="text-xl font-bold text-white mb-2">24/7 Support</h3>
                <p class="text-gray-400">Expert technical support available anytime</p>
            </div>
            
            <div class="text-center group" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-gradient-to-r from-accent to-primary rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Warranty</h3>
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
<div id="cartSidebar" class="fixed top-0 right-0 h-full w-96 bg-gradient-to-b from-dark via-dark-light to-dark backdrop-blur-xl border-l border-white/10 transform translate-x-full transition-transform duration-500 z-50">
    <div class="p-6 border-b border-white/10">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold text-white">Shopping Cart</h3>
            <button id="closeCartBtn" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-red-500/20 hover:text-red-400 transition-all duration-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    
    <div class="flex-1 overflow-y-auto p-6">
        <div id="cartItems" class="space-y-4">
            <!-- Cart items will be dynamically added here -->
            <div class="text-center text-gray-400 py-12">
                <i class="fas fa-shopping-cart text-4xl mb-4 opacity-50"></i>
                <p>Your cart is empty</p>
            </div>
        </div>
    </div>
    
    <div class="p-6 border-t border-white/10">
        <div class="space-y-4">
            <div class="flex items-center justify-between text-lg">
                <span class="text-gray-400">Subtotal:</span>
                <span id="cartSubtotal" class="text-white font-bold">$0.00</span>
            </div>
            <div class="flex items-center justify-between text-xl">
                <span class="text-white font-bold">Total:</span>
                <span id="cartTotal" class="text-primary font-black">$0.00</span>
            </div>
            <button class="w-full bg-gradient-to-r from-primary to-secondary text-white py-4 rounded-2xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                Proceed to Checkout
            </button>
        </div>
    </div>
</div>

<!-- Cart Overlay -->
<div id="cartOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm opacity-0 invisible transition-all duration-300 z-40"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cart functionality
    let cart = [];
    let cartTotal = 0;
    
    // DOM elements
    const cartBtn = document.getElementById('cartBtn');
    const mobileCartBtn = document.getElementById('mobileCartBtn');
    const cartSidebar = document.getElementById('cartSidebar');
    const cartOverlay = document.getElementById('cartOverlay');
    const closeCartBtn = document.getElementById('closeCartBtn');
    const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
    const categoryBtns = document.querySelectorAll('.category-btn');
    const productCards = document.querySelectorAll('.product-card');
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const gridToggle = document.getElementById('gridToggle');
    const listToggle = document.getElementById('listToggle');
    const productsGrid = document.getElementById('productsGrid');
    
    // Open cart
    function openCart() {
        cartSidebar.classList.remove('translate-x-full');
        cartOverlay.classList.remove('opacity-0', 'invisible');
        document.body.style.overflow = 'hidden';
    }
    
    // Close cart
    function closeCart() {
        cartSidebar.classList.add('translate-x-full');
        cartOverlay.classList.add('opacity-0', 'invisible');
        document.body.style.overflow = 'auto';
    }
    
    // Add to cart
    function addToCart(productId) {
        const productCard = document.querySelector(`[data-product-id="${productId}"]`).closest('.product-card');
        const productName = productCard.querySelector('h3').textContent;
        const productPrice = productCard.querySelector('.text-2xl').textContent;
        const productImage = productCard.querySelector('img').src;
        
        const existingItem = cart.find(item => item.id === productId);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: parseFloat(productPrice.replace('$', '').replace(',', '')),
                image: productImage,
                quantity: 1
            });
        }
        
        updateCartUI();
        updateCartCount(cart.reduce((total, item) => total + item.quantity, 0));
        
        // Show success animation
        const btn = document.querySelector(`[data-product-id="${productId}"]`);
        btn.innerHTML = '<i class="fas fa-check mr-2"></i>Added!';
        btn.classList.add('bg-green-500');
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i>Add to Cart';
            btn.classList.remove('bg-green-500');
        }, 2000);
    }
    
    // Update cart UI
    function updateCartUI() {
        const cartItems = document.getElementById('cartItems');
        const cartSubtotal = document.getElementById('cartSubtotal');
        const cartTotal = document.getElementById('cartTotal');
        
        if (cart.length === 0) {
            cartItems.innerHTML = `
                <div class="text-center text-gray-400 py-12">
                    <i class="fas fa-shopping-cart text-4xl mb-4 opacity-50"></i>
                    <p>Your cart is empty</p>
                </div>
            `;
            cartSubtotal.textContent = '$0.00';
            cartTotal.textContent = '$0.00';
            return;
        }
        
        const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
        
        cartItems.innerHTML = cart.map(item => `
            <div class="flex items-center space-x-4 p-4 bg-white/5 rounded-xl">
                <img src="${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-lg">
                <div class="flex-1">
                    <h4 class="text-white font-semibold text-sm">${item.name}</h4>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-primary font-bold">$${item.price}</span>
                        <div class="flex items-center space-x-2">
                            <button onclick="updateQuantity('${item.id}', ${item.quantity - 1})" class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-red-500/20 transition-all duration-300">
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <span class="text-white font-semibold w-8 text-center">${item.quantity}</span>
                            <button onclick="updateQuantity('${item.id}', ${item.quantity + 1})" class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-green-500/20 transition-all duration-300">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        
        cartSubtotal.textContent = `${subtotal.toFixed(2)}`;
        cartTotal.textContent = `${subtotal.toFixed(2)}`;
    }
    
    // Update quantity
    window.updateQuantity = function(productId, newQuantity) {
        if (newQuantity <= 0) {
            cart = cart.filter(item => item.id !== productId);
        } else {
            const item = cart.find(item => item.id === productId);
            if (item) {
                item.quantity = newQuantity;
            }
        }
        updateCartUI();
        updateCartCount(cart.reduce((total, item) => total + item.quantity, 0));
    };
    
    // Filter products
    function filterProducts(category) {
        productCards.forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = 'block';
                card.classList.add('animate-fadeIn');
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update results count
        const visibleCards = Array.from(productCards).filter(card => card.style.display !== 'none');
        document.getElementById('resultsCount').textContent = visibleCards.length;
    }
    
    // Search products
    function searchProducts(query) {
        const searchTerm = query.toLowerCase();
        productCards.forEach(card => {
            const productName = card.querySelector('h3').textContent.toLowerCase();
            const productCategory = card.querySelector('.text-sm').textContent.toLowerCase();
            
            if (productName.includes(searchTerm) || productCategory.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update results count
        const visibleCards = Array.from(productCards).filter(card => card.style.display !== 'none');
        document.getElementById('resultsCount').textContent = visibleCards.length;
    }
    
    // Sort products
    function sortProducts(sortBy) {
        const container = document.getElementById('productsGrid');
        const cards = Array.from(productCards);
        
        cards.sort((a, b) => {
            switch (sortBy) {
                case 'price-low':
                    return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                case 'price-high':
                    return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                case 'newest':
                    // Simulate by reversing order
                    return b.dataset.productId - a.dataset.productId;
                case 'rating':
                    // Simulate by checking star count
                    const starsA = a.querySelectorAll('.fas.fa-star.text-yellow-400').length;
                    const starsB = b.querySelectorAll('.fas.fa-star.text-yellow-400').length;
                    return starsB - starsA;
                default:
                    return 0;
            }
        });
        
        // Re-append sorted cards
        cards.forEach(card => container.appendChild(card));
    }
    
    // Toggle grid/list view
    function toggleView(viewType) {
        if (viewType === 'list') {
            productsGrid.classList.remove('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3', 'xl:grid-cols-4');
            productsGrid.classList.add('grid-cols-1');
            
            productCards.forEach(card => {
                card.querySelector('.bg-gradient-to-br').classList.add('md:flex', 'md:items-center');
                card.querySelector('.relative.h-64').classList.remove('h-64');
                card.querySelector('.relative.h-64').classList.add('md:w-1/3', 'h-48', 'md:h-auto');
                card.querySelector('.p-6').classList.add('md:w-2/3');
            });
            
            gridToggle.classList.remove('text-white');
            gridToggle.classList.add('text-gray-400');
            listToggle.classList.remove('text-gray-400');
            listToggle.classList.add('text-white');
        } else {
            productsGrid.classList.remove('grid-cols-1');
            productsGrid.classList.add('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3', 'xl:grid-cols-4');
            
            productCards.forEach(card => {
                card.querySelector('.bg-gradient-to-br').classList.remove('md:flex', 'md:items-center');
                card.querySelector('.relative').classList.remove('md:w-1/3', 'h-48', 'md:h-auto');
                card.querySelector('.relative').classList.add('h-64');
                card.querySelector('.p-6').classList.remove('md:w-2/3');
            });
            
            listToggle.classList.remove('text-white');
            listToggle.classList.add('text-gray-400');
            gridToggle.classList.remove('text-gray-400');
            gridToggle.classList.add('text-white');
        }
    }
    
    // Event listeners
    cartBtn?.addEventListener('click', openCart);
    mobileCartBtn?.addEventListener('click', openCart);
    closeCartBtn?.addEventListener('click', closeCart);
    cartOverlay?.addEventListener('click', closeCart);
    
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const productId = btn.dataset.productId;
            addToCart(productId);
        });
    });
    
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            categoryBtns.forEach(b => {
                b.classList.remove('bg-gradient-to-r', 'from-primary', 'to-secondary', 'text-white');
                b.classList.add('bg-white/10', 'text-gray-300');
            });
            btn.classList.remove('bg-white/10', 'text-gray-300');
            btn.classList.add('bg-gradient-to-r', 'from-primary', 'to-secondary', 'text-white');
            
            filterProducts(btn.dataset.category);
        });
    });
    
    searchInput?.addEventListener('input', (e) => {
        searchProducts(e.target.value);
    });
    
    sortSelect?.addEventListener('change', (e) => {
        sortProducts(e.target.value);
    });
    
    gridToggle?.addEventListener('click', () => toggleView('grid'));
    listToggle?.addEventListener('click', () => toggleView('list'));
    
    // Load more products
    document.getElementById('loadMoreBtn')?.addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-spinner fa-spin text-primary mr-2"></i>Loading...';
        
        // Simulate loading
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-plus text-primary text-xl"></i><span class="text-lg">Load More Products</span><i class="fas fa-arrow-down text-primary group-hover:translate-y-2 transition-transform duration-300"></i>';
            
            // Add some demo products (in real app, this would fetch from API)
            const newProducts = `
                <div class="product-card group" data-category="streaming" data-price="89" data-aos="fade-up">
                    <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-primary/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20">
                        <div class="relative h-64 overflow-hidden group">
                            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=300&fit=crop" 
                                 alt="Webcam" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="absolute top-4 left-4">
                                <span class="inline-block px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">In Stock</span>
                            </div>
                            
                            <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                <button class="add-to-cart-btn w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105" data-product-id="9">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="text-sm text-gray-400 mb-2">Streaming Cameras</div>
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-primary transition-colors duration-300">
                                Logitech C920 HD Pro Webcam
                            </h3>
                            
                            <div class="flex items-center space-x-2 mb-4">
                                <div class="flex space-x-1">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-gray-400"></i>
                                </div>
                                <span class="text-sm text-gray-400">(324 reviews)</span>
                            </div>
                            
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <span class="text-2xl font-black text-primary">$89</span>
                                </div>
                            </div>
                            
                            <ul class="text-sm text-gray-400 space-y-1">
                                <li><i class="fas fa-check text-green-400 mr-2"></i>1080p HD video</li>
                                <li><i class="fas fa-check text-green-400 mr-2"></i>Auto-focus lens</li>
                                <li><i class="fas fa-check text-green-400 mr-2"></i>Built-in stereo mics</li>
                            </ul>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('productsGrid').insertAdjacentHTML('beforeend', newProducts);
            
            // Re-initialize AOS for new elements
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
            
            // Re-attach event listeners for new add to cart buttons
            document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const productId = btn.dataset.productId;
                    addToCart(productId);
                });
            });
        }, 1500);
    });
    
    // Wishlist functionality
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('text-red-400');
            if (this.classList.contains('text-red-400')) {
                this.innerHTML = '<i class="fas fa-heart"></i>';
            } else {
                this.innerHTML = '<i class="far fa-heart"></i>';
            }
        });
    });
    
    // Quick view functionality
    document.querySelectorAll('.quick-view-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            // In a real app, this would open a modal with product details
            alert('Quick view modal would open here');
        });
    });
});

// CSS Animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out;
    }
    
    .product-card:hover .add-to-cart-btn {
        transform: translateY(0) scale(1.05);
    }
    
    .category-btn.active {
        position: relative;
    }
    
    .category-btn.active::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 0.75rem;
        padding: 2px;
        background: linear-gradient(45deg, #C53030, #E53E3E);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: subtract;
    }
`;
document.head.appendChild(style);
</script>

@endsection