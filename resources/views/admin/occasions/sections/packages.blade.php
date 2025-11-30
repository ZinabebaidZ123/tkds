<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
        <input type="text" name="sections[{{ $section->id }}][title]" 
               value="{{ $section->title ?: 'Choose Your Package' }}" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Section Subtitle</label>
        <input type="text" name="sections[{{ $section->id }}][subtitle]" 
               value="{{ $section->subtitle ?: 'Special Occasion Pricing' }}" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg">
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div class="flex items-center">
            <input type="checkbox" name="sections[{{ $section->id }}][settings][show_discount]" value="1"
                   {{ $section->getSetting('show_discount', true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-primary focus:ring-primary">
            <label class="ml-2 text-sm text-gray-700">Show Discount Badges</label>
        </div>
        <div class="flex items-center">
            <input type="checkbox" name="sections[{{ $section->id }}][settings][highlight_popular]" value="1"
                   {{ $section->getSetting('highlight_popular', true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-primary focus:ring-primary">
            <label class="ml-2 text-sm text-gray-700">Highlight Popular Plan</label>
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Default Pricing Cycle</label>
        <select name="sections[{{ $section->id }}][settings][pricing_cycle]" 
                class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            <option value="monthly" {{ $section->getSetting('pricing_cycle') === 'monthly' ? 'selected' : '' }}>Monthly</option>
            <option value="yearly" {{ $section->getSetting('pricing_cycle') === 'yearly' ? 'selected' : '' }}>Yearly</option>
        </select>
    </div>
</div>