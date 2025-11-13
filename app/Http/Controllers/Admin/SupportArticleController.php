<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SupportArticleController extends Controller
{
    public function index(Request $request): View
    {
        $filters = collect($request->only(['category', 'status', 'search']))
            ->map(fn ($value) => is_string($value) ? trim($value) : $value)
            ->filter()
            ->toArray();

        $query = Article::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['status'])) {
            $query->where('is_published', $filters['status'] === 'published');
        }

        $articles = $query
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.support.articles.index', [
            'articles' => $articles,
            'categories' => Article::getCategories(),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.support.articles.create', [
            'categories' => Article::getCategories(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePayload($request);

        $article = new Article($validated);
        $article->slug = $this->generateUniqueSlug($validated['title']);
        $article->created_by = Auth::id();
        $article->is_published = $request->boolean('is_published');

        if ($article->is_published && !$article->published_at) {
            $article->published_at = now();
        }

        if ($request->hasFile('featured_image')) {
            $article->featured_image = $request->file('featured_image')->store('articles', 'public');
        }

        $article->save();

        return redirect()
            ->route('admin.support.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article): View
    {
        return view('admin.support.articles.edit', [
            'article' => $article,
            'categories' => Article::getCategories(),
        ]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $this->validatePayload($request, $article->id);

        $article->fill($validated);
        $article->slug = $this->generateUniqueSlug($validated['title'], $article->id);
        $article->is_published = $request->boolean('is_published');

        if ($article->is_published && !$article->published_at) {
            $article->published_at = now();
        }

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $article->featured_image = $request->file('featured_image')->store('articles', 'public');
        }

        $article->save();

        return redirect()
            ->route('admin.support.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()
            ->route('admin.support.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    protected function validatePayload(Request $request, ?int $articleId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'category' => ['required', 'in:' . implode(',', Article::getCategories())],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Article::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }
}

