<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
        <input type="text" name="sections[{{ $section->id }}][title]" 
               value="{{ $section->title }}" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg">
    </div>
    
    <div id="dynamic-elements-{{ $section->id }}">
        <label class="block text-sm font-medium text-gray-700 mb-2">Content Elements</label>
        @php
            $elements = $section->getSetting('elements', []);
        @endphp
        @forelse($elements as $index => $element)
            <div class="element-item border border-gray-200 rounded-lg p-4 mb-3">
                <div class="flex justify-between items-center mb-3">
                    <select name="sections[{{ $section->id }}][settings][elements][{{ $index }}][type]" 
                            class="px-3 py-2 border border-gray-300 rounded">
                        <option value="heading" {{ ($element['type'] ?? '') === 'heading' ? 'selected' : '' }}>Heading</option>
                        <option value="paragraph" {{ ($element['type'] ?? '') === 'paragraph' ? 'selected' : '' }}>Paragraph</option>
                        <option value="list" {{ ($element['type'] ?? '') === 'list' ? 'selected' : '' }}>List</option>
                        <option value="image" {{ ($element['type'] ?? '') === 'image' ? 'selected' : '' }}>Image</option>
                        <option value="button" {{ ($element['type'] ?? '') === 'button' ? 'selected' : '' }}>Button</option>
                    </select>
                    <button type="button" onclick="removeElement(this)" 
                            class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                
                <div class="space-y-2">
                    <input type="text" name="sections[{{ $section->id }}][settings][elements][{{ $index }}][content]" 
                           value="{{ $element['content'] ?? '' }}" placeholder="Content" 
                           class="w-full px-3 py-2 border border-gray-300 rounded">
                    <input type="text" name="sections[{{ $section->id }}][settings][elements][{{ $index }}][link]" 
                           value="{{ $element['link'] ?? '' }}" placeholder="Link (for buttons/images)" 
                           class="w-full px-3 py-2 border border-gray-300 rounded">
                </div>
            </div>
        @empty
            <div class="element-item border border-gray-200 rounded-lg p-4 mb-3">
                <div class="flex justify-between items-center mb-3">
                    <select name="sections[{{ $section->id }}][settings][elements][0][type]" 
                            class="px-3 py-2 border border-gray-300 rounded">
                        <option value="heading">Heading</option>
                        <option value="paragraph">Paragraph</option>
                        <option value="list">List</option>
                        <option value="image">Image</option>
                        <option value="button">Button</option>
                    </select>
                    <button type="button" onclick="removeElement(this)" 
                            class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                
                <div class="space-y-2">
                    <input type="text" name="sections[{{ $section->id }}][settings][elements][0][content]" 
                           placeholder="Content" class="w-full px-3 py-2 border border-gray-300 rounded">
                    <input type="text" name="sections[{{ $section->id }}][settings][elements][0][link]" 
                           placeholder="Link (for buttons/images)" class="w-full px-3 py-2 border border-gray-300 rounded">
                </div>
            </div>
        @endforelse
    </div>
    
    <button type="button" onclick="addElement({{ $section->id }})" 
            class="w-full py-2 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-primary hover:text-primary transition-colors">
        <i class="fas fa-plus mr-2"></i> Add Element
    </button>
</div>

<script>
function toggleServiceSelection(checkbox, sectionId) {
    const container = document.getElementById(`service-selection-${sectionId}`);
    if (checkbox.checked) {
        container.classList.add('hidden');
    } else {
        container.classList.remove('hidden');
    }
}

function addStat(sectionId) {
    const container = document.getElementById(`stats-container-${sectionId}`);
    const items = container.querySelectorAll('.stat-item');
    const newIndex = items.length;
    
    const newItem = document.createElement('div');
    newItem.className = 'stat-item border border-gray-200 rounded-lg p-3 mb-3';
    newItem.innerHTML = `
        <div class="grid grid-cols-2 gap-3">
            <div>
                <input type="text" name="sections[${sectionId}][settings][stats][${newIndex}][number]" 
                       placeholder="e.g., 10K+" class="w-full px-3 py-2 border border-gray-300 rounded">
            </div>
            <div>
                <input type="text" name="sections[${sectionId}][settings][stats][${newIndex}][label]" 
                       placeholder="e.g., Happy Customers" class="w-full px-3 py-2 border border-gray-300 rounded">
            </div>
        </div>
        <button type="button" onclick="removeStat(this)" 
                class="mt-2 text-red-600 hover:text-red-800 text-sm">
            <i class="fas fa-trash mr-1"></i> Remove
        </button>
    `;
    
    container.insertBefore(newItem, container.lastElementChild);
}

function removeStat(button) {
    button.closest('.stat-item').remove();
}

function addElement(sectionId) {
    const container = document.getElementById(`dynamic-elements-${sectionId}`);
    const items = container.querySelectorAll('.element-item');
    const newIndex = items.length;
    
    const newItem = document.createElement('div');
    newItem.className = 'element-item border border-gray-200 rounded-lg p-4 mb-3';
    newItem.innerHTML = `
        <div class="flex justify-between items-center mb-3">
            <select name="sections[${sectionId}][settings][elements][${newIndex}][type]" 
                    class="px-3 py-2 border border-gray-300 rounded">
                <option value="heading">Heading</option>
                <option value="paragraph">Paragraph</option>
                <option value="list">List</option>
                <option value="image">Image</option>
                <option value="button">Button</option>
            </select>
            <button type="button" onclick="removeElement(this)" 
                    class="text-red-600 hover:text-red-800">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        
        <div class="space-y-2">
            <input type="text" name="sections[${sectionId}][settings][elements][${newIndex}][content]" 
                   placeholder="Content" class="w-full px-3 py-2 border border-gray-300 rounded">
            <input type="text" name="sections[${sectionId}][settings][elements][${newIndex}][link]" 
                   placeholder="Link (for buttons/images)" class="w-full px-3 py-2 border border-gray-300 rounded">
        </div>
    `;
    
    container.insertBefore(newItem, container.lastElementChild);
}

function removeElement(button) {
    button.closest('.element-item').remove();
}
</script>