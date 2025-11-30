{{-- File: resources/views/admin/contact/submissions/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Contact Submissions')
@section('page-title', 'Contact Submissions')

@section('content')
<div class="space-y-6">
    
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Contact Submissions</h2>
            <p class="text-gray-600 text-sm mt-1">Manage customer inquiries and messages</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.contact.submissions.export', request()->query()) }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Export CSV
            </a>
            <button onclick="showBulkActions()" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-check-square mr-2"></i>
                Bulk Actions
            </button>
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs font-medium">Total</p>
                    <p class="text-xl font-bold">{{ $stats['total'] }}</p>
                </div>
                <i class="fas fa-envelope text-2xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-xs font-medium">Unread</p>
                    <p class="text-xl font-bold">{{ $stats['unread'] }}</p>
                </div>
                <i class="fas fa-envelope text-2xl text-red-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-xs font-medium">Read</p>
                    <p class="text-xl font-bold">{{ $stats['read'] }}</p>
                </div>
                <i class="fas fa-envelope-open text-2xl text-yellow-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-xs font-medium">Replied</p>
                    <p class="text-xl font-bold">{{ $stats['replied'] }}</p>
                </div>
                <i class="fas fa-reply text-2xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-100 text-xs font-medium">Archived</p>
                    <p class="text-xl font-bold">{{ $stats['archived'] }}</p>
                </div>
                <i class="fas fa-archive text-2xl text-gray-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-xs font-medium">Recent (7d)</p>
                    <p class="text-xl font-bold">{{ $stats['recent'] }}</p>
                </div>
                <i class="fas fa-calendar text-2xl text-purple-200"></i>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search submissions..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            
            <!-- Status Filter -->
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Status</option>
                    <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                    <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            
            <!-- Service Filter -->
            <div>
                <select name="service" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Services</option>
                    <option value="live-streaming" {{ request('service') === 'live-streaming' ? 'selected' : '' }}>Live Streaming</option>
                    <option value="cloud-production" {{ request('service') === 'cloud-production' ? 'selected' : '' }}>Cloud Production</option>
                    <option value="ott-platform" {{ request('service') === 'ott-platform' ? 'selected' : '' }}>OTT Platform</option>
                    <option value="sports-broadcasting" {{ request('service') === 'sports-broadcasting' ? 'selected' : '' }}>Sports Broadcasting</option>
                    <option value="radio-streaming" {{ request('service') === 'radio-streaming' ? 'selected' : '' }}>Radio Streaming</option>
                    <option value="custom-solution" {{ request('service') === 'custom-solution' ? 'selected' : '' }}>Custom Solution</option>
                </select>
            </div>
            
            <!-- Sort -->
            <div>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">Latest First</option>
                    <option value="priority" {{ request('sort') === 'priority' ? 'selected' : '' }}>By Priority</option>
                </select>
            </div>
            
            <!-- Submit -->
            <div>
                <button type="submit" class="w-full px-4 py-2 bg-primary hover:bg-secondary text-white rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Submissions List -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-inbox mr-2 text-primary"></i>
                    Submissions ({{ $submissions->total() }})
                </h3>
                <div class="flex items-center space-x-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Select All</span>
                    </label>
                </div>
            </div>
        </div>
        
        @if($submissions->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($submissions as $submission)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200 {{ $submission->isUnread() ? 'bg-blue-50/50' : '' }}">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 mt-1">
                                <input type="checkbox" class="submission-checkbox rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" 
                                       value="{{ $submission->id }}">
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <h4 class="text-lg font-semibold text-gray-900 {{ $submission->isUnread() ? 'font-bold' : '' }}">
                                                {{ $submission->full_name }}
                                            </h4>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $submission->getStatusBadgeClass() }}">
                                                <i class="{{ $submission->getStatusIcon() }} mr-1"></i>
                                                {{ ucfirst($submission->status) }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $submission->getPriorityClass() }}">
                                                {{ $submission->getPriorityLabel() }} Priority
                                            </span>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-gray-600 mb-3">
                                            <div class="flex items-center">
                                                <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                                <a href="mailto:{{ $submission->email }}" class="hover:text-primary">{{ $submission->email }}</a>
                                            </div>
                                            @if($submission->phone)
                                                <div class="flex items-center">
                                                    <i class="fas fa-phone mr-2 text-gray-400"></i>
                                                    <a href="tel:{{ $submission->phone }}" class="hover:text-primary">{{ $submission->phone }}</a>
                                                </div>
                                            @endif
                                            @if($submission->service_interest)
                                                <div class="flex items-center">
                                                    <i class="fas fa-cog mr-2 text-gray-400"></i>
                                                    {{ $submission->getServiceInterestLabel() }}
                                                </div>
                                            @endif
                                            @if($submission->budget)
                                                <div class="flex items-center">
                                                    <i class="fas fa-dollar-sign mr-2 text-gray-400"></i>
                                                    {{ $submission->getBudgetLabel() }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <p class="text-gray-700 mb-3 line-clamp-2">{{ Str::limit($submission->message, 150) }}</p>
                                        
                                        <div class="flex items-center justify-between text-sm text-gray-500">
                                            <span>{{ $submission->created_at->diffForHumans() }}</span>
                                            @if($submission->replied_at)
                                                <span class="text-green-600">
                                                    <i class="fas fa-reply mr-1"></i>
                                                    Replied {{ $submission->replied_at->diffForHumans() }}
                                                    @if($submission->repliedByAdmin)
                                                        by {{ $submission->repliedByAdmin->name }}
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2 ml-4">
                                        <a href="{{ route('admin.contact.submissions.show', $submission) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg font-medium transition-colors duration-200">
                                            <i class="fas fa-eye mr-1"></i>
                                            View
                                        </a>
                                        
                                        <div class="relative">
                                            <button onclick="toggleStatusDropdown({{ $submission->id }})" 
                                                    class="inline-flex items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors duration-200">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            
                                            <div id="statusDropdown{{ $submission->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                                <div class="py-1">
                                                    <button onclick="updateStatus({{ $submission->id }}, 'read')" 
                                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i class="fas fa-envelope-open mr-2"></i>
                                                        Mark as Read
                                                    </button>
                                                    <button onclick="updateStatus({{ $submission->id }}, 'replied')" 
                                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i class="fas fa-reply mr-2"></i>
                                                        Mark as Replied
                                                    </button>
                                                    <button onclick="updateStatus({{ $submission->id }}, 'archived')" 
                                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i class="fas fa-archive mr-2"></i>
                                                        Archive
                                                    </button>
                                                    <div class="border-t border-gray-100"></div>
                                                    <button onclick="deleteSubmission({{ $submission->id }})" 
                                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                        <i class="fas fa-trash mr-2"></i>
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $submissions->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-inbox text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No submissions found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">No contact submissions match your current filters.</p>
            </div>
        @endif
    </div>
</div>

<!-- Bulk Actions Modal -->
<div id="bulkActionsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bulk Actions</h3>
        <p class="text-gray-600 mb-4">Select an action to apply to the selected submissions:</p>
        
        <div class="space-y-2 mb-6">
            <button onclick="performBulkAction('read')" class="w-full text-left px-4 py-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                <i class="fas fa-envelope-open mr-2 text-blue-600"></i>
                Mark as Read
            </button>
            <button onclick="performBulkAction('replied')" class="w-full text-left px-4 py-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                <i class="fas fa-reply mr-2 text-green-600"></i>
                Mark as Replied
            </button>
            <button onclick="performBulkAction('archived')" class="w-full text-left px-4 py-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                <i class="fas fa-archive mr-2 text-gray-600"></i>
                Archive
            </button>
            <button onclick="performBulkAction('delete')" class="w-full text-left px-4 py-3 hover:bg-red-50 rounded-lg transition-colors duration-200">
                <i class="fas fa-trash mr-2 text-red-600"></i>
                Delete
            </button>
        </div>
        
        <div class="flex space-x-3">
            <button onclick="closeBulkActions()" class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl hover:bg-gray-200 transition-all duration-300 font-medium">
                Cancel
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.submission-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Update individual status
function updateStatus(id, status) {
    fetch(`{{ route('admin.contact.submissions.index') }}/${id}/status`, {
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
            location.reload();
        } else {
            alert('Failed to update status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update status');
    });
}

// Toggle status dropdown
function toggleStatusDropdown(id) {
    // Close all other dropdowns
    document.querySelectorAll('[id^="statusDropdown"]').forEach(dropdown => {
        if (dropdown.id !== `statusDropdown${id}`) {
            dropdown.classList.add('hidden');
        }
    });
    
    const dropdown = document.getElementById(`statusDropdown${id}`);
    dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[onclick^="toggleStatusDropdown"]')) {
        document.querySelectorAll('[id^="statusDropdown"]').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});

// Bulk actions
function showBulkActions() {
    const checkedBoxes = document.querySelectorAll('.submission-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Please select at least one submission');
        return;
    }
    
    document.getElementById('bulkActionsModal').classList.remove('hidden');
    document.getElementById('bulkActionsModal').classList.add('flex');
}

function closeBulkActions() {
    document.getElementById('bulkActionsModal').classList.add('hidden');
    document.getElementById('bulkActionsModal').classList.remove('flex');
}

function performBulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.submission-checkbox:checked');
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (ids.length === 0) {
        alert('No submissions selected');
        return;
    }
    
    if (action === 'delete' && !confirm('Are you sure you want to delete the selected submissions?')) {
        return;
    }
    
    fetch('{{ route("admin.contact.submissions.bulk-actions") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            action: action,
            submissions: ids
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to perform bulk action');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to perform bulk action');
    });
    
    closeBulkActions();
}

// Delete submission
function deleteSubmission(id) {
    if (!confirm('Are you sure you want to delete this submission?')) {
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ route('admin.contact.submissions.index') }}/${id}`;
    form.innerHTML = `
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
    `;
    document.body.appendChild(form);
    form.submit();
}
</script>
@endpush