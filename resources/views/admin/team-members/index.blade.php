@extends('admin.layouts.app')

@section('title', 'Team Members')
@section('page-title', 'Team Members')

@section('content')
<div class="space-y-6">
    
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manage Team Members</h2>
            <p class="text-gray-600 text-sm mt-1">Control your team showcase and member information</p>
        </div>
        <a href="{{ route('admin.team-members.create') }}" 
           class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>
            <span>Add New Member</span>
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
                    <p class="text-blue-100 text-sm font-medium">Total Members</p>
                    <p class="text-2xl font-bold">{{ $teamMembers->total() }}</p>
                </div>
                <i class="fas fa-users text-3xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active</p>
                    <p class="text-2xl font-bold">{{ $teamMembers->where('status', 'active')->count() }}</p>
                </div>
                <i class="fas fa-user-check text-3xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Inactive</p>
                    <p class="text-2xl font-bold">{{ $teamMembers->where('status', 'inactive')->count() }}</p>
                </div>
                <i class="fas fa-user-times text-3xl text-yellow-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Recent</p>
                    <p class="text-2xl font-bold">{{ $teamMembers->where('created_at', '>=', now()->subDays(7))->count() }}</p>
                </div>
                <i class="fas fa-calendar text-3xl text-purple-200"></i>
            </div>
        </div>
    </div>

    <!-- Team Members Content -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-users mr-2 text-primary"></i>
                    All Team Members ({{ $teamMembers->total() }})
                </h3>
            </div>
        </div>
        
        @if($teamMembers->count() > 0)
            <!-- Desktop Grid -->
            <div class="hidden lg:block p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="sortable-grid">
                    @foreach($teamMembers as $member)
                        <div class="team-member-card bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group" data-id="{{ $member->id }}">
                            <div class="relative">
                                <img src="{{ $member->getImageUrl() }}" 
                                     alt="{{ $member->name }}" 
                                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $member->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                </div>
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        #{{ $member->sort_order }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $member->name }}</h4>
                                <p class="text-sm text-gray-600 mb-2">{{ $member->position }}</p>
                                
                                @if($member->email)
                                    <p class="text-xs text-gray-500 mb-2">
                                        <i class="fas fa-envelope mr-1"></i>
                                        {{ $member->email }}
                                    </p>
                                @endif
                                
                                @if($member->bio)
                                    <p class="text-xs text-gray-600 mb-3 line-clamp-2">{{ $member->getShortBio() }}</p>
                                @endif
                                
                                <!-- Social Links -->
                                @if(count($member->getSocialLinks()) > 0)
                                    <div class="flex items-center space-x-2 mb-3">
                                        @foreach($member->getSocialLinks() as $platform => $link)
                                            <a href="{{ $link['url'] }}" 
                                               target="_blank" 
                                               class="w-6 h-6 flex items-center justify-center rounded-full {{ $link['color'] }} hover:bg-gray-100 transition-colors duration-200">
                                                <i class="{{ $link['icon'] }} text-xs"></i>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <!-- Actions -->
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <div class="flex items-center space-x-2">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   class="sr-only status-toggle" 
                                                   data-id="{{ $member->id }}"
                                                   {{ $member->isActive() ? 'checked' : '' }}>
                                            <div class="w-9 h-5 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none"></div>
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.team-members.edit', $member) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-1 rounded hover:bg-blue-50 transition-colors duration-200"
                                           title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button onclick="deleteMember({{ $member->id }})" 
                                                class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition-colors duration-200"
                                                title="Delete">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Mobile List -->
            <div class="lg:hidden divide-y divide-gray-100">
                @foreach($teamMembers as $member)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <img src="{{ $member->getImageUrl() }}" 
                                     alt="{{ $member->name }}" 
                                     class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $member->name }}</h4>
                                        <p class="text-xs text-gray-600 mt-1">{{ $member->position }}</p>
                                        <div class="flex items-center mt-2 space-x-3">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Order: {{ $member->sort_order }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $member->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($member->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 ml-4">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   class="sr-only status-toggle" 
                                                   data-id="{{ $member->id }}"
                                                   {{ $member->isActive() ? 'checked' : '' }}>
                                            <div class="w-9 h-5 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none"></div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-xs text-gray-400">
                                        {{ $member->created_at ? $member->created_at->diffForHumans() : 'Unknown date' }}
                                    </span>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.team-members.edit', $member) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-1"
                                           title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button onclick="deleteMember({{ $member->id }})" 
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
                {{ $teamMembers->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-users text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No team members found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by adding your first team member to showcase your amazing team.</p>
                <a href="{{ route('admin.team-members.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>
                    Add Your First Team Member
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
            <p class="text-gray-600 mb-6">Are you sure you want to delete this team member? This action cannot be undone and will remove them from the team showcase.</p>
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
        
        // Add loading state
        this.disabled = true;
        
        fetch(`{{ route('admin.team-members.index') }}/${id}/status`, {
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
                // Update status badges
                const card = this.closest('.team-member-card, div');
                const statusBadges = card.querySelectorAll('.bg-green-100, .bg-red-100');
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
showNotification('Failed to update status', 'error');
        })
        .finally(() => {
            this.disabled = false;
        });
    });
});

// Delete functionality
function deleteMember(id) {
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
        form.action = `{{ route('admin.team-members.index') }}/${deleteId}`;
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

// Sortable functionality for reordering
if (typeof Sortable !== 'undefined') {
    const sortableGrid = document.getElementById('sortable-grid');
    if (sortableGrid) {
        new Sortable(sortableGrid, {
            animation: 150,
            ghostClass: 'opacity-50',
            onEnd: function(evt) {
                const items = Array.from(sortableGrid.children).map((card, index) => ({
                    id: card.dataset.id,
                    sort_order: index + 1
                }));
                
                fetch(`{{ route('admin.team-members.sort-order') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ items: items })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Order updated successfully!', 'success');
                        // Update order badges
                        items.forEach((item, index) => {
                            const card = document.querySelector(`[data-id="${item.id}"]`);
                            const orderBadge = card.querySelector('.bg-blue-100');
                            if (orderBadge) {
                                orderBadge.textContent = `#${index + 1}`;
                            }
                        });
                    } else {
                        showNotification('Failed to update order', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to update order', 'error');
                });
            }
        });
    }
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
