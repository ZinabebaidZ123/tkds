@extends('admin.layouts.app')

@section('title', isset($client) ? 'Edit Client' : 'Add Client')
@section('page-title', isset($client) ? 'Edit Client' : 'Add Client')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.clients.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.clients.index') }}" class="hover:text-primary transition-colors duration-200">Client Logos</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($client) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($client) ? 'Edit' : 'Add New' }} Client Logo
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ isset($client) ? 'Update the' : 'Create a new' }} client showcase entry</p>
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
                        Client Details
                    </h3>
                </div>
                
                <form action="{{ isset($client) ? route('admin.clients.update', $client) : route('admin.clients.store') }}" 
                      method="POST" enctype="multipart/form-data" class="p-6 space-y-6" id="clientForm">
                    @csrf
                    @if(isset($client))
                        @method('PUT')
                    @endif
                    
                    <!-- Client Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-building mr-2 text-primary"></i>
                            Client Name
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $client->name ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('name') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="Enter client name"
                               required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">This will be used for alt text and accessibility</p>
                    </div>

                    <!-- Website URL -->
                    <div class="space-y-2">
                        <label for="website_url" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-link mr-2 text-primary"></i>
                            Website URL (Optional)
                        </label>
                        <input type="url" 
                               id="website_url" 
                               name="website_url" 
                               value="{{ old('website_url', $client->website_url ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('website_url') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="https://example.com">
                        @error('website_url')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Link to client's website (optional)</p>
                    </div>

                    <!-- Logo Upload -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-image mr-2 text-primary"></i>
                            Client Logo {{ isset($client) ? '(Optional - leave empty to keep current)' : '' }}
                        </label>
                        
                        <!-- Current Logo Preview (Edit mode) -->
                        @if(isset($client) && $client->logo)
                            <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Logo:</p>
                                <div class="w-32 h-24 rounded-lg overflow-hidden border border-gray-300 shadow-sm flex items-center justify-center"
                                     style="{{ $client->getStyleString() }}">
                                    <img src="{{ $client->getLogoUrl() }}" 
                                         alt="{{ $client->name }}"
                                         class="max-w-full max-h-full object-contain">
                                </div>
                            </div>
                        @endif
                        
                        <!-- Upload Area -->
                        <div class="mt-1 flex justify-center px-6 pt-8 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary transition-colors duration-300 bg-gray-50 hover:bg-primary/5" id="dropZone">
                            <div class="space-y-4 text-center">
                                <div class="mx-auto h-16 w-16 text-gray-400">
                                    <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                </div>
                                <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                    <label for="logo" class="relative cursor-pointer bg-white rounded-lg font-semibold text-primary hover:text-secondary focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary px-3 py-1 border border-primary/20">
                                        <span>Choose logo file</span>
                                        <input id="logo" name="logo" type="file" class="sr-only" accept="image/*" 
                                               {{ !isset($client) ? 'required' : '' }} onchange="previewLogo(this)">
                                    </label>
                                    <p class="pl-1 sm:pl-2 mt-1 sm:mt-0">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, SVG up to 2MB • Transparent background recommended</p>
                            </div>
                        </div>
                        
                        <!-- New Logo Preview -->
                        <div id="logoPreview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">New Logo Preview:</p>
                            <div class="relative inline-block">
                                <div class="w-32 h-24 rounded-lg overflow-hidden border border-gray-300 shadow-sm flex items-center justify-center bg-white" id="previewContainer">
                                    <img id="previewImg" class="max-w-full max-h-full object-contain" />
                                </div>
                                <button type="button" onclick="removePreview()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        @error('logo')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Category & Order -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="category" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-tags mr-2 text-primary"></i>
                                Category
                            </label>
                            <select id="category" 
                                    name="category" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('category') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="streaming" {{ old('category', $client->category ?? '') === 'streaming' ? 'selected' : '' }}>
                                    📺 Streaming Giants
                                </option>
                                <option value="news_sports" {{ old('category', $client->category ?? '') === 'news_sports' ? 'selected' : '' }}>
                                    📰 News & Sports
                                </option>
                                <option value="tech_gaming" {{ old('category', $client->category ?? '') === 'tech_gaming' ? 'selected' : '' }}>
                                    🎮 Tech & Gaming
                                </option>
                                <option value="other" {{ old('category', $client->category ?? '') === 'other' ? 'selected' : '' }}>
                                    🏢 Other
                                </option>
                            </select>
                            @error('category')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Clients are grouped by category in the showcase</p>
                        </div>

                        <div class="space-y-2">
                            <label for="sort_order" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-sort mr-2 text-primary"></i>
                                Display Order
                            </label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $client->sort_order ?? 1) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('sort_order') border-red-500 ring-2 ring-red-200 @enderror"
                                   required>
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Lower numbers appear first in the carousel</p>
                        </div>
                    </div>

                    <!-- Style Settings -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                        <h4 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                            <i class="fas fa-palette mr-2"></i>
                            Visual Style Settings
                        </h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Background Color -->
                            <div class="space-y-2">
                                <label for="background_color" class="block text-sm font-semibold text-blue-800">
                                    Background Color
                                </label>
                                <div class="flex items-center space-x-3">
                                    <input type="color" 
                                           id="background_color" 
                                           name="background_color" 
                                           value="{{ old('background_color', $client->background_color ?? '#FFFFFF') }}"
                                           class="w-12 h-12 rounded-lg border-2 border-gray-300 cursor-pointer"
                                           onchange="updatePreviewStyles()">
                                    <input type="text" 
                                           id="background_color_text"
                                           value="{{ old('background_color', $client->background_color ?? '#FFFFFF') }}"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono"
                                           onchange="syncColorInputs('background_color')">
                                </div>
                            </div>

                            <!-- Hover Background Color -->
                            <div class="space-y-2">
                                <label for="hover_background_color" class="block text-sm font-semibold text-blue-800">
                                    Hover Background (Optional)
                                </label>
                                <div class="flex items-center space-x-3">
                                    <input type="color" 
                                           id="hover_background_color" 
                                           name="hover_background_color" 
                                           value="{{ old('hover_background_color', $client->hover_background_color ?? '#F5F5F5') }}"
                                           class="w-12 h-12 rounded-lg border-2 border-gray-300 cursor-pointer">
                                    <input type="text" 
                                           id="hover_background_color_text"
                                           value="{{ old('hover_background_color', $client->hover_background_color ?? '#F5F5F5') }}"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono"
                                           onchange="syncColorInputs('hover_background_color')">
                                </div>
                            </div>

                            <!-- Border Color -->
                            <div class="space-y-2">
                                <label for="border_color" class="block text-sm font-semibold text-blue-800">
                                    Border Color (Optional)
                                </label>
                                <div class="flex items-center space-x-3">
                                    <input type="color" 
                                           id="border_color" 
                                           name="border_color" 
                                           value="{{ old('border_color', $client->border_color ?? '#E5E7EB') }}"
                                           class="w-12 h-12 rounded-lg border-2 border-gray-300 cursor-pointer"
                                           onchange="updatePreviewStyles()">
                                    <input type="text" 
                                           id="border_color_text"
                                           value="{{ old('border_color', $client->border_color ?? '#E5E7EB') }}"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono"
                                           onchange="syncColorInputs('border_color')">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="space-y-2">
                                <label for="status" class="block text-sm font-semibold text-blue-800">
                                    Status
                                </label>
                                <select id="status" 
                                        name="status" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                        required>
                                    <option value="active" {{ old('status', $client->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                        ✅ Active (Visible in showcase)
                                    </option>
                                    <option value="inactive" {{ old('status', $client->status ?? '') === 'inactive' ? 'selected' : '' }}>
                                        ❌ Inactive (Hidden from showcase)
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Animation Settings -->
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label for="hover_scale" class="block text-sm font-semibold text-blue-800">
                                    Hover Scale
                                </label>
                                <input type="number" 
                                       id="hover_scale" 
                                       name="hover_scale" 
                                       value="{{ old('hover_scale', $client->hover_scale ?? 1.10) }}"
                                       min="1.00" max="2.00" step="0.05"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <p class="text-xs text-blue-600">1.00 = no scale, 1.10 = 10% larger</p>
                            </div>

                            <div class="space-y-2">
                                <label for="opacity" class="block text-sm font-semibold text-blue-800">
                                    Opacity
                                </label>
                                <input type="number" 
                                       id="opacity" 
                                       name="opacity" 
                                       value="{{ old('opacity', $client->opacity ?? 1.00) }}"
                                       min="0.10" max="1.00" step="0.05"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                       onchange="updatePreviewStyles()">
                                <p class="text-xs text-blue-600">1.00 = fully visible, 0.50 = 50% transparent</p>
                            </div>

                            <div class="space-y-2">
                                <label for="hover_opacity" class="block text-sm font-semibold text-blue-800">
                                    Hover Opacity
                                </label>
                                <input type="number" 
                                       id="hover_opacity" 
                                       name="hover_opacity" 
                                       value="{{ old('hover_opacity', $client->hover_opacity ?? 0.80) }}"
                                       min="0.10" max="1.00" step="0.05"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <p class="text-xs text-blue-600">Opacity when hovered</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.clients.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                                id="submitBtn">
                            <i class="fas fa-save mr-2"></i>
                            <span>{{ isset($client) ? 'Update' : 'Create' }} Client</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Sidebar -->
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
                    <div class="relative bg-gray-900 rounded-lg overflow-hidden p-8">
                        <div id="livePreview" class="w-48 h-24 rounded-xl overflow-hidden border-2 border-gray-300 shadow-lg group hover:scale-110 transition-all duration-500 flex items-center justify-center bg-white mx-auto">
                            <div id="previewClientLogo" class="text-gray-400 text-sm">
                                Upload a logo to see preview
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center">This is how your client will appear in the showcase</p>
                </div>
            </div>
            
            <!-- Tips Card -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl border border-yellow-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-yellow-200">
                    <h3 class="text-lg font-semibold text-yellow-800 flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Logo Tips
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Transparent Background</p>
                            <p class="text-xs text-gray-600">Use PNG with transparent background for best results</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">High Resolution</p>
                            <p class="text-xs text-gray-600">Use crisp, high-quality logos for professional appearance</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Proper Colors</p>
                            <p class="text-xs text-gray-600">Match background colors with brand guidelines</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Category Grouping</p>
                            <p class="text-xs text-gray-600">Group similar clients for better visual flow</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Card -->
            @if(isset($client))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        Client Stats
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Created</span>
                        <span class="text-sm font-medium text-gray-900">{{ $client->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $client->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Category</span>
                        <span class="text-sm font-medium text-gray-900">{{ $client->getCategoryName() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $client->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($client->status) }}
                        </span>
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
// Logo preview functionality
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('logoPreview').classList.remove('hidden');
            document.getElementById('previewImg').src = e.target.result;
            
            // Update live preview
            const livePreview = document.getElementById('previewClientLogo');
            livePreview.innerHTML = `<img src="${e.target.result}" alt="Logo Preview" class="max-w-full max-h-full object-contain">`;
            
            updatePreviewStyles();
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove preview
function removePreview() {
    document.getElementById('logoPreview').classList.add('hidden');
    document.getElementById('previewImg').src = '';
    document.getElementById('logo').value = '';
    
    // Reset live preview
    const livePreview = document.getElementById('previewClientLogo');
    livePreview.innerHTML = 'Upload a logo to see preview';
    
    updatePreviewStyles();
}

// Update preview styles
function updatePreviewStyles() {
    const livePreview = document.getElementById('livePreview');
    const previewContainer = document.getElementById('previewContainer');
    
    const backgroundColor = document.getElementById('background_color').value;
    const borderColor = document.getElementById('border_color').value;
    const opacity = document.getElementById('opacity').value;
    
    const style = `
        background-color: ${backgroundColor};
        border-color: ${borderColor};
        opacity: ${opacity};
    `;
    
    if (livePreview) {
        livePreview.style.cssText = style;
    }
    
    if (previewContainer) {
        previewContainer.style.cssText = style;
    }
}

// Sync color inputs
function syncColorInputs(colorType) {
    const colorInput = document.getElementById(colorType);
    const textInput = document.getElementById(colorType + '_text');
    
    if (textInput && colorInput) {
        colorInput.value = textInput.value;
        updatePreviewStyles();
    }
}

// Sync text inputs with color inputs
document.querySelectorAll('input[type="color"]').forEach(input => {
    input.addEventListener('change', function() {
        const textInput = document.getElementById(this.id + '_text');
        if (textInput) {
            textInput.value = this.value;
        }
        updatePreviewStyles();
    });
});

// Drag and drop functionality
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('logo');

dropZone.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('border-primary', 'bg-primary/10');
});

dropZone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('border-primary', 'bg-primary/10');
});

dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('border-primary', 'bg-primary/10');
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        previewLogo(fileInput);
    }
});

// Form submission with loading state
document.getElementById('clientForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Saving...</span>';
});

// Live name preview
document.getElementById('name').addEventListener('input', function() {
    const previewLogo = document.getElementById('previewClientLogo');
    if (previewLogo && previewLogo.textContent.includes('Upload a logo')) {
        previewLogo.textContent = this.value || 'Upload a logo to see preview';
    }
});

// Initialize preview styles on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePreviewStyles();
    
    // Set existing logo in preview if editing
    @if(isset($client) && $client->logo)
        const livePreview = document.getElementById('previewClientLogo');
        livePreview.innerHTML = `<img src="{{ $client->getLogoUrl() }}" alt="{{ $client->name }}" class="max-w-full max-h-full object-contain">`;
        updatePreviewStyles();
    @endif
});

// Character counter for name field
function addCharacterCounter(inputId, maxLength) {
    const input = document.getElementById(inputId);
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

// Add character counter for name
addCharacterCounter('name', 255);

// Color picker enhancements
document.querySelectorAll('input[type="color"]').forEach(colorInput => {
    colorInput.addEventListener('input', function() {
        const textInput = document.getElementById(this.id + '_text');
        if (textInput) {
            textInput.value = this.value;
        }
        updatePreviewStyles();
    });
});

// Validate hex color codes
document.querySelectorAll('input[id$="_text"]').forEach(textInput => {
    textInput.addEventListener('blur', function() {
        const value = this.value.trim();
        if (value && !value.match(/^#[0-9A-Fa-f]{6}$/)) {
            this.style.borderColor = '#EF4444';
            this.style.backgroundColor = '#FEF2F2';
        } else {
            this.style.borderColor = '';
            this.style.backgroundColor = '';
            if (value) {
                const colorInput = document.getElementById(this.id.replace('_text', ''));
                if (colorInput) {
                    colorInput.value = value;
                }
                updatePreviewStyles();
            }
        }
    });
});

// Preset color buttons
function addColorPresets() {
    const colorSections = document.querySelectorAll('input[type="color"]');
    
    const presetColors = [
        '#FFFFFF', '#000000', '#F5F5F5', '#E5E7EB',
        '#DC2626', '#EA580C', '#D97706', '#CA8A04',
        '#65A30D', '#16A34A', '#059669', '#0D9488',
        '#0891B2', '#0284C7', '#2563EB', '#4F46E5',
        '#7C3AED', '#9333EA', '#C026D3', '#DB2777'
    ];
    
    colorSections.forEach(colorInput => {
        const container = colorInput.closest('.space-y-2');
        if (container && !container.querySelector('.color-presets')) {
            const presetsDiv = document.createElement('div');
            presetsDiv.className = 'color-presets grid grid-cols-10 gap-1 mt-2';
            
            presetColors.forEach(color => {
                const preset = document.createElement('button');
                preset.type = 'button';
                preset.className = 'w-6 h-6 rounded border-2 border-gray-300 hover:border-gray-500 transition-colors duration-200';
                preset.style.backgroundColor = color;
                preset.title = color;
                
                preset.addEventListener('click', () => {
                    colorInput.value = color;
                    const textInput = document.getElementById(colorInput.id + '_text');
                    if (textInput) {
                        textInput.value = color;
                    }
                    updatePreviewStyles();
                });
                
                presetsDiv.appendChild(preset);
            });
            
            container.appendChild(presetsDiv);
        }
    });
}

// Initialize color presets
setTimeout(addColorPresets, 100);
</script>
@endpush
