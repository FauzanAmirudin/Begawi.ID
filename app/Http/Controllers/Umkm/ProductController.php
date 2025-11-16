<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use App\Models\UmkmProduct;
use App\Models\UmkmProductCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    /**
     * Mendapatkan UMKM business berdasarkan subdomain atau user login
     */
    protected function getUmkmBusiness(Request $request): ?UmkmBusiness
    {
        // Cek berdasarkan subdomain dari request host
        $host = $request->getHost();
        $subdomain = null;
        
        // Extract subdomain dari host (misal: umkm-name.begawi.id -> umkm-name)
        if (strpos($host, '.') !== false) {
            $parts = explode('.', $host);
            $subdomain = $parts[0];
        }
        
        // Coba cari berdasarkan subdomain
        if ($subdomain) {
            $umkmBusiness = UmkmBusiness::where('subdomain', $subdomain)
                ->where('status', 'active')
                ->first();
            
            if ($umkmBusiness) {
                return $umkmBusiness;
            }
        }
        
        // Fallback: cek berdasarkan user yang login (jika ada)
        if (Auth::check()) {
            $umkmBusiness = UmkmBusiness::where('user_id', Auth::id())
                ->where('status', 'active')
                ->first();
            
            if ($umkmBusiness) {
                return $umkmBusiness;
            }
        }
        
        // Jika tidak ada, ambil UMKM business pertama yang aktif dan memiliki produk aktif (untuk development)
        // Di production, bisa return null atau redirect
        return UmkmBusiness::where('status', 'active')
            ->whereHas('products', function($query) {
                $query->where('is_active', true);
            })
            ->first() 
            ?? UmkmBusiness::where('status', 'active')->first();
    }

    /**
     * Menampilkan halaman katalog (semua produk & unggulan).
     */
    public function index(Request $request)
{
    $umkmBusiness = $this->getUmkmBusiness($request);
    
    if (!$umkmBusiness) {
        // Fallback ke data dummy jika tidak ada UMKM business
        return $this->getDummyData($request);
    }

    // ===========================
    // Query dasar untuk semua produk
    // ===========================
    $allProductsQuery = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
        ->where('is_active', true)
        ->with(['category', 'images'])
        ->orderBy('is_featured', 'desc')
        ->orderBy('created_at', 'desc');

    // ===========================
    // Produk Unggulan (ambil sebelum filter search/kategori)
    // ===========================
    $produkUnggulanQuery = clone $allProductsQuery;
    $produkUnggulanProducts = $produkUnggulanQuery->where('is_featured', true)->get();

    $produkUnggulan = $produkUnggulanProducts->map(function($product) {
        $primaryImage = $product->primaryImage;
        $imagePath = $primaryImage ? Storage::url($primaryImage->image_path) : '/assets/Sneaker.png';
        
        return [
            'id' => $product->id,
            'slug' => $product->slug,
            'nama' => $product->title,
            'harga' => $product->price,
            'harga_diskon' => $product->discount_price,
            'diskon' => $product->discount_percentage > 0 ? (string) $product->discount_percentage : null,
            'gambar' => $imagePath,
            'unggulan' => true,
        ];
    })->toArray();

    // ===========================
    // Filter search & kategori untuk semua produk
    // ===========================
    $query = $allProductsQuery;

    if ($request->search) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->kategori) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('slug', $request->kategori);
        });
    }

    $allProducts = $query->get();

    // Konversi ke array untuk view
    $produkArray = $allProducts->map(function($product) {
        $primaryImage = $product->primaryImage;
        $imagePath = $primaryImage ? Storage::url($primaryImage->image_path) : '/assets/Sneaker.png';
        
        $galleryImages = $product->images->map(function($img) {
            return Storage::url($img->image_path);
        })->toArray();

        if (empty($galleryImages)) {
            $galleryImages = [$imagePath];
        }

        return [
            'id' => $product->id,
            'slug' => $product->slug,
            'nama' => $product->title,
            'harga' => $product->price,
            'harga_diskon' => $product->discount_price,
            'diskon' => $product->discount_percentage > 0 ? (string) $product->discount_percentage : null,
            'gambar' => $imagePath,
            'unggulan' => $product->is_featured,
            'label' => $this->getLabelName($product->labels),
            'label_color' => $this->getLabelColor($product->labels),
            'stok' => $product->stock,
            'kategori' => $product->category ? $product->category->slug : null,
            'kategori_nama' => $product->category ? $product->category->name : 'Uncategorized',
            'deskripsi' => $product->description ?? '<p>Produk berkualitas dari UMKM lokal.</p>',
            'galeri_gambar' => $galleryImages,
        ];
    })->toArray();

    // ===========================
    // Pagination
    // ===========================
    $page = $request->get('page', 1);
    $perPage = 8;
    $collection = collect($produkArray);
    $paginatedProduk = new LengthAwarePaginator(
        $collection->forPage($page, $perPage),
        $collection->count(),
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    // ===========================
    // Ambil kategori untuk filter
    // ===========================
    $kategories = UmkmProductCategory::where('umkm_business_id', $umkmBusiness->id)
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    $linkWA = $this->getLinkWA($umkmBusiness);
    $socials = [
        'instagram' => 'https://instagram.com/umkm',
        'facebook' => 'https://facebook.com/umkm',
        'tiktok' => 'https://tiktok.com/@umkm',
    ];

    return view('pages.umkm.product', [
        'produkUnggulan' => $produkUnggulan,
        'semuaProduk' => $paginatedProduk,
        'kategories' => $kategories,
        'linkWA' => $linkWA,
        'socials' => $socials
    ]);
}


    /**
     * Menampilkan halaman detail satu produk.
     */
    public function show(Request $request, string $id): View
    {
        $umkmBusiness = $this->getUmkmBusiness($request);
        
        if (!$umkmBusiness) {
            abort(404, 'UMKM business tidak ditemukan.');
        }

        // Cari produk berdasarkan ID atau slug
        $product = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->where(function($query) use ($id) {
                if (is_numeric($id)) {
                    $query->where('id', $id);
                } else {
                    $query->where('slug', $id);
                }
            })
            ->where('is_active', true)
            ->with(['category', 'images'])
            ->first();

        if (!$product) {
            abort(404, 'Produk tidak ditemukan.');
        }

        // Increment view count
        $product->increment('view_count');

        // Konversi ke format array untuk kompatibilitas dengan view
        $galleryImages = $product->images->map(function($img) {
            return Storage::url($img->image_path);
        })->toArray();
        
        if (empty($galleryImages)) {
            $galleryImages = ['/assets/Sneaker.png'];
        }

        $produk = (object) [
            'id' => $product->id,
            'slug' => $product->slug,
            'nama' => $product->title,
            'harga' => $product->price,
            'harga_diskon' => $product->discount_price,
            'diskon' => $product->discount_percentage > 0 ? (string) $product->discount_percentage : null,
            'gambar' => !empty($galleryImages) ? $galleryImages[0] : '/assets/Sneaker.png',
            'unggulan' => $product->is_featured,
            'label' => $this->getLabelName($product->labels),
            'label_color' => $this->getLabelColor($product->labels),
            'stok' => $product->stock,
            'kategori' => $product->category ? $product->category->name : 'Uncategorized',
            'deskripsi' => $product->description ?? '<p>Produk berkualitas dari UMKM lokal.</p>',
            'galeri_gambar' => $galleryImages,
            'availability_status' => $product->availability_status,
        ];

        $linkWA = $this->getLinkWA($umkmBusiness);
        $socials = [
            'instagram' => 'https://instagram.com/umkm',
            'facebook' => 'https://facebook.com/umkm',
            'tiktok' => 'https://tiktok.com/@umkm',
        ];

        return view('pages.umkm.product-detail', [
            'produk' => $produk,
            'linkWA' => $linkWA,
            'socials' => $socials
        ]);
    }

    /**
     * Helper untuk Link WA
     */
    private function getLinkWA(?UmkmBusiness $umkmBusiness = null, string $pesan = "Halo, saya tertarik dengan produk Anda."): string
    {
        $nomorWA = $umkmBusiness ? $umkmBusiness->owner_phone : '6281234567890';
        // Bersihkan nomor dari karakter non-numeric
        $nomorWA = preg_replace('/[^0-9]/', '', $nomorWA);
        // Pastikan dimulai dengan 62
        if (!str_starts_with($nomorWA, '62')) {
            if (str_starts_with($nomorWA, '0')) {
                $nomorWA = '62' . substr($nomorWA, 1);
            } else {
                $nomorWA = '62' . $nomorWA;
            }
        }
        $pesanOtomatis = urlencode($pesan);
        return "https://wa.me/{$nomorWA}?text={$pesanOtomatis}";
    }

    /**
     * Helper untuk mendapatkan nama label
     */
    private function getLabelName(?array $labels): ?string
    {
        if (empty($labels)) {
            return null;
        }
        
        $labelMap = [
            'best_seller' => 'Best Seller',
            'new' => 'Baru',
            'promo' => 'Promo',
        ];
        
        foreach ($labels as $label) {
            if (isset($labelMap[$label])) {
                return $labelMap[$label];
            }
        }
        
        return null;
    }

    /**
     * Helper untuk mendapatkan warna label
     */
    private function getLabelColor(?array $labels): ?string
    {
        if (empty($labels)) {
            return null;
        }
        
        $colorMap = [
            'best_seller' => 'bg-accent text-dark',
            'new' => 'bg-blue-500 text-white',
            'promo' => 'bg-red-500 text-white',
        ];
        
        foreach ($labels as $label) {
            if (isset($colorMap[$label])) {
                return $colorMap[$label];
            }
        }
        
        return null;
    }

    /**
     * Fallback ke data dummy jika tidak ada UMKM business
     */
    private function getDummyData(Request $request)
    {
        $produk = [];
        for ($i = 1; $i <= 17; $i++) {
            $produk[$i] = [
                'id' => $i,
                'nama' => "Sneaker Model $i",
                'harga' => (350000 + $i * 10000),
                'gambar' => '/assets/Sneaker.png',
                'unggulan' => $i % 3 === 0,
                'diskon' => ($i % 4 === 0) ? (string) (5 * $i) : null,
                'label' => ($i % 3 === 0) ? 'Best Seller' : (($i % 4 === 0) ? 'Diskon' : null),
                'label_color' => ($i % 3 === 0) ? 'bg-accent text-dark' : (($i % 4 === 0) ? 'bg-red-500 text-white' : null),
                'stok' => 50 + $i * 5,
                'deskripsi' => "<p>Deskripsi produk Sneaker Model $i. Nyaman dan stylish untuk aktivitas sehari-hari.</p>",
                'galeri_gambar' => ['/assets/Sneaker.png', '/assets/Sneaker.png', '/assets/Sneaker.png', '/assets/Sneaker.png'],
            ];
        }

        $produkUnggulan = array_values(array_filter($produk, fn($p) => $p['unggulan'] ?? false));
        $semuaProduk = $produk;

        if ($request->search) {
            $semuaProduk = array_filter($semuaProduk, fn($p) => str_contains(strtolower($p['nama']), strtolower($request->search)));
        }

        $page = $request->get('page', 1);
        $perPage = 8;
        $collection = collect($semuaProduk);
        $paginatedProduk = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $linkWA = $this->getLinkWA();
        $socials = [
            'instagram' => 'https://instagram.com/umkm',
            'facebook' => 'https://facebook.com/umkm',
            'tiktok' => 'https://tiktok.com/@umkm',
        ];

        return view('pages.umkm.product', [
            'produkUnggulan' => $produkUnggulan,
            'semuaProduk' => $paginatedProduk,
            'kategories' => collect([]),
            'linkWA' => $linkWA,
            'socials' => $socials
        ]);
    }
}

