<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang
     */
    public function index()
    {
        $linkWA = $this->getLinkWA();
        $socials = [
            'instagram' => 'https://instagram.com/umkm',
            'facebook' => 'https://facebook.com/umkm',
            'tiktok' => 'https://tiktok.com/@umkm',
        ];
        return view('pages.umkm.cart', compact('linkWA', 'socials'));
    }

    /**
     * Menampilkan detail produk
     */
    public function show($id)
    {
        $produk = $this->getProdukById($id);

        return view('pages.umkm.product-detail', compact('produk'));
    }

    /**
     * Data dummy produk (sama seperti HomeController)
     */
    private function getProdukById($id)
    {
        $allProduk = $this->getSemuaProduk();
        return $allProduk[$id] ?? null;
    }
    private function getLinkWA(string $pesan = "Halo, saya tertarik dengan produk Anda."): string
    {
        $nomorWA = '6281234567890'; // Ganti dengan nomor Anda
        $pesanOtomatis = urlencode($pesan);
        return "https://wa.me/{$nomorWA}?text={$pesanOtomatis}";
    }

    private function getSemuaProduk(): array
    {
        $produk = [];

        for ($i = 1; $i <= 17; $i++) {
            $produk[$i] = (object) [
                'id' => $i,
                'nama' => "Sneaker Model $i",
                'harga' => 350000 + $i * 10000,
                'gambar' => '/assets/Sneaker.png',
                'unggulan' => $i % 3 === 0,
                'diskon' => ($i % 4 === 0) ? (5 * $i) : null,
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

