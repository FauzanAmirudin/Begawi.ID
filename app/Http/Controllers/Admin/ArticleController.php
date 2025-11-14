<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Check if current user is super admin
     */
    protected function checkSuperAdmin(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user || $user->role !== User::ROLE_SUPER_ADMIN) {
            abort(403, 'Akses ditolak. Hanya Super Admin yang dapat mengakses halaman ini.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->checkSuperAdmin();
        
        $articles = Article::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.super-admin.content.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->checkSuperAdmin();
        
        $categories = Article::getCategories();
        
        return view('admin.super-admin.content.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'required|in:Tutorial,Update,Tips',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = Auth::id();
        $validated['is_published'] = $request->has('is_published');
        
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        if ($validated['is_published'] && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect()
            ->route('admin.content.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): View
    {
        $this->checkSuperAdmin();
        
        $article->load('creator');
        
        return view('admin.super-admin.content.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article): View
    {
        $this->checkSuperAdmin();
        
        $categories = Article::getCategories();
        
        return view('admin.super-admin.content.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'required|in:Tutorial,Update,Tips',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');
        
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        if ($validated['is_published'] && !$article->published_at && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        return redirect()
            ->route('admin.content.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        // Delete featured image if exists
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()
            ->route('admin.content.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
