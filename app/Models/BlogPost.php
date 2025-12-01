<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class BlogPost extends Model
{
    use HasFactory;

    protected $table = 'blog_posts';
    
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'gallery',
        'category_id',
        'author_id',
        'status',
        'is_featured',
        'is_trending',
        'published_at',
        'scheduled_at',
        'reading_time',
        'view_count',
        'like_count',
        'share_count',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'title_part1',
        'title_part2',

        'subtitle'
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'reading_time' => 'integer',
        'view_count' => 'integer',
        'like_count' => 'integer',
        'share_count' => 'integer',
    ];

    public function getRouteKeyName()
    {
        if (request()->is('admin/*')) {
            return 'id';
        }
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        Log::info("BlogPost Route Binding Attempt", [
            'value' => $value,
            'field' => $field,
            'request_path' => request()->path(),
            'is_admin' => request()->is('admin/*')
        ]);
        
        if (request()->is('admin/*')) {
            $post = $this->where('id', $value)->first();
            
            if (!$post) {
                Log::warning("BlogPost not found in admin route", [
                    'id' => $value,
                    'table_exists' => \Schema::hasTable('blog_posts'),
                    'total_posts' => BlogPost::count()
                ]);
            } else {
                Log::info("BlogPost found successfully", [
                    'id' => $post->id,
                    'title' => $post->title
                ]);
            }
            
            return $post;
        }
        
        return $this->where($field ?: 'slug', $value)->first();
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(BlogAuthor::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tags', 'post_id', 'tag_id');
    }

    public function media()
    {
        return $this->hasMany(BlogMedia::class, 'post_id');
    }

    public function views()
    {
        return $this->hasMany(BlogPostView::class, 'post_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')
                    ->where('scheduled_at', '>', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeByTag($query, $tagSlug)
    {
        return $query->whereHas('tags', function($q) use ($tagSlug) {
            $q->where('slug', $tagSlug);
        });
    }

    public function scopeByAuthor($query, $authorSlug)
    {
        return $query->whereHas('author', function($q) use ($authorSlug) {
            $q->where('slug', $authorSlug);
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('meta_keywords', 'like', "%{$search}%")
              ->orWhereHas('tags', function($tagQuery) use ($search) {
                  $tagQuery->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('category', function($catQuery) use ($search) {
                  $catQuery->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('author', function($authorQuery) use ($search) {
                  $authorQuery->where('name', 'like', "%{$search}%");
              });
        });
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->orderBy('view_count', 'desc')->limit($limit);
    }

    public function scopeMostLiked($query, $limit = 10)
    {
        return $query->orderBy('like_count', 'desc')->limit($limit);
    }

    public function scopeMostShared($query, $limit = 10)
    {
        return $query->orderBy('share_count', 'desc')->limit($limit);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isScheduled(): bool
    {
        return $this->status === 'scheduled' && $this->scheduled_at > now();
    }

    public function getFeaturedImageUrl(): string
    {
        if ($this->featured_image && filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
            return $this->featured_image;
        }
        
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }

        return 'https://images.unsplash.com/photo-1611224923853-80b023f02d71?w=800&h=600&fit=crop';
    }

    public function getExcerpt($limit = 150): string
    {
        if ($this->excerpt) {
            return Str::limit($this->excerpt, $limit);
        }

        return Str::limit(strip_tags($this->content), $limit);
    }

    public function getReadingTime(): string
    {
        if ($this->reading_time) {
            return $this->reading_time . ' min read';
        }

        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200);
        
        return $minutes . ' min read';
    }

    public function getSectionTitle(): string
    {
        $part1 = $this->title_part1 ?? 'Broadcast';
        $part2 = $this->title_part2 ?? 'Smarts';
        
        return $part1 . ' <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">' . $part2 . '</span>';
    }

    public function incrementViews()
    {
        $lastView = BlogPostView::where('post_id', $this->id)
                               ->where('ip_address', request()->ip())
                               ->where('viewed_at', '>=', now()->subHours(1))
                               ->first();

        if (!$lastView) {
            $this->increment('view_count');
            
            BlogPostView::create([
                'post_id' => $this->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'referrer' => request()->header('referer'),
                'viewed_at' => now()
            ]);
        }
    }

    public function getRelatedPosts($limit = 3)
    {
        $relatedPosts = self::published()
                           ->where('id', '!=', $this->id)
                           ->where('category_id', $this->category_id)
                           ->with(['category', 'author'])
                           ->orderBy('published_at', 'desc')
                           ->limit($limit)
                           ->get();

        if ($relatedPosts->count() < $limit) {
            $needed = $limit - $relatedPosts->count();
            $additionalPosts = self::published()
                                  ->where('id', '!=', $this->id)
                                  ->whereNotIn('id', $relatedPosts->pluck('id'))
                                  ->with(['category', 'author'])
                                  ->orderBy('view_count', 'desc')
                                  ->limit($needed)
                                  ->get();
            
            $relatedPosts = $relatedPosts->merge($additionalPosts);
        }

        return $relatedPosts;
    }

    public function getGalleryImages(): array
    {
        if (!$this->gallery) {
            return [];
        }

        return collect($this->gallery)->map(function($image) {
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                return $image;
            }
            return asset('storage/' . $image);
        })->toArray();
    }

    public function getShareUrl(): string
    {
        return route('blog.show', $this->slug);
    }

    public function getShareText(): string
    {
        return $this->title . ' - ' . $this->getExcerpt(100);
    }

    public function getTotalEngagement(): int
    {
        return $this->view_count + $this->like_count + $this->share_count;
    }

    public function getPopularityScore(): float
    {
        $viewScore = $this->view_count * 1;
        $likeScore = $this->like_count * 5;
        $shareScore = $this->share_count * 10;
        $recencyScore = $this->published_at->diffInDays(now()) < 7 ? 20 : 0;
        
        return $viewScore + $likeScore + $shareScore + $recencyScore;
    }

    public function isPopular(): bool
    {
        return $this->view_count > 1000 || $this->like_count > 50 || $this->share_count > 20;
    }

    public function hasBeenLikedByUser(): bool
    {
        return session()->has('liked_post_' . $this->id);
    }

    public function getEstimatedReadingTime(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return ceil($wordCount / 200);
    }

    public function getSeoScore(): int
    {
        $score = 0;
        
        if (strlen($this->title) >= 50 && strlen($this->title) <= 60) {
            $score += 20;
        }
        
        if ($this->meta_description && strlen($this->meta_description) >= 150 && strlen($this->meta_description) <= 160) {
            $score += 20;
        }
        
        if ($this->excerpt) {
            $score += 15;
        }
        
        if ($this->featured_image) {
            $score += 15;
        }
        
        if ($this->tags->count() > 0) {
            $score += 15;
        }
        
        $wordCount = str_word_count(strip_tags($this->content));
        if ($wordCount >= 300) {
            $score += 15;
        }
        
        return $score;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            if ($post->content) {
                $wordCount = str_word_count(strip_tags($post->content));
                $post->reading_time = ceil($wordCount / 200);
            }

            if (!$post->slug && $post->title) {
                $post->slug = Str::slug($post->title);
            }

            if (!$post->meta_title && $post->title) {
                $post->meta_title = $post->title;
            }

            if (!$post->meta_description && $post->excerpt) {
                $post->meta_description = Str::limit($post->excerpt, 160);
            } elseif (!$post->meta_description && $post->content) {
                $post->meta_description = Str::limit(strip_tags($post->content), 160);
            }
        });
    }
}