@extends('layouts.user')

@section('title', 'Active Sessions - TKDS Media')
@section('meta_description', 'View and manage your active login sessions for security.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark via-dark-light to-dark py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <a href="{{ route('user.dashboard') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
            </div>
            <h1 class="text-3xl font-black text-white mb-2">Active Sessions</h1>
            <p class="text-gray-400">Monitor and manage your login sessions for enhanced security</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 mb-6 animate-fade-in">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-400 mr-3"></i>
                    <p class="text-green-400">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-6 animate-fade-in">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-400 mr-3"></i>
                    <p class="text-red-400">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Sessions Overview -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <!-- Total Sessions -->
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-white">{{ $sessions->total() }}</p>
                        <p class="text-gray-400 text-sm">Total Sessions</p>
                    </div>
                </div>
            </div>

            <!-- Active Sessions -->
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-white">{{ $sessions->where('is_active', true)->count() }}</p>
                        <p class="text-gray-400 text-sm">Active Now</p>
                    </div>
                </div>
            </div>

            <!-- Device Types -->
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-devices text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-white">{{ $sessions->groupBy('device_type')->count() }}</p>
                        <p class="text-gray-400 text-sm">Device Types</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sessions List -->
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden">
            <div class="p-6 border-b border-white/10">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <h2 class="text-xl font-bold text-white">Login Sessions</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-400">
                            Showing {{ $sessions->count() }} of {{ $sessions->total() }} sessions
                        </span>
                        @if($sessions->where('is_active', true)->count() > 1)
                            <button onclick="terminateAllOtherSessions()" 
                                    class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-500/30 transition-all duration-300">
                                <i class="fas fa-power-off mr-2"></i>
                                Terminate Others
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-white/5">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Device</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Login Time</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse($sessions as $session)
                            <tr class="hover:bg-white/5 transition-colors duration-200">
                                <!-- Device Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-r from-gray-600 to-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-{{ $session->device_type === 'mobile' ? 'mobile-alt' : ($session->device_type === 'tablet' ? 'tablet-alt' : 'desktop') }} text-white"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-white font-medium truncate">{{ $session->getDeviceInfo() }}</p>
                                            <p class="text-gray-400 text-sm truncate">{{ $session->ip_address }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Location -->
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <p class="text-white">{{ $session->getLocationInfo() }}</p>
                                        @if($session->location_country)
                                            <p class="text-gray-400">{{ $session->location_country }}</p>
                                        @endif
                                    </div>
                                </td>

                                <!-- Login Time -->
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <p class="text-white">{{ $session->login_at->format('M d, Y') }}</p>
                                        <p class="text-gray-400">{{ $session->login_at->format('g:i A') }}</p>
                                        <p class="text-gray-500 text-xs">{{ $session->login_at->diffForHumans() }}</p>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    @if($session->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                            <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                            Active
                                        </span>
                                        @if($session->session_id === session()->getId())
                                            <div class="mt-1">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary/20 text-primary">
                                                    Current Session
                                                </span>
                                            </div>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400">
                                            Ended
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">{{ $session->getDuration() }}</p>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    @if($session->is_active && $session->session_id !== session()->getId())
                                        <form method="POST" action="{{ route('user.sessions.terminate', $session->session_id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to terminate this session?')"
                                                    class="text-red-400 hover:text-red-300 transition-colors duration-200">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </form>
                                    @elseif($session->session_id === session()->getId())
                                        <span class="text-gray-500 text-sm">Current</span>
                                    @else
                                        <span class="text-gray-600">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <i class="fas fa-shield-alt text-4xl mb-4"></i>
                                        <p class="text-lg font-semibold">No sessions found</p>
                                        <p class="text-sm">Your login sessions will appear here.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden divide-y divide-white/10">
                @forelse($sessions as $session)
                    <div class="p-6 hover:bg-white/5 transition-colors duration-200">
                        <div class="flex items-start space-x-4">
                            <!-- Device Icon -->
                            <div class="w-12 h-12 bg-gradient-to-r from-gray-600 to-gray-700 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-{{ $session->device_type === 'mobile' ? 'mobile-alt' : ($session->device_type === 'tablet' ? 'tablet-alt' : 'desktop') }} text-white"></i>
                            </div>

                            <!-- Session Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-white font-semibold truncate">{{ $session->getDeviceInfo() }}</h3>
                                        <p class="text-gray-400 text-sm truncate">{{ $session->getLocationInfo() }}</p>
                                    </div>
                                    
                                    @if($session->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 ml-2">
                                            <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400 ml-2">
                                            Ended
                                        </span>
                                    @endif
                                </div>

                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-gray-400 text-sm">{{ $session->login_at->diffForHumans() }}</p>
                                        @if($session->session_id === session()->getId())
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary/20 text-primary mt-1">
                                                Current Session
                                            </span>
                                        @endif
                                        @if(!$session->is_active)
                                            <p class="text-xs text-gray-500 mt-1">Duration: {{ $session->getDuration() }}</p>
                                        @endif
                                    </div>

                                    @if($session->is_active && $session->session_id !== session()->getId())
                                        <form method="POST" action="{{ route('user.sessions.terminate', $session->session_id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to terminate this session?')"
                                                    class="bg-red-500/20 border border-red-500/30 text-red-400 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-red-500/30 transition-all duration-300">
                                                <i class="fas fa-times mr-1"></i>
                                                Terminate
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <i class="fas fa-shield-alt text-gray-600 text-4xl mb-4"></i>
                        <h3 class="text-white font-semibold mb-2">No sessions found</h3>
                        <p class="text-gray-400">Your login sessions will appear here.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($sessions->hasPages())
            <div class="mt-8">
                <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10">
                    {{ $sessions->links() }}
                </div>
            </div>
        @endif

        <!-- Security Notice -->
        <div class="mt-8">
            <div class="bg-blue-500/10 border border-blue-500/20 rounded-2xl p-6">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-blue-400 font-semibold mb-2">Security Information</h3>
                        <div class="text-blue-300 text-sm space-y-2">
                            <p>• Always log out when using shared or public computers</p>
                            <p>• If you notice any suspicious activity, terminate all sessions and change your password</p>
                            <p>• We recommend enabling two-factor authentication for enhanced security</p>
                            <p>• Sessions automatically expire after 30 days of inactivity</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Function to terminate all other active sessions
function terminateAllOtherSessions() {
    if (!confirm('Are you sure you want to terminate all other active sessions? This will log you out from all other devices.')) {
        return;
    }
    
    // You can implement this functionality by adding a route and method
    // For now, we'll show an alert
    alert('This feature will be implemented soon. Please terminate sessions individually for now.');
}

// Auto-refresh sessions every 2 minutes
setInterval(function() {
    // Only refresh if user is still on the page
    if (document.visibilityState === 'visible') {
        // You can add AJAX call here to refresh session data
        // window.location.reload();
    }
}, 120000);

// Handle page visibility changes
document.addEventListener('visibilitychange', function() {
    if (document.visibilityState === 'visible') {
        // Optionally refresh data when user returns to tab
    }
});

// Add loading states to terminate buttons
document.addEventListener('DOMContentLoaded', function() {
    const terminateForms = document.querySelectorAll('form[action*="sessions/terminate"]');
    
    terminateForms.forEach(form => {
        form.addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            if (button) {
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Terminating...';
            }
        });
    });
});
</script>

<style>
/* Custom pagination styles for dark theme */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
}

.pagination .page-link {
    color: #9CA3AF;
    background-color: transparent;
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    color: #C53030;
    background-color: rgba(197, 48, 48, 0.1);
    border-color: rgba(197, 48, 48, 0.3);
}

.pagination .page-item.active .page-link {
    color: white;
    background: linear-gradient(135deg, #C53030, #E53E3E);
    border-color: #C53030;
}

.pagination .page-item.disabled .page-link {
    color: #4B5563;
    background-color: transparent;
    border-color: rgba(255, 255, 255, 0.05);
}

/* Animation for session cards */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out;
}

/* Responsive improvements */
@media (max-width: 640px) {
    .truncate {
        max-width: 150px;
    }
}
</style>
@endsection