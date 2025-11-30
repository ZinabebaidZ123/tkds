@extends('admin.layouts.app')

@section('title', isset($card) ? 'Edit Perfect For Card' : 'Add Perfect For Card')
@section('page-title', isset($card) ? 'Edit Perfect For Card' : 'Add Perfect For Card')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.perfect-for-cards.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.perfect-for-cards.index') }}" class="hover:text-primary transition-colors duration-200">Perfect For Cards</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($card) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($card) ? 'Edit' : 'Add New' }} Perfect For Card
                </h2>
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
                        Card Details
                    </h3>
                </div>
                
                <form action="{{ isset($card) ? route('admin.perfect-for-cards.update', $card) : route('admin.perfect-for-cards.store') }}" 
                      method="POST" class="p-6 space-y-6">
                    @csrf
                    @if(isset($card))
                        @method('PUT')
                    @endif
                    
                    <!-- Title -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-heading mr-2 text-primary"></i>
                            Card Title
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $card->title ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('title') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="e.g., Speakers"
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
                            Card Subtitle
                        </label>
                        <input type="text" 
                               id="subtitle" 
                               name="subtitle" 
                               value="{{ old('subtitle', $card->subtitle ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('subtitle') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="e.g., Trainers & Coaches"
                               required>
                        @error('subtitle')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Icon -->
                    <div class="space-y-2">
                        <label for="icon" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-icons mr-2 text-primary"></i>
                            FontAwesome Icon (Optional)
                        </label>
                        <input type="text" 
                               id="icon" 
                               name="icon" 
                               value="{{ old('icon', $card->icon ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('icon') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="e.g., fas fa-microphone">
                        @error('icon')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Use FontAwesome classes like "fas fa-microphone"</p>
                    </div>

                    <!-- Colors -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="space-y-2">
                            <label for="background_color" class="block text-sm font-semibold text-gray-700">
                                Background Color
                            </label>
                            <input type="color" 
                                   id="background_color" 
                                   name="background_color" 
                                   value="{{ old('background_color', $card->background_color ?? '#C53030') }}"
                                   class="w-full h-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary"
                                   required>
                        </div>

                        <div class="space-y-2">
                            <label for="text_color" class="block text-sm font-semibold text-gray-700">
                                Text Color
                            </label>
                            <input type="color" 
                                   id="text_color" 
                                   name="text_color" 
                                   value="{{ old('text_color', $card->text_color ?? '#ffffff') }}"
                                   class="w-full h-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary"
                                   required>
                        </div>

                        <div class="space-y-2">
                            <label for="border_color" class="block text-sm font-semibold text-gray-700">
                                Border Color
                            </label>
                            <input type="color" 
                                   id="border_color" 
                                   name="border_color" 
                                   value="{{ old('border_color', $card->border_color ?? '#E53E3E') }}"
                                   class="w-full h-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary"
                                   required>
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
                                   value="{{ old('sort_order', $card->sort_order ?? 1) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('sort_order') border-red-500 ring-2 ring-red-200 @enderror"
                                   required>
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
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
                                <option value="active" {{ old('status', $card->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                    ✅ Active (Visible in rotation)
                                </option>
                                <option value="inactive" {{ old('status', $card->status ?? '') === 'inactive' ? 'selected' : '' }}>
                                    ❌ Inactive (Hidden from rotation)
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
                        <a href="{{ route('admin.perfect-for-cards.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            <span>{{ isset($card) ? 'Update' : 'Create' }} Card</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Sidebar Preview -->
        <div class="space-y-6">
            
            <!-- Live Preview -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-eye mr-2 text-blue-600"></i>
                        Live Preview
                    </h3>
                </div>
                <div class="p-6">
                    <div id="card-preview" 
                         class="w-full h-32 rounded-xl border-2 flex flex-col items-center justify-center text-center transition-all duration-300"
                         style="background-color: {{ $card->background_color ?? '#C53030' }}; 
                                color: {{ $card->text_color ?? '#ffffff' }}; 
                                border-color: {{ $card->border_color ?? '#E53E3E' }};">
                        <div class="preview-icon text-2xl mb-2">
                            <i class="{{ $card->icon ?? 'fas fa-star' }}"></i>
                        </div>
                        <div class="preview-title text-lg font-bold">{{ $card->title ?? 'Card Title' }}</div>
                        <div class="preview-subtitle text-sm opacity-80">{{ $card->subtitle ?? 'Card Subtitle' }}</div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center">This is how your card will appear</p>
                </div>
            </div>
            
            <!-- Icon Helper -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl border border-yellow-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-yellow-200">
                    <h3 class="text-lg font-semibold text-yellow-800 flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Icon Examples
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-microphone text-primary"></i>
                            <code class="text-xs bg-white px-2 py-1 rounded">fas fa-microphone</code>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-video text-primary"></i>
                            <code class="text-xs bg-white px-2 py-1 rounded">fas fa-video</code>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-building text-primary"></i>
                            <code class="text-xs bg-white px-2 py-1 rounded">fas fa-building</code>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-users text-primary"></i>
                            <code class="text-xs bg-white px-2 py-1 rounded">fas fa-users</code>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-graduation-cap text-primary"></i>
                            <code class="text-xs bg-white px-2 py-1 rounded">fas fa-graduation-cap</code>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-broadcast-tower text-primary"></i>
                            <code class="text-xs bg-white px-2 py-1 rounded">fas fa-broadcast-tower</code>
                        </div>
                    </div>
                    <p class="text-xs text-yellow-700 mt-3">
                        Find more icons at <a href="https://fontawesome.com/icons" target="_blank" class="underline">FontAwesome.com</a>
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const subtitleInput = document.getElementById('subtitle');
    const iconInput = document.getElementById('icon');
    const backgroundColorInput = document.getElementById('background_color');
    const textColorInput = document.getElementById('text_color');
    const borderColorInput = document.getElementById('border_color');
    
    const preview = document.getElementById('card-preview');
    const previewTitle = preview.querySelector('.preview-title');
    const previewSubtitle = preview.querySelector('.preview-subtitle');
    const previewIcon = preview.querySelector('.preview-icon i');

    // Update preview when inputs change
    function updatePreview() {
        previewTitle.textContent = titleInput.value || 'Card Title';
        previewSubtitle.textContent = subtitleInput.value || 'Card Subtitle';
        
        if (iconInput.value) {
            previewIcon.className = iconInput.value;
        } else {
            previewIcon.className = 'fas fa-star';
        }
        
        preview.style.backgroundColor = backgroundColorInput.value;
        preview.style.color = textColorInput.value;
        preview.style.borderColor = borderColorInput.value;
    }

    // Add event listeners
    titleInput.addEventListener('input', updatePreview);
    subtitleInput.addEventListener('input', updatePreview);
    iconInput.addEventListener('input', updatePreview);
    backgroundColorInput.addEventListener('input', updatePreview);
    textColorInput.addEventListener('input', updatePreview);
    borderColorInput.addEventListener('input', updatePreview);
});
</script>
@endpush