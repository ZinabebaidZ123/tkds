<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $table = 'blog_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'meta_title',
        'meta_description',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    // Relationships
    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }

    public function activePosts()
    {
        return $this->hasMany(BlogPost::class, 'category_id')->published();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getPostsCount(): int
    {
        return $this->activePosts()->count();
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}