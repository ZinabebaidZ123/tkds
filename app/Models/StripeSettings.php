<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'environment',
        'live_public_key',
        'live_secret_key',
        'sandbox_public_key',
        'sandbox_secret_key',
        'webhook_secret',
        'default_currency',
        'collect_billing_address',
        'collect_shipping_address',
        'enable_tax_calculation',
        'status'
    ];

    protected $casts = [
        'collect_billing_address' => 'boolean',
        'collect_shipping_address' => 'boolean',
        'enable_tax_calculation' => 'boolean',
    ];

    // Hide sensitive keys
    protected $hidden = [
        'live_secret_key',
        'sandbox_secret_key',
        'webhook_secret'
    ];

    // Get the single instance - MINIMAL VERSION
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            // Create minimal default settings - let .env handle the values
            $settings = self::create([
                'environment' => env('STRIPE_ENV', 'sandbox'),
                'default_currency' => env('STRIPE_CURRENCY', 'USD'),
                'collect_billing_address' => true,
                'collect_shipping_address' => false,
                'enable_tax_calculation' => false,
                'status' => 'active'
            ]);
        }
        
        return $settings;
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isLive(): bool
    {
        return $this->environment === 'live';
    }

    public function isSandbox(): bool
    {
        return $this->environment === 'sandbox';
    }

    public function getPublicKey(): string
    {
        if ($this->isLive()) {
            return $this->live_public_key ?: env('STRIPE_LIVE_PUBLIC_KEY', '');
        }
        
        return $this->sandbox_public_key ?: env('STRIPE_SANDBOX_PUBLIC_KEY', '');
    }

    public function getSecretKey(): string
    {
        if ($this->isLive()) {
            return $this->live_secret_key ?: env('STRIPE_LIVE_SECRET_KEY', '');
        }
        
        return $this->sandbox_secret_key ?: env('STRIPE_SANDBOX_SECRET_KEY', '');
    }

    public function isConfigured(): bool
    {
        $publicKey = $this->getPublicKey();
        $secretKey = $this->getSecretKey();
        
        return !empty($publicKey) && !empty($secretKey);
    }

    public function getWebhookSecret(): string
    {
        return $this->webhook_secret ?: env('STRIPE_WEBHOOK_SECRET', '');
    }

    public function hasWebhookSecret(): bool
    {
        return !empty($this->webhook_secret) || !empty(env('STRIPE_WEBHOOK_SECRET'));
    }

    public function getSupportedCurrencies(): array
    {
        return [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'CAD' => 'C$',
            'AUD' => 'A$',
            'JPY' => '¥'
        ];
    }

    public function getCurrencySymbol(string $currency = null): string
    {
        $currency = $currency ?: $this->default_currency;
        $currencies = $this->getSupportedCurrencies();
        
        return $currencies[$currency] ?? $currency . ' ';
    }

    public function getEnvironmentBadge(): array
    {
        return match ($this->environment) {
            'live' => [
                'text' => 'Live',
                'class' => 'bg-green-100 text-green-800',
                'icon' => 'fas fa-check-circle'
            ],
            'sandbox' => [
                'text' => 'Sandbox',
                'class' => 'bg-yellow-100 text-yellow-800',
                'icon' => 'fas fa-flask'
            ],
            default => [
                'text' => 'Unknown',
                'class' => 'bg-gray-100 text-gray-800',
                'icon' => 'fas fa-question-circle'
            ]
            };
    }

    public function getStatusBadge(): array
    {
        return match ($this->status) {
            'active' => [
                'text' => 'Active',
                'class' => 'bg-green-100 text-green-800',
                'icon' => 'fas fa-check-circle'
            ],
            'inactive' => [
                'text' => 'Inactive',
                'class' => 'bg-red-100 text-red-800',
                'icon' => 'fas fa-times-circle'
            ],
            default => [
                'text' => 'Unknown',
                'class' => 'bg-gray-100 text-gray-800',
                'icon' => 'fas fa-question-circle'
            ]
            };
    }

    public function getConfigurationStatus(): array
    {
        $issues = [];
        
        $publicKey = $this->getPublicKey();
        $secretKey = $this->getSecretKey();
        
        if (empty($publicKey)) {
            $issues[] = 'Public key not configured for ' . $this->environment . ' environment';
        }
        
        if (empty($secretKey)) {
            $issues[] = 'Secret key not configured for ' . $this->environment . ' environment';
        }
        
        $webhookSecret = $this->webhook_secret ?: env('STRIPE_WEBHOOK_SECRET');
        if (empty($webhookSecret)) {
            $issues[] = 'Webhook secret not configured';
        }

        return [
            'is_configured' => empty($issues),
            'issues' => $issues,
            'status' => empty($issues) ? 'ready' : 'incomplete'
        ];
    }

    // Environment switching
    public function switchToLive(): bool
    {
        if (!$this->live_public_key || !$this->live_secret_key) {
            return false;
        }

        $this->update(['environment' => 'live']);
        return true;
    }

    public function switchToSandbox(): bool
    {
        $this->update(['environment' => 'sandbox']);
        return true;
    }
}