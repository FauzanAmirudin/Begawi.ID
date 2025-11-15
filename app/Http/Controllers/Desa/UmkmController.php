<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use App\Models\UmkmContentValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    public function index()
    {
        $data = [
            'produk' => $this->getAllProdukUmkm(),
            'kategori' => $this->getKategoriUmkm(),
            'produk_unggulan' => $this->getProdukUnggulan(),
            'umkm_terdaftar' => $this->getUmkmTerdaftar()
        ];
        
        return view('pages.desa.umkm.index', $data);
    }

    public function detail($slug)
    {
        $produk = $this->getProdukBySlug($slug);

        if (!$produk) {
            abort(404);
        }

        $data = [
            'produk' => $produk,
            'produk_terkait' => $this->getProdukTerkait($produk['kategori'], $slug),
            'galeri' => $produk['galeri'] ?? $this->getGaleriProduk($slug)
        ];
        
        return view('pages.desa.umkm.detail', $data);
    }

    public function kategori($kategori)
    {
        $data = [
            'produk' => $this->getProdukByKategori($kategori),
            'kategori' => $kategori,
            'kategori_list' => $this->getKategoriUmkm()
        ];
        
        return view('pages.desa.umkm.kategori', $data);
    }

    public function toko($slug)
    {
        $data = [
            'umkm' => $this->getUmkmBySlug($slug),
            'produk_toko' => $this->getProdukByToko($slug)
        ];
        
        return view('pages.desa.umkm.toko', $data);
    }

    // Helper methods untuk data UMKM
    private function getAllProdukUmkm()
    {
        // Ambil produk yang sudah disetujui dari database
        $validations = UmkmContentValidation::query()
            ->where('content_type', 'product')
            ->where('status', 'approved')
            ->with(['umkmBusiness.website'])
            ->orderByDesc('created_at')
            ->get();

        $produk = [];

        foreach ($validations as $validation) {
            $umkm = $validation->umkmBusiness;
            if (!$umkm || $umkm->status !== 'active') {
                continue; // Skip jika UMKM tidak aktif
            }

            $contentData = $validation->content_data ?? [];
            $gambar = $contentData['image'] ?? $contentData['gambar'] ?? null;
            $galeri = $contentData['gallery'] ?? $contentData['galeri'] ?? [];
            
            // Handle image paths
            if ($gambar && !filter_var($gambar, FILTER_VALIDATE_URL)) {
                $gambar = Storage::url($gambar);
            }
            
            if (empty($gambar)) {
                $gambar = 'https://via.placeholder.com/400x400?text=Produk+UMKM';
            }

            // Format gallery images
            $galeriFormatted = [];
            if (is_array($galeri) && !empty($galeri)) {
                foreach ($galeri as $img) {
                    if (!filter_var($img, FILTER_VALIDATE_URL)) {
                        $img = Storage::url($img);
                    }
                    $galeriFormatted[] = $img;
                }
            }
            
            if (empty($galeriFormatted)) {
                $galeriFormatted = [$gambar];
            }

            $harga = $contentData['price'] ?? $contentData['harga'] ?? 0;
            $stok = $contentData['stock'] ?? $contentData['stok'] ?? 0;
            $rating = $contentData['rating'] ?? 4.5;
            $terjual = $contentData['sold'] ?? $contentData['terjual'] ?? 0;
            $berat = $contentData['weight'] ?? $contentData['berat'] ?? '-';
            $unggulan = $contentData['featured'] ?? $contentData['unggulan'] ?? false;

            $produk[] = [
                'id' => $validation->id,
                'nama' => $validation->title,
                'slug' => Str::slug($validation->title) . '-' . $validation->id,
                'kategori' => $umkm->category,
                'harga' => (int) $harga,
                'harga_format' => 'Rp ' . number_format($harga, 0, ',', '.'),
                'deskripsi' => $validation->description ?? $contentData['description'] ?? '',
                'gambar' => $gambar,
                'galeri' => $galeriFormatted,
                'umkm' => [
                    'nama' => $umkm->name,
                    'slug' => $umkm->slug,
                    'pemilik' => $umkm->owner_name,
                    'kontak' => $umkm->owner_phone,
                    'alamat' => $umkm->address ?? $contentData['address'] ?? '-',
                    'deskripsi' => $umkm->description ?? '',
                    'website_url' => $umkm->website 
                        ? ($umkm->website->custom_domain ? 'http://' . $umkm->website->custom_domain : 'http://' . $umkm->website->url)
                        : ($umkm->subdomain ? 'http://' . $umkm->subdomain : route('umkm.home'))
                ],
                'rating' => (float) $rating,
                'terjual' => (int) $terjual,
                'stok' => (int) $stok,
                'berat' => $berat,
                'unggulan' => (bool) $unggulan
            ];
        }

        // Jika tidak ada produk dari database, return empty array atau fallback ke dummy data
        if (empty($produk)) {
            return $this->getDummyProduk();
        }

        return $produk;
    }

    private function getDummyProduk()
    {
        // Fallback dummy data jika belum ada produk di database
        return [];
    }

    private function getKategoriUmkm()
    {
        // Ambil kategori dari UMKM yang aktif
        $kategori = UmkmBusiness::query()
            ->where('status', 'active')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->toArray();

        // Tambahkan kategori default jika belum ada
        $defaultKategori = [
            'Makanan & Minuman',
            'Kerajinan & Fashion',
            'Kesehatan & Herbal',
            'Pertanian & Perkebunan',
            'Teknologi & Digital',
            'Jasa & Layanan'
        ];

        $allKategori = array_unique(array_merge(['Semua Kategori'], $kategori, $defaultKategori));
        
        return array_values($allKategori);
    }

    private function getProdukUnggulan()
    {
        return collect($this->getAllProdukUmkm())->where('unggulan', true)->values()->toArray();
    }

    private function getUmkmTerdaftar()
    {
        // Ambil UMKM yang aktif dari database
        $umkmList = UmkmBusiness::query()
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get();

        $umkmTerdaftar = [];

        foreach ($umkmList as $umkm) {
            $logo = $umkm->logo_path;
            if ($logo && !filter_var($logo, FILTER_VALIDATE_URL)) {
                $logo = Storage::url($logo);
            }
            
            if (empty($logo)) {
                $logo = 'https://via.placeholder.com/100x100?text=' . urlencode(substr($umkm->name, 0, 2));
            }

            // Hitung jumlah produk yang sudah disetujui
            $produkCount = UmkmContentValidation::query()
                ->where('umkm_business_id', $umkm->id)
                ->where('content_type', 'product')
                ->where('status', 'approved')
                ->count();

            $umkmTerdaftar[] = [
                'nama' => $umkm->name,
                'slug' => $umkm->slug,
                'kategori' => $umkm->category,
                'produk_count' => $produkCount,
                'rating' => 4.5, // Default rating, bisa diambil dari produk jika ada
                'logo' => $logo
            ];
        }

        // Jika tidak ada UMKM, return empty array
        return $umkmTerdaftar;
    }

    private function getProdukBySlug($slug)
    {
        // Extract ID from slug (format: nama-produk-123)
        $parts = explode('-', $slug);
        $id = end($parts);
        
        if (is_numeric($id)) {
            $validation = UmkmContentValidation::query()
                ->where('id', $id)
                ->where('content_type', 'product')
                ->where('status', 'approved')
                ->with(['umkmBusiness'])
                ->first();
            
            if ($validation) {
                $umkm = $validation->umkmBusiness;
                if ($umkm && $umkm->status === 'active') {
                    $contentData = $validation->content_data ?? [];
                    $gambar = $contentData['image'] ?? $contentData['gambar'] ?? null;
                    $galeri = $contentData['gallery'] ?? $contentData['galeri'] ?? [];
                    
                    if ($gambar && !filter_var($gambar, FILTER_VALIDATE_URL)) {
                        $gambar = Storage::url($gambar);
                    }
                    
                    if (empty($gambar)) {
                        $gambar = 'https://via.placeholder.com/400x400?text=Produk+UMKM';
                    }

                    $galeriFormatted = [];
                    if (is_array($galeri) && !empty($galeri)) {
                        foreach ($galeri as $img) {
                            if (!filter_var($img, FILTER_VALIDATE_URL)) {
                                $img = Storage::url($img);
                            }
                            $galeriFormatted[] = $img;
                        }
                    }
                    
                    if (empty($galeriFormatted)) {
                        $galeriFormatted = [$gambar];
                    }

                    $harga = $contentData['price'] ?? $contentData['harga'] ?? 0;
                    $stok = $contentData['stock'] ?? $contentData['stok'] ?? 0;
                    $rating = $contentData['rating'] ?? 4.5;
                    $terjual = $contentData['sold'] ?? $contentData['terjual'] ?? 0;
                    $berat = $contentData['weight'] ?? $contentData['berat'] ?? '-';
                    $unggulan = $contentData['featured'] ?? $contentData['unggulan'] ?? false;

                    return [
                        'id' => $validation->id,
                        'nama' => $validation->title,
                        'slug' => $slug,
                        'kategori' => $umkm->category,
                        'harga' => (int) $harga,
                        'harga_format' => 'Rp ' . number_format($harga, 0, ',', '.'),
                        'deskripsi' => $validation->description ?? $contentData['description'] ?? '',
                        'gambar' => $gambar,
                        'galeri' => $galeriFormatted,
                        'umkm' => [
                            'nama' => $umkm->name,
                            'slug' => $umkm->slug,
                            'pemilik' => $umkm->owner_name,
                            'kontak' => $umkm->owner_phone,
                            'alamat' => $umkm->address ?? $contentData['address'] ?? '-',
                            'deskripsi' => $umkm->description ?? '',
                            'website_url' => $umkm->website 
                                ? ($umkm->website->custom_domain ? 'http://' . $umkm->website->custom_domain : 'http://' . $umkm->website->url)
                                : ($umkm->subdomain ? 'http://' . $umkm->subdomain : route('umkm.home'))
                        ],
                        'rating' => (float) $rating,
                        'terjual' => (int) $terjual,
                        'stok' => (int) $stok,
                        'berat' => $berat,
                        'unggulan' => (bool) $unggulan
                    ];
                }
            }
        }
        
        // Fallback ke method lama
        return collect($this->getAllProdukUmkm())->firstWhere('slug', $slug);
    }

    private function getProdukTerkait($kategori = null, $excludeSlug = null)
    {
        $produk = collect($this->getAllProdukUmkm());

        if ($kategori) {
            $produk = $produk->where('kategori', $kategori);
        }

        if ($excludeSlug) {
            $produk = $produk->reject(fn ($item) => $item['slug'] === $excludeSlug);
        }

        return $produk->take(4)->values()->toArray();
    }

    private function getGaleriProduk($slug)
    {
        $produk = $this->getProdukBySlug($slug);
        return $produk ? $produk['galeri'] : [];
    }

    private function getProdukByKategori($kategori)
    {
        if ($kategori === 'semua-kategori') {
            return $this->getAllProdukUmkm();
        }
        
        $kategoriMap = [
            'makanan-minuman' => 'Makanan & Minuman',
            'kerajinan-fashion' => 'Kerajinan & Fashion',
            'kesehatan-herbal' => 'Kesehatan & Herbal',
            'pertanian-perkebunan' => 'Pertanian & Perkebunan',
            'teknologi-digital' => 'Teknologi & Digital',
            'jasa-layanan' => 'Jasa & Layanan'
        ];
        
        $kategoriName = $kategoriMap[$kategori] ?? '';
        return collect($this->getAllProdukUmkm())->where('kategori', $kategoriName)->values()->toArray();
    }

    private function getUmkmBySlug($slug)
    {
        // Ambil UMKM dari database
        $umkm = UmkmBusiness::query()
            ->where('slug', $slug)
            ->where('status', 'active')
            ->first();
        
        if ($umkm) {
            $logo = $umkm->logo_path;
            if ($logo && !filter_var($logo, FILTER_VALIDATE_URL)) {
                $logo = Storage::url($logo);
            }
            
            // Get website URL
            $websiteUrl = route('umkm.home');
            if ($umkm->website) {
                $websiteUrl = $umkm->website->custom_domain 
                    ? 'http://' . $umkm->website->custom_domain 
                    : 'http://' . $umkm->website->url;
            } elseif ($umkm->subdomain) {
                $websiteUrl = 'http://' . $umkm->subdomain;
            }
            
            return [
                'nama' => $umkm->name,
                'slug' => $umkm->slug,
                'pemilik' => $umkm->owner_name,
                'kontak' => $umkm->owner_phone,
                'email' => $umkm->owner_email,
                'alamat' => $umkm->address ?? '-',
                'deskripsi' => $umkm->description ?? '',
                'kategori' => $umkm->category,
                'logo' => $logo ?? 'https://via.placeholder.com/200x200?text=' . urlencode(substr($umkm->name, 0, 2)),
                'subdomain' => $umkm->subdomain,
                'website_url' => $websiteUrl,
            ];
        }
        
        // Fallback ke method lama
        $produk = collect($this->getAllProdukUmkm())->firstWhere('umkm.slug', $slug);
        return $produk ? $produk['umkm'] : null;
    }

    private function getProdukByToko($slug)
    {
        // Ambil produk dari UMKM tertentu
        $umkm = UmkmBusiness::query()
            ->where('slug', $slug)
            ->where('status', 'active')
            ->first();
        
        if ($umkm) {
            $validations = UmkmContentValidation::query()
                ->where('umkm_business_id', $umkm->id)
                ->where('content_type', 'product')
                ->where('status', 'approved')
                ->orderByDesc('created_at')
                ->get();
            
            $produk = [];
            
            foreach ($validations as $validation) {
                $contentData = $validation->content_data ?? [];
                $gambar = $contentData['image'] ?? $contentData['gambar'] ?? null;
                
                if ($gambar && !filter_var($gambar, FILTER_VALIDATE_URL)) {
                    $gambar = Storage::url($gambar);
                }
                
                if (empty($gambar)) {
                    $gambar = 'https://via.placeholder.com/400x400?text=Produk+UMKM';
                }
                
                $harga = $contentData['price'] ?? $contentData['harga'] ?? 0;
                $stok = $contentData['stock'] ?? $contentData['stok'] ?? 0;
                $rating = $contentData['rating'] ?? 4.5;
                $terjual = $contentData['sold'] ?? $contentData['terjual'] ?? 0;
                $berat = $contentData['weight'] ?? $contentData['berat'] ?? '-';
                $unggulan = $contentData['featured'] ?? $contentData['unggulan'] ?? false;
                
                $produk[] = [
                    'id' => $validation->id,
                    'nama' => $validation->title,
                    'slug' => Str::slug($validation->title) . '-' . $validation->id,
                    'kategori' => $umkm->category,
                    'harga' => (int) $harga,
                    'harga_format' => 'Rp ' . number_format($harga, 0, ',', '.'),
                    'deskripsi' => $validation->description ?? $contentData['description'] ?? '',
                    'gambar' => $gambar,
                    'umkm' => [
                        'nama' => $umkm->name,
                        'slug' => $umkm->slug,
                        'pemilik' => $umkm->owner_name,
                        'kontak' => $umkm->owner_phone,
                        'website_url' => $umkm->website 
                            ? ($umkm->website->custom_domain ? 'http://' . $umkm->website->custom_domain : 'http://' . $umkm->website->url)
                            : ($umkm->subdomain ? 'http://' . $umkm->subdomain : route('umkm.home'))
                    ],
                    'rating' => (float) $rating,
                    'terjual' => (int) $terjual,
                    'stok' => (int) $stok,
                    'berat' => $berat,
                    'unggulan' => (bool) $unggulan
                ];
            }
            
            return $produk;
        }
        
        // Jika UMKM tidak ditemukan, return array kosong
        return [];
    }
}

