<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Models\VillageGalleryCategory;
use App\Models\VillageGalleryItem;
use App\Models\VillagePotential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class GaleriWisataController extends Controller
{
    protected ?Village $villageModel = null;

    protected function village(): Village
    {
        if ($this->villageModel === null) {
            $this->villageModel = Village::query()
                ->firstOrCreate(
                    ['slug' => 'desa-sejahtera'],
                    ['name' => 'Desa Sejahtera']
                );
        }

        return $this->villageModel;
    }

    protected function mediaUrl(?string $path, string $default = ''): string
    {
        if (empty($path)) {
            return $default;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return Storage::url($path);
    }

    public function index()
    {
        $village = $this->village();
        
        // Ambil galeri terbaru untuk ditampilkan di halaman utama galeri
        $galleryItems = $village->galleryItems()
            ->where('is_published', true)
            ->with('category')
            ->orderByRaw('COALESCE(taken_at, created_at) DESC')
            ->take(12)
            ->get()
            ->map(function (VillageGalleryItem $item) {
                $takenAt = $item->taken_at ? \Carbon\Carbon::parse($item->taken_at) : null;
                $createdAt = \Carbon\Carbon::parse($item->created_at);
                
                return [
                    'id' => $item->id,
                    'judul' => $item->title,
                    'gambar' => $this->mediaUrl($item->thumbnail_path ?? $item->media_path, 'https://via.placeholder.com/400x400'),
                    'gambar_full' => $this->mediaUrl($item->media_path, 'https://via.placeholder.com/1200x800'),
                    'kategori' => $item->category ? $item->category->name : 'Umum',
                    'kategori_slug' => $item->category ? $item->category->slug : 'umum',
                    'tahun' => $takenAt ? $takenAt->format('Y') : $createdAt->format('Y'),
                    'tanggal' => $takenAt ? $takenAt->format('d M Y') : $createdAt->format('d M Y'),
                    'deskripsi' => $item->description,
                    'type' => $item->type,
                ];
            });

        // Ambil statistik
        $totalFoto = $village->galleryItems()
            ->where('is_published', true)
            ->where('type', VillageGalleryItem::TYPE_PHOTO)
            ->count();
            
        $totalVideo = $village->galleryItems()
            ->where('is_published', true)
            ->where('type', VillageGalleryItem::TYPE_VIDEO)
            ->count();

        // Ambil data wisata dari database
        $wisataItems = $village->potentials()
            ->where('status', VillagePotential::STATUS_ACTIVE)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function (VillagePotential $item) {
                return [
                    'id' => $item->id,
                    'slug' => $item->slug,
                    'judul' => $item->title,
                    'kategori' => $item->category ?? 'Wisata Alam',
                    'gambar' => $this->mediaUrl($item->featured_image, 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=400&fit=crop'),
                    'ringkasan' => $item->summary,
                    'deskripsi' => $item->description,
                    'map_embed' => $item->map_embed,
                ];
            });

        return view('pages.desa.galeri-wisata.index', [
            'galleryItems' => $galleryItems,
            'totalFoto' => $totalFoto,
            'totalVideo' => $totalVideo,
            'wisataItems' => $wisataItems,
        ]);
    }

    public function galeriFoto(Request $request)
    {
        $village = $this->village();
        
        // Query untuk mengambil semua foto
        $query = $village->galleryItems()
            ->where('is_published', true)
            ->where('type', VillageGalleryItem::TYPE_PHOTO)
            ->with('category')
            ->orderByRaw('COALESCE(taken_at, created_at) DESC');

        // Filter berdasarkan kategori (menggunakan category_id melalui relasi)
        if ($request->has('kategori') && $request->kategori) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->kategori)
                  ->orWhere('name', $request->kategori);
            });
        }

        // Filter berdasarkan tahun
        if ($request->has('tahun') && $request->tahun) {
            $query->whereYear('taken_at', $request->tahun);
        }

        // Pagination
        $fotos = $query->paginate(24)->withQueryString();

        // Format data foto
        $fotos->getCollection()->transform(function (VillageGalleryItem $item) {
            $takenAt = $item->taken_at ? \Carbon\Carbon::parse($item->taken_at) : null;
            $createdAt = \Carbon\Carbon::parse($item->created_at);
            
            return [
                'id' => $item->id,
                'judul' => $item->title,
                'gambar' => $this->mediaUrl($item->thumbnail_path ?? $item->media_path, 'https://via.placeholder.com/400x400'),
                'gambar_full' => $this->mediaUrl($item->media_path, 'https://via.placeholder.com/1200x800'),
                'kategori' => $item->category ? $item->category->name : 'Umum',
                'kategori_slug' => $item->category ? $item->category->slug : 'umum',
                'tahun' => $takenAt ? $takenAt->format('Y') : $createdAt->format('Y'),
                'tanggal' => $takenAt ? $takenAt->format('d M Y') : $createdAt->format('d M Y'),
                'deskripsi' => $item->description,
            ];
        });

        // Ambil daftar kategori dan tahun untuk filter
        $kategoris = $village->galleryItems()
            ->where('is_published', true)
            ->where('type', VillageGalleryItem::TYPE_PHOTO)
            ->whereHas('category')
            ->with('category')
            ->get()
            ->pluck('category.name')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $tahuns = $village->galleryItems()
            ->where('is_published', true)
            ->where('type', VillageGalleryItem::TYPE_PHOTO)
            ->whereNotNull('taken_at')
            ->selectRaw('YEAR(taken_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->filter()
            ->values();

        // Jika tidak ada tahun dari taken_at, ambil dari created_at
        if ($tahuns->isEmpty()) {
            $tahuns = $village->galleryItems()
                ->where('is_published', true)
                ->where('type', VillageGalleryItem::TYPE_PHOTO)
                ->selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderByDesc('year')
                ->pluck('year')
                ->filter()
                ->values();
        }

        return view('pages.desa.galeri-wisata.galeri-foto', [
            'fotos' => $fotos,
            'kategoris' => $kategoris,
            'tahuns' => $tahuns,
            'kategori_selected' => $request->kategori ?? '',
            'tahun_selected' => $request->tahun ?? '',
        ]);
    }

    public function uploadStore(Request $request)
    {
        $village = $this->village();

        $currentYear = (int) now()->addYear()->format('Y');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:jpeg,jpg,png,gif', 'max:6144'],
            'category' => ['required', 'string', 'max:100'],
            'year' => ['required', 'integer', 'min:2000', "max:{$currentYear}"],
        ]);

        try {
            $category = VillageGalleryCategory::firstOrCreate(
                [
                    'village_id' => $village->id,
                    'slug' => Str::slug($validated['category']),
                ],
                [
                    'name' => Str::title($validated['category']),
                    'description' => null,
                    'display_order' => (VillageGalleryCategory::where('village_id', $village->id)->max('display_order') ?? -1) + 1,
                ]
            );

            $mediaPath = $request->file('file')->store('villages/gallery', 'public');

            VillageGalleryItem::create([
                'village_id' => $village->id,
                'category_id' => $category->id,
                'created_by' => null,
                'title' => $validated['title'],
                'description' => null,
                'type' => VillageGalleryItem::TYPE_PHOTO,
                'media_path' => $mediaPath,
                'thumbnail_path' => $mediaPath,
                'taken_at' => Carbon::createFromDate((int) $validated['year'], 1, 1),
                'is_published' => true,
            ]);

            return redirect()
                ->route('desa.galeri-wisata.index')
                ->with('success', '✅ Foto berhasil diunggah dan menunggu persetujuan admin desa.');
        } catch (\Throwable $e) {
            Log::error('Gagal mengunggah galeri desa', [
                'message' => $e->getMessage(),
            ]);

            return back()
                ->withInput($request->except('file'))
                ->with('error', 'Maaf, terjadi kesalahan saat menyimpan foto. Silakan coba kembali.');
        }
    }

    public function detailWisata(string $slug)
    {
        $village = $this->village();
        
        $wisata = $village->potentials()
            ->where('slug', $slug)
            ->where('status', VillagePotential::STATUS_ACTIVE)
            ->firstOrFail();

        // Ambil wisata terkait (dari kategori yang sama)
        $relatedWisata = $village->potentials()
            ->where('status', VillagePotential::STATUS_ACTIVE)
            ->where('id', '!=', $wisata->id)
            ->where('category', $wisata->category)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function (VillagePotential $item) {
                return [
                    'id' => $item->id,
                    'slug' => $item->slug,
                    'judul' => $item->title,
                    'kategori' => $item->category ?? 'Wisata Alam',
                    'gambar' => $this->mediaUrl($item->featured_image, 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=400&fit=crop'),
                    'ringkasan' => $item->summary,
                ];
            });

        return view('pages.desa.galeri-wisata.detail', [
            'wisata' => [
                'id' => $wisata->id,
                'slug' => $wisata->slug,
                'judul' => $wisata->title,
                'kategori' => $wisata->category ?? 'Wisata Alam',
                'gambar' => $this->mediaUrl($wisata->featured_image, 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&h=600&fit=crop'),
                'ringkasan' => $wisata->summary,
                'deskripsi' => $wisata->description,
                'map_embed' => $wisata->map_embed,
                'status' => $wisata->status,
            ],
            'relatedWisata' => $relatedWisata,
        ]);
    }
}