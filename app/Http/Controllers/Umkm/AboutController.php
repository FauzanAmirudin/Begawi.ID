<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
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

    public function index(Request $request): View
    {
        $umkmBusiness = $this->getUmkmBusiness($request);
        
        if (!$umkmBusiness) {
            // Fallback ke data dummy jika tidak ada UMKM business
            return $this->getDummyData();
        }

        // Format jam operasional
        $operatingHours = $umkmBusiness->operating_hours ?? [];
        $jamOperasional = $this->formatOperatingHours($operatingHours);

        // Data profile dari database
        $profile = [
            'nama_usaha' => $umkmBusiness->name,
            'deskripsi' => $umkmBusiness->description ?? $umkmBusiness->about_business ?? 'Tidak ada deskripsi.',
            'visi' => $umkmBusiness->about_business ?? $umkmBusiness->description ?? '',
            'alamat' => $umkmBusiness->address ?? 'Alamat belum diisi',
            'telepon' => $umkmBusiness->owner_phone ?? 'Telepon belum diisi',
            'jam_operasional' => $jamOperasional,
        ];

        // Google Maps Embed URL - bisa berupa HTML embed code atau URL
        $mapsEmbed = $umkmBusiness->maps_embed_url ?? '';
        $mapEmbedUrl = '';
        $mapEmbedHtml = '';
        
        if (!empty($mapsEmbed)) {
            // Cek apakah sudah berupa HTML embed code (mengandung <iframe)
            if (str_contains($mapsEmbed, '<iframe')) {
                $mapEmbedHtml = $mapsEmbed;
            } else {
                // Jika hanya URL, kita buat iframe
                $mapEmbedUrl = $mapsEmbed;
            }
        }

        // Social media dari database
        $socialMedia = $umkmBusiness->social_media ?? [];
        $socials = [
            'instagram' => $socialMedia['instagram'] ?? '#',
            'facebook' => $socialMedia['facebook'] ?? '#',
            'tiktok' => $socialMedia['tiktok'] ?? '#',
            'youtube' => $socialMedia['youtube'] ?? '#',
        ];

        // Link WA untuk layout
        $linkWA = $this->getLinkWA($umkmBusiness);

        return view('pages.umkm.about-us', compact('profile', 'mapEmbedUrl', 'mapEmbedHtml', 'socials', 'linkWA'));
    }

    /**
     * Format operating hours untuk ditampilkan
     */
    private function formatOperatingHours(array $operatingHours): string
    {
        if (empty($operatingHours)) {
            return 'Jam operasional belum diatur';
        }

        $formatted = [];
        foreach ($operatingHours as $hour) {
            if (isset($hour['is_closed']) && $hour['is_closed']) {
                $formatted[] = $hour['day'] . ': Tutup';
            } else {
                $open = $hour['open_time'] ?? '';
                $close = $hour['close_time'] ?? '';
                if ($open && $close) {
                    $formatted[] = $hour['day'] . ': ' . $open . ' - ' . $close;
                } else {
                    $formatted[] = $hour['day'] . ': -';
                }
            }
        }

        return implode(' | ', $formatted);
    }

    /**
     * Helper untuk Link WA (agar konsisten).
     */
    private function getLinkWA(?UmkmBusiness $umkmBusiness = null, string $pesan = "Halo, saya ingin bertanya tentang usaha Anda."): string
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
     * Fallback ke data dummy jika tidak ada UMKM business
     */
    private function getDummyData()
    {
        $profile = [
            'nama_usaha' => 'Sneaky - UMKM Streetwear',
            'deskripsi' => 'Sneaky adalah rumahnya sneaker streetwear dengan desain yang fresh dan kekinian. Kami percaya bahwa gaya adalah ekspresi diri, dan kami hadir untuk menyediakan alas kaki berkualitas yang cocok buat anak muda yang ingin tampil beda tanpa ribet.',
            'visi' => 'Menjadi brand streetwear lokal terdepan yang menginspirasi anak muda untuk berani berekspresi.',
            'alamat' => 'Jl. P. Diponegoro No. 123, Enggal, Bandar Lampung, 35118',
            'telepon' => '0812-3456-7890',
            'jam_operasional' => 'Senin - Minggu: 10:00 - 21:00 WIB',
        ];

        $mapEmbedUrl = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.102377317768!2d105.2595013749842!3d-5.406326096080353!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40da31a416a971%3A0xe211c33f21a1f057!2sTugu%20Adipura%20(Elephant%20Park)!5e0!3m2!1sen!2sid!4f13.1!5m2!1sen!2sid';
        $mapEmbedHtml = '';

        $socials = [
            'instagram' => 'https://instagram.com/umkm',
            'facebook' => 'https://facebook.com/umkm',
            'tiktok' => 'https://tiktok.com/@umkm',
            'youtube' => '#',
        ];

        $linkWA = $this->getLinkWA();

        return view('pages.umkm.about-us', compact('profile', 'mapEmbedUrl', 'mapEmbedHtml', 'socials', 'linkWA'));
    }
}

