<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AiSettings extends Model
{
    use HasFactory;

    protected $table = 'ai_settings';

    protected $fillable = [
        'tkds_ai_token',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    /**
     * Get singleton settings instance
     */
    public static function getSettings(): self
    {
        return Cache::remember('ai_settings', 3600, function () {
            $settings = self::first();

            if (!$settings) {
                $settings = self::create([
                    'tkds_ai_token' => null,
                    'enabled' => false,
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
        Cache::forget('ai_settings');
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
     * Check if AI is enabled
     */
    public function isEnabled(): bool
    {
        return $this->enabled && !empty($this->tkds_ai_token);
    }
}
