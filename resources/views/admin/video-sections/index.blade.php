@extends('admin.layouts.app')
@section('page-title', 'Video Sections Management')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Video Sections</h1>
            <p class="text-gray-600 mt-1">Manage your video sections and live streams</p>
        </div>
        <a href="{{ route('admin.video-sections.create') }}" 
           class ="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>
            Add Video Section
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <!-- Video Sections Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        
        @if($videoSections->count() > 0)
        
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">
                    Total Sections: {{ $videoSections->total() }}
                </h3>
                <div class="text-sm text-gray-600">
                    Showing {{ $videoSections->firstItem() ?? 0 }} to {{ $videoSections->lastItem() ?? 0 }}
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Section Details
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Video Info
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Settings
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="sortable-sections">
                    @foreach($videoSections as $section)
                    <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $section->id }}">
                        
                        <!-- Section Details -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <!-- Drag Handle -->
                                <div class="drag-handle mr-3 cursor-move text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-grip-vertical"></i>
                                </div>
                                
                                <!-- Thumbnail -->
                                <div class="flex-shrink-0 h-16 w-24 mr-4">
                                    @if($section->thumbnail)
                                        <img src="{{ $section->thumbnail_url }}" 
                                             alt="{{ $section->title }}" 
                                             class="h-16 w-24 object-cover rounded-lg border border-gray-200">
                                    @else
                                        <div class="h-16 w-24 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Details -->
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $section->title }}
                                    </div>
                                    @if($section->subtitle)
                                        <div class="text-sm text-gray-500">
                                            {{ Str::limit($section->subtitle, 50) }}
                                        </div>
                                    @endif
                                    <div class="text-xs text-gray-400 mt-1">
                                        Order: {{ $section->sort_order }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Video Info -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <!-- Video Type Badge -->
                                @if($section->isLiveStream())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mb-2">
                                        <div class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5 animate-pulse"></div>
                                        Live Stream
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                        <i class="fas fa-video text-blue-600 mr-1"></i>
                                        Upload
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Video Source Info -->
                            {{-- <div class="text-xs text-gray-500">
                                @if($section->hasVideo())
                                    @if($section->isLiveStream())
                                        <div class="flex items-center">
                                            <i class="fas fa-link mr-1"></i>
                                            {{ Str::limit($section->video_url, 10) }}
                                        </div>
                                    @else
                                        <div class="flex items-center">
                                            <i class="fas fa-file-video mr-1"></i>
                                            {{ basename($section->video_file) }}
                                        </div>
                                    @endif
                                @else
                                    <span class="text-red-500">No video source</span>
                                @endif
                            </div> --}}
                        </td>

                        <!-- Settings -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="space-y-1">
                                <!-- Video Options -->
                                <div class="flex flex-wrap gap-1">
                                    @if($section->shouldAutoplay())
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-green-100 text-green-800">
                                            Autoplay
                                        </span>
                                    @endif
                                    @if($section->shouldLoop())
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-blue-100 text-blue-800">
                                            Loop
                                        </span>
                                    @endif
                                    @if($section->isMuted())
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-yellow-100 text-yellow-800">
                                            Muted
                                        </span>
                                    @endif
                                    @if($section->hasControls())
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-purple-100 text-purple-800">
                                            Controls
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Button Info -->
                                @if($section->button_text)
                                    <div class="text-xs text-gray-500">
                                        <i class="fas fa-mouse-pointer mr-1"></i>
                                        {{ $section->button_text }}
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       class="sr-only status-toggle" 
                                       data-id="{{ $section->id }}"
                                       {{ $section->isActive() ? 'checked' : '' }}>
                                <div class="relative">
                                    <div class="block bg-gray-600 w-14 h-8 rounded-full transition-colors {{ $section->isActive() ? 'bg-green-600' : '' }}"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform {{ $section->isActive() ? 'transform translate-x-6' : '' }}"></div>
                                </div>
                            </label>
                            
                            <div class="text-xs text-gray-500 mt-1 text-center">
                                {{ $section->status_display }}
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <!-- Preview Button -->
                                @if($section->hasVideo())
                                    <button type="button" 
                                            class="text-blue-600 hover:text-blue-900 preview-btn"
                                            data-video="{{ $section->video_source }}"
                                            data-title="{{ $section->title }}"
                                            title="Preview Video">
                                        <i class="fas fa-play"></i>
                                    </button>
                                @endif
                                
                                <!-- Edit Button -->
                                <a href="{{ route('admin.video-sections.edit', $section) }}" 
                                   class="text-indigo-600 hover:text-indigo-900" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- Delete Button -->
                                <form method="POST" 
                                      action="{{ route('admin.video-sections.destroy', $section) }}" 
                                      class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="text-red-600 hover:text-red-900 delete-btn" 
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($videoSections->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $videoSections->links() }}
        </div>
        @endif

        @else
        
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-video text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Video Sections</h3>
            <p class="text-gray-500 mb-6">Get started by creating your first video section.</p>
            <a href="{{ route('admin.video-sections.create') }}" 
               class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>
                Create Video Section
            </a>
        </div>
        
        @endif
    </div>
</div>

<!-- Video Preview Modal -->
<div id="video-preview-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-4xl w-full max-h-full overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h3 id="modal-title" class="text-lg font-medium text-gray-900">Video Preview</h3>
            <button id="close-modal" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="aspect-video bg-black rounded-lg overflow-hidden">
                <video id="preview-video" class="w-full h-full" controls>
                    <p class="text-white text-center p-8">Your browser doesn't support video playback.</p>
                </video>
            </div>
        </div>
    </div>
</div>

<style>
.drag-handle {
    touch-action: none;
}

.sortable-ghost {
    opacity: 0.5;
    background: #f3f4f6;
}

.status-toggle + div {
    transition: all 0.3s ease;
}

.status-toggle:checked + div {
    background-color: #10b981;
}

.status-toggle:checked + div .dot {
    transform: translateX(1.5rem);
}

/* Custom table hover effects */
tbody tr:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

/* Loading state */
.loading {
    opacity: 0.6;
    pointer-events: none;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize sortable
    const sortableElement = document.getElementById('sortable-sections');
    if (sortableElement) {
        new Sortable(sortableElement, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function(evt) {
                updateSortOrder();
            }
        });
    }
    
    // Status toggle functionality
    document.querySelectorAll('.status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const sectionId = this.dataset.id;
            const status = this.checked ? 'active' : 'inactive';
            
            fetch(`{{ route('admin.video-sections.status', ':id') }}`.replace(':id', sectionId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    this.checked = !this.checked;
                    alert('Failed to update status');
                }
            })
            .catch(error => {
                this.checked = !this.checked;
                console.error('Error:', error);
                alert('Failed to update status');
            });
        });
    });
    
    // Delete confirmation
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this video section? This action cannot be undone.')) {
                this.closest('.delete-form').submit();
            }
        });
    });
    
    // Video preview functionality
    const modal = document.getElementById('video-preview-modal');
    const modalTitle = document.getElementById('modal-title');
    const previewVideo = document.getElementById('preview-video');
    const closeModal = document.getElementById('close-modal');
    
    document.querySelectorAll('.preview-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const videoSrc = this.dataset.video;
            const title = this.dataset.title;
            
            modalTitle.textContent = title;
            previewVideo.src = videoSrc;
            modal.classList.remove('hidden');
        });
    });
    
    closeModal.addEventListener('click', function() {
        modal.classList.add('hidden');
        previewVideo.pause();
        previewVideo.src = '';
    });
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
            previewVideo.pause();
            previewVideo.src = '';
        }
    });
    
    // Update sort order
    function updateSortOrder() {
        const rows = document.querySelectorAll('#sortable-sections tr');
        const items = [];
        
        rows.forEach(function(row, index) {
            items.push({
                id: parseInt(row.dataset.id),
                sort_order: index
            });
        });
        
        fetch('{{ route('admin.video-sections.sort-order') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ items: items })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Failed to update sort order');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update sort order');
            location.reload();
        });
    }
});
</script>
@endsection