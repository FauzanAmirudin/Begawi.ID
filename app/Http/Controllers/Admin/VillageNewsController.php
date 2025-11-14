<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Models\VillageNews;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VillageNewsController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $village = $this->resolveVillage();

        $validated = $request->validateWithBag('news', [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'writer' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'published_at' => ['nullable', 'date'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['village_id'] = $village->id;
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['status'] === VillageNews::STATUS_PUBLISHED && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('villages/news', 'public');
        }

        VillageNews::create($validated);

        return redirect()
            ->route('admin.desa-management.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(Request $request, VillageNews $news): RedirectResponse
    {
        $validated = $request->validateWithBag('news', [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'writer' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'published_at' => ['nullable', 'date'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        if ($news->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $news->id);
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['status'] === VillageNews::STATUS_PUBLISHED && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }

            $validated['featured_image'] = $request->file('featured_image')->store('villages/news', 'public');
        }

        $news->update($validated);

        return redirect()
            ->route('admin.desa-management.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(VillageNews $news): RedirectResponse
    {
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return redirect()
            ->route('admin.desa-management.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    protected function resolveVillage(): Village
    {
        return Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );
    }

    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            VillageNews::query()
                ->when($ignoreId, fn ($query) => $query->whereNot('id', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
