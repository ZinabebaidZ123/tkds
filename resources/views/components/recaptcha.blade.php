{{-- resources/views/components/recaptcha.blade.php --}}

@php
try {
    $recaptchaService = app(\App\Services\ReCaptchaService::class);
    $recaptchaSettings = $recaptchaService->getSettings();
    $shouldShowRecaptcha = $recaptchaService->shouldShow($form ?? 'default', request());
    $recaptchaConfig = $recaptchaSettings->getFrontendConfig();
} catch (\Exception $e) {
    $shouldShowRecaptcha = false;
    $recaptchaConfig = [];
    \Log::error('reCAPTCHA Component Error: ' . $e->getMessage());
}
@endphp

@if($shouldShowRecaptcha)
<!-- reCAPTCHA Section -->
<div class="mb-6">
    <label class="block text-sm font-semibold text-white mb-2">
        Security Verification
    </label>
    
    <!-- Hidden input for reCAPTCHA response -->
    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-{{ $form ?? 'default' }}" />
    
    @if($recaptchaConfig['version'] === 'v2')
        <!-- reCAPTCHA v2 Widget -->
        <div class="flex justify-center">
            <div id="recaptcha-container-{{ $form ?? 'default' }}" 
                 class="bg-white/10 border border-white/20 rounded-lg p-4 min-h-[78px] flex items-center justify-center">
                <div class="text-gray-400 text-sm">Loading reCAPTCHA...</div>
            </div>
        </div>
    @else
        <!-- reCAPTCHA v3 Notice -->
        <div class="bg-white/10 border border-white/20 rounded-lg p-3">
            <p class="text-xs text-gray-300 text-center">
                <i class="fas fa-shield-alt mr-1"></i>
                This site is protected by reCAPTCHA and the Google 
                <a href="https://policies.google.com/privacy" target="_blank" class="text-blue-400 hover:underline">Privacy Policy</a> and 
                <a href="https://policies.google.com/terms" target="_blank" class="text-blue-400 hover:underline">Terms of Service</a> apply.
            </p>
        </div>
    @endif
    
    <!-- Error message placeholder -->
    @error('g-recaptcha-response')
        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
    @enderror
</div>

<!-- Load reCAPTCHA Script -->
@once('recaptcha-script')
    @if($recaptchaConfig['version'] === 'v2')
        <script src="https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoadCallback&render=explicit&hl={{ $recaptchaConfig['language'] ?? 'en' }}" async defer></script>
    @else
        <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaConfig['site_key'] }}&hl={{ $recaptchaConfig['language'] ?? 'en' }}" async defer></script>
    @endif
@endonce

@if($recaptchaConfig['version'] === 'v2')
    <!-- v2 JavaScript -->
    @push('scripts')
    <script>
    // Global variables for reCAPTCHA
    window.recaptchaWidgets = window.recaptchaWidgets || {};
    window.recaptchaCallbacks = window.recaptchaCallbacks || [];
    
    // Add this form's callback to the queue
    window.recaptchaCallbacks.push(function() {
        const container = document.getElementById('recaptcha-container-{{ $form ?? 'default' }}');
        if (container && typeof grecaptcha !== 'undefined') {
            // Clear loading message
            container.innerHTML = '';
            
            try {
                window.recaptchaWidgets['{{ $form ?? 'default' }}'] = grecaptcha.render('recaptcha-container-{{ $form ?? 'default' }}', {
                    'sitekey': '{{ $recaptchaConfig['site_key'] }}',
                    'theme': '{{ $recaptchaConfig['theme'] }}',
                    'size': '{{ $recaptchaConfig['size'] }}',
                    'callback': function(response) {
                        console.log('reCAPTCHA completed for {{ $form ?? 'default' }}:', response);
                        document.getElementById('g-recaptcha-response-{{ $form ?? 'default' }}').value = response;
                    },
                    'expired-callback': function() {
                        console.log('reCAPTCHA expired for {{ $form ?? 'default' }}');
                        document.getElementById('g-recaptcha-response-{{ $form ?? 'default' }}').value = '';
                    },
                    'error-callback': function() {
                        console.log('reCAPTCHA error for {{ $form ?? 'default' }}');
                        document.getElementById('g-recaptcha-response-{{ $form ?? 'default' }}').value = '';
                    }
                });
                
                console.log('reCAPTCHA widget created for {{ $form ?? 'default' }} with ID:', window.recaptchaWidgets['{{ $form ?? 'default' }}']);
            } catch (error) {
                console.error('reCAPTCHA render error for {{ $form ?? 'default' }}:', error);
                container.innerHTML = '<div class="text-red-400 text-sm">reCAPTCHA failed to load</div>';
            }
        }
    });
    
    // Global callback function (called when reCAPTCHA loads)
    window.onRecaptchaLoadCallback = function() {
        console.log('reCAPTCHA library loaded, processing callbacks');
        if (window.recaptchaCallbacks && window.recaptchaCallbacks.length > 0) {
            window.recaptchaCallbacks.forEach(function(callback) {
                try {
                    callback();
                } catch (error) {
                    console.error('reCAPTCHA callback error:', error);
                }
            });
            // Clear callbacks after execution
            window.recaptchaCallbacks = [];
        }
    };
    </script>
    @endpush
@else
    <!-- v3 JavaScript -->
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find forms that contain this reCAPTCHA
        const forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            const responseInput = form.querySelector('#g-recaptcha-response-{{ $form ?? 'default' }}');
            if (responseInput) {
                form.addEventListener('submit', function(e) {
                    if (!responseInput.value) {
                        e.preventDefault();
                        
                        if (typeof grecaptcha !== 'undefined') {
                            grecaptcha.ready(function() {
                                grecaptcha.execute('{{ $recaptchaConfig['site_key'] }}', {action: '{{ $form ?? 'default' }}'})
                                    .then(function(token) {
                                        console.log('reCAPTCHA v3 token for {{ $form ?? 'default' }}:', token);
                                        responseInput.value = token;
                                        form.submit();
                                    })
                                    .catch(function(error) {
                                        console.error('reCAPTCHA v3 error for {{ $form ?? 'default' }}:', error);
                                        form.submit();
                                    });
                            });
                        } else {
                            console.warn('reCAPTCHA not loaded for {{ $form ?? 'default' }}, submitting form anyway');
                            form.submit();
                        }
                    }
                });
            }
        });
    });
    </script>
    @endpush
@endif

@if($recaptchaConfig['version'] === 'v3' && ($recaptchaConfig['invisible_badge'] ?? false))
    @push('styles')
    <style>
        .grecaptcha-badge {
            visibility: hidden !important;
        }
    </style>
    @endpush
@endif

@endif