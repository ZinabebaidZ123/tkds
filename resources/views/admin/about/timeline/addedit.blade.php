{{-- Path: resources/views/admin/about/timeline/addedit.blade.php --}}
@extends('admin.layouts.app')

@section('title', isset($timeline) ? 'Edit Timeline Item' : 'Add Timeline Item')
@section('page-title', isset($timeline) ? 'Edit Timeline Item' : 'Add Timeline Item')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.about.timeline.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.about.settings') }}" class="hover:text-primary transition-colors duration-200">About Settings</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('admin.about.timeline.index') }}" class="hover:text-primary transition-colors duration-200">Timeline</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($timeline) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($timeline) ? 'Edit' : 'Add New' }} Timeline Milestone
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ isset($timeline) ? 'Update the' : 'Create a new' }} milestone for the company timeline</p>
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
                        <i class="fas fa-history mr-2 text-blue-500"></i>
                        Milestone Details
                    </h3>
                </div>
                
                <form action="{{ isset($timeline) ? route('admin.about.timeline.update', $timeline) : route('admin.about.timeline.store') }}" 
                      method="POST" class="p-6 space-y-6" id="timelineForm">
                    @csrf
                    @if(isset($timeline))
                        @method('PUT')
                    @endif
                    
                    <!-- Year & Title -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label for="year" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-calendar mr-2 text-primary"></i>
                                Year
                            </label>
                            <input type="text" 
                                   id="year" 
                                   name="year" 
                                   value="{{ old('year', $timeline->year ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('year') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="2024"
                                   required>
                            @error('year')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2 space-y-2">
                            <label for="title" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-heading mr-2 text-primary"></i>
                                Title
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $timeline->title ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('title') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="Company Founded"
                                   required>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
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
                                  placeholder="Describe this milestone and its significance..."
                                  required>{{ old('description', $timeline->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Explain what happened during this milestone and why it was important</p>
                    </div>

                    <!-- Color & Position -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="color" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-palette mr-2 text-primary"></i>
                                Color Theme
                            </label>
                            <select id="color" 
                                    name="color" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('color') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="primary" {{ old('color', $timeline->color ?? 'primary') === 'primary' ? 'selected' : '' }}>🔴 Primary (Red)</option>
                                <option value="secondary" {{ old('color', $timeline->color ?? '') === 'secondary' ? 'selected' : '' }}>🟠 Secondary (Orange)</option>
                                <option value="accent" {{ old('color', $timeline->color ?? '') === 'accent' ? 'selected' : '' }}>🟡 Accent (Yellow)</option>
                            </select>
                            @error('color')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="position" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-arrows-alt-h mr-2 text-primary"></i>
                                Timeline Position
                            </label>
                            <select id="position" 
                                    name="position" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('position') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="left" {{ old('position', $timeline->position ?? 'left') === 'left' ? 'selected' : '' }}>
                                    ⬅️ Left Side
                                </option>
                                <option value="right" {{ old('position', $timeline->position ?? '') === 'right' ? 'selected' : '' }}>
                                    ➡️ Right Side
                                </option>
                            </select>
                            @error('position')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Choose which side of the timeline this item appears on</p>
                        </div>
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
                                   value="{{ old('sort_order', $timeline->sort_order ?? 1) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('sort_order') border-red-500 ring-2 ring-red-200 @enderror"
                                   required>
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Lower numbers appear first in the timeline</p>
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
                                <option value="active" {{ old('status', $timeline->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                    ✅ Active (Visible in timeline)
                                </option>
                                <option value="inactive" {{ old('status', $timeline->status ?? '') === 'inactive' ? 'selected' : '' }}>
                                    ❌ Inactive (Hidden from timeline)
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
                        <a href="{{ route('admin.about.timeline.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                                id="submitBtn">
                            <i class="fas fa-save mr-2"></i>
                            <span>{{ isset($timeline) ? 'Update' : 'Create' }} Milestone</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Sidebar with Preview -->
        <div class="space-y-6">
            
            <!-- Live Preview Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-eye mr-2 text-blue-600"></i>
                        Timeline Preview
                    </h3>
                </div>
                <div class="p-6">
                    <!-- Timeline Preview -->
                    <div class="relative">
                        <!-- Timeline Line -->
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-primary via-secondary to-accent rounded-full"></div>
                        
                        <!-- Timeline Item Preview -->
                        <div class="flex items-center relative">
                            <div id="preview-content-left" class="w-1/2 pr-4 text-right">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <h4 id="preview-year" class="text-lg font-bold text-gray-900 mb-2">{{ $timeline->year ?? '2024' }}</h4>
                                    <h5 id="preview-title" class="text-md font-semibold text-primary mb-2">{{ $timeline->title ?? 'Your Title Here' }}</h5>
                                    <p id="preview-description" class="text-gray-600 text-sm">{{ $timeline->description ?? 'Your description will appear here' }}</p>
                                </div>
                            </div>
                            <div id="preview-dot" class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-primary rounded-full border-4 border-white shadow"></div>
                            <div id="preview-content-right" class="w-1/2 pl-4" style="display: none;">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $timeline->year ?? '2024' }}</h4>
                                    <h5 class="text-md font-semibold text-primary mb-2">{{ $timeline->title ?? 'Your Title Here' }}</h5>
                                    <p class="text-gray-600 text-sm">{{ $timeline->description ?? 'Your description will appear here' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4 text-center">This is how your milestone will appear in the timeline</p>
                </div>
            </div>
            
            <!-- Timeline Tips Card -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl border border-yellow-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-yellow-200">
                    <h3 class="text-lg font-semibold text-yellow-800 flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Timeline Tips
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Chronological Order</p>
                            <p class="text-xs text-gray-600">Order your milestones chronologically using sort order</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Balance Positions</p>
                            <p class="text-xs text-gray-600">Alternate between left and right for visual balance</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Key Moments</p>
                            <p class="text-xs text-gray-600">Focus on major milestones that shaped your company</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Consistent Style</p>
                            <p class="text-xs text-gray-600">Use similar description lengths for better visual flow</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Card -->
            @if(isset($timeline))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        Milestone Stats
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Created</span>
                        <span class="text-sm font-medium text-gray-900">{{ $timeline->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $timeline->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $timeline->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($timeline->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Position</span>
                        <span class="text-sm font-medium text-gray-900 capitalize">
                            <i class="fas fa-arrow-{{ $timeline->position }} mr-1"></i>
                            {{ $timeline->position }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Display Order</span>
                        <span class="text-sm font-medium text-gray-900">#{{ $timeline->sort_order }}</span>
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
// Live preview updates
document.getElementById('year').addEventListener('input', function() {
    document.getElementById('preview-year').textContent = this.value || '2024';
});

document.getElementById('title').addEventListener('input', function() {
    document.getElementById('preview-title').textContent = this.value || 'Your Title Here';
});

document.getElementById('description').addEventListener('input', function() {
    document.getElementById('preview-description').textContent = this.value || 'Your description will appear here';
});

// Update preview position and color
function updatePreview() {
    const position = document.getElementById('position').value;
    const color = document.getElementById('color').value;
    
    const leftContent = document.getElementById('preview-content-left');
    const rightContent = document.getElementById('preview-content-right');
    const dot = document.getElementById('preview-dot');
    
    // Update position
    if (position === 'left') {
        leftContent.style.display = 'block';
        rightContent.style.display = 'none';
    } else {
        leftContent.style.display = 'none';
        rightContent.style.display = 'block';
    }
    
    // Update color
    const colorClasses = {
        'primary': 'bg-primary',
        'secondary': 'bg-secondary',
        'accent': 'bg-accent'
    };
    
    dot.className = `absolute left-1/2 transform -translate-x-1/2 w-4 h-4 ${colorClasses[color]} rounded-full border-4 border-white shadow`;
}

// Add event listeners for position and color changes
document.getElementById('position').addEventListener('change', updatePreview);
document.getElementById('color').addEventListener('change', updatePreview);

// Form submission with loading state
document.getElementById('timelineForm').addEventListener('submit', function() {
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
addCharacterCounter('title', 100);
addCharacterCounter('description', 300);

// Initialize preview on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePreview();
});

// Auto-suggest years
const currentYear = new Date().getFullYear();
const yearInput = document.getElementById('year');
const yearSuggestions = [];

for (let i = currentYear; i >= currentYear - 50; i--) {
    yearSuggestions.push(i.toString());
}

// Add datalist for year suggestions
const datalist = document.createElement('datalist');
datalist.id = 'year-suggestions';
yearSuggestions.forEach(year => {
    const option = document.createElement('option');
    option.value = year;
    datalist.appendChild(option);
});

yearInput.setAttribute('list', 'year-suggestions');
document.body.appendChild(datalist);
</script>
@endpush