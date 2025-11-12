<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    public function home()
    {
        // Data untuk homepage
        $data = [
            'berita' => $this->getBeritaTerbaru(),
            'umkm_terbaru' => $this->getUmkmTerbaru(),
            'umkm_populer' => $this->getUmkmPopuler(),
            'galeri' => $this->getGaleriTerbaru(),
            'wisata' => $this->getWisataPopuler(),
            'kegiatan' => $this->getKegiatanDesa()
        ];
        
        return view('pages.desa.home', $data);
    }
    
    public function about()
    {
        $data = [
            'identitas_desa' => $this->getIdentitasDesa(),
            'visi_misi' => $this->getVisiMisi(),
            'struktur_pemerintahan' => $this->getStrukturPemerintahan(),
            'sejarah_geografi' => $this->getSejarahGeografi(),
            'sosial_media' => $this->getSosialMedia()
        ];
        return view('pages.desa.about', $data);
    }
    
    public function contact()
    {
        return view('pages.desa.contact');
    }
    
    public function directory()
    {
        return view('pages.desa.directory');
    }
    
    public function education()
    {
        return view('pages.desa.education');
    }
    
    public function privacy()
    {
        return view('pages.desa.privacy');
    }
    
    public function sitemap()
    {
        return view('pages.desa.sitemap');
    }
    
    public function terms()
    {
        return view('pages.desa.terms');
    }
    
    public function templates()
    {
        return view('pages.desa.templates');
    }
    
    // Helper methods untuk data Home dan About
    private function getBeritaTerbaru()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Pembangunan Jalan Desa Tahap 2 Dimulai',
                'ringkasan' => 'Pembangunan infrastruktur jalan desa memasuki tahap kedua dengan target selesai akhir tahun.',
                'thumbnail' => 'https://via.placeholder.com/400x300',
                'tanggal' => '2024-01-15'
            ],
            [
                'id' => 2,
                'judul' => 'Pelatihan UMKM Digital Marketing',
                'ringkasan' => 'Desa mengadakan pelatihan digital marketing untuk meningkatkan penjualan UMKM lokal.',
                'thumbnail' => 'https://via.placeholder.com/400x300',
                'tanggal' => '2024-01-12'
            ],
            [
                'id' => 3,
                'judul' => 'Festival Panen Raya 2024',
                'ringkasan' => 'Perayaan panen raya akan diselenggarakan dengan berbagai lomba dan pameran produk desa.',
                'thumbnail' => 'https://via.placeholder.com/400x300',
                'tanggal' => '2024-01-10'
            ]
        ];
    }
    
    private function getUmkmTerbaru()
    {
        return [
            [
                'nama' => 'Keripik Singkong Renyah',
                'umkm' => 'UD Berkah Jaya',
                'harga' => 'Rp 15.000',
                'gambar' => 'https://via.placeholder.com/280x280'
            ],
            [
                'nama' => 'Madu Hutan Asli',
                'umkm' => 'Madu Sari Desa',
                'harga' => 'Rp 45.000',
                'gambar' => 'https://via.placeholder.com/280x280'
            ],
            [
                'nama' => 'Batik Tulis Motif Desa',
                'umkm' => 'Batik Nusantara',
                'harga' => 'Rp 125.000',
                'gambar' => 'https://via.placeholder.com/280x280'
            ]
        ];
    }
    
    private function getUmkmPopuler()
    {
        return [
            [
                'nama' => 'Dodol Durian Premium',
                'umkm' => 'Dodol Pak Haji',
                'harga' => 'Rp 25.000',
                'rating' => 4.8,
                'gambar' => 'https://via.placeholder.com/280x280'
            ],
            [
                'nama' => 'Kopi Robusta Giling',
                'umkm' => 'Kopi Gunung Sari',
                'harga' => 'Rp 35.000',
                'rating' => 4.9,
                'gambar' => 'https://via.placeholder.com/280x280'
            ],
            [
                'nama' => 'Tas Anyaman Pandan',
                'umkm' => 'Kerajinan Ibu-Ibu',
                'harga' => 'Rp 75.000',
                'rating' => 4.7,
                'gambar' => 'https://via.placeholder.com/280x280'
            ],
            [
                'nama' => 'Emping Melinjo Gurih',
                'umkm' => 'Emping Sari Rasa',
                'harga' => 'Rp 20.000',
                'rating' => 4.6,
                'gambar' => 'https://via.placeholder.com/280x280'
            ]
        ];
    }
    
    private function getGaleriTerbaru()
    {
        return [
            [
                'judul' => 'Gotong Royong Membersihkan Sungai',
                'gambar' => 'https://via.placeholder.com/400x600'
            ],
            [
                'judul' => 'Senam Sehat Bersama',
                'gambar' => 'https://via.placeholder.com/400x300'
            ],
            [
                'judul' => 'Pelatihan Hidroponik',
                'gambar' => 'https://via.placeholder.com/400x500'
            ],
            [
                'judul' => 'Lomba 17 Agustus',
                'gambar' => 'https://via.placeholder.com/400x400'
            ]
        ];
    }
    
    private function getWisataPopuler()
    {
        return [
            [
                'nama' => 'Air Terjun Sumber Rejeki',
                'deskripsi' => 'Air terjun alami dengan ketinggian 25 meter, dikelilingi hutan hijau yang asri.',
                'gambar' => 'https://via.placeholder.com/400x225'
            ],
            [
                'nama' => 'Kebun Teh Lereng Indah',
                'deskripsi' => 'Hamparan kebun teh dengan pemandangan pegunungan yang menakjubkan.',
                'gambar' => 'https://via.placeholder.com/400x225'
            ],
            [
                'nama' => 'Desa Wisata Kampung Bambu',
                'deskripsi' => 'Wisata edukasi kerajinan bambu dengan pengalaman membuat produk langsung.',
                'gambar' => 'https://via.placeholder.com/400x225'
            ]
        ];
    }
    
    private function getKegiatanDesa()
    {
        return [
            [
                'judul' => 'Rapat RT/RW',
                'tanggal' => '2024-01-20',
                'waktu' => '19:00',
                'tempat' => 'Balai Desa',
                'jenis' => 'rapat'
            ],
            [
                'judul' => 'Pelatihan Komputer',
                'tanggal' => '2024-01-22',
                'waktu' => '09:00',
                'tempat' => 'Ruang Serbaguna',
                'jenis' => 'pelatihan'
            ],
            [
                'judul' => 'Pasar Minggu Desa',
                'tanggal' => '2024-01-28',
                'waktu' => '06:00',
                'tempat' => 'Lapangan Desa',
                'jenis' => 'acara'
            ]
        ];
    }

    private function getIdentitasDesa()
    {
        return [
            'nama' => 'Desa Sejahtera',
            'kode_desa' => '3201012001',
            'alamat' => 'Jl. Desa Sejahtera No. 123',
            'kecamatan' => 'Kecamatan Makmur',
            'kabupaten' => 'Kabupaten Berkah',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '12345',
            'luas_wilayah' => '15.25 km²',
            'jumlah_penduduk' => '8.543 jiwa',
            'kepadatan' => '560 jiwa/km²',
            'logo' => 'https://via.placeholder.com/200x200'
        ];
    }

    private function getVisiMisi()
    {
        return [
            'visi' => 'Mewujudkan Desa Sejahtera yang Maju, Mandiri, dan Berkelanjutan Berbasis Kearifan Lokal',
            'visi_subtitle' => 'Visi 2024-2030',
            'misi' => [
                'Meningkatkan kualitas pelayanan publik yang transparan dan akuntabel',
                'Mengembangkan ekonomi kreatif dan UMKM berbasis potensi lokal',
                'Melestarikan budaya dan kearifan lokal sebagai identitas desa',
                'Membangun infrastruktur yang mendukung kesejahteraan masyarakat',
                'Menciptakan lingkungan yang bersih, sehat, dan berkelanjutan',
                'Meningkatkan kualitas pendidikan dan kesehatan masyarakat'
            ]
        ];
    }

    private function getStrukturPemerintahan()
    {
        return [
            'kepala_desa' => [
                'nama' => 'H. Ahmad Maulana, S.Sos',
                'jabatan' => 'Kepala Desa',
                'foto' => 'https://via.placeholder.com/200x200',
                'periode' => '2019-2025'
            ],
            'perangkat_desa' => [
                [
                    'nama' => 'Siti Nurhaliza, S.AP',
                    'jabatan' => 'Sekretaris Desa',
                    'foto' => 'https://via.placeholder.com/200x200'
                ],
                [
                    'nama' => 'Bambang Suryanto',
                    'jabatan' => 'Kaur Keuangan',
                    'foto' => 'https://via.placeholder.com/200x200'
                ],
                [
                    'nama' => 'Dewi Sartika, S.Pd',
                    'jabatan' => 'Kaur Umum',
                    'foto' => 'https://via.placeholder.com/200x200'
                ],
                [
                    'nama' => 'Joko Widodo',
                    'jabatan' => 'Kaur Perencanaan',
                    'foto' => 'https://via.placeholder.com/200x200'
                ],
                [
                    'nama' => 'Rina Melati',
                    'jabatan' => 'Kasi Pemerintahan',
                    'foto' => 'https://via.placeholder.com/200x200'
                ],
                [
                    'nama' => 'Agus Salim',
                    'jabatan' => 'Kasi Kesejahteraan',
                    'foto' => 'https://via.placeholder.com/200x200'
                ]
            ],
            'lembaga' => [
                [
                    'nama' => 'Badan Permusyawaratan Desa',
                    'ketua' => 'H. Suparman',
                    'anggota' => '9 orang'
                ],
                [
                    'nama' => 'Karang Taruna',
                    'ketua' => 'Andi Pratama',
                    'anggota' => '25 orang'
                ],
                [
                    'nama' => 'PKK Desa',
                    'ketua' => 'Hj. Fatimah',
                    'anggota' => '45 orang'
                ],
                [
                    'nama' => 'RT/RW',
                    'ketua' => '12 RT, 4 RW',
                    'anggota' => '16 pengurus'
                ]
            ]
        ];
    }

    private function getSejarahGeografi()
    {
        return [
            'sejarah' => [
                'pembentukan' => '1952',
                'asal_nama' => 'Nama "Sejahtera" berasal dari harapan para pendiri desa agar wilayah ini menjadi tempat yang memberikan kesejahteraan bagi seluruh warganya.',
                'tonggak_sejarah' => [
                    '1952' => 'Pembentukan Desa Sejahtera',
                    '1975' => 'Pembangunan Balai Desa pertama',
                    '1990' => 'Program transmigrasi dan pengembangan pertanian',
                    '2010' => 'Pembangunan infrastruktur jalan utama',
                    '2020' => 'Digitalisasi pelayanan desa'
                ],
                'cerita_singkat' => 'Desa Sejahtera didirikan pada tahun 1952 oleh sekelompok keluarga yang bermigrasi dari daerah pegunungan untuk mencari kehidupan yang lebih baik. Mereka memilih lokasi ini karena tanahnya yang subur dan sumber air yang melimpah. Seiring berjalannya waktu, desa ini berkembang menjadi pusat pertanian dan perdagangan di wilayah kecamatan.'
            ],
            'geografi' => [
                'ketinggian' => '450 mdpl',
                'topografi' => 'Dataran tinggi berbukit',
                'iklim' => 'Tropis',
                'batas_wilayah' => [
                    'utara' => 'Desa Makmur Jaya',
                    'selatan' => 'Desa Sumber Rezeki',
                    'timur' => 'Hutan Lindung Gunung Sari',
                    'barat' => 'Sungai Jernih'
                ],
                'potensi_alam' => [
                    'Pertanian padi dan palawija',
                    'Perkebunan kopi dan teh',
                    'Hutan bambu',
                    'Sumber mata air alami',
                    'Wisata alam air terjun'
                ]
            ],
            'foto_wilayah' => [
                'https://via.placeholder.com/600x400',
                'https://via.placeholder.com/600x400',
                'https://via.placeholder.com/600x400'
            ]
        ];
    }

    private function getSosialMedia()
    {
        return [
            'facebook' => 'https://facebook.com/desasejahtera',
            'instagram' => 'https://instagram.com/desasejahtera_official',
            'youtube' => 'https://youtube.com/@desasejahtera',
            'whatsapp' => 'https://wa.me/6281234567890',
            'email' => 'info@desasejahtera.id'
        ];
    }
}