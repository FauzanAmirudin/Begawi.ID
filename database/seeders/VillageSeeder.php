<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Village;
use App\Models\VillageAchievement;
use App\Models\VillageGalleryCategory;
use App\Models\VillageGalleryItem;
use App\Models\VillageNews;
use App\Models\VillagePotential;
use App\Models\VillageProgram;
use App\Models\Website;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $village = Village::updateOrCreate(
            ['slug' => 'desa-sejahtera'],
            [
                'name' => 'Desa Sejahtera',
                'tagline' => 'Desa Digital yang Maju, Mandiri, dan Berkelanjutan',
                'head' => 'H. Ahmad Maulana, S.Sos',
                'head_title' => 'Kepala Desa',
                'location' => 'Jl. Desa Sejahtera No. 123, Kecamatan Makmur, Kabupaten Berkah, Jawa Barat',
                'code' => '3201012001',
                'population' => '8.543 jiwa',
                'area' => '15.25 km²',
                'density' => '560 jiwa/km²',
                'logo_path' => 'https://via.placeholder.com/200x200',
                'description' => 'Website resmi Desa Sejahtera sebagai pusat informasi, pelayanan, dan transparansi pembangunan desa.',
                'vision' => 'Mewujudkan Desa Sejahtera yang Maju, Mandiri, dan Berkelanjutan Berbasis Kearifan Lokal',
                'vision_period' => 'Visi 2024-2030',
                'missions' => [
                    'Meningkatkan kualitas pelayanan publik yang transparan dan akuntabel.',
                    'Mengembangkan ekonomi kreatif dan UMKM berbasis potensi lokal.',
                    'Melestarikan budaya dan kearifan lokal sebagai identitas desa.',
                    'Membangun infrastruktur yang mendukung kesejahteraan masyarakat.',
                    'Menciptakan lingkungan yang bersih, sehat, dan berkelanjutan.',
                    'Meningkatkan kualitas pendidikan dan kesehatan masyarakat.',
                ],
                'contacts' => [
                    [
                        'label' => 'Telepon Kantor Desa',
                        'value' => '(0261) 8899 221',
                        'type' => 'phone',
                        'icon' => 'phone',
                    ],
                    [
                        'label' => 'Email Resmi',
                        'value' => 'info@desasejahtera.id',
                        'type' => 'email',
                        'icon' => 'mail',
                    ],
                    [
                        'label' => 'Whatsapp Pelayanan',
                        'value' => '+62 812-3456-7890',
                        'type' => 'whatsapp',
                        'icon' => 'chat',
                    ],
                    [
                        'label' => 'Alamat Kantor',
                        'value' => 'Jl. Desa Sejahtera No. 123, Kecamatan Makmur',
                        'type' => 'map',
                        'icon' => 'location',
                    ],
                ],
                'structures' => [
                    [
                        'name' => 'H. Ahmad Maulana, S.Sos',
                        'role' => 'Kepala Desa',
                        'since' => 'Periode 2019-2025',
                        'photo' => 'https://via.placeholder.com/200x200',
                    ],
                    [
                        'name' => 'Siti Nurhaliza, S.AP',
                        'role' => 'Sekretaris Desa',
                        'since' => 'Sejak 2018',
                        'photo' => 'https://via.placeholder.com/200x200',
                    ],
                    [
                        'name' => 'Bambang Suryanto',
                        'role' => 'Kaur Keuangan',
                        'since' => 'Sejak 2017',
                        'photo' => 'https://via.placeholder.com/200x200',
                    ],
                    [
                        'name' => 'Dewi Sartika, S.Pd',
                        'role' => 'Kaur Umum',
                        'since' => 'Sejak 2020',
                        'photo' => 'https://via.placeholder.com/200x200',
                    ],
                ],
                'history' => [
                    ['year' => '1952', 'event' => 'Pembentukan Desa Sejahtera sebagai pemekaran Desa Makmur.'],
                    ['year' => '1975', 'event' => 'Pembangunan Balai Desa pertama dengan swadaya masyarakat.'],
                    ['year' => '1990', 'event' => 'Program transmigrasi dan pengembangan pertanian terpadu.'],
                    ['year' => '2010', 'event' => 'Pembangunan infrastruktur jalan utama penghubung desa.'],
                    ['year' => '2020', 'event' => 'Digitalisasi pelayanan desa dan peluncuran website desa.'],
                ],
            ]
        );

        // Create or link Website for this village
        if (!$village->website_id) {
            // Get or create admin desa user
            $adminUser = User::where('role', User::ROLE_ADMIN_DESA)
                ->where('village_id', $village->id)
                ->first();

            if (!$adminUser) {
                $adminUser = User::where('role', User::ROLE_ADMIN_DESA)
                    ->whereNull('village_id')
                    ->first();
            }

            if (!$adminUser) {
                $adminUser = User::updateOrCreate(
                    ['email' => 'admin.desa@begawi.id'],
                    [
                        'name' => 'Admin Desa',
                        'password' => Hash::make('password'),
                        'role' => User::ROLE_ADMIN_DESA,
                        'status' => 'active',
                        'village_id' => $village->id,
                        'email_verified_at' => now(),
                    ]
                );
            } else {
                $adminUser->update(['village_id' => $village->id]);
            }

            // Generate subdomain
            $subdomain = Str::slug($village->name);
            $counter = 1;
            $originalSubdomain = $subdomain;
            while (Website::where('url', $subdomain)->exists()) {
                $subdomain = $originalSubdomain . '-' . $counter;
                $counter++;
            }

            // Create website
            $website = Website::updateOrCreate(
                [
                    'type' => 'desa',
                    'name' => $village->name,
                ],
                [
                    'url' => $subdomain,
                    'status' => 'active',
                    'user_id' => $adminUser->id,
                    'template_id' => 'desa-template',
                ]
            );

            // Link village to website
            $village->update(['website_id' => $website->id]);
        }

        $newsData = [
            [
                'title' => 'Pembangunan Jalan Desa Tahap 2 Dimulai',
                'category' => 'Pembangunan',
                'summary' => 'Pembangunan infrastruktur jalan desa memasuki tahap kedua dengan target selesai akhir tahun ini.',
                'writer' => 'Admin Desa',
                'published_at' => Carbon::parse('2024-01-15'),
                'status' => VillageNews::STATUS_PUBLISHED,
                'views' => 156,
            ],
            [
                'title' => 'Pelatihan UMKM Digital Marketing',
                'category' => 'Pelatihan',
                'summary' => 'Pelatihan digital marketing untuk meningkatkan penjualan UMKM lokal.',
                'writer' => 'Admin Desa',
                'published_at' => Carbon::parse('2024-01-12'),
                'status' => VillageNews::STATUS_PUBLISHED,
                'views' => 89,
            ],
            [
                'title' => 'Festival Panen Raya 2024',
                'category' => 'Acara',
                'summary' => 'Perayaan panen raya dengan lomba dan pameran produk unggulan.',
                'writer' => 'Admin Desa',
                'published_at' => Carbon::parse('2024-01-10'),
                'status' => VillageNews::STATUS_PUBLISHED,
                'views' => 234,
            ],
            [
                'title' => 'Bantuan Sosial untuk Warga Terdampak',
                'category' => 'Sosial',
                'summary' => 'Penyaluran bantuan sosial kepada warga yang terdampak bencana.',
                'writer' => 'Admin Desa',
                'published_at' => Carbon::parse('2024-01-08'),
                'status' => VillageNews::STATUS_PUBLISHED,
                'views' => 67,
            ],
        ];

        foreach ($newsData as $data) {
            VillageNews::updateOrCreate(
                [
                    'village_id' => $village->id,
                    'slug' => Str::slug($data['title']),
                ],
                array_merge($data, [
                    'village_id' => $village->id,
                    'is_featured' => true,
                    'content' => 'Konten berita akan diperbarui melalui editor admin desa.',
                ])
            );
        }

        $galleryCategories = collect([
            [
                'name' => 'Acara',
                'description' => 'Dokumentasi acara resmi desa: festival, lomba, perayaan hari besar.',
            ],
            [
                'name' => 'Pembangunan',
                'description' => 'Progres pembangunan infrastruktur desa dan sarana umum.',
            ],
            [
                'name' => 'Sosial',
                'description' => 'Kegiatan sosial dan keagamaan yang melibatkan masyarakat desa.',
            ],
        ])->map(function ($data, $order) use ($village) {
            return VillageGalleryCategory::updateOrCreate(
                [
                    'village_id' => $village->id,
                    'slug' => Str::slug($data['name']),
                ],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'display_order' => $order,
                ]
            );
        });

        $galleryItems = [
            [
                'category' => 'Acara',
                'title' => 'Festival Budaya 2024',
                'media_path' => 'https://images.unsplash.com/photo-1599661046289-50cdda180774?w=800&h=600&fit=crop',
                'taken_at' => '2024-12-01',
                'type' => VillageGalleryItem::TYPE_PHOTO,
            ],
            [
                'category' => 'Acara',
                'title' => 'Lomba Desain Batik',
                'media_path' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&h=600&fit=crop',
                'taken_at' => '2024-09-20',
                'type' => VillageGalleryItem::TYPE_VIDEO,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ],
            [
                'category' => 'Pembangunan',
                'title' => 'Pembangunan Jalan Dusun 2',
                'media_path' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=800&h=600&fit=crop',
                'taken_at' => '2024-11-18',
                'type' => VillageGalleryItem::TYPE_PHOTO,
            ],
            [
                'category' => 'Pembangunan',
                'title' => 'Peresmian Posyandu Sejahtera',
                'media_path' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800&h=600&fit=crop',
                'taken_at' => '2024-08-14',
                'type' => VillageGalleryItem::TYPE_PHOTO,
            ],
            [
                'category' => 'Sosial',
                'title' => 'Program Desa Sehat',
                'media_path' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=800&h=600&fit=crop',
                'taken_at' => '2024-07-05',
                'type' => VillageGalleryItem::TYPE_PHOTO,
            ],
            [
                'category' => 'Sosial',
                'title' => 'Bakti Sosial Desa',
                'media_path' => 'https://images.unsplash.com/photo-1500634245200-e5245c7574ef?w=800&h=600&fit=crop',
                'taken_at' => '2024-05-21',
                'type' => VillageGalleryItem::TYPE_VIDEO,
                'video_url' => 'https://www.youtube.com/watch?v=ysz5S6PUM-U',
            ],
        ];

        foreach ($galleryItems as $item) {
            $category = $galleryCategories->firstWhere('name', $item['category']);

            if (! $category) {
                continue;
            }

            $payload = Arr::except($item, ['category']);

            VillageGalleryItem::updateOrCreate(
                [
                    'village_id' => $village->id,
                    'title' => $item['title'],
                ],
                array_merge($payload, [
                    'village_id' => $village->id,
                    'category_id' => $category->id,
                    'thumbnail_path' => $item['media_path'],
                ])
            );
        }

        $potentials = [
            [
                'title' => 'Air Terjun Sumber Rejeki',
                'category' => 'Wisata Alam',
                'summary' => 'Air terjun alami dengan ketinggian 25 meter dikelilingi hutan lindung.',
                'map_embed' => 'https://maps.google.com/maps?q=-6.175392,106.827153&hl=id&z=12&output=embed',
                'status' => VillagePotential::STATUS_ACTIVE,
            ],
            [
                'title' => 'Kebun Teh Lereng Indah',
                'category' => 'Pertanian',
                'summary' => 'Hamparan kebun teh seluas 15 hektar dengan fasilitas wisata edukasi.',
                'map_embed' => 'https://maps.google.com/maps?q=-6.200000,106.816666&hl=id&z=12&output=embed',
                'status' => VillagePotential::STATUS_DEVELOPMENT,
            ],
            [
                'title' => 'Sentra Batik Daun Padi',
                'category' => 'Ekonomi Kreatif',
                'summary' => 'UMKM batik tulis khas desa dengan motif daun padi dan bambu.',
                'map_embed' => 'https://maps.google.com/maps?q=-6.300000,106.900000&hl=id&z=12&output=embed',
                'status' => VillagePotential::STATUS_ACTIVE,
            ],
        ];

        foreach ($potentials as $potential) {
            VillagePotential::updateOrCreate(
                [
                    'village_id' => $village->id,
                    'slug' => Str::slug($potential['title']),
                ],
                array_merge($potential, [
                    'village_id' => $village->id,
                ])
            );
        }

        $achievements = [
            [
                'title' => 'Juara 1 Desa Digital Tingkat Provinsi',
                'year' => 2024,
                'category' => 'Teknologi dan Informasi',
                'organizer' => 'Pemprov Jawa Barat',
                'description' => 'Pengakuan atas inovasi digitalisasi pelayanan publik desa.',
            ],
            [
                'title' => 'Desa Bersih dan Sehat 2023',
                'year' => 2023,
                'category' => 'Lingkungan',
                'organizer' => 'Kementerian Lingkungan Hidup',
                'description' => 'Kerja gotong royong warga menjaga kebersihan dan sanitasi.',
            ],
            [
                'title' => 'UMKM Kreatif Terbaik',
                'year' => 2022,
                'category' => 'Ekonomi Kreatif',
                'organizer' => 'Kemendes PDTT',
                'description' => 'Pengembangan sentra batik dan produk olahan pangan lokal.',
            ],
        ];

        foreach ($achievements as $achievement) {
            VillageAchievement::updateOrCreate(
                [
                    'village_id' => $village->id,
                    'title' => $achievement['title'],
                ],
                array_merge($achievement, [
                    'village_id' => $village->id,
                ])
            );
        }

        $programs = [
            [
                'title' => 'Program Desa Digital',
                'period' => '2021 - Sekarang',
                'lead' => 'Bidang Pemerintahan',
                'progress' => 85,
                'status' => VillageProgram::STATUS_ACTIVE,
                'description' => 'Digitalisasi layanan administrasi dan informasi desa berbasis web.',
            ],
            [
                'title' => 'Kampung UMKM Naik Kelas',
                'period' => '2022 - 2025',
                'lead' => 'Bidang Ekonomi',
                'progress' => 70,
                'status' => VillageProgram::STATUS_ACTIVE,
                'description' => 'Pendampingan intensif bagi pelaku UMKM untuk ekspansi pasar.',
            ],
            [
                'title' => 'Sekolah Lapang Pertanian Organik',
                'period' => '2023 - 2024',
                'lead' => 'Bidang Pertanian',
                'progress' => 60,
                'status' => VillageProgram::STATUS_ACTIVE,
                'description' => 'Pelatihan pertanian organik untuk petani milenial dan kelompok wanita tani.',
            ],
        ];

        foreach ($programs as $program) {
            VillageProgram::updateOrCreate(
                [
                    'village_id' => $village->id,
                    'title' => $program['title'],
                ],
                array_merge($program, [
                    'village_id' => $village->id,
                ])
            );
        }
    }
}
