<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Newsletter extends Model
{
    use HasFactory;

    protected $table = 'newsletters';

    protected $fillable = [
        'email',
        'name',
        'status',
        'source',
        'ip_address',
        'user_agent',
        'tags',
        'metadata',
        'verified_at',
        'unsubscribed_at',
        'last_sent_at',
        'bounce_count'
    ];

    protected $casts = [
        'tags' => 'array',
        'metadata' => 'array',
        'verified_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
        'last_sent_at' => 'datetime',
        'bounce_count' => 'integer',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_UNSUBSCRIBED = 'unsubscribed';
    const STATUS_BOUNCED = 'bounced';
    const STATUS_BLOCKED = 'blocked';

    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_UNSUBSCRIBED => 'Unsubscribed',
        self::STATUS_BOUNCED => 'Bounced',
        self::STATUS_BLOCKED => 'Blocked'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeUnsubscribed($query)
    {
        return $query->where('status', self::STATUS_UNSUBSCRIBED);
    }

    public function scopeBounced($query)
    {
        return $query->where('status', self::STATUS_BOUNCED);
    }

    public function scopeBlocked($query)
    {
        return $query->where('status', self::STATUS_BLOCKED);
    }

    public function scopeBySource($query, $source)
    {
        return $query->where('source', $source);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isUnsubscribed(): bool
    {
        return $this->status === self::STATUS_UNSUBSCRIBED;
    }

    public function isBounced(): bool
    {
        return $this->status === self::STATUS_BOUNCED;
    }

    public function isBlocked(): bool
    {
        return $this->status === self::STATUS_BLOCKED;
    }

    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    public function getStatusBadge(): array
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => [
                'text' => 'Active',
                'class' => 'bg-green-100 text-green-800',
                'icon' => 'fas fa-check-circle'
            ],
            self::STATUS_UNSUBSCRIBED => [
                'text' => 'Unsubscribed',
                'class' => 'bg-gray-100 text-gray-800',
                'icon' => 'fas fa-times-circle'
            ],
            self::STATUS_BOUNCED => [
                'text' => 'Bounced',
                'class' => 'bg-red-100 text-red-800',
                'icon' => 'fas fa-exclamation-triangle'
            ],
            self::STATUS_BLOCKED => [
                'text' => 'Blocked',
                'class' => 'bg-red-100 text-red-800',
                'icon' => 'fas fa-ban'
            ],
            default => [
                'text' => 'Unknown',
                'class' => 'bg-gray-100 text-gray-800',
                'icon' => 'fas fa-question-circle'
            ]
        };
    }

    public function getFormattedCreatedAt(): string
    {
        return $this->created_at->format('M j, Y g:i A');
    }

    public function getDaysAgo(): int
    {
        return $this->created_at->diffInDays(now());
    }

    public function getTags(): array
    {
        return $this->tags ?: [];
    }

    public function getMetadata(): array
    {
        return $this->metadata ?: [];
    }

    public function addTag(string $tag): void
    {
        $tags = $this->getTags();
        if (!in_array($tag, $tags)) {
            $tags[] = $tag;
            $this->tags = $tags;
            $this->save();
        }
    }

    public function removeTag(string $tag): void
    {
        $tags = $this->getTags();
        $this->tags = array_values(array_filter($tags, fn($t) => $t !== $tag));
        $this->save();
    }

    public function unsubscribe(): bool
    {
        return $this->update([
            'status' => self::STATUS_UNSUBSCRIBED,
            'unsubscribed_at' => now()
        ]);
    }

    public function resubscribe(): bool
    {
        return $this->update([
            'status' => self::STATUS_ACTIVE,
            'unsubscribed_at' => null
        ]);
    }

    public function markAsVerified(): bool
    {
        return $this->update([
            'verified_at' => now()
        ]);
    }

    public function incrementBounceCount(): bool
    {
        $this->increment('bounce_count');
        
        if ($this->bounce_count >= 5) {
            $this->update(['status' => self::STATUS_BOUNCED]);
        }
        
        return true;
    }

    // Static methods
    public static function getStats(): array
    {
        return [
            'total' => self::count(),
            'active' => self::active()->count(),
            'unsubscribed' => self::unsubscribed()->count(),
            'bounced' => self::bounced()->count(),
            'blocked' => self::blocked()->count(),
            'recent' => self::recent(7)->count(),
            'verified' => self::verified()->count()
        ];
    }

    public static function getGrowthData(int $days = 30): array
    {
        $data = [];
        for ($i = $days; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = self::whereDate('created_at', $date)->count();
            $data[] = [
                'date' => $date->format('M j'),
                'count' => $count
            ];
        }
        return $data;
    }

    public static function getSourceStats(): array
    {
        return self::selectRaw('source, COUNT(*) as count')
            ->groupBy('source')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'source')
            ->toArray();
    }
}