@extends('admin.layouts.app')

@section('title', 'Contact FAQs')
@section('page-title', 'Contact FAQs Management')

@section('content')
<div class="space-y-6">
    
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Contact FAQs</h2>
            <p class="text-gray-600 text-sm mt-1">Manage frequently asked questions for the contact page</p>
        </div>
        <a href="{{ route('admin.contact.faqs.create') }}" 
           class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>
            <span>Add New FAQ</span>
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
                    <p class="text-blue-100 text-sm font-medium">Total FAQs</p>
                    <p class="text-2xl font-bold">{{ $faqs->total() }}</p>
                </div>
                <i class="fas fa-question-circle text-3xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active</p>
                    <p class="text-2xl font-bold">{{ $faqs->where('status', 'active')->count() }}</p>
                </div>
                <i class="fas fa-check-circle text-3xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Inactive</p>
                    <p class="text-2xl font-bold">{{ $faqs->where('status', 'inactive')->count() }}</p>
                </div>
                <i class="fas fa-eye-slash text-3xl text-yellow-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Categories</p>
                    <p class="text-2xl font-bold">{{ $faqs->pluck('category')->unique()->count() }}</p>
                </div>
                <i class="fas fa-tags text-3xl text-purple-200"></i>
            </div>
        </div>
    </div>

    <!-- FAQs Content -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-question-circle mr-2 text-primary"></i>
                    All FAQs ({{ $faqs->total() }})
                </h3>
                
                <!-- Filter by Category -->
                <form method="GET" class="flex items-center space-x-2">
                    <select name="category" onchange="this.form.submit()" 
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">All Categories</option>
                        @foreach($faqs->pluck('category')->unique() as $category)
                            <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $category)) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        
        @if($faqs->count() > 0)
            <!-- FAQs grouped by category -->
            @php
                $faqsByCategory = $faqs->groupBy('category');
            @endphp
            
            <div class="divide-y divide-gray-100">
                @foreach($faqsByCategory as $category => $categoryFaqs)
                    <div class="p-6 bg-gray-50/50">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-folder-open mr-2 text-primary"></i>
                            {{ ucwords(str_replace('_', ' ', $category)) }} 
                            <span class="ml-2 text-sm font-normal text-gray-500">({{ $categoryFaqs->count() }} FAQs)</span>
                        </h4>
                        
                        <div class="grid gap-4" id="sortable-{{ $category }}">
                            @foreach($categoryFaqs->sortBy('sort_order') as $faq)
                                <div class="faq-item bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-all duration-300" data-id="{{ $faq->id }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-3 mb-3">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Order: {{ $faq->sort_order }}
                                                </span>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $faq->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($faq->status) }}
                                                </span>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $faq->getCategoryLabel() }}
                                                </span>
                                            </div>
                                            
                                            <h5 class="text-lg font-semibold text-gray-900 mb-2">{{ $faq->question }}</h5>
                                            <p class="text-gray-600 text-sm line-clamp-3">{{ Str::limit($faq->answer, 200) }}</p>
                                            
                                            <div class="flex items-center justify-between mt-4 text-sm text-gray-500">
                                                <span>Created {{ $faq->created_at->diffForHumans() }}</span>
                                                <span>Updated {{ $faq->updated_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2 ml-4">
                                            <!-- Status Toggle -->
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" 
                                                       class="sr-only status-toggle" 
                                                       data-id="{{ $faq->id }}"
                                                       {{ $faq->isActive() ? 'checked' : '' }}>
                                                <div class="w-9 h-5 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none"></div>
                                            </label>
                                            
                                            <!-- Action Buttons -->
                                            <a href="{{ route('admin.contact.faqs.edit', $faq) }}" 
                                               class="text-blue-600 hover:text-blue-800 p-2 rounded hover:bg-blue-50 transition-colors duration-200"
                                               title="Edit FAQ">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <button onclick="deleteFaq({{ $faq->id }})" 
                                                    class="text-red-600 hover:text-red-800 p-2 rounded hover:bg-red-50 transition-colors duration-200"
                                                    title="Delete FAQ">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            
                                            <!-- Drag Handle -->
                                            <div class="drag-handle cursor-move text-gray-400 hover:text-gray-600 p-2">
                                                <i class="fas fa-grip-vertical"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $faqs->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-question-circle text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No FAQs found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by adding your first FAQ to help customers.</p>
                <a href="{{ route('admin.contact.faqs.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>
                    Add Your First FAQ
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
            <p class="text-gray-600 mb-6">Are you sure you want to delete this FAQ? This action cannot be undone.</p>
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
        
        fetch(`{{ route('admin.contact.faqs.index') }}/${id}/status`, {
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
                // Update status badge
                const faqItem = this.closest('.faq-item');
                const statusBadge = faqItem.querySelector('.bg-green-100, .bg-red-100');
                statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                statusBadge.className = `inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
                
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
function deleteFaq(id) {
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
        form.action = `{{ route('admin.contact.faqs.index') }}/${deleteId}`;
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    }
});

// Sortable functionality for reordering within categories
document.querySelectorAll('[id^="sortable-"]').forEach(sortableContainer => {
    if (typeof Sortable !== 'undefined') {
        new Sortable(sortableContainer, {
            animation: 150,
            ghostClass: 'opacity-50',
            handle: '.drag-handle',
            onEnd: function(evt) {
                const items = Array.from(sortableContainer.children).map((item, index) => ({
                    id: item.dataset.id,
                    sort_order: index + 1
                }));
                
                fetch(`{{ route('admin.contact.faqs.sort-order') }}`, {
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
                            const faqItem = document.querySelector(`[data-id="${item.id}"]`);
                            const orderBadge = faqItem.querySelector('.bg-blue-100');
                            if (orderBadge) {
                                orderBadge.textContent = `Order: ${index + 1}`;
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
