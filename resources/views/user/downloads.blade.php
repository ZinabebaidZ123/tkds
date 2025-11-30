{{-- File: resources/views/user/downloads.blade.php --}}
@extends('layouts.user')

@section('title', 'My Downloads - TKDS Media')
@section('meta_description', 'Access your purchased software downloads and digital products')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark via-dark-light to-dark">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-white mb-2">My Downloads</h1>
            <p class="text-gray-400">Access your purchased software and digital products</p>
        </div>

        <!-- Downloads Grid -->
        @if($downloads->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($downloads as $download)
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10 hover:border-primary/30 transition-all duration-300">
                        
                        <!-- Product Info -->
                        <div class="flex items-start space-x-4 mb-6">
                            <img src="{{ $download->product->getFeaturedImageUrl() }}" 
                                 alt="{{ $download->product->name }}" 
                                 class="w-16 h-16 object-cover rounded-xl border border-white/20">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-white truncate">{{ $download->product->name }}</h3>
                                <p class="text-gray-400 text-sm">Order: {{ $download->order->order_number }}</p>
                                <p class="text-gray-500 text-xs">{{ $download->created_at->format('M j, Y') }}</p>
                            </div>
                        </div>

                        <!-- File Info -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400 text-sm">File Name:</span>
                                <span class="text-white text-sm font-medium">{{ $download->file_name }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400 text-sm">File Size:</span>
                                <span class="text-white text-sm">{{ $download->getFormattedFileSize() }}</span>
                            </div>
                        </div>

                        <!-- Download Status -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400 text-sm">Downloads:</span>
                                <span class="text-white text-sm">{{ $download->getDownloadsStatus() }}</span>
                            </div>
                            
                            @if($download->expires_at)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-sm">Expires:</span>
                                    <span class="text-white text-sm">{{ $download->getExpiryStatus() }}</span>
                                </div>
                            @endif

                            @if($download->last_downloaded_at)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400 text-sm">Last Downloaded:</span>
                                    <span class="text-white text-sm">{{ $download->last_downloaded_at->diffForHumans() }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Status Badge -->
                        <div class="mb-6">
                            @php $statusBadge = $download->getStatusBadge() @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusBadge['class'] }}">
                                <i class="{{ $statusBadge['icon'] }} mr-1"></i>
                                {{ $statusBadge['text'] }}
                            </span>
                        </div>

                        <!-- Download Button -->
                        @if($download->canDownload())
                            <a href="{{ $download->getDownloadUrl() }}" 
                               class="w-full inline-flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <i class="fas fa-download"></i>
                                <span>Download Now</span>
                            </a>
                        @else
                            <button disabled 
                                    class="w-full inline-flex items-center justify-center space-x-2 px-6 py-3 bg-gray-600 text-gray-400 font-bold rounded-xl cursor-not-allowed opacity-50">
                                <i class="fas fa-ban"></i>
                                <span>Download Unavailable</span>
                            </button>
                        @endif

                        <!-- Additional Actions -->
                        <div class="mt-4 flex space-x-3">
                            <button onclick="showDownloadInfo({{ $download->id }})" 
                                    class="flex-1 text-center px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors duration-200 text-sm">
                                <i class="fas fa-info-circle mr-1"></i>
                                Details
                            </button>
                            
                            @if($download->canDownload())
                                <button onclick="resendDownloadLink({{ $download->id }})" 
                                        class="flex-1 text-center px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors duration-200 text-sm">
                                    <i class="fas fa-envelope mr-1"></i>
                                    Email Link
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $downloads->links() }}
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-download text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">No Downloads Available</h3>
                <p class="text-gray-400 mb-6 max-w-md mx-auto">You haven't purchased any digital products yet. Browse our software collection to get started.</p>
                <a href="{{ route('shop.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Browse Software
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Download Info Modal -->
<div id="downloadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-dark rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl border border-white/10">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white">Download Information</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="modalContent" class="text-gray-300">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<script>
function showDownloadInfo(downloadId) {
    const modal = document.getElementById('downloadModal');
    const content = document.getElementById('modalContent');
    
    content.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-primary"></i></div>';
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    fetch(`/shop/download/${downloadId}/preview`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const download = data.download;
                content.innerHTML = `
                    <div class="space-y-4">
                        <div>
                            <span class="text-gray-400 text-sm block mb-1">Product:</span>
                            <p class="text-white font-medium">${download.product_name}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-sm block mb-1">Order Number:</span>
                            <p class="text-white">${download.order_number}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-sm block mb-1">File Size:</span>
                            <p class="text-white">${download.file_size}</p>
                        </div>
                        <div>
                            <span class="text-gray-400 text-sm block mb-1">Downloads Remaining:</span>
                            <p class="text-white">${download.downloads_status}</p>
                        </div>
                        ${download.expires_at ? `
                        <div>
                            <span class="text-gray-400 text-sm block mb-1">Expires:</span>
                            <p class="text-white">${download.expires_at}</p>
                        </div>
                        ` : ''}
                        ${download.last_downloaded_at ? `
                        <div>
                            <span class="text-gray-400 text-sm block mb-1">Last Downloaded:</span>
                            <p class="text-white">${download.last_downloaded_at}</p>
                        </div>
                        ` : ''}
                    </div>
                `;
            } else {
                content.innerHTML = '<p class="text-red-400">Failed to load download information.</p>';
            }
        })
        .catch(error => {
            content.innerHTML = '<p class="text-red-400">Error loading download information.</p>';
        });
}

function resendDownloadLink(downloadId) {
    fetch('/shop/download/resend', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ download_id: downloadId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Download link sent to your email!', 'success');
        } else {
            showNotification(data.message || 'Failed to send download link', 'error');
        }
    })
    .catch(error => {
        showNotification('Something went wrong', 'error');
    });
}

function closeModal() {
    const modal = document.getElementById('downloadModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle mr-2"></i>
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
        closeModal();
    }
});

// Close modal on background click
document.getElementById('downloadModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection