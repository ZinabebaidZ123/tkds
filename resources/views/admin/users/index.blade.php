@extends('admin.layouts.app')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')
<div class="space-y-6">
    
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">User Management</h2>
            <p class="text-gray-600 text-sm mt-1">Manage all registered users and their information</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" 
               class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 shadow-md hover:shadow-lg">
                <i class="fas fa-download mr-2"></i>
                <span>Export</span>
            </a>
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>
                <span>Add New User</span>
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Users</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['total']) }}</p>
                </div>
                <i class="fas fa-users text-3xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['active']) }}</p>
                </div>
                <i class="fas fa-user-check text-3xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Inactive</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['inactive']) }}</p>
                </div>
                <i class="fas fa-user-times text-3xl text-red-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Verified</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['verified']) }}</p>
                </div>
                <i class="fas fa-shield-alt text-3xl text-purple-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">This Week</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['recent']) }}</p>
                </div>
                <i class="fas fa-calendar text-3xl text-yellow-200"></i>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-filter mr-2 text-primary"></i>
                Filters & Search
            </h3>
        </div>
        
        <div class="p-6">
            <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Users</label>
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search by name, email, or phone..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Verification Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Verification</label>
                        <select name="verified" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="all" {{ request('verified') === 'all' ? 'selected' : '' }}>All Users</option>
                            <option value="verified" {{ request('verified') === 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="unverified" {{ request('verified') === 'unverified' ? 'selected' : '' }}>Unverified</option>
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Registration Date</option>
                            <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                            <option value="email" {{ request('sort') === 'email' ? 'selected' : '' }}>Email</option>
                            <option value="last_login_at" {{ request('sort') === 'last_login_at' ? 'selected' : '' }}>Last Login</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center space-x-3">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Apply Filters
                        </button>
                        <a href="{{ route('admin.users.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Clear
                        </a>
                    </div>

                    <!-- Bulk Actions -->
                    <div class="flex items-center space-x-3">
                        <select id="bulkAction" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="">Bulk Actions</option>
                            <option value="activate">Activate Selected</option>
                            <option value="deactivate">Deactivate Selected</option>
                            <option value="verify_email">Verify Email</option>
                            <option value="delete">Delete Selected</option>
                        </select>
                        <button type="button" 
                                id="applyBulkAction"
                                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors duration-200 disabled:opacity-50"
                                disabled>
                            Apply
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-list mr-2 text-primary"></i>
                    All Users ({{ $users->total() }})
                </h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">
                        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
                    </span>
                </div>
            </div>
        </div>
        
        @if($users->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-primary focus:ring-primary">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Verification</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Registered</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                <td class="px-6 py-4">
                                    <input type="checkbox" class="user-checkbox rounded border-gray-300 text-primary focus:ring-primary" value="{{ $user->id }}">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $user->getAvatarUrl() }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ $user->id }}</div>
                                            @if($user->profile?->job_title)
                                                <div class="text-xs text-gray-400">{{ $user->profile->job_title }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="text-sm text-gray-900 flex items-center">
                                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                            {{ $user->email }}
                                        </div>
                                        @if($user->phone)
                                            <div class="text-xs text-gray-500 flex items-center">
                                                <i class="fas fa-phone text-gray-400 mr-2"></i>
                                                {{ $user->phone }}
                                            </div>
                                        @endif
                                        @if($user->profile?->location)
                                            <div class="text-xs text-gray-500 flex items-center">
                                                <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                                {{ $user->profile->location }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               class="sr-only status-toggle" 
                                               data-id="{{ $user->id }}"
                                               {{ $user->isActive() ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-200"></div>
                                        <span class="ml-3 text-sm font-medium status-text {{ $user->isActive() ? 'text-green-600' : 'text-red-600' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </label>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->isVerified())
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Verified
                                        </span>
                                    @else
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Unverified
                                            </span>
                                            <button onclick="verifyEmail({{ $user->id }})" 
                                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium"
                                                    title="Verify Email">
                                                Verify
                                            </button>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                                        @if($user->last_login_at)
                                            <div class="text-xs text-gray-400">
                                                Last: {{ $user->last_login_at->diffForHumans() }}
                                            </div>
                                        @else
                                            <div class="text-xs text-red-400">Never logged in</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                           title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="deleteUser({{ $user->id }})" 
                                                class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                                title="Delete User">
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
                @foreach($users as $user)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-start space-x-4">
                            <input type="checkbox" class="user-checkbox rounded border-gray-300 text-primary focus:ring-primary mt-1" value="{{ $user->id }}">
                            <div class="flex-shrink-0">
                                <img src="{{ $user->getAvatarUrl() }}" 
                                     alt="{{ $user->name }}" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $user->name }}</h4>
                                        <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
                                        @if($user->phone)
                                            <p class="text-xs text-gray-400 mt-1">{{ $user->phone }}</p>
                                        @endif
                                        
                                        <div class="flex items-center mt-2 space-x-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                            @if($user->isVerified())
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Verified
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                    Unverified
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 ml-4">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   class="sr-only status-toggle" 
                                                   data-id="{{ $user->id }}"
                                                   {{ $user->isActive() ? 'checked' : '' }}>
                                            <div class="w-9 h-5 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none"></div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-xs text-gray-400">
                                        Joined {{ $user->created_at->diffForHumans() }}
                                    </span>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-1"
                                           title="View">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="text-green-600 hover:text-green-800 p-1"
                                           title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        @if(!$user->isVerified())
                                            <button onclick="verifyEmail({{ $user->id }})" 
                                                    class="text-purple-600 hover:text-purple-800 p-1"
                                                    title="Verify Email">
                                                <i class="fas fa-shield-alt text-sm"></i>
                                            </button>
                                        @endif
                                        <button onclick="deleteUser({{ $user->id }})" 
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
                {{ $users->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-users text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No users found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">
                    @if(request()->hasAny(['search', 'status', 'verified']))
                        No users match your current filters. Try adjusting your search criteria.
                    @else
                        No users have registered yet. Create the first user to get started.
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'status', 'verified']))
                    <a href="{{ route('admin.users.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>
                        Create First User
                    </a>
                @else
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Clear Filters
                    </a>
                @endif
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
            <p class="text-gray-600 mb-6">Are you sure you want to delete this user? This action cannot be undone and will remove all user data permanently.</p>
            <div class="flex space-x-3">
                <button id="confirmDelete" class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-3 rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 font-medium shadow-lg">
                    <i class="fas fa-trash mr-2"></i>
                    Delete User
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

// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActionButton();
});

// Individual checkbox change
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('user-checkbox')) {
        updateBulkActionButton();
        
        // Update select all checkbox
        const allCheckboxes = document.querySelectorAll('.user-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
        const selectAllCheckbox = document.getElementById('selectAll');
        
        if (checkedCheckboxes.length === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (checkedCheckboxes.length === allCheckboxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
        }
    }
});

// Update bulk action button state
function updateBulkActionButton() {
    const checkedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
    const bulkActionSelect = document.getElementById('bulkAction');
    const applyButton = document.getElementById('applyBulkAction');
    
    if (checkedCheckboxes.length > 0 && bulkActionSelect.value) {
        applyButton.disabled = false;
    } else {
        applyButton.disabled = true;
    }
}

// Bulk action select change
document.getElementById('bulkAction').addEventListener('change', updateBulkActionButton);

// Apply bulk action
document.getElementById('applyBulkAction').addEventListener('click', function() {
    const checkedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
    const action = document.getElementById('bulkAction').value;
    
    if (checkedCheckboxes.length === 0 || !action) return;
    
    const userIds = Array.from(checkedCheckboxes).map(cb => cb.value);
    const actionLabels = {
        'activate': 'activate',
        'deactivate': 'deactivate', 
        'verify_email': 'verify email for',
        'delete': 'delete'
    };
    
    if (confirm(`Are you sure you want to ${actionLabels[action]} ${userIds.length} selected users?`)) {
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
        
        fetch('{{ route("admin.users.bulk-actions") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                action: action,
                users: userIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(data.message || 'Bulk action failed', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        })
        .finally(() => {
            this.disabled = false;
            this.innerHTML = 'Apply';
        });
    }
});

// Status toggle functionality
document.querySelectorAll('.status-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const id = this.dataset.id;
        const status = this.checked ? 'active' : 'inactive';
        const statusText = this.closest('label').querySelector('.status-text');
        
        this.disabled = true;
        const originalText = statusText ? statusText.textContent : '';
        if (statusText) statusText.textContent = 'Updating...';
        
        fetch(`{{ route('admin.users.index') }}/${id}/status`, {
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
                if (statusText) {
                    statusText.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    statusText.className = `ml-3 text-sm font-medium status-text ${status === 'active' ? 'text-green-600' : 'text-red-600'}`;
                }
                
                // Update mobile status badges
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
            this.checked = !this.checked;
            if (statusText) statusText.textContent = originalText;
            showNotification('Failed to update status', 'error');
        })
        .finally(() => {
            this.disabled = false;
        });
    });
});

// Email verification
function verifyEmail(userId) {
    if (confirm('Are you sure you want to verify this user\'s email?')) {
        fetch(`{{ route('admin.users.index') }}/${userId}/verify-email`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Email verified successfully!', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(data.message || 'Failed to verify email', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    }
}

// Delete functionality
function deleteUser(id) {
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
        form.action = `{{ route('admin.users.index') }}/${deleteId}`;
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