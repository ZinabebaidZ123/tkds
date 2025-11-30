@props(['plan', 'cycle' => 'monthly', 'featured' => false])

<div class="relative bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 {{ $featured ? 'ring-2 ring-primary scale-105' : '' }}">
    
    @if($plan->isPopular() || $featured)
        <!-- Popular Badge -->
        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-10">
            <div class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                {{ $plan->isPopular() ? 'Most Popular' : 'Featured' }}
            </div>
        </div>
    @endif

    @if($plan->isFeatured())
        <!-- Featured Glow Effect -->
        <div class="absolute inset-0 bg-gradient-to-r from-primary/5 to-secondary/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    @endif
    
    <div class="relative p-8">
        <!-- Plan Icon & Header -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-r {{ $plan->getColorClass() }} rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="{{ $plan->icon }} text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
            @if($plan->short_description)
                <p class="text-gray-600">{{ $plan->short_description }}</p>
            @endif
        </div>

        <!-- Pricing -->
        <div class="text-center mb-6">
            @php
                $price = $cycle === 'yearly' ? $plan->price_yearly : $plan->price_monthly;
                $displayPrice = $cycle === 'yearly' && $plan->price_yearly ? $plan->price_yearly / 12 : $price;
            @endphp
            
            @if($price > 0)
                <div class="flex items-center justify-center">
                    <span class="text-4xl font-black text-gray-900">
                        {{-- ✅ FIXED: Show exact price without rounding --}}
                        @if($displayPrice == floor($displayPrice))
                            ${{ number_format($displayPrice, 0) }}
                        @else
                            ${{ number_format($displayPrice, 2) }}
                        @endif
                    </span>
                    <span class="text-gray-500 ml-2">/month</span>
                </div>
                
                @if($cycle === 'yearly' && $plan->price_yearly)
                    <div class="text-sm text-gray-500 mt-1">
                        Billed annually (${{ $plan->price_yearly == floor($plan->price_yearly) ? number_format($plan->price_yearly, 0) : number_format($plan->price_yearly, 2) }})
                    </div>
                    @if($plan->getYearlySavingsPercentage() > 0)
                        <div class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium mt-2">
                            Save {{ $plan->getYearlySavingsPercentage() }}%
                        </div>
                    @endif
                @endif
            @else
                <div class="text-4xl font-black text-green-600">Free</div>
                <div class="text-gray-500 text-sm">No credit card required</div>
            @endif

            {{-- ✅ NEW: Setup Fee Display --}}
            @if($plan->hasSetupFee())
                <div class="mt-3 text-sm text-orange-600 bg-orange-50 border border-orange-200 rounded-lg p-2">
                    <i class="fas fa-plus-circle mr-1"></i>
                    {{ $plan->getFormattedSetupFee() }}
                </div>
            @endif
        </div>

        <!-- Trial Period -->
        @if($plan->trial_days)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-6 text-center">
                <div class="text-blue-700 text-sm font-medium">
                    <i class="fas fa-gift mr-2"></i>
                    {{ $plan->trial_days }} days free trial
                </div>
            </div>
        @endif

        <!-- Features -->
        @if($plan->getFeatures())
            <ul class="space-y-3 mb-8">
                @foreach($plan->getFeatures() as $feature)
                    <li class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fas fa-check text-green-600 text-xs"></i>
                        </div>
                        <span class="text-gray-700 text-sm">{{ $feature }}</span>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- ✅ ENHANCED: Usage Limits with all details --}}
        @if($plan->max_users || $plan->max_projects || $plan->storage_limit || $plan->bandwidth_limit)
            <div class="border-t border-gray-100 pt-6 mb-8">
                <h4 class="text-sm font-semibold text-gray-900 mb-4">Usage Limits</h4>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    @if($plan->max_users)
                        <div class="flex items-center space-x-2 bg-gray-50 rounded-lg p-2">
                            <i class="fas fa-users text-blue-500"></i>
                            <span class="text-gray-700">{{ number_format($plan->max_users) }} viewers</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 bg-green-50 rounded-lg p-2">
                            <i class="fas fa-infinity text-green-500"></i>
                            <span class="text-gray-700">Unlimited viewers</span>
                        </div>
                    @endif
                    
                    @if($plan->max_projects)
                        <div class="flex items-center space-x-2 bg-gray-50 rounded-lg p-2">
                            <i class="fas fa-folder text-purple-500"></i>
                            <span class="text-gray-700">{{ $plan->max_projects }} MB/S </span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 bg-green-50 rounded-lg p-2">
                            <i class="fas fa-infinity text-green-500"></i>
                            <span class="text-gray-700">Unlimited bitrate</span>
                        </div>
                    @endif
                    
                    @if($plan->storage_limit)
                        <div class="flex items-center space-x-2 bg-gray-50 rounded-lg p-2">
                            <i class="fas fa-hdd text-yellow-500"></i>
                            <span class="text-gray-700">{{ $plan->storage_limit }}</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 bg-green-50 rounded-lg p-2">
                            <i class="fas fa-infinity text-green-500"></i>
                            <span class="text-gray-700">Unlimited storage</span>
                        </div>
                    @endif
                    
                    @if($plan->bandwidth_limit)
                        <div class="flex items-center space-x-2 bg-gray-50 rounded-lg p-2">
                            <i class="fas fa-tachometer-alt text-red-500"></i>
                            <span class="text-gray-700">{{ $plan->bandwidth_limit }}</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 bg-green-50 rounded-lg p-2">
                            <i class="fas fa-infinity text-green-500"></i>
                            <span class="text-gray-700">Unlimited bandwidth</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Support Level -->
        <div class="flex items-center justify-between text-sm mb-8 bg-gray-50 rounded-lg p-3">
            <span class="text-gray-600 font-medium">Support Level:</span>
            <span class="font-bold text-gray-900 capitalize flex items-center {{ $plan->support_level === 'premium' ? 'text-primary' : '' }}">
                @if($plan->support_level === 'premium')
                    <i class="fas fa-crown text-primary mr-2"></i>
                @elseif($plan->support_level === 'priority')
                    <i class="fas fa-bolt text-orange-500 mr-2"></i>
                @else
                    <i class="fas fa-life-ring text-blue-500 mr-2"></i>
                @endif
                {{ ucfirst($plan->support_level) }} Support
            </span>
        </div>

        <!-- CTA Button -->
        @auth
            <a href="{{ route('subscription.create', ['pricingPlan' => $plan->slug, 'cycle' => $cycle]) }}" 
               class="w-full inline-block text-center px-6 py-4 {{ $plan->isPopular() || $featured ? 'bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-accent text-white' : 'bg-gray-900 hover:bg-gray-800 text-white' }} font-bold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                @if($price > 0)
                    @if($plan->trial_days)
                        Start Free Trial
                    @else
                        Subscribe Now
                    @endif
                @else
                    Get Started Free
                @endif
            </a>
        @else
            <a href="{{ route('auth.register') }}?plan={{ $plan->slug }}&cycle={{ $cycle }}" 
               class="w-full inline-block text-center px-6 py-4 {{ $plan->isPopular() || $featured ? 'bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-accent text-white' : 'bg-gray-900 hover:bg-gray-800 text-white' }} font-bold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                Get Started
            </a>
        @endauth
        
        <!-- Additional Info -->
        <div class="text-center mt-4">
            <a href="{{ route('pricing.show', $plan->slug) }}" 
               class="text-sm text-gray-500 hover:text-primary transition-colors duration-200">
                View Full Details →
            </a>
        </div>
    </div>

    <!-- Bottom Accent -->
    @if($plan->isPopular() || $featured)
        <div class="h-1 bg-gradient-to-r from-primary to-secondary"></div>
    @endif
</div>