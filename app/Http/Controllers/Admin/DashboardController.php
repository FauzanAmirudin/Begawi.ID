<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\InformationPage;
use App\Models\PaymentGatewayConfig;
use App\Models\SubscriptionPackage;
use App\Models\Transaction;
use App\Models\UmkmBusiness;
use App\Models\UmkmContentValidation;
use App\Models\User;
use App\Models\VideoDocumentation;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->role === User::ROLE_SUPER_ADMIN) {
            return $this->renderSuperAdminDashboard();
        }

        if ($user && $user->role === User::ROLE_ADMIN_DESA) {
            return $this->renderVillageAdminDashboard();
        }

        if ($user && $user->role === User::ROLE_ADMIN_UMKM) {
            return $this->renderUmkmAdminDashboard();
        }

        return $this->renderDefaultDashboard();
    }

    /**
     * Render dashboard for Super Admin with platform level insights.
     */
    protected function renderSuperAdminDashboard()
    {
        $websites = Website::select(['id', 'name', 'type', 'status', 'created_at', 'updated_at', 'user_id'])
            ->with('user:id,name')
            ->get();

        $totalTenants = $websites->count();
        $activeTenants = $websites->where('status', 'active')->count();
        $suspendedTenants = $websites->where('status', 'suspended')->count();
        $inactiveTenants = $websites->where('status', 'inactive')->count();
        $desaTenants = $websites->where('type', 'desa')->count();
        $umkmTenants = $websites->where('type', 'umkm')->count();
        $activeDesa = $websites->where('type', 'desa')->where('status', 'active')->count();
        $activeUmkm = $websites->where('type', 'umkm')->where('status', 'active')->count();

        $activeUsers = User::where('status', 'active')->count();
        $newUsersThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();

        $transactionsSuccess = Transaction::where('status', 'success');
        $revenueThisMonth = (clone $transactionsSuccess)
            ->whereBetween('paid_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');
        $revenueThisYear = (clone $transactionsSuccess)
            ->whereBetween('paid_at', [now()->startOfYear(), now()->endOfYear()])
            ->sum('amount');

        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $failedTransactions = Transaction::where('status', 'failed')->count();

        $activePackages = SubscriptionPackage::where('is_active', true)->count();
        $totalPackages = SubscriptionPackage::count();
        $activeGateways = PaymentGatewayConfig::where('is_active', true)->count();
        $publishedArticles = Article::where('is_published', true)->count();
        $publishedVideos = VideoDocumentation::where('is_published', true)->count();
        $informationPages = InformationPage::count();

        $supportStats = $this->supportTicketStats();
        $totalSupportTickets = array_sum([$supportStats['open'], $supportStats['in_progress'], $supportStats['resolved']]);

        $overviewCards = [
            [
                'label' => 'Tenant Aktif',
                'value' => number_format($activeTenants),
                'description' => $totalTenants > 0
                    ? round(($activeTenants / $totalTenants) * 100) . "% dari {$totalTenants} tenant"
                    : 'Belum ada tenant terdaftar',
                'gradient' => 'from-green-500 to-green-600',
                'icon' => 'grid',
                'link' => route('admin.platform-directory.index'),
                'link_label' => 'Direktori Platform',
                'badge' => [
                    'label' => '+ ' . number_format($this->countNewWebsites($websites, now()->startOfMonth())),
                    'text' => 'Tenant baru bulan ini',
                ],
            ],
            [
                'label' => 'Pendapatan Bulan Ini',
                'value' => $this->formatCurrency($revenueThisMonth),
                'description' => 'Total pendapatan transaksi sukses',
                'gradient' => 'from-purple-500 to-purple-600',
                'icon' => 'wallet',
                'link' => route('admin.finance.transactions.index'),
                'link_label' => 'Riwayat Transaksi',
                'badge' => [
                    'label' => $pendingTransactions . ' Pending',
                    'text' => 'Menunggu verifikasi',
                ],
            ],
            [
                'label' => 'Admin Aktif',
                'value' => number_format($activeUsers),
                'description' => $newUsersThisMonth . ' akun baru bulan ini',
                'gradient' => 'from-orange-500 to-red-500',
                'icon' => 'users',
                'link' => route('admin.users.index'),
                'link_label' => 'Kelola Pengguna',
                'badge' => [
                    'label' => $failedTransactions . ' Gagal',
                    'text' => 'Transaksi butuh review',
                ],
            ],
        ];

        $secondaryCards = [
            [
                'label' => 'Website Desa',
                'value' => number_format($desaTenants),
                'description' => "{$activeDesa} aktif · " . ($desaTenants - $activeDesa) . " menunggu",
                'gradient' => 'from-blue-500 to-blue-600',
                'icon' => 'village',
                'link' => route('admin.websites.desa'),
                'link_label' => 'Kelola Desa',
            ],
            [
                'label' => 'Website UMKM',
                'value' => number_format($umkmTenants),
                'description' => "{$activeUmkm} aktif · " . ($umkmTenants - $activeUmkm) . " pendampingan",
                'gradient' => 'from-gray-800 to-gray-900',
                'icon' => 'storefront',
                'link' => route('admin.websites.umkm'),
                'link_label' => 'Kelola UMKM',
            ],
            [
                'label' => 'Konten Terbit',
                'value' => number_format($publishedArticles + $publishedVideos + $informationPages),
                'description' => "{$publishedArticles} artikel · {$publishedVideos} video · {$informationPages} halaman",
                'gradient' => 'from-cyan-500 to-blue-500',
                'icon' => 'content',
                'link' => route('admin.content.articles.index'),
                'link_label' => 'Manajemen Konten',
            ],
        ];

        $operationalMetrics = [
            [
                'label' => 'Rasio Tenant Aktif',
                'percentage' => $totalTenants > 0 ? round(($activeTenants / $totalTenants) * 100) : 0,
                'badge' => "{$activeTenants} / {$totalTenants}",
                'color' => 'bg-orange-500',
            ],
            [
                'label' => 'Paket Aktif',
                'percentage' => $totalPackages > 0 ? round(($activePackages / $totalPackages) * 100) : 0,
                'badge' => "{$activePackages} paket",
                'color' => 'bg-blue-500',
            ],
            [
                'label' => 'Tiket Terselesaikan',
                'percentage' => $totalSupportTickets > 0 ? round(($supportStats['resolved'] / $totalSupportTickets) * 100) : 0,
                'badge' => "{$supportStats['resolved']} tiket",
                'color' => 'bg-purple-500',
            ],
            [
                'label' => 'Integrasi Gateway Aktif',
                'percentage' => min(100, $activeGateways * 50),
                'badge' => "{$activeGateways} gateway",
                'color' => 'bg-teal-500',
            ],
        ];

        $charts = [
            'tenant_growth' => $this->tenantGrowthChart($websites),
            'status_distribution' => $this->tenantStatusDistribution($activeTenants, $suspendedTenants, $inactiveTenants),
            'financial_highlight' => [
                'this_year' => $this->formatCurrency($revenueThisYear),
                'pending' => $pendingTransactions,
                'failed' => $failedTransactions,
            ],
        ];

        $latestEvents = $this->latestPlatformEvents();

        return view('admin.super-admin.dashboard.index', [
            'overviewCards' => $overviewCards,
            'secondaryCards' => $secondaryCards,
            'operationalMetrics' => $operationalMetrics,
            'charts' => $charts,
            'latestEvents' => $latestEvents,
            'dashboardRole' => 'super_admin',
        ]);
    }

    /**
     * Render dashboard for village (admin desa) role with localised insights.
     */
    protected function renderVillageAdminDashboard()
    {
        $umkmProfiles = $this->villageUmkmProfiles();
        $activeUmkm = $umkmProfiles->where('status', 'active')->count();
        $umkmPending = $umkmProfiles->sum('pending_validation');

        $visitorStats = $this->villageVisitorStats();
        $totalVisitors = array_sum($visitorStats['dataset']);

        $news = $this->villageNewsDataset();
        $gallery = $this->villageGalleryDataset();
        $potencies = $this->villagePotencyDataset();

        $overviewCards = [
            [
                'label' => 'UMKM Aktif',
                'value' => number_format($activeUmkm),
                'description' => "{$umkmProfiles->count()} total binaan desa",
                'gradient' => 'from-emerald-500 to-teal-500',
                'icon' => 'umkm',
                'link' => route('desa.umkm.index'),
                'link_label' => 'Lihat Direktori UMKM',
                'badge' => [
                    'label' => '+ ' . $umkmProfiles->sum('new_products'),
                    'text' => 'Produk baru pekan ini',
                ],
            ],
            [
                'label' => 'Pengunjung Website',
                'value' => number_format($totalVisitors),
                'description' => '12 bulan terakhir',
                'gradient' => 'from-purple-500 to-indigo-500',
                'icon' => 'visitors',
                'link' => route('desa.home'),
                'link_label' => 'Lihat Website Desa',
                'badge' => [
                    'label' => '+'.$visitorStats['growth'].'%',
                    'text' => 'Pertumbuhan bulan ini',
                ],
            ],
            [
                'label' => 'Konten Terbit',
                'value' => number_format($news->count() + $gallery->count() + $potencies->count()),
                'description' => "{$news->count()} berita · {$gallery->count()} galeri · {$potencies->count()} potensi",
                'gradient' => 'from-orange-500 to-pink-500',
                'icon' => 'content',
                'link' => route('desa.berita.index'),
                'link_label' => 'Kelola Konten Desa',
                'badge' => [
                    'label' => $umkmPending . ' Draft',
                    'text' => 'Menunggu validasi',
                ],
            ],
        ];

        $secondaryCards = [
            [
                'label' => 'Berita Desa',
                'value' => number_format($news->count()),
                'description' => 'Update kegiatan & informasi desa',
                'gradient' => 'from-blue-500 to-blue-600',
                'icon' => 'news',
                'link' => route('desa.berita.index'),
                'link_label' => 'Kelola Berita',
            ],
            [
                'label' => 'Galeri & Dokumentasi',
                'value' => number_format($gallery->count()),
                'description' => 'Momen terbaru di desa',
                'gradient' => 'from-rose-500 to-amber-500',
                'icon' => 'gallery',
                'link' => route('desa.galeri-wisata.index'),
                'link_label' => 'Kelola Galeri',
            ],
            [
                'label' => 'Potensi Unggulan',
                'value' => number_format($potencies->count()),
                'description' => 'Destinasi & potensi desa',
                'gradient' => 'from-cyan-500 to-teal-500',
                'icon' => 'potency',
                'link' => route('desa.galeri-wisata.index'),
                'link_label' => 'Kelola Potensi',
            ],
        ];

        $charts = [
            'visitors' => $visitorStats,
            'umkm_distribution' => $this->villageUmkmDistribution($umkmProfiles),
            'content_trend' => $this->villageContentTrend($news, $gallery, $potencies),
        ];

        $activityFeed = $this->villageActivityFeed($umkmProfiles);
        $pendingValidations = $this->villagePendingContent();
        $quickActions = $this->villageQuickActions();
        $sidebarHighlights = $this->villageSidebarHighlights($umkmProfiles);

        return view('admin.admin-desa.dashboard.desa', [
            'overviewCards' => $overviewCards,
            'secondaryCards' => $secondaryCards,
            'charts' => $charts,
            'activityFeed' => $activityFeed,
            'pendingValidations' => $pendingValidations,
            'quickActions' => $quickActions,
            'sidebarHighlights' => $sidebarHighlights,
            'visitorSummary' => [
                'total' => number_format($totalVisitors),
                'average' => number_format($visitorStats['average']),
                'growth' => $visitorStats['growth'],
            ],
        ]);
    }

    /**
     * Render dashboard for UMKM admin with business-specific insights.
     */
    protected function renderUmkmAdminDashboard()
    {
        $user = Auth::user();
        
        // Get UMKM business for this user
        $umkmBusiness = UmkmBusiness::where('user_id', $user->id)->first();
        
        if (!$umkmBusiness) {
            // Return dashboard with empty data and error message instead of redirecting
            return $this->renderUmkmAdminDashboardEmpty('UMKM business tidak ditemukan untuk akun Anda. Silakan hubungi administrator untuk mendaftarkan UMKM business Anda.');
        }

        // Total produk aktif (approved products)
        $totalActiveProducts = UmkmContentValidation::where('umkm_business_id', $umkmBusiness->id)
            ->where('content_type', 'product')
            ->where('status', 'approved')
            ->count();

        // Jumlah pengunjung website UMKM
        $totalVisitors = $umkmBusiness->visits_count ?? 0;

        // Produk paling banyak dilihat (using content_data or placeholder)
        $topProducts = UmkmContentValidation::where('umkm_business_id', $umkmBusiness->id)
            ->where('content_type', 'product')
            ->where('status', 'approved')
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->map(function ($product) {
                $views = $product->content_data['views'] ?? rand(10, 500);
                return [
                    'title' => $product->title,
                    'views' => $views,
                    'image' => $product->content_data['image'] ?? null,
                ];
            })
            ->sortByDesc('views')
            ->take(3)
            ->values();

        // Notifikasi: produk menunggu verifikasi
        $pendingProducts = UmkmContentValidation::where('umkm_business_id', $umkmBusiness->id)
            ->where('content_type', 'product')
            ->whereIn('status', ['review', 'verification'])
            ->count();

        // Template update notifications (placeholder - can be enhanced later)
        $templateUpdateNeeded = false; // Can be enhanced with actual template version checking

        // Aktivitas terakhir
        $recentActivities = UmkmContentValidation::where('umkm_business_id', $umkmBusiness->id)
            ->latest('updated_at')
            ->take(6)
            ->get()
            ->map(function ($activity) {
                $activityType = match($activity->content_type) {
                    'product' => 'Produk',
                    'photo' => 'Foto',
                    'promotion' => 'Promosi',
                    'profile_update' => 'Profil',
                    default => 'Konten',
                };
                
                $action = match($activity->status) {
                    'approved' => 'disetujui',
                    'review' => 'menunggu review',
                    'revision_requested' => 'perlu revisi',
                    default => 'diperbarui',
                };

                return [
                    'time' => $activity->updated_at->format('H:i'),
                    'type' => 'product_update',
                    'title' => $activityType . ' ' . $action,
                    'user' => $activity->submitter->name ?? 'Anda',
                    'desc' => $activity->title,
                ];
            })
            ->toArray();

        // Overview Cards
        $overviewCards = [
            [
                'label' => 'Total Produk Aktif',
                'value' => number_format($totalActiveProducts),
                'description' => 'Produk yang sudah disetujui dan aktif',
                'gradient' => 'from-emerald-500 to-teal-500',
                'icon' => 'storefront',
                'link' => '#', // Can be linked to products page later
                'link_label' => 'Lihat Produk',
                'badge' => [
                    'label' => $pendingProducts . ' Pending',
                    'text' => 'Menunggu verifikasi',
                ],
            ],
            [
                'label' => 'Pengunjung Website',
                'value' => number_format($totalVisitors),
                'description' => 'Total pengunjung website UMKM',
                'gradient' => 'from-purple-500 to-indigo-500',
                'icon' => 'visitors',
                'link' => $umkmBusiness->website ? 'https://' . $umkmBusiness->subdomain : '#',
                'link_label' => 'Lihat Website',
                'badge' => [
                    'label' => '+12%',
                    'text' => 'Bulan ini',
                ],
            ],
            [
                'label' => 'Produk Paling Dilihat',
                'value' => $topProducts->isNotEmpty() ? $topProducts->first()['title'] : '-',
                'description' => $topProducts->isNotEmpty() ? number_format($topProducts->first()['views']) . ' kali dilihat' : 'Belum ada data',
                'gradient' => 'from-orange-500 to-pink-500',
                'icon' => 'content',
                'link' => '#',
                'link_label' => 'Lihat Detail',
            ],
        ];

        // Secondary Cards
        $secondaryCards = [
            [
                'label' => 'Produk Menunggu Verifikasi',
                'value' => number_format($pendingProducts),
                'description' => 'Produk yang perlu ditinjau',
                'gradient' => 'from-amber-500 to-orange-500',
                'icon' => 'content',
                'link' => '#',
                'link_label' => 'Lihat Daftar',
            ],
            [
                'label' => 'Update Template',
                'value' => $templateUpdateNeeded ? 'Tersedia' : 'Terbaru',
                'description' => $templateUpdateNeeded ? 'Template baru tersedia' : 'Template sudah terbaru',
                'gradient' => $templateUpdateNeeded ? 'from-blue-500 to-blue-600' : 'from-gray-500 to-gray-600',
                'icon' => 'content',
                'link' => '#',
                'link_label' => 'Cek Update',
            ],
            [
                'label' => 'Total Pesanan',
                'value' => number_format($umkmBusiness->orders_count ?? 0),
                'description' => 'Pesanan yang masuk',
                'gradient' => 'from-cyan-500 to-teal-500',
                'icon' => 'storefront',
                'link' => '#',
                'link_label' => 'Lihat Pesanan',
            ],
        ];

        // Quick Actions
        $quickActions = [
            [
                'label' => 'Tambah Produk',
                'description' => 'Tambahkan produk baru ke katalog',
                'link' => '#', // Can be linked to add product page
                'icon' => 'plus',
                'color' => 'from-emerald-500 to-teal-500',
            ],
            [
                'label' => 'Edit Profil',
                'description' => 'Perbarui informasi UMKM',
                'link' => '#', // Can be linked to profile edit page
                'icon' => 'content',
                'color' => 'from-blue-500 to-indigo-500',
            ],
            [
                'label' => 'Tambah Banner',
                'description' => 'Unggah banner promosi',
                'link' => '#', // Can be linked to banner management
                'icon' => 'media',
                'color' => 'from-rose-500 to-orange-500',
            ],
        ];

        // Charts data (placeholder for now)
        $charts = [
            'visitors' => $this->umkmVisitorStats($umkmBusiness),
            'products' => $this->umkmProductsChart($umkmBusiness),
        ];

        // Sidebar highlights
        $sidebarHighlights = [
            'topProducts' => $topProducts->toArray(),
            'stats' => [
                'totalProducts' => $totalActiveProducts,
                'pendingProducts' => $pendingProducts,
            ],
        ];

        return view('admin.admin-umkm.dashboard.umkm', [
            'overviewCards' => $overviewCards,
            'secondaryCards' => $secondaryCards,
            'charts' => $charts,
            'activityFeed' => $recentActivities,
            'pendingValidations' => UmkmContentValidation::where('umkm_business_id', $umkmBusiness->id)
                ->whereIn('status', ['review', 'verification'])
                ->latest('created_at')
                ->take(5)
                ->get()
                ->map(function ($validation) {
                    return [
                        'type' => $validation->content_type_label,
                        'title' => $validation->title,
                        'submitted_by' => $validation->submitter->name ?? 'Anda',
                        'submitted_at' => $validation->created_at->format('d M · H:i'),
                        'status' => $validation->status,
                    ];
                })
                ->toArray(),
            'quickActions' => $quickActions,
            'sidebarHighlights' => $sidebarHighlights,
            'visitorSummary' => [
                'total' => number_format($totalVisitors),
                'average' => number_format($totalVisitors > 0 ? $totalVisitors / 30 : 0),
                'growth' => 12, // Placeholder
            ],
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Render dashboard for UMKM admin when business is not found.
     */
    protected function renderUmkmAdminDashboardEmpty(string $errorMessage)
    {
        // Empty/default data for dashboard
        $overviewCards = [
            [
                'label' => 'Total Produk Aktif',
                'value' => '0',
                'description' => 'Belum ada produk terdaftar',
                'gradient' => 'from-gray-400 to-gray-500',
                'icon' => 'storefront',
                'link' => '#',
                'link_label' => 'Lihat Produk',
            ],
            [
                'label' => 'Pengunjung Website',
                'value' => '0',
                'description' => 'Belum ada data pengunjung',
                'gradient' => 'from-gray-400 to-gray-500',
                'icon' => 'visitors',
                'link' => '#',
                'link_label' => 'Lihat Website',
            ],
            [
                'label' => 'Produk Paling Dilihat',
                'value' => '-',
                'description' => 'Belum ada data',
                'gradient' => 'from-gray-400 to-gray-500',
                'icon' => 'content',
                'link' => '#',
                'link_label' => 'Lihat Detail',
            ],
        ];

        $secondaryCards = [
            [
                'label' => 'Produk Menunggu Verifikasi',
                'value' => '0',
                'description' => 'Belum ada produk',
                'gradient' => 'from-gray-400 to-gray-500',
                'icon' => 'content',
                'link' => '#',
                'link_label' => 'Lihat Daftar',
            ],
            [
                'label' => 'Update Template',
                'value' => 'Terbaru',
                'description' => 'Template sudah terbaru',
                'gradient' => 'from-gray-400 to-gray-500',
                'icon' => 'content',
                'link' => '#',
                'link_label' => 'Cek Update',
            ],
            [
                'label' => 'Total Pesanan',
                'value' => '0',
                'description' => 'Belum ada pesanan',
                'gradient' => 'from-gray-400 to-gray-500',
                'icon' => 'storefront',
                'link' => '#',
                'link_label' => 'Lihat Pesanan',
            ],
        ];

        $quickActions = [
            [
                'label' => 'Hubungi Administrator',
                'description' => 'Daftarkan UMKM business Anda',
                'link' => '#',
                'icon' => 'content',
                'color' => 'from-blue-500 to-indigo-500',
            ],
        ];

        $charts = [
            'visitors' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                'dataset' => [0, 0, 0, 0, 0, 0],
                'growth' => 0,
                'average' => 0,
            ],
            'products' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                'dataset' => [0, 0, 0, 0, 0, 0],
            ],
        ];

        return view('admin.admin-umkm.dashboard.umkm', [
            'overviewCards' => $overviewCards,
            'secondaryCards' => $secondaryCards,
            'charts' => $charts,
            'activityFeed' => [],
            'pendingValidations' => [],
            'quickActions' => $quickActions,
            'sidebarHighlights' => [
                'topProducts' => [],
                'stats' => [
                    'totalProducts' => 0,
                    'pendingProducts' => 0,
                ],
            ],
            'visitorSummary' => [
                'total' => '0',
                'average' => '0',
                'growth' => 0,
            ],
            'umkmBusiness' => null,
            'errorMessage' => $errorMessage,
        ]);
    }

    /**
     * Get UMKM visitor stats
     */
    protected function umkmVisitorStats($umkmBusiness): array
    {
        $months = collect(range(5, 0))->map(function (int $offset) {
            return Carbon::now()->subMonths($offset);
        });

        // Placeholder data - can be enhanced with actual visitor tracking
        $baseVisitors = $umkmBusiness->visits_count ?? 0;
        $dataset = [];
        foreach (range(0, 5) as $i) {
            $dataset[] = (int) ($baseVisitors / 6) + rand(0, 50);
        }

        return [
            'labels' => $months->map(fn (Carbon $month) => $month->translatedFormat('M'))->all(),
            'dataset' => $dataset,
            'growth' => 12,
            'average' => (int) round(array_sum($dataset) / max(count($dataset), 1)),
        ];
    }

    /**
     * Get UMKM products chart data
     */
    protected function umkmProductsChart($umkmBusiness): array
    {
        $months = collect(range(5, 0))->map(function (int $offset) {
            return Carbon::now()->subMonths($offset);
        });

        $dataset = [];
        foreach (range(0, 5) as $i) {
            $count = UmkmContentValidation::where('umkm_business_id', $umkmBusiness->id)
                ->where('content_type', 'product')
                ->where('status', 'approved')
                ->whereMonth('created_at', Carbon::now()->subMonths(5 - $i)->month)
                ->whereYear('created_at', Carbon::now()->subMonths(5 - $i)->year)
                ->count();
            $dataset[] = $count;
        }

        return [
            'labels' => $months->map(fn (Carbon $month) => $month->translatedFormat('M'))->all(),
            'dataset' => $dataset,
        ];
    }

    /**
     * Default dashboard data placeholder for other roles.
     */
    protected function renderDefaultDashboard()
    {
        $overviewCards = [
            [
                'label' => 'Statistik Halaman',
                'value' => number_format(1345),
                'description' => 'Pertumbuhan 12% dari bulan lalu',
                'gradient' => 'from-green-500 to-green-600',
                'icon' => 'grid',
                'link' => '#',
                'link_label' => 'Lihat Detail',
                'badge' => [
                    'label' => '+124',
                    'text' => 'Halaman baru',
                ],
            ],
            [
                'label' => 'Postingan Konten',
                'value' => number_format(12456),
                'description' => 'Konten aktif di seluruh tenant',
                'gradient' => 'from-purple-500 to-purple-600',
                'icon' => 'content',
                'link' => '#',
                'link_label' => 'Kelola Konten',
                'badge' => [
                    'label' => '58 Draft',
                    'text' => 'Menunggu review',
                ],
            ],
            [
                'label' => 'Pengguna Aktif',
                'value' => number_format(21),
                'description' => 'Pengguna login 24 jam terakhir',
                'gradient' => 'from-orange-500 to-red-500',
                'icon' => 'users',
                'link' => '#',
                'link_label' => 'Kelola Pengguna',
                'badge' => [
                    'label' => '3 Baru',
                    'text' => 'Registrasi minggu ini',
                ],
            ],
        ];

        $secondaryCards = [
            [
                'label' => 'File Media',
                'value' => number_format(1220),
                'description' => 'Total file terunggah',
                'gradient' => 'from-blue-500 to-blue-600',
                'icon' => 'media',
                'link' => '#',
                'link_label' => 'Kelola Media',
            ],
            [
                'label' => 'Kategori Konten',
                'value' => number_format(65),
                'description' => 'Kategori aktif dalam sistem',
                'gradient' => 'from-gray-800 to-gray-900',
                'icon' => 'category',
                'link' => '#',
                'link_label' => 'Kelola Kategori',
            ],
            [
                'label' => 'Komentar Masuk',
                'value' => number_format(9876),
                'description' => 'Komentar publikasi',
                'gradient' => 'from-cyan-500 to-blue-500',
                'icon' => 'comment',
                'link' => '#',
                'link_label' => 'Lihat Komentar',
            ],
        ];

        $operationalMetrics = [
            [
                'label' => 'Visitors',
                'percentage' => 75,
                'badge' => '11K',
                'color' => 'bg-orange-500',
            ],
            [
                'label' => 'Subscribers',
                'percentage' => 60,
                'badge' => '60%',
                'color' => 'bg-blue-500',
            ],
            [
                'label' => 'Contributor',
                'percentage' => 45,
                'badge' => '45%',
                'color' => 'bg-purple-500',
            ],
            [
                'label' => 'Author',
                'percentage' => 30,
                'badge' => '30%',
                'color' => 'bg-teal-500',
            ],
        ];

        $charts = [
            'tenant_growth' => [
                'labels' => collect(range(1, 12))->map(function ($month) {
                    return Carbon::now()->subMonths(12 - $month)->format('M');
                }),
                'dataset' => [120, 180, 150, 200, 170, 190, 160, 210, 180, 220, 190, 240],
                'total' => 2640,
                'highlight' => [
                    'label' => 'Aktivitas',
                    'value' => '432 Users',
                ],
            ],
            'status_distribution' => [
                'labels' => ['Aktif', 'Suspended'],
                'values' => [75, 25],
            ],
            'financial_highlight' => [
                'this_year' => $this->formatCurrency(0),
                'pending' => 0,
                'failed' => 0,
            ],
        ];

        $latestEvents = $this->placeholderEvents();

        return view('admin.super-admin.dashboard.index', [
            'overviewCards' => $overviewCards,
            'secondaryCards' => $secondaryCards,
            'operationalMetrics' => $operationalMetrics,
            'charts' => $charts,
            'latestEvents' => $latestEvents,
            'dashboardRole' => 'default',
        ]);
    }

    /**
     * Calculate tenant growth data for chart visualisation.
     */
    protected function tenantGrowthChart(Collection $websites): array
    {
        $months = collect(range(11, 0))->map(function ($offset) {
            $period = Carbon::now()->subMonths($offset);

            return [
                'key' => $period->format('Y-m'),
                'label' => $period->translatedFormat('M'),
            ];
        });

        $grouped = $websites->groupBy(function (Website $website) {
            $timestamp = $website->created_at ?? $website->updated_at ?? Carbon::now();

            return $timestamp->format('Y-m');
        });

        $dataset = $months->map(function (array $month) use ($grouped) {
            return (int) $grouped->get($month['key'], collect())->count();
        })->all();

        $total = array_sum($dataset);

        return [
            'labels' => $months->pluck('label')->all(),
            'dataset' => $dataset,
            'total' => $total,
            'highlight' => [
                'label' => 'Tenant baru 12 bulan',
                'value' => number_format($total),
            ],
        ];
    }

    /**
     * Calculate tenant status distribution for doughnut chart.
     */
    protected function tenantStatusDistribution(int $active, int $suspended, int $inactive): array
    {
        return [
            'labels' => ['Aktif', 'Suspend', 'Nonaktif'],
            'values' => [$active, $suspended, $inactive],
        ];
    }

    /**
     * Gather latest platform events.
     */
    protected function latestPlatformEvents(): array
    {
        $websiteEvents = Website::with('user:id,name')
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function (Website $website) {
                $timestamp = $website->created_at ?? Carbon::now();
                return [
                    'timestamp' => $timestamp,
                    'time' => $timestamp->format('d M · H:i'),
                    'type' => $website->type === 'desa' ? 'desa' : 'umkm',
                    'title' => 'Tenant Baru: ' . $website->name,
                    'user' => optional($website->user)->name ?? 'Sistem',
                    'desc' => 'Status ' . ucfirst($website->status) . ' · ' . ($website->custom_domain ?: $website->url),
                ];
            })
            ->values()
            ->toBase();

        $transactionEvents = Transaction::latest('created_at')
            ->take(5)
            ->get()
            ->map(function (Transaction $transaction) {
                $timestamp = $transaction->created_at ?? Carbon::now();
                return [
                    'timestamp' => $timestamp,
                    'time' => $timestamp->format('d M · H:i'),
                    'type' => 'transaction',
                    'title' => 'Transaksi ' . strtoupper($transaction->status),
                    'user' => optional($transaction->user)->name ?? 'Tanpa nama',
                    'desc' => $transaction->transaction_code . ' · ' . $this->formatCurrency((float) $transaction->amount),
                ];
            })
            ->values()
            ->toBase();

        $articleEvents = Article::latest('published_at')
            ->take(3)
            ->get()
            ->map(function (Article $article) {
                $timestamp = $article->published_at ?? $article->created_at ?? Carbon::now();
                return [
                    'timestamp' => $timestamp,
                    'time' => $timestamp->format('d M · H:i'),
                    'type' => 'content',
                    'title' => 'Konten Baru: ' . $article->title,
                    'user' => 'Kategori ' . ($article->category ?? '-'),
                    'desc' => $article->excerpt ? strip_tags($article->excerpt) : 'Artikel dipublikasikan',
                ];
            })
            ->values()
            ->toBase();

        return $websiteEvents
            ->merge($transactionEvents)
            ->merge($articleEvents)
            ->sortByDesc('timestamp')
            ->take(6)
            ->map(function (array $event) {
                unset($event['timestamp']);
                return $event;
            })
            ->values()
            ->all();
    }

    /**
     * Support ticket summary based on reference dataset.
     */
    protected function supportTicketStats(): array
    {
        $tickets = $this->supportTicketDataset();

        return [
            'open' => $tickets->where('status', 'open')->count(),
            'in_progress' => $tickets->where('status', 'in_progress')->count(),
            'resolved' => $tickets->where('status', 'resolved')->count(),
        ];
    }

    /**
     * Reference support ticket dataset (mirrors SupportController seed data).
     */
    protected function supportTicketDataset(): Collection
    {
        return collect([
            ['status' => 'open'],
            ['status' => 'in_progress'],
            ['status' => 'in_progress'],
            ['status' => 'resolved'],
        ]);
    }

    /**
     * Count websites created after a given time.
     */
    protected function countNewWebsites(Collection $websites, Carbon $since): int
    {
        return $websites->filter(function (Website $website) use ($since) {
            return $website->created_at && $website->created_at->greaterThanOrEqualTo($since);
        })->count();
    }

    /**
     * Format currency helper.
     */
    protected function formatCurrency(float $value): string
    {
        if ($value <= 0) {
            return 'Rp 0';
        }

        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    /**
     * Placeholder events for default dashboard.
     */
    protected function placeholderEvents(): array
    {
        return [
            ['time' => '11:32', 'type' => 'page', 'title' => 'New Page', 'user' => 'Kay Phillips', 'desc' => 'About Page Company'],
            ['time' => '11:20', 'type' => 'comment', 'title' => 'New Comment', 'user' => 'Erik Pittman', 'desc' => 'You might remember the Dell computer commercials in which a youth reports this exciting news to his friends...'],
            ['time' => '11:18', 'type' => 'comment', 'title' => 'New Comment', 'user' => 'Erik Pittman', 'desc' => 'Category «Templates»'],
            ['time' => '11:16', 'type' => 'user', 'title' => 'New User', 'user' => 'Erik Pittman', 'desc' => 'New User Alberta Colon'],
            ['time' => '11:01', 'type' => 'post', 'title' => 'New Post', 'user' => 'Erik Pittman', 'desc' => 'Add New Post - Second Post-'],
        ];
    }

    /**
     * Village dataset helpers
     */
    protected function villageUmkmProfiles(): Collection
    {
        return collect([
            [
                'name' => 'UD Berkah Jaya',
                'slug' => 'ud-berkah-jaya',
                'category' => 'Makanan & Minuman',
                'status' => 'active',
                'products' => 8,
                'new_products' => 2,
                'sales_30d' => 156,
                'pending_validation' => 1,
                'last_activity' => Carbon::now()->subHours(3),
                'last_activity_desc' => 'Mengunggah produk Keripik Singkong Renyah',
            ],
            [
                'name' => 'Madu Sari Desa',
                'slug' => 'madu-sari-desa',
                'category' => 'Kesehatan & Herbal',
                'status' => 'active',
                'products' => 5,
                'new_products' => 1,
                'sales_30d' => 89,
                'pending_validation' => 2,
                'last_activity' => Carbon::now()->subHours(6),
                'last_activity_desc' => 'Memperbarui stok Madu Hutan Asli',
            ],
            [
                'name' => 'Batik Nusantara',
                'slug' => 'batik-nusantara',
                'category' => 'Kerajinan & Fashion',
                'status' => 'active',
                'products' => 12,
                'new_products' => 0,
                'sales_30d' => 34,
                'pending_validation' => 0,
                'last_activity' => Carbon::now()->subDay(),
                'last_activity_desc' => 'Mengunggah katalog Batik Motif Daun Padi',
            ],
            [
                'name' => 'Dodol Pak Haji',
                'slug' => 'dodol-pak-haji',
                'category' => 'Makanan & Minuman',
                'status' => 'active',
                'products' => 6,
                'new_products' => 1,
                'sales_30d' => 267,
                'pending_validation' => 1,
                'last_activity' => Carbon::now()->subHours(12),
                'last_activity_desc' => 'Menandai pesanan pre-order festival panen',
            ],
            [
                'name' => 'Kopi Gunung Sari',
                'slug' => 'kopi-gunung-sari',
                'category' => 'Makanan & Minuman',
                'status' => 'active',
                'products' => 4,
                'new_products' => 1,
                'sales_30d' => 198,
                'pending_validation' => 0,
                'last_activity' => Carbon::now()->subHours(2),
                'last_activity_desc' => 'Konfirmasi pesanan Kopi Robusta Giling Halus',
            ],
        ]);
    }

    protected function villageVisitorStats(): array
    {
        $months = collect(range(5, 0))->map(function (int $offset) {
            return Carbon::now()->subMonths($offset);
        });

        $dataset = [1280, 1420, 1510, 1680, 1850, 2100];
        $growth = 12;
        $average = (int) round(array_sum($dataset) / max(count($dataset), 1));

        return [
            'labels' => $months->map(fn (Carbon $month) => $month->translatedFormat('M'))->all(),
            'dataset' => $dataset,
            'growth' => $growth,
            'average' => $average,
        ];
    }

    protected function villageNewsDataset(): Collection
    {
        return collect([
            ['title' => 'Pembangunan Jalan Desa Tahap 2 Dimulai', 'status' => 'published'],
            ['title' => 'Pelatihan UMKM Digital Marketing', 'status' => 'published'],
            ['title' => 'Festival Panen Raya 2024', 'status' => 'published'],
        ]);
    }

    protected function villageGalleryDataset(): Collection
    {
        return collect([
            ['title' => 'Gotong Royong Membersihkan Sungai'],
            ['title' => 'Senam Sehat Bersama'],
            ['title' => 'Pelatihan Hidroponik'],
            ['title' => 'Lomba 17 Agustus'],
        ]);
    }

    protected function villagePotencyDataset(): Collection
    {
        return collect([
            ['title' => 'Air Terjun Sumber Rejeki'],
            ['title' => 'Kebun Teh Lereng Indah'],
            ['title' => 'Desa Wisata Kampung Bambu'],
        ]);
    }

    protected function villageUmkmDistribution(Collection $umkmProfiles): array
    {
        $grouped = $umkmProfiles
            ->groupBy('category')
            ->map(function (Collection $items) {
                return $items->count();
            });

        return [
            'labels' => $grouped->keys()->all(),
            'dataset' => $grouped->values()->map(fn ($count) => (int) $count)->all(),
        ];
    }

    protected function villageContentTrend(Collection $news, Collection $gallery, Collection $potencies): array
    {
        $weeks = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];

        return [
            'labels' => $weeks,
            'dataset' => [
                'berita' => [2, 1, 1, 1],
                'galeri' => [1, 1, 1, 1],
                'potensi' => [1, 0, 1, 1],
            ],
        ];
    }

    protected function villageActivityFeed(Collection $umkmProfiles): array
    {
        return $umkmProfiles
            ->sortByDesc('last_activity')
            ->take(6)
            ->map(function (array $umkm) {
                return [
                    'time' => optional($umkm['last_activity'])->format('H:i') ?? '-',
                    'type' => 'umkm_activity',
                    'title' => $umkm['name'],
                    'user' => $umkm['category'],
                    'desc' => $umkm['last_activity_desc'] ?? '-',
                ];
            })
            ->values()
            ->all();
    }

    protected function villagePendingContent(): array
    {
        return [
            [
                'type' => 'Berita',
                'title' => 'Laporan Realisasi Dana Desa Q1',
                'submitted_by' => 'Sekretariat Desa',
                'submitted_at' => Carbon::now()->subHours(8)->format('d M · H:i'),
                'status' => 'review',
            ],
            [
                'type' => 'Produk UMKM',
                'title' => 'Sirup Jahe Merah 250ml',
                'submitted_by' => 'Madu Sari Desa',
                'submitted_at' => Carbon::now()->subDay()->format('d M · H:i'),
                'status' => 'verification',
            ],
            [
                'type' => 'Galeri',
                'title' => 'Dokumentasi Posyandu Sejahtera',
                'submitted_by' => 'Tim Kader PKK',
                'submitted_at' => Carbon::now()->subDays(2)->format('d M · H:i'),
                'status' => 'draft',
            ],
        ];
    }

    protected function villageQuickActions(): array
    {
        return [
            [
                'label' => 'Tambah UMKM',
                'description' => 'Daftarkan pelaku usaha baru desa',
                'link' => route('desa.umkm.index'),
                'icon' => 'plus',
                'color' => 'from-emerald-500 to-teal-500',
            ],
            [
                'label' => 'Tambah Berita',
                'description' => 'Publikasikan kabar terbaru desa',
                'link' => route('desa.berita.index'),
                'icon' => 'news',
                'color' => 'from-blue-500 to-indigo-500',
            ],
            [
                'label' => 'Tambah Galeri',
                'description' => 'Unggah dokumentasi kegiatan',
                'link' => route('desa.galeri-wisata.index'),
                'icon' => 'gallery',
                'color' => 'from-rose-500 to-orange-500',
            ],
        ];
    }

    protected function villageSidebarHighlights(Collection $umkmProfiles): array
    {
        return [
            'topUmkm' => $umkmProfiles
                ->sortByDesc('sales_30d')
                ->take(3)
                ->map(function (array $umkm) {
                    return [
                        'name' => $umkm['name'],
                        'category' => $umkm['category'],
                        'sales' => number_format($umkm['sales_30d']),
                        'status' => ucfirst($umkm['status']),
                    ];
                })
                ->values()
                ->all(),
            'stats' => [
                'produkBaru' => $umkmProfiles->sum('new_products'),
                'drafKonten' => $umkmProfiles->sum('pending_validation'),
            ],
        ];
    }
}