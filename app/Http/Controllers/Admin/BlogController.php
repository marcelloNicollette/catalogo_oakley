<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'thumb_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'material_date' => 'nullable|date',
            'publish_at' => 'nullable|date',
            'unpublish_at' => 'nullable|date',
            'status' => 'boolean',
            'active' => 'boolean',
            'access_levels' => 'nullable|array',
            'access_levels.*' => 'string|in:representante,interno,fornecedor,convidado,cliente',
        ]);

        if ($request->hasFile('thumb_image')) {
            $validated['thumb_image'] = $request->file('thumb_image')->store('blogs/thumbs', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('blogs/covers', 'public');
        }

        $validated['status'] = $request->boolean('status');
        $validated['active'] = $request->boolean('active');

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog criado com sucesso!');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'thumb_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'material_date' => 'nullable|date',
            'publish_at' => 'nullable|date',
            'unpublish_at' => 'nullable|date',
            'status' => 'boolean',
            'active' => 'boolean',
            'access_levels' => 'nullable|array',
            'access_levels.*' => 'string|in:representante,interno,fornecedor,convidado,cliente',
        ]);

        if ($request->hasFile('thumb_image')) {
            // Delete old thumb if exists
            if ($blog->thumb_image) {
                Storage::disk('public')->delete($blog->thumb_image);
            }
            $validated['thumb_image'] = $request->file('thumb_image')->store('blogs/thumbs', 'public');
        }

        if ($request->hasFile('cover_image')) {
            // Delete old cover if exists
            if ($blog->cover_image) {
                Storage::disk('public')->delete($blog->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('blogs/covers', 'public');
        }

        $validated['status'] = $request->boolean('status');
        $validated['active'] = $request->boolean('active');
        
        if (!$request->has('access_levels')) {
            $validated['access_levels'] = null;
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog atualizado com sucesso!');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->thumb_image) {
            Storage::disk('public')->delete($blog->thumb_image);
        }
        if ($blog->cover_image) {
            Storage::disk('public')->delete($blog->cover_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog removido com sucesso!');
    }
}
