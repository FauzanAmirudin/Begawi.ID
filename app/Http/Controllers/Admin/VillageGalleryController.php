<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Models\VillageGalleryCategory;
use App\Models\VillageGalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

            // Validasi berdasarkan tipe konten
            if ($type === VillageGalleryItem::TYPE_PHOTO) {
                // Untuk foto: harus ada media_file ATAU media_url (tidak keduanya wajib, tapi minimal salah satu)
                if (! $request->hasFile('media_file') && ! $request->filled('media_url')) {
                    $validator->errors()->add('media_file', 'Untuk foto, harap unggah file foto atau masukkan URL foto.');
                }
                // Jika foto, tidak perlu video_url
                if ($request->filled('video_url')) {
                    $validator->errors()->add('video_url', 'URL video tidak diperlukan untuk konten foto.');
                }
            }

            if ($type === VillageGalleryItem::TYPE_VIDEO) {
                // Untuk video: wajib video_url
                if (! $request->filled('video_url')) {
                    $validator->errors()->add('video_url', 'Untuk video, harap masukkan URL video (YouTube, Vimeo, dll).');
                }
                // Jika video, tidak perlu media_file atau media_url
                if ($request->hasFile('media_file')) {
                    $validator->errors()->add('media_file', 'Upload file tidak diperlukan untuk konten video. Gunakan URL video saja.');
                }
                if ($request->filled('media_url')) {
                    $validator->errors()->add('media_url', 'URL media tidak diperlukan untuk konten video. Gunakan URL video saja.');
                }
            }

            // Validasi kategori
            if (! $request->filled('category_id') && ! $request->filled('new_category_name')) {
                $validator->errors()->add('category_id', 'Pilih kategori atau buat kategori baru.');
            }
        });

        if ($validator->fails()) {
            throw (new ValidationException($validator))->errorBag('gallery');
        }

        $validated = $validator->validated();

        try {
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

            // Handle media path berdasarkan tipe
            $mediaPath = null;
            if ($validated['type'] === VillageGalleryItem::TYPE_PHOTO) {
                if ($request->hasFile('media_file')) {
                    $mediaPath = $request->file('media_file')->store('villages/gallery', 'public');
                } elseif (! empty($validated['media_url'])) {
                    $mediaPath = $validated['media_url'];
                }
            }

            // Handle thumbnail
            $thumbnailPath = $validated['thumbnail_url'] ?? null;
            if ($request->hasFile('thumbnail_file')) {
                $thumbnailPath = $request->file('thumbnail_file')->store('villages/gallery/thumbnails', 'public');
            } elseif ($validated['type'] === VillageGalleryItem::TYPE_PHOTO && $mediaPath) {
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
                'video_url' => $validated['type'] === VillageGalleryItem::TYPE_VIDEO ? ($validated['video_url'] ?? null) : null,
                'thumbnail_path' => $thumbnailPath,
                'taken_at' => $validated['taken_at'] ?? null,
                'is_published' => $request->boolean('is_published', true),
            ]);

            return redirect()
                ->route('admin.desa-management.gallery')
                ->with('success', 'Konten galeri berhasil ditambahkan.');
        } catch (\Throwable $exception) {
            Log::error('Failed to save village gallery item', [
                'message' => $exception->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return back()
                ->withInput()
                ->with('open_gallery_modal', true)
                ->with('error', 'Maaf, terjadi kesalahan saat menyimpan konten galeri. Silakan coba kembali.');
        }
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
            ->route('admin.desa-management.gallery')
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
