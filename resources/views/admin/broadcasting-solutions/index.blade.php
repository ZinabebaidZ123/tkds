@extends('admin.layouts.app')

@section('title', 'Broadcasting Solutions')
@section('page-title', 'Broadcasting Solutions')

@section('content')
<div class="space-y-6">
    
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manage Broadcasting Solutions</h2>
            <p class="text-gray-600 text-sm mt-1">Control the slideshow content in the broadcasting section</p>
        </div>
        <a href="{{ route('admin.broadcasting-solutions.create') }}" 
           class="inline-flex items-center justify-center bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>
            <span>Add New Solution</span>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Solutions</p>
                    <p class="text-2xl font-bold">{{ $solutions->total() }}</p>
                </div>
                <i class="fas fa-broadcast-tower text-3xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active</p>
                    <p class="text-2xl font-bold">{{ $solutions->where('status', 'active')->count() }}</p>
                </div>
                <i class="fas fa-eye text-3xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Inactive</p>
                    <p class="text-2xl font-bold">{{ $solutions->where('status', 'inactive')->count() }}</p>
                </div>
                <i class="fas fa-eye-slash text-3xl text-yellow-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Recent</p>
                    <p class="text-2xl font-bold">{{ $solutions->where('created_at', '>=', now()->subDays(7))->count() }}</p>
                </div>
                <i class="fas fa-calendar text-3xl text-red-200"></i>
            </div>
        </div>
    </div>

    <!-- Section Title & Subtitle Form -->
    @php
        $firstSolution = $solutions->first();
        $defaultTitlePart1 = $firstSolution->title_part1 ?? 'Our';
        $defaultTitlePart2 = $firstSolution->title_part2 ?? 'Broadcasting';
        $defaultSubtitle = $firstSolution->subtitle ?? 'Experience professional broadcasting across all platforms';
    @endphp

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-gray-50 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-heading mr-2 text-red-600"></i>
                Section Title & Subtitle
            </h3>
            <p class="text-gray-600 text-sm mt-1">Edit the main title and subtitle for the broadcasting section</p>
        </div>
        
        <form id="sectionTitleForm" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Left Column - Title Parts -->
                <div class="space-y-6">
                    <div class="bg-gradient-to-r from-red-50 to-gray-50 p-4 rounded-xl border border-red-100">
                        <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-heading mr-2 text-red-600"></i>
                            Section Title
                        </h4>
                        <p class="text-sm text-gray-600 mb-4">
                            Create a dynamic title like "Our <span class="text-red-600 font-semibold">Broadcasting</span>"
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="title_part1" class="block text-sm font-medium text-gray-700 mb-2">
                                    First Part
                                </label>
                                <input type="text" 
                                       id="title_part1"
                                       name="title_part1"
                                       value="{{ $defaultTitlePart1 }}"
                                       placeholder="e.g., Our"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200">
                            </div>
                            
                            <div>
                                <label for="title_part2" class="block text-sm font-medium text-gray-700 mb-2">
                                    Second Part (Highlighted)
                                </label>
                                <input type="text" 
                                       id="title_part2"
                                       name="title_part2"
                                       value="{{ $defaultTitlePart2 }}"
                                       placeholder="e.g., Broadcasting"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200">
                            </div>
                        </div>
                        
                        <!-- Preview -->
                        <div class="mt-4 p-3 bg-white rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 mb-2">Preview:</p>
                            <div id="titlePreview" class="text-xl font-bold text-gray-900">
                                <span id="part1Preview">{{ $defaultTitlePart1 }}</span>
                                <span id="part2Preview" class="bg-gradient-to-r from-red-500 to-red-600 bg-clip-text text-transparent">{{ $defaultTitlePart2 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Subtitle -->
                <div class="space-y-6">
                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                            Section Subtitle
                            <span class="text-gray-500 font-normal">- Appears below the main title</span>
                        </label>
                        <textarea id="subtitle" 
                                  name="subtitle"
                                  rows="4"
                                  placeholder="e.g., Experience professional broadcasting across all platforms"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200">{{ $defaultSubtitle }}</textarea>
                    </div>

                    <!-- Save Button -->
                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-3 rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Solutions Content -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-list mr-2 text-primary"></i>
                    All Solutions ({{ $solutions->total() }})
                </h3>
            </div>
        </div>
        
        @if($solutions->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Preview</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Content</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($solutions as $solution)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                <td class="px-6 py-4">
                                    <div class="relative group">
                                        <img src="{{ $solution->getImageUrl() }}" 
                                             alt="{{ $solution->title }}" 
                                             class="w-20 h-16 object-cover rounded-lg border-2 border-gray-200 shadow-sm group-hover:shadow-md transition-shadow duration-200">
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @if($solution->title_part1 || $solution->title_part2)
                                            <div class="text-xs text-blue-600 font-medium">Section Title:</div>
                                            <div class="text-sm font-semibold text-gray-900 mb-1">
                                                {{ $solution->title_part1 }} <span class="text-primary">{{ $solution->title_part2 }}</span>
                                            </div>
                                            @if($solution->subtitle)
                                                <div class="text-xs text-gray-500 max-w-xs line-clamp-1">{{ $solution->subtitle }}</div>
                                            @endif
                                            <hr class="my-1">
                                        @endif
                                        <div class="text-xs text-green-600 font-medium">Slide Content:</div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $solution->title }}</div>
                                        <div class="text-xs text-gray-500 max-w-xs truncate">{{ $solution->description }}</div>
                                        <div class="text-xs text-gray-400">
                                            Created {{ $solution->created_at ? $solution->created_at->diffForHumans() : 'Unknown' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300">
                                        <i class="fas fa-sort mr-1"></i>
                                        {{ $solution->sort_order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               class="sr-only status-toggle" 
                                               data-id="{{ $solution->id }}"
                                               {{ $solution->isActive() ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-200"></div>
                                        <span class="ml-3 text-sm font-medium status-text {{ $solution->isActive() ? 'text-green-600' : 'text-red-600' }}">
                                            {{ ucfirst($solution->status) }}
                                        </span>
                                    </label>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.broadcasting-solutions.edit', $solution) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="deleteSolution({{ $solution->id }})" 
                                                class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile Cards -->
            <div class="lg:hidden divide-y divide-gray-100">
                @foreach($solutions as $solution)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <img src="{{ $solution->getImageUrl() }}" 
                                     alt="{{ $solution->title }}" 
                                     class="w-16 h-12 object-cover rounded-lg border border-gray-200">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        @if($solution->title_part1 || $solution->title_part2)
                                            <div class="text-xs text-blue-600 font-medium mb-1">Section:</div>
                                            <h4 class="text-sm font-medium text-gray-900 mb-1">
                                                {{ $solution->title_part1 }} <span class="text-primary">{{ $solution->title_part2 }}</span>
                                            </h4>
                                            @if($solution->subtitle)
                                                <p class="text-xs text-gray-500 mb-2 line-clamp-1">{{ $solution->subtitle }}</p>
                                            @endif
                                            <hr class="mb-2">
                                        @endif
                                        <div class="text-xs text-green-600 font-medium mb-1">Slide:</div>
                                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $solution->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $solution->description }}</p>
                                        <div class="flex items-center mt-2 space-x-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Order: {{ $solution->sort_order }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $solution->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($solution->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 ml-4">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   class="sr-only status-toggle" 
                                                   data-id="{{ $solution->id }}"
                                                   {{ $solution->isActive() ? 'checked' : '' }}>
                                            <div class="w-9 h-5 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none"></div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-xs text-gray-400">
                                        {{ $solution->created_at ? $solution->created_at->diffForHumans() : 'Unknown date' }}
                                    </span>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.broadcasting-solutions.edit', $solution) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-1"
                                           title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button onclick="deleteSolution({{ $solution->id }})" 
                                                class="text-red-600 hover:text-red-800 p-1"
                                                title="Delete">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $solutions->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-broadcast-tower text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No solutions found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by creating your first broadcasting solution to showcase your services.</p>
                <a href="{{ route('admin.broadcasting-solutions.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>
                    Create Your First Solution
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl transform transition-all duration-300 scale-95">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Confirm Delete</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this solution? This action cannot be undone and will remove it from the broadcasting showcase.</p>
            <div class="flex space-x-3">
                <button id="confirmDelete" class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-3 rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 font-medium shadow-lg">
                    <i class="fas fa-trash mr-2"></i>
                    Delete
                </button>
                <button onclick="closeDeleteModal()" class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl hover:bg-gray-200 transition-all duration-300 font-medium">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let deleteId = null;

// Title Preview functionality for the visible form
document.addEventListener('DOMContentLoaded', function() {
    const titlePart1 = document.getElementById('title_part1');
    const titlePart2 = document.getElementById('title_part2');
    const part1Preview = document.getElementById('part1Preview');
    const part2Preview = document.getElementById('part2Preview');
    
    function updateTitlePreview() {
        const part1 = titlePart1.value || 'Our';
        const part2 = titlePart2.value || 'Broadcasting';
        
        part1Preview.textContent = part1;
        part2Preview.textContent = part2;
    }
    
    titlePart1.addEventListener('input', updateTitlePreview);
    titlePart2.addEventListener('input', updateTitlePreview);
});

// Section Title Form Submit
document.getElementById('sectionTitleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
    
    const formData = {
        title_part1: document.getElementById('title_part1').value,
        title_part2: document.getElementById('title_part2').value,
        subtitle: document.getElementById('subtitle').value
    };
    
    fetch('{{ route('admin.broadcasting-solutions.index') }}/update-section-title', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Section title updated successfully!', 'success');
        } else {
            throw new Error(data.message || 'Failed to update section title');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to update section title', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Status toggle functionality
document.querySelectorAll('.status-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const id = this.dataset.id;
        const status = this.checked ? 'active' : 'inactive';
        const statusText = this.closest('label').querySelector('.status-text');
        
        // Add loading state
        this.disabled = true;
        const originalText = statusText ? statusText.textContent : '';
        if (statusText) statusText.textContent = 'Updating...';
        
        fetch(`{{ route('admin.broadcasting-solutions.index') }}/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update status text in desktop view
                if (statusText) {
                    statusText.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    statusText.className = `ml-3 text-sm font-medium status-text ${status === 'active' ? 'text-green-600' : 'text-red-600'}`;
                }
                
                // Update status badges in mobile view
                const row = this.closest('tr, div');
                const statusBadges = row.querySelectorAll('.bg-green-100, .bg-red-100');
                statusBadges.forEach(badge => {
                    if (badge.textContent.trim().toLowerCase() === 'active' || badge.textContent.trim().toLowerCase() === 'inactive') {
                        badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                        badge.className = `inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
                    }
                });
                
                showNotification('Status updated successfully!', 'success');
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.checked = !this.checked; // Revert checkbox
            if (statusText) statusText.textContent = originalText;
            showNotification('Failed to update status', 'error');
        })
        .finally(() => {
            this.disabled = false;
        });
    });
});

// Delete functionality
function deleteSolution(id) {
    deleteId = id;
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        modal.querySelector('.bg-white').classList.remove('scale-95');
        modal.querySelector('.bg-white').classList.add('scale-100');
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.querySelector('.bg-white').classList.remove('scale-100');
    modal.querySelector('.bg-white').classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        deleteId = null;
    }, 300);
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (deleteId) {
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Deleting...';
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('admin.broadcasting-solutions.index') }}/${deleteId}`;
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    }
});

// Notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});

// Close modal on background click
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endpush