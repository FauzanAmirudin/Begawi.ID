<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\InformationPage;
use App\Models\PaymentGatewayConfig;
use App\Models\SubscriptionPackage;
use App\Models\Transaction;
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

        return view('admin.dashboard.index', [
            'overviewCards' => $overviewCards,
            'secondaryCards' => $secondaryCards,
            'operationalMetrics' => $operationalMetrics,
            'charts' => $charts,
            'latestEvents' => $latestEvents,
            'dashboardRole' => 'super_admin',
        ]);
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

        return view('admin.dashboard.index', [
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
}