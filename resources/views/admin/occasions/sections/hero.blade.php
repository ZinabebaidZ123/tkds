<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
        <input type="text" name="sections[{{ $section->id }}][title]" value="{{ $section->title }}" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
        <input type="text" name="sections[{{ $section->id }}][subtitle]" value="{{ $section->subtitle }}" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
        <textarea name="sections[{{ $section->id }}][content]" rows="3" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg">{{ $section->content }}</textarea>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
            <input type="text" name="sections[{{ $section->id }}][settings][button_text]" 
                   value="{{ $section->getSetting('button_text', 'Get Started') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Button Link</label>
            <input type="text" name="sections[{{ $section->id }}][settings][button_link]" 
                   value="{{ $section->getSetting('button_link', '#packages') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Background Image</label>
        <input type="file" name="sections[{{ $section->id }}][background_image]" accept="image/*"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg">
        @if($section->getSetting('background_image'))
            <p class="text-sm text-gray-500 mt-1">Current: {{ basename($section->getSetting('background_image')) }}</p>
        @endif
    </div>
</div>