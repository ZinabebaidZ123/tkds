{{-- File: resources/views/components/pricing-section.blade.php --}}
@php
    $plans = \App\Models\PricingPlan::active()
                ->showInHome()
                ->ordered()
                ->limit(3)
                ->get();

    // جلب البيانات الديناميكية من أول خطة تسعير
    $firstPlan = \App\Models\PricingPlan::orderBy('sort_order', 'asc')->first();
    
    $sectionData = [
        'title_part1' => $firstPlan->title_part1 ?? 'Choose Your',
        'title_part2' => $firstPlan->title_part2 ?? 'Video Content Management Package',
        'subtitle' => $firstPlan->subtitle ?? 'Flexible pricing designed to scale with your needs, from startup to enterprise'
    ];
@endphp

<section id="packages" class="py-20 bg-dark relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary to-transparent opacity-30"></div>
    <!-- Background Elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-primary/5 via-transparent to-secondary/5"></div>
        <div class="absolute top-40 right-20 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-40 left-20 w-80 h-80 bg-secondary/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16 max-w-7xl" data-aos="fade-up">
            <div class="inline-flex items-center space-x-2 bg-secondary/10 rounded-full px-6 py-2 mb-6">
                <i class="fas fa-star text-secondary"></i>
                <span class="text-secondary font-medium">Pricing Plans</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                {{ $sectionData['title_part1'] ?? 'Choose Your' }} 
                <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">
                    {{ $sectionData['title_part2'] ?? 'Video Content Management Package' }}
                </span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                {{ $sectionData['subtitle'] ?? 'Flexible pricing designed to scale with your needs, from startup to enterprise' }}
            </p>
        </div>
        
        @if($plans->count() > 0)
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
            
            <!-- Plans Grid -->
            <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @foreach($plans as $index => $plan)
                    <div class="glass-effect rounded-2xl p-8 relative group hover:bg-white/20 transition-all duration-300 transform hover:-translate-y-2 
                                {{ $plan->isPopular() ? 'border-2 border-primary' : '' }}" 
                         data-aos="fade-up" 
                         data-aos-delay="{{ ($index + 1) * 100 }}">
                        
                        @if($plan->isPopular())
                            <!-- Popular Badge -->
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                <div class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-2 rounded-full text-sm font-bold">
                                    Most Popular
                                </div>
                            </div>
                        @endif
                        
                        <div class="text-center">
                            <!-- Plan Icon -->
                            <div class="w-16 h-16 bg-gradient-to-r {{ $plan->getColorClass() }} rounded-xl flex items-center justify-center mx-auto mb-6">
                                <i class="{{ $plan->icon }} text-white text-2xl"></i>
                            </div>
                            
                            <!-- Plan Name & Description -->
                            <h3 class="text-2xl font-bold text-white mb-2">{{ $plan->name }}</h3>
                            <p class="text-gray-400 mb-6">{{ $plan->short_description }}</p>
                            
                            <!-- Pricing -->
                            <div class="mb-6">
                                @if($plan->price_monthly)
                                    <span class="text-4xl font-black text-white monthly-price" data-monthly="{{ $plan->price_monthly }}">
                                        {{-- Show exact price --}}
                                        @if($plan->price_monthly == floor($plan->price_monthly))
                                            ${{ number_format($plan->price_monthly, 0) }}
                                        @else
                                            ${{ number_format($plan->price_monthly, 2) }}
                                        @endif
                                    </span>
                                @endif
                                
                                @if($plan->price_yearly)
                                    <span class="text-4xl font-black text-white yearly-price hidden" data-yearly="{{ $plan->price_yearly }}">
                                        {{-- Show exact yearly price --}}
                                        @php $monthlyFromYearly = $plan->price_yearly / 12; @endphp
                                        @if($monthlyFromYearly == floor($monthlyFromYearly))
                                            ${{ number_format($monthlyFromYearly, 0) }}
                                        @else
                                            ${{ number_format($monthlyFromYearly, 2) }}
                                        @endif
                                    </span>
                                @endif
                                
                                @if(!$plan->price_monthly && !$plan->price_yearly)
                                    <span class="text-4xl font-black text-green-400">Free</span>
                                @else
                                    <span class="text-gray-400">/month</span>
                                @endif
                                
                                @if($plan->getYearlySavingsPercentage() > 0)
                                    <div class="yearly-savings hidden text-sm text-green-400 mt-2">
                                        Save {{ $plan->getYearlySavingsPercentage() }}% yearly
                                    </div>
                                @endif

                                {{-- Setup Fee Display --}}
                                @if($plan->hasSetupFee())
                                    <div class="mt-3 text-sm text-orange-300 bg-orange-500/10 border border-orange-500/20 rounded-lg p-2">
                                        <i class="fas fa-plus-circle mr-1"></i>
                                        {{ $plan->getFormattedSetupFee() }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Features -->
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

                            {{-- Usage Limits Display --}}
                            @if($plan->max_users || $plan->max_projects || $plan->storage_limit || $plan->bandwidth_limit)
                                <div class="border-t border-gray-700 pt-4 mb-6">
                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-400">
                                        @if($plan->max_users)
                                            <div class="flex items-center space-x-1">
                                                <i class="fas fa-users text-blue-400"></i>
                                                <span>{{ number_format($plan->max_users) }} viewers</span>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-1">
                                                <i class="fas fa-infinity text-green-400"></i>
                                                <span>Unlimited viewers</span>
                                            </div>
                                        @endif
                                        
                                        @if($plan->max_projects)
                                            <div class="flex items-center space-x-1">
                                                <i class="fas fa-signal text-purple-400"></i>
                                                <span>{{ number_format($plan->max_projects) }} MB/S</span>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-1">
                                                <i class="fas fa-infinity text-green-400"></i>
                                                <span>Unlimited bitrate</span>
                                            </div>
                                        @endif
                                        
                                        @if($plan->storage_limit)
                                            <div class="flex items-center space-x-1">
                                                <i class="fas fa-hdd text-yellow-400"></i>
                                                <span>{{ $plan->storage_limit }} Storage</span>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-1">
                                                <i class="fas fa-infinity text-green-400"></i>
                                                <span>Unlimited storage</span>
                                            </div>
                                        @endif
                                        
                                        @if($plan->bandwidth_limit)
                                            <div class="flex items-center space-x-1">
                                                <i class="fas fa-tachometer-alt text-red-400"></i>
                                                <span>{{ $plan->bandwidth_limit }}</span>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-1">
                                                <i class="fas fa-infinity text-green-400"></i>
                                                <span>Unlimited bandwidth</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Support Level -->
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
                            
                            <!-- Trial Period -->
                            @if($plan->trial_days)
                                <div class="bg-blue-500/20 rounded-lg p-3 mb-6">
                                    <div class="text-blue-300 text-sm">
                                        <i class="fas fa-gift mr-2"></i>
                                        {{ $plan->trial_days }} days free trial
                                    </div>
                                </div>
                            @endif
                            
                            <!-- CTA Button -->
                            @if($plan->isPopular())
                                <a href="{{ route('subscription.create', $plan->slug) }}" 
                                   class="w-full inline-block px-6 py-4 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105">
                                    Choose {{ $plan->name }}
                                </a>
                            @else
                                <a href="{{ route('subscription.create', $plan->slug) }}" 
                                   class="w-full inline-block px-6 py-4 glass-effect text-white font-bold rounded-xl hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                                    Get Started
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- View All Plans Link -->
            <div class="text-center mt-12" data-aos="fade-up">
                <a href="{{ route('pricing') }}" 
                   class="inline-flex items-center text-primary hover:text-secondary font-medium transition-colors duration-200">
                    View All Plans & Compare Features
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @else
            <!-- No Plans Available -->
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-tags text-3xl text-gray-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Plans Coming Soon</h3>
                <p class="text-gray-400 max-w-md mx-auto mb-8">
                    We're working on amazing pricing plans for you. Stay tuned for updates!
                </p>
                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-primary to-secondary text-white px-8 py-4 rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300">
                    Get Notified
                    <i class="fas fa-bell ml-2"></i>
                </a>
            </div>
        @endif
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pricing Toggle
    const monthlyBtn = document.getElementById('monthlyBtn');
    const yearlyBtn = document.getElementById('yearlyBtn');
    const monthlyPrices = document.querySelectorAll('.monthly-price');
    const yearlyPrices = document.querySelectorAll('.yearly-price');
    const yearlySavings = document.querySelectorAll('.yearly-savings');
    
    if (monthlyBtn && yearlyBtn) {
        yearlyBtn.addEventListener('click', () => {
            // Update buttons
            monthlyBtn.classList.remove('bg-gradient-to-r', 'from-primary', 'to-secondary', 'text-white');
            monthlyBtn.classList.add('text-gray-400');
            yearlyBtn.classList.add('bg-gradient-to-r', 'from-primary', 'to-secondary', 'text-white');
            yearlyBtn.classList.remove('text-gray-400');
            
            // Show yearly prices
            monthlyPrices.forEach(price => price.classList.add('hidden'));
            yearlyPrices.forEach(price => price.classList.remove('hidden'));
            yearlySavings.forEach(saving => saving.classList.remove('hidden'));
        });
        
        monthlyBtn.addEventListener('click', () => {
            // Update buttons
            yearlyBtn.classList.remove('bg-gradient-to-r', 'from-primary', 'to-secondary', 'text-white');
            yearlyBtn.classList.add('text-gray-400');
            monthlyBtn.classList.add('bg-gradient-to-r', 'from-primary', 'to-secondary', 'text-white');
            monthlyBtn.classList.remove('text-gray-400');
            
            // Show monthly prices
            yearlyPrices.forEach(price => price.classList.add('hidden'));
            monthlyPrices.forEach(price => price.classList.remove('hidden'));
            yearlySavings.forEach(saving => saving.classList.add('hidden'));
        });
    }
    
    // Add click tracking for analytics
    document.querySelectorAll('a[href*="subscription/create"]').forEach(button => {
        button.addEventListener('click', function(e) {
            // Track plan selection
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
</script>