@extends('admin.layouts.app')

@section('title', isset($solution) ? 'Edit Broadcasting Solution' : 'Add Broadcasting Solution')
@section('page-title', isset($solution) ? 'Edit Broadcasting Solution' : 'Add Broadcasting Solution')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.broadcasting-solutions.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.broadcasting-solutions.index') }}" class="hover:text-primary transition-colors duration-200">Broadcasting Solutions</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($solution) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($solution) ? 'Edit' : 'Add New' }} Broadcasting Solution
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ isset($solution) ? 'Update the' : 'Create a new' }} slide for the broadcasting showcase</p>
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
                        Solution Details
                    </h3>
                </div>
                
                <form action="{{ isset($solution) ? route('admin.broadcasting-solutions.update', $solution) : route('admin.broadcasting-solutions.store') }}" 
                      method="POST" enctype="multipart/form-data" class="p-6 space-y-6" id="solutionForm">
                    @csrf
                    @if(isset($solution))
                        @method('PUT')
                    @endif
                    
                    <!-- Title -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-heading mr-2 text-primary"></i>
                            Title
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $solution->title ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('title') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="Enter a compelling title"
                               required>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">This will be displayed as the main heading on the slide</p>
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
                                  placeholder="Describe this broadcasting solution"
                                  required>{{ old('description', $solution->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Keep it concise and impactful - this appears below the title</p>
                    </div>

                    <!-- Image Upload -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-image mr-2 text-primary"></i>
                            Background Image {{ isset($solution) ? '(Optional - leave empty to keep current)' : '' }}
                        </label>
                        
                        <!-- Current Image Preview (Edit mode) -->
                        @if(isset($solution))
                            <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
                                <img src="{{ $solution->getImageUrl() }}" 
                                     alt="{{ $solution->title }}"
                                     class="max-w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm">
                            </div>
                        @endif
                        
                        <!-- Upload Area -->
                        <div class="mt-1 flex justify-center px-6 pt-8 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary transition-colors duration-300 bg-gray-50 hover:bg-primary/5" id="dropZone">
                            <div class="space-y-4 text-center">
                                <div class="mx-auto h-16 w-16 text-gray-400">
                                    <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                </div>
                                <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-lg font-semibold text-primary hover:text-secondary focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary px-3 py-1 border border-primary/20">
                                        <span>Choose file</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*" 
                                               {{ !isset($solution) ? 'required' : '' }} onchange="previewImage(this)">
                                    </label>
                                    <p class="pl-1 sm:pl-2 mt-1 sm:mt-0">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB • Recommended: 1200x600px</p>
                            </div>
                        </div>
                        
                        <!-- New Image Preview -->
                        <div id="imagePreview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">New Image Preview:</p>
                            <div class="relative inline-block">
                                <img id="previewImg" class="max-w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm" />
                                <button type="button" onclick="removePreview()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        @error('image')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Sort Order & Status -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="sort_order" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-sort mr-2 text-primary"></i>
                                Display Order
                            </label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $solution->sort_order ?? 1) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('sort_order') border-red-500 ring-2 ring-red-200 @enderror"
                                   required>
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Lower numbers appear first in the slideshow</p>
                        </div>

                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-toggle-on mr-2 text-primary"></i>
                                Status
                            </label>
                            <select id="status" 
                                    name="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('status') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="active" {{ old('status', $solution->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                    ✅ Active (Visible in slideshow)
                                </option>
                                <option value="inactive" {{ old('status', $solution->status ?? '') === 'inactive' ? 'selected' : '' }}>
                                    ❌ Inactive (Hidden from slideshow)
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

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.broadcasting-solutions.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                                id="submitBtn">
                            <i class="fas fa-save mr-2"></i>
                            <span>{{ isset($solution) ? 'Update' : 'Create' }} Solution</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Sidebar with Tips -->
        <div class="space-y-6">
            
            <!-- Preview Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-eye mr-2 text-blue-600"></i>
                        Live Preview
                    </h3>
                </div>
                <div class="p-6">
                    <div class="relative bg-gray-900 rounded-lg overflow-hidden" style="aspect-ratio: 16/9;">
                        <div id="livePreview" class="absolute inset-0 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 id="previewTitle" class="text-lg font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-2">
                                    {{ $solution->title ?? 'Your Title Here' }}
                                </h3>
                                <p id="previewDescription" class="text-gray-300 text-sm">
                                    {{ $solution->description ?? 'Your description will appear here' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center">This is how your solution will appear in the slideshow</p>
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
                            <p class="text-sm font-medium text-gray-800">Image Quality</p>
                            <p class="text-xs text-gray-600">Use high-resolution images (1200x600px) for crisp display on all devices</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Title Length</p>
                            <p class="text-xs text-gray-600">Keep titles under 50 characters for optimal readability</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Description</p>
                            <p class="text-xs text-gray-600">Write concise, benefit-focused descriptions that grab attention</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Order Strategy</p>
                            <p class="text-xs text-gray-600">Place your most important solutions first (lower order numbers)</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Card -->
            @if(isset($solution))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        Solution Stats
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Created</span>
                        <span class="text-sm font-medium text-gray-900">{{ $solution->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $solution->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $solution->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($solution->status) }}
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
// Image preview functionality
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('previewImg').src = e.target.result;
            
            // Update live preview background
            const livePreview = document.getElementById('livePreview');
            livePreview.style.backgroundImage = `url(${e.target.result})`;
            livePreview.style.backgroundSize = 'cover';
            livePreview.style.backgroundPosition = 'center';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove preview
function removePreview() {
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('previewImg').src = '';
    document.getElementById('image').value = '';
    
    // Reset live preview background
    const livePreview = document.getElementById('livePreview');
    livePreview.style.backgroundImage = '';
}

// Live preview updates
document.getElementById('title').addEventListener('input', function() {
    const previewTitle = document.getElementById('previewTitle');
    previewTitle.textContent = this.value || 'Your Title Here';
});

document.getElementById('description').addEventListener('input', function() {
    const previewDescription = document.getElementById('previewDescription');
    previewDescription.textContent = this.value || 'Your description will appear here';
});

// Drag and drop functionality
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('image');

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
        previewImage(fileInput);
    }
});

// Form submission with loading state
document.getElementById('solutionForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Saving...</span>';
});

// Character counters
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

// Add character counters
addCharacterCounter('title', 50);
addCharacterCounter('description', 200);
</script>
@endpush