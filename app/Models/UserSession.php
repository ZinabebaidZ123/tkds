<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'location_country',
        'location_city',
        'login_at',
        'logout_at',
        'is_active'
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('login_at', '>=', now()->subDays($days));
    }

    // Methods
    public function markAsLoggedOut(): void
    {
        $this->update([
            'logout_at' => now(),
            'is_active' => false
        ]);
    }

    public function getDuration(): string
    {
        if (!$this->logout_at) {
            return 'Still active';
        }

        $diff = $this->logout_at->diffInMinutes($this->login_at);
        
        if ($diff < 60) {
            return $diff . ' minutes';
        }
        
        return round($diff / 60, 1) . ' hours';
    }

    public function getDeviceInfo(): string
    {
        $info = [];
        
        if ($this->browser) {
            $info[] = $this->browser;
        }
        
        if ($this->platform) {
            $info[] = $this->platform;
        }
        
        if ($this->device_type) {
            $info[] = ucfirst($this->device_type);
        }
        
        return implode(' • ', $info) ?: 'Unknown Device';
    }

    public function getLocationInfo(): string
    {
        $location = [];
        
        if ($this->location_city) {
            $location[] = $this->location_city;
        }
        
        if ($this->location_country) {
            $location[] = $this->location_country;
        }
        
        return implode(', ', $location) ?: $this->ip_address;
    }
}