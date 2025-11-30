{{-- File: resources/views/admin/shop/categories/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Category Details')
@section('page-title', 'Category Details')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.shop.categories.index') }}" 
               class="p-2 text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h2>
                <p class="text-gray-600 text-sm mt-1">Category details and statistics</p>
            </div>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.shop.categories.edit', $category) }}" 
               class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Edit Category
            </a>
            <button onclick="toggleStatus({{ $category->id }}, '{{ $category->status }}')" 
                    class="inline-flex items-center px-4 py-2 {{ $category->isActive() ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-xl transition-colors duration-200">
                <i class="fas {{ $category->isActive() ? 'fa-pause' : 'fa-play' }} mr-2"></i>
                {{ $category->isActive() ? 'Deactivate' : 'Activate' }}
            </button>
        </div>
    </div>

    <!-- Category Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        @if($category->image)
                            <img src="{{ $category->getImageUrl() }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-20 h-20 object-cover rounded-xl border border-gray-200">
                        @else
                            <div class="w-20 h-20 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center">
                                @if($category->icon)
                                    <i class="{{ $category->icon }} text-white text-2xl"></i>
                                @else
                                    <i class="fas fa-folder text-white text-2xl"></i>
                                @endif
                            </div>
                        @endif
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h3>
                            <p class="text-gray-600">{{ $category->slug }}</p>
                            @if($category->parent)
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="fas fa-folder mr-1"></i>
                                    Parent: <a href="{{ route('admin.shop.categories.show', $category->parent) }}" 
                                              class="text-primary hover:text-secondary">{{ $category->parent->name }}</a>
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    @php $statusBadge = $category->isActive() ? ['text' => 'Active', 'class' => 'bg-green-500/20 text-green-400', 'icon' => 'fas fa-check-circle'] : ['text' => 'Inactive', 'class' => 'bg-red-500/20 text-red-400', 'icon' => 'fas fa-times-circle'] @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusBadge['class'] }}">
                        <i class="{{ $statusBadge['icon'] }} mr-2"></i>
                        {{ $statusBadge['text'] }}
                    </span>
                </div>

                @if($category->description)
                    <div class="prose max-w-none">
                        <div class="bg-gray-50 rounded-xl p-4 border-l-4 border-primary">
                            <p class="text-gray-800 leading-relaxed">{{ $category->description }}</p>
                        </div>
                    </div>
                @endif

                <!-- Category Details -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-3">Category Information</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sort Order:</span>
                                <span class="font-medium text-gray-900">{{ $category->sort_order ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Featured:</span>
                                <span class="font-medium {{ $category->is_featured ? 'text-green-600' : 'text-gray-400' }}">
                                    {{ $category->is_featured ? 'Yes' : 'No' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created:</span>
                                <span class="font-medium text-gray-900">
                                    {{ $category->created_at ? $category->created_at->format('M j, Y') : 'N/A' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Last Updated:</span>
                                <span class="font-medium text-gray-900">
                                    {{ $category->updated_at ? $category->updated_at->format('M j, Y') : 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($category->meta_title || $category->meta_description)
                        <div>
                            <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-3">SEO Information</h4>
                            <div class="space-y-3">
                                @if($category->meta_title)
                                    <div>
                                        <span class="text-gray-600 text-sm">Meta Title:</span>
                                        <p class="font-medium text-gray-900 text-sm">{{ $category->meta_title }}</p>
                                    </div>
                                @endif
                                @if($category->meta_description)
                                    <div>
                                        <span class="text-gray-600 text-sm">Meta Description:</span>
                                        <p class="font-medium text-gray-900 text-sm">{{ $category->meta_description }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Subcategories -->
            @if($category->children()->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-folder-open text-primary mr-3"></i>
                            Subcategories ({{ $category->children()->count() }})
                        </h3>
                        <a href="{{ route('admin.shop.categories.create', ['parent_id' => $category->id]) }}" 
                           class="text-primary hover:text-secondary text-sm font-medium">
                            Add Subcategory →
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($category->children as $child)
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 hover:border-primary transition-colors duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        @if($child->image)
                                            <img src="{{ $child->getImageUrl() }}" 
                                                 alt="{{ $child->name }}" 
                                                 class="w-10 h-10 object-cover rounded-lg">
                                        @else
                                            <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-lg flex items-center justify-center">
                                                @if($child->icon)
                                                    <i class="{{ $child->icon }} text-white text-sm"></i>
                                                @else
                                                    <i class="fas fa-folder text-white text-sm"></i>
                                                @endif
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $child->name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $child->getProductsCount() }} products</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.shop.categories.show', $child) }}" 
                                       class="text-primary hover:text-secondary">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Recent Products -->
            @if($category->products()->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-cube text-primary mr-3"></i>
                            Recent Products
                        </h3>
                        <a href="{{ route('admin.shop.products.index', ['category' => $category->id]) }}" 
                           class="text-primary hover:text-secondary text-sm font-medium">
                            View All Products →
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($category->products()->latest()->limit(5)->get() as $product)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $product->getFeaturedImageUrl() }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $product->name }}</h4>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            <span>{{ $product->getFormattedPrice() }}</span>
                                            @php $stockBadge = $product->getStockBadge() @endphp
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $stockBadge['class'] }}">
                                                {{ $stockBadge['text'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.shop.products.show', $product) }}" 
                                   class="text-primary hover:text-secondary">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @endforeach
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
                            <i class="fas fa-cube text-blue-600"></i>
                            <span class="text-blue-900 font-medium">Total Products</span>
                        </div>
                        <span class="text-xl font-bold text-blue-900">{{ $stats['total_products'] ?? 0 }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span class="text-green-900 font-medium">Active Products</span>
                        </div>
                        <span class="text-xl font-bold text-green-900">{{ $stats['active_products'] ?? 0 }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-xl">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-star text-purple-600"></i>
                            <span class="text-purple-900 font-medium">Featured Products</span>
                        </div>
                        <span class="text-xl font-bold text-purple-900">{{ $stats['featured_products'] ?? 0 }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-orange-50 rounded-xl">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-dollar-sign text-orange-600"></i>
                            <span class="text-orange-900 font-medium">Total Revenue</span>
                        </div>
                        <span class="text-xl font-bold text-orange-900">${{ number_format($stats['total_revenue'] ?? 0, 0) }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-bolt text-primary mr-3"></i>
                    Quick Actions
                </h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.shop.products.create', ['category_id' => $category->id]) }}" 
                       class="w-full flex items-center justify-center p-3 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Add Product
                    </a>
                    
                    <a href="{{ route('admin.shop.categories.create', ['parent_id' => $category->id]) }}" 
                       class="w-full flex items-center justify-center p-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200">
                        <i class="fas fa-folder-plus mr-2"></i>
                        Add Subcategory
                    </a>
                    
                    <a href="{{ route('admin.shop.products.index', ['category' => $category->id]) }}" 
                       class="w-full flex items-center justify-center p-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors duration-200">
                        <i class="fas fa-list mr-2"></i>
                        View All Products
                    </a>
                    
                    <a href="{{ route('admin.shop.categories.edit', $category) }}" 
                       class="w-full flex items-center justify-center p-3 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Category
                    </a>
                    
                    <button onclick="deleteCategory({{ $category->id }})" 
                            class="w-full flex items-center justify-center p-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-200">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Category
                    </button>
                </div>
            </div>

            <!-- Category Tree -->
            @if($category->parent || $category->children()->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-sitemap text-primary mr-3"></i>
                        Category Tree
                    </h3>
                    
                    <div class="space-y-2">
                        @if($category->parent)
                            <div class="flex items-center text-sm text-gray-600 pl-2">
                                <i class="fas fa-level-up-alt mr-2"></i>
                                Parent: 
                                <a href="{{ route('admin.shop.categories.show', $category->parent) }}" 
                                   class="text-primary hover:text-secondary ml-1">
                                    {{ $category->parent->name }}
                                </a>
                            </div>
                        @endif
                        
                        <div class="flex items-center text-sm font-semibold text-gray-900 pl-4 py-2 bg-primary/10 rounded-lg">
                            <i class="fas fa-folder mr-2 text-primary"></i>
                            {{ $category->name }} (Current)
                        </div>
                        
                        @foreach($category->children as $child)
                            <div class="flex items-center justify-between text-sm text-gray-600 pl-8 py-1">
                                <div class="flex items-center">
                                    <i class="fas fa-folder-open mr-2"></i>
                                    {{ $child->name }}
                                    <span class="text-xs text-gray-400 ml-2">({{ $child->getProductsCount() }})</span>
                                </div>
                                <a href="{{ route('admin.shop.categories.show', $child) }}" 
                                   class="text-primary hover:text-secondary">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
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
                            <p class="text-sm font-medium text-gray-900">Category Created</p>
                            <p class="text-xs text-gray-500">
                                {{ $category->created_at ? $category->created_at->diffForHumans() : 'Unknown' }}
                            </p>
                        </div>
                    </div>
                    
                    @if($category->updated_at && $category->updated_at != $category->created_at)
                        <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-edit text-white text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                <p class="text-xs text-gray-500">{{ $category->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($category->products()->exists())
                        @php $latestProduct = $category->products()->latest()->first() @endphp
                        @if($latestProduct)
                            <div class="flex items-center space-x-3 p-3 bg-purple-50 rounded-lg">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-cube text-white text-xs"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Latest Product Added</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $latestProduct->name }} - {{ $latestProduct->created_at ? $latestProduct->created_at->diffForHumans() : 'Unknown' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleStatus(categoryId, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this category?`)) {
        fetch(`/admin/shop/categories/${categoryId}/status`, {
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
                alert('Failed to update category status');
            }
        });
    }
}

function deleteCategory(categoryId) {
    if (confirm('Are you sure you want to delete this category? This action cannot be undone and will affect all products in this category.')) {
        fetch(`/admin/shop/categories/${categoryId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route('admin.shop.categories.index') }}';
            } else {
                alert(data.message || 'Failed to delete category');
            }
        });
    }
}
</script>
@endsection