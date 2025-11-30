@extends('admin.layouts.app')

@section('title', 'Blog Tags')
@section('page-title', 'Blog Tags')

@section('content')
<div class="space-y-6">
    
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manage Blog Tags</h2>
            <p class="text-gray-600 text-sm mt-1">Organize content with tags for better discoverability</p>
        </div>
        <button onclick="openCreateModal()" 
                class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>
            <span>Add New Tag</span>
        </button>
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
                    <p class="text-blue-100 text-sm font-medium">Total Tags</p>
                    <p class="text-2xl font-bold">{{ $tags->total() }}</p>
                </div>
                <i class="fas fa-tags text-3xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active</p>
                    <p class="text-2xl font-bold">{{ $tags->where('status', 'active')->count() }}</p>
                </div>
                <i class="fas fa-check-circle text-3xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Inactive</p>
                    <p class="text-2xl font-bold">{{ $tags->where('status', 'inactive')->count() }}</p>
                </div>
                <i class="fas fa-times-circle text-3xl text-yellow-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">With Posts</p>
                    <p class="text-2xl font-bold">{{ $tags->where('posts_count', '>', 0)->count() }}</p>
                </div>
                <i class="fas fa-newspaper text-3xl text-purple-200"></i>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row gap-4 items-center">
            <div class="flex-1">
                <div class="relative">
                    <input type="text" 
                           id="searchTags" 
                           placeholder="Search tags..." 
                           class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            <div class="flex space-x-2">
                <button onclick="filterTags('all')" class="filter-btn active px-4 py-3 bg-primary text-white rounded-xl font-medium transition-all duration-200">
                    All
                </button>
                <button onclick="filterTags('active')" class="filter-btn px-4 py-3 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-xl font-medium transition-all duration-200">
                    Active
                </button>
                <button onclick="filterTags('inactive')" class="filter-btn px-4 py-3 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-xl font-medium transition-all duration-200">
                    Inactive
                </button>
            </div>
        </div>
    </div>

    <!-- Tags Content -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-list mr-2 text-primary"></i>
                All Tags ({{ $tags->total() }})
            </h3>
        </div>
        
        @if($tags->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tag</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Posts</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100" id="tagsTableBody">
                        @foreach($tags as $tag)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 group tag-row" data-status="{{ $tag->status }}" data-name="{{ strtolower($tag->name) }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-4 h-4 rounded-full border-2 border-white shadow-sm" style="background-color: {{ $tag->color }};"></div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">#{{ $tag->name }}</div>
                                            <div class="text-xs text-gray-500 font-mono bg-gray-100 px-2 py-1 rounded mt-1">{{ $tag->slug }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ $tag->posts_count }} {{ Str::plural('post', $tag->posts_count) }}
                                        </span>
                                        @if($tag->posts_count > 0)
                                            <a href="{{ route('blog.tag', $tag->slug) }}" 
                                               target="_blank"
                                               class="text-green-600 hover:text-green-800 text-sm" title="View tag page">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               class="sr-only status-toggle" 
                                               data-id="{{ $tag->id }}"
                                               {{ $tag->status === 'active' ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-200"></div>
                                        <span class="ml-3 text-sm font-medium status-text {{ $tag->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ ucfirst($tag->status) }}
                                        </span>
                                    </label>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600">
                                        {{ $tag->created_at ? $tag->created_at->format('M d, Y') : 'Unknown' }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $tag->created_at ? $tag->created_at->diffForHumans() : 'Unknown' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <button onclick="openEditModal({{ $tag->id }}, '{{ addslashes($tag->name) }}', '{{ $tag->color }}', '{{ $tag->status }}')" 
                                                class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteTag({{ $tag->id }})" 
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
            <div class="lg:hidden divide-y divide-gray-100" id="tagsCardsContainer">
                @foreach($tags as $tag)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200 tag-card" data-status="{{ $tag->status }}" data-name="{{ strtolower($tag->name) }}">
                        <div class="flex items-start space-x-4">
                            <div class="w-6 h-6 rounded-full border-2 border-white shadow-sm flex-shrink-0 mt-1" style="background-color: {{ $tag->color }};"></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">#{{ $tag->name }}</h4>
                                        <p class="text-xs text-gray-500 font-mono bg-gray-100 px-2 py-1 rounded mt-1 inline-block">{{ $tag->slug }}</p>
                                        <div class="flex items-center mt-3 space-x-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $tag->posts_count }} {{ Str::plural('post', $tag->posts_count) }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $tag->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($tag->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 ml-4">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   class="sr-only status-toggle" 
                                                   data-id="{{ $tag->id }}"
                                                   {{ $tag->status === 'active' ? 'checked' : '' }}>
                                            <div class="w-9 h-5 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none"></div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <div class="text-xs text-gray-400">
                                        Created {{ $tag->created_at ? $tag->created_at->diffForHumans() : 'Unknown' }}
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($tag->posts_count > 0)
                                            <a href="{{ route('blog.tag', $tag->slug) }}" 
                                               target="_blank"
                                               class="text-green-600 hover:text-green-800 p-1" title="View tag page">
                                                <i class="fas fa-external-link-alt text-sm"></i>
                                            </a>
                                        @endif
                                        <button onclick="openEditModal({{ $tag->id }}, '{{ addslashes($tag->name) }}', '{{ $tag->color }}', '{{ $tag->status }}')" 
                                                class="text-blue-600 hover:text-blue-800 p-1" title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <button onclick="deleteTag({{ $tag->id }})" 
                                                class="text-red-600 hover:text-red-800 p-1" title="Delete">
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
                {{ $tags->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-tags text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No tags found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by creating your first tag to organize your content.</p>
                <button onclick="openCreateModal()" 
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>
                    Create Your First Tag
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Create/Edit Tag Modal -->
<div id="tagModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl transform transition-all duration-300 scale-95">
        <div class="text-center mb-6">
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Add New Tag</h3>
        </div>
        
        <form id="tagForm">
            <input type="hidden" id="tagId" value="">
            
            <div class="space-y-4">
                <!-- Tag Name -->
                <div>
                    <label for="tagName" class="block text-sm font-medium text-gray-700 mb-2">Tag Name</label>
                    <input type="text" 
                           id="tagName" 
                           name="name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                           placeholder="Enter tag name"
                           required>
                </div>
                
                <!-- Color -->
                <div>
                    <label for="tagColor" class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                    <div class="flex space-x-3">
                        <input type="color" 
                               id="tagColor" 
                               name="color"
                               class="w-16 h-12 border border-gray-300 rounded-xl cursor-pointer"
                               value="#C53030">
                        <input type="text" 
                               id="tagColorHex" 
                               value="#C53030"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               readonly>
                    </div>
                </div>
                
                <!-- Status -->
                <div>
                    <label for="tagStatus" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="tagStatus" 
                            name="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                
                <!-- Preview -->
                <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                    <span id="tagPreview" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary/10 text-primary">
                        <div class="w-3 h-3 rounded-full mr-2" style="background-color: #C53030;"></div>
                        #TagName
                    </span>
                </div>
            </div>
            
            <div class="flex space-x-3 mt-6">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-primary to-secondary text-white px-4 py-3 rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg"
                        id="submitTagBtn">
                    <i class="fas fa-save mr-2"></i>
                    <span id="submitBtnText">Create Tag</span>
                </button>
                <button type="button" 
                        onclick="closeTagModal()" 
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl hover:bg-gray-200 transition-all duration-300 font-medium">
                    Cancel
                </button>
            </div>
        </form>
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
            <p class="text-gray-600 mb-6">Are you sure you want to delete this tag? This will remove it from all associated posts.</p>
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
let isEditMode = false;

// Search functionality
document.getElementById('searchTags').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    filterTagsBySearch(query);
});

function filterTagsBySearch(query) {
    const rows = document.querySelectorAll('.tag-row');
    const cards = document.querySelectorAll('.tag-card');
    
    rows.forEach(row => {
        const name = row.dataset.name;
        if (name.includes(query)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    cards.forEach(card => {
        const name = card.dataset.name;
        if (name.includes(query)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

function filterTags(status) {
    // Update active filter button
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-primary', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-700');
    });
    event.target.classList.add('active', 'bg-primary', 'text-white');
    event.target.classList.remove('bg-gray-100', 'text-gray-700');
    
    // Filter rows and cards
    const rows = document.querySelectorAll('.tag-row');
    const cards = document.querySelectorAll('.tag-card');
    
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    cards.forEach(card => {
        if (status === 'all' || card.dataset.status === status) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

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
        
        fetch(`{{ route('admin.blog.tags.status', ':id') }}`.replace(':id', id), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => {
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
                    const badgeText = badge.textContent.trim().toLowerCase();
                    if (badgeText === 'active' || badgeText === 'inactive') {
                        badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                        badge.className = `inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
                    }
                });
                
                // Update row/card data attribute
                row.dataset.status = status;
                
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

// Modal functions
function openCreateModal() {
    isEditMode = false;
    document.getElementById('modalTitle').textContent = 'Add New Tag';
    document.getElementById('submitBtnText').textContent = 'Create Tag';
    document.getElementById('tagForm').reset();
    document.getElementById('tagId').value = '';
    document.getElementById('tagColor').value = '#C53030';
    document.getElementById('tagColorHex').value = '#C53030';
    updateTagPreview();
    showModal();
}

function openEditModal(id, name, color, status) {
    isEditMode = true;
    document.getElementById('modalTitle').textContent = 'Edit Tag';
    document.getElementById('submitBtnText').textContent = 'Update Tag';
    document.getElementById('tagId').value = id;
    document.getElementById('tagName').value = name;
    document.getElementById('tagColor').value = color;
    document.getElementById('tagColorHex').value = color;
    document.getElementById('tagStatus').value = status;
    updateTagPreview();
    showModal();
}

function showModal() {
    const modal = document.getElementById('tagModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        modal.querySelector('.bg-white').classList.remove('scale-95');
        modal.querySelector('.bg-white').classList.add('scale-100');
    }, 10);
}

function closeTagModal() {
    const modal = document.getElementById('tagModal');
    modal.querySelector('.bg-white').classList.remove('scale-100');
    modal.querySelector('.bg-white').classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// Color picker sync
document.getElementById('tagColor').addEventListener('input', function() {
    document.getElementById('tagColorHex').value = this.value;
    updateTagPreview();
});

document.getElementById('tagName').addEventListener('input', function() {
    updateTagPreview();
});

function updateTagPreview() {
    const name = document.getElementById('tagName').value || 'TagName';
    const color = document.getElementById('tagColor').value;
    
    const preview = document.getElementById('tagPreview');
    
    preview.innerHTML = `
        <div class="w-3 h-3 rounded-full mr-2" style="background-color: ${color};"></div>
        #${name}
    `;
}

// Form submission for create/update
document.getElementById('tagForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitTagBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
    
    let url, method;
    if (isEditMode) {
        url = `{{ route('admin.blog.tags.update', ':id') }}`.replace(':id', document.getElementById('tagId').value);
        method = 'PUT';
    } else {
        url = `{{ route('admin.blog.tags.store') }}`;
        method = 'POST';
    }
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: document.getElementById('tagName').value,
            color: document.getElementById('tagColor').value,
            status: document.getElementById('tagStatus').value
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Response text:', text);
                throw new Error(`HTTP error! status: ${response.status}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            closeTagModal();
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            throw new Error(data.message || 'Failed to save tag');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to save tag', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Delete functionality
function deleteTag(id) {
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
        
        fetch(`{{ route('admin.blog.tags.destroy', ':id') }}`.replace(':id', deleteId), {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Response text:', text);
                    throw new Error(`HTTP error! status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                closeDeleteModal();
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                throw new Error(data.message || 'Failed to delete tag');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to delete tag', 'error');
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-trash mr-2"></i>Delete';
        });
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

// Close modals on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTagModal();
        closeDeleteModal();
    }
});

// Close modals on background click
document.getElementById('tagModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTagModal();
    }
});

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateTagPreview();
});

</script>

@endpush