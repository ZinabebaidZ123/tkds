{{-- resources/views/admin/service-contact/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Service Contact Management')
@section('page-title', 'Service Contact Management')

@section('content')
    <div class="space-y-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Service Contact Management</h2>
                <p class="text-gray-600 text-sm mt-1">Configure contact emails for services and products inquiries</p>
            </div>
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Services</p>
                        <p class="text-2xl font-bold">{{ $stats['total_services'] }}</p>
                    </div>
                    <i class="fas fa-cogs text-3xl text-blue-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Services with Email</p>
                        <p class="text-2xl font-bold">{{ $stats['services_with_email'] }}</p>
                    </div>
                    <i class="fas fa-envelope text-3xl text-green-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Total Products</p>
                        <p class="text-2xl font-bold">{{ $stats['total_products'] }}</p>
                    </div>
                    <i class="fas fa-cube text-3xl text-purple-200"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Products with Email</p>
                        <p class="text-2xl font-bold">{{ $stats['products_with_email'] }}</p>
                    </div>
                    <i class="fas fa-mail-bulk text-3xl text-orange-200"></i>
                </div>
            </div>
        </div>

        <!-- Actions Bar -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Bulk Actions</h3>
                    <p class="text-sm text-gray-600">Apply changes to multiple items at once</p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="openBulkModal()" 
                            class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 font-medium">
                        <i class="fas fa-edit mr-2"></i>
                        Bulk Update
                    </button>
                    <button onclick="exportConfig()" 
                            class="px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 font-medium">
                        <i class="fas fa-download mr-2"></i>
                        Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-cogs mr-2 text-blue-600"></i>
                    Services ({{ $services->count() }})
                </h3>
            </div>

            <div class="p-6">
                <div class="space-y-4">
                    @forelse($services as $service)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="{{ $service->icon ?? 'fas fa-cog' }} text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $service->title }}</h4>
                                    <p class="text-sm text-gray-500">ID: {{ $service->id }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <input type="email" 
                                       value="{{ $service->contact_email }}"
                                       placeholder="Enter contact email"
                                       class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64"
                                       onchange="updateServiceEmail({{ $service->id }}, this.value)">
                                <button onclick="testEmail('service', {{ $service->id }}, this.previousElementSibling.value)" 
                                        class="px-3 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200"
                                        title="Test Email">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500">No services found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-cube mr-2 text-purple-600"></i>
                    Products ({{ $products->count() }})
                </h3>
            </div>

            <div class="p-6">
                <div class="space-y-4">
                    @forelse($products as $product)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="{{ $product->icon ?? 'fas fa-cube' }} text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $product->title }}</h4>
                                    <p class="text-sm text-gray-500">ID: {{ $product->id }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <input type="email" 
                                       value="{{ $product->contact_email }}"
                                       placeholder="Enter contact email"
                                       class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent w-64"
                                       onchange="updateProductEmail({{ $product->id }}, this.value)">
                                <button onclick="testEmail('product', {{ $product->id }}, this.previousElementSibling.value)" 
                                        class="px-3 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200"
                                        title="Test Email">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500">No products found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Update Modal -->
    <div id="bulkModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 max-w-2xl w-full mx-4 shadow-2xl transform transition-all duration-300 scale-95">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Bulk Update Contact Emails</h3>
                <button onclick="closeBulkModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Email for All Services</label>
                    <input type="email" id="bulkServicesEmail" placeholder="services@tkdsmedia.com" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Email for All Products</label>
                    <input type="email" id="bulkProductsEmail" placeholder="products@tkdsmedia.com" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
            </div>
            
            <div class="flex space-x-3 mt-6">
                <button onclick="applyBulkUpdate()" 
                        class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 font-medium">
                    Apply Changes
                </button>
                <button onclick="closeBulkModal()" 
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl hover:bg-gray-200 transition-all duration-300 font-medium">
                    Cancel
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Update service email
        function updateServiceEmail(serviceId, email) {
            if (!email) {
                email = '';
            }
            
            const inputElement = event.target;
            
            fetch(`/admin/service-contact/services/${serviceId}/email`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ contact_email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    inputElement.value = data.service.contact_email || '';
                    inputElement.style.borderColor = '#10B981';
                    setTimeout(() => {
                        inputElement.style.borderColor = '';
                    }, 2000);
                } else {
                    showNotification('Failed to update email: ' + (data.message || 'Unknown error'), 'error');
                    inputElement.style.borderColor = '#EF4444';
                    setTimeout(() => {
                        inputElement.style.borderColor = '';
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Something went wrong', 'error');
                inputElement.style.borderColor = '#EF4444';
                setTimeout(() => {
                    inputElement.style.borderColor = '';
                }, 2000);
            });
        }

        // Update product email
        function updateProductEmail(productId, email) {
            if (!email) {
                email = '';
            }
            
            const inputElement = event.target;
            
            fetch(`/admin/service-contact/products/${productId}/email`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ contact_email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    inputElement.value = data.product.contact_email || '';
                    inputElement.style.borderColor = '#10B981';
                    setTimeout(() => {
                        inputElement.style.borderColor = '';
                    }, 2000);
                } else {
                    showNotification('Failed to update email: ' + (data.message || 'Unknown error'), 'error');
                    inputElement.style.borderColor = '#EF4444';
                    setTimeout(() => {
                        inputElement.style.borderColor = '';
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Something went wrong', 'error');
                inputElement.style.borderColor = '#EF4444';
                setTimeout(() => {
                    inputElement.style.borderColor = '';
                }, 2000);
            });
        }

        // Test email functionality
        function testEmail(type, id, email) {
            if (!email) {
                showNotification('Please enter an email address first', 'error');
                return;
            }

            const btn = event.target.closest('button');
            const originalIcon = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;

            fetch('/admin/service-contact/test-email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    item_type: type,
                    item_id: id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Test email sent successfully!', 'success');
                } else {
                    showNotification('Failed to send test email: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Something went wrong', 'error');
            })
            .finally(() => {
                btn.innerHTML = originalIcon;
                btn.disabled = false;
            });
        }

        // Bulk modal functions
        function openBulkModal() {
            const modal = document.getElementById('bulkModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.bg-white').classList.remove('scale-95');
                modal.querySelector('.bg-white').classList.add('scale-100');
            }, 10);
        }

        function closeBulkModal() {
            const modal = document.getElementById('bulkModal');
            modal.querySelector('.bg-white').classList.remove('scale-100');
            modal.querySelector('.bg-white').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function applyBulkUpdate() {
            const servicesEmail = document.getElementById('bulkServicesEmail').value;
            const productsEmail = document.getElementById('bulkProductsEmail').value;

            if (!servicesEmail && !productsEmail) {
                showNotification('Please enter at least one email address', 'error');
                return;
            }

            const items = [];

            // Add all services
            @foreach($services as $service)
                if (servicesEmail) {
                    items.push({
                        type: 'service',
                        id: {{ $service->id }},
                        email: servicesEmail
                    });
                }
            @endforeach

            // Add all products
            @foreach($products as $product)
                if (productsEmail) {
                    items.push({
                        type: 'product',
                        id: {{ $product->id }},
                        email: productsEmail
                    });
                }
            @endforeach

            fetch('/admin/service-contact/bulk-update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ items: items })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeBulkModal();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification('Failed to update emails', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Something went wrong', 'error');
            });
        }

        function exportConfig() {
            showNotification('Export feature coming soon!', 'info');
        }

        // Notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : 
                           type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            const icon = type === 'success' ? 'fa-check-circle' : 
                        type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';

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
                closeBulkModal();
            }
        });

        // Close modal on background click
        document.getElementById('bulkModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBulkModal();
            }
        });
    </script>
@endpush