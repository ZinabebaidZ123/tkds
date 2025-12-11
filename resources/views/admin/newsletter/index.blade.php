{{-- resources/views/admin/newsletter/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Newsletter Management')
@section('page-title', 'Newsletter Management')

@section('content')
    <div class="space-y-6">
        
        <!-- Header with Stats -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        

            <!-- ✅ Stats Cards - أضيف Inactive -->
            <div class="flex justify-center items-center p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 max-w-5xl w-full">
                    
                    <!-- Total Subscribers -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 lg:p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-xs font-medium">Total Subscribers</p>
                                <p class="text-xl lg:text-2xl font-bold">{{ number_format($stats['total']) }}</p>
                            </div>
                            <i class="fas fa-users text-2xl lg:text-3xl text-blue-200"></i>
                        </div>
                    </div>

                    <!-- Active Subscribers -->
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 lg:p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-xs font-medium">Active</p>
                                <p class="text-xl lg:text-2xl font-bold">{{ number_format($stats['active']) }}</p>
                            </div>
                            <i class="fas fa-check-circle text-2xl lg:text-3xl text-green-200"></i>
                        </div>
                    </div>

                    <!-- ✅ NEW: Inactive Subscribers -->
                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-4 lg:p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-xs font-medium">Inactive</p>
                                <p class="text-xl lg:text-2xl font-bold">{{ number_format(($stats['total'] ?? 0) - ($stats['active'] ?? 0)) }}</p>
                            </div>
                            <i class="fas fa-pause-circle text-2xl lg:text-3xl text-yellow-200"></i>
                        </div>
                    </div>

                    <!-- Recent Subscribers -->
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 lg:p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-xs font-medium">Recent (7d)</p>
                                <p class="text-xl lg:text-2xl font-bold">{{ number_format($stats['recent']) }}</p>
                            </div>
                            <i class="fas fa-clock text-2xl lg:text-3xl text-purple-200"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                <!-- Search -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by email or name..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="unsubscribed" {{ request('status') === 'unsubscribed' ? 'selected' : '' }}>Unsubscribed</option>
                        <option value="bounced" {{ request('status') === 'bounced' ? 'selected' : '' }}>Bounced</option>
                        <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Blocked</option>
                    </select>
                </div>

       

                <!-- Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                    <input type="date" 
                           name="date_from" 
                           value="{{ request('date_from') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" 
                            class="px-2 py-2 min-w-[120px] bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.newsletter.index') }}" 
                       class="px-2 py-2 min-w-[120px] text-center bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Bulk Actions -->
        <div id="bulkActions" class="bg-blue-50 border border-blue-200 rounded-xl p-4 hidden">
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0">
                <span class="text-blue-800 font-medium text-sm sm:text-base">
                    <span id="selectedCount">0</span> subscribers selected
                </span>
                <div class="flex flex-wrap gap-2">
                    <button onclick="bulkAction('activate')" class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600 transition-colors">
                        <i class="fas fa-check mr-1"></i>Activate
                    </button>
                    <button onclick="bulkAction('unsubscribe')" class="px-3 py-1 bg-gray-500 text-white text-sm rounded hover:bg-gray-600 transition-colors">
                        <i class="fas fa-times mr-1"></i>Unsubscribe
                    </button>
                    <button onclick="bulkAction('block')" class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition-colors">
                        <i class="fas fa-ban mr-1"></i>Block
                    </button>
                    <button onclick="bulkAction('delete')" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- ✅ Newsletter Table - Fixed Overflow -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 lg:px-6 py-3 text-left">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span class="hidden sm:inline">Subscriber</span>
                                <span class="sm:hidden">Email</span>
                            </th>
                            <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="hidden md:table-cell px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Source
                            </th>
                            <th class="hidden lg:table-cell px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subscribed
                            </th>
                            <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($newsletters as $newsletter)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 lg:px-6 py-4">
                                    <input type="checkbox" class="newsletter-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" value="{{ $newsletter->id }}">
                                </td>
                                <td class="px-3 lg:px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 lg:h-10 lg:w-10">
                                            <div class="h-8 w-8 lg:h-10 lg:w-10 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                                                <span class="text-white font-medium text-xs lg:text-sm">
                                                    {{ strtoupper(substr($newsletter->email, 0, 1)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-2 lg:ml-4 min-w-0 flex-1">
                                            <div class="text-sm font-medium text-gray-900 truncate">{{ $newsletter->email }}</div>
                                            @if($newsletter->name)
                                                <div class="text-xs lg:text-sm text-gray-500 truncate">{{ $newsletter->name }}</div>
                                            @endif
                                            @if($newsletter->isVerified())
                                                <div class="flex items-center text-xs text-green-600 mt-1">
                                                    <i class="fas fa-shield-check mr-1"></i>
                                                    <span class="hidden sm:inline">Verified</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 lg:px-6 py-4">
                                    @php $badge = $newsletter->getStatusBadge(); @endphp
                                    <span class="inline-flex items-center px-2 lg:px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge['class'] }}">
                                        <i class="{{ $badge['icon'] }} mr-1"></i>
                                        <span class="hidden sm:inline">{{ $badge['text'] }}</span>
                                    </span>
                                </td>
                                <td class="hidden md:table-cell px-3 lg:px-6 py-4">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                                        {{ ucfirst($newsletter->source ?? 'Unknown') }}
                                    </span>
                                </td>
                                <td class="hidden lg:table-cell px-3 lg:px-6 py-4 text-sm text-gray-900">
                                    <div>{{ $newsletter->getFormattedCreatedAt() }}</div>
                                    <div class="text-xs text-gray-500">{{ $newsletter->getDaysAgo() }} days ago</div>
                                </td>
                                <td class="px-3 lg:px-6 py-4 text-sm font-medium">
                                    <div class="flex items-center space-x-1 lg:space-x-2">
                                        @if($newsletter->isActive())
                                            <button onclick="changeStatus({{ $newsletter->id }}, 'unsubscribed')" 
                                                    class="text-red-600 hover:text-red-900 p-1 rounded transition-colors" title="Unsubscribe">
                                                <i class="fas fa-times text-sm"></i>
                                            </button>
                                        @elseif($newsletter->isUnsubscribed())
                                            <button onclick="changeStatus({{ $newsletter->id }}, 'active')" 
                                                    class="text-green-600 hover:text-green-900 p-1 rounded transition-colors" title="Reactivate">
                                                <i class="fas fa-check text-sm"></i>
                                            </button>
                                        @endif

                                        <button onclick="deleteSubscriber({{ $newsletter->id }})" 
                                                class="text-red-600 hover:text-red-900 p-1 rounded transition-colors" title="Delete">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">No subscribers found</h3>
                                        <p class="text-gray-500">No newsletter subscribers match your current filters.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($newsletters->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $newsletters->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- ✅ Success/Error Messages - Responsive Fixed -->
    <div id="notification" class="fixed top-4 left-4 right-4 sm:left-auto sm:right-4 sm:w-96 z-50 hidden">
        <div class="w-full bg-white shadow-lg rounded-lg border border-gray-200 pointer-events-auto">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i id="notification-icon" class="text-xl"></i>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p id="notification-message" class="text-sm font-medium text-gray-900"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button onclick="hideNotification()" class="rounded-md inline-flex text-gray-400 hover:text-gray-500 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Select All functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.newsletter-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });

        // Individual checkbox functionality
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('newsletter-checkbox')) {
                updateBulkActions();
            }
        });

        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.newsletter-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            
            if (checkboxes.length > 0) {
                bulkActions.classList.remove('hidden');
                selectedCount.textContent = checkboxes.length;
            } else {
                bulkActions.classList.add('hidden');
            }
        }

        function deleteSubscriber(id) {
            if (!confirm('Are you sure you want to delete this subscriber? This action cannot be undone.')) {
                return;
            }

            // Show loading in notification
            showNotification('Deleting subscriber...', 'loading');

            fetch(`/admin/newsletter/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    // Remove row from table instead of full reload for better UX
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message || 'Failed to delete subscriber', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Something went wrong. Please try again.', 'error');
            });
        }

        function changeStatus(id, status) {
            // Show loading
            showNotification(`Updating status to ${status}...`, 'loading');

            fetch(`/admin/newsletter/${id}/status`, {
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
                    showNotification(data.message, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message || 'Failed to update status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Something went wrong. Please try again.', 'error');
            });
        }

        function bulkAction(action) {
            const checkboxes = document.querySelectorAll('.newsletter-checkbox:checked');
            const ids = Array.from(checkboxes).map(cb => cb.value);
            
            if (ids.length === 0) {
                showNotification('Please select at least one subscriber', 'error');
                return;
            }

            if (action === 'delete' && !confirm('Are you sure you want to delete the selected subscribers? This action cannot be undone.')) {
                return;
            }

            // Show loading
            showNotification(`Processing ${action} for ${ids.length} subscribers...`, 'loading');

            fetch('/admin/newsletter/bulk-action', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ action: action, ids: ids })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message || 'Bulk action failed', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Something went wrong. Please try again.', 'error');
            });
        }

        function exportSubscribers() {
            showNotification('Preparing export...', 'loading');
            const params = new URLSearchParams(window.location.search);
            window.open(`/admin/newsletter/export?${params.toString()}`, '_blank');
            
            setTimeout(() => {
                showNotification('Export started! Check your downloads.', 'success');
            }, 1000);
        }

        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            const icon = document.getElementById('notification-icon');
            const messageEl = document.getElementById('notification-message');
            
            messageEl.textContent = message;
            
            // Set icon and color based on type
            if (type === 'success') {
                icon.className = 'fas fa-check-circle text-green-500 text-xl';
                notification.querySelector('.bg-white').classList.add('border-l-4', 'border-green-500');
            } else if (type === 'error') {
                icon.className = 'fas fa-exclamation-circle text-red-500 text-xl';
                notification.querySelector('.bg-white').classList.add('border-l-4', 'border-red-500');
            } else if (type === 'loading') {
                icon.className = 'fas fa-spinner fa-spin text-blue-500 text-xl';
                notification.querySelector('.bg-white').classList.add('border-l-4', 'border-blue-500');
            }
            
            notification.classList.remove('hidden');
            
            // Auto-hide after delay (except for loading)
            if (type !== 'loading') {
                setTimeout(() => {
                    hideNotification();
                }, 5000);
            }
        }

        function hideNotification() {
            const notification = document.getElementById('notification');
            notification.classList.add('hidden');
            
            // Reset classes
            const bgElement = notification.querySelector('.bg-white');
            bgElement.classList.remove('border-l-4', 'border-green-500', 'border-red-500', 'border-blue-500');
        }

        // Auto-hide loading notifications after 10 seconds
        let notificationTimeout;
        const originalShowNotification = showNotification;
        showNotification = function(message, type) {
            clearTimeout(notificationTimeout);
            originalShowNotification(message, type);
            
            if (type === 'loading') {
                notificationTimeout = setTimeout(() => {
                    hideNotification();
                }, 10000);
            }
        };
    </script>
@endpush