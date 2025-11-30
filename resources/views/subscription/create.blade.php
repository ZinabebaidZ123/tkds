{{-- File: resources/views/subscription/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Subscribe to ' . $pricingPlan->name . ' - TKDS Media')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark via-dark-light to-dark py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('pricing') }}" class="inline-flex items-center text-gray-400 hover:text-primary transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Pricing
            </a>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            
            <!-- Plan Details -->
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r {{ $pricingPlan->getColorClass() }} rounded-2xl flex items-center justify-center">
                        <i class="{{ $pricingPlan->icon }} text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $pricingPlan->name }}</h1>
                        <p class="text-gray-400">{{ $pricingPlan->short_description }}</p>
                    </div>
                </div>

                <!-- Price -->
                <div class="mb-6 p-6 bg-white/5 rounded-xl">
                    <div class="text-center">
                        <div class="text-4xl font-black text-white mb-2">
                            {{ $pricingPlan->getFormattedPrice($cycle) }}
                        </div>
                        @if($cycle === 'yearly' && $pricingPlan->getYearlySavingsPercentage() > 0)
                            <div class="text-green-400 text-sm">
                                Save {{ $pricingPlan->getYearlySavingsPercentage() }}% with yearly billing
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Features -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-white mb-4">What's Included:</h3>
                    <div class="space-y-3">
                        @foreach($pricingPlan->getFeatures() as $feature)
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-check text-green-400 flex-shrink-0"></i>
                                <span class="text-gray-300">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($pricingPlan->trial_days)
                    <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-gift text-blue-400"></i>
                            <span class="text-blue-400 font-semibold">{{ $pricingPlan->trial_days }}-Day Free Trial</span>
                        </div>
                        <p class="text-blue-300 text-sm mt-1">
                            Start your free trial today. Cancel anytime during the trial period.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Payment Form -->
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                <h2 class="text-2xl font-bold text-white mb-6">Complete Your Subscription</h2>

                <!-- User Info -->
                <div class="mb-6 p-4 bg-white/5 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-xl object-cover">
                        <div>
                            <p class="text-white font-semibold">{{ $user->name }}</p>
                            <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form id="subscription-form">
                    @csrf
                    <input type="hidden" name="pricing_plan_id" value="{{ $pricingPlan->id }}">
                    <input type="hidden" name="billing_cycle" value="{{ $cycle }}">

                    <!-- Card Element -->
                    <div class="mb-6">
                        <label class="block text-gray-300 text-sm font-medium mb-2">Payment Information</label>
                        <div id="card-element" class="p-4 bg-white/10 rounded-xl border border-white/20">
                            <!-- Stripe Elements will create form elements here -->
                        </div>
                        <div id="card-errors" class="text-red-400 text-sm mt-2" role="alert"></div>
                    </div>

                    <!-- Terms -->
                    <div class="mb-6">
                        <label class="flex items-start space-x-3">
                            <input type="checkbox" id="terms-checkbox" class="mt-1 text-primary focus:ring-primary border-gray-600 bg-transparent rounded">
                            <span class="text-gray-300 text-sm">
                                I agree to the <a href="{{ route('terms-conditions') }}" class="text-primary hover:text-secondary">Terms & Conditions</a> 
                                and <a href="{{ route('privacy-policy') }}" class="text-primary hover:text-secondary">Privacy Policy</a>
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submit-button" 
                            class="w-full bg-gradient-to-r from-primary to-secondary text-white py-4 rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <span id="button-text">
                            @if($pricingPlan->trial_days)
                                Start {{ $pricingPlan->trial_days }}-Day Free Trial
                            @else
                                Subscribe Now - {{ $pricingPlan->getFormattedPrice($cycle) }}
                            @endif
                        </span>
                        <i id="button-icon" class="fas fa-credit-card ml-2"></i>
                    </button>
                </form>

                <!-- Security Info -->
                <div class="mt-6 text-center">
                    <div class="flex items-center justify-center space-x-4 text-gray-400 text-sm">
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-shield-alt"></i>
                            <span>Secure</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-lock"></i>
                            <span>SSL Encrypted</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-undo"></i>
                            <span>Cancel Anytime</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="success-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-dark/95 backdrop-blur-xl rounded-2xl p-8 border border-white/10 max-w-md mx-4 text-center">
        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-check text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Subscription Successful! </h3>
        <p class="text-gray-400 mb-6">Welcome to {{ $pricingPlan->name }}! Your subscription is now active.</p>
        <div class="text-center">
        <p class="text-gray-400 mb-6">Please Wait Transfer you to other page</p>
        </div>
    </div>
</div>

<!-- Stripe JS -->
<script src="https://js.stripe.com/v3/"></script>

<script>
// Initialize Stripe
const stripe = Stripe('{{ $publicKey }}');
const elements = stripe.elements({
    appearance: {
        theme: 'night',
        variables: {
            colorPrimary: '#C53030',
            colorBackground: 'rgba(255, 255, 255, 0.1)',
            colorText: '#ffffff',
            colorDanger: '#ef4444',
            borderRadius: '12px',
        }
    }
});

// Create card element
const cardElement = elements.create('card');
cardElement.mount('#card-element');

// Handle real-time validation errors from the card Element
cardElement.on('change', ({error}) => {
    const displayError = document.getElementById('card-errors');
    if (error) {
        displayError.textContent = error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission
const form = document.getElementById('subscription-form');
const submitButton = document.getElementById('submit-button');
const buttonText = document.getElementById('button-text');
const buttonIcon = document.getElementById('button-icon');
const termsCheckbox = document.getElementById('terms-checkbox');

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    // Check terms agreement
    if (!termsCheckbox.checked) {
        alert('Please agree to the Terms & Conditions and Privacy Policy');
        return;
    }

    // Disable submit button
    submitButton.disabled = true;
    buttonText.textContent = 'Processing...';
    buttonIcon.className = 'fas fa-spinner fa-spin ml-2';

    try {
        // ✅ STEP 1: Create subscription first
        const formData = new FormData(form);
        
        const subscriptionResponse = await fetch('{{ route("subscription.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });

        const subscriptionData = await subscriptionResponse.json();

        if (!subscriptionResponse.ok) {
            throw new Error(subscriptionData.message || 'Failed to create subscription');
        }

        // ✅ STEP 2: If there's a client_secret, confirm payment
        if (subscriptionData.client_secret) {
            const {error: stripeError, paymentIntent} = await stripe.confirmCardPayment(
                subscriptionData.client_secret,
                {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: '{{ $user->name }}',
                            email: '{{ $user->email }}'
                        }
                    }
                }
            );

            if (stripeError) {
                throw new Error(stripeError.message);
            }

            console.log('Payment confirmed:', paymentIntent);
        }

        // ✅ STEP 3: Show success and redirect
        document.getElementById('success-modal').classList.remove('hidden');
        
        // Auto redirect after 3 seconds
        setTimeout(() => {
            window.location.href = '{{ route("subscription.success") }}?subscription_id=' + subscriptionData.subscription_id;
        }, 3000);

    } catch (error) {
        console.error('Subscription error:', error);
        alert('Error: ' + error.message);
    } finally {
        // Re-enable submit button
        submitButton.disabled = false;
        buttonText.textContent = '@if($pricingPlan->trial_days) Start {{ $pricingPlan->trial_days }}-Day Free Trial @else Subscribe Now - {{ $pricingPlan->getFormattedPrice($cycle) }} @endif';
        buttonIcon.className = 'fas fa-credit-card ml-2';
    }
});

// Auto-redirect if already has subscription
@if(auth()->user()->hasActiveSubscription())
    setTimeout(() => {
        if (confirm('You already have an active subscription. Go to manage it?')) {
            window.location.href = '{{ route("user.subscription.show") }}';
        } else {
            window.location.href = '{{ route("pricing") }}';
        }
    }, 1000);
@endif
</script>
@endsection