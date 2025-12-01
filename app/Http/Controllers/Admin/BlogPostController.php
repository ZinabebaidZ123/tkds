<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Newsletter;
use App\Models\BlogCategory;
use App\Models\BlogAuthor;
use App\Models\BlogTag;
use App\Models\BlogMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Services\NewsletterEmailService;
use Illuminate\Support\Facades\Log;

class BlogPostController extends Controller

{

       protected NewsletterEmailService $newsletterService;

    public function __construct()
    {
        $this->newsletterService = new NewsletterEmailService();
    }

    public function index(Request $request)
    {
        $query = BlogPost::with(['category', 'author', 'tags']);

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by author
        if ($request->author) {
            $query->where('author_id', $request->author);
        }

        // Search
        if ($request->search) {
            $query->search($request->search);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $categories = BlogCategory::active()->get();
        $authors = BlogAuthor::active()->get();

        return view('admin.blog.posts.index', compact('posts', 'categories', 'authors'));
    }

    public function create()
    {
        $categories = BlogCategory::active()->ordered()->get();
        $authors = BlogAuthor::active()->get();
        $tags = BlogTag::active()->orderBy('name')->get();
        
        return view('admin.blog.posts.addedit', compact('categories', 'authors', 'tags'));
    }


   public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:500',
        'slug' => 'nullable|string|max:500|unique:blog_posts,slug',
        'excerpt' => 'nullable|string|max:1000',
        'content' => 'required|string|min:10', // ✅ إضافة validation للـ content
        'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'featured_image_alt' => 'nullable|string|max:255',
        'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'category_id' => 'required|exists:blog_categories,id',
        'author_id' => 'required|exists:blog_authors,id',
        'status' => 'required|in:draft,published,scheduled,archived',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'published_at' => 'nullable|date',
        'scheduled_at' => 'nullable|date|after:now',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'meta_keywords' => 'nullable|string|max:500',
        'tags' => 'nullable|array',
        'media_files.*' => 'nullable|file|max:10240',
        'send_newsletter' => 'boolean',
    ], [
        // ✅ Custom error messages
        'content.required' => 'Content is required.',
        'content.min' => 'Content must be at least 10 characters long.',
        'title.required' => 'Post title is required.',
        'category_id.required' => 'Please select a category.',
        'author_id.required' => 'Please select an author.',
        'status.required' => 'Please select a status.',
        'featured_image.image' => 'Featured image must be a valid image file.',
        'featured_image.max' => 'Featured image size must not exceed 5MB.',
        'gallery.*.image' => 'All gallery files must be valid image files.',
        'gallery.*.max' => 'Each gallery image must not exceed 5MB.',
        'media_files.*.max' => 'Each media file must not exceed 10MB.',
        'scheduled_at.after' => 'Scheduled date must be in the future.',
    ]);

    // ✅ Custom validation for content (strip HTML tags and check)
    $contentText = strip_tags($request->content);
    if (strlen(trim($contentText)) < 10) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['content' => 'Content must contain at least 10 characters of actual text.']);
    }

    // ✅ Custom validation for newsletter checkbox
    if ($request->has('send_newsletter') && $request->send_newsletter == '1') {
        if ($request->status !== 'published') {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'send_newsletter' => 'Newsletter can only be sent when the post status is "Published". Please change the status to Published or uncheck the newsletter option.'
                ]);
        }
    }

    try {
        $data = $request->all();
        
        // ✅ Handle checkboxes properly
        $data['is_featured'] = $request->has('is_featured') && $request->is_featured == '1';
        $data['is_trending'] = $request->has('is_trending') && $request->is_trending == '1';
        
        $data['slug'] = $request->slug ?: Str::slug($request->title);
        
        // Handle status-specific dates
        if ($data['status'] === 'published') {
            if (empty($data['published_at'])) {
                $data['published_at'] = now();
            }
        } elseif ($data['status'] === 'scheduled') {
            if (!empty($data['scheduled_at'])) {
                $data['published_at'] = $data['scheduled_at'];
            } else {
                $data['published_at'] = null;
            }
        } else {
            $data['published_at'] = null;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            try {
                $imagePath = $request->file('featured_image')->store('blog/posts', 'public');
                $data['featured_image'] = $imagePath;
            } catch (\Exception $e) {
                Log::error('Featured image upload failed: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['featured_image' => 'Failed to upload featured image. Please try again.']);
            }
        }

        // ✅ Handle gallery upload for CREATE - support multiple images
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            Log::info('Creating new post with gallery images: ' . count($request->file('gallery')));
            
            foreach ($request->file('gallery') as $file) {
                try {
                    $galleryPath = $file->store('blog/gallery', 'public');
                    $galleryPaths[] = $galleryPath;
                    Log::info('Stored gallery image: ' . $galleryPath);
                } catch (\Exception $e) {
                    Log::error('Gallery image upload failed: ' . $e->getMessage());
                    // Continue with other images instead of failing completely
                }
            }
        }
        $data['gallery'] = $galleryPaths;

        // ✅ Create the post
        $post = BlogPost::create($data);

        Log::info('Created new post with gallery', [
            'post_id' => $post->id,
            'gallery_count' => count($galleryPaths),
            'gallery_paths' => $galleryPaths
        ]);

        // Sync tags
        if ($request->has('tags') && is_array($request->tags)) {
            $validTags = array_filter($request->tags, function($tagId) {
                return is_numeric($tagId) || (is_string($tagId) && strpos($tagId, 'temp_') === 0);
            });
            
            if (!empty($validTags)) {
                $post->tags()->sync($validTags);
            }
        }

        // Handle additional media files
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $index => $file) {
                try {
                    BlogMedia::create([
                        'post_id' => $post->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $file->store('blog/media', 'public'),
                        'file_type' => pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION),
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'sort_order' => $index,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Media file upload failed: ' . $e->getMessage());
                    // Continue with other files
                }
            }
        }

        // ✅ Send newsletter if requested and post is published
        if ($request->has('send_newsletter') && $request->send_newsletter == '1' && $data['status'] === 'published') {
            try {
                $this->sendNewsletterNotification($post);
                Log::info('Newsletter sent for new post', ['post_id' => $post->id]);
            } catch (\Exception $e) {
                Log::error('Newsletter sending failed for new post: ' . $e->getMessage());
                return redirect()->route('admin.blog.posts.index')
                    ->with('success', 'Post created successfully!')
                    ->with('newsletter_error', 'Post created, but newsletter sending failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Post created successfully' . ($request->has('send_newsletter') && $request->send_newsletter == '1' && $data['status'] === 'published' ? ' and newsletter sent!' : '!'));

    } catch (\Exception $e) {
        Log::error('Post creation failed: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()
            ->withInput()
            ->withErrors(['general' => 'Failed to create post. Please try again. Error: ' . $e->getMessage()]);
    }
}
    public function show(BlogPost $post)
    {
        $post->load(['category', 'author', 'tags', 'media']);
        return view('admin.blog.posts.show', compact('post'));
    }

    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::active()->ordered()->get();
        $authors = BlogAuthor::active()->get();
        $tags = BlogTag::active()->orderBy('name')->get();
        $post->load(['tags', 'media']);
        
        return view('admin.blog.posts.addedit', compact('post', 'categories', 'authors', 'tags'));
    }
public function update(Request $request, BlogPost $post)
{
    $request->validate([
        'title' => 'required|string|max:500',
        'slug' => 'nullable|string|max:500|unique:blog_posts,slug,' . $post->id,
        'excerpt' => 'nullable|string|max:1000',
        'content' => 'required|string|min:10', // ✅ إضافة validation للـ content
        'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'featured_image_alt' => 'nullable|string|max:255',
        'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'category_id' => 'required|exists:blog_categories,id',
        'author_id' => 'required|exists:blog_authors,id',
        'status' => 'required|in:draft,published,scheduled,archived',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'published_at' => 'nullable|date',
        'scheduled_at' => 'nullable|date|after:now',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'meta_keywords' => 'nullable|string|max:500',
        'tags' => 'nullable|array',
        'media_files.*' => 'nullable|file|max:10240',
        'remove_gallery_images' => 'nullable|array',
        'remove_gallery_images.*' => 'string',
        'send_newsletter' => 'boolean',
    ], [
        // ✅ Custom error messages
        'content.required' => 'Content is required.',
        'content.min' => 'Content must be at least 10 characters long.',
        'title.required' => 'Post title is required.',
        'category_id.required' => 'Please select a category.',
        'author_id.required' => 'Please select an author.',
        'status.required' => 'Please select a status.',
        'featured_image.image' => 'Featured image must be a valid image file.',
        'featured_image.max' => 'Featured image size must not exceed 5MB.',
        'gallery.*.image' => 'All gallery files must be valid image files.',
        'gallery.*.max' => 'Each gallery image must not exceed 5MB.',
        'media_files.*.max' => 'Each media file must not exceed 10MB.',
        'scheduled_at.after' => 'Scheduled date must be in the future.',
    ]);

    // ✅ Custom validation for content (strip HTML tags and check)
    $contentText = strip_tags($request->content);
    if (strlen(trim($contentText)) < 10) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['content' => 'Content must contain at least 10 characters of actual text.']);
    }

    // ✅ Custom validation for newsletter checkbox
    if ($request->has('send_newsletter') && $request->send_newsletter == '1') {
        if ($request->status !== 'published') {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'send_newsletter' => 'Newsletter can only be sent when the post status is "Published". Please change the status to Published or uncheck the newsletter option.'
                ]);
        }
    }

    try {
        $data = $request->all();
        
        // ✅ Handle checkboxes properly
        $data['is_featured'] = $request->has('is_featured') && $request->is_featured == '1';
        $data['is_trending'] = $request->has('is_trending') && $request->is_trending == '1';
        
        $data['slug'] = $request->slug ?: Str::slug($request->title);

        // ✅ Handle status-specific dates properly with null checks
        if ($data['status'] === 'published') {
            // Only set published_at if post wasn't already published and no custom date provided
            if (!$post->published_at && empty($data['published_at'])) {
                $data['published_at'] = now();
            }
        } elseif ($data['status'] === 'scheduled') {
            // For scheduled posts, use scheduled_at as published_at
            if (!empty($data['scheduled_at'])) {
                $data['published_at'] = $data['scheduled_at'];
            }
        } else {
            // For draft or archived posts, clear published_at only if it wasn't set before
            if ($data['status'] === 'draft' && !$post->published_at) {
                $data['published_at'] = null;
            }
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            try {
                // Delete old image
                if ($post->featured_image && !filter_var($post->featured_image, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($post->featured_image);
                }
                
                $imagePath = $request->file('featured_image')->store('blog/posts', 'public');
                $data['featured_image'] = $imagePath;
            } catch (\Exception $e) {
                Log::error('Featured image upload failed during update: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['featured_image' => 'Failed to upload featured image. Please try again.']);
            }
        }

        // ✅ Gallery Management
        $currentGallery = is_array($post->gallery) ? $post->gallery : [];
        
        // Remove selected images
        if ($request->has('remove_gallery_images') && is_array($request->remove_gallery_images)) {
            foreach ($request->remove_gallery_images as $imageToRemove) {
                try {
                    if (!filter_var($imageToRemove, FILTER_VALIDATE_URL)) {
                        if (Storage::disk('public')->exists($imageToRemove)) {
                            Storage::disk('public')->delete($imageToRemove);
                        }
                    }
                    
                    $currentGallery = array_filter($currentGallery, function($image) use ($imageToRemove) {
                        return $image !== $imageToRemove;
                    });
                } catch (\Exception $e) {
                    Log::error('Failed to delete gallery image: ' . $e->getMessage());
                    // Continue with other images
                }
            }
            
            $currentGallery = array_values($currentGallery);
        }

        // Add new images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                try {
                    $newImagePath = $file->store('blog/gallery', 'public');
                    $currentGallery[] = $newImagePath;
                    Log::info('Added new gallery image: ' . $newImagePath);
                } catch (\Exception $e) {
                    Log::error('Failed to upload new gallery image: ' . $e->getMessage());
                    // Continue with other images
                }
            }
        }
        
        $data['gallery'] = $currentGallery;

        // Store previous status to check for newsletter sending
        $previousStatus = $post->status;
        
        // ✅ Update the post
        $post->update($data);

        // Sync tags
        if ($request->has('tags')) {
            $validTags = [];
            if (is_array($request->tags)) {
                $validTags = array_filter($request->tags, function($tagId) {
                    return is_numeric($tagId) || (is_string($tagId) && strpos($tagId, 'temp_') === 0);
                });
            }
            $post->tags()->sync($validTags);
        } else {
            $post->tags()->sync([]);
        }

        // Handle additional media files
        if ($request->hasFile('media_files')) {
            $existingMediaCount = $post->media()->count();
            foreach ($request->file('media_files') as $index => $file) {
                try {
                    BlogMedia::create([
                        'post_id' => $post->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $file->store('blog/media', 'public'),
                        'file_type' => pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION),
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'sort_order' => $existingMediaCount + $index,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Media file upload failed during update: ' . $e->getMessage());
                    // Continue with other files
                }
            }
        }

        // ✅ Newsletter logic with better validation
        $isNewlyPublished = ($previousStatus !== 'published' && $data['status'] === 'published');
        
        // Send newsletter if requested and newly published
        if ($request->has('send_newsletter') && $request->send_newsletter == '1' && $isNewlyPublished) {
            try {
                $this->sendNewsletterNotification($post);
                Log::info('Newsletter notification triggered successfully', [
                    'post_id' => $post->id,
                    'post_title' => $post->title
                ]);
                
                return redirect()->route('admin.blog.posts.index')
                    ->with('success', 'Post updated successfully and newsletter sent!');
                    
            } catch (\Exception $e) {
                Log::error('Newsletter notification failed: ' . $e->getMessage(), [
                    'post_id' => $post->id,
                    'error' => $e->getMessage()
                ]);
                
                return redirect()->route('admin.blog.posts.index')
                    ->with('success', 'Post updated successfully.')
                    ->with('newsletter_error', 'Post updated successfully, but newsletter notification failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Post updated successfully.');

    } catch (\Exception $e) {
        Log::error('Post update failed: ' . $e->getMessage(), [
            'post_id' => $post->id ?? 'unknown',
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()
            ->withInput()
            ->withErrors(['general' => 'Failed to update post. Please try again. Error: ' . $e->getMessage()]);
    }
}

    // ✅ NEW: Method to remove single gallery image via AJAX
    public function removeGalleryImage(Request $request, BlogPost $post)
    {
        try {
            $request->validate([
                'image_path' => 'required|string'
            ]);

            $imagePath = $request->image_path;
            $currentGallery = is_array($post->gallery) ? $post->gallery : [];
            
            // Check if image exists in gallery
            if (!in_array($imagePath, $currentGallery)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image not found in gallery.'
                ], 404);
            }

            // Remove from storage
            if (!filter_var($imagePath, FILTER_VALIDATE_URL)) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            
            // Remove from gallery array
            $updatedGallery = array_filter($currentGallery, function($image) use ($imagePath) {
                return $image !== $imagePath;
            });
            
            // Re-index array
            $updatedGallery = array_values($updatedGallery);
            
            // Update post
            $post->update(['gallery' => $updatedGallery]);

            Log::info("Gallery image removed successfully: Post ID {$post->id}, Image: {$imagePath}");

            return response()->json([
                'success' => true,
                'message' => 'Image removed successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error removing gallery image: ' . $e->getMessage(), [
                'post_id' => $post->id,
                'image_path' => $request->image_path ?? 'unknown'
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove image: ' . $e->getMessage()
            ], 500);
        }
    }

    // ✅ FIXED: Delete method with proper validation and error handling
    public function destroy(BlogPost $post)
    {
        try {
            if (!$post) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Post not found.'
                    ], 404);
                }
                
                return redirect()->route('admin.blog.posts.index')
                    ->with('error', 'Post not found.');
            }

            // Delete featured image
            if ($post->featured_image && !filter_var($post->featured_image, FILTER_VALIDATE_URL)) {
                if (Storage::disk('public')->exists($post->featured_image)) {
                    Storage::disk('public')->delete($post->featured_image);
                }
            }

            // Delete gallery images
            if ($post->gallery && is_array($post->gallery)) {
                foreach ($post->gallery as $image) {
                    if (!filter_var($image, FILTER_VALIDATE_URL)) {
                        if (Storage::disk('public')->exists($image)) {
                            Storage::disk('public')->delete($image);
                        }
                    }
                }
            }

            // Delete media files
            if ($post->media && $post->media->count() > 0) {
                foreach ($post->media as $media) {
                    if (!filter_var($media->file_path, FILTER_VALIDATE_URL)) {
                        if (Storage::disk('public')->exists($media->file_path)) {
                            Storage::disk('public')->delete($media->file_path);
                        }
                    }
                }
            }

            // Delete tags associations
            $post->tags()->detach();

            // Delete media records
            $post->media()->delete();

            // Delete the post
            $post->delete();

            // Log success
            Log::info("Blog post deleted successfully: ID {$post->id}, Title: {$post->title}");

            // Return JSON response for AJAX
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post deleted successfully.'
                ]);
            }

            return redirect()->route('admin.blog.posts.index')
                ->with('success', 'Post deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Error deleting blog post: ' . $e->getMessage(), [
                'post_id' => $post->id ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete post. Error: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.blog.posts.index')
                ->with('error', 'Failed to delete post: ' . $e->getMessage());
        }
    }

    // ✅ FIXED: Status update with proper validation
    public function updateStatus(Request $request, BlogPost $post)
    {
        try {
            $request->validate([
                'status' => 'required|in:draft,published,scheduled,archived',
            ]);

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found.'
                ], 404);
            }

            $data = ['status' => $request->status];

            // Set published_at when publishing
            if ($request->status === 'published' && !$post->published_at) {
                $data['published_at'] = now();
            }

            $post->update($data);

            Log::info("Blog post status updated: ID {$post->id}, New Status: {$request->status}");

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'status' => $post->status
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating blog post status: ' . $e->getMessage(), [
                'post_id' => $post->id ?? 'unknown',
                'new_status' => $request->status ?? 'unknown'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    // ✅ FIXED: Duplicate method with complete error handling
    public function duplicate(BlogPost $post)
    {
        try {
            if (!$post) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Post not found.'
                    ], 404);
                }
                
                return redirect()->route('admin.blog.posts.index')
                    ->with('error', 'Post not found.');
            }

            // Create new post with replicated data
            $newPost = $post->replicate();
            $newPost->title = $post->title . ' (Copy)';
            $newPost->slug = $this->generateUniqueSlug($newPost->title);
            $newPost->status = 'draft';
            $newPost->published_at = null;
            $newPost->scheduled_at = null;
            $newPost->view_count = 0;
            $newPost->like_count = 0;
            $newPost->share_count = 0;
            $newPost->created_at = now();
            $newPost->updated_at = now();

            // ✅ FIXED: Copy gallery images properly - ALL images
            if ($post->gallery && is_array($post->gallery)) {
                $newGallery = [];
                foreach ($post->gallery as $imagePath) {
                    if (Storage::disk('public')->exists($imagePath)) {
                        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                        $filename = pathinfo($imagePath, PATHINFO_FILENAME);
                        $directory = dirname($imagePath);
                        $newPath = $directory . '/' . $filename . '_copy_' . time() . '_' . rand(100, 999) . '.' . $extension;
                        
                        if (Storage::disk('public')->copy($imagePath, $newPath)) {
                            $newGallery[] = $newPath;
                        }
                    }
                }
                $newPost->gallery = $newGallery;
                
                Log::info("Duplicated gallery images", [
                    'original_count' => count($post->gallery),
                    'copied_count' => count($newGallery),
                    'original_images' => $post->gallery,
                    'copied_images' => $newGallery
                ]);
            }

            $newPost->save();

            // Copy tags
            if ($post->tags && $post->tags->count() > 0) {
                $newPost->tags()->sync($post->tags->pluck('id'));
            }

            // Copy media files (create new copies)
            if ($post->media && $post->media->count() > 0) {
                foreach ($post->media as $media) {
                    if (Storage::disk('public')->exists($media->file_path)) {
                        // Create new filename to avoid conflicts
                        $extension = pathinfo($media->file_path, PATHINFO_EXTENSION);
                        $filename = pathinfo($media->file_path, PATHINFO_FILENAME);
                        $directory = dirname($media->file_path);
                        $newPath = $directory . '/' . $filename . '_copy_' . time() . '.' . $extension;
                        
                        if (Storage::disk('public')->copy($media->file_path, $newPath)) {
                            BlogMedia::create([
                                'post_id' => $newPost->id,
                                'file_name' => 'Copy of ' . $media->file_name,
                                'file_path' => $newPath,
                                'file_type' => $media->file_type,
                                'file_size' => $media->file_size,
                                'mime_type' => $media->mime_type,
                                'sort_order' => $media->sort_order,
                            ]);
                        }
                    }
                }
            }

            Log::info("Blog post duplicated successfully: Original ID {$post->id}, New ID {$newPost->id}");

            // Return JSON response for AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post duplicated successfully.',
                    'redirect_url' => route('admin.blog.posts.edit', $newPost),
                    'new_post_id' => $newPost->id
                ]);
            }

            return redirect()->route('admin.blog.posts.edit', $newPost)
                ->with('success', 'Post duplicated successfully.');

        } catch (\Exception $e) {
            Log::error('Error duplicating blog post: ' . $e->getMessage(), [
                'original_post_id' => $post->id ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to duplicate post: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.blog.posts.index')
                ->with('error', 'Failed to duplicate post: ' . $e->getMessage());
        }
    }

    public function deleteMedia(Request $request, BlogPost $post, BlogMedia $media)
    {
        try {
            if ($media->post_id !== $post->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Media not found for this post.'
                ], 404);
            }

            // Delete file from storage
            if (!filter_var($media->file_path, FILTER_VALIDATE_URL)) {
                if (Storage::disk('public')->exists($media->file_path)) {
                    Storage::disk('public')->delete($media->file_path);
                }
            }

            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Media deleted successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting blog media: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete media.'
            ], 500);
        }
    }

    /**
     * Generate unique slug for duplicated post
     */
    private function generateUniqueSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = BlogPost::where('slug', $slug);
            if ($id) {
                $query->where('id', '!=', $id);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }


public function getSectionTitle()
{
    $firstPost = BlogPost::published()->with(['category', 'author'])->latest('published_at')->first();
    
    return response()->json([
        'success' => true,
        'title_part1' => $firstPost->title_part1 ?? '',
        'title_part2' => $firstPost->title_part2 ?? '',
        'subtitle' => $firstPost->subtitle ?? ''
    ]);
}

public function updateSectionTitle(Request $request)
{
    $request->validate([
        'title_part1' => 'nullable|string|max:255',
        'title_part2' => 'nullable|string|max:255',
        'subtitle' => 'nullable|string|max:500',
    ]);

    // Update the first published post or create a new one if none exists
    $firstPost = BlogPost::published()->with(['category', 'author'])->latest('published_at')->first();
    
    if ($firstPost) {
        $firstPost->update([
            'title_part1' => $request->title_part1,
            'title_part2' => $request->title_part2,
            'subtitle' => $request->subtitle
        ]);
    } else {
        // If no post exists, create a default one with section title data
        $defaultCategory = BlogCategory::active()->first();
        $defaultAuthor = BlogAuthor::active()->first();
        
        if (!$defaultCategory || !$defaultAuthor) {
            return response()->json([
                'success' => false,
                'message' => 'Please create at least one category and author first.'
            ], 422);
        }
        
        BlogPost::create([
            'title_part1' => $request->title_part1,
            'title_part2' => $request->title_part2,
            'subtitle' => $request->subtitle,
            'title' => 'Default Blog Post',
            'slug' => 'default-blog-post',
            'content' => 'This is a default blog post created for section title management.',
            'excerpt' => 'Default blog post excerpt.',
            'featured_image' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=800',
            'category_id' => $defaultCategory->id,
            'author_id' => $defaultAuthor->id,
            'status' => 'published',
            'published_at' => now()
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Section title updated successfully.'
    ]);
}

private function sendNewsletterNotification(BlogPost $post): void
{
    try {
        // Log newsletter attempt start
        Log::info('Starting newsletter notification process', [
            'post_id' => $post->id,
            'post_title' => $post->title,
            'post_status' => $post->status
        ]);

        // Check if active subscribers exist first
        $subscriberCount = $this->newsletterService->getActiveSubscriberCount();
        Log::info('Active subscriber count check', [
            'active_count' => $subscriberCount,
            'total_count' => Newsletter::count()
        ]);

        if ($subscriberCount === 0) {
            session()->flash('newsletter_warning', 
                'No active newsletter subscribers found. Total subscribers: ' . Newsletter::count() . '. Please check subscriber statuses.');
            
            Log::warning('No active subscribers to notify', [
                'post_id' => $post->id,
                'total_subscribers' => Newsletter::count(),
                'active_subscribers' => 0
            ]);
            return;
        }

        $result = $this->newsletterService->sendNewPostNotification($post);
        
        Log::info('Newsletter service result', [
            'post_id' => $post->id,
            'result' => $result
        ]);
        
        if ($result['success']) {
            if ($result['sent_count'] > 0) {
                session()->flash('newsletter_success', 
                    "📧 Newsletter sent successfully to {$result['sent_count']} out of {$result['active_subscribers']} active subscribers!");
                
                // Also log successful campaign
                Log::info('Newsletter campaign successful', [
                    'post_id' => $post->id,
                    'post_title' => $post->title,
                    'sent_count' => $result['sent_count'],
                    'active_subscribers' => $result['active_subscribers'],
                    'failed_count' => $result['failed_count'] ?? 0
                ]);
            } else {
                session()->flash('newsletter_error', 
                    "⚠️ Newsletter failed to send to any subscribers. Active subscribers: {$result['active_subscribers']}. Check application logs for details.");
            }
        } else {
            session()->flash('newsletter_error', 
                "❌ Newsletter sending failed: " . $result['message']);
        }

    } catch (\Exception $e) {
        Log::error('Newsletter notification process failed', [
            'post_id' => $post->id,
            'post_title' => $post->title,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
        session()->flash('newsletter_error', 
            '🚨 Critical error in newsletter process: ' . $e->getMessage());
    }
}
}