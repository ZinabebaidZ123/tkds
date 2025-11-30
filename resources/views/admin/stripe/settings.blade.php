@extends('admin.layouts.app')

@section('title', 'Stripe Settings')
@section('page-title', 'Stripe Configuration')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Stripe Settings</h2>
            <p class="text-gray-600 text-sm mt-1">Configure your Stripe payment gateway</p>
        </div>
        <button onclick="testConnection()" 
                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200">
            <i class="fas fa-plug mr-2"></i>
            Test Connection
        </button>
    </div>

    <!-- Configuration Form -->
    <form action="{{ route('admin.stripe.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Settings -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Environment Settings -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">Environment</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Environment</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative">
                                    <input type="radio" name="environment" value="sandbox" 
                                           {{ old('environment', $settings->environment) === 'sandbox' ? 'checked' : '' }}
                                           class="sr-only">
                                    <div class="block w-full p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 
                                                {{ old('environment', $settings->environment) === 'sandbox' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-300 hover:border-gray-400' }}">
                                        <div class="flex items-center">
                                            <i class="fas fa-flask text-yellow-600 mr-3"></i>
                                            <div>
                                                <div class="font-medium">Sandbox</div>
                                                <div class="text-sm text-gray-500">For testing</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="relative">
                                    <input type="radio" name="environment" value="live" 
                                           {{ old('environment', $settings->environment) === 'live' ? 'checked' : '' }}
                                           class="sr-only">
                                    <div class="block w-full p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 
                                                {{ old('environment', $settings->environment) === 'live' ? 'border-green-500 bg-green-50' : 'border-gray-300 hover:border-gray-400' }}">
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                                            <div>
                                                <div class="font-medium">Live</div>
                                                <div class="text-sm text-gray-500">Production</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="active" {{ old('status', $settings->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $settings->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- API Keys -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">API Keys</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Live Keys -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900 flex items-center">
                                <i class="fas fa-globe text-green-600 mr-2"></i>
                                Live Environment
                            </h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label for="live_public_key" class="block text-sm font-medium text-gray-700 mb-2">
                                        Publishable Key
                                    </label>
                                    <input type="text" name="live_public_key" id="live_public_key"
                                           value="{{ old('live_public_key', $settings->live_public_key) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary font-mono text-sm"
                                           placeholder="pk_live_...">
                                </div>
                                <div>
                                    <label for="live_secret_key" class="block text-sm font-medium text-gray-700 mb-2">
                                        Secret Key
                                    </label>
                                    <input type="password" name="live_secret_key" id="live_secret_key"
                                           value="{{ old('live_secret_key', $settings->live_secret_key) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary font-mono text-sm"
                                           placeholder="sk_live_...">
                                </div>
                            </div>
                        </div>

                        <!-- Test Keys -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900 flex items-center">
                                <i class="fas fa-flask text-yellow-600 mr-2"></i>
                                Test Environment
                            </h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label for="sandbox_public_key" class="block text-sm font-medium text-gray-700 mb-2">
                                        Publishable Key
                                    </label>
                                    <input type="text" name="sandbox_public_key" id="sandbox_public_key"
                                           value="{{ old('sandbox_public_key', $settings->sandbox_public_key) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary font-mono text-sm"
                                           placeholder="pk_test_...">
                                </div>
                                <div>
                                    <label for="sandbox_secret_key" class="block text-sm font-medium text-gray-700 mb-2">
                                        Secret Key
                                    </label>
                                    <input type="password" name="sandbox_secret_key" id="sandbox_secret_key"
                                           value="{{ old('sandbox_secret_key', $settings->sandbox_secret_key) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary font-mono text-sm"
                                           placeholder="sk_test_...">
                                </div>
                            </div>
                        </div>

                        <!-- Webhook Secret -->
                        <div>
                            <label for="webhook_secret" class="block text-sm font-medium text-gray-700 mb-2">
                                Webhook Secret
                            </label>
                            <input type="password" name="webhook_secret" id="webhook_secret"
                                   value="{{ old('webhook_secret', $settings->webhook_secret) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary font-mono text-sm"
                                   placeholder="whsec_...">
                            <p class="text-xs text-gray-500 mt-1">Used to verify webhook signatures</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">Payment Settings</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label for="default_currency" class="block text-sm font-medium text-gray-700 mb-2">
                                Default Currency
                            </label>
                            <select name="default_currency" id="default_currency" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="USD" {{ old('default_currency', $settings->default_currency) === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="EUR" {{ old('default_currency', $settings->default_currency) === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ old('default_currency', $settings->default_currency) === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                <option value="CAD" {{ old('default_currency', $settings->default_currency) === 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                <option value="AUD" {{ old('default_currency', $settings->default_currency) === 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                            </select>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label for="collect_billing_address" class="text-sm font-medium text-gray-700">
                                    Collect Billing Address
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
 <input type="checkbox" name="collect_billing_address" value="1" 
       {{ old('collect_billing_address', $settings->collect_billing_address) ? 'checked' : '' }}
       class="status-toggle sr-only">
<div class="w-11 h-6 bg-gray-200 rounded-full relative"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <label for="collect_shipping_address" class="text-sm font-medium text-gray-700">
                                    Collect Shipping Address
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
 <input type="checkbox" name="collect_shipping_address" value="1" 
       {{ old('collect_shipping_address', $settings->collect_shipping_address) ? 'checked' : '' }}
       class="status-toggle sr-only">
<div class="w-11 h-6 bg-gray-200 rounded-full relative"></div>                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <label for="enable_tax_calculation" class="text-sm font-medium text-gray-700">
                                    Enable Tax Calculation
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
    <input type="checkbox" name="enable_tax_calculation" value="1" 
       {{ old('enable_tax_calculation', $settings->enable_tax_calculation) ? 'checked' : '' }}
       class="status-toggle sr-only">
<div class="w-11 h-6 bg-gray-200 rounded-full relative"></div>                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Connection Status -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Connection Status</h3>
                    <div id="connectionStatus" class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center 
                                    {{ $settings->isConfigured() ? 'bg-green-100' : 'bg-yellow-100' }}">
                            <i class="fas {{ $settings->isConfigured() ? 'fa-check-circle text-green-600' : 'fa-exclamation-triangle text-yellow-600' }} text-2xl"></i>
                        </div>
                        <div class="font-medium {{ $settings->isConfigured() ? 'text-green-900' : 'text-yellow-900' }}">
                            {{ $settings->isConfigured() ? 'Connected' : 'Not Configured' }}
                        </div>
                        <div class="text-sm {{ $settings->isConfigured() ? 'text-green-600' : 'text-yellow-600' }} mt-1">
                            {{ $settings->isConfigured() ? 'Stripe is ready to process payments' : 'Please configure your API keys' }}
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Stats</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Revenue</span>
                            <span class="font-semibold">${{ number_format($stats['total_revenue']) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subscribers</span>
                            <span class="font-semibold">{{ number_format($stats['total_subscribers']) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Success Rate</span>
                            <span class="font-semibold">{{ number_format(100 - $stats['failure_rate'], 1) }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Webhook Setup -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Webhook Setup</h3>
                    <button onclick="generateWebhookUrl()" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl font-medium transition-all duration-200 mb-3">
                        <i class="fas fa-link mr-2"></i>
                        Get Webhook URL
                    </button>
                    <div id="webhookInfo" class="hidden">
                        <div class="bg-gray-50 rounded-lg p-3 mb-3">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Webhook URL</label>
                            <input type="text" id="webhookUrl" readonly 
                                   class="w-full text-xs font-mono p-2 border rounded bg-white">
                        </div>
                        <div class="text-xs text-gray-600">
                            <strong>Events to enable:</strong>
                            <ul class="list-disc list-inside mt-1 space-y-1">
                                <li>invoice.payment_succeeded</li>
                                <li>invoice.payment_failed</li>
                                <li>customer.subscription.updated</li>
                                <li>customer.subscription.deleted</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-primary to-secondary text-white px-6 py-4 rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-save mr-2"></i>
                    Save Settings
                </button>
            </div>
        </div>
    </form>

</div>

<!-- Test Connection Modal -->
<div id="testModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
        <div class="text-center">
            <div id="testSpinner" class="hidden">
                <i class="fas fa-spinner fa-spin text-4xl text-primary mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-900">Testing Connection...</h3>
            </div>
            <div id="testResult" class="hidden">
                <div id="testIcon" class="text-4xl mb-4"></div>
                <h3 id="testTitle" class="text-lg font-semibold mb-2"></h3>
                <p id="testMessage" class="text-gray-600 mb-4"></p>
                <button onclick="closeTestModal()" 
                        class="bg-primary hover:bg-secondary text-white px-6 py-2 rounded-xl transition-colors duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function testConnection() {
    const modal = document.getElementById('testModal');
    const spinner = document.getElementById('testSpinner');
    const result = document.getElementById('testResult');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    spinner.classList.remove('hidden');
    result.classList.add('hidden');
    
    fetch('{{ route("admin.stripe.test-connection") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        spinner.classList.add('hidden');
        result.classList.remove('hidden');
        
        const icon = document.getElementById('testIcon');
        const title = document.getElementById('testTitle');
        const message = document.getElementById('testMessage');
        
        if (data.success) {
            icon.innerHTML = '<i class="fas fa-check-circle text-green-600"></i>';
            title.textContent = 'Connection Successful!';
            title.className = 'text-lg font-semibold mb-2 text-green-900';
            message.textContent = data.message + (data.account_id ? ` (Account: ${data.account_id})` : '');
        } else {
            icon.innerHTML = '<i class="fas fa-times-circle text-red-600"></i>';
            title.textContent = 'Connection Failed';
            title.className = 'text-lg font-semibold mb-2 text-red-900';
            message.textContent = data.message;
        }
    })
    .catch(error => {
        spinner.classList.add('hidden');
        result.classList.remove('hidden');
        
        document.getElementById('testIcon').innerHTML = '<i class="fas fa-times-circle text-red-600"></i>';
        document.getElementById('testTitle').textContent = 'Connection Failed';
        document.getElementById('testMessage').textContent = 'Network error occurred';
    });
}

function generateWebhookUrl() {
    fetch('{{ route("admin.stripe.webhook-url") }}', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('webhookUrl').value = data.webhook_url;
            document.getElementById('webhookInfo').classList.remove('hidden');
        }
    });
}

function closeTestModal() {
    const modal = document.getElementById('testModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Radio button styling
document.querySelectorAll('input[name="environment"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('input[name="environment"]').forEach(r => {
            const div = r.nextElementSibling;
            if (r.checked) {
                div.classList.add(r.value === 'sandbox' ? 'border-yellow-500' : 'border-green-500');
                div.classList.add(r.value === 'sandbox' ? 'bg-yellow-50' : 'bg-green-50');
                div.classList.remove('border-gray-300');
            } else {
                div.classList.remove('border-yellow-500', 'border-green-500', 'bg-yellow-50', 'bg-green-50');
                div.classList.add('border-gray-300');
            }
        });
    });
});
</script>
@endpush