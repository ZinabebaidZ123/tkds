<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ShopSetting extends Model
{
    use HasFactory;

    protected $table = 'shop_settings';

    protected $fillable = [
        'key',
        'value',
        'type',
        'group'
    ];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $cacheKey = 'shop_setting_' . str_replace('.', '_', $key);
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }

            if ($setting->value === 'true') return true;
            if ($setting->value === 'false') return false;
            
            if (is_numeric($setting->value)) {
                return (float) $setting->value;
            }

            return $setting->value;
        });
    }

    /**
     * Set setting value
     */
    public static function set($key, $value)
    {
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'updated_at' => now()]
        );

        $cacheKey = 'shop_setting_' . str_replace('.', '_', $key);
        Cache::forget($cacheKey);

        return $setting;
    }

    /**
     * Get all shop settings as array
     */
    public static function getAllShopSettings()
    {
        return Cache::remember('all_shop_settings', 3600, function () {
            return self::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear all shop settings cache
     */
    public static function clearCache()
    {
        Cache::forget('all_shop_settings');
        
        $settings = self::all();
        foreach ($settings as $setting) {
            $cacheKey = 'shop_setting_' . str_replace('.', '_', $setting->key);
            Cache::forget($cacheKey);
        }
    }
}