@extends('admin.layouts.app')

@section('title', 'Services Management')
@section('page-title', 'Services Management')

@section('content')
    <div class="space-y-6">

        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Manage Services</h2>
                <p class="text-gray-600 text-sm mt-1">Control all your services content and settings</p>
            </div>
            <a href="{{ route('admin.services.create') }}"
                class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>
                <span>Add New Service</span>
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
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

        @if (session('error'))
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
                        <p class="text-blue-100 text-sm font-medium">Total Services</p>
                        <p class="text-2xl font-bold">{{ $services->total() }}</p>
                    </div>
                    <i class="fas fa-cogs text-3xl text-blue-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Active</p>
                        <p class="text-2xl font-bold">{{ $services->where('status', 'active')->count() }}</p>
                    </div>
                    <i class="fas fa-check-circle text-3xl text-green-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">Featured</p>
                        <p class="text-2xl font-bold">{{ $services->where('is_featured', true)->count() }}</p>
                    </div>
                    <i class="fas fa-star text-3xl text-yellow-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Inactive</p>
                        <p class="text-2xl font-bold">{{ $services->where('status', 'inactive')->count() }}</p>
                    </div>
                    <i class="fas fa-eye-slash text-3xl text-purple-200"></i>
                </div>
            </div>
        </div>

        <!-- Services Content -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-list mr-2 text-primary"></i>
                        All Services ({{ $services->total() }})
                    </h3>
                </div>
            </div>

            @if ($services->count() > 0)
                <!-- Desktop Grid -->
                <div class="hidden lg:block p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($services as $service)
                            <div
                                class="group bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200 hover:border-{{ $service->border_color }}/50 hover:shadow-lg transition-all duration-300">
                                <!-- Service Icon & Status -->
                                <div class="flex items-start justify-between mb-4">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-r {{ $service->getGradientClass() }} rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                        <i class="{{ $service->icon }} text-white text-2xl"></i>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if ($service->is_featured)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-star mr-1"></i>
                                                Featured
                                            </span>
                                        @endif
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only status-toggle"
                                                data-id="{{ $service->id }}" {{ $service->isActive() ? 'checked' : '' }}>
                                            <div
                                                class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-500">
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Service Content -->
                                <div class="space-y-3">
                                    <h4
                                        class="text-lg font-bold text-gray-900 group-hover:text-{{ $service->color_from }} transition-colors duration-300">
                                        {{ $service->title }}
                                    </h4>
                                    <p class="text-gray-600 text-sm line-clamp-3">{{ $service->description }}</p>

                                    <!-- Features Preview -->
                                    @if ($service->getFeatures())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach (array_slice($service->getFeatures(), 0, 2) as $feature)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-200 text-gray-700">
                                                    {{ $feature }}
                                                </span>
                                            @endforeach
                                            @if (count($service->getFeatures()) > 2)
                                                <span
                                                    class="text-xs text-gray-500">+{{ count($service->getFeatures()) - 2 }}
                                                    more</span>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Sort Order -->
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span>Order: {{ $service->sort_order }}</span>
                                        <span>{{ $service->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ $service->getUrl() }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                            title="View Service">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <a href="{{ route('admin.services.show', $service) }}"
                                            class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                            title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.services.page-content', $service) }}"
                                            class="text-purple-600 hover:text-purple-800 p-2 rounded-lg hover:bg-purple-50 transition-colors duration-200"
                                            title="Manage Page Content">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.services.edit', $service) }}"
                                            class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="deleteService({{ $service->id }}, '{{ addslashes($service->title) }}')"
                                            class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Mobile List -->
                <div class="lg:hidden divide-y divide-gray-100">
                    @foreach ($services as $service)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex space-x-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-r {{ $service->getGradientClass() }} rounded-lg flex items-center justify-center">
                                        <i class="{{ $service->icon }} text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $service->title }}
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $service->description }}
                                            </p>
                                            <div class="flex items-center mt-2 space-x-4">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Order: {{ $service->sort_order }}
                                                </span>
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $service->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($service->status) }}
                                                </span>
                                                @if ($service->is_featured)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <i class="fas fa-star mr-1"></i>
                                                        Featured
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2 ml-4">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only status-toggle"
                                                    data-id="{{ $service->id }}"
                                                    {{ $service->isActive() ? 'checked' : '' }}>
                                                <div
                                                    class="w-9 h-5 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all after:duration-200 peer-checked:bg-green-500">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-xs text-gray-400">
                                            {{ $service->created_at->diffForHumans() }}
                                        </span>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.services.edit', $service) }}"
                                                class="text-blue-600 hover:text-blue-800 p-1" title="Edit">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <button onclick="deleteService({{ $service->id }}, '{{ addslashes($service->title) }}')"
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
                    {{ $services->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div
                        class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-cogs text-4xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No services found</h3>
                    <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by creating your first service to showcase
                        your offerings.</p>
                    <a href="{{ route('admin.services.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>
                        Create Your First Service
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
                <p class="text-gray-600 mb-2">Are you sure you want to delete "<span id="serviceName" class="font-medium"></span>"?</p>
                <p class="text-gray-600 mb-6">This action cannot be undone and will remove it from your website.</p>
                <div class="flex space-x-3">
                    <button id="confirmDelete"
                        class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-3 rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 font-medium shadow-lg">
                        <span class="delete-text">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Service
                        </span>
                        <span class="delete-loading hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Deleting...
                        </span>
                    </button>
                    <button onclick="closeDeleteModal()"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl hover:bg-gray-200 transition-all duration-300 font-medium">
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
        let serviceName = null;

        // Status toggle functionality
        document.querySelectorAll('.status-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const id = this.dataset.id;
                const status = this.checked ? 'active' : 'inactive';
                
                console.log('Status update attempt:', { id, status });

                // Add loading state
                this.disabled = true;

                const url = `/admin/services/${id}/status`;
                console.log('Status update URL:', url);

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status: status })
                    })
                    .then(response => {
                        console.log('Status response:', response.status, response.statusText);
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Status update success:', data);
                        if (data.success) {
                            showNotification('Status updated successfully!', 'success');
                        } else {
                            throw new Error(data.message || 'Failed to update status');
                        }
                    })
                    .catch(error => {
                        console.error('Status update error:', error);
                        this.checked = !this.checked; // Revert checkbox
                        showNotification(`Failed to update status: ${error.message}`, 'error');
                    })
                    .finally(() => {
                        this.disabled = false;
                    });
            });
        });

        // Delete functionality
        function deleteService(id, name) {
            console.log('Delete service called:', { id, name });
            
            deleteId = id;
            serviceName = name;
            document.getElementById('serviceName').textContent = name;
            
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.bg-white').classList.remove('scale-95');
                modal.querySelector('.bg-white').classList.add('scale-100');
            }, 10);
        }

        function closeDeleteModal() {
            console.log('Closing delete modal');
            const modal = document.getElementById('deleteModal');
            modal.querySelector('.bg-white').classList.remove('scale-100');
            modal.querySelector('.bg-white').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                deleteId = null;
                serviceName = null;
                
                // Reset button state
                const btn = document.getElementById('confirmDelete');
                btn.disabled = false;
                const deleteText = btn.querySelector('.delete-text');
                const deleteLoading = btn.querySelector('.delete-loading');
                if (deleteText) deleteText.classList.remove('hidden');
                if (deleteLoading) deleteLoading.classList.add('hidden');
            }, 300);
        }

        // Delete confirmation with AJAX POST - FINAL WORKING SOLUTION
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (!deleteId) {
                console.error('No deleteId set');
                return;
            }

            console.log('Confirming delete for service:', { deleteId, serviceName });
            
            const btn = this;
            btn.disabled = true;
            
            const deleteText = btn.querySelector('.delete-text');
            const deleteLoading = btn.querySelector('.delete-loading');
            
            if (deleteText) deleteText.classList.add('hidden');
            if (deleteLoading) deleteLoading.classList.remove('hidden');

            // Use AJAX POST to delete route
            submitDeleteRequest();
        });

        // Final working delete function using POST to /delete endpoint
        function submitDeleteRequest() {
            console.log('Submitting delete request for service:', deleteId);
            
            const url = `/admin/services/${deleteId}/delete`;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            console.log('Delete URL:', url);
            console.log('CSRF Token:', token);
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('Delete response:', response.status, response.statusText);
                
                if (response.ok) {
                    return response.json().then(data => {
                        console.log('Delete success:', data);
                        showNotification(`Service "${serviceName}" deleted successfully!`, 'success');
                        closeDeleteModal();
                        
                        // Reload page after short delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    });
                } else if (response.status === 404) {
                    throw new Error('Service not found - it may have been already deleted');
                } else if (response.status === 422) {
                    throw new Error('Validation error');
                } else {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                showNotification(`Failed to delete service: ${error.message}`, 'error');
                
                // Reset button state on error
                const btn = document.getElementById('confirmDelete');
                btn.disabled = false;
                const deleteText = btn.querySelector('.delete-text');
                const deleteLoading = btn.querySelector('.delete-loading');
                if (deleteText) deleteText.classList.remove('hidden');
                if (deleteLoading) deleteLoading.classList.add('hidden');
                
                // Don't close modal on error so user can try again
            });
        }

        // Enhanced notification function
        function showNotification(message, type = 'success') {
            console.log('Showing notification:', { message, type });
            
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';

            notification.className =
                `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white max-w-sm`;
            notification.innerHTML = `
                <div class="flex items-start">
                    <i class="fas ${icon} mr-2 mt-1 flex-shrink-0"></i>
                    <span class="text-sm">${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
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

        // Debug on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Services index page loaded');
            
            // Check if CSRF token exists
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found! Make sure you have @csrf in your layout.');
            } else {
                console.log('CSRF token found:', csrfToken.getAttribute('content'));
            }
        });

        // Global error handler for debugging
        window.addEventListener('error', function(e) {
            console.error('JavaScript error:', {
                message: e.message,
                filename: e.filename,
                lineno: e.lineno,
                colno: e.colno,
                error: e.error
            });
        });
    </script>
@endpush