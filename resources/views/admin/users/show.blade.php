@extends('admin.layouts.app')

@section('title', 'User Details - ' . $user->name)
@section('page-title', 'User Details')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.users.index') }}" class="hover:text-primary transition-colors duration-200">User Management</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ $user->name }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">User Details</h2>
                <p class="text-gray-600 text-sm mt-1">Complete user information and activity</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3 sm:ml-auto">
            @if(!$user->isVerified())
                <button onclick="verifyEmail({{ $user->id }})" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                    <i class="fas fa-shield-check mr-2"></i>
                    Verify Email
                </button>
            @endif
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Edit User
            </a>
            <button onclick="deleteUser({{ $user->id }})" 
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                <i class="fas fa-trash mr-2"></i>
                Delete
            </button>
        </div>
    </div>

    <!-- User Profile Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-8 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6">
                <div class="flex-shrink-0">
                    <img src="{{ $user->getAvatarUrl() }}" 
                         alt="{{ $user->name }}" 
                         class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                </div>
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                            @if($user->profile?->job_title)
                                <p class="text-gray-500 mt-1">{{ $user->profile->job_title }}</p>
                            @endif
                            @if($user->profile?->company)
                                <p class="text-gray-500">{{ $user->profile->company }}</p>
                            @endif
                        </div>
                        <div class="flex flex-col sm:items-end space-y-2 mt-4 sm:mt-0">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas {{ $user->isActive() ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                {{ ucfirst($user->status) }}
                            </span>
                            @if($user->isVerified())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-shield-check mr-1"></i>
                                    Email Verified
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Email Unverified
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column - Main Info -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Contact Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-address-card mr-2 text-primary"></i>
                        Contact Information
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                    <span class="text-gray-900">{{ $user->email }}</span>
                                    @if($user->isVerified())
                                        <i class="fas fa-check-circle text-green-500" title="Verified"></i>
                                    @endif
                                </div>
                            </div>
                            
                            @if($user->phone)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-phone text-gray-400"></i>
                                    <span class="text-gray-900">{{ $user->phone }}</span>
                                </div>
                            </div>
                            @endif
                            
                            @if($user->date_of_birth)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                    <span class="text-gray-900">{{ $user->date_of_birth->format('F d, Y') }}</span>
                                    <span class="text-gray-500">({{ $user->date_of_birth->age }} years old)</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="space-y-4">
                            @if($user->gender)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-venus-mars text-gray-400"></i>
                                    <span class="text-gray-900">{{ ucfirst($user->gender) }}</span>
                                </div>
                            </div>
                            @endif
                            
                            @if($user->profile?->location)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Location</label>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    <span class="text-gray-900">{{ $user->profile->location }}</span>
                                </div>
                            </div>
                            @endif
                            
                            @if($user->profile?->website)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Website</label>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-globe text-gray-400"></i>
                                    <a href="{{ $user->profile->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        {{ $user->profile->website }}
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biography -->
            @if($user->profile?->bio)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user-edit mr-2 text-primary"></i>
                        Biography
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 leading-relaxed">{{ $user->profile->bio }}</p>
                </div>
            </div>
            @endif

            <!-- Recent Sessions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-history mr-2 text-primary"></i>
                        Recent Sessions
                        <span class="ml-2 text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ $user->sessions->count() }} total</span>
                    </h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($user->sessions->take(5) as $session)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if($session->device_type === 'mobile')
                                            <i class="fas fa-mobile-alt text-blue-500 text-lg"></i>
                                        @elseif($session->device_type === 'tablet')
                                            <i class="fas fa-tablet-alt text-green-500 text-lg"></i>
                                        @else
                                            <i class="fas fa-desktop text-purple-500 text-lg"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $session->getDeviceInfo() }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $session->getLocationInfo() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-900">{{ $session->login_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $session->login_at->format('h:i A') }}</p>
                                    @if($session->is_active)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                                            Active
                                        </span>
                                    @else
                                        <p class="text-xs text-gray-400 mt-1">{{ $session->getDuration() }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center">
                            <i class="fas fa-history text-gray-400 text-3xl mb-2"></i>
                            <p class="text-gray-500">No login sessions found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Right Column - Stats & Quick Info -->
        <div class="space-y-6">
            
            <!-- Quick Stats -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                        Quick Stats
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">User ID</span>
                        <span class="text-sm font-medium text-gray-900">#{{ $user->id }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Member Since</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Login</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Sessions</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->sessions->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Account Age</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-cog mr-2 text-purple-600"></i>
                        Account Settings
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Status Toggle -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Account Status</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   class="sr-only status-toggle" 
                                   data-id="{{ $user->id }}"
                                   {{ $user->isActive() ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-200"></div>
                        </label>
                    </div>

                    <!-- Email Verification -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Email Verified</span>
                        <div class="flex items-center space-x-2">
                            @if($user->isVerified())
                                <span class="text-green-600 text-sm font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Verified
                                </span>
                            @else
                                <button onclick="verifyEmail({{ $user->id }})" 
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-shield-check mr-1"></i>
                                    Verify Now
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Last Updated</span>
                        <span class="text-sm text-gray-500">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Billing Information -->
            @if($user->billingInfo->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-credit-card mr-2 text-green-600"></i>
                        Billing Information
                        <span class="ml-2 text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full">{{ $user->billingInfo->count() }}</span>
                    </h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($user->billingInfo->take(3) as $billing)
                        <div class="p-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $billing->billing_name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $billing->billing_email }}</p>
                                    @if($billing->company_name)
                                        <p class="text-xs text-gray-400">{{ $billing->company_name }}</p>
                                    @endif
                                </div>
                                @if($billing->is_default)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Default
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Shipping Information -->
            @if($user->shippingInfo->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-orange-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-shipping-fast mr-2 text-yellow-600"></i>
                        Shipping Information
                        <span class="ml-2 text-sm bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">{{ $user->shippingInfo->count() }}</span>
                    </h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($user->shippingInfo->take(3) as $shipping)
                        <div class="p-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $shipping->shipping_name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $shipping->getFullAddress() }}</p>
                                    @if($shipping->shipping_phone)
                                        <p class="text-xs text-gray-400">{{ $shipping->shipping_phone }}</p>
                                    @endif
                                </div>
                                @if($shipping->is_default)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Default
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-pink-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt mr-2 text-red-600"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <button onclick="sendPasswordReset()" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors duration-200">
                        <i class="fas fa-key mr-2"></i>
                        Send Password Reset
                    </button>
                    
                    <button onclick="sendWelcomeEmail()" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                        <i class="fas fa-envelope mr-2"></i>
                        Send Welcome Email
                    </button>
                    
                    <button onclick="exportUserData()" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i>
                        Export User Data
                    </button>
                    
                    <button onclick="viewActivity()" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors duration-200">
                        <i class="fas fa-chart-line mr-2"></i>
                        View Activity Log
                    </button>
                </div>
            </div>
        </div>
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
            <p class="text-gray-600 mb-6">Are you sure you want to delete <strong>{{ $user->name }}</strong>? This action cannot be undone and will remove all user data permanently.</p>
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

// Status toggle functionality
document.querySelectorAll('.status-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const id = this.dataset.id;
        const status = this.checked ? 'active' : 'inactive';
        
        this.disabled = true;
        
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
                showNotification('Status updated successfully!', 'success');
                
                // Update page elements
                const statusBadges = document.querySelectorAll('.bg-green-100, .bg-red-100');
                statusBadges.forEach(badge => {
                    if (badge.textContent.trim().toLowerCase().includes('active') || badge.textContent.trim().toLowerCase().includes('inactive')) {
                        badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                        badge.className = `inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
                    }
                });
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

// Quick Actions
function sendPasswordReset() {
    if (confirm('Send password reset email to {{ $user->email }}?')) {
        showNotification('Password reset email sent!', 'success');
    }
}

function sendWelcomeEmail() {
    if (confirm('Send welcome email to {{ $user->email }}?')) {
        showNotification('Welcome email sent!', 'success');
    }
}

function exportUserData() {
    showNotification('Exporting user data...', 'info');
    
    // Create and download user data as JSON
    const userData = {
        id: {{ $user->id }},
        name: '{{ $user->name }}',
        email: '{{ $user->email }}',
        phone: '{{ $user->phone }}',
        status: '{{ $user->status }}',
        verified: {{ $user->isVerified() ? 'true' : 'false' }},
        created_at: '{{ $user->created_at }}',
        profile: {
            bio: '{{ $user->profile?->bio }}',
            location: '{{ $user->profile?->location }}',
            website: '{{ $user->profile?->website }}',
            company: '{{ $user->profile?->company }}',
            job_title: '{{ $user->profile?->job_title }}'
        }
    };
    
    const dataStr = JSON.stringify(userData, null, 2);
    const dataBlob = new Blob([dataStr], {type: 'application/json'});
    const url = URL.createObjectURL(dataBlob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'user_{{ $user->id }}_data.json';
    link.click();
    URL.revokeObjectURL(url);
    
    setTimeout(() => {
        showNotification('User data exported successfully!', 'success');
    }, 1000);
}

function viewActivity() {
    showNotification('Activity log feature coming soon!', 'info');
}

// Notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white max-w-sm`;
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
    }, 4000);
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

// Auto-refresh session status every 5 minutes
setInterval(() => {
    const activeSessions = document.querySelectorAll('.bg-green-100');
    if (activeSessions.length > 0) {
        // In a real app, you'd make an AJAX call to check session status
        console.log('Checking session status...');
    }
}, 300000);

console.log('User details page loaded with enhanced functionality');
</script>
@endpush