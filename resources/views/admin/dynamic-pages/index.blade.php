@extends('admin.layouts.app')

@section('title', 'Dynamic Pages Manager')
@section('page-title', 'Dynamic Pages Manager')

@push('styles')
<style>
.section-item {
    cursor: move;
    transition: all 0.3s ease;
}
.section-item:hover {
    background-color: #f8fafc;
    transform: translateX(4px);
}
.sortable-ghost {
    background: linear-gradient(90deg, #e0e7ff, #ddd6fe) !important;
    border: 2px dashed #8b5cf6 !important;
    border-radius: 0.75rem !important;
    opacity: 0.7 !important;
}
.sortable-chosen {
    background: #fff !important;
    border: 2px solid #3b82f6 !important;
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3) !important;
    transform: scale(1.02) !important;
}
.drag-handle {
    cursor: grab;
    opacity: 0.5;
    transition: opacity 0.2s;
}
.drag-handle:hover {
    opacity: 1;
}
.drag-handle:active {
    cursor: grabbing;
}
.save-order-btn {
    display: none;
    animation: fadeInUp 0.3s ease;
}
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.sections-order-container {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-top: 1rem;
}
.sortable-list {
    min-height: 100px;
}
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Special Offer Page Manager</h1>
            <p class="text-gray-600 text-sm mt-1">Manage sections and their order.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('occasions') }}" target="_blank" 
               class="inline-flex items-center justify-center bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-external-link-alt mr-2"></i>
                Preview Page
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active Pages</p>
                    <p class="text-2xl font-bold">{{ $pages->where('status', 'active')->count() }}</p>
                </div>
                <i class="fas fa-check-circle text-3xl text-green-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Inactive Pages</p>
                    <p class="text-2xl font-bold">{{ $pages->where('status', 'inactive')->count() }}</p>
                </div>
                <i class="fas fa-eye-slash text-3xl text-yellow-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Pages</p>
                    <p class="text-2xl font-bold">{{ $pages->count() }}</p>
                </div>
                <i class="fas fa-layer-group text-3xl text-blue-200"></i>
            </div>
        </div>
    </div>

    @forelse($pages as $page)
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Page Header -->
        <div class="px-6 py-6 bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $page->page_name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Slug: <span class="font-mono bg-gray-100 px-2 py-1 rounded text-xs">{{ $page->page_slug }}</span>
                        </p>
                    </div>
                </div>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $page->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($page->status) }}
                </span>
            </div>
        </div>

        

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Sections Management -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-cogs text-blue-500 mr-2"></i>
                        Sections Management
                    </h4>
                    
                    @php
                        $allSections = [
                            'header' => ['name' => 'Header', 'icon' => 'fas fa-header', 'color' => 'blue', 'editable' => true],
                            'hero' => ['name' => 'Hero Section', 'icon' => 'fas fa-star', 'color' => 'purple', 'editable' => true],
                            'why_choose' => ['name' => 'Why Choose Us', 'icon' => 'fas fa-check-circle', 'color' => 'cyan', 'editable' => true],
                            'services' => ['name' => 'Services', 'icon' => 'fas fa-cogs', 'color' => 'emerald', 'editable' => true],
                            'products' => ['name' => 'Products', 'icon' => 'fas fa-shopping-bag', 'color' => 'indigo', 'editable' => true],
                            'shop_products' => ['name' => 'Shop Products', 'icon' => 'fas fa-shopping-cart', 'color' => 'orange', 'editable' => true],
                            'packages' => ['name' => 'Packages', 'icon' => 'fas fa-box', 'color' => 'pink', 'editable' => true],
                            'video' => ['name' => 'Video Section', 'icon' => 'fas fa-play-circle', 'color' => 'red', 'editable' => true],
                            'clients' => ['name' => 'Clients', 'icon' => 'fas fa-users', 'color' => 'teal', 'editable' => true],
                            'reviews' => ['name' => 'Reviews', 'icon' => 'fas fa-star-half-alt', 'color' => 'yellow', 'editable' => true],
                            'contact' => ['name' => 'Contact', 'icon' => 'fas fa-envelope', 'color' => 'rose', 'editable' => true],
                            'footer' => ['name' => 'Footer', 'icon' => 'fas fa-columns', 'color' => 'gray', 'editable' => true]
                        ];
                    @endphp

                    <div class="space-y-3">
                        @foreach($allSections as $sectionKey => $section)
                            @php
                                $statusField = $sectionKey . '_status';
                                $isActive = $page->$statusField === 'active';
                                $colorClass = [
                                    'blue' => 'from-blue-500 to-blue-600',
                                    'purple' => 'from-purple-500 to-purple-600',
                                    'cyan' => 'from-cyan-500 to-cyan-600',
                                    'emerald' => 'from-emerald-500 to-emerald-600',
                                    'orange' => 'from-orange-500 to-orange-600',
                                    'indigo' => 'from-indigo-500 to-indigo-600',
                                    'red' => 'from-red-500 to-red-600',
                                    'teal' => 'from-teal-500 to-teal-600',
                                    'yellow' => 'from-yellow-500 to-yellow-600',
                                    'rose' => 'from-rose-500 to-rose-600',
                                    'gray' => 'from-gray-500 to-gray-600',
                                    'pink' => 'from-pink-500 to-pink-600'
                                ][$section['color']];
                            @endphp
                            <div class="group flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br {{ $colorClass }} rounded-lg flex items-center justify-center shadow-md">
                                        <i class="{{ $section['icon'] }} text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-gray-900">{{ $section['name'] }}</h5>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $isActive ? 'Active' : 'Inactive' }}
                                    </span>
                                    <button onclick="toggleSection({{ $page->id }}, '{{ $sectionKey }}')" 
                                            class="w-8 h-8 rounded-lg {{ $isActive ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} flex items-center justify-center transition-all opacity-0 group-hover:opacity-100">
                                        <i class="fas fa-power-off text-xs"></i>
                                    </button>
                                    @if($section['editable'])
                                        <a href="{{ route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => str_replace('_', '-', $sectionKey)]) }}" 
                                           class="w-8 h-8 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-all opacity-0 group-hover:opacity-100">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sections Order (Drag & Drop) -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-sort text-green-500 mr-2"></i>
                            Sections Order
                        </h4>
                        <button type="button" 
                                class="save-order-btn px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all shadow-lg hover:shadow-xl"
                                data-page-id="{{ $page->id }}">
                            <i class="fas fa-save mr-1"></i>
                            Save Order
                        </button>
                    </div>
                    
                    <div class="sections-order-container">
                        <p class="text-sm text-gray-600 mb-4">
                            <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                            Drag and drop to reorder sections. Changes will be applied to the frontend.
                        </p>
                        
                        <ul class="sortable-list space-y-2" id="sections-{{ $page->id }}" data-page-id="{{ $page->id }}">
                            @php
                                // Get the current sections order, or default to all sections
                                $savedOrder = $page->sections_order ?? [];
                                $allSectionKeys = array_keys($allSections);
                                
                                // If saved order exists, merge it with any new sections not in the saved order
                                if (!empty($savedOrder)) {
                                    $missingSections = array_diff($allSectionKeys, $savedOrder);
                                    $sectionsOrder = array_merge($savedOrder, $missingSections);
                                } else {
                                    $sectionsOrder = $allSectionKeys;
                                }
                            @endphp
                            
                            @foreach($sectionsOrder as $sectionKey)
                                @if(isset($allSections[$sectionKey]))
                                    @php
                                        $section = $allSections[$sectionKey];
                                        $statusField = $sectionKey . '_status';
                                        $isActive = $page->$statusField === 'active';
                                        $colorClass = [
                                            'blue' => 'border-blue-200',
                                            'purple' => 'border-purple-200',
                                            'cyan' => 'border-cyan-200',
                                            'emerald' => 'border-emerald-200',
                                            'orange' => 'border-orange-200',
                                            'indigo' => 'border-indigo-200',
                                            'red' => 'border-red-200',
                                            'teal' => 'border-teal-200',
                                            'yellow' => 'border-yellow-200',
                                            'rose' => 'border-rose-200',
                                            'gray' => 'border-gray-200',
                                            'pink' => 'border-pink-200'
                                        ][$section['color']];
                                    @endphp
                                    <li class="section-item bg-white border {{ $colorClass }} rounded-lg p-3 shadow-sm {{ $isActive ? '' : 'opacity-60' }}" 
                                        data-section="{{ $sectionKey }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="drag-handle text-gray-400 hover:text-gray-600">
                                                    <i class="fas fa-grip-vertical"></i>
                                                </div>
                                                <div class="w-8 h-8 bg-gradient-to-br {{ $colorClass = [
                                                    'blue' => 'from-blue-500 to-blue-600',
                                                    'purple' => 'from-purple-500 to-purple-600',
                                                    'cyan' => 'from-cyan-500 to-cyan-600',
                                                    'emerald' => 'from-emerald-500 to-emerald-600',
                                                    'orange' => 'from-orange-500 to-orange-600',
                                                    'indigo' => 'from-indigo-500 to-indigo-600',
                                                    'red' => 'from-red-500 to-red-600',
                                                    'teal' => 'from-teal-500 to-teal-600',
                                                    'yellow' => 'from-yellow-500 to-yellow-600',
                                                    'rose' => 'from-rose-500 to-rose-600',
                                                    'gray' => 'from-gray-500 to-gray-600',
                                                    'pink' => 'from-pink-500 to-pink-600'
                                                ][$section['color']] }} rounded-lg flex items-center justify-center shadow-sm">
                                                    <i class="{{ $section['icon'] }} text-white text-xs"></i>
                                                </div>
                                                <span class="font-medium text-gray-900">{{ $section['name'] }}</span>
                                            </div>
                                            <span class="text-xs px-2 py-1 rounded-full {{ $isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $isActive ? 'Active' : 'Hidden' }}
                                            </span>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-16">
        <div class="mx-auto h-24 w-24 bg-gradient-to-br from-blue-100 to-purple-100 rounded-2xl flex items-center justify-center mb-6">
            <i class="fas fa-layer-group text-4xl text-blue-500"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No pages found</h3>
        <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by creating your first dynamic page.</p>
    </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('SortableJS loaded:', typeof Sortable);
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    // Initialize sortable for each list
    document.querySelectorAll('.sortable-list').forEach(function(list) {
        console.log('Initializing sortable for:', list.id);
        
        const sortable = Sortable.create(list, {
            handle: '.drag-handle',
            animation: 200,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            fallbackOnBody: true,
            swapThreshold: 0.65,
            onStart: function(evt) {
                console.log('Drag started');
            },
            onEnd: function(evt) {
                console.log('Drag ended');
                const pageId = list.dataset.pageId;
                const saveBtn = document.querySelector(`.save-order-btn[data-page-id="${pageId}"]`);
                if (saveBtn) {
                    saveBtn.style.display = 'block';
                    saveBtn.classList.add('animate-pulse');
                }
            }
        });
        
        console.log('Sortable initialized successfully for:', list.id);
    });

    // Save order functionality
    document.querySelectorAll('.save-order-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const pageId = this.dataset.pageId;
            const list = document.querySelector(`#sections-${pageId}`);
            
            if (!list) {
                console.error('List not found for page:', pageId);
                return;
            }
            
            const sectionsOrder = [];
            list.querySelectorAll('.section-item').forEach(function(item) {
                const section = item.dataset.section;
                if (section) {
                    sectionsOrder.push(section);
                }
            });

            console.log('Saving order for page', pageId, ':', sectionsOrder);

            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Saving...';
            this.disabled = true;
            this.classList.remove('animate-pulse');

            // Send AJAX request
            fetch(`/admin/dynamic-pages/${pageId}/reorder-sections`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken.content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    order: sectionsOrder
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    this.innerHTML = '<i class="fas fa-check mr-1"></i>Saved!';
                    this.className = this.className.replace('bg-green-500 hover:bg-green-600', 'bg-green-600');
                    
                    // Show success message
                    showNotification('Sections order updated successfully!', 'success');
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.className = this.className.replace('bg-green-600', 'bg-green-500 hover:bg-green-600');
                        this.disabled = false;
                        this.style.display = 'none';
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Unknown error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.innerHTML = '<i class="fas fa-times mr-1"></i>Error!';
                this.className = this.className.replace('bg-green-500 hover:bg-green-600', 'bg-red-500 hover:bg-red-600');
                
                showNotification('Failed to save sections order: ' + error.message, 'error');
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.className = this.className.replace('bg-red-500 hover:bg-red-600', 'bg-green-500 hover:bg-green-600');
                    this.disabled = false;
                }, 3000);
            });
        });
    });
});

// Toggle section function
function toggleSection(pageId, section) {
    console.log('Toggle section:', pageId, section);
    const button = event.target.closest('button');
    const originalClasses = button.className;

    button.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i>';
    button.disabled = true;

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    fetch(`/admin/dynamic-pages/${pageId}/sections/${section}`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': csrfToken.content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: 'toggle' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            button.innerHTML = '<i class="fas fa-power-off text-xs"></i>';
            button.className = originalClasses;
            button.disabled = false;
            showNotification('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.innerHTML = '<i class="fas fa-power-off text-xs"></i>';
        button.className = originalClasses;
        button.disabled = false;
        showNotification('Something went wrong!', 'error');
    });
}

// Notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg text-white transition-all duration-300 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check' : 'fa-times'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animation
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
        notification.style.opacity = '1';
    }, 100);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        notification.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>
@endpush