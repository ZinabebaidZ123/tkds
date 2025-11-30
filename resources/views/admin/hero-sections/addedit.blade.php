@extends('admin.layouts.app')

@section('title', isset($heroSection) ? 'Edit Hero Section' : 'Add Hero Section')
@section('page-title', isset($heroSection) ? 'Edit Hero Section' : 'Add Hero Section')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.hero-sections.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.hero-sections.index') }}" class="hover:text-primary transition-colors duration-200">Hero Sections</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($heroSection) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($heroSection) ? 'Edit' : 'Add New' }} Hero Section
                </h2>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <form action="{{ isset($heroSection) ? route('admin.hero-sections.update', $heroSection) : route('admin.hero-sections.store') }}" 
          method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        @if(isset($heroSection))
            @method('PUT')
        @endif
        
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Basic Content -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-edit mr-2 text-primary"></i>
                        Content Settings
                    </h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-heading mr-2 text-primary"></i>
                            Main Title
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $heroSection->title ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('title') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="Your World, Live and Direct"
                               required>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Subtitle -->
                    <div class="space-y-2">
                        <label for="subtitle" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-text-width mr-2 text-primary"></i>
                            Subtitle (Optional)
                        </label>
                        <input type="text" 
                               id="subtitle" 
                               name="subtitle" 
                               value="{{ old('subtitle', $heroSection->subtitle ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('subtitle') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="Professional Broadcasting Solutions">
                        @error('subtitle')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-align-left mr-2 text-primary"></i>
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('description') border-red-500 ring-2 ring-red-200 @enderror"
                                  placeholder="Premium streaming, production, and broadcasting solutions...">{{ old('description', $heroSection->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Buttons Settings -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-mouse-pointer mr-2 text-primary"></i>
                        Button Settings
                    </h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Main Button -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="main_button_text" class="block text-sm font-semibold text-gray-700">
                                Main Button Text
                            </label>
                            <input type="text" 
                                   id="main_button_text" 
                                   name="main_button_text" 
                                   value="{{ old('main_button_text', $heroSection->main_button_text ?? 'Start Broadcasting') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   required>
                        </div>
                        <div class="space-y-2">
                            <label for="main_button_link" class="block text-sm font-semibold text-gray-700">
                                Main Button Link
                            </label>
                            <input type="text" 
                                   id="main_button_link" 
                                   name="main_button_link" 
                                   value="{{ old('main_button_link', $heroSection->main_button_link ?? '#packages') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   required>
                        </div>
                    </div>

                    <!-- Second Button -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="second_button_text" class="block text-sm font-semibold text-gray-700">
                                Second Button Text (Optional)
                            </label>
                            <input type="text" 
                                   id="second_button_text" 
                                   name="second_button_text" 
                                   value="{{ old('second_button_text', $heroSection->second_button_text ?? 'Talk with AI Chat') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        </div>
                        <div class="space-y-2">
                            <label for="second_button_link" class="block text-sm font-semibold text-gray-700">
                                Second Button Link
                            </label>
                            <input type="text" 
                                   id="second_button_link" 
                                   name="second_button_link" 
                                   value="{{ old('second_button_link', $heroSection->second_button_link ?? '#') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perfect For Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-users mr-2 text-primary"></i>
                        Perfect For Section
                    </h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="perfect_for_title" class="block text-sm font-semibold text-gray-700">
                                Section Title
                            </label>
                            <input type="text" 
                                   id="perfect_for_title" 
                                   name="perfect_for_title" 
                                   value="{{ old('perfect_for_title', $heroSection->perfect_for_title ?? 'Perfect For') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        </div>
                        <div class="space-y-2">
                            <label for="perfect_for_subtitle" class="block text-sm font-semibold text-gray-700">
                                Section Subtitle
                            </label>
                            <input type="text" 
                                   id="perfect_for_subtitle" 
                                   name="perfect_for_subtitle" 
                                   value="{{ old('perfect_for_subtitle', $heroSection->perfect_for_subtitle ?? 'Real-World Broadcasting Scenarios') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            <span class="text-sm font-medium text-blue-800">Manage Cards</span>
                        </div>
                        <p class="text-sm text-blue-700 mb-3">Perfect For cards (Speakers, Filmmakers, etc.) are managed separately.</p>
                        <a href="{{ route('admin.perfect-for-cards.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            Manage Perfect For Cards
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Settings -->
        <div class="space-y-6">
            
            <!-- Status & Order -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-cog mr-2 text-primary"></i>
                        Settings
                    </h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-semibold text-gray-700">
                            Status
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                required>
                            <option value="active" {{ old('status', $heroSection->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                ✅ Active
                            </option>
                            <option value="inactive" {{ old('status', $heroSection->status ?? '') === 'inactive' ? 'selected' : '' }}>
                                ❌ Inactive
                            </option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="sort_order" class="block text-sm font-semibold text-gray-700">
                            Display Order
                        </label>
                        <input type="number" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', $heroSection->sort_order ?? 1) }}"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               required>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-magic mr-2 text-primary"></i>
                        Visual Features
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
<!-- AI Badge -->
<div class="flex items-center justify-between">
    <div>
        <label for="show_ai_badge" class="text-sm font-medium text-gray-700">Show AI Badge</label>
        <p class="text-xs text-gray-500">Display the "NOW POWERED BY AI" badge</p>
    </div>
    <label class="toggle-switch">
        <input type="checkbox" 
               id="show_ai_badge"
               name="show_ai_badge" 
               {{ old('show_ai_badge', $heroSection->show_ai_badge ?? true) ? 'checked' : '' }}>
        <span class="toggle-slider"></span>
    </label>
</div>

<!-- Rotating Cards -->
<div class="flex items-center justify-between">
    <div>
        <label for="show_rotating_cards" class="text-sm font-medium text-gray-700">Show Rotating Cards</label>
        <p class="text-xs text-gray-500">Display the "Perfect For" rotating cards</p>
    </div>
    <label class="toggle-switch">
        <input type="checkbox" 
               id="show_rotating_cards"
               name="show_rotating_cards" 
               {{ old('show_rotating_cards', $heroSection->show_rotating_cards ?? true) ? 'checked' : '' }}>
        <span class="toggle-slider"></span>
    </label>
</div>

<!-- Particles -->
<div class="flex items-center justify-between">
    <div>
        <label for="show_particles" class="text-sm font-medium text-gray-700">Show Particles</label>
        <p class="text-xs text-gray-500">Display animated particles in background</p>
    </div>
    <label class="toggle-switch">
        <input type="checkbox" 
               id="show_particles"
               name="show_particles" 
               {{ old('show_particles', $heroSection->show_particles ?? true) ? 'checked' : '' }}>
        <span class="toggle-slider"></span>
    </label>
</div>
                    <!-- AI Badge Text -->
                    <div class="space-y-2">
                        <label for="ai_badge_text" class="block text-sm font-semibold text-gray-700">
                            AI Badge Text
                        </label>
                        <input type="text" 
                               id="ai_badge_text" 
                               name="ai_badge_text" 
                               value="{{ old('ai_badge_text', $heroSection->ai_badge_text ?? 'NOW POWERED BY AI TECHNOLOGY') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                    </div>
                </div>
            </div>

            <!-- Colors -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-palette mr-2 text-primary"></i>
                        Colors
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="space-y-2">
                        <label for="text_color" class="block text-sm font-semibold text-gray-700">
                            Text Color
                        </label>
                        <input type="color" 
                               id="text_color" 
                               name="text_color" 
                               value="{{ old('text_color', $heroSection->text_color ?? '#ffffff') }}"
                               class="w-full h-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>

                    <div class="space-y-2">
                        <label for="gradient_color_1" class="block text-sm font-semibold text-gray-700">
                            Gradient Color 1
                        </label>
                        <input type="color" 
                               id="gradient_color_1" 
                               name="gradient_color_1" 
                               value="{{ old('gradient_color_1', $heroSection->gradient_color_1 ?? '#C53030') }}"
                               class="w-full h-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>

                    <div class="space-y-2">
                        <label for="gradient_color_2" class="block text-sm font-semibold text-gray-700">
                            Gradient Color 2
                        </label>
                        <input type="color" 
                               id="gradient_color_2" 
                               name="gradient_color_2" 
                               value="{{ old('gradient_color_2', $heroSection->gradient_color_2 ?? '#E53E3E') }}"
                               class="w-full h-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>

                    <div class="space-y-2">
                        <label for="gradient_color_3" class="block text-sm font-semibold text-gray-700">
                            Gradient Color 3
                        </label>
                        <input type="color" 
                               id="gradient_color_3" 
                               name="gradient_color_3" 
                               value="{{ old('gradient_color_3', $heroSection->gradient_color_3 ?? '#FC8181') }}"
                               class="w-full h-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </div>

            <!-- Media -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-image mr-2 text-primary"></i>
                        Background Media
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
<!-- Background Image -->
<div class="space-y-2">
    <label class="block text-sm font-semibold text-gray-700">
        Background Image (Optional)
    </label>
    
    @if(isset($heroSection) && $heroSection->background_image)
        <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200 relative">
            <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
            <div class="relative inline-block">
                <img src="{{ $heroSection->getBackgroundImageUrl() }}" 
                     alt="Background"
                     class="max-w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm"
                     id="currentImage">
                <button type="button" 
                        class="remove-image-btn" 
                        onclick="removeCurrentImage('background_image')"
                        title="Remove Image">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
            <input type="hidden" name="remove_background_image" id="remove_background_image" value="0">
        </div>
    @endif
    
    <input type="file" 
           id="background_image" 
           name="background_image" 
           accept="image/*"
           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
           onchange="previewImage(this, 'imagePreview')">
    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
    
    <!-- New Image Preview -->
    <div id="imagePreview" class="mt-4 hidden">
        <p class="text-sm font-medium text-gray-700 mb-2">New Image Preview:</p>
        <div class="relative inline-block">
            <img id="previewImg" class="max-w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm" />
            <button type="button" 
                    class="remove-image-btn" 
                    onclick="removePreview('imagePreview', 'background_image')"
                    title="Remove Preview">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>
</div>

<!-- Background Video -->
<div class="space-y-2">
    <label class="block text-sm font-semibold text-gray-700">
        Background Video (Optional)
    </label>
    
    @if(isset($heroSection) && $heroSection->background_video)
        <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200 relative">
            <p class="text-sm font-medium text-gray-700 mb-2">Current Video:</p>
            <div class="relative inline-block bg-gray-200 px-4 py-2 rounded-lg">
                <i class="fas fa-video mr-2 text-gray-600"></i>
                <span class="text-sm text-gray-700">{{ basename($heroSection->background_video) }}</span>
                <button type="button" 
                        class="remove-image-btn" 
                        onclick="removeCurrentImage('background_video')"
                        title="Remove Video">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
            <input type="hidden" name="remove_background_video" id="remove_background_video" value="0">
        </div>
    @endif
    
    <input type="file" 
           id="background_video" 
           name="background_video" 
           accept="video/*"
           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
    <p class="text-xs text-gray-500">MP4, AVI, MOV up to 50MB</p>
</div>
                </div>
            </div>

            <!-- Custom CSS -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-code mr-2 text-primary"></i>
                        Custom CSS (Advanced)
                    </h3>
                </div>
                
                <div class="p-6">
                    <textarea id="custom_css" 
                              name="custom_css" 
                              rows="6"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none font-mono text-sm"
                              placeholder=".hero-section { background: linear-gradient(...); }">{{ old('custom_css', $heroSection->custom_css ?? '') }}</textarea>
                    <p class="text-xs text-gray-500 mt-2">Add custom CSS for advanced styling</p>
                </div>
            </div>

        </div>

        <!-- Submit Buttons -->
        <div class="lg:col-span-3 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.hero-sections.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                <i class="fas fa-times mr-2"></i>
                Cancel
            </a>
            <button type="submit" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                <span>{{ isset($heroSection) ? 'Update' : 'Create' }} Hero Section</span>
            </button>
        </div>
    </form>
</div>

<style>
/* Toggle Switch Fixes */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #e5e7eb;
    transition: all 0.3s ease;
    border-radius: 24px;
    border: 2px solid #d1d5db;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    transition: all 0.3s ease;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

input:checked + .toggle-slider {
    background-color: #10b981;
    border-color: #059669;
}

input:checked + .toggle-slider:before {
    transform: translateX(20px);
}

.toggle-slider:hover {
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}

/* Remove Image Button */
.remove-image-btn {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 10;
}

.remove-image-btn:hover {
    background: #dc2626;
    transform: scale(1.1);
}
</style>
@push('scripts')
<script>
// Image preview functionality
function previewImage(input, previewContainerId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const previewContainer = document.getElementById(previewContainerId);
            const previewImg = previewContainer.querySelector('img');
            
            previewContainer.classList.remove('hidden');
            previewImg.src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove current image/video
function removeCurrentImage(type) {
    const removeInput = document.getElementById('remove_' + type);
    const currentImageContainer = removeInput.closest('.relative');
    
    // Mark for removal
    removeInput.value = '1';
    
    // Hide the current image/video container
    currentImageContainer.style.display = 'none';
    
    // Show notification
    showNotification(`Current ${type.replace('_', ' ')} will be removed when you save`, 'warning');
}

// Remove preview
function removePreview(previewContainerId, inputId) {
    const previewContainer = document.getElementById(previewContainerId);
    const fileInput = document.getElementById(inputId);
    
    previewContainer.classList.add('hidden');
    fileInput.value = '';
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 
                   type === 'error' ? 'bg-red-500' : 
                   type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';
    
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white max-w-sm`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-info-circle mr-2"></i>
            <span class="text-sm">${message}</span>
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
@endpush
@endsection