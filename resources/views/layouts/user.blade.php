{{-- File: resources/views/layouts/user.blade.php --}}
@extends('layouts.app')

@section('content')
    @yield('content')
@endsection

@push('head')
<meta name="robots" content="noindex, nofollow">
@endpush

@push('scripts')
<script>
// User dashboard specific scripts
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh stats every 30 seconds
    setInterval(function() {
        // You can add AJAX calls here to refresh dashboard stats
        // updateDashboardStats();
    }, 30000);
    
    // Add smooth animations to stat cards
    const statCards = document.querySelectorAll('[data-stat-card]');
    statCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('animate-fade-in');
    });
});

// Function to update dashboard stats via AJAX (optional)
function updateDashboardStats() {
    fetch('/user/dashboard/stats', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update stats in real-time
        if (data.success) {
            updateStatCard('profile-completion', data.stats.profile_completion);
            updateStatCard('total-logins', data.stats.total_logins);
        }
    })
    .catch(error => {
        console.log('Stats update failed:', error);
    });
}

function updateStatCard(statId, newValue) {
    const element = document.getElementById(statId);
    if (element) {
        // Add animation effect
        element.style.transform = 'scale(1.1)';
        setTimeout(() => {
            element.textContent = newValue;
            element.style.transform = 'scale(1)';
        }, 150);
    }
}
</script>

<style>

    .min-h-screen{
        margin-top: 80px !important;
    }


    </style>
@endpush