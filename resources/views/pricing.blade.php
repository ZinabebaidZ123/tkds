@extends('layouts.app')

@section('title', 'Pricing Plans - TKDS Media')
@section('meta_description', 'Choose the perfect broadcasting plan for your needs. Flexible pricing with powerful features.')

@section('content')
<section class="py-20 bg-dark relative overflow-hidden mt-20">
    <!-- Background Elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-primary/5 via-transparent to-secondary/5"></div>
        <div class="absolute top-40 right-20 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-40 left-20 w-80 h-80 bg-secondary/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center space-x-2 bg-secondary/10 rounded-full px-6 py-2 mb-6">
                <i class="fas fa-star text-secondary"></i>
                <span class="text-secondary font-medium">Pricing Plans</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white mb-6">
                Choose Your <span class="text-gradient">Video Content Management Package</span>
            </h1>

            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                Flexible plans designed to scale with your needs, from startup to enterprise
            </p>
        </div>
        
        <!-- Pricing Toggle -->
        <div class="flex items-center justify-center mb-12" data-aos="fade-up">
            <div class="glass-effect rounded-full p-1">
                <div class="flex items-center">
                    <button id="monthlyBtn" class="px-6 py-3 rounded-full bg-gradient-to-r from-primary to-secondary text-white font-semibold transition-all duration-300">
                        Monthly
                    </button>
                    <button id="yearlyBtn" class="px-6 py-3 rounded-full text-gray-400 font-semibold transition-all duration-300 hover:text-white">
                        Yearly 
                        @if($plans->where('price_yearly', '>', 0)->first())
                            <span class="text-green-400 text-xs">(Save up to {{ $plans->where('price_yearly', '>', 0)->max(function($plan) { return $plan->getYearlySavingsPercentage(); }) }}%)</span>
                        @endif
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Packages Grid -->
        <div class="grid lg:grid-cols-{{ min($plans->count(), 3) }} gap-8 max-w-6xl mx-auto">
            @foreach($plans as $plan)
                <div class="glass-effect rounded-2xl p-8 relative group hover:bg-white/20 transition-all duration-300 transform hover:-translate-y-2 
                    {{ $plan->isPopular() ? 'border-2 border-primary' : '' }}" 
                    data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    
                    @if($plan->isPopular())
                        <!-- Popular Badge -->
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <div class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-2 rounded-full text-sm font-bold">
                                Most Popular
                            </div>
                        </div>
                    @endif
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r {{ $plan->getColorClass() }} rounded-xl flex items-center justify-center mx-auto mb-6">
                            <i class="{{ $plan->icon }} text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $plan->name }}</h3>
                        <p class="text-gray-400 mb-6">{{ $plan->short_description }}</p>
                        
                        <div class="mb-6">
                            @if($plan->price_monthly)
                                <span class="text-4xl font-black text-white monthly-price" data-monthly="{{ $plan->price_monthly }}">
                                    {{-- ✅ FIXED: Show exact price --}}
                                    @if($plan->price_monthly == floor($plan->price_monthly))
                                        ${{ number_format($plan->price_monthly, 0) }}
                                    @else
                                        ${{ number_format($plan->price_monthly, 2) }}
                                    @endif
                                </span>
                                <span class="text-gray-400 monthly-price">/month</span>
                            @endif
                            
                            @if($plan->price_yearly)
                                <div class="yearly-price hidden">
                                    <span class="text-4xl font-black text-white" data-yearly="{{ $plan->price_yearly }}">
                                        @php $monthlyFromYearly = $plan->price_yearly / 12; @endphp
                                        @if($monthlyFromYearly == floor($monthlyFromYearly))
                                            ${{ number_format($monthlyFromYearly, 0) }}
                                        @else
                                            ${{ number_format($monthlyFromYearly, 2) }}
                                        @endif
                                    </span>
                                    <span class="text-gray-400">/month</span>
                                    <div class="text-sm text-gray-400 mt-1">
                                        Billed annually (${{ $plan->price_yearly == floor($plan->price_yearly) ? number_format($plan->price_yearly, 0) : number_format($plan->price_yearly, 2) }})
                                    </div>
                                </div>
                            @endif
                            
                            @if(!$plan->price_monthly && !$plan->price_yearly)
                                <span class="text-4xl font-black text-white">Free</span>
                            @endif

                            @if($plan->getYearlySavingsPercentage() > 0)
                                <div class="yearly-savings hidden inline-block bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm font-medium mt-3">
                                    Save {{ $plan->getYearlySavingsPercentage() }}%
                                </div>
                            @endif

                            {{-- ✅ NEW: Setup Fee Display --}}
                            @if($plan->hasSetupFee())
                                <div class="mt-4 text-sm text-orange-300 bg-orange-500/10 border border-orange-500/20 rounded-lg p-3">
                                    <i class="fas fa-plus-circle mr-2"></i>
                                    <strong>{{ $plan->getFormattedSetupFee() }}</strong>
                                </div>
                            @endif
                        </div>

                        <!-- Trial Period -->
                        @if($plan->trial_days)
                            <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-3 mb-6">
                                <div class="text-blue-300 text-sm font-medium">
                                    <i class="fas fa-gift mr-2"></i>
                                    {{ $plan->trial_days }} days free trial
                                </div>
                            </div>
                        @endif
                        
                        <!-- Features List -->
                        @if($plan->getFeatures())
                            <ul class="space-y-3 text-left mb-6">
                                @foreach($plan->getFeatures() as $feature)
                                    <li class="flex items-center space-x-3">
                                        <i class="fas fa-check text-accent flex-shrink-0"></i>
                                        <span class="text-gray-300">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- ✅ ENHANCED: Complete Usage Limits Display --}}
                        <div class="border-t border-gray-700 pt-6 mb-6">
                            <h4 class="text-sm font-semibold text-gray-300 mb-4">Plan Includes</h4>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                {{-- Users --}}
                                @if($plan->max_users)
                                    <div class="flex items-center space-x-2 bg-blue-500/10 rounded-lg p-2">
                                        <i class="fas fa-users text-blue-400"></i>
                                        <span class="text-gray-300">{{ number_format($plan->max_users) }} viewers</span>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-2 bg-green-500/10 rounded-lg p-2">
                                        <i class="fas fa-infinity text-green-400"></i>
                                        <span class="text-gray-300">Unlimited viewers</span>
                                    </div>
                                @endif
                                
                                {{-- Projects --}}
                                @if($plan->max_projects)
                                    <div class="flex items-center space-x-2 bg-purple-500/10 rounded-lg p-2">
                                        <i class="fas fa-signal text-purple-400"></i>
                                        <span class="text-gray-300">{{ number_format($plan->max_projects) }} MB/S</span>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-2 bg-green-500/10 rounded-lg p-2">
                                        <i class="fas fa-infinity text-green-400"></i>
                                        <span class="text-gray-300">Unlimited bitrate</span>
                                    </div>
                                @endif
                                
                                {{-- Storage --}}
                                @if($plan->storage_limit)
                                    <div class="flex items-center space-x-2 bg-yellow-500/10 rounded-lg p-2">
                                        <i class="fas fa-hdd text-yellow-400"></i>
                                        <span class="text-gray-300">{{ $plan->storage_limit }} </span>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-2 bg-green-500/10 rounded-lg p-2">
                                        <i class="fas fa-infinity text-green-400"></i>
                                        <span class="text-gray-300">Unlimited storage</span>
                                    </div>
                                @endif
                                
                                {{-- Bandwidth --}}
                                @if($plan->bandwidth_limit)
                                    <div class="flex items-center space-x-2 bg-red-500/10 rounded-lg p-2">
                                        <i class="fas fa-tachometer-alt text-red-400"></i>
                                        <span class="text-gray-300">{{ $plan->bandwidth_limit }}</span>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-2 bg-green-500/10 rounded-lg p-2">
                                        <i class="fas fa-infinity text-green-400"></i>
                                        <span class="text-gray-300">Unlimited bandwidth</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Support Level --}}
                        <div class="flex items-center justify-center space-x-2 text-sm mb-6 bg-white/5 rounded-lg p-3">
                            @if($plan->support_level === 'premium')
                                <i class="fas fa-crown text-yellow-400"></i>
                                <span class="text-yellow-400 font-semibold">Premium Support</span>
                            @elseif($plan->support_level === 'priority')
                                <i class="fas fa-bolt text-orange-400"></i>
                                <span class="text-orange-400 font-semibold">Priority Support</span>
                            @else
                                <i class="fas fa-life-ring text-blue-400"></i>
                                <span class="text-blue-400 font-semibold">Basic Support</span>
                            @endif
                        </div>
                        
                        @auth
                            @if(auth()->user()->hasActiveSubscription())
                                @php
                                    $currentSubscription = auth()->user()->subscriptions()
                                        ->whereIn('status', ['active', 'trialing'])
                                        ->with('pricingPlan')
                                        ->first();
                                    $currentPlan = $currentSubscription ? $currentSubscription->pricingPlan : null;
                                @endphp

                                @if($currentPlan && $currentPlan->id === $plan->id)                                   
                                    <button class="w-full px-6 py-4 bg-green-500/20 text-green-400 font-bold rounded-xl border-2 border-green-500/50 cursor-not-allowed">
                                        <i class="fas fa-check mr-2"></i>
                                        Current Plan
                                    </button>
                                @else
                                    <a href="{{ route('subscription.create', $plan->slug) }}" 
                                       class="w-full inline-block px-6 py-4 {{ $plan->isPopular() ? 'bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-accent' : 'glass-effect hover:bg-white/20' }} text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 text-center">
                                        Upgrade to {{ $plan->name }}
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('subscription.create', $plan->slug) }}" 
                                   class="w-full inline-block px-6 py-4 {{ $plan->isPopular() ? 'bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-accent' : 'glass-effect hover:bg-white/20' }} text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 text-center">
                                    @if($plan->trial_days)
                                        Start {{ $plan->trial_days }}-Day Free Trial
                                    @else
                                        Get Started
                                    @endif
                                </a>
                            @endif
                        @else
                            <a href="{{ route('auth.register') }}?plan={{ $plan->slug }}" 
                               class="w-full inline-block px-6 py-4 {{ $plan->isPopular() ? 'bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-accent' : 'glass-effect hover:bg-white/20' }} text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 text-center">
                                @if($plan->trial_days)
                                    Start {{ $plan->trial_days }}-Day Free Trial
                                @else
                                    Get Started
                                @endif
                            </a>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- FAQ Section -->
        <div class="mt-20" data-aos="fade-up">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-black text-white mb-4">Frequently Asked Questions</h3>
                <p class="text-gray-400">Got questions? We have answers</p>
            </div>
            
            <div class="max-w-4xl mx-auto space-y-4">
                <div class="glass-effect rounded-xl p-6">
                    <div class="flex items-center justify-between cursor-pointer" onclick="toggleFAQ(1)">
                        <h4 class="text-lg font-bold text-white">Can I change plans anytime?</h4>
                        <i class="fas fa-chevron-down text-primary transition-transform duration-300" id="faq-icon-1"></i>
                    </div>
                    <div class="mt-4 text-gray-400 hidden" id="faq-content-1">
                        Yes, you can upgrade or downgrade your plan at any time. Changes take effect immediately for upgrades, or at the next billing cycle for downgrades.
                    </div>
                </div>
                
                <div class="glass-effect rounded-xl p-6">
                    <div class="flex items-center justify-between cursor-pointer" onclick="toggleFAQ(2)">
                        <h4 class="text-lg font-bold text-white">What payment methods do you accept?</h4>
                        <i class="fas fa-chevron-down text-primary transition-transform duration-300" id="faq-icon-2"></i>
                    </div>
                    <div class="mt-4 text-gray-400 hidden" id="faq-content-2">
                        We accept all major credit cards, debit cards, and digital wallets through our secure Stripe payment processing.
                    </div>
                </div>
                
                <div class="glass-effect rounded-xl p-6">
                    <div class="flex items-center justify-between cursor-pointer" onclick="toggleFAQ(3)">
                        <h4 class="text-lg font-bold text-white">Are there setup fees?</h4>
                        <i class="fas fa-chevron-down text-primary transition-transform duration-300" id="faq-icon-3"></i>
                    </div>
                    <div class="mt-4 text-gray-400 hidden" id="faq-content-3">
                        Setup fees vary by plan and are clearly displayed in the pricing. Many plans include free setup, while premium plans may have one-time setup costs for advanced configurations.
                    </div>
                </div>
                
                <div class="glass-effect rounded-xl p-6">
                    <div class="flex items-center justify-between cursor-pointer" onclick="toggleFAQ(4)">
                        <h4 class="text-lg font-bold text-white">Can I cancel anytime?</h4>
                        <i class="fas fa-chevron-down text-primary transition-transform duration-300" id="faq-icon-4"></i>
                    </div>
                    <div class="mt-4 text-gray-400 hidden" id="faq-content-4">
                        Absolutely! You can cancel your subscription at any time. You'll continue to have access until the end of your current billing period.
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Trust Indicators -->
        <div class="mt-16 text-center" data-aos="fade-up">
            <div class="flex items-center justify-center space-x-8 text-gray-400">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-shield-alt text-green-400"></i>
                    <span class="text-sm">Secure Payments</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-undo text-blue-400"></i>
                    <span class="text-sm">30-Day Refund</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-headset text-purple-400"></i>
                    <span class="text-sm">24/7 Support</span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Pricing Toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const monthlyBtn = document.getElementById('monthlyBtn');
    const yearlyBtn = document.getElementById('yearlyBtn');
    const monthlyPrices = document.querySelectorAll('.monthly-price');
    const yearlyPrices = document.querySelectorAll('.yearly-price');
    const yearlySavings = document.querySelectorAll('.yearly-savings');
    
    if (monthlyBtn && yearlyBtn) {
        yearlyBtn.addEventListener('click', () => {
            monthlyBtn.classList.remove('bg-gradient-to-r', 'from-primary', 'to-secondary', 'text-white');
            monthlyBtn.classList.add('text-gray-400');
            yearlyBtn.classList.add('bg-gradient-to-r', 'from-primary', 'to-secondary', 'text-white');
            yearlyBtn.classList.remove('text-gray-400');
            
            monthlyPrices.forEach(price => price.classList.add('hidden'));
            yearlyPrices.forEach(price => price.classList.remove('hidden'));
            yearlySavings.forEach(saving => saving.classList.remove('hidden'));
        });
        
        monthlyBtn.addEventListener('click', () => {
            yearlyBtn.classList.remove('bg-gradient-to-r', 'from-primary', 'to-secondary', 'text-white');
            yearlyBtn.classList.add('text-gray-400');
            monthlyBtn.classList.add('bg-gradient-to-r', 'from-primary', 'to-secondary', 'text-white');
            monthlyBtn.classList.remove('text-gray-400');
            
            yearlyPrices.forEach(price => price.classList.add('hidden'));
            monthlyPrices.forEach(price => price.classList.remove('hidden'));
            yearlySavings.forEach(saving => saving.classList.add('hidden'));
        });
    }

    // Analytics tracking for plan selection
    document.querySelectorAll('a[href*="subscription/create"]').forEach(button => {
        button.addEventListener('click', function(e) {
            const planName = this.href.split('/').pop();
            
            // Google Analytics event
            if (typeof gtag !== 'undefined') {
                gtag('event', 'plan_selected', {
                    event_category: 'Pricing',
                    event_label: planName,
                    value: 1
                });
            }
            
            // Facebook Pixel event
            if (typeof fbq !== 'undefined') {
                fbq('track', 'InitiateCheckout', {
                    content_name: planName,
                    content_category: 'Subscription Plan'
                });
            }
        });
    });
});

// FAQ Toggle
function toggleFAQ(id) {
    const content = document.getElementById(`faq-content-${id}`);
    const icon = document.getElementById(`faq-icon-${id}`);
    
    content.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}
</script>
@endsection