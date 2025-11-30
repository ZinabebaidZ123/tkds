<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $table = 'team_members';

    protected $fillable = [
        'name',
        'position',
        'email',
        'phone',
        'bio',
        'image',
        'linkedin_url',
        'twitter_url',
        'facebook_url',
        'instagram_url',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Get all active team members ordered by sort_order
    public static function getActiveOrdered()
    {
        return self::active()
                   ->ordered()
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getImageUrl(): string
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        return asset('storage/' . $this->image);
    }

    public function getInitials(): string
    {
        $nameParts = explode(' ', $this->name);
        $initials = '';
        
        foreach (array_slice($nameParts, 0, 2) as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }
        
        return $initials ?: 'TM';
    }

    public function getSocialLinks(): array
    {
        $links = [];
        
        if ($this->linkedin_url) {
            $links['linkedin'] = [
                'url' => $this->linkedin_url,
                'icon' => 'fab fa-linkedin',
                'color' => 'text-blue-600'
            ];
        }
        
        if ($this->twitter_url) {
            $links['twitter'] = [
                'url' => $this->twitter_url,
                'icon' => 'fab fa-twitter',
                'color' => 'text-blue-400'
            ];
        }
        
        if ($this->facebook_url) {
            $links['facebook'] = [
                'url' => $this->facebook_url,
                'icon' => 'fab fa-facebook',
                'color' => 'text-blue-700'
            ];
        }
        
        if ($this->instagram_url) {
            $links['instagram'] = [
                'url' => $this->instagram_url,
                'icon' => 'fab fa-instagram',
                'color' => 'text-pink-600'
            ];
        }
        
        return $links;
    }

    public function getShortBio(): string
    {
        if (!$this->bio) {
            return '';
        }
        
        return strlen($this->bio) > 100 
            ? substr($this->bio, 0, 100) . '...' 
            : $this->bio;
    }
}