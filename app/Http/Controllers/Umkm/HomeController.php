<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda.
     */
    public function index(Request $request): View
    {
        // Semua produk (database tiruan)
        $allProducts = $this->getSemuaProduk();

        // Produk unggulan (unggulan == true)
        $produkUnggulan = array_values(array_filter($allProducts, fn($p) => $p['unggulan'] ?? false));

        // Produk terbaru (4 terakhir dari daftar)
        $produkTerbaru = array_slice(array_reverse($allProducts), 0, 4);

        // Filter search
        $semuaProduk = $allProducts;
        if ($request->search) {
            $semuaProduk = array_filter($semuaProduk, fn($p) => str_contains(strtolower($p['nama']), strtolower($request->search)));
        }

        // Filter kategori
        if ($request->kategori) {
            $semuaProduk = array_filter($semuaProduk, fn($p) => ($p['kategori'] ?? '') == $request->kategori);
        }

        $linkWA = $this->getLinkWA();
        $socials = [
            'instagram' => 'https://instagram.com/umkm',
            'facebook' => 'https://facebook.com/umkm',
            'tiktok' => 'https://tiktok.com/@umkm',
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
     * Membuat link WhatsApp dinamis.
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
                'harga' => (350000 + $i * 10000),
                'gambar' => '/assets/Sneaker.png',
                'unggulan' => $i % 3 === 0, // setiap 3 produk jadi unggulan
                'diskon' => ($i % 4 === 0) ? (string)(5 * $i) : null, // diskon tiap 4 produk
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

        return $produk;
    }
}

