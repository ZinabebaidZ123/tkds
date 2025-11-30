{{-- File: resources/views/admin/shop/categories/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

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
                <h2 class="text-2xl font-bold text-gray-900">Edit Category</h2>
                <p class="text-gray-600 text-sm mt-1">Update category: {{ $category->name }}</p>
            </div>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.shop.categories.show', $category) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-eye mr-2"></i>
                View Category
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-gradient-to-r from-red-50 to-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-red-800 font-medium">Please fix the following errors:</h3>
                    <ul class="text-red-700 text-sm mt-1 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Category Form -->
    <form action="{{ route('admin.shop.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-folder text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Basic Information</h3>
                    <p class="text-gray-600 text-sm">Essential category details</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Category Name *
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" 
                           required
                           placeholder="Enter category name..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Category Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" 
                           placeholder="auto-generated-from-name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('slug') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Leave empty to auto-generate from name</p>
                    @error('slug')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Parent Category</label>
                    <select name="parent_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('parent_id') border-red-500 @enderror">
                        <option value="">No Parent (Main Category)</option>
                        @foreach($parentCategories as $parentCategory)
                            <option value="{{ $parentCategory->id }}" {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                                {{ $parentCategory->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" 
                           min="0"
                           placeholder="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('sort_order') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                    @error('sort_order')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4"
                              placeholder="Category description..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Visual Settings -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-image text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Visual Settings</h3>
                    <p class="text-gray-600 text-sm">Images and visual elements</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Category Image</label>
                    
                    @if($category->image)
                        <div class="mb-4">
                            <img src="{{ $category->getImageUrl() }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-32 h-24 object-cover rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-500 mt-1">Current image</p>
                        </div>
                    @endif
                    
                    <input type="file" name="image" 
                           accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('image') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Recommended: 400x300px. Leave empty to keep current image.</p>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon Class</label>
                    <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" 
                           placeholder="fas fa-cube"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('icon') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">FontAwesome icon class (optional)</p>
                    @if($category->icon)
                        <div class="mt-2 flex items-center text-sm text-gray-600">
                            <i class="{{ $category->icon }} mr-2"></i>
                            Current icon preview
                        </div>
                    @endif
                    @error('icon')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Category Settings -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-cog text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Category Settings</h3>
                    <p class="text-gray-600 text-sm">Visibility and status options</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900">Featured Category</h4>
                            <p class="text-xs text-gray-500">Show in featured sections</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" 
                                   class="sr-only peer" 
                                   {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
<div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Category Status *
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('status') border-red-500 @enderror">
                        <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>✅ Active</option>
                        <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>⏸️ Inactive</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SEO Settings -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-search text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">SEO Settings</h3>
                    <p class="text-gray-600 text-sm">Search engine optimization</p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}" 
                           maxlength="60"
                           placeholder="SEO title for search engines..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('meta_title') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Recommended: 50-60 characters</p>
                    @error('meta_title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Meta Description</label>
                    <textarea name="meta_description" rows="3" maxlength="160"
                              placeholder="SEO description for search engines..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('meta_description') border-red-500 @enderror">{{ old('meta_description', $category->meta_description) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Recommended: 150-160 characters</p>
                    @error('meta_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Category Statistics -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-chart-bar text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Category Statistics</h3>
                    <p class="text-gray-600 text-sm">Performance overview</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <i class="fas fa-cube text-2xl text-blue-600 mb-2"></i>
                    <p class="text-2xl font-bold text-blue-900">{{ $category->getProductsCount() }}</p>
                    <p class="text-sm text-blue-700">Total Products</p>
                </div>
                
                <div class="text-center p-4 bg-green-50 rounded-xl border border-green-200">
                    <i class="fas fa-check-circle text-2xl text-green-600 mb-2"></i>
                    <p class="text-2xl font-bold text-green-900">{{ $category->activeProducts()->count() }}</p>
                    <p class="text-sm text-green-700">Active Products</p>
                </div>
                
                <div class="text-center p-4 bg-purple-50 rounded-xl border border-purple-200">
                    <i class="fas fa-star text-2xl text-purple-600 mb-2"></i>
                    <p class="text-2xl font-bold text-purple-900">{{ $category->products()->where('is_featured', true)->count() }}</p>
                    <p class="text-sm text-purple-700">Featured Products</p>
                </div>
                
                <div class="text-center p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                    <i class="fas fa-folder text-2xl text-yellow-600 mb-2"></i>
                    <p class="text-2xl font-bold text-yellow-900">{{ $category->children()->count() }}</p>
                    <p class="text-sm text-yellow-700">Subcategories</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 bg-gray-50 rounded-2xl border border-gray-200">
            <div class="text-sm text-gray-600">
                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                Last updated: {{ $category->updated_at->format('M j, Y \a\t g:i A') }}
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('admin.shop.categories.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition-all duration-200 font-medium">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Update Category
                </button>
            </div>
        </div>
    </form>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 border border-blue-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-bolt text-primary mr-3"></i>
            Quick Actions
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.shop.products.index', ['category' => $category->id]) }}" 
               class="flex items-center justify-center p-4 bg-white rounded-xl border border-gray-200 hover:border-primary hover:shadow-lg transition-all duration-200 group">
                <div class="text-center">
                    <i class="fas fa-cube text-2xl text-primary mb-2 group-hover:scale-110 transition-transform duration-200"></i>
                    <p class="font-medium text-gray-900">View Products</p>
                </div>
            </a>
            
            <a href="{{ route('admin.shop.products.create', ['category_id' => $category->id]) }}" 
               class="flex items-center justify-center p-4 bg-white rounded-xl border border-gray-200 hover:border-primary hover:shadow-lg transition-all duration-200 group">
                <div class="text-center">
                    <i class="fas fa-plus text-2xl text-primary mb-2 group-hover:scale-110 transition-transform duration-200"></i>
                    <p class="font-medium text-gray-900">Add Product</p>
                </div>
            </a>
            
            @if($category->children()->count() > 0)
                <a href="{{ route('admin.shop.categories.index', ['parent' => $category->id]) }}" 
                   class="flex items-center justify-center p-4 bg-white rounded-xl border border-gray-200 hover:border-primary hover:shadow-lg transition-all duration-200 group">
                    <div class="text-center">
                        <i class="fas fa-folder-open text-2xl text-primary mb-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <p class="font-medium text-gray-900">View Subcategories</p>
                    </div>
                </a>
            @else
                <button onclick="createSubcategory()" 
                        class="flex items-center justify-center p-4 bg-white rounded-xl border border-gray-200 hover:border-primary hover:shadow-lg transition-all duration-200 group">
                    <div class="text-center">
                        <i class="fas fa-folder-plus text-2xl text-primary mb-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <p class="font-medium text-gray-900">Add Subcategory</p>
                    </div>
                </button>
            @endif
            
            <button onclick="deleteCategory({{ $category->id }})" 
                    class="flex items-center justify-center p-4 bg-white rounded-xl border border-red-200 hover:border-red-400 hover:shadow-lg transition-all duration-200 group">
                <div class="text-center">
                    <i class="fas fa-trash text-2xl text-red-500 mb-2 group-hover:scale-110 transition-transform duration-200"></i>
                    <p class="font-medium text-red-700">Delete Category</p>
                </div>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.querySelector('input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    nameInput.addEventListener('input', function() {
        const slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        slugInput.value = slug;
    });

    // Form validation enhancement
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
        submitBtn.disabled = true;
    });
});

function createSubcategory() {
    const categoryId = {{ $category->id }};
    window.location.href = `{{ route('admin.shop.categories.create') }}?parent_id=${categoryId}`;
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