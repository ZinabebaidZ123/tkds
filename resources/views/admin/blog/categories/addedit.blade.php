@extends('admin.layouts.app')

@section('title', isset($category) ? 'Edit Category' : 'Add New Category')
@section('page-title', isset($category) ? 'Edit Category' : 'Add New Category')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.blog.categories.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.blog.categories.index') }}" class="hover:text-primary transition-colors duration-200">Blog Categories</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($category) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($category) ? 'Edit' : 'Add New' }} Category
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ isset($category) ? 'Update the' : 'Create a new' }} blog category to organize content</p>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-edit mr-2 text-primary"></i>
                        Category Details
                    </h3>
                </div>
                
                <form action="{{ isset($category) ? route('admin.blog.categories.update', $category) : route('admin.blog.categories.store') }}" 
                      method="POST" class="p-6 space-y-6" id="categoryForm">
                    @csrf
                    @if(isset($category))
                        @method('PUT')
                    @endif
                    
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-tag mr-2 text-primary"></i>
                            Category Name *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $category->name ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('name') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="Enter category name"
                               required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">This will be displayed to users</p>
                    </div>

                    <!-- Slug -->
                    <div class="space-y-2">
                        <label for="slug" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-link mr-2 text-primary"></i>
                            URL Slug
                        </label>
                        <input type="text" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug', $category->slug ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('slug') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="auto-generated-from-name">
                        @error('slug')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Leave empty to auto-generate from name</p>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-align-left mr-2 text-primary"></i>
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('description') border-red-500 ring-2 ring-red-200 @enderror"
                                  placeholder="Brief description of this category">{{ old('description', $category->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Optional - will be shown on category pages</p>
                    </div>

                    <!-- Icon & Color -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="icon" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-icons mr-2 text-primary"></i>
                                Icon *
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       id="icon" 
                                       name="icon" 
                                       value="{{ old('icon', $category->icon ?? 'fas fa-folder') }}"
                                       class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('icon') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="fas fa-folder"
                                       required>
<div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                    <i id="iconPreview" class="{{ old('icon', $category->icon ?? 'fas fa-folder') }} text-gray-600"></i>
                                </div>
                            </div>
                            @error('icon')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">FontAwesome class (e.g., fas fa-folder)</p>
                        </div>

                        <div class="space-y-2">
                            <label for="color" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-palette mr-2 text-primary"></i>
                                Color *
                            </label>
                            <div class="flex space-x-3">
                                <input type="color" 
                                       id="color" 
                                       name="color" 
                                       value="{{ old('color', $category->color ?? '#C53030') }}"
                                       class="w-16 h-12 border border-gray-300 rounded-xl cursor-pointer @error('color') border-red-500 @enderror"
                                       required>
                                <input type="text" 
                                       id="colorHex" 
                                       value="{{ old('color', $category->color ?? '#C53030') }}"
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="#C53030"
                                       readonly>
                            </div>
                            @error('color')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Used for category badges and styling</p>
                        </div>
                    </div>

                    <!-- Sort Order & Status -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="sort_order" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-sort mr-2 text-primary"></i>
                                Sort Order *
                            </label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $category->sort_order ?? 1) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('sort_order') border-red-500 ring-2 ring-red-200 @enderror"
                                   required>
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Lower numbers appear first</p>
                        </div>

                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-toggle-on mr-2 text-primary"></i>
                                Status *
                            </label>
                            <select id="status" 
                                    name="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('status') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="active" {{ old('status', $category->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                    ✅ Active (Visible to users)
                                </option>
                                <option value="inactive" {{ old('status', $category->status ?? '') === 'inactive' ? 'selected' : '' }}>
                                    ❌ Inactive (Hidden from users)
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-search mr-2 text-primary"></i>
                            SEO Settings
                        </h4>
                        
                        <div class="space-y-6">
                            <!-- Meta Title -->
                            <div class="space-y-2">
                                <label for="meta_title" class="block text-sm font-semibold text-gray-700">
                                    Meta Title
                                </label>
                                <input type="text" 
                                       id="meta_title" 
                                       name="meta_title" 
                                       value="{{ old('meta_title', $category->meta_title ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="Leave empty to use category name">
                                <p class="text-xs text-gray-500">Recommended: 50-60 characters</p>
                            </div>

                            <!-- Meta Description -->
                            <div class="space-y-2">
                                <label for="meta_description" class="block text-sm font-semibold text-gray-700">
                                    Meta Description
                                </label>
                                <textarea id="meta_description" 
                                          name="meta_description" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                          placeholder="Brief description for search engines">{{ old('meta_description', $category->meta_description ?? '') }}</textarea>
                                <p class="text-xs text-gray-500">Recommended: 150-160 characters</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.blog.categories.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                                id="submitBtn">
                            <i class="fas fa-save mr-2"></i>
                            <span>{{ isset($category) ? 'Update' : 'Create' }} Category</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Sidebar with Preview & Tips -->
        <div class="space-y-6">
            
            <!-- Live Preview Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-eye mr-2 text-blue-600"></i>
                        Live Preview
                    </h3>
                </div>
                <div class="p-6">
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                        <div class="flex items-center space-x-4 mb-4">
                            <div id="previewIcon" class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm"
                                 style="background: linear-gradient(135deg, {{ old('color', $category->color ?? '#C53030') }}20, {{ old('color', $category->color ?? '#C53030') }}40);">
                                <i id="previewIconClass" class="{{ old('icon', $category->icon ?? 'fas fa-folder') }} text-xl" 
                                   style="color: {{ old('color', $category->color ?? '#C53030') }};"></i>
                            </div>
                            <div>
                                <h4 id="previewName" class="text-lg font-bold text-gray-900">
                                    {{ $category->name ?? 'Category Name' }}
                                </h4>
                                <p id="previewSlug" class="text-sm text-gray-500 font-mono">
                                    {{ $category->slug ?? 'category-slug' }}
                                </p>
                            </div>
                        </div>
                        <p id="previewDescription" class="text-gray-600 text-sm">
                            {{ $category->description ?? 'Category description will appear here' }}
                        </p>
                        <div class="mt-4 flex items-center justify-between">
                            <span id="previewBadge" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                                  style="background-color: {{ old('color', $category->color ?? '#C53030') }}20; color: {{ old('color', $category->color ?? '#C53030') }};">
                                <i id="previewBadgeIcon" class="{{ old('icon', $category->icon ?? 'fas fa-folder') }} mr-2"></i>
                                <span id="previewBadgeName">{{ $category->name ?? 'Category Name' }}</span>
                            </span>
                            <span id="previewOrder" class="text-xs text-gray-500">
                                Order: {{ $category->sort_order ?? '1' }}
                            </span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3 text-center">This is how your category will appear to users</p>
                </div>
            </div>
            
            <!-- Icon Picker -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-icons mr-2 text-purple-600"></i>
                        Popular Icons
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-6 gap-3">
                        @php
                            $popularIcons = [
                                'fas fa-folder', 'fas fa-tag', 'fas fa-star', 'fas fa-heart',
                                'fas fa-bookmark', 'fas fa-flag', 'fas fa-bell', 'fas fa-gift',
                                'fas fa-lightbulb', 'fas fa-fire', 'fas fa-bolt', 'fas fa-gem',
                                'fas fa-crown', 'fas fa-medal', 'fas fa-trophy', 'fas fa-rocket',
                                'fas fa-globe', 'fas fa-camera', 'fas fa-music', 'fas fa-gamepad',
                                'fas fa-laptop', 'fas fa-mobile', 'fas fa-tv', 'fas fa-car'
                            ];
                        @endphp
                        @foreach($popularIcons as $iconClass)
                            <button type="button" 
                                    onclick="selectIcon('{{ $iconClass }}')"
                                    class="w-10 h-10 bg-gray-100 hover:bg-primary/10 rounded-lg flex items-center justify-center transition-colors duration-200 icon-btn"
                                    title="{{ $iconClass }}">
                                <i class="{{ $iconClass }} text-gray-600 hover:text-primary"></i>
                            </button>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Click an icon to select it, or type your own FontAwesome class</p>
                </div>
            </div>
            
            <!-- Tips Card -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl border border-yellow-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-yellow-200">
                    <h3 class="text-lg font-semibold text-yellow-800 flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Pro Tips
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Choose Meaningful Names</p>
                            <p class="text-xs text-gray-600">Use clear, descriptive names that help users understand the content</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Color Consistency</p>
                            <p class="text-xs text-gray-600">Use colors that match your brand and are easily distinguishable</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">SEO Optimization</p>
                            <p class="text-xs text-gray-600">Fill in meta descriptions to improve search engine visibility</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Logical Ordering</p>
                            <p class="text-xs text-gray-600">Order categories by importance or frequency of use</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Card (Edit Mode) -->
            @if(isset($category))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        Category Stats
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                            <div class="text-2xl font-bold text-blue-600">{{ $category->active_posts_count }}</div>
                            <div class="text-sm text-blue-700">Posts</div>
                        </div>
                        <div class="text-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
                            <div class="text-2xl font-bold text-green-600">{{ $category->isActive() ? 'Active' : 'Inactive' }}</div>
                            <div class="text-sm text-green-700">Status</div>
                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <span>Created:</span>
                            <span>{{ $category->created_at ? $category->created_at->format('M d, Y') : 'Unknown' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Last Updated:</span>
                            <span>{{ $category->updated_at->diffForHumans() }}</span>
                        </div>
                        @if($category->active_posts_count > 0)
                            <div class="pt-2 border-t border-gray-200">
                                <a href="{{ route('admin.blog.posts.index', ['category' => $category->id]) }}" 
                                   class="text-primary hover:text-secondary text-sm font-medium">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    View Posts in this Category
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    document.getElementById('slug').value = slug;
    
    // Update preview
    document.getElementById('previewName').textContent = name || 'Category Name';
    document.getElementById('previewSlug').textContent = slug || 'category-slug';
    document.getElementById('previewBadgeName').textContent = name || 'Category Name';
});

// Description preview
document.getElementById('description').addEventListener('input', function() {
    document.getElementById('previewDescription').textContent = this.value || 'Category description will appear here';
});

// Icon preview and selection
document.getElementById('icon').addEventListener('input', function() {
    const iconClass = this.value || 'fas fa-folder';
    document.getElementById('iconPreview').className = iconClass + ' text-gray-600';
    document.getElementById('previewIconClass').className = iconClass + ' text-xl';
    document.getElementById('previewBadgeIcon').className = iconClass + ' mr-2';
});

function selectIcon(iconClass) {
    document.getElementById('icon').value = iconClass;
    document.getElementById('iconPreview').className = iconClass + ' text-gray-600';
    document.getElementById('previewIconClass').className = iconClass + ' text-xl';
    document.getElementById('previewBadgeIcon').className = iconClass + ' mr-2';
    
    // Highlight selected icon
    document.querySelectorAll('.icon-btn').forEach(btn => {
        btn.classList.remove('bg-primary/20');
    });
    event.target.closest('.icon-btn').classList.add('bg-primary/20');
}

// Color preview and sync
document.getElementById('color').addEventListener('input', function() {
    const color = this.value;
    document.getElementById('colorHex').value = color;
    updateColorPreview(color);
});

document.getElementById('colorHex').addEventListener('input', function() {
    const color = this.value;
    if (/^#[0-9A-F]{6}$/i.test(color)) {
        document.getElementById('color').value = color;
        updateColorPreview(color);
    }
});

function updateColorPreview(color) {
    // Update preview elements
    const previewIcon = document.getElementById('previewIcon');
    const previewIconClass = document.getElementById('previewIconClass');
    const previewBadge = document.getElementById('previewBadge');
    
    previewIcon.style.background = `linear-gradient(135deg, ${color}20, ${color}40)`;
    previewIconClass.style.color = color;
    previewBadge.style.backgroundColor = color + '20';
    previewBadge.style.color = color;
}

// Sort order preview
document.getElementById('sort_order').addEventListener('input', function() {
    document.getElementById('previewOrder').textContent = 'Order: ' + (this.value || '1');
});

// Form submission with loading state
document.getElementById('categoryForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Saving...</span>';
});

// Character counters
function addCharacterCounter(inputId, maxLength) {
    const input = document.getElementById(inputId);
    if (!input) return;
    
    const counter = document.createElement('div');
    counter.className = 'text-xs text-gray-500 text-right mt-1';
    input.parentNode.appendChild(counter);
    
    function updateCounter() {
        const remaining = maxLength - input.value.length;
        counter.textContent = `${input.value.length}/${maxLength}`;
        counter.className = `text-xs text-right mt-1 ${remaining < 10 ? 'text-red-500' : 'text-gray-500'}`;
    }
    
    input.addEventListener('input', updateCounter);
    updateCounter();
}

// Add character counters
addCharacterCounter('meta_title', 60);
addCharacterCounter('meta_description', 160);

// Initialize preview on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set initial preview values
    const name = document.getElementById('name').value;
    const description = document.getElementById('description').value;
    const color = document.getElementById('color').value;
    const icon = document.getElementById('icon').value;
    const sortOrder = document.getElementById('sort_order').value;
    
    if (name) {
        document.getElementById('previewName').textContent = name;
        document.getElementById('previewBadgeName').textContent = name;
    }
    if (description) {
        document.getElementById('previewDescription').textContent = description;
    }
    if (color) {
        updateColorPreview(color);
        document.getElementById('colorHex').value = color;
    }
    if (sortOrder) {
        document.getElementById('previewOrder').textContent = 'Order: ' + sortOrder;
    }
});
</script>
@endpush