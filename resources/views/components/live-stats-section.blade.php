{{-- Live Statistics Section - Simple & Clean --}}
<section class="py-16 bg-gradient-to-br from-dark via-dark-light to-dark">
    <div class="max-w-5xl mx-auto px-4 text-center">
        
        <!-- Live Badge -->
        <div class="inline-flex items-center space-x-3 bg-red-500/20 rounded-full px-6 py-3 border border-red-500/40 mb-8">
            <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
            <span class="text-red-400 font-bold text-sm uppercase">Live Now</span>
        </div>

        <!-- Main Counter -->
        <div class="mb-8">
            <h2 class="text-5xl md:text-7xl font-black text-primary mb-4" id="liveCounter">
                <span class="animate-pulse">Loading...</span>
            </h2>
            <h3 class="text-xl font-bold text-white mb-2">Total Network Users</h3>
            <p class="text-gray-400">Active across all TKDS platforms</p>
        </div>

        <!-- Sub Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Streaming -->
            <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                <div class="text-3xl font-black text-primary mb-2" id="streamingCount">
                    <span class="animate-pulse">Loading...</span>
                </div>
                <div class="text-sm text-white">Live Streaming</div>
            </div>

            <!-- Viewing -->
            <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                <div class="text-3xl font-black text-secondary mb-2" id="viewingCount">
                    <span class="animate-pulse">Loading...</span>
                </div>
                <div class="text-sm text-white">Active Viewers</div>
            </div>

            <!-- Engaged -->
            <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                <div class="text-3xl font-black text-accent mb-2" id="engagedCount">
                    <span class="animate-pulse">Loading...</span>
                </div>
                <div class="text-sm text-white">Engaged Users</div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const liveCounter = document.getElementById('liveCounter');
    const streamingCount = document.getElementById('streamingCount');
    const viewingCount = document.getElementById('viewingCount');
    const engagedCount = document.getElementById('engagedCount');

    let lastTotal = 0;

    // Fetch data from API
    async function fetchStats() {
        try {
            console.log('Fetching API data...');
            
            const response = await fetch('https://ad.tkdsservers.com/api/platform/total-visitors', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('API Response:', data);
            
            if (data.total_visitors) {
                updateCounters(data.total_visitors);
                console.log('Data updated successfully:', data.total_visitors);
            }
            
        } catch (error) {
            console.error('Error fetching data:', error);
            // Keep showing loading or last known value
            if (lastTotal === 0) {
                console.log('Still loading...');
            }
        }
    }

    // Update counters with animation
    function updateCounters(totalVisitors) {
        if (totalVisitors === lastTotal) return;
        
        // Main counter (real from API)
        animateCounterUpdate(liveCounter, totalVisitors);
        
        // Sub calculations
        const streaming = Math.floor(totalVisitors * 0.00004);
        const viewing = Math.floor(totalVisitors * 0.025); // average 2.5%
        const engaged = Math.floor((streaming + viewing) * 0.15);
        
        // Update display with animation
        animateCounterUpdate(streamingCount, streaming);
        animateCounterUpdate(viewingCount, viewing);
        animateCounterUpdate(engagedCount, engaged);
        
        lastTotal = totalVisitors;
    }

    // Animate counter update
    function animateCounterUpdate(element, newValue) {
        element.style.transform = 'scale(1.1)';
        element.style.transition = 'transform 0.3s ease';
        
        setTimeout(() => {
            element.textContent = newValue.toLocaleString();
        }, 150);
        
        setTimeout(() => {
            element.style.transform = 'scale(1)';
        }, 300);
    }

    // Initial load
    console.log('Starting initial API call...');
    fetchStats();
    
    // Update every 45 seconds (give API time to respond)
    setInterval(fetchStats, 45000);
    
    // Try again after 10 seconds if first call failed
    setTimeout(() => {
        if (lastTotal === 0) {
            console.log('Retrying API call...');
            fetchStats();
        }
    }, 10000);
});
</script>
