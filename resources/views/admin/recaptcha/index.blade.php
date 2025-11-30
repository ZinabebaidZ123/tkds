@extends('admin.layouts.app')

@section('title', 'reCAPTCHA Settings')
@section('page-title', 'reCAPTCHA Settings')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-900">reCAPTCHA Management</h2>
            <p class="text-gray-600 text-sm mt-1">Configure Google reCAPTCHA protection for your forms</p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="testConfiguration()" 
                    class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-flask mr-2"></i>
                Test Configuration
            </button>
            <button onclick="resetSettings()" 
                    class="px-4 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200">
                <i class="fas fa-undo mr-2"></i>
                Reset to Default
            </button>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-gradient-to-r from-red-50 to-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-red-800 font-medium">Please fix the following errors:</h3>
                    <ul class="mt-2 text-red-700 text-sm list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Form -->
    <form action="{{ route('admin.recaptcha.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Basic Configuration -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-key mr-2 text-blue-600"></i>
                        Basic Configuration
                    </h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Enable reCAPTCHA -->
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Enable reCAPTCHA</label>
                            <p class="text-xs text-gray-500">Turn on/off reCAPTCHA protection globally</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="enabled" value="1" 
                                   {{ $settings->enabled ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    
                    <!-- Site Key -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Key</label>
                        <input type="text" name="site_key" 
                               value="{{ old('site_key', $settings->site_key) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter your reCAPTCHA site key">
                        <p class="text-xs text-gray-500 mt-1">Get your keys from <a href="https://www.google.com/recaptcha/admin" target="_blank" class="text-blue-600 hover:underline">Google reCAPTCHA Console</a></p>
                    </div>
                    
                    <!-- Secret Key -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Secret Key</label>
                        <input type="password" name="secret_key" 
                               value="{{ old('secret_key', $settings->secret_key) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter your reCAPTCHA secret key">
                        <p class="text-xs text-gray-500 mt-1">Keep this key secure and never expose it publicly</p>
                    </div>
                    
                    <!-- Version -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">reCAPTCHA Version</label>
                        <select name="version" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="v2" {{ $settings->version === 'v2' ? 'selected' : '' }}>reCAPTCHA v2 (Checkbox)</option>
                            <option value="v3" {{ $settings->version === 'v3' ? 'selected' : '' }}>reCAPTCHA v3 (Invisible)</option>
                        </select>
                    </div>
                    
                    <!-- V3 Score Threshold -->
                    <div id="v3-settings" class="{{ $settings->version === 'v3' ? '' : 'hidden' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Score Threshold (v3 only)</label>
                        <input type="number" name="v3_score_threshold" 
                               value="{{ old('v3_score_threshold', $settings->v3_score_threshold) }}"
                               min="0.0" max="1.0" step="0.1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Lower scores indicate bots (0.0-1.0). Recommended: 0.5</p>
                    </div>
                </div>
            </div>

            <!-- Appearance Settings -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-palette mr-2 text-purple-600"></i>
                        Appearance Settings
                    </h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Theme -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Theme</label>
                        <select name="theme" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="light" {{ $settings->theme === 'light' ? 'selected' : '' }}>Light</option>
                            <option value="dark" {{ $settings->theme === 'dark' ? 'selected' : '' }}>Dark</option>
                        </select>
                    </div>
                    
                    <!-- Size -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                        <select name="size" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="normal" {{ $settings->size === 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="compact" {{ $settings->size === 'compact' ? 'selected' : '' }}>Compact</option>
                        </select>
                    </div>
                    
                    <!-- Language -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                        <select name="language" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="en" {{ $settings->language === 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ $settings->language === 'ar' ? 'selected' : '' }}>Arabic</option>
                            <option value="es" {{ $settings->language === 'es' ? 'selected' : '' }}>Spanish</option>
                            <option value="fr" {{ $settings->language === 'fr' ? 'selected' : '' }}>French</option>
                            <option value="de" {{ $settings->language === 'de' ? 'selected' : '' }}>German</option>
                        </select>
                    </div>
                    
                    <!-- Invisible Badge -->
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Hide reCAPTCHA Badge</label>
                            <p class="text-xs text-gray-500">Hide the reCAPTCHA badge (v3 only)</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="invisible_badge" value="1" 
                                   {{ $settings->invisible_badge ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                    
                    <!-- Custom Error Message -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Custom Error Message</label>
                        <textarea name="custom_error_message" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                  placeholder="Please verify that you are not a robot.">{{ old('custom_error_message', $settings->custom_error_message) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Form Protection Settings -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-green-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-shield-alt mr-2 text-green-600"></i>
                        Form Protection
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <!-- Login Form -->
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Login Form</label>
                            <p class="text-xs text-gray-500">Protect user login form</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="login_enabled" value="1" 
                                   {{ $settings->login_enabled ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-600"></div>
                        </label>
                    </div>
                    
                    <!-- Register Form -->
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Registration Form</label>
                            <p class="text-xs text-gray-500">Protect user registration form</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="register_enabled" value="1" 
                                   {{ $settings->register_enabled ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-600"></div>
                        </label>
                    </div>
                    
                    <!-- Contact Form -->
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Contact Form</label>
                            <p class="text-xs text-gray-500">Protect contact form submissions</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="contact_enabled" value="1" 
                                   {{ $settings->contact_enabled ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-600"></div>
                        </label>
                    </div>
                    
                    <!-- Comment Form -->
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Comment Form</label>
                            <p class="text-xs text-gray-500">Protect blog comment submissions</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="comment_enabled" value="1" 
                                   {{ $settings->comment_enabled ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Advanced Settings -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-orange-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-cogs mr-2 text-orange-600"></i>
                        Advanced Settings
                    </h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Excluded IPs -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Excluded IP Addresses</label>
                        <textarea name="excluded_ips" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                  placeholder="127.0.0.1&#10;192.168.1.1&#10;One IP per line">{{ old('excluded_ips', is_array($settings->excluded_ips) ? implode("\n", $settings->excluded_ips) : '') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">IP addresses that bypass reCAPTCHA verification (one per line)</p>
                    </div>
                    
                    <!-- Statistics -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Current Status</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Status:</span>
                                <span class="ml-2 px-2 py-1 rounded-full text-xs {{ $settings->isEnabled() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $settings->isEnabled() ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-500">Version:</span>
                                <span class="ml-2 font-medium">{{ strtoupper($settings->version) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Protected Forms:</span>
                                <span class="ml-2 font-medium">{{ collect([$settings->login_enabled, $settings->register_enabled, $settings->contact_enabled, $settings->comment_enabled])->filter()->count() }}/4</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Last Updated:</span>
                                <span class="ml-2 font-medium">{{ $settings->updated_at?->diffForHumans() ?? 'Never' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-4">
            <button type="button" onclick="window.location.reload()" 
                    class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-200">
                Cancel
            </button>
            <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Settings
            </button>
        </div>
    </form>
</div>

<!-- Test Modal -->
<div id="testModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Test reCAPTCHA Configuration</h3>
        
        <div id="recaptcha-test-container">
            <!-- reCAPTCHA will be rendered here -->
        </div>
        
        <div class="flex justify-end space-x-3 mt-6">
            <button onclick="closeTestModal()" 
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                Cancel
            </button>
            <button onclick="submitTest()" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Test
            </button>
        </div>
    </div>
</div>

<script>
// Show/hide v3 settings based on version selection
document.querySelector('select[name="version"]').addEventListener('change', function() {
    const v3Settings = document.getElementById('v3-settings');
    if (this.value === 'v3') {
        v3Settings.classList.remove('hidden');
    } else {
        v3Settings.classList.add('hidden');
    }
});

// Test configuration
function testConfiguration() {
    const siteKey = document.querySelector('input[name="site_key"]').value;
    const secretKey = document.querySelector('input[name="secret_key"]').value;
    
    if (!siteKey || !secretKey) {
        alert('Please enter both site key and secret key before testing.');
        return;
    }
    
    document.getElementById('testModal').classList.remove('hidden');
    document.getElementById('testModal').classList.add('flex');
    
    // Load reCAPTCHA for testing
    loadRecaptchaForTest(siteKey);
}

function closeTestModal() {
    document.getElementById('testModal').classList.add('hidden');
    document.getElementById('testModal').classList.remove('flex');
    
    // Clear test container
    document.getElementById('recaptcha-test-container').innerHTML = '';
}

function loadRecaptchaForTest(siteKey) {
    const container = document.getElementById('recaptcha-test-container');
    container.innerHTML = `<div class="g-recaptcha" data-sitekey="${siteKey}"></div>`;
    
    // Load reCAPTCHA script if not already loaded
    if (!window.grecaptcha) {
        const script = document.createElement('script');
        script.src = 'https://www.google.com/recaptcha/api.js';
        script.onload = function() {
            grecaptcha.render(container.querySelector('.g-recaptcha'));
        };
        document.head.appendChild(script);
    } else {
        grecaptcha.render(container.querySelector('.g-recaptcha'));
    }
}

function submitTest() {
    const response = grecaptcha.getResponse();
    const siteKey = document.querySelector('input[name="site_key"]').value;
    const secretKey = document.querySelector('input[name="secret_key"]').value;
    
    if (!response) {
        alert('Please complete the reCAPTCHA challenge.');
        return;
    }
    
    // Send test request
    fetch('{{ route("admin.recaptcha.test") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            site_key: siteKey,
            secret_key: secretKey,
            test_response: response
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.message);
        }
        closeTestModal();
    })
    .catch(error => {
        alert('Error testing configuration: ' + error.message);
        closeTestModal();
    });
}

// Reset settings
function resetSettings() {
    if (confirm('Are you sure you want to reset all reCAPTCHA settings to default values? This action cannot be undone.')) {
        fetch('{{ route("admin.recaptcha.reset") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Failed to reset settings.');
            }
        })
        .catch(error => {
            alert('Error resetting settings: ' + error.message);
        });
    }
}
</script>

@endsection