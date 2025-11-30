<?php

// File: app/Models/ContactSubmission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $table = 'contact_submissions';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'service_interest',
        'budget',
        'message',
        'ip_address',
        'user_agent',
        'status',
        'admin_notes',
        'replied_at',
        'replied_by'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    // Relationships
    public function repliedByAdmin()
    {
        return $this->belongsTo(AdminUser::class, 'replied_by');
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('message', 'like', "%{$search}%")
              ->orWhere('service_interest', 'like', "%{$search}%");
        });
    }

    // Methods
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'unread' => 'bg-red-100 text-red-800',
            'read' => 'bg-yellow-100 text-yellow-800',
            'replied' => 'bg-green-100 text-green-800',
            'archived' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusIcon(): string
    {
        return match($this->status) {
            'unread' => 'fas fa-envelope',
            'read' => 'fas fa-envelope-open',
            'replied' => 'fas fa-reply',
            'archived' => 'fas fa-archive',
            default => 'fas fa-envelope'
        };
    }

    public function isUnread(): bool
    {
        return $this->status === 'unread';
    }

    public function isRead(): bool
    {
        return $this->status === 'read';
    }

    public function isReplied(): bool
    {
        return $this->status === 'replied';
    }

    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }

    public function markAsRead($adminId = null): void
    {
        if ($this->status === 'unread') {
            $this->update([
                'status' => 'read',
                'replied_by' => $adminId
            ]);
        }
    }

    public function markAsReplied($adminId = null): void
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now(),
            'replied_by' => $adminId
        ]);
    }

    public function archive(): void
    {
        $this->update(['status' => 'archived']);
    }

    public function getServiceInterestLabel(): string
    {
        $services = [
            'live-streaming' => 'Live Streaming',
            'cloud-production' => 'Cloud Production',
            'ott-platform' => 'OTT Platform',
            'sports-broadcasting' => 'Sports Broadcasting',
            'radio-streaming' => 'Radio Streaming',
            'custom-solution' => 'Custom Solution'
        ];

        return $services[$this->service_interest] ?? ucwords(str_replace('-', ' ', $this->service_interest));
    }

    public function getBudgetLabel(): string
    {
        $budgets = [
            'under-500' => 'Under $500',
            '500-1000' => '$500 - $1,000',
            '1000-5000' => '$1,000 - $5,000',
            '5000-10000' => '$5,000 - $10,000',
            'over-10000' => 'Over $10,000'
        ];

        return $budgets[$this->budget] ?? ucwords(str_replace('-', ' ', $this->budget));
    }

    public function getPriorityScore(): int
    {
        $score = 0;
        
        // Budget-based priority
        $score += match($this->budget) {
            'over-10000' => 50,
            '5000-10000' => 40,
            '1000-5000' => 30,
            '500-1000' => 20,
            'under-500' => 10,
            default => 15
        };

        // Service interest priority
        $score += match($this->service_interest) {
            'ott-platform' => 30,
            'sports-broadcasting' => 25,
            'live-streaming' => 20,
            'cloud-production' => 20,
            'custom-solution' => 15,
            default => 10
        };

        // Recency boost
        if ($this->created_at->diffInHours() <= 24) {
            $score += 20;
        } elseif ($this->created_at->diffInDays() <= 3) {
            $score += 10;
        }

        return $score;
    }

    public function getPriorityLabel(): string
    {
        $score = $this->getPriorityScore();
        
        if ($score >= 80) return 'High';
        if ($score >= 50) return 'Medium';
        return 'Low';
    }

    public function getPriorityClass(): string
    {
        $score = $this->getPriorityScore();
        
        if ($score >= 80) return 'bg-red-100 text-red-800';
        if ($score >= 50) return 'bg-yellow-100 text-yellow-800';
        return 'bg-green-100 text-green-800';
    }
}