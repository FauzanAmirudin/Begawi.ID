<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Models\VillageGalleryCategory;
use App\Models\VillageGalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class VillageGalleryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $village = $this->resolveVillage();

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:photo,video'],
            'category_id' => ['nullable', 'exists:village_gallery_categories,id'],
            'new_category_name' => ['nullable', 'string', 'max:100'],
            'new_category_description' => ['nullable', 'string'],
            'taken_at' => ['nullable', 'date'],
            'media_file' => ['nullable', 'image', 'max:6144'],
            'media_url' => ['nullable', 'url'],
            'video_url' => ['nullable', 'url'],
            'thumbnail_file' => ['nullable', 'image', 'max:4096'],
            'thumbnail_url' => ['nullable', 'url'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $type = $request->input('type');

            if ($type === VillageGalleryItem::TYPE_PHOTO) {
                if (! $request->hasFile('media_file') && ! $request->filled('media_url')) {
                    $validator->errors()->add('media_file', 'Harap unggah foto atau masukkan URL media.');
                }
            }

            if ($type === VillageGalleryItem::TYPE_VIDEO) {
                if (! $request->filled('video_url')) {
                    $validator->errors()->add('video_url', 'Harap masukkan URL video.');
                }
            }

            if (! $request->filled('category_id') && ! $request->filled('new_category_name')) {
                $validator->errors()->add('category_id', 'Pilih kategori atau buat kategori baru.');
            }
        });

        if ($validator->fails()) {
            throw (new ValidationException($validator))->errorBag('gallery');
        }

        $validated = $validator->validated();

        $categoryId = $validated['category_id'] ?? null;

        if (! $categoryId && ! empty($validated['new_category_name'])) {
            $category = VillageGalleryCategory::updateOrCreate(
                [
                    'village_id' => $village->id,
                    'slug' => Str::slug($validated['new_category_name']),
                ],
                [
                    'name' => $validated['new_category_name'],
                    'description' => $validated['new_category_description'] ?? null,
                    'display_order' => (VillageGalleryCategory::where('village_id', $village->id)->max('display_order') ?? -1) + 1,
                ]
            );

            $categoryId = $category->id;
        }

        $mediaPath = $validated['media_url'] ?? null;
        if ($request->hasFile('media_file')) {
            $mediaPath = $request->file('media_file')->store('villages/gallery', 'public');
        }

        $thumbnailPath = $validated['thumbnail_url'] ?? null;
        if ($request->hasFile('thumbnail_file')) {
            $thumbnailPath = $request->file('thumbnail_file')->store('villages/gallery/thumbnails', 'public');
        } elseif ($validated['type'] === VillageGalleryItem::TYPE_PHOTO) {
            $thumbnailPath = $mediaPath;
        }

        VillageGalleryItem::create([
            'village_id' => $village->id,
            'category_id' => $categoryId,
            'created_by' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'media_path' => $mediaPath,
            'video_url' => $validated['type'] === VillageGalleryItem::TYPE_VIDEO ? $validated['video_url'] : null,
            'thumbnail_path' => $thumbnailPath,
            'taken_at' => $validated['taken_at'] ?? null,
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()
            ->route('admin.desa-management.index')
            ->with('success', 'Konten galeri berhasil ditambahkan.');
    }

    public function destroy(VillageGalleryItem $item): RedirectResponse
    {
        if ($item->media_path && ! str_starts_with($item->media_path, 'http')) {
            Storage::disk('public')->delete($item->media_path);
        }

        if ($item->thumbnail_path && ! str_starts_with($item->thumbnail_path, 'http')) {
            Storage::disk('public')->delete($item->thumbnail_path);
        }

        $item->delete();

        return redirect()
            ->route('admin.desa-management.index')
            ->with('success', 'Item galeri berhasil dihapus.');
    }

    protected function resolveVillage(): Village
    {
        return Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );
    }
}
