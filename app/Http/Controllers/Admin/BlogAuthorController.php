<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogAuthor;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogAuthorController extends Controller
{
    public function index()
    {
        $authors = BlogAuthor::withCount('activePosts')
                            ->orderBy('created_at', 'desc')
                            ->paginate(12);
        
        return view('admin.blog.authors.index', compact('authors'));
    }

    public function create()
    {
        $adminUsers = AdminUser::where('status', 'active')->get();
        return view('admin.blog.authors.addedit', compact('adminUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'admin_user_id' => 'nullable|exists:admin_users,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_authors,slug',
            'email' => 'nullable|email|max:255',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'social_links' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        $data['slug'] = $request->slug ?: Str::slug($request->name);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('blog/authors', 'public');
            $data['avatar'] = $avatarPath;
        }

        BlogAuthor::create($data);

        return redirect()->route('admin.blog.authors.index')
            ->with('success', 'Author created successfully.');
    }

    public function edit(BlogAuthor $author)
    {
        $adminUsers = AdminUser::where('status', 'active')->get();
        return view('admin.blog.authors.addedit', compact('author', 'adminUsers'));
    }

    public function update(Request $request, BlogAuthor $author)
    {
        $request->validate([
            'admin_user_id' => 'nullable|exists:admin_users,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_authors,slug,' . $author->id,
            'email' => 'nullable|email|max:255',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'social_links' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        $data['slug'] = $request->slug ?: Str::slug($request->name);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($author->avatar && !filter_var($author->avatar, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($author->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('blog/authors', 'public');
            $data['avatar'] = $avatarPath;
        }

        $author->update($data);

        return redirect()->route('admin.blog.authors.index')
            ->with('success', 'Author updated successfully.');
    }

    public function destroy(BlogAuthor $author)
    {
        if ($author->posts()->count() > 0) {
            return redirect()->route('admin.blog.authors.index')
                ->with('error', 'Cannot delete author with existing posts.');
        }

        // Delete avatar if exists
        if ($author->avatar && !filter_var($author->avatar, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($author->avatar);
        }

        $author->delete();

        return redirect()->route('admin.blog.authors.index')
            ->with('success', 'Author deleted successfully.');
    }

    public function updateStatus(Request $request, BlogAuthor $author)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $author->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $author->status
        ]);
    }
}