<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogAuthor extends Model
{
    use HasFactory;

    protected $table = 'blog_authors';

    protected $fillable = [
        'admin_user_id',
        'name',
        'slug',
        'email',
        'bio',
        'avatar',
        'social_links',
        'meta_title',
        'meta_description',
        'status'
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    // Relationships
    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class);
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    public function activePosts()
    {
        return $this->hasMany(BlogPost::class, 'author_id')->published();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getAvatarUrl(): string
    {
        if ($this->avatar && filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }
        
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=fff&background=C53030';
    }

    public function getPostsCount(): int
    {
        return $this->activePosts()->count();
    }

    public function getSocialLinks(): array
    {
        return $this->social_links ?? [];
    }

    public function getRouteKeyName()
    {
         return 'id';
    }
}

