<div class="product-card group" data-product-id="{{ $product->id }}" data-aos="fade-up" data-aos-delay="{{ ($loop->index ?? 0) * 100 }}">
    <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-primary/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/20">
        <!-- Product Image -->
        <div class="relative h-64 overflow-hidden group">
            <img src="{{ $product->getFeaturedImageUrl() }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                 loading="lazy">
            
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            
            <!-- Top Badges Row -->
            <div class="absolute top-3 left-3 right-3 flex items-start justify-between">
                <!-- Left Side Badges -->
                <div class="flex flex-col space-y-2 max-w-[60%]">
                    @php $stockBadge = $product->getStockBadge() @endphp
                    <span class="inline-block px-2 py-1 rounded-lg text-xs font-bold {{ $stockBadge['class'] }} backdrop-blur-sm">
                        <i class="{{ $stockBadge['icon'] }} mr-1"></i>
                        {{ $stockBadge['text'] }}
                    </span>
                    
                    @if($product->is_featured)
                        <span class="inline-block px-2 py-1 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-xs font-bold rounded-lg backdrop-blur-sm">
                            ⭐ Bestseller
                        </span>
                    @endif
                </div>
                
                <!-- Right Side Badges -->
                <div class="flex flex-col space-y-2 items-end max-w-[35%]">
                    @if($product->getDiscountPercentage() > 0)
                        <span class="inline-block px-2 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-lg backdrop-blur-sm animate-pulse">
                            -{{ $product->getDiscountPercentage() }}%
                        </span>
                    @endif
                    
                    <!-- Quick View Button -->
                    <button class="quick-view-btn w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center text-white hover:bg-primary/30 hover:text-primary transition-all duration-300 opacity-0 group-hover:opacity-100"
                            data-product-id="{{ $product->id }}" title="Quick View">
                        <i class="fas fa-eye text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Quick Add to Cart -->
            <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                @if($product->canPurchase())
                    <button class="add-to-cart-btn w-full bg-gradient-to-r from-primary to-secondary text-white py-2.5 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 text-sm" 
                            data-product-id="{{ $product->id }}">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Add to Cart
                    </button>
                @else
                    <button class="w-full bg-gray-600 text-gray-400 py-2.5 rounded-xl font-semibold cursor-not-allowed text-sm" disabled>
                        <i class="fas fa-ban mr-2"></i>
                        Unavailable
                    </button>
                @endif
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="p-5">
            <!-- Category & Type in one row -->
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-gray-400 uppercase tracking-wider">
                    {{ $product->category?->name ?? 'Uncategorized' }}
                </span>
                
                @php $typeBadge = $product->getTypeBadge() @endphp
                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium {{ $typeBadge['class'] }}">
                    <i class="{{ $typeBadge['icon'] }} mr-1"></i>
                    {{ Str::replace('Software Download', 'Digital', $typeBadge['text']) }}
                </span>
            </div>
            
            <!-- Product Name -->
            <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary transition-colors duration-300 line-clamp-2 min-h-[3.5rem]">
                <a href="{{ route('shop.product', $product->slug) }}">{{ $product->name }}</a>
            </h3>
            
            <!-- Rating -->
            @if($product->getReviewsCount() > 0)
                <div class="flex items-center space-x-2 mb-3">
                    <div class="flex space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $product->getAverageRating())
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                            @else
                                <i class="fas fa-star text-gray-400 text-xs"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-xs text-gray-400">({{ $product->getReviewsCount() }})</span>
                </div>
            @endif
            
            <!-- Price Section - Enhanced -->
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <div class="flex items-center space-x-2">
                            <span class="text-xl font-black text-primary">{{ $product->getFormattedPrice() }}</span>
                            @if($product->getFormattedOriginalPrice())
                                <span class="text-sm text-gray-400 line-through">{{ $product->getFormattedOriginalPrice() }}</span>
                            @endif
                        </div>
                        @if($product->getDiscountPercentage() > 0)
                            <span class="text-xs text-green-400 font-medium mt-1">
                                Save {{ $product->getFormattedOriginalPrice() ? '$' . number_format($product->price - $product->sale_price, 2) : '' }}
                            </span>
                        @endif
                    </div>
                    
                    @if($product->getDiscountPercentage() > 0)
                        <div class="bg-red-500 text-white px-2 py-1 rounded-lg text-xs font-bold animate-pulse">
                            -{{ $product->getDiscountPercentage() }}%
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Features (max 2 for space) -->
            @if($product->features && count($product->features) > 0)
                <ul class="text-xs text-gray-400 space-y-1 mb-4">
                    @foreach(array_slice($product->features, 0, 2) as $feature)
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-400 mr-2 mt-0.5 flex-shrink-0 text-xs"></i>
                            <span class="line-clamp-1">{{ $feature }}</span>
                        </li>
                    @endforeach
                    @if(count($product->features) > 2)
                        <li class="text-primary text-xs font-medium">
                            +{{ count($product->features) - 2 }} more features
                        </li>
                    @endif
                </ul>
            @endif
        </div>
        
        <!-- Product Actions Footer -->
        <div class="px-5 pb-5 pt-0">
            <div class="flex space-x-2">
                <a href="{{ route('shop.product', $product->slug) }}" 
                   class="flex-1 text-center px-3 py-2.5 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors duration-200 text-sm font-medium">
                    <i class="fas fa-info-circle mr-1"></i>
                    Details
                </a>
                
                @if($product->canPurchase())
                    <button class="add-to-cart-btn flex-1 text-center px-3 py-2.5 bg-gradient-to-r from-primary to-secondary text-white rounded-lg hover:from-secondary hover:to-accent transition-all duration-200 text-sm font-medium"
                            data-product-id="{{ $product->id }}">
                        <i class="fas fa-cart-plus mr-1"></i>
                        Add 
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
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

.product-card:hover .add-to-cart-btn {
    transform: translateY(0) scale(1.02);
}

.product-card .quick-view-btn:hover {
    transform: scale(1.1);
}

/* Enhanced animations */
.product-card .quick-view-btn {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(197, 48, 48, 0.25);
}

/* Better badge positioning */
.product-card .absolute.top-3 {
    z-index: 10;
}

/* Ensure text doesn't overflow */
.product-card h3 {
    word-wrap: break-word;
    hyphens: auto;
}

@media (max-width: 640px) {
    .product-card {
        margin: 0 auto;
        max-width: 280px;
    }
    
    .product-card h3 {
        font-size: 1rem;
        min-height: 3rem;
    }
    
    .product-card .text-xl {
        font-size: 1.125rem;
    }
}
</style>