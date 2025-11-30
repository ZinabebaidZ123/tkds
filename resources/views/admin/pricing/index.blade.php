@extends('admin.layouts.app')

@section('title', 'Pricing Plans')
@section('page-title', 'Pricing Plans Management')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pricing Plans</h2>
            <p class="text-gray-600 text-sm mt-1">Manage subscription plans and pricing</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.stripe.settings') }}" 
               class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium transition-all duration-200">
                <i class="fas fa-cog mr-2"></i>
                Stripe Settings
            </a>
            <a href="{{ route('admin.pricing-plans.create') }}" 
               class="inline-flex items-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-2 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>
                Add New Plan
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

    @if($errors->any())
        <div class="bg-gradient-to-r from-red-50 to-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <div class="text-red-700 font-medium">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Plans</p>
                    <p class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <i class="fas fa-tags text-3xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active Plans</p>
                    <p class="text-2xl font-bold">{{ $stats['active'] ?? 0 }}</p>
                </div>
                <i class="fas fa-check-circle text-3xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Popular Plans</p>
                    <p class="text-2xl font-bold">{{ $stats['popular'] ?? 0 }}</p>
                </div>
                <i class="fas fa-star text-3xl text-purple-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Subscribers</p>
                    <p class="text-2xl font-bold">{{ $stats['total_subscribers'] ?? 0 }}</p>
                </div>
                <i class="fas fa-users text-3xl text-yellow-200"></i>
            </div>
        </div>
    </div>

    <!-- Plans Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-list mr-2 text-primary"></i>
                    All Plans ({{ $plans->total() ?? 0 }})
                </h3>
                
                <div class="flex items-center space-x-3">
                    <button onclick="enableSortMode()" id="sortBtn"
                            class="inline-flex items-center text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg transition-colors duration-200">
                        <i class="fas fa-sort mr-2"></i>
                        Sort Order
                    </button>
                </div>
            </div>
        </div>
        
        @if($plans && $plans->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Plan Details</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pricing</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Display</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Subscribers</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100" id="plansTableBody">
                        @foreach($plans as $plan)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 group sortable-row" data-id="{{ $plan->id }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="sort-handle hidden cursor-move text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-grip-vertical"></i>
                                        </div>
                                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="{{ $plan->icon ?? 'fas fa-star' }} text-white"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center space-x-2">
                                                <h4 class="text-sm font-semibold text-gray-900">{{ $plan->name }}</h4>
                                                @if($plan->is_popular)
                                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">Popular</span>
                                                @endif
                                                @if($plan->is_featured)
                                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs font-medium">Featured</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-500 max-w-xs truncate">{{ $plan->short_description }}</p>
                                            <div class="flex items-center space-x-3 mt-1">
                                                <span class="text-xs text-gray-400">Order: {{ $plan->sort_order }}</span>
                                                @if($plan->trial_days)
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">{{ $plan->trial_days }}d trial</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        @if($plan->price_monthly)
                                            <div class="font-semibold text-gray-900">${{ number_format($plan->price_monthly, 2) }}/mo</div>
                                        @endif
                                        @if($plan->price_yearly)
                                            <div class="text-gray-500">${{ number_format($plan->price_yearly, 2) }}/yr</div>
                                        @endif
                                        @if($plan->setup_fee && $plan->setup_fee > 0)
                                            <div class="text-orange-600 text-xs">+${{ number_format($plan->setup_fee, 2) }} setup</div>
                                        @endif
                                        @if(!$plan->price_monthly && !$plan->price_yearly)
                                            <div class="font-semibold text-green-600">Free</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs {{ $plan->show_in_home ? 'text-green-600' : 'text-gray-400' }}">
                                                <i class="fas fa-home mr-1"></i>Home
                                            </span>
                                            <span class="text-xs {{ $plan->show_in_pricing ? 'text-green-600' : 'text-gray-400' }}">
                                                <i class="fas fa-tag mr-1"></i>Pricing
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               class="sr-only status-toggle" 
                                               data-id="{{ $plan->id }}"
                                               {{ $plan->status == 'active' ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-200"></div>
                                        <span class="ml-3 text-sm font-medium status-text {{ $plan->status == 'active' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ ucfirst($plan->status) }}
                                        </span>
                                    </label>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <div class="font-semibold text-gray-900">{{ $plan->subscriptions_count ?? 0 }}</div>
                                        <div class="text-gray-500 text-xs">active subscribers</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.pricing-plans.show', $plan->id) }}" 
                                           class="text-gray-400 hover:text-primary p-2 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.pricing-plans.edit', $plan->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="duplicatePlan({{ $plan->id }})" 
                                                class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                                title="Duplicate">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        @if($plan->stripe_product_id)
                                            <button onclick="syncStripe({{ $plan->id }})" 
                                                    class="text-purple-600 hover:text-purple-800 p-2 rounded-lg hover:bg-purple-50 transition-colors duration-200"
                                                    title="Sync with Stripe">
                                                <i class="fab fa-stripe"></i>
                                            </button>
                                        @endif
                                        <button onclick="deletePlan({{ $plan->id }}, '{{ addslashes($plan->name) }}')" 
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
            <div class="lg:hidden divide-y divide-gray-100" id="plansMobileList">
                @foreach($plans as $plan)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200 sortable-row" data-id="{{ $plan->id }}">
                        <div class="flex space-x-4">
                            <div class="sort-handle hidden cursor-move text-gray-400 hover:text-gray-600 mt-2">
                                <i class="fas fa-grip-vertical"></i>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="{{ $plan->icon ?? 'fas fa-star' }} text-white"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $plan->name }}</h4>
                                            @if($plan->is_popular)
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">Popular</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 mb-2 line-clamp-2">{{ $plan->short_description }}</p>
                                        <div class="flex items-center space-x-4 text-xs text-gray-500">
                                            <span>Order: {{ $plan->sort_order }}</span>
                                            <span>{{ $plan->subscriptions_count ?? 0 }} subscribers</span>
                                            @if($plan->trial_days)
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ $plan->trial_days }}d trial</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 ml-4">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   class="sr-only status-toggle" 
                                                   data-id="{{ $plan->id }}"
                                                   {{ $plan->status == 'active' ? 'checked' : '' }}>
                                            <div class="w-9 h-5 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none"></div>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-3">
                                    <div class="text-sm">
                                        @if($plan->price_monthly)
                                            <span class="font-semibold text-gray-900">${{ number_format($plan->price_monthly, 0) }}/mo</span>
                                        @endif
                                        @if($plan->price_yearly)
                                            <span class="text-gray-500 ml-2">${{ number_format($plan->price_yearly, 0) }}/yr</span>
                                        @endif
                                        @if(!$plan->price_monthly && !$plan->price_yearly)
                                            <span class="font-semibold text-green-600">Free</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.pricing-plans.show', $plan->id) }}" 
                                           class="text-gray-400 hover:text-primary p-1"
                                           title="View">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <a href="{{ route('admin.pricing-plans.edit', $plan->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-1"
                                           title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button onclick="duplicatePlan({{ $plan->id }})" 
                                                class="text-green-600 hover:text-green-800 p-1"
                                                title="Duplicate">
                                            <i class="fas fa-copy text-sm"></i>
                                        </button>
                                        <button onclick="deletePlan({{ $plan->id }}, '{{ addslashes($plan->name) }}')" 
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
                {{ $plans->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-tags text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No pricing plans found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by creating your first pricing plan for your subscribers.</p>
                <a href="{{ route('admin.pricing-plans.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>
                    Create Your First Plan
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl transform transition-all duration-300 scale-95">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Confirm Delete</h3>
            <p class="text-gray-600 mb-6" id="deleteMessage">Are you sure you want to delete this pricing plan? This action cannot be undone.</p>
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
let deleteId = null;
let deleteName = '';
let sortableInstance = null;

// CSRF token helper with error handling
function getCsrfToken() {
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    if (!metaTag) {
        console.error('CSRF token meta tag not found');
        showNotification('Security token not found. Please refresh the page.', 'error');
        return null;
    }
    return metaTag.getAttribute('content');
}

// Enhanced API request helper with better error handling
async function makeApiRequest(url, options = {}) {
    const csrfToken = getCsrfToken();
    if (!csrfToken) {
        throw new Error('CSRF token not available');
    }

    const defaultOptions = {
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    };

    const mergedOptions = {
        ...defaultOptions,
        ...options,
        headers: {
            ...defaultOptions.headers,
            ...options.headers
        }
    };

    console.log('Making API request:', { url, options: mergedOptions });

    try {
        const response = await fetch(url, mergedOptions);
        
        console.log('API response status:', response.status);
        
        const responseText = await response.text();
        console.log('API response text:', responseText);

        let data;
        try {
            data = JSON.parse(responseText);
        } catch (parseError) {
            console.error('Failed to parse JSON response:', parseError);
            
            // If it's an HTML response (likely an error page), extract meaningful error
            if (responseText.includes('<!DOCTYPE html>') || responseText.includes('<html>')) {
                if (responseText.includes('404')) {
                    throw new Error('Resource not found (404). The pricing plan may have been deleted or does not exist.');
                } else if (responseText.includes('500')) {
                    throw new Error('Server error (500). Please try again later.');
                } else if (responseText.includes('419')) {
                    throw new Error('Session expired (419). Please refresh the page and try again.');
                } else {
                    throw new Error('Server returned an unexpected response. Please refresh the page and try again.');
                }
            } else {
                throw new Error(`Invalid JSON response: ${responseText.substring(0, 100)}...`);
            }
        }
        
        if (!response.ok) {
            const errorMessage = data?.message || data?.error || `HTTP ${response.status}: ${response.statusText}`;
            throw new Error(errorMessage);
        }

        console.log('API response data:', data);
        return data;

    } catch (error) {
        console.error('API request failed:', error);
        
        // Handle network errors
        if (error.name === 'TypeError' && error.message.includes('fetch')) {
            throw new Error('Network error. Please check your connection and try again.');
        }
        
        throw error;
    }
}

// Status toggle functionality with improved error handling
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', async function() {
            const id = this.dataset.id;
            const status = this.checked ? 'active' : 'inactive';
            const statusText = this.closest('label').querySelector('.status-text');
            
            if (!id) {
                showNotification('Plan ID not found', 'error');
                this.checked = !this.checked;
                return;
            }
            
            this.disabled = true;
            const originalText = statusText?.textContent || '';
            const originalChecked = this.checked;
            
            if (statusText) statusText.textContent = 'Updating...';
            
            try {
                const data = await makeApiRequest(`/admin/pricing-plans/${id}/status`, {
                    method: 'POST',
                    body: JSON.stringify({ status: status })
                });
                
                if (data.success) {
                    if (statusText) {
                        statusText.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                        statusText.className = `ml-3 text-sm font-medium status-text ${status === 'active' ? 'text-green-600' : 'text-red-600'}`;
                    }
                    showNotification(data.message || 'Status updated successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to update status');
                }
                
            } catch (error) {
                console.error('Status update error:', error);
                this.checked = !originalChecked;
                if (statusText) statusText.textContent = originalText;
                showNotification(`Failed to update status: ${error.message}`, 'error');
            } finally {
                this.disabled = false;
            }
        });
    });
});

// Delete functionality with improved error handling
function deletePlan(id, name = '') {
    if (!id) {
        showNotification('Invalid plan ID', 'error');
        return;
    }
    
    deleteId = id;
    deleteName = name;
    
    const modal = document.getElementById('deleteModal');
    const messageElement = document.getElementById('deleteMessage');
    
    if (!modal) {
        showNotification('Delete modal not found', 'error');
        return;
    }
    
    if (messageElement && name) {
        messageElement.textContent = `Are you sure you want to delete the plan "${name}"? This action cannot be undone.`;
    }
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        const content = modal.querySelector('.bg-white');
        if (content) {
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (!modal) return;
    
    const content = modal.querySelector('.bg-white');
    if (content) {
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
    }
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        deleteId = null;
        deleteName = '';
    }, 300);
}

// Confirm delete handler with improved error handling
document.addEventListener('DOMContentLoaded', function() {
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', async function() {
            if (!deleteId) {
                showNotification('No plan selected for deletion', 'error');
                return;
            }
            
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Deleting...';
            
            try {
                const data = await makeApiRequest(`/admin/pricing-plans/${deleteId}`, {
                    method: 'DELETE'
                });
                
                if (data.success) {
                    showNotification(data.message || 'Plan deleted successfully!', 'success');
                    closeDeleteModal();
                    
                    // Remove the row from the table instead of full reload
                    const rowsToRemove = document.querySelectorAll(`[data-id="${deleteId}"]`);
                    rowsToRemove.forEach(row => {
                        row.style.transition = 'opacity 0.3s ease';
                        row.style.opacity = '0';
                        setTimeout(() => row.remove(), 300);
                    });
                    
                    // Update statistics if possible
                    setTimeout(() => {
                        // Optionally reload the page if needed for stats update
                        window.location.reload();
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Failed to delete plan');
                }
                
            } catch (error) {
                console.error('Delete error:', error);
                showNotification(`Failed to delete plan: ${error.message}`, 'error');
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-trash mr-2"></i>Delete';
            }
        });
    }
});

// Duplicate functionality with improved error handling
async function duplicatePlan(id) {
    if (!id) {
        showNotification('Invalid plan ID', 'error');
        return;
    }
    
    if (!confirm('Are you sure you want to duplicate this plan?')) {
        return;
    }
    
    try {
        const data = await makeApiRequest(`/admin/pricing-plans/${id}/duplicate`, {
            method: 'POST'
        });
        
        if (data.success) {
            showNotification(data.message || 'Plan duplicated successfully!', 'success');
            if (data.redirect) {
                setTimeout(() => window.location.href = data.redirect, 1000);
            } else {
                setTimeout(() => window.location.reload(), 1000);
            }
        } else {
            showNotification(data.message || 'Failed to duplicate plan', 'error');
        }
        
    } catch (error) {
        console.error('Duplicate error:', error);
        showNotification(`Failed to duplicate plan: ${error.message}`, 'error');
    }
}

// Stripe sync functionality with improved error handling
async function syncStripe(id) {
    if (!id) {
        showNotification('Invalid plan ID', 'error');
        return;
    }
    
    if (!confirm('Sync this plan with Stripe? This will create or update products and prices.')) {
        return;
    }
    
    try {
        const data = await makeApiRequest(`/admin/pricing-plans/${id}/sync-stripe`, {
            method: 'POST'
        });
        
        showNotification(data.message || 'Stripe sync completed', data.success ? 'success' : 'error');
        
    } catch (error) {
        console.error('Stripe sync error:', error);
        showNotification(`Failed to sync with Stripe: ${error.message}`, 'error');
    }
}

// Sort functionality with improved error handling
function enableSortMode() {
    const sortHandles = document.querySelectorAll('.sort-handle');
    const sortBtn = document.getElementById('sortBtn');
    
    if (!sortBtn || sortHandles.length === 0) {
        showNotification('Sort elements not found', 'error');
        return;
    }
    
    if (sortableInstance) {
        // Exit sort mode
        sortableInstance.destroy();
        sortableInstance = null;
        sortHandles.forEach(handle => handle.classList.add('hidden'));
        sortBtn.innerHTML = '<i class="fas fa-sort mr-2"></i>Sort Order';
        sortBtn.classList.remove('bg-primary', 'text-white');
        sortBtn.classList.add('bg-gray-100', 'text-gray-700');
    } else {
        // Enable sort mode
        sortHandles.forEach(handle => handle.classList.remove('hidden'));
        sortBtn.innerHTML = '<i class="fas fa-times mr-2"></i>Exit Sort';
        sortBtn.classList.add('bg-primary', 'text-white');
        sortBtn.classList.remove('bg-gray-100', 'text-gray-700');
        
        const tableBody = document.getElementById('plansTableBody');
        const mobileList = document.getElementById('plansMobileList');
        
        if (tableBody && window.innerWidth >= 1024) {
            // Desktop table sorting
            sortableInstance = Sortable.create(tableBody, {
                handle: '.sort-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onEnd: updateSortOrder
            });
        } else if (mobileList && window.innerWidth < 1024) {
            // Mobile list sorting
            sortableInstance = Sortable.create(mobileList, {
                handle: '.sort-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onEnd: updateSortOrder
            });
        }
    }
}

async function updateSortOrder() {
    const rows = document.querySelectorAll('.sortable-row');
    if (rows.length === 0) {
        showNotification('No plans found to sort', 'error');
        return;
    }
    
    const items = Array.from(rows).map((row, index) => {
        const id = parseInt(row.dataset.id);
        if (isNaN(id)) {
            console.error('Invalid plan ID:', row.dataset.id);
            return null;
        }
        return {
            id: id,
            sort_order: index + 1
        };
    }).filter(item => item !== null);
    
    if (items.length === 0) {
        showNotification('No valid plans to sort', 'error');
        return;
    }
    
    try {
        const data = await makeApiRequest('/admin/pricing-plans/sort-order', {
            method: 'POST',
            body: JSON.stringify({ items })
        });
        
        showNotification(
            data.success ? (data.message || 'Sort order updated successfully!') : 'Failed to update sort order', 
            data.success ? 'success' : 'error'
        );
        
    } catch (error) {
        console.error('Sort order error:', error);
        showNotification(`Failed to update sort order: ${error.message}`, 'error');
    }
}

// Enhanced notification function
function showNotification(message, type = 'success') {
    if (!message) {
        console.error('Notification message is empty');
        return;
    }
    
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification-toast');
    existingNotifications.forEach(notification => {
        if (document.body.contains(notification)) {
            document.body.removeChild(notification);
        }
    });
    
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    notification.className = `notification-toast fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white max-w-md`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-2"></i>
            <span class="text-sm font-medium">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white/80 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => notification.classList.remove('translate-x-full'), 100);
    
    // Hide notification after 5 seconds
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

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Escape key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Click outside modal to close
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    }

    // Debug route checking
    console.log('Available routes check:', {
        'pricing-plans.index': '{{ route("admin.pricing-plans.index") }}',
        'pricing-plans.create': '{{ route("admin.pricing-plans.create") }}',
        'current_url': window.location.href,
        'csrf_token': getCsrfToken() ? 'Available' : 'Missing'
    });

    // Check for any PHP errors in console
    @if($errors->any())
        console.error('PHP Errors found:', @json($errors->all()));
    @endif

    @if(session('error'))
        console.error('Session Error:', @json(session('error')));
    @endif
});

// Handle window resize for responsive sorting
window.addEventListener('resize', function() {
    if (sortableInstance) {
        // Recreate sortable instance when window size changes
        const wasActive = true;
        enableSortMode(); // Exit
        enableSortMode(); // Re-enable
    }
});

// Add CSS for sortable states
const style = document.createElement('style');
style.textContent = `
    .sortable-ghost {
        opacity: 0.5;
        background: #f3f4f6;
    }
    .sortable-chosen {
        cursor: grabbing !important;
    }
    .sortable-drag {
        opacity: 0.8;
        transform: scale(1.02);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    .notification-toast {
        word-wrap: break-word;
        max-width: 400px;
    }
`;
document.head.appendChild(style);

// Log page initialization
console.log('Pricing Plans Index page initialized', {
    'plans_count': {{ $plans->count() ?? 0 }},
    'total_plans': {{ $stats['total'] ?? 0 }},
    'timestamp': new Date().toISOString()
});
</script>
@endpush