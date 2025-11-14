<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class ProductController extends Controller
{
    /**
     * Menampilkan halaman katalog (semua produk & unggulan).
     */
    public function index(Request $request)
    {
        $allProducts = $this->getSemuaProduk(); // Semua produk asli
        $semuaProduk = $allProducts;

        // Produk unggulan selalu dari semua produk asli
        $produkUnggulan = array_values(array_filter($allProducts, fn($p) => $p['unggulan'] ?? false));

        // Filter search
        if ($request->search) {
            $semuaProduk = array_filter($semuaProduk, fn($p) => str_contains(strtolower($p['nama']), strtolower($request->search)));
        }

        // Filter kategori
        if ($request->kategori) {
            $semuaProduk = array_filter($semuaProduk, fn($p) => ($p['kategori'] ?? '') == $request->kategori);
        }

        // Pagination manual
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
            'linkWA' => $linkWA,
            'socials' => $socials
        ]);
    }

    /**
     * Menampilkan halaman detail satu produk.
     */
    public function show(string $id): View
    {
        $produk = $this->findProdukById($id);

        if (!$produk) {
            abort(404); // Tampilkan 404 jika produk tidak ada
        }

        // Siapkan link WA (asumsi dari layout)
        $linkWA = $this->getLinkWA();
        $socials = [
            'instagram' => 'https://instagram.com/umkm',
            'facebook' => 'https://facebook.com/umkm',
            'tiktok' => 'https://tiktok.com/@umkm',
        ];

        return view('pages.umkm.product-detail', [
            'produk' => (object) $produk,
            'linkWA' => $linkWA,
            'socials' => $socials
        ]);
        
    }

    // --- DATABASE TIRUAN ---

    /**
     * Helper untuk mencari produk berdasarkan ID.
     */
    private function findProdukById(string $id): ?array
    {
        return Arr::first($this->getSemuaProduk(), function ($produk) use ($id) {
            return $produk['id'] == $id;
        });
    }

    /**
     * Helper untuk Link WA (agar konsisten).
     */
    private function getLinkWA(string $pesan = "Halo, saya tertarik dengan produk Anda."): string
    {
        $nomorWA = '6281234567890'; // Ganti dengan nomor Anda
        $pesanOtomatis = urlencode($pesan);
        return "https://wa.me/{$nomorWA}?text={$pesanOtomatis}";
    }

    /**
     * Data master semua produk (database tiruan).
     */
    private function getSemuaProduk(): array
    {
        $produk = [];

        for ($i = 1; $i <= 17; $i++) {
            $produk[$i] = [
                'id' => $i,
                'nama' => "Sneaker Model $i",
                'harga' => (350000 + $i * 10000), // variasi harga
                'gambar' => '/assets/Sneaker.png',
                'unggulan' => $i % 3 === 0, // setiap 3 produk jadi unggulan
                'diskon' => ($i % 4 === 0) ? (string) (5 * $i) : null, // diskon tiap 4 produk
                'label' => ($i % 3 === 0) ? 'Best Seller' : (($i % 4 === 0) ? 'Diskon' : null),
                'label_color' => ($i % 3 === 0) ? 'bg-accent text-dark' : (($i % 4 === 0) ? 'bg-red-500 text-white' : null),
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

        return $produk;
    }

}

