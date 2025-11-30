@extends('admin.layouts.app')
@section('page-title', isset($videoSection) ? 'Edit Video Section' : 'Create Video Section')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ isset($videoSection) ? 'Edit Video Section' : 'Create Video Section' }}
            </h1>
        </div>
        <a href="{{ route('admin.video-sections.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="closeAlert('success-alert')">
                <i class="fas fa-times"></i>
            </span>
        </div>
    @endif

    @if(session('error'))
        <div id="error-alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="closeAlert('error-alert')">
                <i class="fas fa-times"></i>
            </span>
        </div>
    @endif

    @if($errors->any())
        <div id="validation-alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative">
            <strong class="font-bold">Please fix the following errors:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="closeAlert('validation-alert')">
                <i class="fas fa-times"></i>
            </span>
        </div>
    @endif

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white p-6 rounded-lg">
                <div class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-lg font-medium">Processing...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form id="video-form" action="{{ isset($videoSection) ? route('admin.video-sections.update', $videoSection) : route('admin.video-sections.store') }}" 
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($videoSection))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column - Form Fields -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Basic Information</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title"
                                   value="{{ old('title', $videoSection->title ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                                   placeholder="Enter section title"
                                   required>
                            @error('title')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                            <input type="text" name="subtitle" id="subtitle"
                                   value="{{ old('subtitle', $videoSection->subtitle ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter subtitle (optional)">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Enter description (optional)">{{ old('description', $videoSection->description ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Video Type -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Video Type</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="video-type-option flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors" data-type="upload">
                                <input type="radio" name="video_type" value="upload" id="video_type_upload"
                                       {{ old('video_type', $videoSection->video_type ?? 'upload') === 'upload' ? 'checked' : '' }}
                                       class="sr-only" onchange="toggleVideoType()">
                                <div class="flex items-center space-x-3">
                                    <div class="radio-indicator w-4 h-4 border-2 border-blue-500 rounded-full flex items-center justify-center">
                                        <div class="radio-dot w-2 h-2 bg-blue-500 rounded-full"></div>
                                    </div>
                                    <i class="fas fa-upload text-blue-600"></i>
                                    <span class="font-medium">Upload File</span>
                                </div>
                            </label>
                            
                            <label class="video-type-option flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors" data-type="live_stream">
                                <input type="radio" name="video_type" value="live_stream" id="video_type_live"
                                       {{ old('video_type', $videoSection->video_type ?? '') === 'live_stream' ? 'checked' : '' }}
                                       class="sr-only" onchange="toggleVideoType()">
                                <div class="flex items-center space-x-3">
                                    <div class="radio-indicator w-4 h-4 border-2 border-red-500 rounded-full flex items-center justify-center">
                                        <div class="radio-dot w-2 h-2 bg-red-500 rounded-full"></div>
                                    </div>
                                    <i class="fas fa-broadcast-tower text-red-600"></i>
                                    <span class="font-medium">Live Stream</span>
                                </div>
                            </label>
                        </div>
                        @error('video_type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Video File Upload -->
                    <div id="upload-section" class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Video File</h3>
                        
                        @if(isset($videoSection) && $videoSection->video_file)
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-600 mb-1">Current file:</p>
                                <p class="text-sm font-medium text-gray-900">{{ basename($videoSection->video_file) }}</p>
                                <p class="text-xs text-gray-500">Choose a new file to replace the current one</p>
                            </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Video File @if(!isset($videoSection) || !$videoSection->video_file)<span class="text-red-500">*</span>@endif
                            </label>
                            <div class="relative">
                                <input type="file" name="video_file" id="video_file" accept="video/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('video_file') border-red-500 @enderror"
                                       onchange="previewVideo(this)">
                                <div id="upload-progress" class="hidden mt-2">
                                    <div class="bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1">Uploading...</p>
                                </div>
                            </div>
                            <div class="mt-2 text-xs text-gray-500 space-y-1">
                                <p><strong>Supported formats:</strong> MP4, MOV, AVI, WMV, WebM, FLV, MKV</p>
                                <p><strong>Maximum size:</strong> 500MB</p>
                            </div>
                            @error('video_file')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Live Stream URL -->
                    <div id="stream-section" class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Live Stream</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Stream URL <span class="text-red-500">*</span>
                            </label>
                            <input type="url" name="video_url" id="video_url"
                                   value="{{ old('video_url', $videoSection->video_url ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('video_url') border-red-500 @enderror"
                                   placeholder="https://example.com/stream.m3u8">
                            <p class="text-xs text-gray-500 mt-1">Enter M3U8 or direct streaming URL</p>
                            @error('video_url')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Thumbnail -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Thumbnail</h3>
                        
                        @if(isset($videoSection) && $videoSection->thumbnail)
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm text-gray-600 mb-2">Current thumbnail:</p>
                                <img src="{{ $videoSection->thumbnail_url }}" alt="Current thumbnail" class="w-32 h-20 object-cover rounded">
                            </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Thumbnail Image</label>
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   onchange="previewThumbnail(this)">
                            <p class="text-xs text-gray-500 mt-1">Supported: JPG, PNG, WebP, GIF (Max: 10MB)</p>
                            @error('thumbnail')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Button Settings -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Call to Action Button</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                                <input type="text" name="button_text" id="button_text"
                                       value="{{ old('button_text', $videoSection->button_text ?? 'Watch Now') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Watch Now">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Button Link</label>
                                <input type="text" name="button_link" id="button_link"
                                       value="{{ old('button_link', $videoSection->button_link ?? '#') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="https://example.com or #section-id">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column - Preview & Settings -->
                <div class="space-y-6">
                    
                    <!-- Video Preview -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-3">Video Preview</h4>
                        <div id="video-preview" class="w-full h-40 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                            @if(isset($videoSection) && $videoSection->hasVideo())
                                <video class="w-full h-full object-cover rounded-lg" controls>
                                    <source src="{{ $videoSection->video_source }}" type="video/mp4">
                                </video>
                            @else
                                <div class="text-center text-gray-500">
                                    <i class="fas fa-video text-2xl mb-2"></i>
                                    <p class="text-sm">No video selected</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Thumbnail Preview -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-3">Thumbnail Preview</h4>
                        <div id="thumbnail-preview" class="w-full h-24 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                            @if(isset($videoSection) && $videoSection->thumbnail)
                                <img src="{{ $videoSection->thumbnail_url }}" alt="Thumbnail" class="w-full h-full object-cover rounded-lg">
                            @else
                                <div class="text-center text-gray-500">
                                    <i class="fas fa-image text-xl mb-1"></i>
                                    <p class="text-xs">No thumbnail</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Video Options - تم تحديث checkboxes بشكل كامل -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-3">Video Options</h4>
                        <div class="space-y-3">
                            <!-- Hidden inputs لإرسال 0 عند عدم التحديد -->
                            <input type="hidden" name="autoplay" value="0">
                            <input type="hidden" name="loop" value="0">
                            <input type="hidden" name="muted" value="0">
                            <input type="hidden" name="controls" value="0">
                            <input type="hidden" name="overlay_enabled" value="0">
                            
                            <label class="flex items-center">
                                <input type="checkbox" name="autoplay" value="1"
                                       {{ old('autoplay', (isset($videoSection) && $videoSection->shouldAutoplay()) ? 1 : 0) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm">Autoplay</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="loop" value="1"
                                       {{ old('loop', (isset($videoSection) && $videoSection->shouldLoop()) ? 1 : 0) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm">Loop</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="muted" value="1"
                                       {{ old('muted', (isset($videoSection) && $videoSection->isMuted()) ? 1 : 1) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm">Muted</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="controls" value="1"
                                       {{ old('controls', (isset($videoSection) && $videoSection->hasControls()) ? 1 : 1) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm">Show Controls</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="overlay_enabled" value="1"
                                       {{ old('overlay_enabled', (isset($videoSection) && $videoSection->isOverlayEnabled()) ? 1 : 0) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm">Enable Overlay</span>
                            </label>
                        </div>
                    </div>

                    <!-- Sort Order -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-3">Display Order</h4>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                            <input type="number" name="sort_order" min="0"
                                   value="{{ old('sort_order', $videoSection->sort_order ?? 0) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 mt-6 pt-6 border-t">
                <a href="{{ route('admin.video-sections.index') }}" 
                   class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Cancel
                </a>
                <button type="submit" id="submit-btn"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="btn-text">{{ isset($videoSection) ? 'Update' : 'Create' }} Video Section</span>
                    <i class="fas fa-spinner fa-spin ml-2 hidden btn-spinner"></i>
                </button>
            </div>

        </form>
    </div>
</div>

<style>
.video-type-option {
    transition: all 0.3s ease;
}

.video-type-option[data-type="upload"].selected {
    border-color: #3b82f6;
    background-color: #eff6ff;
}

.video-type-option[data-type="live_stream"].selected {
    border-color: #ef4444;
    background-color: #fef2f2;
}

.radio-indicator {
    transition: all 0.3s ease;
}

.radio-dot {
    transform: scale(0);
    transition: transform 0.3s ease;
}

.video-type-option.selected .radio-dot {
    transform: scale(1);
}

#upload-progress .bg-blue-600 {
    transition: width 0.3s ease;
}
</style>

<script>
let isSubmitting = false;

function toggleVideoType() {
    const uploadSection = document.getElementById('upload-section');
    const streamSection = document.getElementById('stream-section');
    const uploadRadio = document.querySelector('input[name="video_type"][value="upload"]');
    const liveRadio = document.querySelector('input[name="video_type"][value="live_stream"]');
    const options = document.querySelectorAll('.video-type-option');
    
    // Remove all selected classes
    options.forEach(option => option.classList.remove('selected'));
    
    if (uploadRadio.checked) {
        uploadSection.style.display = 'block';
        streamSection.style.display = 'none';
        document.querySelector('[data-type="upload"]').classList.add('selected');
    } else {
        uploadSection.style.display = 'none';
        streamSection.style.display = 'block';
        document.querySelector('[data-type="live_stream"]').classList.add('selected');
    }
}

function previewVideo(input) {
    const preview = document.getElementById('video-preview');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Check file size (500MB = 524,288,000 bytes)
        if (file.size > 524288000) {
            alert('File size exceeds 500MB limit. Please choose a smaller file.');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <video class="w-full h-full object-cover rounded-lg" controls>
                    <source src="${e.target.result}" type="video/mp4">
                    Your browser does not support video playback.
                </video>
            `;
        }
        reader.readAsDataURL(file);
    }
}

function previewThumbnail(input) {
    const preview = document.getElementById('thumbnail-preview');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Check file size (10MB = 10,485,760 bytes)
        if (file.size > 10485760) {
            alert('Thumbnail size exceeds 10MB limit. Please choose a smaller image.');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Thumbnail preview" class="w-full h-full object-cover rounded-lg">
            `;
        }
        reader.readAsDataURL(file);
    }
}

function closeAlert(alertId) {
    const alert = document.getElementById(alertId);
    if (alert) {
        alert.style.display = 'none';
    }
}

function showLoading() {
    document.getElementById('loading-overlay').classList.remove('hidden');
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = true;
    submitBtn.querySelector('.btn-text').textContent = 'Processing...';
    submitBtn.querySelector('.btn-spinner').classList.remove('hidden');
}

function hideLoading() {
    document.getElementById('loading-overlay').classList.add('hidden');
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = false;
    submitBtn.querySelector('.btn-text').textContent = '{{ isset($videoSection) ? "Update" : "Create" }} Video Section';
    submitBtn.querySelector('.btn-spinner').classList.add('hidden');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleVideoType();
    
    // Form submission handling
    const form = document.getElementById('video-form');
    form.addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }
        
        isSubmitting = true;
        showLoading();
        
        // Validate required fields
        const videoType = document.querySelector('input[name="video_type"]:checked').value;
        const title = document.getElementById('title').value.trim();
        
        if (!title) {
            hideLoading();
            isSubmitting = false;
            alert('Title is required.');
            document.getElementById('title').focus();
            e.preventDefault();
            return false;
        }
        
        if (videoType === 'upload') {
            const hasExistingFile = {{ isset($videoSection) && $videoSection->video_file ? 'true' : 'false' }};
            const videoFile = document.getElementById('video_file').files[0];
            
            if (!hasExistingFile && !videoFile) {
                hideLoading();
                isSubmitting = false;
                alert('Video file is required when type is "Upload File".');
                document.getElementById('video_file').focus();
                e.preventDefault();
                return false;
            }
        } else if (videoType === 'live_stream') {
            const videoUrl = document.getElementById('video_url').value.trim();
            
            if (!videoUrl) {
                hideLoading();
                isSubmitting = false;
                alert('Stream URL is required when type is "Live Stream".');
                document.getElementById('video_url').focus();
                e.preventDefault();
                return false;
            }
        }
        
        // Let form submit naturally
        return true;
    });
    
    // Auto-hide alerts after 10 seconds
    setTimeout(function() {
        const alerts = ['success-alert', 'error-alert'];
        alerts.forEach(function(alertId) {
            closeAlert(alertId);
        });
    }, 10000);
});

// Prevent double submission
window.addEventListener('beforeunload', function(e) {
    if (isSubmitting) {
        e.preventDefault();
        e.returnValue = '';
    }
});
</script>

@endsection