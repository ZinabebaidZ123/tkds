@extends('admin.layouts.app')

@section('title', 'Blog Authors')
@section('page-title', 'Blog Authors')

@section('content')
<div class="space-y-6">
    
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manage Blog Authors</h2>
            <p class="text-gray-600 text-sm mt-1">Manage content creators and their profiles</p>
        </div>
        <a href="{{ route('admin.blog.authors.create') }}" 
           class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>
            <span>Add New Author</span>
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

    @if(session('error'))
        <div class="bg-gradient-to-r from-red-50 to-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Authors</p>
                    <p class="text-2xl font-bold">{{ $authors->total() }}</p>
                </div>
                <i class="fas fa-users text-3xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active</p>
                    <p class="text-2xl font-bold">{{ $authors->where('status', 'active')->count() }}</p>
                </div>
                <i class="fas fa-user-check text-3xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Inactive</p>
                    <p class="text-2xl font-bold">{{ $authors->where('status', 'inactive')->count() }}</p>
                </div>
                <i class="fas fa-user-slash text-3xl text-yellow-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">With Posts</p>
                    <p class="text-2xl font-bold">{{ $authors->where('active_posts_count', '>', 0)->count() }}</p>
                </div>
                <i class="fas fa-newspaper text-3xl text-purple-200"></i>
            </div>
        </div>
    </div>

    <!-- Authors Content -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-list mr-2 text-primary"></i>
                    All Authors ({{ $authors->total() }})
                </h3>
            </div>
        </div>
        
        @if($authors->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Posts</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Admin User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($authors as $author)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <img src="{{ $author->getAvatarUrl() }}" 
                                                 alt="{{ $author->name }}"
                                                 class="w-12 h-12 rounded-full border-2 border-gray-200 shadow-sm">
                                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-{{ $author->isActive() ? 'green' : 'red' }}-500 rounded-full border-2 border-white"></div>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $author->name }}</div>
                                            <div class="text-xs text-gray-500 font-mono bg-gray-100 px-2 py-1 rounded mt-1">{{ $author->slug }}</div>
                                            @if($author->bio)
                                                <div class="text-xs text-gray-600 mt-1 max-w-xs truncate" title="{{ $author->bio }}">
                                                    {{ $author->bio }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @if($author->email)
                                            <div class="flex items-center text-sm text-gray-600">
                                                <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                                <a href="mailto:{{ $author->email }}" class="hover:text-primary">{{ $author->email }}</a>
                                            </div>
                                        @endif
                                        @if($author->getSocialLinks())
                                            <div class="flex items-center space-x-2">
                                                @foreach(array_slice($author->getSocialLinks(), 0, 3) as $platform => $link)
                                                    <a href="{{ $link }}" target="_blank" 
                                                       class="text-gray-400 hover:text-primary text-sm">
                                                        <i class="fab fa-{{ $platform }}"></i>
                                                    </a>
                                                @endforeach
                                                @if(count($author->getSocialLinks()) > 3)
                                                    <span class="text-gray-400 text-xs">+{{ count($author->getSocialLinks()) - 3 }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ $author->active_posts_count }} {{ Str::plural('post', $author->active_posts_count) }}
                                        </span>
                                        @if($author->active_posts_count > 0)
                                            <a href="{{ route('admin.blog.posts.index', ['author' => $author->id]) }}" 
                                               class="text-primary hover:text-secondary text-sm" title="View posts">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($author->adminUser)
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center">
                                                <span class="text-white text-xs font-bold">{{ substr($author->adminUser->name, 0, 1) }}</span>
                                            </div>
                                            <span class="text-sm text-gray-900">{{ $author->adminUser->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm italic">No admin user</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               class="sr-only status-toggle" 
                                               data-id="{{ $author->id }}"
                                               {{ $author->isActive() ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-200"></div>
                                        <span class="ml-3 text-sm font-medium status-text {{ $author->isActive() ? 'text-green-600' : 'text-red-600' }}">
                                            {{ ucfirst($author->status) }}
                                        </span>
                                    </label>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        @if($author->active_posts_count > 0)
                                            <a href="{{ route('blog.author', $author->slug) }}" 
                                               target="_blank"
                                               class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                               title="View Author Page">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.blog.authors.edit', $author) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="deleteAuthor({{ $author->id }})" 
                                                class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                                title="Delete"
                                                {{ $author->active_posts_count > 0 ? 'disabled' : '' }}>
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
                @foreach($authors as $author)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-start space-x-4">
                            <div class="relative flex-shrink-0">
                                <img src="{{ $author->getAvatarUrl() }}" 
                                     alt="{{ $author->name }}"
                                     class="w-16 h-16 rounded-full border-2 border-gray-200 shadow-sm">
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-{{ $author->isActive() ? 'green' : 'red' }}-500 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $author->name }}</h4>
                                        <p class="text-xs text-gray-500 font-mono bg-gray-100 px-2 py-1 rounded mt-1 inline-block">{{ $author->slug }}</p>
                                        @if($author->email)
                                            <p class="text-xs text-gray-600 mt-1">{{ $author->email }}</p>
                                        @endif
                                        @if($author->bio)
                                            <p class="text-xs text-gray-600 mt-2 line-clamp-2">{{ $author->bio }}</p>
                                        @endif
                                        <div class="flex items-center mt-3 space-x-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $author->active_posts_count }} {{ Str::plural('post', $author->active_posts_count) }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $author->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($author->status) }}
                                            </span>
                                            @if($author->adminUser)
                                                <span class="text-xs text-gray-500">Admin: {{ $author->adminUser->name }}</span>
                                            @endif
                                        </div>
                                        @if($author->getSocialLinks())
                                            <div class="flex items-center space-x-2 mt-2">
                                                @foreach($author->getSocialLinks() as $platform => $link)
                                                    <a href="{{ $link }}" target="_blank" 
                                                       class="text-gray-400 hover:text-primary text-sm">
                                                        <i class="fab fa-{{ $platform }}"></i>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-2 ml-4">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   class="sr-only status-toggle" 
                                                   data-id="{{ $author->id }}"
                                                   {{ $author->isActive() ? 'checked' : '' }}>
                                            <div class="w-9 h-5 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none"></div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <div class="text-xs text-gray-400">
                                        Created {{ $author->created_at->diffForHumans() }}
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($author->active_posts_count > 0)
                                            <a href="{{ route('blog.author', $author->slug) }}" 
                                               target="_blank"
                                               class="text-green-600 hover:text-green-800 p-1" title="View Author Page">
                                                <i class="fas fa-external-link-alt text-sm"></i>
                                            </a>
                                            <a href="{{ route('admin.blog.posts.index', ['author' => $author->id]) }}" 
                                               class="text-blue-600 hover:text-blue-800 p-1" title="View posts">
                                                <i class="fas fa-list text-sm"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.blog.authors.edit', $author) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-1" title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button onclick="deleteAuthor({{ $author->id }})" 
                                                class="text-red-600 hover:text-red-800 p-1" title="Delete"
                                                {{ $author->active_posts_count > 0 ? 'disabled' : '' }}>
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
                {{ $authors->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-users text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No authors found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by adding your first author to start creating content.</p>
                <a href="{{ route('admin.blog.authors.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>
                    Add Your First Author
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
            <p class="text-gray-600 mb-6">Are you sure you want to delete this author? This action cannot be undone.</p>
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

// Status toggle functionality - FIXED
document.querySelectorAll('.status-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const id = this.dataset.id;
        const status = this.checked ? 'active' : 'inactive';
        const statusText = this.closest('label').querySelector('.status-text');
        
        // Add loading state
        this.disabled = true;
        const originalText = statusText ? statusText.textContent : '';
        if (statusText) statusText.textContent = 'Updating...';
        
        // FIXED: Use proper route construction
        fetch(`/admin/blog/authors/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => {
            // Check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
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
                
                // Update status indicators
                const indicators = row.querySelectorAll('.bg-green-500, .bg-red-500');
                indicators.forEach(indicator => {
                    indicator.className = indicator.className.replace(/bg-(green|red)-500/, `bg-${status === 'active' ? 'green' : 'red'}-500`);
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
            showNotification('Failed to update status: ' + error.message, 'error');
        })
        .finally(() => {
            this.disabled = false;
        });
    });
});

// Delete functionality - FIXED
function deleteAuthor(id) {
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
        form.action = `/admin/blog/authors/${deleteId}`;
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    }
});

// Notification function - ENHANCED
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white max-w-md`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-2"></i>
            <span class="text-sm">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        if (document.body.contains(notification)) {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }
    }, 5000);
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

// Debug function to test routes - Remove this after testing
function testRoutes() {
    console.log('Testing author routes...');
    
    // Test if the route exists
    fetch('/admin/blog/authors/1/status', {
        method: 'HEAD',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Route test result:', response.status);
        if (response.status === 404) {
            console.error('Route not found! Check your routes file.');
        }
    })
    .catch(error => {
        console.error('Route test error:', error);
    });
}

// Auto-check on page load (remove after debugging)
document.addEventListener('DOMContentLoaded', function() {
    console.log('Authors page loaded');
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));
    
    // Uncomment this line to test routes on page load
    // testRoutes();
});

// Enhanced error handling for fetch requests
function makeStatusRequest(id, status) {
    return fetch(`/admin/blog/authors/${id}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Response text:', text);
                throw new Error(`HTTP ${response.status}: ${text}`);
            });
        }
        
        return response.json();
    });
}
</script>
@endpush