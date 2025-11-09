<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        $stats = [
            'founded_year' => 2024,
            'villages' => 1250,
            'umkm' => 3420,
            'provinces' => 34
        ];
        
        $team = [
            [
                'name' => 'Andi Prasetyo',
                'position' => 'CEO & Founder',
                'avatar' => 'team/ceo.jpg',
                'bio' => '10+ tahun pengalaman dalam teknologi dan pemberdayaan masyarakat. Alumni ITB dengan passion untuk Indonesia digital.',
                'social' => [
                    'linkedin' => '#',
                    'twitter' => '#'
                ],
                'color' => 'emerald'
            ],
            [
                'name' => 'Sari Indrawati',
                'position' => 'CTO & Co-Founder',
                'avatar' => 'team/cto.jpg',
                'bio' => 'Expert dalam pengembangan platform scalable. Berpengalaman membangun sistem untuk jutaan pengguna.',
                'social' => [
                    'linkedin' => '#',
                    'pinterest' => '#'
                ],
                'color' => 'blue'
            ],
            [
                'name' => 'Budi Hartono',
                'position' => 'Head of Community',
                'avatar' => 'team/cmo.jpg',
                'bio' => 'Ahli dalam community building dan digital marketing. Fokus pada pengembangan ekosistem pengguna.',
                'social' => [
                    'linkedin' => '#',
                    'whatsapp' => '#'
                ],
                'color' => 'purple'
            ]
        ];
        
        $values = [
            [
                'icon' => '🤝',
                'title' => 'Inklusivitas',
                'description' => 'Kami percaya teknologi harus dapat diakses oleh semua orang, tanpa memandang latar belakang ekonomi atau geografis.',
                'color' => 'emerald'
            ],
            [
                'icon' => '💎',
                'title' => 'Kualitas',
                'description' => 'Setiap produk dan layanan yang kami berikan harus memenuhi standar kualitas tertinggi dan memberikan nilai nyata.',
                'color' => 'blue'
            ],
            [
                'icon' => '🌱',
                'title' => 'Keberlanjutan',
                'description' => 'Kami membangun solusi yang berkelanjutan untuk jangka panjang, mendukung pertumbuhan ekonomi lokal.',
                'color' => 'purple'
            ],
            [
                'icon' => '🔒',
                'title' => 'Transparansi',
                'description' => 'Keterbukaan dalam setiap aspek bisnis kami, dari pengembangan produk hingga penggunaan data pengguna.',
                'color' => 'orange'
            ],
            [
                'icon' => '🚀',
                'title' => 'Inovasi',
                'description' => 'Terus berinovasi untuk menghadirkan solusi terdepan yang sesuai dengan perkembangan teknologi.',
                'color' => 'pink'
            ],
            [
                'icon' => '❤️',
                'title' => 'Empati',
                'description' => 'Memahami kebutuhan dan tantangan yang dihadapi masyarakat Indonesia dalam era digital.',
                'color' => 'red'
            ]
        ];
        
        $timeline = [
            [
                'year' => '2023',
                'period' => 'AWAL MULA',
                'title' => 'Identifikasi Masalah',
                'description' => 'Riset mendalam tentang kesenjangan digital di desa-desa Indonesia. Kami menemukan 70% desa belum memiliki website resmi.',
                'color' => 'emerald'
            ],
            [
                'year' => '2024',
                'period' => 'PENGEMBANGAN',
                'title' => 'Membangun Solusi',
                'description' => 'Mengembangkan platform dengan fokus pada kemudahan penggunaan dan kebutuhan spesifik Indonesia.',
                'color' => 'blue'
            ],
            [
                'year' => '2024',
                'period' => 'PELUNCURAN',
                'title' => 'Beta Launch',
                'description' => 'Meluncurkan versi beta dengan 50 desa dan 100 UMKM sebagai pilot project.',
                'color' => 'purple'
            ],
            [
                'year' => 'SEKARANG',
                'period' => 'EKSPANSI',
                'title' => 'Jangkauan Nasional',
                'description' => 'Melayani 1,250+ desa dan 3,420+ UMKM di 34 provinsi Indonesia.',
                'color' => 'orange'
            ]
        ];
        
        return view('pages.about', compact('stats', 'team', 'values', 'timeline'));
    }
}

