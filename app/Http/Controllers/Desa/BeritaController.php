<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $data = [
            'berita' => $this->getAllBerita(),
            'kategori' => $this->getKategoriBerita(),
            'berita_populer' => $this->getBeritaPopuler()
        ];
        
        return view('pages.desa.berita.index', $data);
    }

    public function tambah()
    {
        $data = [
            'kategori' => $this->getKategoriBerita()
        ];
        
        return view('pages.desa.berita.tambah', $data);
    }

    public function edit($id)
    {
        $data = [
            'berita' => $this->getBeritaById($id),
            'kategori' => $this->getKategoriBerita()
        ];
        
        return view('pages.desa.berita.edit', $data);
    }

    public function arsip()
    {
        $data = [
            'arsip_tahun' => $this->getArsipTahun(),
            'arsip_kategori' => $this->getArsipKategori()
        ];
        
        return view('pages.desa.berita.arsip', $data);
    }

    public function agenda()
    {
        $data = [
            'kegiatan' => $this->getKegiatanMendatang(),
            'kalender_events' => $this->getKalenderEvents()
        ];
        
        return view('pages.desa.berita.agenda', $data);
    }

    public function detail($slug)
    {
        $data = [
            'berita' => $this->getBeritaBySlug($slug),
            'berita_terkait' => $this->getBeritaTerkait()
        ];
        
        return view('pages.desa.berita.detail', $data);
    }

    // Helper methods untuk data Berita
    private function getAllBerita()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Pembangunan Jalan Desa Tahap 2 Dimulai',
                'slug' => 'pembangunan-jalan-desa-tahap-2-dimulai',
                'kategori' => 'Pembangunan',
                'ringkasan' => 'Pembangunan infrastruktur jalan desa memasuki tahap kedua dengan target selesai akhir tahun ini.',
                'konten' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
                'thumbnail' => 'https://via.placeholder.com/600x400',
                'penulis' => 'Admin Desa',
                'tanggal' => '2024-01-15',
                'views' => 156,
                'featured' => true
            ],
            [
                'id' => 2,
                'judul' => 'Pelatihan UMKM Digital Marketing',
                'slug' => 'pelatihan-umkm-digital-marketing',
                'kategori' => 'Pelatihan',
                'ringkasan' => 'Desa mengadakan pelatihan digital marketing untuk meningkatkan penjualan UMKM lokal.',
                'konten' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
                'thumbnail' => 'https://via.placeholder.com/600x400',
                'penulis' => 'Admin Desa',
                'tanggal' => '2024-01-12',
                'views' => 89,
                'featured' => false
            ],
            [
                'id' => 3,
                'judul' => 'Festival Panen Raya 2024',
                'slug' => 'festival-panen-raya-2024',
                'kategori' => 'Acara',
                'ringkasan' => 'Perayaan panen raya akan diselenggarakan dengan berbagai lomba dan pameran produk desa.',
                'konten' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
                'thumbnail' => 'https://via.placeholder.com/600x400',
                'penulis' => 'Admin Desa',
                'tanggal' => '2024-01-10',
                'views' => 234,
                'featured' => true
            ],
            [
                'id' => 4,
                'judul' => 'Bantuan Sosial untuk Warga Terdampak',
                'slug' => 'bantuan-sosial-untuk-warga-terdampak',
                'kategori' => 'Sosial',
                'ringkasan' => 'Pemerintah desa menyalurkan bantuan sosial kepada warga yang terdampak bencana alam.',
                'konten' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
                'thumbnail' => 'https://via.placeholder.com/600x400',
                'penulis' => 'Admin Desa',
                'tanggal' => '2024-01-08',
                'views' => 67,
                'featured' => false
            ],
            [
                'id' => 5,
                'judul' => 'Gotong Royong Bersihkan Sungai Desa',
                'slug' => 'gotong-royong-bersihkan-sungai-desa',
                'kategori' => 'Lingkungan',
                'ringkasan' => 'Warga desa bergotong royong membersihkan sungai untuk menjaga kelestarian lingkungan.',
                'konten' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
                'thumbnail' => 'https://via.placeholder.com/600x400',
                'penulis' => 'Admin Desa',
                'tanggal' => '2024-01-05',
                'views' => 123,
                'featured' => false
            ],
            [
                'id' => 6,
                'judul' => 'Peluncuran Program Desa Digital',
                'slug' => 'peluncuran-program-desa-digital',
                'kategori' => 'Teknologi',
                'ringkasan' => 'Desa meluncurkan program digitalisasi pelayanan untuk memudahkan warga dalam mengakses layanan.',
                'konten' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
                'thumbnail' => 'https://via.placeholder.com/600x400',
                'penulis' => 'Admin Desa',
                'tanggal' => '2024-01-03',
                'views' => 189,
                'featured' => true
            ]
        ];
    }

    private function getKategoriBerita()
    {
        return [
            'Semua',
            'Pembangunan',
            'Pelatihan', 
            'Acara',
            'Sosial',
            'Lingkungan',
            'Teknologi',
            'Kesehatan',
            'Pendidikan'
        ];
    }

    private function getBeritaPopuler()
    {
        return array_slice($this->getAllBerita(), 0, 3);
    }

    private function getBeritaById($id)
    {
        $berita = $this->getAllBerita();
        return collect($berita)->firstWhere('id', $id);
    }

    private function getBeritaBySlug($slug)
    {
        $berita = $this->getAllBerita();
        return collect($berita)->firstWhere('slug', $slug);
    }

    private function getBeritaTerkait()
    {
        return array_slice($this->getAllBerita(), 0, 4);
    }

    private function getArsipTahun()
    {
        return [
            '2024' => [
                'total' => 15,
                'berita' => array_slice($this->getAllBerita(), 0, 3)
            ],
            '2023' => [
                'total' => 28,
                'berita' => array_slice($this->getAllBerita(), 3, 3)
            ]
        ];
    }

    private function getArsipKategori()
    {
        return [
            'Pembangunan' => 8,
            'Pelatihan' => 12,
            'Acara' => 15,
            'Sosial' => 6,
            'Lingkungan' => 9,
            'Teknologi' => 4
        ];
    }

    private function getKegiatanMendatang()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Rapat Koordinasi RT/RW',
                'tanggal' => '2024-01-25',
                'waktu' => '19:00',
                'tempat' => 'Balai Desa',
                'kategori' => 'Rapat',
                'deskripsi' => 'Rapat koordinasi bulanan dengan seluruh RT/RW se-desa'
            ],
            [
                'id' => 2,
                'judul' => 'Pelatihan Hidroponik untuk Ibu-Ibu',
                'tanggal' => '2024-01-28',
                'waktu' => '09:00',
                'tempat' => 'Ruang Serbaguna',
                'kategori' => 'Pelatihan',
                'deskripsi' => 'Pelatihan budidaya tanaman hidroponik untuk meningkatkan ekonomi keluarga'
            ],
            [
                'id' => 3,
                'judul' => 'Pasar Minggu Desa',
                'tanggal' => '2024-01-30',
                'waktu' => '06:00',
                'tempat' => 'Lapangan Desa',
                'kategori' => 'Acara',
                'deskripsi' => 'Pasar minggu dengan produk-produk UMKM lokal'
            ],
            [
                'id' => 4,
                'judul' => 'Posyandu Balita',
                'tanggal' => '2024-02-02',
                'waktu' => '08:00',
                'tempat' => 'Puskesmas Pembantu',
                'kategori' => 'Kesehatan',
                'deskripsi' => 'Pemeriksaan kesehatan rutin untuk balita'
            ],
            [
                'id' => 5,
                'judul' => 'Senam Sehat Lansia',
                'tanggal' => '2024-02-05',
                'waktu' => '07:00',
                'tempat' => 'Lapangan Desa',
                'kategori' => 'Kesehatan',
                'deskripsi' => 'Senam sehat untuk warga lanjut usia'
            ]
        ];
    }

    private function getKalenderEvents()
    {
        return [
            [
                'title' => 'Rapat RT/RW',
                'start' => '2024-01-25',
                'color' => '#166534',
                'category' => 'rapat'
            ],
            [
                'title' => 'Pelatihan Hidroponik',
                'start' => '2024-01-28',
                'color' => '#3B82F6',
                'category' => 'pelatihan'
            ],
            [
                'title' => 'Pasar Minggu',
                'start' => '2024-01-30',
                'color' => '#F59E0B',
                'category' => 'acara'
            ],
            [
                'title' => 'Posyandu Balita',
                'start' => '2024-02-02',
                'color' => '#EC4899',
                'category' => 'kesehatan'
            ],
            [
                'title' => 'Senam Lansia',
                'start' => '2024-02-05',
                'color' => '#EC4899',
                'category' => 'kesehatan'
            ],
            [
                'title' => 'Rapat Koordinasi',
                'start' => '2024-02-08',
                'color' => '#166534',
                'category' => 'rapat'
            ],
            [
                'title' => 'Pelatihan UMKM',
                'start' => '2024-02-12',
                'color' => '#3B82F6',
                'category' => 'pelatihan'
            ],
            [
                'title' => 'Festival Desa',
                'start' => '2024-02-15',
                'color' => '#F59E0B',
                'category' => 'acara'
            ]
        ];
    }
}

