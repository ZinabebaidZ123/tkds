@extends('admin.layouts.app')

@section('title', 'Sales Page Management')
@section('page-title', 'Sales Page Management')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Sales Page Management</h1>
            <p class="mt-2 text-gray-600">Manage all sections of the special occasions sales page</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.occasions.create') }}" 
               class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add New Section
            </a>
            <a href="{{ route('occasions') }}" target="_blank"
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-external-link-alt mr-2"></i>
                Preview Page
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-layer-group text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Sections</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $sections->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Active Sections</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $sections->where('is_active', 1)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-eye-slash text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Inactive Sections</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $sections->where('is_active', 0)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-percentage text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Max Discount</p>
                    <p class="text-2xl font-bold text-gray-900">80%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sections List -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Page Sections</h3>
            <div class="flex items-center space-x-2">
                <button onclick="enableSortMode()" id="sortBtn"
                        class="bg-gray-100 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-200">
                    <i class="fas fa-sort mr-1"></i>
                    Enable Sort
                </button>
                <button onclick="saveSortOrder()" id="saveBtn" style="display: none;"
                        class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                    <i class="fas fa-save mr-1"></i>
                    Save Order
                </button>
            </div>
        </div>
    </div>

    <div id="sections-list" class="divide-y divide-gray-200">
        @foreach($sections as $section)
        <div class="section-item p-6 hover:bg-gray-50" data-id="{{ $section->id }}" data-sort="{{ $section->sort_order }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Drag Handle (hidden by default) -->
                    <div class="drag-handle hidden cursor-move">
                        <i class="fas fa-grip-vertical text-gray-400"></i>
                    </div>

                    <!-- Section Info -->
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            @php
                            $sectionIcons = [
                                'header' => 'fas fa-header',
                                'hero' => 'fas fa-star',
                                'why_choose' => 'fas fa-heart',
                                'services' => 'fas fa-cogs',
                                'packages' => 'fas fa-boxes',
                                'products' => 'fas fa-shopping-bag',
                                'video' => 'fas fa-video',
                                'clients' => 'fas fa-handshake',
                                'reviews' => 'fas fa-comments',
                                'contact' => 'fas fa-envelope',
                                'footer' => 'fas fa-columns'
                            ];
                            $iconClass = $sectionIcons[$section->section_type] ?? 'fas fa-layer-group';
                            @endphp
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="{{ $iconClass }} text-gray-600"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">{{ $section->section_title }}</h4>
                            <p class="text-sm text-gray-500">
                                Type: <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $section->section_type)) }}</span>
                                @if($section->section_subtitle)
                                • {{ Str::limit($section->section_subtitle, 50) }}
                                @endif
                            </p>
                            <div class="flex items-center mt-2 space-x-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $section->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $section->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <span class="text-xs text-gray-500">Order: {{ $section->sort_order }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-2">
                    <!-- Status Toggle -->
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="status-toggle sr-only" 
                               {{ $section->is_active ? 'checked' : '' }}
                               onchange="toggleStatus({{ $section->id }}, this)">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>

                    <!-- Action Buttons -->
                    <a href="{{ route('admin.occasions.show', $section->id) }}"
                       class="text-blue-600 hover:text-blue-800 p-2" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.occasions.edit', $section->id) }}"
                       class="text-green-600 hover:text-green-800 p-2" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="duplicateSection({{ $section->id }})"
                            class="text-yellow-600 hover:text-yellow-800 p-2" title="Duplicate">
                        <i class="fas fa-copy"></i>
                    </button>
                    <button onclick="deleteSection({{ $section->id }})"
                            class="text-red-600 hover:text-red-800 p-2" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach

        @if($sections->isEmpty())
        <!-- Quick Add Section Cards when empty -->
        <div class="p-12">
            <h3 class="text-lg font-medium text-gray-900 mb-8 text-center">No sections found - Create your first sections</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Why Choose Us Card -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-lg border-2 border-dashed border-blue-300 hover:border-blue-400 transition-all duration-200 cursor-pointer group" onclick="createSection('why_choose')">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-heart text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Why Choose Us</h4>
                        <p class="text-sm text-blue-700">Showcase your unique advantages and features</p>
                    </div>
                </div>

                <!-- Clients Card -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-lg border-2 border-dashed border-green-300 hover:border-green-400 transition-all duration-200 cursor-pointer group" onclick="createSection('clients')">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-handshake text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-green-900 mb-2">Client Logos</h4>
                        <p class="text-sm text-green-700">Display trusted client logos and partnerships</p>
                    </div>
                </div>

                <!-- Reviews Card -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-lg border-2 border-dashed border-purple-300 hover:border-purple-400 transition-all duration-200 cursor-pointer group" onclick="createSection('reviews')">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-comments text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-purple-900 mb-2">Reviews</h4>
                        <p class="text-sm text-purple-700">Share customer testimonials and feedback</p>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-lg border-2 border-dashed border-red-300 hover:border-red-400 transition-all duration-200 cursor-pointer group" onclick="createSection('contact')">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-envelope text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-red-900 mb-2">Contact Info</h4>
                        <p class="text-sm text-red-700">Add contact details and support information</p>
                    </div>
                </div>
            </div>
            
            <!-- General Create Button -->
            <div class="text-center mt-8">
                <a href="{{ route('admin.occasions.create') }}"
                   class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Create Custom Section
                </a>
            </div>
        </div>
        @else
        <!-- Quick Add Buttons when sections exist -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex flex-wrap gap-2">
                @php
                $existingSectionTypes = $sections->pluck('section_type')->toArray();
                $missingSections = [
                    'why_choose' => ['name' => 'Why Choose Us', 'icon' => 'fas fa-heart', 'color' => 'blue'],
                    'clients' => ['name' => 'Client Logos', 'icon' => 'fas fa-handshake', 'color' => 'green'],
                    'reviews' => ['name' => 'Reviews', 'icon' => 'fas fa-comments', 'color' => 'purple'],
                    'contact' => ['name' => 'Contact Info', 'icon' => 'fas fa-envelope', 'color' => 'red']
                ];
                @endphp
                
                @foreach($missingSections as $type => $details)
                    @if(!in_array($type, $existingSectionTypes))
                        <button onclick="createSection('{{ $type }}')"
                                class="bg-{{ $details['color'] }}-100 text-{{ $details['color'] }}-800 px-3 py-2 rounded-lg text-sm hover:bg-{{ $details['color'] }}-200 transition-colors duration-200 flex items-center">
                            <i class="{{ $details['icon'] }} mr-2"></i>
                            Add {{ $details['name'] }}
                        </button>
                    @endif
                @endforeach
                
                <a href="{{ route('admin.occasions.create') }}"
                   class="bg-gray-100 text-gray-800 px-3 py-2 rounded-lg text-sm hover:bg-gray-200 transition-colors duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Custom Section
                </a>
            </div>
        </div>
        @endif
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>

// Create section function
function createSection(sectionType) {
    // Redirect to create page with section type pre-selected
    window.location.href = `{{ route('admin.occasions.create') }}?type=${sectionType}`;
}

</script>

</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
let sortable = null;
let sortMode = false;

// Enable sort mode
function enableSortMode() {
    sortMode = true;
    document.getElementById('sortBtn').style.display = 'none';
    document.getElementById('saveBtn').style.display = 'inline-block';
    
    // Show drag handles
    document.querySelectorAll('.drag-handle').forEach(handle => {
        handle.classList.remove('hidden');
    });
    
    // Initialize sortable
    const sectionsList = document.getElementById('sections-list');
    sortable = new Sortable(sectionsList, {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'bg-blue-100',
        chosenClass: 'bg-blue-50',
        onEnd: function(evt) {
            // Update visual order numbers
            updateOrderNumbers();
        }
    });
}

// Update order numbers visually
function updateOrderNumbers() {
    const items = document.querySelectorAll('.section-item');
    items.forEach((item, index) => {
        const orderSpan = item.querySelector('span:contains("Order:")');
        if (orderSpan) {
            orderSpan.textContent = `Order: ${(index + 1) * 10}`;
        }
    });
}

// Save sort order
function saveSortOrder() {
    const items = Array.from(document.querySelectorAll('.section-item'));
    const updateData = items.map((item, index) => ({
        id: parseInt(item.dataset.id),
        sort_order: (index + 1) * 10
    }));

    fetch('{{ route("admin.occasions.updateSortOrder") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ items: updateData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showAlert('Sort order updated successfully!', 'success');
            
            // Disable sort mode
            disableSortMode();
        } else {
            showAlert('Failed to update sort order: ' + data.message, 'error');
        }
    })
    .catch(error => {
        showAlert('Error updating sort order', 'error');
        console.error('Error:', error);
    });
}

// Disable sort mode
function disableSortMode() {
    sortMode = false;
    document.getElementById('sortBtn').style.display = 'inline-block';
    document.getElementById('saveBtn').style.display = 'none';
    
    // Hide drag handles
    document.querySelectorAll('.drag-handle').forEach(handle => {
        handle.classList.add('hidden');
    });
    
    if (sortable) {
        sortable.destroy();
        sortable = null;
    }
}

// Toggle section status
function toggleStatus(sectionId, checkbox) {
    fetch(`{{ url('admin/occasions') }}/${sectionId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update status badge
            const sectionItem = checkbox.closest('.section-item');
            const statusBadge = sectionItem.querySelector('.inline-flex.items-center');
            
            if (data.status) {
                statusBadge.className = statusBadge.className.replace('bg-red-100 text-red-800', 'bg-green-100 text-green-800');
                statusBadge.textContent = 'Active';
            } else {
                statusBadge.className = statusBadge.className.replace('bg-green-100 text-green-800', 'bg-red-100 text-red-800');
                statusBadge.textContent = 'Inactive';
            }
            
            showAlert(data.message, 'success');
        } else {
            // Revert checkbox state
            checkbox.checked = !checkbox.checked;
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        // Revert checkbox state
        checkbox.checked = !checkbox.checked;
        showAlert('Error updating status', 'error');
        console.error('Error:', error);
    });
}

// Duplicate section
function duplicateSection(sectionId) {
    if (!confirm('Are you sure you want to duplicate this section?')) {
        return;
    }

    fetch(`{{ url('admin/occasions') }}/${sectionId}/duplicate`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        showAlert('Error duplicating section', 'error');
        console.error('Error:', error);
    });
}

// Delete section
function deleteSection(sectionId) {
    if (!confirm('Are you sure you want to delete this section? This action cannot be undone.')) {
        return;
    }

    fetch(`{{ url('admin/occasions') }}/${sectionId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            // Remove the section from DOM
            document.querySelector(`.section-item[data-id="${sectionId}"]`).remove();
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        showAlert('Error deleting section', 'error');
        console.error('Error:', error);
    });
}

// Show alert message
function showAlert(message, type = 'info') {
    // Create alert element
    const alert = document.createElement('div');
    alert.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' :
        type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' :
        'bg-blue-100 text-blue-800 border border-blue-200'
    }`;
    alert.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-lg">&times;</button>
        </div>
    `;
    
    document.body.appendChild(alert);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}

// Handle page load
document.addEventListener('DOMContentLoaded', function() {
    // Add any initialization code here
});
</script>
@endpush
@endsection