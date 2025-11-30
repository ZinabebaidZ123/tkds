<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ReCaptchaSettings extends Model
{
    use HasFactory;

    protected $table = 'recaptcha_settings';

    protected $fillable = [
        'site_key',
        'secret_key',
        'enabled',
        'login_enabled',
        'register_enabled',
        'contact_enabled',
        'comment_enabled',
        'version',
        'v3_score_threshold',
        'theme',
        'size',
        'language',
        'custom_error_message',
        'invisible_badge',
        'excluded_ips'
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'login_enabled' => 'boolean',
        'register_enabled' => 'boolean',
        'contact_enabled' => 'boolean',
        'comment_enabled' => 'boolean',
        'v3_score_threshold' => 'decimal:1',
        'invisible_badge' => 'boolean',
        'excluded_ips' => 'array'
    ];

    /**
     * Get singleton settings instance
     */
    public static function getSettings(): self
    {
        return Cache::remember('recaptcha_settings', 3600, function () {
            $settings = self::first();
            
            if (!$settings) {
                $settings = self::create([
                    'site_key' => '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI',
                    'secret_key' => '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe',
                    'enabled' => false,
                    'login_enabled' => true,
                    'register_enabled' => true,
                    'contact_enabled' => true,
                    'comment_enabled' => false,
                    'version' => 'v2',
                    'v3_score_threshold' => 0.5,
                    'theme' => 'light',
                    'size' => 'normal',
                    'language' => 'en',
                    'custom_error_message' => 'Please verify that you are not a robot.',
                    'invisible_badge' => false,
                    'excluded_ips' => ['127.0.0.1', '::1']
                ]);
            }
            
            return $settings;
        });
    }

    /**
     * Clear settings cache
     */
    public static function clearCache(): void
    {
        Cache::forget('recaptcha_settings');
    }

    /**
     * Update settings and clear cache
     */
    public function updateSettings(array $data): bool
    {
        $result = $this->update($data);
        self::clearCache();
        return $result;
    }

    /**
     * Check if reCAPTCHA is enabled
     */
    public function isEnabled(): bool
    {
        return $this->enabled && !empty($this->site_key) && !empty($this->secret_key);
    }

    /**
     * Check if reCAPTCHA is enabled for specific form
     */
    public function isEnabledFor(string $form): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return match($form) {
            'login' => $this->login_enabled,
            'register' => $this->register_enabled,
            'contact' => $this->contact_enabled,
            'comment' => $this->comment_enabled,
            default => false
        };
    }

    /**
     * Check if IP is excluded
     */
    public function isIpExcluded(string $ip): bool
    {
        if (!$this->excluded_ips) {
            return false;
        }

        return in_array($ip, $this->excluded_ips);
    }

    /**
     * Get reCAPTCHA script URL
     */
    public function getScriptUrl(): string
    {
        $params = [
            'render' => $this->version === 'v3' ? $this->site_key : 'explicit',
            'hl' => $this->language
        ];

        return 'https://www.google.com/recaptcha/api.js?' . http_build_query($params);
    }

    /**
     * Get frontend config
     */
    public function getFrontendConfig(): array
    {
        return [
            'enabled' => $this->isEnabled(),
            'site_key' => $this->site_key,
            'version' => $this->version,
            'theme' => $this->theme,
            'size' => $this->size,
            'language' => $this->language,
            'invisible_badge' => $this->invisible_badge,
            'error_message' => $this->custom_error_message ?: 'Please verify that you are not a robot.',
            'forms' => [
                'login' => $this->isEnabledFor('login'),
                'register' => $this->isEnabledFor('register'),
                'contact' => $this->isEnabledFor('contact'),
                'comment' => $this->isEnabledFor('comment')
            ]
        ];
    }
}