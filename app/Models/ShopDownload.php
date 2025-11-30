<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'file_name',
        'file_path',
        'file_size',
        'download_token',
        'downloads_remaining',
        'expires_at',
        'last_downloaded_at'
    ];

    protected $casts = [
        'file_size' => 'integer',
        'downloads_remaining' => 'integer',
        'expires_at' => 'datetime',
        'last_downloaded_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        })->where(function($q) {
            $q->where('downloads_remaining', '>', 0)
              ->orWhere('downloads_remaining', -1);
        });
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    public function scopeNoDownloadsLeft($query)
    {
        return $query->where('downloads_remaining', 0);
    }

    // Methods
    public function isActive(): bool
    {
        return $this->canDownload();
    }

    public function canDownload(): bool
    {
        // Check if expired
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // Check download limit (-1 means unlimited)
        if ($this->downloads_remaining !== -1 && $this->downloads_remaining <= 0) {
            return false;
        }

        return true;
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function hasDownloadsLeft(): bool
    {
        return $this->downloads_remaining === -1 || $this->downloads_remaining > 0;
    }

    public function getFormattedFileSize(): string
    {
        if (!$this->file_size) {
            return 'Unknown size';
        }

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

public function getDownloadUrl(): string
    {
        return route('shop.download', $this->download_token);
    }

    public function getExpiryStatus(): string
    {
        if (!$this->expires_at) {
            return 'Never expires';
        }

        if ($this->isExpired()) {
            return 'Expired on ' . $this->expires_at->format('M j, Y');
        }

        $diff = now()->diffInDays($this->expires_at, false);
        
        if ($diff <= 0) {
            return 'Expires today';
        } elseif ($diff <= 7) {
            return 'Expires in ' . $diff . ' days';
        } else {
            return 'Expires on ' . $this->expires_at->format('M j, Y');
        }
    }

    public function getDownloadsStatus(): string
    {
        if ($this->downloads_remaining === -1) {
            return 'Unlimited downloads';
        }

        if ($this->downloads_remaining <= 0) {
            return 'No downloads remaining';
        }

        return $this->downloads_remaining . ' downloads remaining';
    }

    public function recordDownload(): bool
    {
        if (!$this->canDownload()) {
            return false;
        }

        // Update download count only if not unlimited
        if ($this->downloads_remaining > 0) {
            $this->decrement('downloads_remaining');
        }

        // Update last downloaded time
        $this->update(['last_downloaded_at' => now()]);

        return true;
    }

    public function getStatusBadge(): array
    {
        if (!$this->canDownload()) {
            if ($this->isExpired()) {
                return [
                    'text' => 'Expired',
                    'class' => 'bg-red-500/20 text-red-400',
                    'icon' => 'fas fa-clock'
                ];
            }

            if (!$this->hasDownloadsLeft()) {
                return [
                    'text' => 'No Downloads Left',
                    'class' => 'bg-orange-500/20 text-orange-400',
                    'icon' => 'fas fa-ban'
                ];
            }
        }

        if ($this->expires_at && $this->expires_at->diffInDays() <= 7) {
            return [
                'text' => 'Expires Soon',
                'class' => 'bg-yellow-500/20 text-yellow-400',
                'icon' => 'fas fa-exclamation-triangle'
            ];
        }

        return [
            'text' => 'Available',
            'class' => 'bg-green-500/20 text-green-400',
            'icon' => 'fas fa-download'
        ];
    }

    // Static Methods
    public static function findByToken(string $token): ?self
    {
        return self::where('download_token', $token)->first();
    }

    public static function cleanupExpired(): int
    {
        return self::expired()->delete();
    }
}