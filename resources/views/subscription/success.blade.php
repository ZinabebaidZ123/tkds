@extends('layouts.user')

@section('title', 'Subscription Successful - TKDS Media')
@section('meta_description', 'Your subscription has been successfully activated. Welcome to TKDS Media!')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark via-dark-light to-dark flex items-center justify-center py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        
        <!-- Success Animation -->
        <div class="relative mb-8">
            <div class="w-32 h-32 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse shadow-2xl">
                <i class="fas fa-check text-white text-4xl"></i>
            </div>
            
            <!-- Confetti Animation -->
            <div class="absolute inset-0 pointer-events-none">
                @for($i = 0; $i < 20; $i++)
                    <div class="absolute w-2 h-2 bg-primary rounded-full animate-bounce" 
                         style="left: {{ rand(10, 90) }}%; top: {{ rand(10, 90) }}%; animation-delay: {{ rand(0, 2000) }}ms;"></div>
                @endfor
            </div>
        </div>

        <!-- Success Message -->
        <h1 class="text-4xl md:text-5xl font-black text-white mb-6">
            🎉 Welcome to 
            @if($subscription)
                <span class="text-gradient bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                    {{ $subscription->pricingPlan->name }}!
                </span>
            @else
                <span class="text-gradient bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                    TKDS Media!
                </span>
            @endif
        </h1>

        <p class="text-xl text-gray-400 mb-8 max-w-lg mx-auto">
            Your subscription has been successfully activated. You can now access all the features of your plan and start broadcasting immediately.
        </p>

        @if($subscription)
            <!-- Subscription Details Card -->
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10 mb-8 text-left">
                <h2 class="text-2xl font-bold text-white mb-6 text-center">Subscription Details</h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Plan</span>
                            <span class="text-white font-semibold">{{ $subscription->pricingPlan->name }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Billing</span>
                            <span class="text-white font-semibold capitalize">{{ $subscription->billing_cycle }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Amount</span>
                            <span class="text-white font-semibold">{{ $subscription->getFormattedAmount() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Status</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $subscription->isActive() ? 'bg-green-500/20 text-green-400' : ($subscription->isTrialing() ? 'bg-blue-500/20 text-blue-400' : 'bg-gray-500/20 text-gray-400') }}">
                                @if($subscription->isActive())
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                    Active
                                @elseif($subscription->isTrialing())
                                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></div>
                                    Trial ({{ $subscription->getTrialDaysRemaining() }} days left)
                                @else
                                    {{ ucfirst($subscription->status) }}
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        @if($subscription->current_period_end)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">{{ $subscription->isTrialing() ? 'Trial Ends' : 'Next Payment' }}</span>
                                <span class="text-white font-semibold">{{ $subscription->current_period_end->format('M d, Y') }}</span>
                            </div>
                        @endif
                        
                        @if($subscription->trial_end && $subscription->isTrialing())
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Trial Period</span>
                                <span class="text-white font-semibold">{{ $subscription->pricingPlan->trial_days }} days</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Support Level</span>
                            <span class="text-white font-semibold capitalize">{{ $subscription->pricingPlan->support_level }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Started</span>
                            <span class="text-white font-semibold">{{ $subscription->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                @if($subscription->isTrialing())
                    <!-- Trial Notice -->
                    <div class="mt-6 bg-blue-500/10 border border-blue-500/20 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-info-circle text-blue-400 mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="text-blue-400 font-medium mb-1">Free Trial Active</p>
                                <p class="text-blue-300 text-sm">
                                    You have {{ $subscription->getTrialDaysRemaining() }} days left in your free trial. 
                                    Your first payment of {{ $subscription->getFormattedAmount() }} will be charged on {{ $subscription->trial_end->format('M d, Y') }}.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Next Steps -->
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10 mb-8">
            <h3 class="text-2xl font-bold text-white mb-6">What's Next?</h3>
            
            <div class="grid md:grid-cols-3 gap-6 text-left">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-broadcast-tower text-white text-2xl"></i>
                    </div>
                    <h4 class="text-white font-semibold mb-2">Start Broadcasting</h4>
                    <p class="text-gray-400 text-sm">Access your dashboard and begin setting up your first live stream.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-secondary to-accent rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-cogs text-white text-2xl"></i>
                    </div>
                    <h4 class="text-white font-semibold mb-2">Configure Settings</h4>
                    <p class="text-gray-400 text-sm">Customize your broadcasting preferences and platform settings.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-accent to-primary rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-white text-2xl"></i>
                    </div>
                    <h4 class="text-white font-semibold mb-2">Get Support</h4>
                    <p class="text-gray-400 text-sm">Our team is ready to help you get started with your new plan.</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
            <a href="{{ route('user.dashboard') }}" 
               class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary text-white px-8 py-4 rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-tachometer-alt mr-2"></i>
                Go to Dashboard
            </a>
            
            @if($subscription)
                <a href="{{ route('user.subscription') }}" 
                   class="inline-flex items-center justify-center bg-white/10 backdrop-blur-sm border border-white/20 text-white px-8 py-4 rounded-xl font-semibold hover:bg-white/20 transition-all duration-300">
                    <i class="fas fa-credit-card mr-2"></i>
                    Manage Subscription
                </a>
            @endif
        </div>

        <!-- Help Section -->
        <div class="mt-12 text-center">
            <p class="text-gray-400 mb-4">Need help getting started?</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-6">
                <a href="{{ route('contact') }}" class="text-primary hover:text-secondary transition-colors duration-200">
                    <i class="fas fa-envelope mr-2"></i>Contact Support
                </a>
                <a href="{{ route('blog.index') }}" class="text-primary hover:text-secondary transition-colors duration-200">
                    <i class="fas fa-book mr-2"></i>View Documentation
                </a>
                <a href="{{ route('services') }}" class="text-primary hover:text-secondary transition-colors duration-200">
                    <i class="fas fa-play-circle mr-2"></i>Watch Tutorials
                </a>
            </div>
        </div>

        <!-- Social Sharing -->
        <div class="mt-8 pt-8 border-t border-white/20">
            <p class="text-gray-400 mb-4">Share your excitement!</p>
            <div class="flex justify-center space-x-4">
                <a href="https://twitter.com/intent/tweet?text=Just%20joined%20TKDS%20Media%20broadcasting%20platform!%20🚀&url={{ urlencode(route('home')) }}" 
                   target="_blank"
                   class="w-12 h-12 bg-blue-500 hover:bg-blue-600 rounded-full flex items-center justify-center text-white transition-colors duration-200">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('home')) }}" 
                   target="_blank"
                   class="w-12 h-12 bg-blue-700 hover:bg-blue-800 rounded-full flex items-center justify-center text-white transition-colors duration-200">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('home')) }}" 
                   target="_blank"
                   class="w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center text-white transition-colors duration-200">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Auto-redirect to dashboard after 30 seconds
setTimeout(function() {
    if (confirm('Would you like to go to your dashboard now?')) {
        window.location.href = '{{ route("user.dashboard") }}';
    }
}, 30000);

// Confetti animation
document.addEventListener('DOMContentLoaded', function() {
    // Add some celebration effects
    const confettiElements = document.querySelectorAll('.animate-bounce');
    confettiElements.forEach((element, index) => {
        setTimeout(() => {
            element.style.animation = `bounce 2s infinite ${index * 0.1}s`;
        }, index * 100);
    });
});
</script>
@endpush