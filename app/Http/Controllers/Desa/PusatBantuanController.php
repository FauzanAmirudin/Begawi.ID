<?php
// app/Http/Controllers/Desa/PusatBantuanController.php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PusatBantuanController extends Controller
{
    public function index()
    {
        $data = [
            'tutorials' => $this->getTutorials(),
            'videos' => $this->getVideos(),
            'articles' => $this->getArticles(),
            'riwayatForm' => $this->getRiwayatForm(),
            'statistik' => $this->getStatistikBantuan()
        ];
        
        return view('pages.desa.pusat-bantuan.index', $data);
    }
    
    public function submitLaporan(Request $request)
    {
        // Logic untuk submit laporan teknis
        return response()->json([
            'success' => true,
            'message' => 'Laporan teknis berhasil dikirim. Tim teknis akan menindaklanjuti dalam 24 jam.',
            'ticket_id' => 'TKN-' . date('Ymd') . '-' . rand(1000, 9999)
        ]);
    }
    
    public function getTutorialDetail($id)
    {
        $tutorial = $this->getTutorialById($id);
        return response()->json($tutorial);
    }
    
    public function getVideoDetail($id)
    {
        $video = $this->getVideoById($id);
        return response()->json($video);
    }
    
    public function getArticleDetail($id)
    {
        $article = $this->getArticleById($id);
        return response()->json($article);
    }
    
    // Private methods untuk dummy data
    private function getTutorials()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Cara Mengajukan Surat Online',
                'kategori' => 'Layanan Administrasi',
                'deskripsi' => 'Pelajari langkah-langkah mengajukan berbagai jenis surat keterangan secara online',
                'durasi' => '5 menit',
                'tingkat' => 'Pemula',
                'icon' => 'document-text',
                'color' => 'blue',
                'langkah' => [
                    'Buka halaman Layanan & Administrasi',
                    'Pilih jenis surat yang dibutuhkan',
                    'Isi form permohonan dengan lengkap',
                    'Upload persyaratan yang diminta',
                    'Kirim permohonan dan simpan kode tracking'
                ]
            ],
            [
                'id' => 2,
                'judul' => 'Mengelola Profil Akun',
                'kategori' => 'Pengaturan Akun',
                'deskripsi' => 'Panduan lengkap mengelola informasi profil dan keamanan akun Anda',
                'durasi' => '3 menit',
                'tingkat' => 'Pemula',
                'icon' => 'user-circle',
                'color' => 'emerald',
                'langkah' => [
                    'Login ke akun Anda',
                    'Klik menu Profil di header',
                    'Edit informasi yang diperlukan',
                    'Ubah password jika perlu',
                    'Simpan perubahan'
                ]
            ],
            [
                'id' => 3,
                'judul' => 'Melacak Status Pengajuan',
                'kategori' => 'Layanan Administrasi',
                'deskripsi' => 'Cara memantau progress pengajuan surat dan pengaduan Anda',
                'durasi' => '4 menit',
                'tingkat' => 'Pemula',
                'icon' => 'magnifying-glass',
                'color' => 'amber',
                'langkah' => [
                    'Buka halaman Layanan & Administrasi',
                    'Klik tombol "Lacak Status"',
                    'Masukkan kode tracking',
                    'Lihat detail status dan timeline',
                    'Download dokumen jika sudah selesai'
                ]
            ],
            [
                'id' => 4,
                'judul' => 'Menggunakan Fitur UMKM',
                'kategori' => 'UMKM',
                'deskripsi' => 'Panduan mendaftarkan dan mengelola produk UMKM di website desa',
                'durasi' => '8 menit',
                'tingkat' => 'Menengah',
                'icon' => 'building-storefront',
                'color' => 'purple',
                'langkah' => [
                    'Daftar sebagai pelaku UMKM',
                    'Lengkapi profil toko',
                    'Tambahkan produk dengan foto',
                    'Atur kategori dan harga',
                    'Publikasikan produk'
                ]
            ],
            [
                'id' => 5,
                'judul' => 'Menyampaikan Pengaduan',
                'kategori' => 'Layanan Masyarakat',
                'deskripsi' => 'Tata cara menyampaikan aspirasi dan pengaduan kepada pemerintah desa',
                'durasi' => '6 menit',
                'tingkat' => 'Pemula',
                'icon' => 'chat-bubble-left-right',
                'color' => 'red',
                'langkah' => [
                    'Pilih kategori pengaduan yang sesuai',
                    'Isi form pengaduan dengan detail',
                    'Upload bukti pendukung jika ada',
                    'Submit pengaduan',
                    'Pantau progress penanganan'
                ]
            ],
            [
                'id' => 6,
                'judul' => 'Mengakses Informasi Desa',
                'kategori' => 'Informasi Umum',
                'deskripsi' => 'Cara mencari dan mengakses berbagai informasi tentang desa',
                'durasi' => '4 menit',
                'tingkat' => 'Pemula',
                'icon' => 'information-circle',
                'color' => 'indigo',
                'langkah' => [
                    'Navigasi ke menu Tentang Desa',
                    'Jelajahi profil dan sejarah desa',
                    'Lihat struktur organisasi',
                    'Baca berita dan pengumuman terbaru',
                    'Download dokumen publik'
                ]
            ]
        ];
    }
    
    private function getVideos()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Pengenalan Website Desa Digital',
                'deskripsi' => 'Video pengenalan fitur-fitur utama website desa dan cara menggunakannya',
                'durasi' => '12:30',
                'kategori' => 'Pengenalan',
                'thumbnail' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'youtube_id' => 'dQw4w9WgXcQ',
                'views' => 1250,
                'likes' => 98
            ],
            [
                'id' => 2,
                'judul' => 'Tutorial Lengkap Surat Online',
                'deskripsi' => 'Panduan step-by-step mengajukan surat keterangan secara online',
                'durasi' => '8:45',
                'kategori' => 'Tutorial',
                'thumbnail' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'youtube_id' => 'dQw4w9WgXcQ',
                'views' => 890,
                'likes' => 76
            ],
            [
                'id' => 3,
                'judul' => 'Cara Mendaftar UMKM Online',
                'deskripsi' => 'Langkah-langkah mendaftarkan usaha UMKM di platform digital desa',
                'durasi' => '15:20',
                'kategori' => 'UMKM',
                'thumbnail' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'youtube_id' => 'dQw4w9WgXcQ',
                'views' => 654,
                'likes' => 52
            ],
            [
                'id' => 4,
                'judul' => 'Menyampaikan Aspirasi Digital',
                'deskripsi' => 'Tata cara menyampaikan pengaduan dan aspirasi melalui platform online',
                'durasi' => '6:15',
                'kategori' => 'Tutorial',
                'thumbnail' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'youtube_id' => 'dQw4w9WgXcQ',
                'views' => 432,
                'likes' => 38
            ],
            [
                'id' => 5,
                'judul' => 'Keamanan Data & Privasi',
                'deskripsi' => 'Tips menjaga keamanan data pribadi saat menggunakan layanan digital',
                'durasi' => '9:30',
                'kategori' => 'Keamanan',
                'thumbnail' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'youtube_id' => 'dQw4w9WgXcQ',
                'views' => 321,
                'likes' => 29
            ]
        ];
    }
    
    private function getArticles()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Transformasi Digital Desa: Dari Manual ke Digital',
                'excerpt' => 'Perjalanan desa dalam mengadopsi teknologi digital untuk meningkatkan pelayanan kepada masyarakat...',
                'penulis' => 'Tim Redaksi Desa',
                'tanggal' => '2024-12-01',
                'kategori' => 'Digitalisasi',
                'gambar' => 'https://via.placeholder.com/600x400/0284C7/ffffff?text=Digital+Transformation',
                'tags' => ['#InovasiDesa', '#Digitalisasi', '#PelayananPublik'],
                'waktu_baca' => '5 menit'
            ],
            [
                'id' => 2,
                'judul' => 'Meningkatkan Partisipasi Warga Melalui Platform Digital',
                'excerpt' => 'Bagaimana teknologi dapat menjadi jembatan komunikasi antara pemerintah desa dan warga...',
                'penulis' => 'Kepala Desa',
                'tanggal' => '2024-11-28',
                'kategori' => 'Partisipasi',
                'gambar' => 'https://via.placeholder.com/600x400/10B981/ffffff?text=Citizen+Engagement',
                'tags' => ['#PartisipasiWarga', '#Komunikasi', '#Transparansi'],
                'waktu_baca' => '4 menit'
            ],
            [
                'id' => 3,
                'judul' => 'Success Story: UMKM Desa Go Digital',
                'excerpt' => 'Kisah inspiratif pelaku UMKM desa yang berhasil meningkatkan penjualan melalui platform digital...',
                'penulis' => 'Koordinator UMKM',
                'tanggal' => '2024-11-25',
                'kategori' => 'UMKM',
                'gambar' => 'https://via.placeholder.com/600x400/FACC15/ffffff?text=UMKM+Success',
                'tags' => ['#UMKM', '#ECommerce', '#InovasiDesa'],
                'waktu_baca' => '6 menit'
            ],
            [
                'id' => 4,
                'judul' => 'Panduan Keamanan Digital untuk Warga Desa',
                'excerpt' => 'Tips dan trik menjaga keamanan data pribadi saat menggunakan layanan digital desa...',
                'penulis' => 'Tim IT Desa',
                'tanggal' => '2024-11-22',
                'kategori' => 'Keamanan',
                'gambar' => 'https://via.placeholder.com/600x400/EF4444/ffffff?text=Digital+Security',
                'tags' => ['#Keamanan', '#PrivasiData', '#TipsDigital'],
                'waktu_baca' => '7 menit'
            ]
        ];
    }
    
    private function getRiwayatForm()
    {
        return [
            [
                'id' => 'TKN-20241201-001',
                'tanggal' => '2024-12-01',
                'deskripsi' => 'Error saat upload dokumen di form surat online',
                'kategori' => 'Website',
                'status' => 'selesai',
                'prioritas' => 'tinggi'
            ],
            [
                'id' => 'TKN-20241130-002',
                'tanggal' => '2024-11-30',
                'deskripsi' => 'Tidak bisa login ke akun pengguna',
                'kategori' => 'Akun',
                'status' => 'proses',
                'prioritas' => 'sedang'
            ],
            [
                'id' => 'TKN-20241129-003',
                'tanggal' => '2024-11-29',
                'deskripsi' => 'Halaman UMKM loading lambat',
                'kategori' => 'Performa',
                'status' => 'selesai',
                'prioritas' => 'rendah'
            ],
            [
                'id' => 'TKN-20241128-004',
                'tanggal' => '2024-11-28',
                'deskripsi' => 'Fitur pencarian tidak berfungsi dengan baik',
                'kategori' => 'Website',
                'status' => 'revisi',
                'prioritas' => 'sedang'
            ]
        ];
    }
    
    private function getStatistikBantuan()
    {
        return [
            'total_tutorial' => 6,
            'total_video' => 5,
            'total_artikel' => 4,
            'laporan_selesai' => 15,
            'laporan_proses' => 3,
            'rating_kepuasan' => 4.7
        ];
    }
    
    private function getTutorialById($id)
    {
        $tutorials = $this->getTutorials();
        return collect($tutorials)->firstWhere('id', $id);
    }
    
    private function getVideoById($id)
    {
        $videos = $this->getVideos();
        return collect($videos)->firstWhere('id', $id);
    }
    
    private function getArticleById($id)
    {
        $articles = $this->getArticles();
        return collect($articles)->firstWhere('id', $id);
    }
}