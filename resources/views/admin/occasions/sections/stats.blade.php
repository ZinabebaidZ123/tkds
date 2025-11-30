<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
        <input type="text" name="sections[{{ $section->id }}][title]" 
               value="{{ $section->title ?: 'Success Statistics' }}" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Section Subtitle</label>
        <input type="text" name="sections[{{ $section->id }}][subtitle]" 
               value="{{ $section->subtitle ?: 'Numbers That Speak for Themselves' }}" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg">
    </div>
    
    <div id="stats-container-{{ $section->id }}">
        <label class="block text-sm font-medium text-gray-700 mb-2">Statistics</label>
        @php
            $stats = $section->getSetting('stats', []);
        @endphp
        @forelse($stats as $index => $stat)
            <div class="stat-item border border-gray-200 rounded-lg p-3 mb-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <input type="text" name="sections[{{ $section->id }}][settings][stats][{{ $index }}][number]" 
                               value="{{ $stat['number'] ?? '' }}" placeholder="e.g., 10K+" 
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>
                    <div>
                        <input type="text" name="sections[{{ $section->id }}][settings][stats][{{ $index }}][label]" 
                               value="{{ $stat['label'] ?? '' }}" placeholder="e.g., Happy Customers" 
                               class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>
                </div>
                <button type="button" onclick="removeStat(this)" 
                        class="mt-2 text-red-600 hover:text-red-800 text-sm">
                    <i class="fas fa-trash mr-1"></i> Remove
                </button>
            </div>
        @empty
            <div class="stat-item border border-gray-200 rounded-lg p-3 mb-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <input type="text" name="sections[{{ $section->id }}][settings][stats][0][number]" 
                               placeholder="e.g., 10K+" class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>
                    <div>
                        <input type="text" name="sections[{{ $section->id }}][settings][stats][0][label]" 
                               placeholder="e.g., Happy Customers" class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>
                </div>
                <button type="button" onclick="removeStat(this)" 
                        class="mt-2 text-red-600 hover:text-red-800 text-sm">
                    <i class="fas fa-trash mr-1"></i> Remove
                </button>
            </div>
        @endforelse
    </div>
    
    <button type="button" onclick="addStat({{ $section->id }})" 
            class="w-full py-2 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-primary hover:text-primary transition-colors">
        <i class="fas fa-plus mr-2"></i> Add Statistic
    </button>
</div>