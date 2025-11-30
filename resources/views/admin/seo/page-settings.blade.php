@extends('admin.layouts.app')

@section('title', 'Page SEO Settings')
@section('page-title', 'Page SEO Settings')

@section('content')
<div class="space-y-6">
    
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Page SEO Settings</h2>
            <p class="text-gray-600 text-sm mt-1">Manage SEO settings for individual pages</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.seo.global-settings') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-globe mr-2"></i>
                Global Settings
            </a>
            <a href="{{ route('admin.seo.page-settings.create') }}" 
               class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>
                <span>Add Page SEO</span>
            </a>
        </div>
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
                    <p class="text-blue-100 text-sm font-medium">Total Pages</p>
                    <p class="text-2xl font-bold">{{ $pages->total() }}</p>
                </div>
                <i class="fas fa-file-alt text-3xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active</p>
                    <p class="text-2xl font-bold">{{ $pages->where('status', 'active')->count() }}</p>
                </div>
                <i class="fas fa-check-circle text-3xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">With Meta Desc</p>
                    <p class="text-2xl font-bold">{{ $pages->whereNotNull('meta_description')->count() }}</p>
                </div>
                <i class="fas fa-tags text-3xl text-yellow-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">With OG Data</p>
                    <p class="text-2xl font-bold">{{ $pages->whereNotNull('og_title')->count() }}</p>
                </div>
                <i class="fas fa-share-alt text-3xl text-purple-200"></i>
            </div>
        </div>
    </div>

    <!-- Pages Content -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-file-alt mr-2 text-primary"></i>
                    All Page SEO Settings ({{ $pages->total() }})
                </h3>
            </div>
        </div>
        
        @if($pages->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Page</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meta Info</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Social Media</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SEO Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pages as $page)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $page->page_title }}</div>
                                            <div class="text-sm text-gray-500">{{ $page->page_route }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($page->meta_title)
                                            <div class="flex items-center text-green-600 mb-1">
                                                <i class="fas fa-check text-xs mr-1"></i>
                                                Meta Title ({{ strlen($page->meta_title) }} chars)
                                            </div>
                                        @else
                                            <div class="flex items-center text-red-600 mb-1">
                                                <i class="fas fa-times text-xs mr-1"></i>
                                                Missing Meta Title
                                            </div>
                                        @endif
                                        
                                        @if($page->meta_description)
                                            <div class="flex items-center text-green-600">
                                                <i class="fas fa-check text-xs mr-1"></i>
                                                Meta Description ({{ strlen($page->meta_description) }} chars)
                                            </div>
                                        @else
                                            <div class="flex items-center text-red-600">
                                                <i class="fas fa-times text-xs mr-1"></i>
                                                Missing Meta Description
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($page->og_title && $page->og_description)
                                            <div class="flex items-center text-green-600 mb-1">
                                                <i class="fab fa-facebook text-xs mr-1"></i>
                                                Open Graph Complete
                                            </div>
                                        @else
                                            <div class="flex items-center text-yellow-600 mb-1">
                                                <i class="fab fa-facebook text-xs mr-1"></i>
                                                Open Graph Incomplete
                                            </div>
                                        @endif
                                        
                                        @if($page->twitter_title && $page->twitter_description)
                                            <div class="flex items-center text-green-600">
                                                <i class="fab fa-twitter text-xs mr-1"></i>
                                                Twitter Cards Complete
                                            </div>
                                        @else
                                            <div class="flex items-center text-yellow-600">
                                                <i class="fab fa-twitter text-xs mr-1"></i>
                                                Twitter Cards Incomplete
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $score = 0;
                                        if($page->meta_title) $score += 25;
                                        if($page->meta_description) $score += 25;
                                        if($page->og_title && $page->og_description) $score += 25;
                                        if($page->twitter_title && $page->twitter_description) $score += 25;
                                        
                                        $scoreColor = $score >= 80 ? 'text-green-600 bg-green-100' : ($score >= 60 ? 'text-yellow-600 bg-yellow-100' : 'text-red-600 bg-red-100');
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $scoreColor }}">
                                        {{ $score }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               class="sr-only status-toggle" 
                                               data-id="{{ $page->id }}"
                                               {{ $page->isActive() ? 'checked' : '' }}>
                                        <div class="w-9 h-5 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none"></div>
                                    </label>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ $page->getCanonicalUrl() }}" target="_blank"
                                           class="text-blue-600 hover:text-blue-800 p-1 rounded hover:bg-blue-50 transition-colors duration-200"
                                           title="View Page">
                                            <i class="fas fa-external-link-alt text-sm"></i>
                                        </a>
                                        <a href="{{ route('admin.seo.page-settings.edit', $page) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-1 rounded hover:bg-blue-50 transition-colors duration-200"
                                           title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button onclick="deletePage({{ $page->id }})" 
                                                class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors duration-200"
                                                title="Delete">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile List -->
            <div class="lg:hidden divide-y divide-gray-100">
                @foreach($pages as $page)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">{{ $page->page_title }}</h4>
                                <p class="text-xs text-gray-600 mt-1">{{ $page->page_route }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                @php
                                    $score = 0;
                                    if($page->meta_title) $score += 25;
                                    if($page->meta_description) $score += 25;
                                    if($page->og_title && $page->og_description) $score += 25;
                                    if($page->twitter_title && $page->twitter_description) $score += 25;
                                    
                                    $scoreColor = $score >= 80 ? 'text-green-600 bg-green-100' : ($score >= 60 ? 'text-yellow-600 bg-yellow-100' : 'text-red-600 bg-red-100');
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $scoreColor }}">
                                    {{ $score }}%
                                </span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           class="sr-only status-toggle" 
                                           data-id="{{ $page->id }}"
                                           {{ $page->isActive() ? 'checked' : '' }}>
                                    <div class="w-9 h-5 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none"></div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-3 text-xs">
                            <div>
                                <span class="font-medium text-gray-700">Meta:</span>
                                @if($page->meta_title && $page->meta_description)
                                    <span class="text-green-600">Complete</span>
                                @else
                                    <span class="text-red-600">Incomplete</span>
                                @endif
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Social:</span>
                                @if($page->og_title && $page->twitter_title)
                                    <span class="text-green-600">Complete</span>
                                @else
                                    <span class="text-yellow-600">Incomplete</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-400">
                                Updated {{ $page->updated_at->diffForHumans() }}
                            </span>
                            <div class="flex items-center space-x-2">
                                <a href="{{ $page->getCanonicalUrl() }}" target="_blank"
                                   class="text-blue-600 hover:text-blue-800 p-1"
                                   title="View Page">
                                    <i class="fas fa-external-link-alt text-sm"></i>
                                </a>
                                <a href="{{ route('admin.seo.page-settings.edit', $page) }}" 
                                   class="text-blue-600 hover:text-blue-800 p-1"
                                   title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <button onclick="deletePage({{ $page->id }})" 
                                        class="text-red-600 hover:text-red-800 p-1"
                                        title="Delete">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $pages->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-file-alt text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No page SEO settings found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by adding SEO settings for your pages to improve search engine visibility.</p>
                <a href="{{ route('admin.seo.page-settings.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>
                    Add Your First Page SEO
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
            <p class="text-gray-600 mb-6">Are you sure you want to delete this page SEO setting? This action cannot be undone.</p>
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

// Status toggle functionality
document.querySelectorAll('.status-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const id = this.dataset.id;
        const status = this.checked ? 'active' : 'inactive';
        
        this.disabled = true;
        
        fetch(`{{ route('admin.seo.page-settings.status', ':id') }}`.replace(':id', id), {
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
                showNotification('Status updated successfully!', 'success');
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.checked = !this.checked;
            showNotification('Failed to update status', 'error');
        })
        .finally(() => {
            this.disabled = false;
        });
    });
});

// Delete functionality
function deletePage(id) {
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
        form.action = `{{ route('admin.seo.page-settings.destroy', ':id') }}`.replace(':id', deleteId);
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