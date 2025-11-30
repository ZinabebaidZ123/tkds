{{-- File: resources/views/admin/shop/products/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Add New Product')
@section('page-title', 'Add New Product')

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
                <h2 class="text-2xl font-bold text-gray-900">Add New Product</h2>
                <p class="text-gray-600 text-sm mt-1">Create a new product for your shop</p>
            </div>
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

    <!-- Product Form -->
    <form action="{{ route('admin.shop.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-info-circle text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Basic Information</h3>
                    <p class="text-gray-600 text-sm">Essential product details</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Product Name *
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           required
                           placeholder="Enter product name..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Slug</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" 
                           placeholder="auto-generated-from-name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('slug') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Leave empty to auto-generate from name</p>
                    @error('slug')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" 
                           placeholder="PROD-001"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('sku') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Stock Keeping Unit (optional)</p>
                    @error('sku')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Product Type *
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="type" required id="productType"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('type') border-red-500 @enderror">
                        <option value="">Select Type</option>
                        <option value="physical" {{ old('type') == 'physical' ? 'selected' : '' }}>📦 Physical Product</option>
                        <option value="software" {{ old('type') == 'software' ? 'selected' : '' }}>💾 Software/Digital</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                    <select name="category_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('category_id') border-red-500 @enderror">
                        <option value="">No Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Short Description</label>
                    <textarea name="short_description" rows="3"
                              placeholder="Brief product description..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('short_description') border-red-500 @enderror">{{ old('short_description') }}</textarea>
                    @error('short_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Full Description *
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" rows="6" required
                              placeholder="Detailed product description..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pricing -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Pricing</h3>
                    <p class="text-gray-600 text-sm">Set product pricing and currency</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Regular Price *
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="price" value="{{ old('price') }}" 
                           step="0.01" min="0" required
                           placeholder="0.00"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('price') border-red-500 @enderror">
                           @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sale Price</label>
                    <input type="number" name="sale_price" value="{{ old('sale_price') }}" 
                           step="0.01" min="0"
                           placeholder="0.00"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('sale_price') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Leave empty for no discount</p>
                    @error('sale_price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Currency *
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="currency" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('currency') border-red-500 @enderror">
                        <option value="USD" {{ old('currency', 'USD') == 'USD' ? 'selected' : '' }}>🇺🇸 USD</option>
                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>🇪🇺 EUR</option>
                        <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>🇬🇧 GBP</option>
                        <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }}>🇨🇦 CAD</option>
                    </select>
                    @error('currency')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Inventory (Physical Products Only) -->
        <div id="inventorySection" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8" style="display: none;">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-boxes text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Inventory Management</h3>
                    <p class="text-gray-600 text-sm">Stock and inventory settings</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <input type="checkbox" id="manageStock" name="manage_stock" value="1" 
                               {{ old('manage_stock') ? 'checked' : '' }}
                               class="w-5 h-5 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2">
                        <label for="manageStock" class="text-sm font-semibold text-gray-900">
                            Enable stock management for this product
                        </label>
                    </div>
                </div>

                <div id="stockQuantityField">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" 
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('stock_quantity') border-red-500 @enderror">
                    @error('stock_quantity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Weight (kg)</label>
                    <input type="number" name="weight" value="{{ old('weight') }}" 
                           step="0.01" min="0"
                           placeholder="0.00"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('weight') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">For shipping calculations</p>
                    @error('weight')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Digital Product Settings -->
        <div id="digitalSection" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8" style="display: none;">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-download text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Digital Product Settings</h3>
                    <p class="text-gray-600 text-sm">Download and access configurations</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Download Limit</label>
                    <input type="number" name="download_limit" value="{{ old('download_limit', -1) }}" 
                           min="-1"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('download_limit') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">-1 for unlimited downloads</p>
                    @error('download_limit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Download Expiry (Days)</label>
                    <input type="number" name="download_expiry_days" value="{{ old('download_expiry_days', 0) }}" 
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('download_expiry_days') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">0 for never expires</p>
                    @error('download_expiry_days')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Downloadable Files</label>
                    <input type="file" name="downloadable_files[]" multiple 
                           accept=".zip,.pdf,.exe,.dmg,.pkg,.deb,.apk,.ipa"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('downloadable_files') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Upload files customers can download after purchase</p>
                    @error('downloadable_files')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Media -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-images text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Product Media</h3>
                    <p class="text-gray-600 text-sm">Images and visual content</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Featured Image</label>
                    <input type="file" name="featured_image" 
                           accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('featured_image') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Main product image (recommended: 800x600px)</p>
                    @error('featured_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Gallery Images</label>
                    <input type="file" name="gallery[]" multiple 
                           accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('gallery') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Additional product images</p>
                    @error('gallery')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Product Settings -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-cog text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Product Settings</h3>
                    <p class="text-gray-600 text-sm">Visibility and status options</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900">Featured Product</h4>
                            <p class="text-xs text-gray-500">Show in featured sections</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" 
                                   class="sr-only peer" 
                                   {{ old('is_featured') ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900">Popular Product</h4>
                            <p class="text-xs text-gray-500">Mark as popular/trending</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_popular" value="1" 
                                   class="sr-only peer" 
                                   {{ old('is_popular') ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Product Status *
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('status') border-red-500 @enderror">
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>✅ Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>⏸️ Inactive</option>
                        <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>❌ Out of Stock</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SEO -->
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
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" 
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
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('meta_description') border-red-500 @enderror">{{ old('meta_description') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Recommended: 150-160 characters</p>
                    @error('meta_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 bg-gray-50 rounded-2xl border border-gray-200">
            <div class="text-sm text-gray-600">
                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                Product will be created with the selected status.
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('admin.shop.products.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition-all duration-200 font-medium">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Create Product
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productTypeSelect = document.getElementById('productType');
    const inventorySection = document.getElementById('inventorySection');
    const digitalSection = document.getElementById('digitalSection');
    const manageStockCheckbox = document.getElementById('manageStock');
    const stockQuantityField = document.getElementById('stockQuantityField');

    // Show/hide sections based on product type
    function toggleSections() {
        const type = productTypeSelect.value;
        
        if (type === 'physical') {
            inventorySection.style.display = 'block';
            digitalSection.style.display = 'none';
        } else if (type === 'software') {
            inventorySection.style.display = 'none';
            digitalSection.style.display = 'block';
        } else {
            inventorySection.style.display = 'none';
            digitalSection.style.display = 'none';
        }
    }

    // Toggle stock quantity field
    function toggleStockField() {
        if (manageStockCheckbox.checked) {
            stockQuantityField.style.display = 'block';
        } else {
            stockQuantityField.style.display = 'none';
        }
    }

    // Auto-generate slug from name
    const nameInput = document.querySelector('input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    nameInput.addEventListener('input', function() {
        if (!slugInput.value) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        }
    });

    // Event listeners
    productTypeSelect.addEventListener('change', toggleSections);
    manageStockCheckbox.addEventListener('change', toggleStockField);

    // Initialize
    toggleSections();
    toggleStockField();

    // Form validation enhancement
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection