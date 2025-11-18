<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use App\Models\UmkmContentValidation;
use App\Models\UmkmProduct;
use App\Models\UmkmProductImage;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $allProduk = $this->getAllProdukUmkm();

        $data = [
            'produk' => $this->paginateArray($allProduk, $request, 4),
            'produk_count' => count($allProduk),
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
        $produk = [];

        // Ambil produk dari tabel UmkmProduct (tabel utama)
        $products = UmkmProduct::query()
            ->where('is_active', true)
            ->with(['umkmBusiness.website', 'primaryImage', 'images', 'category'])
            ->whereHas('umkmBusiness', function($query) {
                $query->where('status', 'active');
            })
            ->orderByDesc('created_at')
            ->get();

        foreach ($products as $product) {
            $umkm = $product->umkmBusiness;
            if (!$umkm || $umkm->status !== 'active') {
                continue;
            }

            // Ambil gambar utama
            $primaryImage = $product->primaryImage;
            $gambar = null;
            
            if ($primaryImage) {
                $gambar = $primaryImage->image_path;
            } elseif ($product->images->count() > 0) {
                $gambar = $product->images->first()->image_path;
            }
            
            // Handle image paths
            if ($gambar && !filter_var($gambar, FILTER_VALIDATE_URL)) {
                $gambar = Storage::url($gambar);
            }
            
            if (empty($gambar)) {
                $gambar = 'https://via.placeholder.com/400x400?text=Produk+UMKM';
            }

            // Format gallery images
            $galeriFormatted = [];
            if ($product->images->count() > 0) {
                foreach ($product->images as $img) {
                    $imgPath = $img->image_path;
                    if ($imgPath && !filter_var($imgPath, FILTER_VALIDATE_URL)) {
                        $imgPath = Storage::url($imgPath);
                    }
                    if ($imgPath) {
                        $galeriFormatted[] = $imgPath;
                    }
                }
            }
            
            if (empty($galeriFormatted)) {
                $galeriFormatted = [$gambar];
            }

            // Ambil kategori dari product category atau fallback ke UMKM category
            $kategori = $product->category ? $product->category->name : ($umkm->category ?? 'Umum');

            $harga = $product->discount_price ?? $product->price;
            $stok = $product->stock ?? 0;
            $rating = $product->rating ?? 4.5;
            $terjual = $product->sold_count ?? 0;
            $berat = $product->weight ?? '-';
            $unggulan = $product->is_featured ?? false;

            $produk[] = [
                'id' => $product->id,
                'nama' => $product->title,
                'slug' => $product->slug,
                'kategori' => $kategori,
                'harga' => (int) $harga,
                'harga_format' => 'Rp ' . number_format((float) $harga, 0, ',', '.'),
                'deskripsi' => $product->description ?? '',
                'gambar' => $gambar,
                'galeri' => $galeriFormatted,
                'umkm' => [
                    'nama' => $umkm->name,
                    'slug' => $umkm->slug,
                    'pemilik' => $umkm->owner_name,
                    'kontak' => $umkm->owner_phone,
                    'alamat' => $umkm->address ?? '-',
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

        // Jika tidak ada produk dari UmkmProduct, coba ambil dari UmkmContentValidation sebagai fallback
        if (empty($produk)) {
            $validations = UmkmContentValidation::query()
                ->where('content_type', 'product')
                ->where('status', 'approved')
                ->with(['umkmBusiness.website'])
                ->orderByDesc('created_at')
                ->get();

            foreach ($validations as $validation) {
                $umkm = $validation->umkmBusiness;
                if (!$umkm || $umkm->status !== 'active') {
                    continue;
                }

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
        }

        return $produk;
    }

    private function getKategoriUmkm()
    {
        // Ambil kategori dari product categories yang aktif
        $productCategories = \App\Models\UmkmProductCategory::query()
            ->where('is_active', true)
            ->distinct()
            ->pluck('name')
            ->filter()
            ->toArray();

        // Ambil kategori dari UMKM yang aktif
        $umkmCategories = UmkmBusiness::query()
            ->where('status', 'active')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->toArray();

        // Gabungkan semua kategori
        $kategori = array_unique(array_merge($productCategories, $umkmCategories));

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

            // Hitung jumlah produk aktif dari tabel UmkmProduct
            $produkCount = UmkmProduct::query()
                ->where('umkm_business_id', $umkm->id)
                ->where('is_active', true)
                ->count();

            // Jika tidak ada produk dari UmkmProduct, hitung dari UmkmContentValidation sebagai fallback
            if ($produkCount == 0) {
                $produkCount = UmkmContentValidation::query()
                    ->where('umkm_business_id', $umkm->id)
                    ->where('content_type', 'product')
                    ->where('status', 'approved')
                    ->count();
            }

            // Hitung rating rata-rata dari produk
            $avgRating = UmkmProduct::query()
                ->where('umkm_business_id', $umkm->id)
                ->where('is_active', true)
                ->where('rating', '>', 0)
                ->avg('rating');

            $umkmTerdaftar[] = [
                'nama' => $umkm->name,
                'slug' => $umkm->slug,
                'kategori' => $umkm->category ?? 'Umum',
                'produk_count' => $produkCount,
                'rating' => round($avgRating ?? 4.5, 1),
                'logo' => $logo
            ];
        }

        // Jika tidak ada UMKM, return empty array
        return $umkmTerdaftar;
    }

    private function getProdukBySlug($slug)
    {
        // Cari produk dari tabel UmkmProduct berdasarkan slug
        $product = UmkmProduct::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with(['umkmBusiness.website', 'primaryImage', 'images', 'category'])
            ->whereHas('umkmBusiness', function($query) {
                $query->where('status', 'active');
            })
            ->first();
        
        if ($product) {
            $umkm = $product->umkmBusiness;
            if ($umkm && $umkm->status === 'active') {
                // Ambil gambar utama
                $primaryImage = $product->primaryImage;
                $gambar = null;
                
                if ($primaryImage) {
                    $gambar = $primaryImage->image_path;
                } elseif ($product->images->count() > 0) {
                    $gambar = $product->images->first()->image_path;
                }
                
                if ($gambar && !filter_var($gambar, FILTER_VALIDATE_URL)) {
                    $gambar = Storage::url($gambar);
                }
                
                if (empty($gambar)) {
                    $gambar = 'https://via.placeholder.com/400x400?text=Produk+UMKM';
                }

                // Format gallery images
                $galeriFormatted = [];
                if ($product->images->count() > 0) {
                    foreach ($product->images as $img) {
                        $imgPath = $img->image_path;
                        if ($imgPath && !filter_var($imgPath, FILTER_VALIDATE_URL)) {
                            $imgPath = Storage::url($imgPath);
                        }
                        if ($imgPath) {
                            $galeriFormatted[] = $imgPath;
                        }
                    }
                }
                
                if (empty($galeriFormatted)) {
                    $galeriFormatted = [$gambar];
                }

                // Ambil kategori dari product category atau fallback ke UMKM category
                $kategori = $product->category ? $product->category->name : ($umkm->category ?? 'Umum');

                $harga = $product->discount_price ?? $product->price;
                $stok = $product->stock ?? 0;
                $rating = $product->rating ?? 4.5;
                $terjual = $product->sold_count ?? 0;
                $berat = $product->weight ?? '-';
                $unggulan = $product->is_featured ?? false;

                return [
                    'id' => $product->id,
                    'nama' => $product->title,
                    'slug' => $product->slug,
                    'kategori' => $kategori,
                    'harga' => (int) $harga,
                    'harga_format' => 'Rp ' . number_format((float) $harga, 0, ',', '.'),
                    'deskripsi' => $product->description ?? '',
                    'gambar' => $gambar,
                    'galeri' => $galeriFormatted,
                    'umkm' => [
                        'nama' => $umkm->name,
                        'slug' => $umkm->slug,
                        'pemilik' => $umkm->owner_name,
                        'kontak' => $umkm->owner_phone,
                        'alamat' => $umkm->address ?? '-',
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
        
        // Fallback: cari dari UmkmContentValidation jika tidak ditemukan di UmkmProduct
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
        
        // Fallback terakhir: cari dari array produk
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
            $produk = [];
            
            // Ambil produk dari tabel UmkmProduct
            $products = UmkmProduct::query()
                ->where('umkm_business_id', $umkm->id)
                ->where('is_active', true)
                ->with(['primaryImage', 'images', 'category'])
                ->orderByDesc('created_at')
                ->get();
            
            foreach ($products as $product) {
                // Ambil gambar utama
                $primaryImage = $product->primaryImage;
                $gambar = null;
                
                if ($primaryImage) {
                    $gambar = $primaryImage->image_path;
                } elseif ($product->images->count() > 0) {
                    $gambar = $product->images->first()->image_path;
                }
                
                if ($gambar && !filter_var($gambar, FILTER_VALIDATE_URL)) {
                    $gambar = Storage::url($gambar);
                }
                
                if (empty($gambar)) {
                    $gambar = 'https://via.placeholder.com/400x400?text=Produk+UMKM';
                }

                // Ambil kategori dari product category atau fallback ke UMKM category
                $kategori = $product->category ? $product->category->name : ($umkm->category ?? 'Umum');

                $harga = $product->discount_price ?? $product->price;
                $stok = $product->stock ?? 0;
                $rating = $product->rating ?? 4.5;
                $terjual = $product->sold_count ?? 0;
                $berat = $product->weight ?? '-';
                $unggulan = $product->is_featured ?? false;
                
                $produk[] = [
                    'id' => $product->id,
                    'nama' => $product->title,
                    'slug' => $product->slug,
                    'kategori' => $kategori,
                    'harga' => (int) $harga,
                    'harga_format' => 'Rp ' . number_format((float) $harga, 0, ',', '.'),
                    'deskripsi' => $product->description ?? '',
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
            
            // Jika tidak ada produk dari UmkmProduct, ambil dari UmkmContentValidation sebagai fallback
            if (empty($produk)) {
                $validations = UmkmContentValidation::query()
                    ->where('umkm_business_id', $umkm->id)
                    ->where('content_type', 'product')
                    ->where('status', 'approved')
                    ->orderByDesc('created_at')
                    ->get();
                
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
            }
            
            return $produk;
        }
        
        // Jika UMKM tidak ditemukan, return array kosong
        return [];
    }

    private function paginateArray(array $items, Request $request, int $perPage = 12): LengthAwarePaginator
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $itemsCollection = collect($items);
        $currentItems = $itemsCollection->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $currentItems,
            $itemsCollection->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }
}

