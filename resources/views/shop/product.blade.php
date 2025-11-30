{{-- File: resources/views/shop/product.blade.php --}}
@extends('layouts.app')

@section('title', $product->name . ' - TKDS Media Shop')
@section('meta_description', $product->short_description ?: $product->description)

@section('content')

<!-- Breadcrumbs -->
<section class="bg-dark-light py-4 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">Home</a>
            <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
            <a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">Shop</a>
            @if($product->category)
                <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
                <a href="{{ route('shop.category', $product->category->slug) }}" class="text-gray-400 hover:text-primary transition-colors duration-200">{{ $product->category->name }}</a>
            @endif
            <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
            <span class="text-white">{{ $product->name }}</span>
        </nav>
    </div>
</section>

<!-- Product Details -->
<section class="py-16 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12">
            
            <!-- Product Images -->
            <div class="space-y-6" data-aos="fade-right">
                <!-- Main Image -->
                <div class="relative bg-white/5 rounded-2xl overflow-hidden border border-white/10">
                    <img id="mainProductImage" 
                         src="{{ $product->getFeaturedImageUrl() }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-96 lg:h-[500px] object-cover">
                    
                    <!-- Image Zoom -->
                    <div class="absolute top-4 right-4">
                        <button id="zoomBtn" class="w-10 h-10 bg-black/50 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-black/70 transition-all duration-300">
                            <i class="fas fa-search-plus"></i>
                        </button>
                    </div>
                    
                    <!-- Product Badges -->
                    <div class="absolute top-4 left-4 space-y-2">
                        @php $stockBadge = $product->getStockBadge() @endphp
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $stockBadge['class'] }}">
                            <i class="{{ $stockBadge['icon'] }} mr-1"></i>
                            {{ $stockBadge['text'] }}
                        </span>
                        
                        @if($product->is_featured)
                            <span class="block px-3 py-1 bg-primary text-white text-xs font-bold rounded-full">
                                Bestseller
                            </span>
                        @endif
                        
                        @if($product->getDiscountPercentage() > 0)
                            <span class="block px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                                -{{ $product->getDiscountPercentage() }}% OFF
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Gallery Thumbnails -->
                @if($product->getGalleryImages())
                    <div class="flex space-x-4 overflow-x-auto pb-2">
                       <button class="thumbnail-btn flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-primary" 
                                data-image="{{ $product->getFeaturedImageUrl() }}">
                            <img src="{{ $product->getFeaturedImageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </button>
                        
                        @foreach($product->getGalleryImages() as $image)
                            <button class="thumbnail-btn flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-white/20 hover:border-primary transition-colors duration-200" 
                                    data-image="{{ $image }}">
                                <img src="{{ $image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Information -->
            <div class="space-y-8" data-aos="fade-left">
                
                <!-- Product Header -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="text-sm text-gray-400">{{ $product->category?->name ?? 'Uncategorized' }}</span>
                        @php $typeBadge = $product->getTypeBadge() @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $typeBadge['class'] }}">
                            <i class="{{ $typeBadge['icon'] }} mr-1"></i>
                            {{ $typeBadge['text'] }}
                        </span>
                    </div>
                    
                    <h1 class="text-3xl lg:text-4xl font-black text-white mb-4">{{ $product->name }}</h1>
                    
                    @if($product->short_description)
                        <p class="text-xl text-gray-300 leading-relaxed">{{ $product->short_description }}</p>
                    @endif
                </div>

                <!-- Rating & Reviews -->
                @if($product->getReviewsCount() > 0)
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-2">
                            <div class="flex space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $product->getAverageRating())
                                        <i class="fas fa-star text-yellow-400 text-lg"></i>
                                    @else
                                        <i class="fas fa-star text-gray-400 text-lg"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-white font-semibold">{{ number_format($product->getAverageRating(), 1) }}</span>
                        </div>
                        <a href="#reviews" class="text-primary hover:text-secondary transition-colors duration-200">
                            ({{ $product->getReviewsCount() }} {{ $product->getReviewsCount() === 1 ? 'review' : 'reviews' }})
                        </a>
                    </div>
                @endif

                <!-- Price -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <span class="text-4xl font-black text-primary">{{ $product->getFormattedPrice() }}</span>
                        @if($product->getFormattedOriginalPrice())
                            <span class="text-2xl text-gray-400 line-through">{{ $product->getFormattedOriginalPrice() }}</span>
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                Save {{ $product->getDiscountPercentage() }}%
                            </span>
                        @endif
                    </div>
                    
                    <!-- Stock Status -->
                    @php $stockBadge = $product->getStockBadge() @endphp
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $stockBadge['class'] }}">
                            <i class="{{ $stockBadge['icon'] }} mr-2"></i>
                            {{ $stockBadge['text'] }}
                        </span>
                        @if($product->sku)
                            <span class="text-gray-400 text-sm">SKU: {{ $product->sku }}</span>
                        @endif
                    </div>
                </div>

                <!-- Quantity & Add to Cart -->
                @if($product->canPurchase())
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <label class="text-white font-semibold">Quantity:</label>
                            <div class="flex items-center space-x-3">
                                <button id="decreaseQty" class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center text-white hover:bg-red-500/20 hover:text-red-400 transition-all duration-300">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="productQuantity" value="1" min="1" max="{{ $product->isSoftware() ? 99 : $product->stock_quantity }}"
                                       class="w-20 px-3 py-2 bg-white/10 border border-white/20 rounded-lg text-white text-center focus:outline-none focus:ring-2 focus:ring-primary">
                                <button id="increaseQty" class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center text-white hover:bg-green-500/20 hover:text-green-400 transition-all duration-300">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-4">
                            <button id="addToCartBtn" 
                                    class="flex-1 bg-gradient-to-r from-primary to-secondary text-white py-4 px-8 rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl"
                                    data-product-id="{{ $product->id }}">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Add to Cart
                            </button>
                            

                        </div>

                        <!-- Quick Actions -->
                        <div class="flex space-x-4 text-sm">
                            <button class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fas fa-share-alt"></i>
                                <span>Share</span>
                            </button>
                            {{-- <button class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fas fa-balance-scale"></i>
                                <span>Compare</span>
                            </button> --}}
                            @if($product->isSoftware())
                                <button class="flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
                                    <i class="fas fa-download"></i>
                                    <span>Download Info</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="p-6 bg-red-500/10 border border-red-500/20 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                            <div>
                                <h3 class="text-white font-semibold">Currently Unavailable</h3>
                                <p class="text-gray-400 text-sm">This product is temporarily out of stock. Check back later or contact us for availability.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Product Guarantees -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6 border-t border-white/10">
                    <div class="text-center p-4">
                        <i class="fas fa-shipping-fast text-primary text-2xl mb-2"></i>
                        <h4 class="text-white font-semibold text-sm">Free Shipping</h4>
                        <p class="text-gray-400 text-xs">Orders over $500</p>
                    </div>
                    <div class="text-center p-4">
                        <i class="fas fa-shield-alt text-primary text-2xl mb-2"></i>
                        <h4 class="text-white font-semibold text-sm">Warranty</h4>
                        <p class="text-gray-400 text-xs">2-year protection</p>
                    </div>
                    <div class="text-center p-4">
                        <i class="fas fa-undo text-primary text-2xl mb-2"></i>
                        <h4 class="text-white font-semibold text-sm">Easy Returns</h4>
                        <p class="text-gray-400 text-xs">30-day policy</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Details Tabs -->
<section class="py-16 bg-dark-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Tab Navigation -->
        <div class="flex flex-wrap border-b border-white/10 mb-8" data-aos="fade-up">
            <button class="tab-btn active px-6 py-4 text-white font-semibold border-b-2 border-primary" data-tab="description">
                Description
            </button>
            @if($product->specifications && count($product->specifications) > 0)
                <button class="tab-btn px-6 py-4 text-gray-400 font-semibold border-b-2 border-transparent hover:text-white transition-colors duration-200" data-tab="specifications">
                    Specifications
                </button>
            @endif
            @if($product->features && count($product->features) > 0)
                <button class="tab-btn px-6 py-4 text-gray-400 font-semibold border-b-2 border-transparent hover:text-white transition-colors duration-200" data-tab="features">
                    Features
                </button>
            @endif
            @if($product->isSoftware() && $product->hasDownloadableFiles())
                <button class="tab-btn px-6 py-4 text-gray-400 font-semibold border-b-2 border-transparent hover:text-white transition-colors duration-200" data-tab="downloads">
                    Download Info
                </button>
            @endif
            @if($product->getReviewsCount() > 0)
                <button class="tab-btn px-6 py-4 text-gray-400 font-semibold border-b-2 border-transparent hover:text-white transition-colors duration-200" data-tab="reviews">
                    Reviews ({{ $product->getReviewsCount() }})
                </button>
            @endif
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Description Tab -->
            <div id="description" class="tab-pane active" data-aos="fade-up">
                <div class="prose prose-invert max-w-none">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <!-- Specifications Tab -->
            @if($product->specifications && count($product->specifications) > 0)
                <div id="specifications" class="tab-pane hidden" data-aos="fade-up">
                    <div class="bg-white/5 rounded-2xl p-8">
                        <h3 class="text-2xl font-bold text-white mb-6">Technical Specifications</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            @foreach($product->specifications as $key => $value)
                                <div class="flex justify-between py-3 border-b border-white/10">
                                    <span class="text-gray-400">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                    <span class="text-white font-semibold">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Features Tab -->
            @if($product->features && count($product->features) > 0)
                <div id="features" class="tab-pane hidden" data-aos="fade-up">
                    <div class="bg-white/5 rounded-2xl p-8">
                        <h3 class="text-2xl font-bold text-white mb-6">Key Features</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach($product->features as $feature)
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-check text-green-400 mt-1 flex-shrink-0"></i>
                                    <span class="text-gray-300">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Download Info Tab -->
            @if($product->isSoftware() && $product->hasDownloadableFiles())
                <div id="downloads" class="tab-pane hidden" data-aos="fade-up">
                    <div class="bg-white/5 rounded-2xl p-8">
                        <h3 class="text-2xl font-bold text-white mb-6">Download Information</h3>
                        <div class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                @if($product->download_limit > 0)
                                    <div>
                                        <h4 class="text-white font-semibold mb-2">Download Limit</h4>
                                        <p class="text-gray-400">{{ $product->download_limit }} downloads per purchase</p>
                                    </div>
                                @endif
                                
                                @if($product->download_expiry_days > 0)
                                    <div>
                                        <h4 class="text-white font-semibold mb-2">Access Duration</h4>
                                        <p class="text-gray-400">{{ $product->download_expiry_days }} days from purchase</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div>
                                <h4 class="text-white font-semibold mb-4">Available Files</h4>
                                <div class="space-y-3">
                                    @foreach($product->getDownloadableFiles() as $file)
                                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <i class="fas fa-file-download text-primary"></i>
                                                <span class="text-white">{{ $file['name'] ?? 'Download File' }}</span>
                                            </div>
                                            @if(isset($file['size']))
                                                <span class="text-gray-400 text-sm">{{ $file['size'] }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Reviews Tab -->
            @if($product->getReviewsCount() > 0)
                <div id="reviews" class="tab-pane hidden" data-aos="fade-up">
                    <div class="space-y-8">
                        <!-- Review Summary -->
                        <div class="bg-white/5 rounded-2xl p-8">
                            <div class="grid md:grid-cols-2 gap-8">
                                <div class="text-center">
                                    <div class="text-5xl font-black text-white mb-2">{{ number_format($reviewStats['average_rating'], 1) }}</div>
                                    <div class="flex justify-center space-x-1 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $reviewStats['average_rating'])
                                                <i class="fas fa-star text-yellow-400 text-xl"></i>
                                            @else
                                                <i class="fas fa-star text-gray-400 text-xl"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-gray-400">Based on {{ $reviewStats['total_reviews'] }} reviews</p>
                                </div>
                                
                                <div class="space-y-3">
                                    @foreach($reviewStats['rating_breakdown'] as $rating => $data)
                                        <div class="flex items-center space-x-4">
                                            <span class="text-sm text-gray-400 w-12">{{ $rating }} star</span>
                                            <div class="flex-1 bg-gray-700 rounded-full h-2">
                                                <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $data['percentage'] }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-400 w-12">{{ $data['count'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Individual Reviews -->
                        <div class="space-y-6" id="reviewsList">
                            @foreach($reviews as $review)
                                <div class="bg-white/5 rounded-xl p-6">
                                    <div class="flex items-start space-x-4">
                                        <img src="{{ $review->user->getAvatarUrl() }}" alt="{{ $review->user->name }}" 
                                             class="w-12 h-12 rounded-full object-cover">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <div>
                                                    <h4 class="text-white font-semibold">{{ $review->user->name }}</h4>
                                                    <div class="flex space-x-1 mt-1">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $review->rating)
                                                                <i class="fas fa-star text-yellow-400"></i>
                                                            @else
                                                                <i class="fas fa-star text-gray-400"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                                <span class="text-gray-400 text-sm">{{ $review->created_at->format('M j, Y') }}</span>
                                            </div>
                                            
                                            @if($review->title)
                                                <h5 class="text-white font-semibold mb-2">{{ $review->title }}</h5>
                                            @endif
                                            
                                            <p class="text-gray-300 leading-relaxed">{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Review Pagination -->
                        <div class="text-center">
                            {{ $reviews->links() }}
                        </div>

                        <!-- Write Review Section -->
                        @auth
                            @if($canReview)
                                <div class="bg-white/5 rounded-2xl p-8">
                                    <h3 class="text-2xl font-bold text-white mb-6">Write a Review</h3>
                                    <form id="reviewForm" class="space-y-6">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        
                                        <!-- Rating Selection -->
                                        <div>
                                            <label class="block text-white font-semibold mb-3">Your Rating</label>
                                            <div class="flex space-x-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <button type="button" class="rating-star text-3xl text-gray-400 hover:text-yellow-400 transition-colors duration-200" data-rating="{{ $i }}">
                                                        <i class="fas fa-star"></i>
                                                    </button>
                                                @endfor
                                            </div>
                                            <input type="hidden" name="rating" id="selectedRating" value="">
                                        </div>
                                        
                                        <!-- Review Title -->
                                        <div>
                                            <label for="reviewTitle" class="block text-white font-semibold mb-2">Review Title (Optional)</label>
                                            <input type="text" id="reviewTitle" name="title" 
                                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary"
                                                   placeholder="Summarize your review">
                                        </div>
                                        
                                        <!-- Review Comment -->
                                        <div>
                                            <label for="reviewComment" class="block text-white font-semibold mb-2">Your Review</label>
                                            <textarea id="reviewComment" name="comment" rows="5" required
                                                      class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary resize-none"
                                                      placeholder="Share your experience with this product..."></textarea>
                                        </div>
                                        
                                        <!-- Submit Button -->
                                        <button type="submit" id="submitReviewBtn"
                                                class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                            Submit Review
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <div class="bg-white/5 rounded-2xl p-8 text-center">
                                <h3 class="text-white font-semibold mb-2">Want to leave a review?</h3>
                                <p class="text-gray-400 mb-4">Sign in to share your experience with this product</p>
                                <a href="{{ route('auth.login') }}" 
                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-accent transition-all duration-300">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Sign In to Review
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="py-20 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Related Products</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">You might also be interested in these products</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($relatedProducts as $relatedProduct)
                @include('shop.partials.product-card', ['product' => $relatedProduct])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Recently Viewed -->
<section class="py-16 bg-dark-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-2xl md:text-3xl font-black text-white mb-4">Recently Viewed</h2>
        </div>
        
        <div id="recentlyViewedContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Recently viewed products will be loaded here via JavaScript -->
        </div>
    </div>
</section>

<!-- Cart Sidebar -->
@include('shop.partials.cart-sidebar')

<!-- Image Zoom Modal -->
<div id="imageZoomModal" class="fixed inset-0 bg-black bg-opacity-90 hidden items-center justify-center z-50 p-4">
    <div class="relative max-w-4xl max-h-full">
        <button id="closeZoomModal" class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl z-10">
            <i class="fas fa-times"></i>
        </button>
        <img id="zoomedImage" src="" alt="" class="max-w-full max-h-full object-contain">
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize product page functionality
    initializeProductPage();
    initializeTabs();
    initializeImageGallery();
    initializeQuantityControls();
    initializeReviewForm();
    initializeRecentlyViewed();
});

function initializeProductPage() {
    // Add to cart functionality
    const addToCartBtn = document.getElementById('addToCartBtn');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const quantity = document.getElementById('productQuantity').value;
            addToCart(this.dataset.productId, parseInt(quantity));
        });
    }

    // Wishlist functionality
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            toggleWishlist(this.dataset.productId);
        });
    });

    // Share functionality
    document.querySelector('[data-action="share"]')?.addEventListener('click', function() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $product->name }}',
                text: '{{ $product->short_description }}',
                url: window.location.href
            });
        } else {
            // Fallback for browsers that don't support Web Share API
            navigator.clipboard.writeText(window.location.href);
            showNotification('Link copied to clipboard!', 'success');
        }
    });
}

function initializeTabs() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.dataset.tab;

            // Remove active state from all tabs
            tabBtns.forEach(b => {
                b.classList.remove('active', 'text-white', 'border-primary');
                b.classList.add('text-gray-400', 'border-transparent');
            });

            // Add active state to clicked tab
            this.classList.add('active', 'text-white', 'border-primary');
            this.classList.remove('text-gray-400', 'border-transparent');

            // Hide all tab panes
            tabPanes.forEach(pane => {
                pane.classList.add('hidden');
                pane.classList.remove('active');
            });

            // Show target tab pane
            const targetPane = document.getElementById(targetTab);
            if (targetPane) {
                targetPane.classList.remove('hidden');
                targetPane.classList.add('active');
            }
        });
    });
}

function initializeImageGallery() {
    const mainImage = document.getElementById('mainProductImage');
    const thumbnails = document.querySelectorAll('.thumbnail-btn');
    const zoomBtn = document.getElementById('zoomBtn');
    const zoomModal = document.getElementById('imageZoomModal');
    const zoomedImage = document.getElementById('zoomedImage');
    const closeZoomModal = document.getElementById('closeZoomModal');

    // Thumbnail click handlers
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            const newImageSrc = this.dataset.image;
            mainImage.src = newImageSrc;

            // Update active thumbnail
            thumbnails.forEach(t => {
                t.classList.remove('border-primary');
                t.classList.add('border-white/20');
            });
            this.classList.add('border-primary');
            this.classList.remove('border-white/20');
        });
    });

    // Zoom functionality
    if (zoomBtn && zoomModal && zoomedImage && closeZoomModal) {
        zoomBtn.addEventListener('click', function() {
            zoomedImage.src = mainImage.src;
            zoomModal.classList.remove('hidden');
            zoomModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });

        closeZoomModal.addEventListener('click', closeZoom);
        zoomModal.addEventListener('click', function(e) {
            if (e.target === this) closeZoom();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeZoom();
        });

        function closeZoom() {
            zoomModal.classList.add('hidden');
            zoomModal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }
}

function initializeQuantityControls() {
    const quantityInput = document.getElementById('productQuantity');
    const decreaseBtn = document.getElementById('decreaseQty');
    const increaseBtn = document.getElementById('increaseQty');

    if (quantityInput && decreaseBtn && increaseBtn) {
        decreaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        increaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            const maxValue = parseInt(quantityInput.max);
            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
            }
        });

        // Validate input
        quantityInput.addEventListener('input', function() {
            const value = parseInt(this.value);
            const min = parseInt(this.min);
            const max = parseInt(this.max);

            if (value < min) this.value = min;
            if (value > max) this.value = max;
        });
    }
}

function initializeReviewForm() {
    const reviewForm = document.getElementById('reviewForm');
    const ratingStars = document.querySelectorAll('.rating-star');
    const selectedRatingInput = document.getElementById('selectedRating');

    if (ratingStars.length > 0) {
        ratingStars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                selectedRatingInput.value = rating;

                // Update star display
                ratingStars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.remove('text-gray-400');
                        s.classList.add('text-yellow-400');
                    } else {
                        s.classList.remove('text-yellow-400');
                        s.classList.add('text-gray-400');
                    }
                });
            });

            // Hover effect
            star.addEventListener('mouseenter', function() {
                const rating = this.dataset.rating;
                ratingStars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.add('text-yellow-400');
                    }
                });
            });
        });

        // Reset hover effect
        document.querySelector('.flex.space-x-2').addEventListener('mouseleave', function() {
            const currentRating = selectedRatingInput.value;
            ratingStars.forEach((s, i) => {
                if (i < currentRating) {
                    s.classList.add('text-yellow-400');
                    s.classList.remove('text-gray-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-400');
                }
            });
        });
    }

    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitReview();
        });
    }
}

function submitReview() {
    const form = document.getElementById('reviewForm');
    const submitBtn = document.getElementById('submitReviewBtn');
    const formData = new FormData(form);

    // Validate rating
    if (!formData.get('rating')) {
        showNotification('Please select a rating', 'error');
        return;
    }

    // Disable submit button
    submitBtn.disabled = true;
    submitBtn.textContent = 'Submitting...';

    fetch('{{ route("shop.product.review", $product->slug) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            form.reset();
            // Reset rating stars
            document.querySelectorAll('.rating-star').forEach(star => {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-400');
            });
            document.getElementById('selectedRating').value = '';
        } else {
            showNotification(data.message || 'Failed to submit review', 'error');
        }
    })
    .catch(error => {
        showNotification('Something went wrong', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Submit Review';
    });
}

function initializeRecentlyViewed() {
    // Add current product to recently viewed
    const productData = {
        id: {{ $product->id }},
        name: '{{ $product->name }}',
        slug: '{{ $product->slug }}',
        price: '{{ $product->getFormattedPrice() }}',
        image: '{{ $product->getFeaturedImageUrl() }}',
        category: '{{ $product->category?->name ?? "" }}'
    };

    addToRecentlyViewed(productData);
    loadRecentlyViewed();
}

function addToRecentlyViewed(product) {
    let recentlyViewed = JSON.parse(localStorage.getItem('recentlyViewed') || '[]');
    
    // Remove if already exists
    recentlyViewed = recentlyViewed.filter(item => item.id !== product.id);
    
    // Add to beginning
    recentlyViewed.unshift(product);
    
    // Keep only last 8 products
    recentlyViewed = recentlyViewed.slice(0, 8);
    
    localStorage.setItem('recentlyViewed', JSON.stringify(recentlyViewed));
}

function loadRecentlyViewed() {
    const container = document.getElementById('recentlyViewedContainer');
    const recentlyViewed = JSON.parse(localStorage.getItem('recentlyViewed') || '[]');
    
    // Exclude current product
    const filteredProducts = recentlyViewed.filter(item => item.id !== {{ $product->id }});
    
    if (filteredProducts.length === 0) {
        container.parentElement.style.display = 'none';
        return;
    }

    container.innerHTML = filteredProducts.slice(0, 4).map(product => `
        <div class="bg-white/5 rounded-xl overflow-hidden hover:bg-white/10 transition-all duration-300">
            <a href="/shop/product/${product.slug}" class="block">
                <img src="${product.image}" alt="${product.name}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-white font-semibold mb-2 truncate">${product.name}</h3>
                    <p class="text-gray-400 text-sm mb-2">${product.category}</p>
                    <p class="text-primary font-bold">${product.price}</p>
                </div>
            </a>
        </div>
    `).join('');
}

function addToCart(productId, quantity = 1) {
    const btn = document.getElementById('addToCartBtn');
    const originalText = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Adding...';

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
            showNotification(data.message, 'success');
            // Update cart UI if cart sidebar exists
            if (window.shoppingCart) {
                window.shoppingCart.loadCart();
            }
        } else {
            showNotification(data.message || 'Failed to add to cart', 'error');
        }
    })
    .catch(error => {
        showNotification('Something went wrong', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

function toggleWishlist(productId) {
    // Wishlist functionality - implement based on your requirements
    console.log('Toggle wishlist for product:', productId);
    showNotification('Wishlist feature coming soon!', 'info');
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
</script>

<style>
.prose-invert {
    color: #d1d5db;
}

.prose-invert p {
    margin-bottom: 1rem;
    line-height: 1.7;
}

.prose-invert h1, .prose-invert h2, .prose-invert h3, .prose-invert h4 {
    color: #ffffff;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose-invert ul, .prose-invert ol {
    margin: 1rem 0;
    padding-left: 2rem;
}

.prose-invert li {
    margin-bottom: 0.5rem;
}

.tab-btn.active {
    color: white;
    border-color: #C53030;
}

.rating-star {
    cursor: pointer;
    user-select: none;
    transition: color 0.2s ease;
}

.rating-star:hover {
    transform: scale(1.1);
}

/* Custom scrollbar for image gallery */
.overflow-x-auto::-webkit-scrollbar {
    height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #C53030;
    border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #E53E3E;
}
</style>

@endsection