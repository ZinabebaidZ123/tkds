{{-- Path: resources/views/admin/about/values/addedit.blade.php --}}
@extends('admin.layouts.app')

@section('title', isset($value) ? 'Edit Value' : 'Add Value')
@section('page-title', isset($value) ? 'Edit Value' : 'Add Value')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.about.values.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.about.settings') }}" class="hover:text-primary transition-colors duration-200">About Settings</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('admin.about.values.index') }}" class="hover:text-primary transition-colors duration-200">Values</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($value) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($value) ? 'Edit' : 'Add New' }} Core Value
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ isset($value) ? 'Update the' : 'Create a new' }} core value for the About page</p>
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
                        <i class="fas fa-heart mr-2 text-red-500"></i>
                        Value Details
                    </h3>
                </div>
                
                <form action="{{ isset($value) ? route('admin.about.values.update', $value) : route('admin.about.values.store') }}" 
                      method="POST" class="p-6 space-y-6" id="valueForm">
                    @csrf
                    @if(isset($value))
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
                               value="{{ old('title', $value->title ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('title') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="Enter value title (e.g., Innovation)"
                               required>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Keep it short and impactful - one or two words work best</p>
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
                                  placeholder="Describe what this value means to your company..."
                                  required>{{ old('description', $value->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Explain how this value guides your company's actions and decisions</p>
                    </div>

                    <!-- Icon Selection -->
                    <div class="space-y-2">
                        <label for="icon" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-icons mr-2 text-primary"></i>
                            Icon Class
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="icon" 
                                   name="icon" 
                                   value="{{ old('icon', $value->icon ?? 'fas fa-lightbulb') }}"
                                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('icon') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="fas fa-lightbulb"
                                   required>
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                <i id="icon-preview" class="{{ old('icon', $value->icon ?? 'fas fa-lightbulb') }} text-gray-400"></i>
                            </div>
                        </div>
                        @error('icon')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        
                        <!-- Popular Icons -->
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-3">Popular Icons:</p>
                            <div class="grid grid-cols-6 sm:grid-cols-8 gap-3">
                                @php
                                    $popularIcons = [
                                        'fas fa-lightbulb' => 'Innovation',
                                        'fas fa-shield-alt' => 'Security',
                                        'fas fa-heart' => 'Care',
                                        'fas fa-rocket' => 'Growth',
                                        'fas fa-users' => 'Teamwork',
                                        'fas fa-target' => 'Focus',
                                        'fas fa-star' => 'Excellence',
                                        'fas fa-handshake' => 'Trust',
                                        'fas fa-cog' => 'Efficiency',
                                        'fas fa-trophy' => 'Success',
                                        'fas fa-compass' => 'Direction',
                                        'fas fa-gem' => 'Quality',
                                        'fas fa-balance-scale' => 'Justice',
                                        'fas fa-graduation-cap' => 'Learning',
                                        'fas fa-globe' => 'Global',
                                        'fas fa-leaf' => 'Sustainability'
                                    ];
                                @endphp
                                @foreach($popularIcons as $iconClass => $iconName)
                                    <button type="button" 
                                            onclick="selectIcon('{{ $iconClass }}')"
                                            class="p-3 border border-gray-200 rounded-lg hover:border-primary hover:bg-primary/5 transition-all duration-200 text-center group"
                                            title="{{ $iconName }}">
                                        <i class="{{ $iconClass }} text-gray-600 group-hover:text-primary"></i>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Colors -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="color_from" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-palette mr-2 text-primary"></i>
                                Gradient Start Color
                            </label>
                            <select id="color_from" 
                                    name="color_from" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('color_from') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="primary" {{ old('color_from', $value->color_from ?? 'primary') === 'primary' ? 'selected' : '' }}>🔴 Primary (Red)</option>
                                <option value="secondary" {{ old('color_from', $value->color_from ?? '') === 'secondary' ? 'selected' : '' }}>🟠 Secondary (Orange)</option>
                                <option value="accent" {{ old('color_from', $value->color_from ?? '') === 'accent' ? 'selected' : '' }}>🟡 Accent (Yellow)</option>
                                <option value="blue-500" {{ old('color_from', $value->color_from ?? '') === 'blue-500' ? 'selected' : '' }}>🔵 Blue</option>
                                <option value="green-500" {{ old('color_from', $value->color_from ?? '') === 'green-500' ? 'selected' : '' }}>🟢 Green</option>
                                <option value="purple-500" {{ old('color_from', $value->color_from ?? '') === 'purple-500' ? 'selected' : '' }}>🟣 Purple</option>
                                <option value="pink-500" {{ old('color_from', $value->color_from ?? '') === 'pink-500' ? 'selected' : '' }}>🩷 Pink</option>
                                <option value="indigo-500" {{ old('color_from', $value->color_from ?? '') === 'indigo-500' ? 'selected' : '' }}>💙 Indigo</option>
                            </select>
                            @error('color_from')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="color_to" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-palette mr-2 text-primary"></i>
                                Gradient End Color
                            </label>
                            <select id="color_to" 
                                    name="color_to" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('color_to') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="secondary" {{ old('color_to', $value->color_to ?? 'secondary') === 'secondary' ? 'selected' : '' }}>🟠 Secondary (Orange)</option>
                                <option value="primary" {{ old('color_to', $value->color_to ?? '') === 'primary' ? 'selected' : '' }}>🔴 Primary (Red)</option>
                                <option value="accent" {{ old('color_to', $value->color_to ?? '') === 'accent' ? 'selected' : '' }}>🟡 Accent (Yellow)</option>
                                <option value="blue-600" {{ old('color_to', $value->color_to ?? '') === 'blue-600' ? 'selected' : '' }}>🔵 Blue Dark</option>
                                <option value="green-600" {{ old('color_to', $value->color_to ?? '') === 'green-600' ? 'selected' : '' }}>🟢 Green Dark</option>
                                <option value="purple-600" {{ old('color_to', $value->color_to ?? '') === 'purple-600' ? 'selected' : '' }}>🟣 Purple Dark</option>
                                <option value="pink-600" {{ old('color_to', $value->color_to ?? '') === 'pink-600' ? 'selected' : '' }}>🩷 Pink Dark</option>
                                <option value="indigo-600" {{ old('color_to', $value->color_to ?? '') === 'indigo-600' ? 'selected' : '' }}>💙 Indigo Dark</option>
                            </select>
                            @error('color_to')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
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
                                   value="{{ old('sort_order', $value->sort_order ?? 1) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('sort_order') border-red-500 ring-2 ring-red-200 @enderror"
                                   required>
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Lower numbers appear first on the page</p>
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
                                <option value="active" {{ old('status', $value->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                    ✅ Active (Visible on About page)
                                </option>
                                <option value="inactive" {{ old('status', $value->status ?? '') === 'inactive' ? 'selected' : '' }}>
                                    ❌ Inactive (Hidden from About page)
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
                        <a href="{{ route('admin.about.values.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                                id="submitBtn">
                            <i class="fas fa-save mr-2"></i>
                            <span>{{ isset($value) ? 'Update' : 'Create' }} Value</span>
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
                        Live Preview
                    </h3>
                </div>
                <div class="p-6">
                    <div class="text-center group">
                        <div id="preview-icon" class="w-20 h-20 bg-gradient-to-r from-primary to-secondary rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i id="preview-icon-element" class="fas fa-lightbulb text-white text-2xl"></i>
                        </div>
                        <h4 id="preview-title" class="text-xl font-bold text-gray-900 mb-4">{{ $value->title ?? 'Innovation' }}</h4>
                        <p id="preview-description" class="text-gray-600">{{ $value->description ?? 'Your description will appear here' }}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-4 text-center">This is how your value will appear on the About page</p>
                </div>
            </div>
            
            <!-- Tips Card -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl border border-yellow-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-yellow-200">
                    <h3 class="text-lg font-semibold text-yellow-800 flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Writing Tips
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Keep Titles Short</p>
                            <p class="text-xs text-gray-600">One or two words work best (Innovation, Trust, Quality)</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Focus on Impact</p>
                            <p class="text-xs text-gray-600">Explain how this value affects your work and customers</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Choose Meaningful Icons</p>
                            <p class="text-xs text-gray-600">Select icons that visually represent your value's essence</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Color Harmony</p>
                            <p class="text-xs text-gray-600">Use complementary colors that match your brand</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Card -->
            @if(isset($value))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        Value Stats
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Created</span>
                        <span class="text-sm font-medium text-gray-900">{{ $value->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $value->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $value->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($value->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Display Order</span>
                        <span class="text-sm font-medium text-gray-900">#{{ $value->sort_order }}</span>
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
// Icon selection function
function selectIcon(iconClass) {
    document.getElementById('icon').value = iconClass;
    document.getElementById('icon-preview').className = iconClass + ' text-gray-400';
    updatePreview();
}

// Icon preview update
document.getElementById('icon').addEventListener('input', function() {
    const iconClass = this.value || 'fas fa-question';
    document.getElementById('icon-preview').className = iconClass + ' text-gray-400';
    updatePreview();
});

// Live preview updates
document.getElementById('title').addEventListener('input', function() {
    document.getElementById('preview-title').textContent = this.value || 'Value Title';
});

document.getElementById('description').addEventListener('input', function() {
    document.getElementById('preview-description').textContent = this.value || 'Your description will appear here';
});

// Update preview colors and icon
function updatePreview() {
    const colorFrom = document.getElementById('color_from').value;
    const colorTo = document.getElementById('color_to').value;
    const icon = document.getElementById('icon').value;
    
    const previewIcon = document.getElementById('preview-icon');
    const previewIconElement = document.getElementById('preview-icon-element');
    
    // Update gradient classes
    previewIcon.className = `w-20 h-20 bg-gradient-to-r from-${colorFrom} to-${colorTo} rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300`;
    
    // Update icon
    previewIconElement.className = `${icon} text-white text-2xl`;
}

// Add event listeners for color changes
document.getElementById('color_from').addEventListener('change', updatePreview);
document.getElementById('color_to').addEventListener('change', updatePreview);

// Form submission with loading state
document.getElementById('valueForm').addEventListener('submit', function() {
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
addCharacterCounter('description', 500);

// Initialize preview on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePreview();
});
</script>
@endpush