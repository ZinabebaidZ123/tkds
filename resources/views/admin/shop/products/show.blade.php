{{-- File: resources/views/admin/shop/products/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Product Details')
@section('page-title', 'Product Details')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.shop.products.index') }}" 
               class="p-2 text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h2>
                <p class="text-gray-600 text-sm mt-1">{{ $product->sku ? 'SKU: ' . $product->sku : 'Product details and statistics' }}</p>
            </div>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.shop.products.edit', $product) }}" 
               class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Edit Product
            </a>
            <button onclick="toggleStatus({{ $product->id }}, '{{ $product->status }}')" 
                    class="inline-flex items-center px-4 py-2 {{ $product->isActive() ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-xl transition-colors duration-200">
                <i class="fas {{ $product->isActive() ? 'fa-pause' : 'fa-play' }} mr-2"></i>
                {{ $product->isActive() ? 'Deactivate' : 'Activate' }}
            </button>
        </div>
    </div>

    <!-- Product Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Product Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Basic Info Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $product->getFeaturedImageUrl() }}" 
                             alt="{{ $product->name }}" 
                             class="w-24 h-24 object-cover rounded-xl border border-gray-200">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h3>
                            <p class="text-gray-600">{{ $product->slug }}</p>
                            @if($product->category)
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="fas fa-folder mr-1"></i>
                                    Category: <a href="{{ route('admin.shop.categories.show', $product->category) }}" 
                                                class="text-primary hover:text-secondary">{{ $product->category->name }}</a>
                                </p>
                            @endif
                            <div class="flex items-center space-x-4 mt-2">
                                @php $statusBadge = $product->getStockBadge() @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusBadge['class'] }}">
                                    <i class="{{ $statusBadge['icon'] }} mr-1"></i>
                                    {{ $statusBadge['text'] }}
                                </span>
                                @php $typeBadge = $product->getTypeBadge() @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $typeBadge['class'] }}">
                                    <i class="{{ $typeBadge['icon'] }} mr-1"></i>
                                    {{ $typeBadge['text'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-3xl font-bold text-gray-900">{{ $product->getFormattedPrice() }}</p>
                        @if($product->getFormattedOriginalPrice())
                            <p class="text-lg text-gray-500 line-through">{{ $product->getFormattedOriginalPrice() }}</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $product->getDiscountPercentage() }}% OFF
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Product Description -->
                @if($product->short_description)
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Short Description</h4>
                        <div class="bg-gray-50 rounded-xl p-4 border-l-4 border-primary">
                            <p class="text-gray-800 leading-relaxed">{{ $product->short_description }}</p>
                        </div>
                    </div>
                @endif

                @if($product->description)
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Full Description</h4>
                        <div class="prose max-w-none">
                            <div class="bg-gray-50 rounded-xl p-4 border-l-4 border-primary">
                                <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Product Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-3">Product Information</h4>
                        <div class="space-y-3">
                            @if($product->sku)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">SKU:</span>
                                    <span class="font-medium text-gray-900">{{ $product->sku }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600">Type:</span>
                                <span class="font-medium text-gray-900">{{ ucfirst($product->type) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Currency:</span>
                                <span class="font-medium text-gray-900">{{ strtoupper($product->currency) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Featured:</span>
                                <span class="font-medium {{ $product->is_featured ? 'text-green-600' : 'text-gray-400' }}">
                                    {{ $product->is_featured ? 'Yes' : 'No' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Popular:</span>
                                <span class="font-medium {{ $product->is_popular ? 'text-green-600' : 'text-gray-400' }}">
                                    {{ $product->is_popular ? 'Yes' : 'No' }}
                                </span>
                            </div>
                            @if($product->isPhysical() && $product->weight)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Weight:</span>
                                    <span class="font-medium text-gray-900">{{ $product->weight }} kg</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-3">Dates</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created:</span>
                                <span class="font-medium text-gray-900">{{ $product->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Last Updated:</span>
                                <span class="font-medium text-gray-900">{{ $product->updated_at->format('M j, Y') }}</span>
                            </div>
                        </div>

                        @if($product->isSoftware())
                            <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-3 mt-6">Download Settings</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Download Limit:</span>
                                    <span class="font-medium text-gray-900">
                                        {{ $product->download_limit == -1 ? 'Unlimited' : $product->download_limit }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Expiry Days:</span>
                                    <span class="font-medium text-gray-900">
                                        {{ $product->download_expiry_days == 0 ? 'Never' : $product->download_expiry_days . ' days' }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Gallery -->
            @if($product->gallery && count($product->gallery) > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-images text-primary mr-3"></i>
                        Product Gallery ({{ count($product->gallery) }} images)
                    </h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($product->getGalleryImages() as $index => $image)
                            <div class="relative group">
                                <img src="{{ $image }}" 
                                     alt="Gallery {{ $index + 1 }}" 
                                     class="w-full h-32 object-cover rounded-xl border border-gray-200 group-hover:shadow-lg transition-shadow duration-200 cursor-pointer"
                                     onclick="openImageModal('{{ $image }}')">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition-all duration-200 flex items-center justify-center">
                                    <i class="fas fa-expand text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Downloadable Files -->
            @if($product->hasDownloadableFiles())
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-download text-primary mr-3"></i>
                        Downloadable Files ({{ count($product->getDownloadableFiles()) }} files)
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($product->getDownloadableFiles() as $index => $file)
                            <div class="flex items-center justify-between p-4 bg-purple-50 rounded-xl border border-purple-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-file text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $file['name'] ?? "File " . ($index + 1) }}</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ isset($file['size']) ? number_format($file['size'] / 1024 / 1024, 2) . ' MB' : 'Unknown size' }}
                                        </p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Available
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- SEO Information -->
            @if($product->meta_title || $product->meta_description)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-search text-primary mr-3"></i>
                        SEO Information
                    </h3>
                    
                    <div class="space-y-4">
                        @if($product->meta_title)
                            <div>
                                <h4 class="text-sm font-semibold text-gray-600 mb-2">Meta Title</h4>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $product->meta_title }}</p>
                            </div>
                        @endif
                        @if($product->meta_description)
                            <div>
                                <h4 class="text-sm font-semibold text-gray-600 mb-2">Meta Description</h4>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $product->meta_description }}</p>
                            </div>
                        @endif
                        @if($product->meta_description)
                            <div>
                                <h4 class="text-sm font-semibold text-gray-600 mb-2">Meta Description</h4>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $product->meta_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Recent Orders -->
            @if($product->orderItems()->exists())
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-shopping-cart text-primary mr-3"></i>
                        Recent Orders
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($product->orderItems()->with('order.user')->latest()->limit(5)->get() as $orderItem)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($orderItem->order->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $orderItem->order->order_number }}</h4>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            <span>{{ $orderItem->order->user->name }}</span>
                                            <span>Qty: {{ $orderItem->quantity }}</span>
                                            <span>{{ $orderItem->getFormattedTotal() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @php $orderBadge = $orderItem->order->getStatusBadge() @endphp
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $orderBadge['class'] }}">
                                        {{ $orderBadge['text'] }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $orderItem->order->created_at->format('M j, Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('admin.shop.orders.index', ['search' => $product->name]) }}" 
                           class="text-primary hover:text-secondary text-sm font-medium">
                            View All Orders for this Product →
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statistics -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-bar text-primary mr-3"></i>
                    Statistics
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-eye text-blue-600"></i>
                            <span class="text-blue-900 font-medium">Total Views</span>
                        </div>
                        <span class="text-xl font-bold text-blue-900">{{ number_format($stats['total_views']) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-shopping-cart text-green-600"></i>
                            <span class="text-green-900 font-medium">Total Sales</span>
                        </div>
                        <span class="text-xl font-bold text-green-900">{{ number_format($stats['total_sales']) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-xl">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-dollar-sign text-purple-600"></i>
                            <span class="text-purple-900 font-medium">Revenue</span>
                        </div>
                        <span class="text-xl font-bold text-purple-900">${{ number_format($stats['total_revenue'], 0) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-star text-yellow-600"></i>
                            <span class="text-yellow-900 font-medium">Avg Rating</span>
                        </div>
                        <span class="text-xl font-bold text-yellow-900">{{ number_format($stats['average_rating'], 1) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-comment text-red-600"></i>
                            <span class="text-red-900 font-medium">Reviews</span>
                        </div>
                        <span class="text-xl font-bold text-red-900">{{ $stats['total_reviews'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Inventory Status -->
            @if($product->isPhysical())
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-boxes text-primary mr-3"></i>
                        Inventory Status
                    </h3>
                    
                    <div class="space-y-4">
                        @if($product->manage_stock)
                            <div class="text-center p-4 {{ $product->stock_quantity <= 5 ? 'bg-red-50 border-red-200' : 'bg-green-50 border-green-200' }} rounded-xl border">
                                <i class="fas fa-boxes text-3xl {{ $product->stock_quantity <= 5 ? 'text-red-600' : 'text-green-600' }} mb-2"></i>
                                <p class="text-2xl font-bold {{ $product->stock_quantity <= 5 ? 'text-red-900' : 'text-green-900' }}">
                                    {{ $product->stock_quantity }}
                                </p>
                                <p class="text-sm {{ $product->stock_quantity <= 5 ? 'text-red-700' : 'text-green-700' }}">
                                    {{ $product->stock_quantity <= 5 ? 'Low Stock!' : 'In Stock' }}
                                </p>
                            </div>
                        @else
                            <div class="text-center p-4 bg-blue-50 border-blue-200 rounded-xl border">
                                <i class="fas fa-infinity text-3xl text-blue-600 mb-2"></i>
                                <p class="text-lg font-bold text-blue-900">Unlimited</p>
                                <p class="text-sm text-blue-700">Stock not managed</p>
                            </div>
                        @endif
                        
                        <div class="text-sm text-gray-600 text-center">
                            <p>Stock Management: {{ $product->manage_stock ? 'Enabled' : 'Disabled' }}</p>
                            @if($product->shipping_required)
                                <p class="mt-1">Shipping Required: Yes</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-bolt text-primary mr-3"></i>
                    Quick Actions
                </h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.shop.products.edit', $product) }}" 
                       class="w-full flex items-center justify-center p-3 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Product
                    </a>
                    
                    <button onclick="duplicateProduct({{ $product->id }})" 
                            class="w-full flex items-center justify-center p-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors duration-200">
                        <i class="fas fa-copy mr-2"></i>
                        Duplicate Product
                    </button>
                    
                    <a href="{{ route('admin.shop.reviews.index', ['product_id' => $product->id]) }}" 
                       class="w-full flex items-center justify-center p-3 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition-colors duration-200">
                        <i class="fas fa-star mr-2"></i>
                        View Reviews ({{ $product->getReviewsCount() }})
                    </a>
                    
                    @if($product->isPhysical() && $product->manage_stock)
                        <button onclick="updateStock({{ $product->id }})" 
                                class="w-full flex items-center justify-center p-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200">
                            <i class="fas fa-boxes mr-2"></i>
                            Update Stock
                        </button>
                    @endif
                    
                    <button onclick="deleteProduct({{ $product->id }})" 
                            class="w-full flex items-center justify-center p-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-200">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Product
                    </button>
                </div>
            </div>

            <!-- Category Information -->
            @if($product->category)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-folder text-primary mr-3"></i>
                        Category
                    </h3>
                    
                    <div class="flex items-center space-x-4">
                        @if($product->category->image)
                            <img src="{{ $product->category->getImageUrl() }}" 
                                 alt="{{ $product->category->name }}" 
                                 class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                        @else
                            <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-lg flex items-center justify-center">
                                @if($product->category->icon)
                                    <i class="{{ $product->category->icon }} text-white"></i>
                                @else
                                    <i class="fas fa-folder text-white"></i>
                                @endif
                            </div>
                        @endif
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $product->category->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $product->category->getProductsCount() }} products</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.shop.categories.show', $product->category) }}" 
                       class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200 mt-4">
                        View Category
                    </a>
                </div>
            @endif

            <!-- Recent Activity -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-clock text-primary mr-3"></i>
                    Recent Activity
                </h3>
                
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-white text-xs"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Product Created</p>
                            <p class="text-xs text-gray-500">{{ $product->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    @if($product->updated_at != $product->created_at)
                        <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-edit text-white text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                <p class="text-xs text-gray-500">{{ $product->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($product->orderItems()->exists())
                        @php $latestOrder = $product->orderItems()->with('order')->latest()->first() @endphp
                        <div class="flex items-center space-x-3 p-3 bg-purple-50 rounded-lg">
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-white text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Latest Sale</p>
                                <p class="text-xs text-gray-500">{{ $latestOrder->order->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center">
    <div class="max-w-4xl max-h-screen p-4">
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        <button onclick="closeImageModal()" 
                class="absolute top-4 right-4 text-white hover:text-gray-300 text-3xl">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<!-- Stock Update Modal -->
<div id="stockModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Stock Quantity</h3>
        <form id="stockForm">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Stock: {{ $product->stock_quantity }}</label>
                    <input type="number" id="newStock" min="0" value="{{ $product->stock_quantity }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
            </div>
            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" onclick="closeStockModal()" 
                        class="px-4 py-2 text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary">
                    Update Stock
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleStatus(productId, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this product?`)) {
        fetch(`/admin/shop/products/${productId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to update product status');
            }
        });
    }
}

function duplicateProduct(productId) {
    if (confirm('Are you sure you want to duplicate this product?')) {
        fetch(`/admin/shop/products/${productId}/duplicate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    location.reload();
                }
            } else {
                alert('Failed to duplicate product');
            }
        });
    }
}

function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        fetch(`/admin/shop/products/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route('admin.shop.products.index') }}';
            } else {
                alert(data.message || 'Failed to delete product');
            }
        });
    }
}

function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

function updateStock(productId) {
    document.getElementById('stockModal').classList.remove('hidden');
}

function closeStockModal() {
    document.getElementById('stockModal').classList.add('hidden');
}

document.getElementById('stockForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const newStock = document.getElementById('newStock').value;
    const productId = {{ $product->id }};
    
    fetch('/admin/shop/inventory/bulk-update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            updates: [{
                product_id: productId,
                stock_quantity: parseInt(newStock)
            }]
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to update stock');
        }
    });
});

// Close modals on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
        closeStockModal();
    }
});
</script>
@endsection