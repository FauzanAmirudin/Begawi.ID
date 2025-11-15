<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use App\Models\UmkmProduct;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
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
        
        // Jika tidak ada, ambil UMKM business pertama yang aktif (untuk development)
        return UmkmBusiness::where('status', 'active')->first();
    }

    /**
     * Menampilkan halaman beranda.
     */
    public function index(Request $request): View
    {
        $umkmBusiness = $this->getUmkmBusiness($request);
        
        if (!$umkmBusiness) {
            // Fallback ke data dummy jika tidak ada UMKM business
            return $this->getDummyData($request);
        }

        // Ambil produk dari database
        $query = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->where('is_active', true)
            ->with(['category', 'images'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter search
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->kategori) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        $allProducts = $query->get();
        
        // Konversi ke format array untuk kompatibilitas dengan view
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

        // Produk unggulan
        $produkUnggulan = array_values(array_filter($produkArray, fn($p) => $p['unggulan'] ?? false));

        // Produk terbaru (4 terakhir)
        $produkTerbaru = array_slice(array_reverse($produkArray), 0, 4);

        // Filter search dan kategori untuk semua produk
        $semuaProduk = $produkArray;
        if ($request->search) {
            $semuaProduk = array_filter($semuaProduk, fn($p) => str_contains(strtolower($p['nama']), strtolower($request->search)));
        }
        if ($request->kategori) {
            $semuaProduk = array_filter($semuaProduk, fn($p) => ($p['kategori'] ?? '') == $request->kategori);
        }

        $linkWA = $this->getLinkWA($umkmBusiness);
        
        // Social media dari database
        $socialMedia = $umkmBusiness->social_media ?? [];
        $socials = [
            'instagram' => $socialMedia['instagram'] ?? '#',
            'facebook' => $socialMedia['facebook'] ?? '#',
            'tiktok' => $socialMedia['tiktok'] ?? '#',
            'youtube' => $socialMedia['youtube'] ?? '#',
        ];

        return view('pages.umkm.home', [
            'produkUnggulan' => $produkUnggulan,
            'produkTerbaru' => $produkTerbaru,
            'semuaProduk' => $semuaProduk,
            'linkWA' => $linkWA,
            'socials'=> $socials,
        ]);
    }

    /**
     * Helper untuk Link WA
     */
    private function getLinkWA(?UmkmBusiness $umkmBusiness = null, string $pesan = "Halo, saya tertarik dengan produk Anda."): string
    {
        $nomorWA = $umkmBusiness ? ($umkmBusiness->whatsapp_number ?? $umkmBusiness->owner_phone) : '6281234567890';
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
                'diskon' => ($i % 4 === 0) ? (string)(5 * $i) : null,
                'kategori' => 'kat' . (($i % 3) + 1),
                'stok' => 50 + $i * 5,
                'deskripsi' => "<p>Deskripsi produk Sneaker Model $i. Nyaman dan stylish untuk aktivitas sehari-hari.</p>",
                'galeri_gambar' => [
                    '/assets/Sneaker.png',
                    '/assets/Sneaker.png',
                    '/assets/Sneaker.png',
                    '/assets/Sneaker.png',
                ],
            ];
        }

        $produkUnggulan = array_values(array_filter($produk, fn($p) => $p['unggulan'] ?? false));
        $produkTerbaru = array_slice(array_reverse($produk), 0, 4);
        $semuaProduk = $produk;

        if ($request->search) {
            $semuaProduk = array_filter($semuaProduk, fn($p) => str_contains(strtolower($p['nama']), strtolower($request->search)));
        }
        if ($request->kategori) {
            $semuaProduk = array_filter($semuaProduk, fn($p) => ($p['kategori'] ?? '') == $request->kategori);
        }

        $linkWA = $this->getLinkWA();
        $socials = [
            'instagram' => '#',
            'facebook' => '#',
            'tiktok' => '#',
            'youtube' => '#',
        ];

        return view('pages.umkm.home', [
            'produkUnggulan' => $produkUnggulan,
            'produkTerbaru' => $produkTerbaru,
            'semuaProduk' => $semuaProduk,
            'linkWA' => $linkWA,
            'socials'=> $socials,
        ]);
    }
}

