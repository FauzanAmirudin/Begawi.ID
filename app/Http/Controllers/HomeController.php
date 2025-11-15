<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Website;
use App\Models\Village;
use App\Models\UmkmBusiness;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data real dari database
        $villagesCount = Website::where('type', 'desa')
            ->where('status', 'active')
            ->count();
        
        $umkmCount = Website::where('type', 'umkm')
            ->where('status', 'active')
            ->count();
        
        $premiumUsersCount = User::whereHas('websites', function($query) {
            $query->where('status', 'active');
        })->count();
        
        // Total visitors bisa diambil dari UmkmVisitor jika ada, atau gunakan dummy
        $totalVisitors = 125000; // Bisa diambil dari analytics jika ada
        
        $stats = [
            'villages' => $villagesCount ?: 1250, // Fallback ke dummy jika belum ada data
            'umkm' => $umkmCount ?: 3420,
            'premium_users' => $premiumUsersCount ?: 850,
            'total_visitors' => $totalVisitors
        ];
        
        // Featured templates - bisa diambil dari database jika ada tabel templates
        // Untuk sekarang tetap menggunakan dummy data
        $featured_templates = [
            [
                'id' => 1,
                'name' => 'Desa Modern',
                'category' => 'desa',
                'image' => 'templates/desa-modern.jpg',
                'views' => 1200,
                'likes' => 89,
                'rating' => 5,
                'is_premium' => false
            ],
            [
                'id' => 2,
                'name' => 'Toko Online Pro',
                'category' => 'umkm',
                'image' => 'templates/toko-online.jpg',
                'views' => 2800,
                'likes' => 156,
                'rating' => 5,
                'is_premium' => true
            ],
            [
                'id' => 3,
                'name' => 'Karang Taruna',
                'category' => 'komunitas',
                'image' => 'templates/karang-taruna.jpg',
                'views' => 856,
                'likes' => 43,
                'rating' => 5,
                'is_premium' => false
            ]
        ];
        
        // Testimonials - bisa diambil dari database jika ada
        $testimonials = [
            [
                'name' => 'Pak Budi Santoso',
                'position' => 'Kepala Desa Sukamaju',
                'avatar' => 'testimonials/pak-budi.jpg',
                'location' => 'Desa Sukamaju, Jawa Barat',
                'rating' => 5,
                'text' => 'Berkat Begawi.id, desa kami kini punya website profesional yang memudahkan warga mengakses informasi. Pelayanan administrasi jadi lebih efisien dan transparan. Luar biasa!'
            ],
            [
                'name' => 'Ibu Sari Dewi',
                'position' => 'Owner Batik Nusantara',
                'avatar' => 'testimonials/ibu-sari.jpg',
                'location' => 'Batik Nusantara, Yogyakarta',
                'rating' => 5,
                'text' => 'Sebagai pemilik UMKM, saya sangat terbantu dengan template e-commerce Begawi.id. Penjualan online meningkat 300% dalam 3 bulan. Fitur pembayarannya juga lengkap!'
            ]
        ];
        
        return view('pages.home', compact('stats', 'featured_templates', 'testimonials'));
    }
    
    public function newsletter(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        
        // Logic untuk subscribe newsletter
        // Bisa menggunakan service seperti Mailchimp, SendGrid, dll
        
        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Anda telah berlangganan newsletter kami.'
        ]);
    }
}