<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use App\Models\UmkmContentValidation;
use App\Models\UmkmDigitalGuide;
use App\Models\Village;
use App\Models\VillageGalleryCategory;
use App\Models\VillageNews;
use App\Models\Website;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class VillageManagementController extends Controller
{
    public function index(): View
    {
        $village = Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );

        $profile = $this->buildVillageProfile($village);
        $contacts = collect($village->contacts ?? [])->values();
        $structures = collect($village->structures ?? [])->values();
        $history = collect($village->history ?? [])->values();
        $visionMission = $this->buildVillageVisionMission($village);

        $news = $village->news()
            ->latest('published_at')
            ->latest('created_at')
            ->get();

        $drafts = $village->news()
            ->whereNot('status', VillageNews::STATUS_PUBLISHED)
            ->latest('updated_at')
            ->get();

        $agendas = $this->villageAgendas(); // Placeholder until agenda module available

        $galleryCategories = $village->galleryCategories()
            ->with(['items' => function ($query) {
                $query->where('is_published', true)
                    ->orderByDesc('taken_at')
                    ->orderByDesc('created_at');
            }])
            ->orderBy('display_order')
            ->get();

        $potentials = $village->potentials()->latest('updated_at')->get();
        $achievements = $village->achievements()->orderByDesc('year')->orderByDesc('created_at')->get();
        $programs = $village->programs()->orderByDesc('progress')->orderByDesc('created_at')->get();

        $stats = [
            'news_total' => $news->count(),
            'news_published' => $news->where('status', VillageNews::STATUS_PUBLISHED)->count(),
            'news_draft' => $drafts->count(),
            'gallery_total' => $galleryCategories->sum(fn (VillageGalleryCategory $category) => $category->items->count()),
            'potentials_total' => $potentials->count(),
            'achievements_total' => $achievements->count(),
            'programs_total' => $programs->count(),
        ];

        $tabs = [
            'profile' => 'Profil Desa',
            'news' => 'Berita & Agenda',
            'gallery' => 'Galeri Desa',
            'potency' => 'Potensi & Wisata',
            'achievement' => 'Prestasi & Program',
        ];

        return view('admin.desa.management', [
            'village' => $village,
            'profile' => $profile,
            'contacts' => $contacts,
            'structures' => $structures,
            'history' => $history,
            'visionMission' => $visionMission,
            'news' => $news,
            'agendas' => $agendas,
            'drafts' => $drafts,
            'galleryCategories' => $galleryCategories,
            'potentials' => $potentials,
            'achievements' => $achievements,
            'programs' => $programs,
            'stats' => $stats,
            'tabs' => $tabs,
        ]);
    }

    public function umkm(): View
    {
        $village = Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );

        $categoryPool = [
            'Makanan & Minuman',
            'Kerajinan & Fashion',
            'Kesehatan & Herbal',
            'Pertanian & Perkebunan',
            'Teknologi & Digital',
            'Jasa & Layanan',
        ];

        $statusPalette = [
            'active' => ['label' => 'Aktif', 'badge' => 'bg-emerald-50 text-emerald-600'],
            'onboarding' => ['label' => 'Onboarding', 'badge' => 'bg-sky-50 text-sky-600'],
            'inactive' => ['label' => 'Tidak Aktif', 'badge' => 'bg-gray-100 text-gray-600'],
            'suspended' => ['label' => 'Suspended', 'badge' => 'bg-rose-50 text-rose-600'],
        ];

        // Get UMKM businesses from database
        $umkmBusinesses = UmkmBusiness::query()
            ->with(['user', 'village'])
            ->orderByDesc('created_at')
            ->get();

        $umkmCollection = $umkmBusinesses->map(function (UmkmBusiness $umkm) use ($statusPalette) {
            $statusKey = $umkm->status;
            $created = optional($umkm->created_at)->translatedFormat('d M Y');
            $lastActivity = optional($umkm->last_activity_at ?? $umkm->updated_at)->diffForHumans();

            return [
                'id' => $umkm->id,
                'name' => $umkm->name,
                'owner' => $umkm->owner_name,
                'category' => $umkm->category,
                'status' => $statusKey,
                'status_label' => $umkm->status_label,
                'status_badge' => $umkm->status_badge,
                'subdomain' => $umkm->subdomain,
                'products' => $umkm->products_count,
                'visits' => $umkm->visits_count,
                'orders' => $umkm->orders_count,
                'conversion' => round(($umkm->orders_count / max($umkm->visits_count, 1)) * 100, 1),
                'messages' => $umkm->contentValidations()->where('status', 'review')->count(),
                'last_update' => $lastActivity,
                'created_at' => $created,
            ];
        });

        if ($umkmCollection->isEmpty()) {
            $umkmCollection = collect([
                [
                    'id' => 1,
                    'name' => 'UD Berkah Jaya',
                    'owner' => 'Ibu Siti Nurhaliza',
                    'category' => 'Makanan & Minuman',
                    'status' => 'active',
                    'status_label' => 'Aktif',
                    'status_badge' => 'bg-emerald-50 text-emerald-600',
                    'subdomain' => 'ud-berkah-jaya.desa.begawi.id',
                    'products' => 18,
                    'visits' => 2310,
                    'orders' => 87,
                    'conversion' => 3.8,
                    'messages' => 4,
                    'last_update' => '3 jam lalu',
                    'created_at' => '12 Feb 2024',
                ],
                [
                    'id' => 2,
                    'name' => 'Madu Sari Desa',
                    'owner' => 'Bapak Ahmad Maulana',
                    'category' => 'Kesehatan & Herbal',
                    'status' => 'active',
                    'status_label' => 'Aktif',
                    'status_badge' => 'bg-emerald-50 text-emerald-600',
                    'subdomain' => 'madusari.desa.begawi.id',
                    'products' => 12,
                    'visits' => 1784,
                    'orders' => 64,
                    'conversion' => 3.6,
                    'messages' => 2,
                    'last_update' => '1 hari lalu',
                    'created_at' => '20 Jan 2024',
                ],
                [
                    'id' => 3,
                    'name' => 'Batik Nusantara',
                    'owner' => 'Ibu Dewi Sartika',
                    'category' => 'Kerajinan & Fashion',
                    'status' => 'onboarding',
                    'status_label' => 'Onboarding',
                    'status_badge' => 'bg-sky-50 text-sky-600',
                    'subdomain' => 'batiknusantara.desa.begawi.id',
                    'products' => 9,
                    'visits' => 1432,
                    'orders' => 38,
                    'conversion' => 2.7,
                    'messages' => 6,
                    'last_update' => '5 jam lalu',
                    'created_at' => '5 Feb 2024',
                ],
                [
                    'id' => 4,
                    'name' => 'Kopi Gunung Sari',
                    'owner' => 'Bapak Joko Widodo',
                    'category' => 'Pertanian & Perkebunan',
                    'status' => 'active',
                    'status_label' => 'Aktif',
                    'status_badge' => 'bg-emerald-50 text-emerald-600',
                    'subdomain' => 'kopigunungsari.desa.begawi.id',
                    'products' => 14,
                    'visits' => 1950,
                    'orders' => 72,
                    'conversion' => 3.7,
                    'messages' => 3,
                    'last_update' => '2 jam lalu',
                    'created_at' => '10 Des 2023',
                ],
                [
                    'id' => 5,
                    'name' => 'Kerajinan Ibu-Ibu',
                    'owner' => 'Ibu Rina Melati',
                    'category' => 'Kerajinan & Fashion',
                    'status' => 'inactive',
                    'status_label' => 'Tidak Aktif',
                    'status_badge' => 'bg-gray-100 text-gray-600',
                    'subdomain' => 'kerajinanibuibu.desa.begawi.id',
                    'products' => 6,
                    'visits' => 980,
                    'orders' => 21,
                    'conversion' => 2.1,
                    'messages' => 1,
                    'last_update' => '4 hari lalu',
                    'created_at' => '28 Nov 2023',
                ],
            ]);
        }

        $totalUmkm = $umkmCollection->count();
        $activeUmkm = $umkmCollection->where('status', 'active')->count();
        $onboardingUmkm = $umkmCollection->where('status', 'onboarding')->count();
        $suspendedUmkm = $umkmCollection->where('status', 'suspended')->count();
        $totalProducts = $umkmCollection->sum('products');
        $totalVisits = $umkmCollection->sum('visits');
        $totalOrders = $umkmCollection->sum('orders');

        $overviewCards = [
            [
                'label' => 'UMKM Aktif',
                'value' => number_format($activeUmkm),
                'description' => "{$totalUmkm} total terdaftar",
                'gradient' => 'from-emerald-500 via-emerald-600 to-teal-500',
                'icon' => 'storefront',
                'link' => '#daftar-umkm',
                'link_label' => 'Kelola Direktori',
                'badge' => [
                    'label' => 'Onboarding',
                    'text' => $onboardingUmkm,
                ],
            ],
            [
                'label' => 'Produk Terdaftar',
                'value' => number_format($totalProducts),
                'description' => 'Jumlah produk aktif',
                'gradient' => 'from-indigo-500 via-indigo-600 to-purple-500',
                'icon' => 'category',
                'link' => '#monitoring-aktivitas',
                'link_label' => 'Lihat Aktivitas',
                'badge' => [
                    'label' => 'Order 30 hari',
                    'text' => number_format($totalOrders),
                ],
            ],
            [
                'label' => 'Total Kunjungan',
                'value' => number_format($totalVisits),
                'description' => '30 hari terakhir',
                'gradient' => 'from-amber-500 via-orange-500 to-rose-500',
                'icon' => 'visitors',
                'link' => '#monitoring-aktivitas',
                'link_label' => 'Detail Insight',
            ],
            [
                'label' => 'Pesan Baru',
                'value' => number_format($umkmCollection->sum('messages')),
                'description' => 'Masuk dari admin UMKM',
                'gradient' => 'from-sky-500 via-blue-500 to-indigo-500',
                'icon' => 'chat',
                'link' => '#validasi-konten',
                'link_label' => 'Tinjau Pesan',
            ],
        ];

        $monitoringSummary = [
            [
                'label' => 'Rata-rata Kunjungan',
                'value' => number_format(round($totalVisits / max($totalUmkm, 1))),
                'delta' => '+12% dibanding bulan lalu',
                'badge' => 'bg-emerald-100 text-emerald-600',
            ],
            [
                'label' => 'Konversi Rata-rata',
                'value' => round($totalOrders / max($totalVisits, 1) * 100, 2) . '%',
                'delta' => 'Target 3% tercapai',
                'badge' => 'bg-indigo-100 text-indigo-600',
            ],
            [
                'label' => 'Produk / UMKM',
                'value' => round($totalProducts / max($totalUmkm, 1), 1),
                'delta' => "{$totalProducts} produk aktif",
                'badge' => 'bg-amber-100 text-amber-600',
            ],
        ];

        $monitoringDetails = $umkmCollection->map(function (array $item) {
            return [
                'name' => $item['name'],
                'owner' => $item['owner'],
                'status_label' => $item['status_label'],
                'status_badge' => $item['status_badge'],
                'products' => $item['products'],
                'visits' => $item['visits'],
                'orders' => $item['orders'],
                'conversion' => $item['conversion'],
                'last_update' => $item['last_update'],
                'subdomain' => $item['subdomain'],
            ];
        });

        // Get validation queue from database
        $validationQueue = UmkmContentValidation::query()
            ->with(['umkmBusiness', 'submitter'])
            ->whereIn('status', ['review', 'verification', 'draft'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function (UmkmContentValidation $validation) {
                return [
                    'id' => $validation->id,
                    'type' => $validation->content_type_label,
                    'umkm' => $validation->umkmBusiness->name ?? 'Unknown',
                    'submitted_by' => $validation->submitter->name ?? 'Unknown',
                    'status' => $validation->status,
                    'items' => [
                        $validation->title,
                        $validation->description ? Str::limit($validation->description, 100) : 'Tidak ada deskripsi',
                    ],
                ];
            });

        // Fallback to dummy data if no validations
        if ($validationQueue->isEmpty()) {
            $validationQueue = collect([
            [
                'id' => 101,
                'type' => 'Produk Baru',
                'umkm' => 'UD Berkah Jaya',
                'submitted_by' => 'Admin UMKM · 2 jam lalu',
                'items' => [
                    'Keripik Singkong Rasa Balado',
                    'Foto produk & deskripsi',
                ],
                'status' => 'review',
            ],
            [
                'id' => 102,
                'type' => 'Update Foto',
                'umkm' => 'Batik Nusantara',
                'submitted_by' => 'Admin UMKM · 5 jam lalu',
                'items' => [
                    'Galeri produk motif daun padi',
                ],
                'status' => 'verification',
            ],
            [
                'id' => 103,
                'type' => 'Promosi',
                'umkm' => 'Kopi Gunung Sari',
                'submitted_by' => 'Admin UMKM · 1 hari lalu',
                'items' => [
                    'Banner promo Ramadan',
                ],
                'status' => 'draft',
            ],
        ]);
        }

        // Get digital guides from database
        $digitalGuides = UmkmDigitalGuide::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get()
            ->map(function (UmkmDigitalGuide $guide) {
                $duration = $guide->duration_minutes 
                    ? "{$guide->duration_minutes} menit" 
                    : ($guide->file_type === 'video' ? 'Video' : '8 menit baca');
                
                return [
                    'title' => $guide->title,
                    'category' => $guide->category_label,
                    'duration' => $duration,
                    'updated_at' => optional($guide->updated_at)->translatedFormat('d M Y'),
                    'link' => route('admin.desa-management.umkm') . '#guide-' . $guide->id,
                ];
            });

        // Fallback to dummy data if no guides
        if ($digitalGuides->isEmpty()) {
            $digitalGuides = collect([
            [
                'title' => 'Panduan Foto Produk UMKM',
                'category' => 'Tips Promosi',
                'duration' => '8 menit baca',
                'updated_at' => '10 Feb 2024',
                'link' => '#',
            ],
            [
                'title' => 'Template Media Sosial Gratis',
                'category' => 'Materi Promosi',
                'duration' => 'Canva & PowerPoint',
                'updated_at' => '08 Feb 2024',
                'link' => '#',
            ],
            [
                'title' => 'Modul Pelatihan Marketplace',
                'category' => 'Pelatihan Online',
                'duration' => 'Rekaman Zoom · 45 menit',
                'updated_at' => '02 Feb 2024',
                'link' => '#',
            ],
        ]);
        }

        $upcomingTrainings = collect([
            [
                'title' => 'Optimasi Toko UMKM',
                'date' => '20 Feb 2024',
                'time' => '19:30 WIB',
                'medium' => 'Zoom Meeting',
                'status' => 'Terbuka',
            ],
            [
                'title' => 'Kelas Copywriting Produk',
                'date' => '27 Feb 2024',
                'time' => '10:00 WIB',
                'medium' => 'Offline · Balai Desa',
                'status' => 'Terbatas',
            ],
        ]);

        $latestMessages = collect([
            [
                'umkm' => 'UD Berkah Jaya',
                'excerpt' => 'Mohon bantuan update stok produk menjelang event desa.',
                'time' => '5 menit lalu',
            ],
            [
                'umkm' => 'Madu Sari Desa',
                'excerpt' => 'Apakah bisa ditambahkan opsi pembayaran COD untuk pesanan lokal?',
                'time' => '45 menit lalu',
            ],
            [
                'umkm' => 'Batik Nusantara',
                'excerpt' => 'Mengajukan permintaan domain custom: batiknusantara.id',
                'time' => '2 jam lalu',
            ],
        ]);

        $quickActions = collect([
            [
                'label' => 'Tambah UMKM',
                'description' => 'Daftarkan pelaku usaha baru',
                'link' => '#tambah-umkm-baru',
                'icon' => 'plus',
                'color' => 'from-emerald-500 to-teal-500',
            ],
            [
                'label' => 'Validasi Produk',
                'description' => 'Setujui konten menunggu',
                'link' => '#validasi-konten',
                'icon' => 'content',
                'color' => 'from-amber-500 to-orange-500',
            ],
            [
                'label' => 'Kirim Bimbingan',
                'description' => 'Upload materi pelatihan',
                'link' => '#bimbingan-digital',
                'icon' => 'progress',
                'color' => 'from-indigo-500 to-purple-500',
            ],
        ]);

        $chart = [
            'visits' => [
                'labels' => ['Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb'],
                'dataset' => [1120, 1380, 1560, 1890, 2150, 2435],
            ],
            'conversion' => [
                'labels' => ['Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb'],
                'dataset' => [2.3, 2.5, 2.7, 3.1, 3.4, 3.8],
            ],
        ];

        return view('admin.desa.umkm', [
            'village' => $village,
            'overviewCards' => $overviewCards,
            'umkmList' => $umkmCollection,
            'categoryFilters' => $categoryPool,
            'monitoringSummary' => $monitoringSummary,
            'monitoringDetails' => $monitoringDetails,
            'validationQueue' => $validationQueue,
            'digitalGuides' => $digitalGuides,
            'upcomingTrainings' => $upcomingTrainings,
            'latestMessages' => $latestMessages,
            'quickActions' => $quickActions,
            'chart' => $chart,
            'domainSuffix' => 'desa.begawi.id',
        ]);
    }

    protected function buildVillageProfile(Village $village): array
    {
        return [
            'logo' => $village->logo_path,
            'name' => $village->name,
            'tagline' => $village->tagline,
            'head' => $village->head,
            'head_title' => $village->head_title,
            'location' => $village->location,
            'code' => $village->code,
            'population' => $village->population,
            'area' => $village->area,
            'density' => $village->density,
        ];
    }

    protected function buildVillageVisionMission(Village $village): array
    {
        return [
            'vision' => $village->vision,
            'vision_period' => $village->vision_period,
            'missions' => $village->missions ?? [],
        ];
    }

    protected function villageAgendas(): Collection
    {
        // TODO: Replace with agenda module once available
        return collect([
            [
                'title' => 'Rapat Koordinasi Pembangunan Infrastruktur',
                'date' => '20 Jan 2024',
                'time' => '09:00',
                'location' => 'Balai Desa',
                'category' => 'Rapat',
                'status' => 'Terjadwal',
            ],
            [
                'title' => 'Pelatihan Digital Marketing UMKM',
                'date' => '22 Jan 2024',
                'time' => '13:00',
                'location' => 'Ruang Multimedia',
                'category' => 'Pelatihan',
                'status' => 'Terbuka',
            ],
            [
                'title' => 'Festival Panen Raya',
                'date' => '28 Jan 2024',
                'time' => '08:00',
                'location' => 'Lapangan Utama',
                'category' => 'Acara',
                'status' => 'Persiapan',
            ],
        ]);
    }
}

