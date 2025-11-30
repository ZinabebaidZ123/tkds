<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'website',
        'location',
        'company',
        'job_title',
        'social_links',
        'preferences',
        'timezone',
        'language'
    ];

    protected $casts = [
        'social_links' => 'array',
        'preferences' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Methods
    public function getSocialLinks(): array
    {
        return $this->social_links ?? [];
    }

    public function getPreferences(): array
    {
        return $this->preferences ?? [];
    }

    public function setSocialLink(string $platform, string $url): void
    {
        $links = $this->getSocialLinks();
        $links[$platform] = $url;
        $this->social_links = $links;
        $this->save();
    }

    public function setPreference(string $key, $value): void
    {
        $preferences = $this->getPreferences();
        $preferences[$key] = $value;
        $this->preferences = $preferences;
        $this->save();
    }
}
