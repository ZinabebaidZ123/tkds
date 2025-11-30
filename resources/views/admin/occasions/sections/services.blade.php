<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
        <input type="text" name="sections[{{ $section->id }}][title]" 
               value="{{ $section->title ?: 'Our Services' }}" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Section Subtitle</label>
        <input type="text" name="sections[{{ $section->id }}][subtitle]" 
               value="{{ $section->subtitle ?: 'Professional Services for Your Success' }}" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg">
    </div>
    <div class="flex items-center mb-4">
        <input type="checkbox" name="sections[{{ $section->id }}][settings][show_all]" value="1"
               {{ $section->getSetting('show_all', false) ? 'checked' : '' }}
               class="rounded border-gray-300 text-primary focus:ring-primary"
               onchange="toggleServiceSelection(this, {{ $section->id }})">
        <label class="ml-2 text-sm text-gray-700">Show All Services</label>
    </div>
    <div id="service-selection-{{ $section->id }}" class="{{ $section->getSetting('show_all') ? 'hidden' : '' }}">
        <label class="block text-sm font-medium text-gray-700 mb-2">Select Services to Display</label>
        <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-3">
            @php
                $selectedServices = $section->getSetting('selected_services', []);
            @endphp
            @foreach($services as $service)
                <div class="flex items-center">
                    <input type="checkbox" name="sections[{{ $section->id }}][settings][selected_services][]" 
                           value="{{ $service->id }}" {{ in_array($service->id, $selectedServices) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-primary focus:ring-primary">
                    <label class="ml-2 text-sm text-gray-700">{{ $service->title }}</label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">More Button Text</label>
            <input type="text" name="sections[{{ $section->id }}][settings][more_button_text]" 
                   value="{{ $section->getSetting('more_button_text', 'View All Services') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">More Button Link</label>
            <input type="text" name="sections[{{ $section->id }}][settings][more_button_link]" 
                   value="{{ $section->getSetting('more_button_link', '/services') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
        </div>
    </div>
</div>
