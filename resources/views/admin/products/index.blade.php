@extends('admin.layouts.app')

@section('title', 'Products Management')
@section('page-title', 'Products Management')

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manage Products</h2>
            <p class="text-gray-600 text-sm mt-1">Control all your products content and settings</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
            class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>
            <span>Add New Product</span>
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Products</p>
                    <p class="text-2xl font-bold">{{ $products->total() }}</p>
                </div>
                <i class="fas fa-cube text-3xl text-blue-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active</p>
                    <p class="text-2xl font-bold">{{ $products->where('status', 'active')->count() }}</p>
                </div>
                <i class="fas fa-check-circle text-3xl text-green-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Featured</p>
                    <p class="text-2xl font-bold">{{ $products->where('is_featured', true)->count() }}</p>
                </div>
                <i class="fas fa-star text-3xl text-yellow-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">In Navbar</p>
                    <p class="text-2xl font-bold">{{ $products->where('show_in_navbar', true)->count() }}</p>
                </div>
                <i class="fas fa-bars text-3xl text-purple-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Coming Soon</p>
                    <p class="text-2xl font-bold">{{ $products->where('status', 'coming_soon')->count() }}</p>
                </div>
                <i class="fas fa-clock text-3xl text-red-200"></i>
            </div>
        </div>
    </div>

    <!-- Section Title & Subtitle Form -->
@php
    $firstProduct = $products->first();
    $defaultTitlePart1 = $firstProduct->title_part1 ?? 'Your Streaming Empire';
    $defaultTitlePart2 = $firstProduct->title_part2 ?? 'Starts Here';
    $defaultSubtitle = $firstProduct->subtitle_section ?? 'Premium SaaS solutions for high-quality streaming, global reliability, and a seamless user experience.';
@endphp

<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-purple-50 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-heading mr-2 text-primary"></i>
            Section Title & Subtitle
        </h3>
        <p class="text-gray-600 text-sm mt-1">Edit the main title and subtitle for the products section on homepage</p>
    </div>
    
    <form id="sectionTitleForm" class="p-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Left Column - Title Parts -->
            <div class="space-y-6">
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-4 rounded-xl border border-blue-100">
                    <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-heading mr-2 text-primary"></i>
                        Section Title
                    </h4>
                    <p class="text-sm text-gray-600 mb-4">
                        Create a dynamic title like "Your Streaming Empire <span class="text-primary font-semibold">Starts Here</span>"
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="title_part1" class="block text-sm font-medium text-gray-700 mb-2">
                                First Part
                            </label>
                            <input type="text" 
                                   id="title_part1"
                                   name="title_part1"
                                   value="{{ $defaultTitlePart1 }}"
                                   placeholder="e.g., Your Streaming Empire"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200">
                        </div>
                        
                        <div>
                            <label for="title_part2" class="block text-sm font-medium text-gray-700 mb-2">
                                Second Part (Highlighted)
                            </label>
                            <input type="text" 
                                   id="title_part2"
                                   name="title_part2"
                                   value="{{ $defaultTitlePart2 }}"
                                   placeholder="e.g., Starts Here"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200">
                        </div>
                    </div>
                    
                    <!-- Preview -->
                    <div class="mt-4 p-3 bg-white rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 mb-2">Preview:</p>
                        <div id="titlePreview" class="text-xl font-bold text-gray-900">
                            <span id="part1Preview">{{ $defaultTitlePart1 }}</span>
                            <span id="part2Preview" class="bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">{{ $defaultTitlePart2 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Subtitle -->
            <div class="space-y-6">
                <div>
                    <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                        Section Subtitle
                        <span class="text-gray-500 font-normal">- Appears below the main title</span>
                    </label>
                    <textarea id="subtitle" 
                              name="subtitle"
                              rows="4"
                              placeholder="e.g., Premium SaaS solutions for high-quality streaming..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200">{{ $defaultSubtitle }}</textarea>
                </div>

                <!-- Save Button -->
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

    <!-- Products Content -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-list mr-2 text-primary"></i>
                    All Products ({{ $products->total() }})
                </h3>
            </div>
        </div>

        @if ($products->count() > 0)
            <!-- Desktop Grid -->
            <div class="hidden lg:block p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <div class="group bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200 hover:border-{{ $product->border_color }}/50 hover:shadow-lg transition-all duration-300">
                            
                            <!-- Product Icon & Status -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-16 h-16 bg-gradient-to-r {{ $product->getGradientClass() }} rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="{{ $product->icon }} text-white text-2xl"></i>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if ($product->is_featured)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-star mr-1"></i>
                                            Featured
                                        </span>
                                    @endif
                                    @if ($product->show_in_navbar)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-bars mr-1"></i>
                                            Navbar
                                        </span>
                                    @endif
                                    {{-- <label class="relative inline-flex items-center cursor-pointer">
                                        <select class="status-select bg-transparent border-0 text-xs font-medium rounded-full px-2 py-1 cursor-pointer 
                                                {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 
                                                   ($product->status === 'coming_soon' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}"
                                                data-id="{{ $product->id }}">
                                            <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="coming_soon" {{ $product->status === 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                                        </select>
                                    </label> --}}
                                </div>
                            </div>

                            <!-- Product Content -->
                            <div class="space-y-3">
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-{{ $product->color_from }} transition-colors duration-300">
                                        {{ $product->title }}
                                    </h4>
                                    @if($product->subtitle)
                                        <p class="text-sm text-{{ $product->color_from }} font-medium">{{ $product->subtitle }}</p>
                                    @endif
                                </div>
                                
                                <p class="text-gray-600 text-sm line-clamp-3">{{ $product->short_description ?: substr($product->description, 0, 100) . '...' }}</p>

                                <!-- Category & Price -->
                                <div class="flex items-center justify-between text-xs">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-gray-200 text-gray-700">
                                        {{ $product->getCategoryLabel() }}
                                    </span>
                                    <span class="font-semibold text-gray-700">{{ $product->getFormattedPrice() }}</span>
                                </div>

                                <!-- Features Preview -->
                                @if ($product->getFeatures())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach (array_slice($product->getFeatures(), 0, 2) as $feature)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-200 text-gray-700">
                                                {{ $feature }}
                                            </span>
                                        @endforeach
                                        @if (count($product->getFeatures()) > 2)
                                            <span class="text-xs text-gray-500">+{{ count($product->getFeatures()) - 2 }} more</span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Sort Order & Created -->
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span>Order: {{ $product->sort_order }}</span>
                                    <span>{{ $product->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ $product->getUrl() }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                        title="View Product">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.products.show', $product) }}"
                                        class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                        title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.page-content', $product) }}"
                                        class="text-purple-600 hover:text-purple-800 p-2 rounded-lg hover:bg-purple-50 transition-colors duration-200"
                                        title="Manage Page Content">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                </div>
                                <div class="flex items-center space-x-2">
                                    {{-- <button onclick="duplicateProduct({{ $product->id }})"
                                        class="text-orange-600 hover:text-orange-800 p-2 rounded-lg hover:bg-orange-50 transition-colors duration-200"
                                        title="Duplicate">
                                        <i class="fas fa-copy"></i>
                                    </button> --}}
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteProduct({{ $product->id }})"
                                        class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                        title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Mobile List -->
            <div class="lg:hidden divide-y divide-gray-100">
                @foreach ($products as $product)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r {{ $product->getGradientClass() }} rounded-lg flex items-center justify-center">
                                    <i class="{{ $product->icon }} text-white"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $product->title }}</h4>
                                        @if($product->subtitle)
                                            <p class="text-xs text-{{ $product->color_from }} font-medium">{{ $product->subtitle }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $product->short_description ?: substr($product->description, 0, 80) . '...' }}</p>
                                        <div class="flex items-center mt-2 space-x-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Order: {{ $product->sort_order }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 
                                                   ($product->status === 'coming_soon' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                                            </span>
                                            @if ($product->is_featured)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-star mr-1"></i>
                                                    Featured
                                                </span>
                                            @endif
                                            @if ($product->show_in_navbar)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-bars mr-1"></i>
                                                    Navbar
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-xs text-gray-400">
                                        {{ $product->created_at->diffForHumans() }}
                                    </span>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="text-blue-600 hover:text-blue-800 p-1" title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button onclick="deleteProduct({{ $product->id }})"
                                            class="text-red-600 hover:text-red-800 p-1" title="Delete">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-cube text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by creating your first product to showcase your offerings.</p>
                <a href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>
                    Create Your First Product
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl transform transition-all duration-300 scale-95">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Confirm Delete</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this product? This action cannot be undone and will remove it from your website.</p>
            <div class="flex space-x-3">
                <button id="confirmDelete"
                    class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-3 rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 font-medium shadow-lg">
                    <i class="fas fa-trash mr-2"></i>
                    Delete
                </button>
                <button onclick="closeDeleteModal()"
                    class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl hover:bg-gray-200 transition-all duration-300 font-medium">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let deleteId = null;

// Title Preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const titlePart1 = document.getElementById('title_part1');
    const titlePart2 = document.getElementById('title_part2');
    const part1Preview = document.getElementById('part1Preview');
    const part2Preview = document.getElementById('part2Preview');
    
    if (titlePart1 && titlePart2 && part1Preview && part2Preview) {
        function updateTitlePreview() {
            const part1 = titlePart1.value || 'Your Streaming Empire';
            const part2 = titlePart2.value || 'Starts Here';
            
            part1Preview.textContent = part1;
            part2Preview.textContent = part2;
        }
        
        titlePart1.addEventListener('input', updateTitlePreview);
        titlePart2.addEventListener('input', updateTitlePreview);
    }
});

// Section Title Form Submit
const sectionTitleForm = document.getElementById('sectionTitleForm');
if (sectionTitleForm) {
    sectionTitleForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
        
        const formData = {
            title_part1: document.getElementById('title_part1').value,
            title_part2: document.getElementById('title_part2').value,
            subtitle: document.getElementById('subtitle').value
        };
        
        fetch('{{ route("admin.products.update-section-title") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Section title updated successfully!', 'success');
            } else {
                throw new Error(data.message || 'Failed to update section title');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to update section title', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
}

// Status change functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const id = this.dataset.id;
            const status = this.value;
            
            const originalValue = this.querySelector('option[selected]')?.value || 
                               Array.from(this.options).find(opt => opt.defaultSelected)?.value || 
                               this.value;
            
            this.disabled = true;

            fetch('/admin/products/' + id + '/status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showNotification('Status updated successfully!', 'success');
                    updateSelectStyling(this, status);
                } else {
                    throw new Error(data.message || 'Failed to update status');
                }
            })
            .catch(error => {
                console.error('Error updating status:', error);
                this.value = originalValue;
                showNotification('Failed to update status: ' + error.message, 'error');
            })
            .finally(() => {
                this.disabled = false;
            });
        });
    });
    
    document.querySelectorAll('.status-select').forEach(select => {
        updateSelectStyling(select, select.value);
    });
});

function updateSelectStyling(select, status) {
    select.classList.remove('bg-green-100', 'text-green-800', 'bg-yellow-100', 'text-yellow-800', 'bg-red-100', 'text-red-800');
    
    switch(status) {
        case 'active':
            select.classList.add('bg-green-100', 'text-green-800');
            break;
        case 'coming_soon':
            select.classList.add('bg-yellow-100', 'text-yellow-800');
            break;
        case 'inactive':
            select.classList.add('bg-red-100', 'text-red-800');
            break;
    }
}

function deleteProduct(id) {
    deleteId = id;
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        modal.querySelector('.bg-white').classList.remove('scale-95');
        modal.querySelector('.bg-white').classList.add('scale-100');
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.querySelector('.bg-white').classList.remove('scale-100');
    modal.querySelector('.bg-white').classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        deleteId = null;
    }, 300);
}

// ✅ حذف المنتج باستخدام الـ route الجديد المنفصل
document.getElementById('confirmDelete').addEventListener('click', function() {
    if (deleteId) {
        console.log('Deleting product ID:', deleteId);
        
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Deleting...';

        // استخدام الـ route الجديد: /admin/products/{id}/delete
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = window.location.origin + '/admin/products/' + deleteId + '/delete';
        form.style.display = 'none';
        
        // CSRF Token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Method Spoofing for DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        
        // إضافة الفورم للصفحة وإرساله
        document.body.appendChild(form);
        
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);
        console.log('CSRF Token:', csrfInput.value);
        
        form.submit();
    }
});

function duplicateProduct(id) {
    if (confirm('Are you sure you want to duplicate this product?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = window.location.origin + '/admin/products/' + id + '/duplicate';
        form.style.display = 'none';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';

    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-2"></i>
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

// Event Listeners for modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endpush