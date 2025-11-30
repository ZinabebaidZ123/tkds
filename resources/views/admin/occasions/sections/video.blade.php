<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
        <input type="text" name="sections[{{ $section->id }}][title]" 
               value="{{ $section->title ?: 'Watch Our Story' }}" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Video URL</label>
        <input type="url" name="sections[{{ $section->id }}][settings][video_url]" 
               value="{{ $section->getSetting('video_url') }}" 
               placeholder="Enter video URL (YouTube, Vimeo, or direct MP4/M3U8)"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg">
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div class="flex items-center">
            <input type="checkbox" name="sections[{{ $section->id }}][settings][autoplay]" value="1"
                   {{ $section->getSetting('autoplay', false) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-primary focus:ring-primary">
            <label class="ml-2 text-sm text-gray-700">Autoplay</label>
        </div>
        <div class="flex items-center">
            <input type="checkbox" name="sections[{{ $section->id }}][settings][controls]" value="1"
                   {{ $section->getSetting('controls', true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-primary focus:ring-primary">
            <label class="ml-2 text-sm text-gray-700">Show Controls</label>
        </div>
    </div>
</div>