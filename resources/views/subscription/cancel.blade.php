@extends('layouts.user')

@section('title', 'Cancel Subscription - TKDS Media')
@section('meta_description', 'Cancel your TKDS Media subscription')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark via-dark-light to-dark py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('user.subscription') }}" class="inline-flex items-center text-gray-400 hover:text-primary transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Subscription
            </a>
        </div>

        <!-- Page Header -->
        <div class="text-center mb-12">
            <div class="w-20 h-20 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-heart-broken text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-black text-white mb-4">We're Sorry to See You Go</h1>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                Before you cancel, let us know how we can improve and explore your options.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            
            <!-- Current Subscription Details -->
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                <h2 class="text-2xl font-bold text-white mb-6">Current Subscription</h2>
                
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 mb-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r {{ $subscription->pricingPlan->getColorClass() }} rounded-xl flex items-center justify-center">
                            <i class="{{ $subscription->pricingPlan->icon }} text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">{{ $subscription->pricingPlan->name }}</h3>
                            <p class="text-gray-400">{{ $subscription->getFormattedAmount() }}/{{ $subscription->billing_cycle }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Status</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $subscription->isActive() ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                {{ ucfirst($subscription->status) }}
                            </span>
                        </div>
                        
                        @if($subscription->current_period_end)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">{{ $subscription->isTrialing() ? 'Trial Ends' : 'Next Payment' }}</span>
                            <span class="text-white">{{ $subscription->current_period_end->format('M d, Y') }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Days Remaining</span>
                            <span class="text-white">{{ $subscription->getRemainingDays() }} days</span>
                        </div>
                    </div>
                </div>

                <!-- What You'll Lose -->
                <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-6">
                    <h4 class="text-red-400 font-semibold mb-4 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        What you'll lose access to:
                    </h4>
                    <ul class="space-y-2">
                        @foreach($subscription->pricingPlan->getFeatures() as $feature)
                            <li class="flex items-center space-x-3 text-red-300">
                                <i class="fas fa-times text-red-400 flex-shrink-0"></i>
                                <span class="text-sm">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Cancellation Form -->
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                <h2 class="text-2xl font-bold text-white mb-6">Cancel Subscription</h2>
                
                <!-- Cancellation Reasons -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-white mb-3">Why are you canceling? (Optional)</label>
                    <div class="space-y-3">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="cancel_reason" value="too_expensive" class="w-4 h-4 text-primary bg-white/10 border-white/20 focus:ring-primary">
                            <span class="text-gray-300">Too expensive</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="cancel_reason" value="not_using" class="w-4 h-4 text-primary bg-white/10 border-white/20 focus:ring-primary">
                            <span class="text-gray-300">Not using it enough</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="cancel_reason" value="missing_features" class="w-4 h-4 text-primary bg-white/10 border-white/20 focus:ring-primary">
                            <span class="text-gray-300">Missing features I need</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="cancel_reason" value="found_alternative" class="w-4 h-4 text-primary bg-white/10 border-white/20 focus:ring-primary">
                            <span class="text-gray-300">Found a better alternative</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="cancel_reason" value="technical_issues" class="w-4 h-4 text-primary bg-white/10 border-white/20 focus:ring-primary">
                            <span class="text-gray-300">Technical issues</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="cancel_reason" value="other" class="w-4 h-4 text-primary bg-white/10 border-white/20 focus:ring-primary">
                            <span class="text-gray-300">Other</span>
                        </label>
                    </div>
                </div>

                <!-- Additional Comments -->
                <div class="mb-6">
                    <label for="cancel_comments" class="block text-sm font-semibold text-white mb-2">
                        Additional Comments (Optional)
                    </label>
                    <textarea id="cancel_comments" 
                              name="cancel_comments" 
                              rows="4" 
                              placeholder="Let us know how we can improve..."
                              class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm resize-none"></textarea>
                </div>

                <!-- Cancellation Options -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-white mb-4">Cancellation Options</h3>
                    
                    <div class="space-y-4">
                        <!-- Cancel at Period End -->
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="radio" name="cancel_type" value="end_of_period" checked class="w-4 h-4 text-primary bg-white/10 border-white/20 focus:ring-primary mt-1">
                                <div>
                                    <div class="text-white font-medium">Cancel at end of billing period</div>
                                    <div class="text-gray-400 text-sm mt-1">
                                        @if($subscription->current_period_end)
                                            You'll keep access until {{ $subscription->current_period_end->format('M d, Y') }} and won't be charged again.
                                        @else
                                            You'll keep access until the end of your current billing period and won't be charged again.
                                        @endif
                                        <span class="text-green-400 font-medium">(Recommended)</span>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Cancel Immediately -->
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="radio" name="cancel_type" value="immediately" class="w-4 h-4 text-primary bg-white/10 border-white/20 focus:ring-primary mt-1">
                                <div>
                                    <div class="text-white font-medium">Cancel immediately</div>
                                    <div class="text-gray-400 text-sm mt-1">
                                        You'll lose access right away. No refund for the current period.
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <button onclick="confirmCancellation()" 
                            id="cancelButton"
                            class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-xl font-bold hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <span id="cancelButtonText">Cancel My Subscription</span>
                        <i id="cancelButtonIcon" class="fas fa-heart-broken ml-2"></i>
                    </button>
                    
                    <a href="{{ route('user.subscription') }}" 
                       class="w-full inline-block text-center bg-white/10 backdrop-blur-sm border border-white/20 text-white px-6 py-4 rounded-xl font-semibold hover:bg-white/20 transition-all duration-300">
                        Keep My Subscription
                    </a>
                </div>
            </div>
        </div>

        <!-- Alternative Options -->
        <div class="mt-16 bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
            <h3 class="text-2xl font-bold text-white mb-6 text-center">Wait! Consider These Alternatives</h3>
            
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Downgrade Option -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-arrow-down text-white text-2xl"></i>
                    </div>
                    <h4 class="text-white font-semibold mb-2">Downgrade Plan</h4>
                    <p class="text-gray-400 text-sm mb-4">Switch to a more affordable plan that better fits your needs.</p>
                    <a href="{{ route('pricing') }}" class="text-primary hover:text-secondary font-medium text-sm">
                        View Plans <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Pause Subscription -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-pause text-white text-2xl"></i>
                    </div>
                    <h4 class="text-white font-semibold mb-2">Pause Subscription</h4>
                    <p class="text-gray-400 text-sm mb-4">Take a break and resume your subscription when you're ready.</p>
                    <a href="{{ route('contact') }}" class="text-primary hover:text-secondary font-medium text-sm">
                        Contact Support <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Get Help -->
                <div class="bg-white/5 rounded-xl p-6 border border-white/10 text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-white text-2xl"></i>
                    </div>
                    <h4 class="text-white font-semibold mb-2">Get Help</h4>
                    <p class="text-gray-400 text-sm mb-4">Let our support team help you get the most out of your subscription.</p>
                    <a href="{{ route('contact') }}" class="text-primary hover:text-secondary font-medium text-sm">
                        Contact Us <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 text-center">
        <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Confirm Cancellation</h3>
        <p id="confirmMessage" class="text-gray-600 mb-6"></p>
        <div class="flex space-x-4">
            <button onclick="processCancellation()" 
                    id="confirmCancelButton"
                    class="flex-1 bg-red-500 text-white px-4 py-3 rounded-xl font-semibold hover:bg-red-600 transition-colors duration-200">
                Yes, Cancel
            </button>
            <button onclick="closeConfirmModal()" 
                    class="flex-1 bg-gray-200 text-gray-800 px-4 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-colors duration-200">
                Keep Subscription
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmCancellation() {
    const cancelType = document.querySelector('input[name="cancel_type"]:checked').value;
    const confirmMessage = document.getElementById('confirmMessage');
    
    if (cancelType === 'immediately') {
        confirmMessage.textContent = 'Are you sure you want to cancel immediately? You will lose access right away and no refund will be provided for the current billing period.';
    } else {
        confirmMessage.textContent = 'Are you sure you want to cancel at the end of your billing period? @if($subscription->current_period_end) You will keep access until {{ $subscription->current_period_end->format("M d, Y") }}. @else You will keep access until the end of your current billing period. @endif';
    }
    
    document.getElementById('confirmModal').classList.remove('hidden');
    document.getElementById('confirmModal').classList.add('flex');
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
    document.getElementById('confirmModal').classList.remove('flex');
}

async function processCancellation() {
    const cancelButton = document.getElementById('confirmCancelButton');
    const originalText = cancelButton.textContent;
    
    // Get form data
    const cancelType = document.querySelector('input[name="cancel_type"]:checked').value;
    const cancelReason = document.querySelector('input[name="cancel_reason"]:checked')?.value || '';
    const cancelComments = document.getElementById('cancel_comments').value;
    
    // Set loading state
    cancelButton.disabled = true;
    cancelButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
    
    try {
        const response = await fetch('{{ route("subscription.process-cancel") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                cancel_immediately: cancelType === 'immediately',
                cancel_reason: `${cancelReason}${cancelComments ? ': ' + cancelComments : ''}`
            })
        });

        const result = await response.json();

        if (result.success) {
            // Show success message and redirect
            alert(result.message);
            window.location.href = '{{ route("user.subscription") }}';
        } else {
            alert(result.message || 'An error occurred. Please try again.');
            cancelButton.disabled = false;
            cancelButton.textContent = originalText;
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
        cancelButton.disabled = false;
        cancelButton.textContent = originalText;
    }
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeConfirmModal();
    }
});
</script>
@endpush