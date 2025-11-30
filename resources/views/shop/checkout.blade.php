@extends('layouts.app')

@section('title', 'Checkout - TKDS Media')
@section('meta_description', 'Complete your purchase securely')

@section('content')

<!-- Breadcrumbs -->
<section class="bg-dark-light py-4 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">Home</a>
            <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
            <a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">Shop</a>
            <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
            <a href="{{ route('shop.cart') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">Cart</a>
            <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
            <span class="text-white">Checkout</span>
        </nav>
    </div>
</section>

<!-- Checkout Process -->
<section class="py-8 md:py-16 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Checkout Header -->
        <div class="text-center mb-8 md:mb-12" data-aos="fade-up">
            <h1 class="text-2xl md:text-4xl font-black text-white mb-4">Secure Checkout</h1>
            <p class="text-gray-400">Complete your order with our secure payment system</p>
        </div>

        <!-- Checkout Steps -->
        <div class="flex justify-center mb-8 md:mb-12" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center space-x-4 md:space-x-8">
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 md:w-8 md:h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-xs md:text-sm">1</div>
                    <span class="text-primary font-semibold text-xs md:text-base hidden sm:block">Information</span>
                </div>
                <div class="w-4 md:w-8 h-px bg-gray-600"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 md:w-8 md:h-8 bg-gray-600 rounded-full flex items-center justify-center text-gray-400 font-bold text-xs md:text-sm">2</div>
                    <span class="text-gray-400 text-xs md:text-base hidden sm:block">Payment</span>
                </div>
                <div class="w-4 md:w-8 h-px bg-gray-600"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 md:w-8 md:h-8 bg-gray-600 rounded-full flex items-center justify-center text-gray-400 font-bold text-xs md:text-sm">3</div>
                    <span class="text-gray-400 text-xs md:text-base hidden sm:block">Confirmation</span>
                </div>
            </div>
        </div>

        <form id="checkoutForm" class="grid lg:grid-cols-3 gap-4 md:gap-8 lg:gap-12">
            
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-4 md:space-y-8">
                
                <!-- Billing Information -->
                <div class="bg-white/5 backdrop-blur-xl rounded-xl p-3 md:p-6 border border-white/10" data-aos="fade-up">
                    <h2 class="text-lg md:text-xl font-bold text-white mb-4 md:mb-6 flex items-center">
                        <i class="fas fa-user mr-2 md:mr-3 text-primary"></i>
                        Billing Information
                    </h2>

                    <div class="grid gap-4 md:grid-cols-2 md:gap-6">
                        <!-- First Name -->
                        <div>
                            <label for="firstName" class="block text-xs md:text-sm font-semibold text-white mb-1 md:mb-2">First Name *</label>
                            <input type="text" id="firstName" name="billing_address[first_name]" required
                                   value="{{ auth()->user()->name ?? '' }}"
                                   class="w-full px-3 py-2 md:px-4 md:py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 text-sm md:text-base">
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="lastName" class="block text-xs md:text-sm font-semibold text-white mb-1 md:mb-2">Last Name *</label>
                            <input type="text" id="lastName" name="billing_address[last_name]" required
                                   class="w-full px-3 py-2 md:px-4 md:py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 text-sm md:text-base">
                        </div>

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <label for="email" class="block text-xs md:text-sm font-semibold text-white mb-1 md:mb-2">Email Address *</label>
                            <input type="email" id="email" name="billing_address[email]" required
                                   value="{{ auth()->user()->email ?? '' }}"
                                   class="w-full px-3 py-2 md:px-4 md:py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 text-sm md:text-base">
                        </div>

                        <!-- Phone -->
                        <div class="md:col-span-2">
                            <label for="phone" class="block text-xs md:text-sm font-semibold text-white mb-1 md:mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="billing_address[phone]"
                                   value="{{ auth()->user()->phone ?? '' }}"
                                   class="w-full px-3 py-2 md:px-4 md:py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 text-sm md:text-base">
                        </div>

                        <!-- Address Line 1 -->
                        <div class="md:col-span-2">
                            <label for="addressLine1" class="block text-xs md:text-sm font-semibold text-white mb-1 md:mb-2">Address Line 1 *</label>
                            <input type="text" id="addressLine1" name="billing_address[address_line_1]" required
                                   placeholder="Street address, P.O. box, company name, c/o"
                                   class="w-full px-3 py-2 md:px-4 md:py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 text-sm md:text-base">
                        </div>

                        <!-- Address Line 2 -->
                        <div class="md:col-span-2">
                            <label for="addressLine2" class="block text-xs md:text-sm font-semibold text-white mb-1 md:mb-2">Address Line 2</label>
                            <input type="text" id="addressLine2" name="billing_address[address_line_2]"
                                   placeholder="Apartment, suite, unit, building, floor, etc."
                                   class="w-full px-3 py-2 md:px-4 md:py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 text-sm md:text-base">
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city" class="block text-xs md:text-sm font-semibold text-white mb-1 md:mb-2">City *</label>
                            <input type="text" id="city" name="billing_address[city]" required
                                   class="w-full px-3 py-2 md:px-4 md:py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 text-sm md:text-base">
                        </div>

                        <!-- State -->
                        <div>
                            <label for="state" class="block text-xs md:text-sm font-semibold text-white mb-1 md:mb-2">State/Province</label>
                            <input type="text" id="state" name="billing_address[state]"
                                   class="w-full px-3 py-2 md:px-4 md:py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 text-sm md:text-base">
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <label for="postalCode" class="block text-xs md:text-sm font-semibold text-white mb-1 md:mb-2">Postal Code *</label>
                            <input type="text" id="postalCode" name="billing_address[postal_code]" required
                                   class="w-full px-3 py-2 md:px-4 md:py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 text-sm md:text-base">
                        </div>

                        <!-- Country -->
                        <div>
                            <label for="country" class="block text-xs md:text-sm font-semibold text-white mb-1 md:mb-2">Country *</label>
                            <select id="country" name="billing_address[country]" required
                                    class="w-full px-3 py-2 md:px-4 md:py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 text-sm md:text-base">
                                <option value="">Select Country</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                                <option value="AU">Australia</option>
                                <option value="DE">Germany</option>
                                <option value="FR">France</option>
                                <option value="IT">Italy</option>
                                <option value="ES">Spain</option>
                                <option value="EG">Egypt</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="bg-white/5 backdrop-blur-xl rounded-xl p-3 md:p-6 border border-white/10" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-between mb-4 md:mb-6">
                        <h2 class="text-lg md:text-xl font-bold text-white flex items-center">
                            <i class="fas fa-shipping-fast mr-2 md:mr-3 text-secondary"></i>
                            Shipping Information
                        </h2>
                        <label class="flex items-center space-x-2 text-xs md:text-sm">
                            <input type="checkbox" id="sameAsBilling" checked 
                                   class="rounded bg-white/10 border-white/20 text-primary focus:ring-primary focus:ring-offset-0">
                            <span class="text-gray-300">Same as billing</span>
                        </label>
                    </div>

                    <div id="shippingForm" class="hidden">
                        <div class="grid gap-4 md:grid-cols-2 md:gap-6">
                            <div>
                                <label class="block text-xs md:text-sm font-semibold text-white mb-1 md:mb-2">First Name *</label>
                                <input type="text" name="shipping_address[first_name]"
                                       class="w-full px-3 py-2 md:px-4 md:py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 text-sm md:text-base">
                            </div>
                            <div>
                                <label class="block text-xs md:text-sm font-semibold text-white mb-1 md:mb-2">Last Name *</label>
                                <input type="text" name="shipping_address[last_name]"
                                       class="w-full px-3 py-2 md:px-4 md:py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 text-sm md:text-base">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white/5 backdrop-blur-xl rounded-xl p-3 md:p-6 border border-white/10" data-aos="fade-up" data-aos-delay="400">
                    <h2 class="text-lg md:text-xl font-bold text-white mb-4 md:mb-6 flex items-center">
                        <i class="fas fa-credit-card mr-2 md:mr-3 text-accent"></i>
                        Payment Method
                    </h2>

                    <div class="space-y-4">
                        <label class="flex items-center space-x-3 md:space-x-4 p-3 md:p-4 bg-white/5 rounded-xl border border-white/10 hover:border-primary/30 transition-all duration-300 cursor-pointer">
                            <input type="radio" name="payment_method" value="stripe" checked 
                                   class="text-primary focus:ring-primary focus:ring-offset-0">
                            <div class="flex items-center space-x-2 md:space-x-3">
                                <i class="fas fa-credit-card text-primary text-lg md:text-xl"></i>
                                <div>
                                    <h3 class="text-white font-semibold text-sm md:text-base">Credit/Debit Card</h3>
                                    <p class="text-gray-400 text-xs md:text-sm">Secure payment via Stripe</p>
                                </div>
                            </div>
                            <div class="ml-auto flex space-x-1 md:space-x-2">
                                <i class="fab fa-cc-visa text-lg md:text-2xl text-blue-500"></i>
                                <i class="fab fa-cc-mastercard text-lg md:text-2xl text-red-500"></i>
                                <i class="fab fa-cc-amex text-lg md:text-2xl text-blue-400"></i>
                            </div>
                        </label>
                    </div>

                    <!-- Security Information -->
                    <div class="mt-4 md:mt-6 p-3 md:p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
                        <div class="flex items-center space-x-2 md:space-x-3">
                            <i class="fas fa-shield-alt text-green-400 text-lg md:text-xl"></i>
                            <div>
                                <h4 class="text-green-300 font-semibold text-sm md:text-base">Secure Payment</h4>
                                <p class="text-green-400 text-xs md:text-sm">Your payment information is encrypted and secure</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="bg-white/5 backdrop-blur-xl rounded-xl p-3 md:p-6 border border-white/10" data-aos="fade-up" data-aos-delay="600">
                    <label class="flex items-start space-x-3 cursor-pointer">
                        <input type="checkbox" name="terms_accepted" required 
                               class="mt-1 rounded bg-white/10 border-white/20 text-primary focus:ring-primary focus:ring-offset-0">
                        <div class="text-xs md:text-sm text-gray-300">
                            I agree to the 
                            <a href="{{ route('terms-conditions') }}" target="_blank" class="text-primary hover:text-secondary transition-colors duration-200">Terms and Conditions</a> 
                            and 
                            <a href="{{ route('privacy-policy') }}" target="_blank" class="text-primary hover:text-secondary transition-colors duration-200">Privacy Policy</a>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white/5 backdrop-blur-xl rounded-xl p-3 md:p-6 border border-white/10 lg:sticky lg:top-8" data-aos="fade-up" data-aos-delay="300">
                    <h2 class="text-lg md:text-xl font-bold text-white mb-4 md:mb-6">Order Summary</h2>

                    <!-- Cart Items -->
                    <div id="orderItems" class="space-y-3 md:space-y-4 mb-4 md:mb-6">
                        <div class="text-center py-6 md:py-8">
                            <div class="animate-spin w-6 h-6 md:w-8 md:h-8 border-2 border-primary border-t-transparent rounded-full mx-auto mb-3 md:mb-4"></div>
                            <p class="text-gray-400 text-sm">Loading order details...</p>
                        </div>
                    </div>

                    <!-- Order Totals -->
                    <div class="space-y-2 md:space-y-3 mb-4 md:mb-6 border-t border-white/10 pt-4 md:pt-6">
                        <div class="flex justify-between text-sm md:text-base">
                            <span class="text-gray-400">Subtotal:</span>
                            <span id="orderSubtotal" class="text-white font-semibold">$0.00</span>
                        </div>
                        <div class="flex justify-between text-sm md:text-base">
                            <span class="text-gray-400">Shipping:</span>
                            <span id="orderShipping" class="text-white">Calculated at checkout</span>
                        </div>
                        <div class="flex justify-between text-sm md:text-base">
                            <span class="text-gray-400">Tax:</span>
                            <span id="orderTax" class="text-white">$0.00</span>
                        </div>
                        <div class="border-t border-white/10 pt-2 md:pt-3">
                            <div class="flex justify-between">
                                <span class="text-base md:text-lg font-bold text-white">Total:</span>
                                <span id="orderTotal" class="text-base md:text-lg font-bold text-primary">$0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" id="placeOrderBtn"
                            class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 md:py-4 rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm md:text-base">
                        <span id="buttonText">
                            <i class="fas fa-lock mr-2"></i>
                            Place Order
                        </span>
                        <span id="buttonSpinner" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Processing...
                        </span>
                    </button>

                    <!-- Security Badges -->
                    <div class="grid grid-cols-3 gap-2 md:gap-4 text-center text-xs text-gray-400 mt-4 md:mt-6">
                        <div>
                            <i class="fas fa-shield-alt text-green-400 text-sm md:text-lg mb-1"></i>
                            <p class="text-xs">SSL Secured</p>
                        </div>
                        <div>
                            <i class="fas fa-lock text-green-400 text-sm md:text-lg mb-1"></i>
                            <p class="text-xs">Safe Payment</p>
                        </div>
                        <div>
                            <i class="fas fa-undo text-green-400 text-sm md:text-lg mb-1"></i>
                            <p class="text-xs">Easy Returns</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Messages -->
<div id="successMessage" class="fixed top-4 right-4 z-50 hidden">
    <div class="bg-green-500 text-white px-4 py-3 md:px-6 md:py-4 rounded-lg shadow-lg max-w-sm md:max-w-md">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2 md:mr-3"></i>
            <span id="successText" class="text-sm md:text-base">Order placed successfully!</span>
        </div>
    </div>
</div>

<div id="errorMessage" class="fixed top-4 right-4 z-50 hidden">
    <div class="bg-red-500 text-white px-4 py-3 md:px-6 md:py-4 rounded-lg shadow-lg max-w-sm md:max-w-md">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-2 md:mr-3"></i>
            <span id="errorText" class="text-sm md:text-base">Something went wrong. Please try again.</span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadOrderSummary();
    initializeCheckoutForm();
});

document.getElementById('sameAsBilling').addEventListener('change', function() {
    const shippingForm = document.getElementById('shippingForm');
    if (this.checked) {
        shippingForm.classList.add('hidden');
    } else {
        shippingForm.classList.remove('hidden');
    }
});

function loadOrderSummary() {
    fetch('{{ route("shop.cart.items") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.items.length > 0) {
                renderOrderItems(data.items);
                updateOrderTotals(data.summary);
            } else {
                window.location.href = '{{ route("shop.cart") }}';
            }
        })
        .catch(error => {
            console.error('Failed to load order summary:', error);
        });
}

function renderOrderItems(items) {
    const container = document.getElementById('orderItems');
    container.innerHTML = '';

    items.forEach(item => {
        const itemElement = document.createElement('div');
        itemElement.className = 'flex items-center space-x-2 md:space-x-3 p-2 md:p-3 bg-white/5 rounded-lg';
        itemElement.innerHTML = `
            <img src="${item.product_image}" alt="${item.product_name}" class="w-10 h-10 md:w-12 md:h-12 object-cover rounded-lg">
            <div class="flex-1 min-w-0">
                <h4 class="text-white font-medium text-xs md:text-sm truncate">${item.product_name}</h4>
                <p class="text-gray-400 text-xs">Qty: ${item.quantity}</p>
            </div>
            <span class="text-primary font-semibold text-xs md:text-sm">${item.subtotal}</span>
        `;
        container.appendChild(itemElement);
    });
}

function updateOrderTotals(summary) {
    document.getElementById('orderSubtotal').textContent = summary.subtotal_formatted;
    document.getElementById('orderShipping').textContent = summary.shipping_formatted;
    document.getElementById('orderTax').textContent = summary.tax_formatted;
    document.getElementById('orderTotal').textContent = summary.total_formatted;
}

function initializeCheckoutForm() {
    const form = document.getElementById('checkoutForm');
    form.addEventListener('submit', handleCheckoutSubmission);
}

function handleCheckoutSubmission(e) {
    e.preventDefault();
    
    const form = e.target;
    const button = document.getElementById('placeOrderBtn');
    const buttonText = document.getElementById('buttonText');
    const buttonSpinner = document.getElementById('buttonSpinner');
    
    if (!validateCheckoutForm(form)) {
        return;
    }
    
    button.disabled = true;
    buttonText.classList.add('hidden');
    buttonSpinner.classList.remove('hidden');
    
    clearAllFieldErrors();
    
    const data = {
        billing_address: {
            first_name: form.querySelector('[name="billing_address[first_name]"]').value.trim(),
            last_name: form.querySelector('[name="billing_address[last_name]"]').value.trim(),
            email: form.querySelector('[name="billing_address[email]"]').value.trim(),
            phone: form.querySelector('[name="billing_address[phone]"]').value.trim(),
            address_line_1: form.querySelector('[name="billing_address[address_line_1]"]').value.trim(),
            address_line_2: form.querySelector('[name="billing_address[address_line_2]"]').value.trim(),
            city: form.querySelector('[name="billing_address[city]"]').value.trim(),
            state: form.querySelector('[name="billing_address[state]"]').value.trim(),
            postal_code: form.querySelector('[name="billing_address[postal_code]"]').value.trim(),
            country: form.querySelector('[name="billing_address[country]"]').value.trim()
        },
        payment_method: form.querySelector('[name="payment_method"]:checked').value,
        terms_accepted: form.querySelector('[name="terms_accepted"]').checked ? 'on' : null,
        notes: form.querySelector('[name="notes"]')?.value.trim() || null
    };
    
    const sameAsBilling = document.getElementById('sameAsBilling').checked;
    if (!sameAsBilling) {
        data.shipping_address = {
            first_name: form.querySelector('[name="shipping_address[first_name]"]')?.value.trim() || '',
            last_name: form.querySelector('[name="shipping_address[last_name]"]')?.value.trim() || '',
            address_line_1: form.querySelector('[name="shipping_address[address_line_1]"]')?.value.trim() || '',
            city: form.querySelector('[name="shipping_address[city]"]')?.value.trim() || '',
            postal_code: form.querySelector('[name="shipping_address[postal_code]"]')?.value.trim() || '',
            country: form.querySelector('[name="shipping_address[country]"]')?.value.trim() || ''
        };
    }
    
    fetch('{{ route("shop.checkout.process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessMessage('Redirecting to payment...');
            window.location.href = data.checkout_url;
        } else {
            handleCheckoutError(data);
        }
    })
    .catch(error => {
        console.error('Checkout error:', error);
        showErrorMessage('Something went wrong. Please try again.');
    })
    .finally(() => {
        button.disabled = false;
        buttonText.classList.remove('hidden');
        buttonSpinner.classList.add('hidden');
    });
}

function validateCheckoutForm(form) {
    let isValid = true;
    const requiredFields = [
        { name: 'billing_address[first_name]', label: 'First Name' },
        { name: 'billing_address[last_name]', label: 'Last Name' },
        { name: 'billing_address[email]', label: 'Email' },
        { name: 'billing_address[address_line_1]', label: 'Address' },
        { name: 'billing_address[city]', label: 'City' },
        { name: 'billing_address[postal_code]', label: 'Postal Code' },
        { name: 'billing_address[country]', label: 'Country' }
    ];
    
    requiredFields.forEach(fieldInfo => {
        const field = form.querySelector(`[name="${fieldInfo.name}"]`);
        if (field && !field.value.trim()) {
            showFieldError(field, `${fieldInfo.label} is required`);
            isValid = false;
        }
    });
    
    // Validate email format
    const emailField = form.querySelector('[name="billing_address[email]"]');
    if (emailField && emailField.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailField.value)) {
            showFieldError(emailField, 'Please enter a valid email address');
            isValid = false;
        }
    }
    
    // Validate terms acceptance
    const termsField = form.querySelector('[name="terms_accepted"]');
    if (termsField && !termsField.checked) {
        showFieldError(termsField, 'You must accept the terms and conditions');
        isValid = false;
    }
    
    // Validate payment method
    const paymentMethod = form.querySelector('[name="payment_method"]:checked');
    if (!paymentMethod) {
        showErrorMessage('Please select a payment method');
        isValid = false;
    }
    
    return isValid;
}

function clearAllFieldErrors() {
    document.querySelectorAll('.field-error').forEach(error => error.remove());
    document.querySelectorAll('.border-red-500').forEach(field => {
        field.classList.remove('border-red-500');
    });
}

function handleCheckoutError(data) {
    if (data.errors) {
        Object.keys(data.errors).forEach(field => {
            let fieldSelector = '';
            
            if (field.startsWith('billing_address.')) {
                const subField = field.replace('billing_address.', '');
                fieldSelector = `[name="billing_address[${subField}]"]`;
            } else if (field.startsWith('shipping_address.')) {
                const subField = field.replace('shipping_address.', '');
                fieldSelector = `[name="shipping_address[${subField}]"]`;
            } else {
                fieldSelector = `[name="${field}"]`;
            }
            
            const fieldElement = document.querySelector(fieldSelector);
            if (fieldElement) {
                fieldElement.classList.add('border-red-500');
                showFieldError(fieldElement, data.errors[field][0]);
                
                if (document.querySelectorAll('.field-error').length === 1) {
                    fieldElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    } else {
        showErrorMessage(data.message || 'Checkout failed. Please try again.');
    }
}

function showFieldError(field, message) {
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    const errorElement = document.createElement('p');
    errorElement.className = 'field-error text-red-400 text-xs mt-1';
    errorElement.textContent = message;
    field.parentNode.appendChild(errorElement);
}

function showErrorMessage(message) {
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    
    errorText.textContent = message;
    errorMessage.classList.remove('hidden');
    
    setTimeout(() => {
        errorMessage.classList.add('hidden');
    }, 5000);
}

function showSuccessMessage(message) {
    const successMessage = document.getElementById('successMessage');
    const successText = document.getElementById('successText');
    
    successText.textContent = message;
    successMessage.classList.remove('hidden');
    
    setTimeout(() => {
        successMessage.classList.add('hidden');
    }, 5000);
}

// Clear field errors on input
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('border-red-500')) {
        e.target.classList.remove('border-red-500');
        const errorElement = e.target.parentNode.querySelector('.field-error');
        if (errorElement) {
            errorElement.remove();
        }
    }
});

// Auto-fill user info
function autoFillUserInfo() {
    @if(auth()->check())
        const user = @json(auth()->user());
        if (user) {
            const firstNameField = document.getElementById('firstName');
            const lastNameField = document.getElementById('lastName');
            const emailField = document.getElementById('email');
            const phoneField = document.getElementById('phone');
            
            if (firstNameField && user.name) {
                firstNameField.value = user.name.split(' ')[0] || '';
            }
            if (lastNameField && user.name) {
                lastNameField.value = user.name.split(' ').slice(1).join(' ') || '';
            }
            if (emailField && user.email) {
                emailField.value = user.email;
            }
            if (phoneField && user.phone) {
                phoneField.value = user.phone;
            }
        }
    @endif
}

// Same as billing checkbox handler
document.addEventListener('DOMContentLoaded', function() {
    const sameAsBillingCheckbox = document.getElementById('sameAsBilling');
    if (sameAsBillingCheckbox) {
        sameAsBillingCheckbox.addEventListener('change', function() {
            const shippingForm = document.getElementById('shippingForm');
            if (shippingForm) {
                if (this.checked) {
                    shippingForm.classList.add('hidden');
                } else {
                    shippingForm.classList.remove('hidden');
                }
            }
        });
    }
    
    loadOrderSummary();
    initializeCheckoutForm();
    autoFillUserInfo();
});
</script>
