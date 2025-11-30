<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\BlogAuthor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::published()->with(['category', 'author', 'tags']);

        // Fixed category filtering
        if ($request->category && $request->category !== 'all') {
            if (is_numeric($request->category)) {
                $query->where('category_id', $request->category);
            } else {
                $query->whereHas('category', function($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }
        }

        // Filter by tag
        if ($request->tag) {
            $query->byTag($request->tag);
        }

        // Filter by author
        if ($request->author) {
            $query->byAuthor($request->author);
        }

        // Enhanced search functionality
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%")
                  ->orWhere('meta_keywords', 'like', "%{$searchTerm}%")
                  ->orWhereHas('tags', function($tagQuery) use ($searchTerm) {
                      $tagQuery->where('name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('category', function($catQuery) use ($searchTerm) {
                      $catQuery->where('name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('author', function($authorQuery) use ($searchTerm) {
                      $authorQuery->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Enhanced sorting options
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'trending':
                $query->where('is_trending', true)->orderBy('published_at', 'desc');
                break;
            case 'most_liked':
                $query->orderBy('like_count', 'desc');
                break;
            case 'most_shared':
                $query->orderBy('share_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            default:
                $query->orderBy('published_at', 'desc');
        }

        $posts = $query->paginate(12);

        // Get featured post for hero section
        $featuredPost = BlogPost::published()
                                ->featured()
                                ->with(['category', 'author'])
                                ->latest('published_at')
                                ->first();

        // Get sidebar data with better performance
        $categories = BlogCategory::active()
                                 ->withCount(['activePosts' => function($query) {
                                     $query->published();
                                 }])
                                 ->having('active_posts_count', '>', 0)
                                 ->ordered()
                                 ->get();

        $popularPosts = BlogPost::published()
                               ->with(['category', 'author'])
                               ->orderBy('view_count', 'desc')
                               ->limit(5)
                               ->get();

        $tags = BlogTag::active()
                       ->withCount(['posts' => function($query) {
                           $query->published();
                       }])
                       ->having('posts_count', '>', 0)
                       ->orderBy('posts_count', 'desc')
                       ->limit(20)
                       ->get();

        return view('blog.index', compact(
            'posts',
            'featuredPost',
            'categories',
            'popularPosts',
            'tags'
        ));
    }

    public function show(BlogPost $post)
    {
        // Check if post is published
        if (!$post->isPublished()) {
            abort(404);
        }

        // Increment views
        $post->incrementViews();

        // Load relationships
        $post->load(['category', 'author', 'tags', 'media']);

        // Get related posts
        $relatedPosts = $post->getRelatedPosts(3);

        // Get next and previous posts
        $nextPost = BlogPost::published()
                           ->where('published_at', '>', $post->published_at)
                           ->orderBy('published_at', 'asc')
                           ->first();

        $previousPost = BlogPost::published()
                               ->where('published_at', '<', $post->published_at)
                               ->orderBy('published_at', 'desc')
                               ->first();

        return view('blog.show', compact(
            'post',
            'relatedPosts',
            'nextPost',
            'previousPost'
        ));
    }

    public function category(BlogCategory $category)
    {
        // Check if category is active
        if (!$category->isActive()) {
            abort(404);
        }

        $query = BlogPost::published()
                        ->where('category_id', $category->id)
                        ->with(['author', 'tags']);

        // Add search functionality to category page
        if (request('search')) {
            $searchTerm = request('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        // Add sorting to category page
        $sortBy = request('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            default:
                $query->orderBy('published_at', 'desc');
        }

        $posts = $query->paginate(12);

        return view('blog.category', compact('category', 'posts'));
    }

    public function tag(BlogTag $tag)
    {
        // Check if tag is active
        if (!$tag->isActive()) {
            abort(404);
        }

        $query = BlogPost::published()
                        ->whereHas('tags', function($q) use ($tag) {
                            $q->where('id', $tag->id);
                        })
                        ->with(['category', 'author']);

        // Add search functionality to tag page
        if (request('search')) {
            $searchTerm = request('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        // Add sorting to tag page
        $sortBy = request('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            default:
                $query->orderBy('published_at', 'desc');
        }

        $posts = $query->paginate(12);

        return view('blog.tag', compact('tag', 'posts'));
    }

    public function author(BlogAuthor $author)
    {
        // Check if author is active
        if (!$author->isActive()) {
            abort(404);
        }

        $query = BlogPost::published()
                        ->where('author_id', $author->id)
                        ->with(['category', 'tags']);

        // Add search functionality to author page
        if (request('search')) {
            $searchTerm = request('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        // Add sorting to author page
        $sortBy = request('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            default:
                $query->orderBy('published_at', 'desc');
        }

        $posts = $query->paginate(12);

        return view('blog.author', compact('author', 'posts'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return redirect()->route('blog.index');
        }

        $postsQuery = BlogPost::published()
                        ->with(['category', 'author', 'tags']);

        // Enhanced search with relevance scoring
        $postsQuery->where(function($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('excerpt', 'like', "%{$query}%")
              ->orWhere('content', 'like', "%{$query}%")
              ->orWhere('meta_keywords', 'like', "%{$query}%")
              ->orWhereHas('tags', function($tagQuery) use ($query) {
                  $tagQuery->where('name', 'like', "%{$query}%");
              })
              ->orWhereHas('category', function($catQuery) use ($query) {
                  $catQuery->where('name', 'like', "%{$query}%");
              })
              ->orWhereHas('author', function($authorQuery) use ($query) {
                  $authorQuery->where('name', 'like', "%{$query}%");
              });
        });

        // Add sorting to search results
        $sortBy = $request->get('sort', 'relevance');
        switch ($sortBy) {
            case 'latest':
                $postsQuery->orderBy('published_at', 'desc');
                break;
            case 'popular':
                $postsQuery->orderBy('view_count', 'desc');
                break;
            case 'oldest':
                $postsQuery->orderBy('published_at', 'asc');
                break;
            default: // relevance
                // Order by title match first, then content match
                $postsQuery->orderByRaw("
                    CASE 
                        WHEN title LIKE '%{$query}%' THEN 1
                        WHEN excerpt LIKE '%{$query}%' THEN 2
                        ELSE 3
                    END
                ")->orderBy('published_at', 'desc');
        }

        $posts = $postsQuery->paginate(12);

        return view('blog.search', compact('posts', 'query'));
    }

  // Updated method for handling likes - FIXED
    public function like(Request $request, $post)
    {
        // Find post by ID
        $blogPost = BlogPost::find($post);
        
        if (!$blogPost || !$blogPost->isPublished()) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        // Check if user already liked this post (using session/IP)
        $sessionKey = 'liked_post_' . $blogPost->id;
        
        if ($request->session()->has($sessionKey)) {
            return response()->json([
                'success' => false,
                'message' => 'You already liked this post',
                'like_count' => $blogPost->like_count
            ]);
        }

        // Increment like count
        $blogPost->increment('like_count');
        
        // Store in session to prevent multiple likes
        $request->session()->put($sessionKey, true);

        return response()->json([
            'success' => true,
            'message' => 'Post liked successfully',
            'like_count' => $blogPost->like_count
        ]);
    }

    // Updated method for handling shares - FIXED
    public function share(Request $request, $post)
    {
        // Find post by ID
        $blogPost = BlogPost::find($post);
        
        if (!$blogPost || !$blogPost->isPublished()) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $platform = $request->get('platform', 'general');
        
        // Increment share count
        $blogPost->increment('share_count');

        return response()->json([
            'success' => true,
            'message' => 'Share recorded successfully',
            'share_count' => $blogPost->share_count,
            'platform' => $platform
        ]);
    }


    public function api()
    {
        $posts = BlogPost::published()
                        ->with(['category', 'author'])
                        ->select(['id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'reading_time', 'view_count', 'like_count', 'share_count', 'category_id', 'author_id'])
                        ->latest('published_at')
                        ->limit(6)
                        ->get();

        return response()->json([
            'success' => true,
            'data' => $posts->map(function($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'excerpt' => $post->getExcerpt(100),
                    'featured_image' => $post->getFeaturedImageUrl(),
                    'published_at' => $post->published_at->format('M d, Y'),
                    'reading_time' => $post->getReadingTime(),
                    'view_count' => $post->view_count,
                    'like_count' => $post->like_count,
                    'share_count' => $post->share_count,
                    'category' => [
                        'name' => $post->category->name,
                        'slug' => $post->category->slug,
                        'color' => $post->category->color,
                    ],
                    'author' => [
                        'name' => $post->author->name,
                        'slug' => $post->author->slug,
                        'avatar' => $post->author->getAvatarUrl(),
                    ],
                    'url' => route('blog.show', $post->slug),
                ];
            })
        ]);
    }
}