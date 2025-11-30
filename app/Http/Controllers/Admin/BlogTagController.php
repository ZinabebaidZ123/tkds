<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BlogTagController extends Controller
{
    public function index()
    {
        $tags = BlogTag::withCount('posts')
                       ->orderBy('name', 'asc')
                       ->paginate(20);
        
        return view('admin.blog.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:blog_tags,name',
                'color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
                'status' => 'required|in:active,inactive',
            ]);

            $tag = BlogTag::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'color' => $request->color,
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tag created successfully.',
                'tag' => $tag
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Tag creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the tag.'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tag = BlogTag::findOrFail($id);
            
            $request->validate([
                'name' => 'required|string|max:255|unique:blog_tags,name,' . $tag->id,
                'color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
                'status' => 'required|in:active,inactive',
            ]);

            $tag->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'color' => $request->color,
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tag updated successfully.',
                'tag' => $tag->fresh()
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tag not found.'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Tag update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the tag.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $tag = BlogTag::findOrFail($id);
            
            // Detach from all posts before deleting
            $tag->posts()->detach();
            $tag->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tag deleted successfully.'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tag not found.'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Tag deletion error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the tag.'
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $tag = BlogTag::findOrFail($id);
            
            $request->validate([
                'status' => 'required|in:active,inactive',
            ]);

            $tag->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'status' => $tag->status
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tag not found.'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Tag status update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the status.'
            ], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('q');
            
            $tags = BlogTag::active()
                           ->where('name', 'like', "%{$query}%")
                           ->orderBy('name')
                           ->limit(10)
                           ->get();

            return response()->json($tags);

        } catch (\Exception $e) {
            \Log::error('Tag search error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while searching tags.'
            ], 500);
        }
    }
}