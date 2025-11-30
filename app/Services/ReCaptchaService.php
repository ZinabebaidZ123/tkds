<?php

namespace App\Services;

use App\Models\ReCaptchaSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReCaptchaService
{
    private ReCaptchaSettings $settings;

    public function __construct()
    {
        $this->settings = ReCaptchaSettings::getSettings();
    }

    /**
     * Verify reCAPTCHA response
     */
    public function verify(string $response, string $ip = null): bool
    {
        // Skip verification if reCAPTCHA is disabled
        if (!$this->settings->isEnabled()) {
            return true;
        }

        // Skip verification for excluded IPs
        if ($ip && $this->settings->isIpExcluded($ip)) {
            return true;
        }

        // Skip if no response provided
        if (empty($response)) {
            return false;
        }

        try {
            $httpResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $this->settings->secret_key,
                'response' => $response,
                'remoteip' => $ip
            ]);

            $result = $httpResponse->json();

            // Log verification attempt
            Log::info('reCAPTCHA verification', [
                'success' => $result['success'] ?? false,
                'score' => $result['score'] ?? null,
                'action' => $result['action'] ?? null,
                'error_codes' => $result['error-codes'] ?? [],
                'ip' => $ip
            ]);

            // Check basic success
            if (!($result['success'] ?? false)) {
                return false;
            }

            // For v3, check score
            if ($this->settings->version === 'v3') {
                $score = $result['score'] ?? 0;
                return $score >= $this->settings->v3_score_threshold;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification failed', [
                'error' => $e->getMessage(),
                'ip' => $ip
            ]);
            
            // In case of error, allow request to proceed (fail open)
            return true;
        }
    }

    /**
     * Verify reCAPTCHA for specific form
     */
    public function verifyForForm(string $form, Request $request): bool
    {
        // Check if reCAPTCHA is enabled for this form
        if (!$this->settings->isEnabledFor($form)) {
            return true;
        }

        $response = $request->input('g-recaptcha-response');
        $ip = $request->ip();

        return $this->verify($response, $ip);
    }

    /**
     * Get validation rule for reCAPTCHA
     */
    public function getValidationRule(string $form): array
    {
        if (!$this->settings->isEnabledFor($form)) {
            return [];
        }

        return [
            'g-recaptcha-response' => [
                'required',
                function ($attribute, $value, $fail) use ($form) {
                    if (!$this->verify($value, request()->ip())) {
                        $fail($this->settings->custom_error_message ?: 'Please verify that you are not a robot.');
                    }
                }
            ]
        ];
    }

    /**
     * Get reCAPTCHA settings
     */
    public function getSettings(): ReCaptchaSettings
    {
        return $this->settings;
    }

    /**
     * Check if reCAPTCHA should be shown
     */
    public function shouldShow(string $form, Request $request = null): bool
    {
        if (!$this->settings->isEnabledFor($form)) {
            return false;
        }

        // Check IP exclusion
        if ($request && $this->settings->isIpExcluded($request->ip())) {
            return false;
        }

        return true;
    }

    /**
     * Generate reCAPTCHA HTML
     */
    public function generateHtml(string $form, array $customAttributes = []): string
    {
        if (!$this->shouldShow($form, request())) {
            return '';
        }

        $defaultAttributes = [
            'class' => 'g-recaptcha',
            'data-sitekey' => $this->settings->site_key,
            'data-theme' => $this->settings->theme,
            'data-size' => $this->settings->size
        ];

        if ($this->settings->version === 'v3') {
            $defaultAttributes['data-callback'] = 'onRecaptchaCallback';
            $defaultAttributes['data-action'] = $form;
        }

        $attributes = array_merge($defaultAttributes, $customAttributes);
        
        $attributeString = '';
        foreach ($attributes as $key => $value) {
            $attributeString .= sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }

        return sprintf('<div%s></div>', $attributeString);
    }

    /**
     * Get JavaScript initialization code
     */
    public function getJavaScript(string $form): string
    {
        if (!$this->shouldShow($form, request())) {
            return '';
        }

        $config = $this->settings->getFrontendConfig();
        
        if ($config['version'] === 'v3') {
            return $this->getV3JavaScript($form, $config);
        }

        return $this->getV2JavaScript($form, $config);
    }

    /**
     * Get v2 JavaScript
     */
    private function getV2JavaScript(string $form, array $config): string
    {
        return "
        window.recaptchaConfig = " . json_encode($config) . ";
        
        var onloadCallback = function() {
            if (typeof grecaptcha !== 'undefined') {
                var recaptchaElements = document.querySelectorAll('.g-recaptcha');
                recaptchaElements.forEach(function(element) {
                    if (!element.hasAttribute('data-rendered')) {
                        grecaptcha.render(element, {
                            'sitekey': '" . $config['site_key'] . "',
                            'theme': '" . $config['theme'] . "',
                            'size': '" . $config['size'] . "'
                        });
                        element.setAttribute('data-rendered', 'true');
                    }
                });
            }
        };";
    }

    /**
     * Get v3 JavaScript
     */
    private function getV3JavaScript(string $form, array $config): string
    {
        return "
        window.recaptchaConfig = " . json_encode($config) . ";
        
        function executeRecaptcha(action) {
            return new Promise(function(resolve, reject) {
                if (typeof grecaptcha === 'undefined') {
                    resolve('');
                    return;
                }
                
                grecaptcha.ready(function() {
                    grecaptcha.execute('" . $config['site_key'] . "', {action: action})
                        .then(function(token) {
                            resolve(token);
                        })
                        .catch(function(error) {
                            console.error('reCAPTCHA error:', error);
                            resolve('');
                        });
                });
            });
        }
        
        // Auto-execute for form submission
        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('form');
            forms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    var recaptchaInput = form.querySelector('input[name=\"g-recaptcha-response\"]');
                    if (recaptchaInput && !recaptchaInput.value) {
                        e.preventDefault();
                        executeRecaptcha('$form').then(function(token) {
                            recaptchaInput.value = token;
                            form.submit();
                        });
                    }
                });
            });
        });";
    }
}