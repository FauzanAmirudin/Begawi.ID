<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return [
            [
                'id' => 1,
                'nama' => 'Keripik Singkong Renyah Original',
                'slug' => 'keripik-singkong-renyah-original',
                'kategori' => 'Makanan & Minuman',
                'harga' => 15000,
                'harga_format' => 'Rp 15.000',
                'deskripsi' => 'Keripik singkong dengan cita rasa gurih dan renyah, dibuat dari singkong pilihan dengan resep turun temurun.',
                'gambar' => 'https://via.placeholder.com/400x400',
                'galeri' => [
                    'https://via.placeholder.com/400x400',
                    'https://via.placeholder.com/400x400',
                    'https://via.placeholder.com/400x400'
                ],
                'umkm' => [
                    'nama' => 'UD Berkah Jaya',
                    'slug' => 'ud-berkah-jaya',
                    'pemilik' => 'Ibu Siti Nurhaliza',
                    'kontak' => '081234567890',
                    'alamat' => 'Jl. Desa Sejahtera RT 02/01',
                    'deskripsi' => 'UMKM keluarga yang bergerak di bidang makanan ringan tradisional sejak 2015.'
                ],
                'rating' => 4.8,
                'terjual' => 156,
                'stok' => 25,
                'berat' => '250gr',
                'unggulan' => true
            ],
            [
                'id' => 2,
                'nama' => 'Madu Hutan Asli Murni',
                'slug' => 'madu-hutan-asli-murni',
                'kategori' => 'Kesehatan & Herbal',
                'harga' => 45000,
                'harga_format' => 'Rp 45.000',
                'deskripsi' => 'Madu murni dari hutan lindung sekitar desa, dipanen secara tradisional tanpa campuran apapun.',
                'gambar' => 'https://via.placeholder.com/400x400',
                'galeri' => [
                    'https://via.placeholder.com/400x400',
                    'https://via.placeholder.com/400x400',
                    'https://via.placeholder.com/400x400'
                ],
                'umkm' => [
                    'nama' => 'Madu Sari Desa',
                    'slug' => 'madu-sari-desa',
                    'pemilik' => 'Bapak Ahmad Maulana',
                    'kontak' => '081234567891',
                    'alamat' => 'Jl. Hutan Lindung RT 03/02',
                    'deskripsi' => 'Spesialis madu hutan asli dengan pengalaman lebah ternak selama 10 tahun.'
                ],
                'rating' => 4.9,
                'terjual' => 89,
                'stok' => 12,
                'berat' => '500ml',
                'unggulan' => true
            ],
            [
                'id' => 3,
                'nama' => 'Batik Tulis Motif Daun Padi',
                'slug' => 'batik-tulis-motif-daun-padi',
                'kategori' => 'Kerajinan & Fashion',
                'harga' => 125000,
                'harga_format' => 'Rp 125.000',
                'deskripsi' => 'Kain batik tulis dengan motif khas desa yang terinspirasi dari tanaman padi dan alam sekitar.',
                'gambar' => 'https://via.placeholder.com/400x400',
                'galeri' => [
                    'https://via.placeholder.com/400x400',
                    'https://via.placeholder.com/400x400',
                    'https://via.placeholder.com/400x400'
                ],
                'umkm' => [
                    'nama' => 'Batik Nusantara',
                    'slug' => 'batik-nusantara',
                    'pemilik' => 'Ibu Dewi Sartika',
                    'kontak' => '081234567892',
                    'alamat' => 'Jl. Kerajinan RT 01/03',
                    'deskripsi' => 'Pengrajin batik tulis dengan motif-motif khas daerah sejak 2010.'
                ],
                'rating' => 4.7,
                'terjual' => 34,
                'stok' => 8,
                'berat' => '200gr',
                'unggulan' => false
            ],
            [
                'id' => 4,
                'nama' => 'Dodol Durian Premium',
                'slug' => 'dodol-durian-premium',
                'kategori' => 'Makanan & Minuman',
                'harga' => 25000,
                'harga_format' => 'Rp 25.000',
                'deskripsi' => 'Dodol durian dengan rasa manis legit, dibuat dari durian lokal pilihan dengan tekstur lembut.',
                'gambar' => 'https://via.placeholder.com/400x400',
                'galeri' => [
                    'https://via.placeholder.com/400x400',
                    'https://via.placeholder.com/400x400',
                    'https://via.placeholder.com/400x400'
                ],
                'umkm' => [
                    'nama' => 'Dodol Pak Haji',
                    'slug' => 'dodol-pak-haji',
                    'pemilik' => 'H. Bambang Suryanto',
                    'kontak' => '081234567893',
                    'alamat' => 'Jl. Manis Jaya RT 04/01',
                    'deskripsi' => 'Produsen dodol tradisional dengan berbagai varian rasa sejak 1995.'
                ],
                'rating' => 4.8,
                'terjual' => 267,
                'stok' => 45,
                'berat' => '300gr',
                'unggulan' => true
            ],
            [
                'id' => 5,
                'nama' => 'Kopi Robusta Giling Halus',
                'slug' => 'kopi-robusta-giling-halus',
                'kategori' => 'Makanan & Minuman',
                'harga' => 35000,
                'harga_format' => 'Rp 35.000',
                'deskripsi' => 'Kopi robusta premium dari kebun kopi lokal, dipanggang dan digiling dengan teknologi modern.',
                'gambar' => 'https://via.placeholder.com/400x400',
                'galeri' => [
                    'https://via.placeholder.com/400x400',
                    'https://via.placeholder.com/400x400',
                    'https://via.placeholder.com/400x400'
                ],
                'umkm' => [
                    'nama' => 'Kopi Gunung Sari',
                    'slug' => 'kopi-gunung-sari',
                    'pemilik' => 'Bapak Joko Widodo',
                    'kontak' => '081234567894',
                    'alamat' => 'Jl. Kebun Kopi RT 05/02',
                    'deskripsi' => 'Petani dan pengolah kopi dengan kebun seluas 2 hektar di lereng gunung.'
                ],
                'rating' => 4.9,
                'terjual' => 198,
                'stok' => 30,
                'berat' => '250gr',
                'unggulan' => true
            ],
            [
                'id' => 6,
                'nama' => 'Tas Anyaman Pandan Cantik',
                'slug' => 'tas-anyaman-pandan-cantik',
                'kategori' => 'Kerajinan & Fashion',
                'harga' => 75000,
                'harga_format' => 'Rp 75.000',
                'deskripsi' => 'Tas anyaman dari pandan alami dengan desain modern, cocok untuk sehari-hari maupun acara formal.',
                'gambar' => 'https://via.placeholder.com/400x400',
                'galeri' => [
                    'https://via.placeholder.com/400x400',
                    'https://via.placeholder.com/400x400',
                    'https://via.placeholder.com/400x400'
                ],
                'umkm' => [
                    'nama' => 'Kerajinan Ibu-Ibu',
                    'slug' => 'kerajinan-ibu-ibu',
                    'pemilik' => 'Ibu Rina Melati',
                    'kontak' => '081234567895',
                    'alamat' => 'Jl. Anyaman Indah RT 02/03',
                    'deskripsi' => 'Kelompok kerajinan ibu-ibu PKK yang menghasilkan berbagai produk anyaman.'
                ],
                'rating' => 4.7,
                'terjual' => 78,
                'stok' => 15,
                'berat' => '400gr',
                'unggulan' => false
            ]
        ];
    }

    private function getKategoriUmkm()
    {
        return [
            'Semua Kategori',
            'Makanan & Minuman',
            'Kerajinan & Fashion',
            'Kesehatan & Herbal',
            'Pertanian & Perkebunan',
            'Teknologi & Digital',
            'Jasa & Layanan'
        ];
    }

    private function getProdukUnggulan()
    {
        return collect($this->getAllProdukUmkm())->where('unggulan', true)->values()->toArray();
    }

    private function getUmkmTerdaftar()
    {
        return [
            [
                'nama' => 'UD Berkah Jaya',
                'slug' => 'ud-berkah-jaya',
                'kategori' => 'Makanan & Minuman',
                'produk_count' => 8,
                'rating' => 4.8,
                'logo' => 'https://via.placeholder.com/100x100'
            ],
            [
                'nama' => 'Madu Sari Desa',
                'slug' => 'madu-sari-desa', 
                'kategori' => 'Kesehatan & Herbal',
                'produk_count' => 5,
                'rating' => 4.9,
                'logo' => 'https://via.placeholder.com/100x100'
            ],
            [
                'nama' => 'Batik Nusantara',
                'slug' => 'batik-nusantara',
                'kategori' => 'Kerajinan & Fashion',
                'produk_count' => 12,
                'rating' => 4.7,
                'logo' => 'https://via.placeholder.com/100x100'
            ]
        ];
    }

    private function getProdukBySlug($slug)
    {
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
        $produk = collect($this->getAllProdukUmkm())->firstWhere('umkm.slug', $slug);
        return $produk ? $produk['umkm'] : null;
    }

    private function getProdukByToko($slug)
    {
        return collect($this->getAllProdukUmkm())->where('umkm.slug', $slug)->values()->toArray();
    }
}

