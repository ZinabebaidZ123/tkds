@extends('admin.layouts.app')

@section('title', 'Service Details - ' . $service->title)
@section('page-title', 'Service Details')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.services.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.services.index') }}" class="hover:text-primary transition-colors duration-200">Services</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ $service->title }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">{{ $service->title }}</h2>
                <p class="text-gray-600 text-sm mt-1">View service details and settings</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="{{ $service->getUrl() }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                <i class="fas fa-external-link-alt mr-2"></i>
                View Live
            </a>
            <a href="{{ route('admin.services.edit', $service) }}" 
               class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Edit Service
            </a>
        </div>
    </div>

    <!-- Service Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Basic Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-primary"></i>
                        Basic Information
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    
                    <!-- Service Preview Card -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200">
                        <div class="flex items-start space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-r {{ $service->getGradientClass() }} rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="{{ $service->icon }} text-white text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $service->title }}</h4>
                                        <p class="text-gray-600 text-sm mb-3">{{ $service->description }}</p>
                                        @if($service->is_featured)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-star mr-1"></i>
                                                Featured Service
                                            </span>
                                        @endif
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $service->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Slug (URL)</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $service->slug }}</p>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Display Order</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $service->sort_order }}</p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Icon Class</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg flex items-center">
                                <i class="{{ $service->icon }} mr-2"></i>
                                {{ $service->icon }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-semibold text-gray-700">Color Scheme</label>
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 bg-{{ $service->color_from }} rounded border border-gray-300"></div>
                                <span class="text-gray-600">to</span>
                                <div class="w-6 h-6 bg-{{ $service->color_to }} rounded border border-gray-300"></div>
                                <span class="text-sm text-gray-600">{{ $service->color_from }} → {{ $service->color_to }}</span>
                            </div>
                        </div>
                    </div>

                    @if($service->route_name || $service->external_url)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($service->route_name)
                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700">Route Name</label>
                                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $service->route_name }}</p>
                                </div>
                            @endif

                            @if($service->external_url)
                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700">External URL</label>
                                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg break-all">{{ $service->external_url }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Features -->
            @if($service->getFeatures())
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-list mr-2 text-primary"></i>
                            Features ({{ count($service->getFeatures()) }})
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($service->getFeatures() as $feature)
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-check text-{{ $service->color_from }} flex-shrink-0"></i>
                                    <span class="text-gray-800">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- SEO Information -->
            @if($service->meta_title || $service->meta_description)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-search mr-2 text-primary"></i>
                            SEO Information
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($service->meta_title)
                            <div class="space-y-1">
                                <label class="text-sm font-semibold text-gray-700">Meta Title</label>
                                <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $service->meta_title }}</p>
                            </div>
                        @endif

                        @if($service->meta_description)
                            <div class="space-y-1">
                                <label class="text-sm font-semibold text-gray-700">Meta Description</label>
                                <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $service->meta_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- Service Image -->
            @if($service->image)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-image mr-2 text-primary"></i>
                            Service Image
                        </h3>
                    </div>
                    <div class="p-6">
                        <img src="{{ $service->getImageUrl() }}" 
                             alt="{{ $service->title }}"
                             class="w-full h-48 object-cover rounded-lg border border-gray-200 shadow-sm">
                    </div>
                </div>
            @endif

            <!-- Statistics -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        Statistics
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Created</span>
                        <span class="text-sm font-medium text-gray-900">{{ $service->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $service->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Features Count</span>
                        <span class="text-sm font-medium text-gray-900">{{ count($service->getFeatures()) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $service->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($service->status) }}
                        </span>
                    </div>
                    @if($service->is_featured)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Featured</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-star mr-1"></i>
                                Yes
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt mr-2 text-primary"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.services.edit', $service) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Service
                    </a>
                    <a href="{{ $service->getUrl() }}" 
                       target="_blank"
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        View Live
                    </a>
                    <button onclick="toggleStatus({{ $service->id }}, '{{ $service->status }}')"
                            class="w-full inline-flex items-center justify-center px-4 py-3 {{ $service->isActive() ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} rounded-lg transition-colors duration-200">
                        <i class="fas fa-{{ $service->isActive() ? 'eye-slash' : 'eye' }} mr-2"></i>
                        {{ $service->isActive() ? 'Deactivate' : 'Activate' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleStatus(id, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    
    fetch(`{{ route('admin.services.index') }}/${id}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: newStatus })
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
</script>
@endpush