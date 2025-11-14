<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        // Data ini bisa Anda pindahkan ke database nanti
        $profile = [
            'nama_usaha' => 'Sneaky - UMKM Streetwear',
            'deskripsi' => 'Sneaky adalah rumahnya sneaker streetwear dengan desain yang fresh dan kekinian. Kami percaya bahwa gaya adalah ekspresi diri, dan kami hadir untuk menyediakan alas kaki berkualitas yang cocok buat anak muda yang ingin tampil beda tanpa ribet.',
            'visi' => 'Menjadi brand streetwear lokal terdepan yang menginspirasi anak muda untuk berani berekspresi.',
            'alamat' => 'Jl. P. Diponegoro No. 123, Enggal, Bandar Lampung, 35118',
            'telepon' => '0812-3456-7890',
            'jam_operasional' => 'Senin - Minggu: 10:00 - 21:00 WIB',
        ];

        // Ganti dengan link Google Maps Embed Anda
        $mapEmbedUrl = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.102377317768!2d105.2595013749842!3d-5.406326096080353!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40da31a416a971%3A0xe211c33f21a1f057!2sTugu%20Adipura%20(Elephant%20Park)!5e0!3m2!1sen!2sid!4f13.1!5m2!1sen!2sid';

        $socials = [
            'instagram' => 'https://instagram.com/umkm',
            'facebook' => 'https://facebook.com/umkm',
            'tiktok' => 'https://tiktok.com/@umkm',
        ];

        // Link WA untuk layout
        $linkWA = $this->getLinkWA();

        return view('pages.umkm.about-us', compact('profile', 'mapEmbedUrl', 'socials', 'linkWA'));
    }

    /**
     * Helper untuk Link WA (agar konsisten).
     */
    private function getLinkWA(string $pesan = "Halo, saya ingin bertanya tentang usaha Anda."): string
    {
        $nomorWA = '6281234567890'; // Ganti dengan nomor Anda
        $pesanOtomatis = urlencode($pesan);
        return "https://wa.me/{$nomorWA}?text={$pesanOtomatis}";
    }
}

