@extends('layouts.user')

@section('title', 'My Subscription - TKDS Media')
@section('meta_description', 'Manage your TKDS Media subscription, view billing history, and update payment methods.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark via-dark-light to-dark py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center text-gray-400 hover:text-primary transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>

        @if($subscription)
            <!-- Current Subscription -->
            <div class="mb-8">
                <h1 class="text-3xl font-black text-white mb-6">My Subscription</h1>
                
                <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                    <div class="grid lg:grid-cols-3 gap-8">
                        
                        <!-- Plan Details -->
                        <div class="lg:col-span-2">
                            <div class="flex items-start space-x-6">
                                <div class="w-20 h-20 bg-gradient-to-r {{ $subscription->pricingPlan->getColorClass() }} rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <i class="{{ $subscription->pricingPlan->icon }} text-white text-2xl"></i>
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                                        <div>
                                            <h2 class="text-2xl font-bold text-white mb-2">{{ $subscription->pricingPlan->name }}</h2>
                                            <p class="text-gray-400">{{ $subscription->pricingPlan->short_description }}</p>
                                        </div>
                                        
                                        @php $statusBadge = $subscription->getStatusBadge() @endphp
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $statusBadge['class'] }} mt-2 sm:mt-0">
                                            <i class="{{ $statusBadge['icon'] }} mr-2"></i>
                                            {{ $statusBadge['text'] }}
                                        </span>
                                    </div>
                                    
                                    <div class="grid sm:grid-cols-2 gap-4 text-sm">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-400">Billing</span>
                                            <span class="text-white font-semibold">{{ $subscription->getFormattedAmount() }}/{{ $subscription->billing_cycle }}</span>
                                        </div>
                                        
                                        @if($subscription->current_period_end)
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-400">{{ $subscription->isTrialing() ? 'Trial Ends' : 'Next Payment' }}</span>
                                            <span class="text-white font-semibold">{{ $subscription->current_period_end->format('M d, Y') }}</span>
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
                            </div>
                            
                            @if($subscription->isTrialing())
                                <!-- Trial Notice -->
                                <div class="mt-6 bg-blue-500/10 border border-blue-500/20 rounded-xl p-4">
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-gift text-blue-400 mt-1 flex-shrink-0"></i>
                                        <div>
                                            <p class="text-blue-400 font-semibold mb-1">Free Trial Active</p>
                                            <p class="text-blue-300 text-sm">
                                                You have {{ $subscription->getTrialDaysRemaining() }} days left in your free trial.
                                                @if($subscription->trial_end)
                                                    Your first payment will be on {{ $subscription->trial_end->format('M d, Y') }}.
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($subscription->isExpiringSoon())
                                <!-- Expiring Soon Notice -->
                                <div class="mt-6 bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-4">
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-exclamation-triangle text-yellow-400 mt-1 flex-shrink-0"></i>
                                        <div>
                                            <p class="text-yellow-400 font-semibold mb-1">Subscription Expiring Soon</p>
                                            <p class="text-yellow-300 text-sm">
                                                Your subscription expires in {{ $subscription->getRemainingDays() }} days. 
                                                Make sure your payment method is up to date.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="space-y-4">
                            @if($subscription->canCancel())
                                <a href="{{ route('subscription.cancel') }}" 
                                   class="w-full inline-flex items-center justify-center bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl font-semibold hover:bg-red-500/30 transition-all duration-300">
                                    <i class="fas fa-times mr-2"></i>
                                    Cancel Subscription
                                </a>
                            @endif
                            
                            @if($subscription->canResume())
                                <form method="POST" action="{{ route('subscription.resume') }}" class="w-full">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl font-semibold hover:bg-green-500/30 transition-all duration-300">
                                        <i class="fas fa-play mr-2"></i>
                                        Resume Subscription
                                    </button>
                                </form>
                            @endif
                            
                            <a href="{{ route('user.profile') }}#billing" 
                               class="w-full inline-flex items-center justify-center bg-white/10 border border-white/20 text-white px-4 py-3 rounded-xl font-semibold hover:bg-white/20 transition-all duration-300">
                                <i class="fas fa-credit-card mr-2"></i>
                                Update Payment
                            </a>
                            
                            <a href="{{ route('contact') }}" 
                               class="w-full inline-flex items-center justify-center bg-primary/20 border border-primary/30 text-primary px-4 py-3 rounded-xl font-semibold hover:bg-primary/30 transition-all duration-300">
                                <i class="fas fa-headset mr-2"></i>
                                Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plan Features -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white mb-6">Your Plan Features</h2>
                
                <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($subscription->pricingPlan->getFeatures() as $feature)
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-check text-green-400 flex-shrink-0"></i>
                                <span class="text-gray-300">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Billing History -->
            @if($subscription->payments->count() > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white mb-6">Billing History</h2>
                
                <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden">
                    <!-- Desktop Table -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-white/5">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach($subscription->payments as $payment)
                                    <tr class="hover:bg-white/5 transition-colors duration-200">
                                        <td class="px-6 py-4 text-sm text-gray-300">
                                            {{ $payment->processed_at ? $payment->processed_at->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="text-sm font-medium text-white">{{ $subscription->pricingPlan->name }}</p>
                                                <p class="text-xs text-gray-400">{{ ucfirst($subscription->billing_cycle) }} subscription</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-white">
                                            {{ $payment->getFormattedAmount() }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @php $statusBadge = $payment->getStatusBadge() @endphp
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusBadge['class'] }}">
                                                <i class="{{ $statusBadge['icon'] }} mr-1"></i>
                                                {{ $statusBadge['text'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                @if($payment->stripe_invoice_id)
                                                    <a href="{{ route('subscription.invoice', [$subscription, $payment->stripe_invoice_id]) }}" 
                                                       class="text-primary hover:text-secondary transition-colors duration-200">
                                                        <i class="fas fa-file-invoice"></i>
                                                    </a>
                                                @endif
                                                
                                                @if($payment->receipt_url)
                                                    <a href="{{ $payment->receipt_url }}" 
                                                       target="_blank"
                                                       class="text-gray-400 hover:text-white transition-colors duration-200">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Mobile Cards -->
                    <div class="lg:hidden divide-y divide-white/10">
                        @foreach($subscription->payments as $payment)
                            <div class="p-6 hover:bg-white/5 transition-colors duration-200">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <p class="text-white font-semibold">{{ $subscription->pricingPlan->name }}</p>
                                        <p class="text-gray-400 text-sm">{{ ucfirst($subscription->billing_cycle) }} subscription</p>
                                        <p class="text-gray-400 text-sm">{{ $payment->processed_at ? $payment->processed_at->format('M d, Y') : 'N/A' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-white font-semibold">{{ $payment->getFormattedAmount() }}</p>
                                        @php $statusBadge = $payment->getStatusBadge() @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusBadge['class'] }} mt-1">
                                            {{ $statusBadge['text'] }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-4">
                                    @if($payment->stripe_invoice_id)
                                        <a href="{{ route('subscription.invoice', [$subscription, $payment->stripe_invoice_id]) }}" 
                                           class="text-primary hover:text-secondary transition-colors duration-200 text-sm">
                                            <i class="fas fa-file-invoice mr-1"></i>
                                            View Invoice
                                        </a>
                                    @endif
                                    
                                    @if($payment->receipt_url)
                                        <a href="{{ $payment->receipt_url }}" 
                                           target="_blank"
                                           class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">
                                            <i class="fas fa-external-link-alt mr-1"></i>
                                            Receipt
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Upgrade Options -->
            @if($availablePlans->count() > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white mb-6">Upgrade Your Plan</h2>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($availablePlans as $plan)
                        <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10 hover:border-primary/30 transition-all duration-300 {{ $plan->isPopular() ? 'ring-2 ring-primary/50' : '' }}">
                            @if($plan->isPopular())
                                <div class="bg-gradient-to-r from-primary to-secondary text-white px-3 py-1 rounded-full text-xs font-bold mb-4 text-center">
                                    Most Popular
                                </div>
                            @endif
                            
                            <div class="text-center">
                                <div class="w-12 h-12 bg-gradient-to-r {{ $plan->getColorClass() }} rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <i class="{{ $plan->icon }} text-white"></i>
                                </div>
                                
                                <h3 class="text-xl font-bold text-white mb-2">{{ $plan->name }}</h3>
                                <p class="text-gray-400 text-sm mb-4">{{ $plan->short_description }}</p>
                                
                                <div class="text-2xl font-black text-white mb-4">
                                    {{ $plan->getFormattedPriceMonthly() }}
                                </div>
                                
                                <a href="{{ route('subscription.create', $plan->slug) }}" 
                                   class="w-full inline-flex items-center justify-center bg-gradient-to-r {{ $plan->getColorClass() }} text-white px-4 py-3 rounded-xl font-semibold hover:opacity-90 transition-all duration-300">
                                    Upgrade Now
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        @else
            <!-- No Subscription -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-credit-card text-white text-3xl"></i>
                </div>
                
                <h1 class="text-3xl font-black text-white mb-4">No Active Subscription</h1>
                <p class="text-xl text-gray-400 mb-8 max-w-lg mx-auto">
                    You don't have an active subscription yet. Choose a plan below to get started with our broadcasting platform.
                </p>
                
                <a href="{{ route('pricing') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-primary to-secondary text-white px-8 py-4 rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-rocket mr-2"></i>
                    Choose Your Plan
                </a>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
// Auto-refresh subscription status every 30 seconds
setInterval(function() {
    // You can add AJAX call here to refresh subscription status
}, 30000);

// Handle plan change
function changePlan(newPlanId, billingCycle) {
    if (!confirm('Are you sure you want to change your plan? This change will take effect immediately.')) {
        return;
    }
    
    fetch('{{ route("subscription.change-plan") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            new_plan_id: newPlanId,
            billing_cycle: billingCycle
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Failed to change plan. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

// Confirm dangerous actions
document.addEventListener('DOMContentLoaded', function() {
    const dangerousLinks = document.querySelectorAll('a[href*="cancel"]');
    dangerousLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to proceed? This action may affect your subscription.')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endpush