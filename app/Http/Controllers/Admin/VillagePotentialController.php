<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Models\VillagePotential;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VillagePotentialController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $village = $this->resolveVillage();

        $validated = $request->validateWithBag('potential', [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:Aktif,Pengembangan,Nonaktif'],
            'map_embed' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['village_id'] = $village->id;

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('villages/potentials', 'public');
        }

        VillagePotential::create($validated);

        return redirect()
            ->route('admin.desa-management.index')
            ->with('success', 'Potensi desa berhasil ditambahkan.');
    }

    public function update(Request $request, VillagePotential $potential): RedirectResponse
    {
        $validated = $request->validateWithBag('potential', [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:Aktif,Pengembangan,Nonaktif'],
            'map_embed' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($potential->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $potential->id);
        }

        if ($request->hasFile('featured_image')) {
            if ($potential->featured_image) {
                Storage::disk('public')->delete($potential->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('villages/potentials', 'public');
        }

        $potential->update($validated);

        return redirect()
            ->route('admin.desa-management.index')
            ->with('success', 'Potensi desa berhasil diperbarui.');
    }

    public function destroy(VillagePotential $potential): RedirectResponse
    {
        if ($potential->featured_image) {
            Storage::disk('public')->delete($potential->featured_image);
        }

        $potential->delete();

        return redirect()
            ->route('admin.desa-management.index')
            ->with('success', 'Potensi desa berhasil dihapus.');
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
            VillagePotential::query()
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
