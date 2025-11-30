{{-- File: resources/views/admin/shop/downloads/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Downloads Management')
@section('page-title', 'Downloads Management')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Downloads Management</h2>
            <p class="text-gray-600 text-sm mt-1">Manage customer digital product downloads</p>
        </div>
        <div class="flex space-x-4">
            <button onclick="bulkAction()" 
                    class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                <i class="fas fa-tasks mr-2"></i>
                Bulk Actions
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Downloads</p>
                    <p class="text-2xl font-bold">{{ $stats['total_downloads'] }}</p>
                </div>
                <i class="fas fa-download text-2xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active</p>
                    <p class="text-2xl font-bold">{{ $stats['active_downloads'] }}</p>
                </div>
                <i class="fas fa-check-circle text-2xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Expired</p>
                    <p class="text-2xl font-bold">{{ $stats['expired_downloads'] }}</p>
                </div>
                <i class="fas fa-calendar-times text-2xl text-red-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Exhausted</p>
                    <p class="text-2xl font-bold">{{ $stats['exhausted_downloads'] }}</p>
                </div>
                <i class="fas fa-ban text-2xl text-orange-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Size</p>
                    <p class="text-2xl font-bold">{{ number_format($stats['total_file_size'] / 1024 / 1024, 1) }}MB</p>
                </div>
                <i class="fas fa-hdd text-2xl text-purple-200"></i>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search downloads..." 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="no_downloads_left" {{ request('status') == 'no_downloads_left' ? 'selected' : '' }}>No Downloads Left</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="flex-1 bg-primary text-white px-4 py-3 rounded-xl hover:bg-secondary transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.shop.downloads.index') }}" 
                   class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Downloads Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        @if($downloads->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-primary focus:ring-primary">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">File</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Order</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Downloads</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Expires</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($downloads as $download)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="selected_downloads[]" value="{{ $download->id }}" 
                                           class="download-checkbox rounded border-gray-300 text-primary focus:ring-primary">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-file text-blue-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $download->file_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $download->getFormattedFileSize() }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $download->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $download->user->email }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $download->product->getFeaturedImageUrl() }}" 
                                             alt="{{ $download->product->name }}" 
                                             class="w-10 h-10 object-cover rounded-lg border border-gray-200">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ Str::limit($download->product->name, 20) }}</div>
                                            <div class="text-xs text-gray-500">{{ $download->product->sku ?: 'No SKU' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.shop.orders.show', $download->order) }}" 
                                       class="text-sm font-medium text-primary hover:text-secondary">
                                        {{ $download->order->order_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($download->downloads_remaining === -1)
                                            <span class="text-green-600 font-semibold">Unlimited</span>
                                        @else
                                            <span class="font-semibold">{{ $download->downloads_remaining }}</span> remaining
                                        @endif
                                    </div>
                                    @if($download->last_downloaded_at)
                                        <div class="text-xs text-gray-500">
                                            Last: {{ $download->last_downloaded_at->format('M j, Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $download->getExpiryStatus() }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php $statusBadge = $download->getStatusBadge() @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusBadge['class'] }}">
                                        <i class="{{ $statusBadge['icon'] }} mr-1"></i>
                                        {{ $statusBadge['text'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        @if($download->canDownload())
                                            <a href="{{ $download->getDownloadUrl() }}" 
                                               class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                               title="Download File">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                        
                                        <button onclick="resetDownload({{ $download->id }})" 
                                                class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                                title="Reset Downloads">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                        
                                        <a href="{{ route('admin.shop.orders.show', $download->order) }}" 
                                           class="text-purple-600 hover:text-purple-800 p-2 rounded-lg hover:bg-purple-50 transition-colors duration-200"
                                           title="View Order">
                                            <i class="fas fa-receipt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $downloads->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-download text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No downloads found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Digital product downloads will appear here when customers purchase software products.</p>
            </div>
        @endif
    </div>
</div>

<!-- Bulk Actions Modal -->
<div id="bulkActionsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bulk Actions</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                <select id="bulkActionType" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="reset">Reset Downloads</option>
                    <option value="extend_expiry">Extend Expiry</option>
                    <option value="delete">Delete Downloads</option>
                </select>
            </div>
            <div id="extendDaysContainer" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Extend by (days)</label>
                <input type="number" id="extendDays" min="1" max="365" value="30" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
        </div>
        <div class="flex justify-end space-x-4 mt-6">
            <button onclick="closeBulkModal()" 
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50">
                Cancel
            </button>
            <button onclick="executeBulkAction()" 
                    class="px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary">
                Execute
            </button>
        </div>
    </div>
</div>

<script>
// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.download-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Show/hide extend days input
document.getElementById('bulkActionType').addEventListener('change', function() {
    const container = document.getElementById('extendDaysContainer');
    if (this.value === 'extend_expiry') {
        container.classList.remove('hidden');
    } else {
        container.classList.add('hidden');
    }
});

// Reset single download
function resetDownload(downloadId) {
    if (confirm('Are you sure you want to reset this download?')) {
        fetch(`{{ route('admin.shop.downloads.index') }}/${downloadId}/reset`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to reset download');
            }
        });
    }
}

// Bulk actions
function bulkAction() {
    const selected = document.querySelectorAll('.download-checkbox:checked');
    if (selected.length === 0) {
        alert('Please select downloads to perform bulk actions');
        return;
    }
    document.getElementById('bulkActionsModal').classList.remove('hidden');
}

function closeBulkModal() {
    document.getElementById('bulkActionsModal').classList.add('hidden');
}

function executeBulkAction() {
    const selected = document.querySelectorAll('.download-checkbox:checked');
    const action = document.getElementById('bulkActionType').value;
    const extendDays = document.getElementById('extendDays').value;
    
    const downloadIds = Array.from(selected).map(checkbox => checkbox.value);
    
    const payload = {
        action: action,
        download_ids: downloadIds
    };
    
    if (action === 'extend_expiry') {
        payload.extend_days = parseInt(extendDays);
    }
    
    fetch(`{{ route('admin.shop.downloads.bulk-actions') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Bulk action failed');
        }
    });
}
</script>
@endsection