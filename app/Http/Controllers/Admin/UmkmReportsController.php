<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use App\Models\UmkmProduct;
use App\Models\UmkmVisitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UmkmReportsController extends Controller
{
    /**
     * Get UMKM business for current user
     */
    protected function getUmkmBusiness(): ?UmkmBusiness
    {
        $user = Auth::user();
        return UmkmBusiness::where('user_id', $user->id)->first();
    }

    /**
     * Display the reports index page
     */
    public function index()
    {
        $umkmBusiness = $this->getUmkmBusiness();
        
        if (!$umkmBusiness) {
            return redirect()->route('admin.umkm.setup')
                ->with('error', 'UMKM business tidak ditemukan. Silakan setup terlebih dahulu.');
        }

        // Get summary statistics
        $summary = $this->getSummaryStatistics($umkmBusiness);

        return view('admin.admin-umkm.reports.index', [
            'umkmBusiness' => $umkmBusiness,
            'summary' => $summary,
        ]);
    }

    /**
     * Laporan Produk - Product Reports
     */
    public function productReports(Request $request)
    {
        $umkmBusiness = $this->getUmkmBusiness();
        
        if (!$umkmBusiness) {
            return redirect()->route('admin.umkm.setup')
                ->with('error', 'UMKM business tidak ditemukan.');
        }

        $type = $request->get('type', 'most-viewed'); // most-viewed, most-interactions

        if ($type === 'most-interactions') {
            return $this->mostInteractionsProducts($umkmBusiness);
        }

        return $this->mostViewedProducts($umkmBusiness);
    }

    /**
     * Most Viewed Products
     */
    protected function mostViewedProducts(UmkmBusiness $umkmBusiness)
    {
        $products = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->where('is_active', true)
            ->with(['category', 'primaryImage'])
            ->orderBy('view_count', 'desc')
            ->paginate(20);

        // Get top 10 for chart
        $topProducts = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->where('is_active', true)
            ->orderBy('view_count', 'desc')
            ->take(10)
            ->get();

        $chartData = [
            'labels' => $topProducts->pluck('title')->map(fn($title) => \Illuminate\Support\Str::limit($title, 20))->all(),
            'dataset' => $topProducts->pluck('view_count')->all(),
        ];

        $summary = [
            'total_views' => UmkmProduct::where('umkm_business_id', $umkmBusiness->id)->sum('view_count'),
            'average_views' => UmkmProduct::where('umkm_business_id', $umkmBusiness->id)->avg('view_count'),
            'total_products' => UmkmProduct::where('umkm_business_id', $umkmBusiness->id)->where('is_active', true)->count(),
        ];

        return view('admin.admin-umkm.reports.product-reports', [
            'type' => 'most-viewed',
            'products' => $products,
            'chartData' => $chartData,
            'summary' => $summary,
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Most Interactions Products
     */
    protected function mostInteractionsProducts(UmkmBusiness $umkmBusiness)
    {
        // Calculate interaction score: view_count + (sold_count * 2) + (rating_count * 3)
        $products = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->where('is_active', true)
            ->with(['category', 'primaryImage'])
            ->get()
            ->map(function ($product) {
                $product->interaction_score = $product->view_count + ($product->sold_count * 2) + ($product->rating_count * 3);
                return $product;
            })
            ->sortByDesc('interaction_score')
            ->values();

        // Paginate manually
        $currentPage = request()->get('page', 1);
        $perPage = 20;
        $items = $products->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedProducts = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $products->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Get top 10 for chart
        $topProducts = $products->take(10);

        $chartData = [
            'labels' => $topProducts->pluck('title')->map(fn($title) => \Illuminate\Support\Str::limit($title, 20))->all(),
            'dataset' => $topProducts->pluck('interaction_score')->all(),
        ];

        $summary = [
            'total_interactions' => $products->sum('interaction_score'),
            'average_interactions' => $products->count() > 0 ? round($products->sum('interaction_score') / $products->count()) : 0,
            'total_products' => $products->count(),
        ];

        return view('admin.admin-umkm.reports.product-reports', [
            'type' => 'most-interactions',
            'products' => $paginatedProducts,
            'chartData' => $chartData,
            'summary' => $summary,
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Laporan Aktivitas - Activity Reports
     */
    public function activityReports(Request $request)
    {
        $umkmBusiness = $this->getUmkmBusiness();
        
        if (!$umkmBusiness) {
            return redirect()->route('admin.umkm.setup')
                ->with('error', 'UMKM business tidak ditemukan.');
        }

        $period = $request->get('period', 'monthly'); // monthly, weekly

        // Get activity data
        $activityData = $this->getActivityData($umkmBusiness, $period);

        return view('admin.admin-umkm.reports.activity-reports', [
            'period' => $period,
            'activityData' => $activityData,
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Export Laporan - Export Reports
     */
    public function exportReport(Request $request)
    {
        $umkmBusiness = $this->getUmkmBusiness();
        
        if (!$umkmBusiness) {
            return redirect()->route('admin.umkm.setup')
                ->with('error', 'UMKM business tidak ditemukan.');
        }

        $format = $request->get('format', 'pdf'); // pdf, excel
        $type = $request->get('type', 'monthly'); // monthly, product, activity

        // Collect report data
        $reportData = $this->collectReportData($umkmBusiness, $type);

        if ($format === 'pdf') {
            return $this->exportPdf($reportData, $umkmBusiness, $type);
        }

        if ($format === 'excel') {
            return $this->exportExcel($reportData, $umkmBusiness, $type);
        }

        return redirect()->back()->with('error', 'Format tidak valid.');
    }

    /**
     * Get summary statistics
     */
    protected function getSummaryStatistics(UmkmBusiness $umkmBusiness): array
    {
        $totalProducts = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->where('is_active', true)
            ->count();

        $totalViews = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->sum('view_count');

        $totalVisitors = UmkmVisitor::where('umkm_business_id', $umkmBusiness->id)
            ->count();

        // Last 30 days activity
        $last30Days = Carbon::now()->subDays(30);
        $recentProducts = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->where('updated_at', '>=', $last30Days)
            ->count();

        return [
            'total_products' => $totalProducts,
            'total_views' => $totalViews,
            'total_visitors' => $totalVisitors,
            'recent_activity' => $recentProducts,
        ];
    }

    /**
     * Get activity data
     */
    protected function getActivityData(UmkmBusiness $umkmBusiness, string $period): array
    {
        if ($period === 'weekly') {
            return $this->getWeeklyActivityData($umkmBusiness);
        }

        return $this->getMonthlyActivityData($umkmBusiness);
    }

    /**
     * Get monthly activity data (last 6 months)
     */
    protected function getMonthlyActivityData(UmkmBusiness $umkmBusiness): array
    {
        $months = collect(range(5, 0))->map(function ($offset) {
            return Carbon::now()->subMonths($offset);
        });

        $activities = [];
        foreach ($months as $month) {
            $productUpdates = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
                ->whereBetween('updated_at', [$month->startOfMonth(), $month->endOfMonth()])
                ->count();

            $productCreates = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
                ->whereBetween('created_at', [$month->startOfMonth(), $month->endOfMonth()])
                ->count();

            $profileUpdates = 0;
            if ($umkmBusiness->updated_at && 
                $umkmBusiness->updated_at->greaterThanOrEqualTo($month->startOfMonth()) &&
                $umkmBusiness->updated_at->lessThanOrEqualTo($month->endOfMonth())) {
                $profileUpdates = 1;
            }

            $activities[] = [
                'month' => $month->translatedFormat('F Y'),
                'product_updates' => $productUpdates,
                'product_creates' => $productCreates,
                'profile_updates' => $profileUpdates,
                'total' => $productUpdates + $productCreates + $profileUpdates,
            ];
        }

        return [
            'period' => 'monthly',
            'activities' => $activities,
            'summary' => [
                'total_updates' => collect($activities)->sum('total'),
                'total_product_updates' => collect($activities)->sum('product_updates'),
                'total_product_creates' => collect($activities)->sum('product_creates'),
                'total_profile_updates' => collect($activities)->sum('profile_updates'),
            ],
        ];
    }

    /**
     * Get weekly activity data (last 12 weeks)
     */
    protected function getWeeklyActivityData(UmkmBusiness $umkmBusiness): array
    {
        $weeks = collect(range(11, 0))->map(function ($offset) {
            $start = Carbon::now()->subWeeks($offset)->startOfWeek();
            return [
                'start' => $start,
                'end' => $start->copy()->endOfWeek(),
                'label' => $start->format('d M') . ' - ' . $start->copy()->endOfWeek()->format('d M'),
            ];
        });

        $activities = [];
        foreach ($weeks as $week) {
            $productUpdates = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
                ->whereBetween('updated_at', [$week['start'], $week['end']])
                ->count();

            $productCreates = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
                ->whereBetween('created_at', [$week['start'], $week['end']])
                ->count();

            $profileUpdates = 0;
            if ($umkmBusiness->updated_at && 
                $umkmBusiness->updated_at->greaterThanOrEqualTo($week['start']) &&
                $umkmBusiness->updated_at->lessThanOrEqualTo($week['end'])) {
                $profileUpdates = 1;
            }

            $activities[] = [
                'week' => $week['label'],
                'product_updates' => $productUpdates,
                'product_creates' => $productCreates,
                'profile_updates' => $profileUpdates,
                'total' => $productUpdates + $productCreates + $profileUpdates,
            ];
        }

        return [
            'period' => 'weekly',
            'activities' => $activities,
            'summary' => [
                'total_updates' => collect($activities)->sum('total'),
                'total_product_updates' => collect($activities)->sum('product_updates'),
                'total_product_creates' => collect($activities)->sum('product_creates'),
                'total_profile_updates' => collect($activities)->sum('profile_updates'),
            ],
        ];
    }

    /**
     * Collect report data for export
     */
    protected function collectReportData(UmkmBusiness $umkmBusiness, string $type): array
    {
        $data = [
            'umkm_name' => $umkmBusiness->name,
            'generated_at' => Carbon::now()->format('d F Y H:i:s'),
            'period' => $type,
        ];

        if ($type === 'product') {
            $data['products'] = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
                ->where('is_active', true)
                ->with('category')
                ->orderBy('view_count', 'desc')
                ->get()
                ->map(function ($product) {
                    return [
                        'title' => $product->title,
                        'category' => $product->category->name ?? '-',
                        'views' => $product->view_count,
                        'sold' => $product->sold_count,
                        'rating' => $product->rating,
                        'price' => $product->price,
                    ];
                })->all();
        } elseif ($type === 'activity') {
            $activityData = $this->getMonthlyActivityData($umkmBusiness);
            $data['activities'] = $activityData['activities'];
            $data['summary'] = $activityData['summary'];
        } else {
            // Monthly report - comprehensive
            $data['summary'] = $this->getSummaryStatistics($umkmBusiness);
            $data['top_products'] = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
                ->where('is_active', true)
                ->orderBy('view_count', 'desc')
                ->take(10)
                ->get()
                ->map(function ($product) {
                    return [
                        'title' => $product->title,
                        'views' => $product->view_count,
                        'sold' => $product->sold_count,
                    ];
                })->all();
            $activityData = $this->getMonthlyActivityData($umkmBusiness);
            $data['activities'] = $activityData['activities'];
        }

        return $data;
    }

    /**
     * Export report as PDF
     */
    protected function exportPdf(array $reportData, UmkmBusiness $umkmBusiness, string $type)
    {
        // Check if Dompdf is available
        if (class_exists(\Dompdf\Dompdf::class)) {
            $dompdf = new \Dompdf\Dompdf([
                'isRemoteEnabled' => true,
                'defaultFont' => 'Helvetica',
            ]);

            $html = $this->generatePdfHtml($reportData, $umkmBusiness, $type);

            $dompdf->loadHtml($html, 'UTF-8');
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $filename = 'laporan-umkm-' . $type . '-' . now()->format('Ymd_His') . '.pdf';
            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ]);
        }

        // Fallback: return JSON
        return response()->json([
            'message' => 'PDF export memerlukan dompdf. Silakan install: composer require barryvdh/laravel-dompdf',
            'data' => $reportData,
        ], 422);
    }

    /**
     * Export report as Excel
     */
    protected function exportExcel(array $reportData, UmkmBusiness $umkmBusiness, string $type)
    {
        $filename = 'laporan-umkm-' . $type . '-' . now()->format('Ymd_His') . '.xls';
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'max-age=0',
        ];

        $html = $this->generateExcelHtml($reportData, $umkmBusiness, $type);

        return response($html, 200, $headers);
    }

    /**
     * Generate PDF HTML
     */
    protected function generatePdfHtml(array $reportData, UmkmBusiness $umkmBusiness, string $type): string
    {
        $html = '<html><head><meta charset="UTF-8"><style>
            body { font-family: Arial, sans-serif; font-size: 12px; }
            h1 { color: #1f2937; margin-bottom: 10px; }
            h2 { color: #374151; margin-top: 20px; margin-bottom: 10px; }
            table { border-collapse: collapse; width: 100%; margin-top: 10px; }
            th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
            th { background: #f3f4f6; font-weight: bold; }
            .summary { background: #f9fafb; padding: 15px; margin: 15px 0; border-radius: 5px; }
        </style></head><body>';

        $html .= '<h1>Laporan UMKM - ' . htmlspecialchars($umkmBusiness->name, ENT_QUOTES, 'UTF-8') . '</h1>';
        $html .= '<p>Dibuat pada: ' . htmlspecialchars($reportData['generated_at'], ENT_QUOTES, 'UTF-8') . '</p>';

        if ($type === 'monthly') {
            $html .= '<div class="summary">';
            $html .= '<h2>Ringkasan</h2>';
            $html .= '<p>Total Produk: ' . $reportData['summary']['total_products'] . '</p>';
            $html .= '<p>Total Views: ' . number_format($reportData['summary']['total_views']) . '</p>';
            $html .= '<p>Total Pengunjung: ' . number_format($reportData['summary']['total_visitors']) . '</p>';
            $html .= '</div>';

            if (!empty($reportData['top_products'])) {
                $html .= '<h2>Top 10 Produk</h2>';
                $html .= '<table><tr><th>Produk</th><th>Views</th><th>Terjual</th></tr>';
                foreach ($reportData['top_products'] as $product) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8') . '</td>';
                    $html .= '<td>' . number_format($product['views']) . '</td>';
                    $html .= '<td>' . number_format($product['sold']) . '</td>';
                    $html .= '</tr>';
                }
                $html .= '</table>';
            }
        } elseif ($type === 'product') {
            $html .= '<h2>Laporan Produk</h2>';
            $html .= '<table><tr><th>Produk</th><th>Kategori</th><th>Views</th><th>Terjual</th><th>Rating</th><th>Harga</th></tr>';
            foreach ($reportData['products'] as $product) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8') . '</td>';
                $html .= '<td>' . htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8') . '</td>';
                $html .= '<td>' . number_format($product['views']) . '</td>';
                $html .= '<td>' . number_format($product['sold']) . '</td>';
                $html .= '<td>' . number_format($product['rating'], 1) . '</td>';
                $html .= '<td>Rp ' . number_format($product['price'], 0, ',', '.') . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
        } elseif ($type === 'activity') {
            $html .= '<h2>Laporan Aktivitas</h2>';
            $html .= '<div class="summary">';
            $html .= '<p>Total Update: ' . $reportData['summary']['total_updates'] . '</p>';
            $html .= '<p>Update Produk: ' . $reportData['summary']['total_product_updates'] . '</p>';
            $html .= '<p>Produk Baru: ' . $reportData['summary']['total_product_creates'] . '</p>';
            $html .= '<p>Update Profil: ' . $reportData['summary']['total_profile_updates'] . '</p>';
            $html .= '</div>';

            $html .= '<table><tr><th>Periode</th><th>Update Produk</th><th>Produk Baru</th><th>Update Profil</th><th>Total</th></tr>';
            foreach ($reportData['activities'] as $activity) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($activity['month'] ?? $activity['week'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                $html .= '<td>' . $activity['product_updates'] . '</td>';
                $html .= '<td>' . $activity['product_creates'] . '</td>';
                $html .= '<td>' . $activity['profile_updates'] . '</td>';
                $html .= '<td>' . $activity['total'] . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
        }

        $html .= '</body></html>';
        return $html;
    }

    /**
     * Generate Excel HTML
     */
    protected function generateExcelHtml(array $reportData, UmkmBusiness $umkmBusiness, string $type): string
    {
        $html = '<html><head><meta charset="UTF-8"></head><body>';
        $html .= '<h1>Laporan UMKM - ' . htmlspecialchars($umkmBusiness->name, ENT_QUOTES, 'UTF-8') . '</h1>';
        $html .= '<p>Dibuat pada: ' . htmlspecialchars($reportData['generated_at'], ENT_QUOTES, 'UTF-8') . '</p>';

        if ($type === 'monthly') {
            $html .= '<h2>Ringkasan</h2>';
            $html .= '<table border="1" cellspacing="0" cellpadding="4">';
            $html .= '<tr><th>Total Produk</th><th>Total Views</th><th>Total Pengunjung</th></tr>';
            $html .= '<tr>';
            $html .= '<td>' . $reportData['summary']['total_products'] . '</td>';
            $html .= '<td>' . number_format($reportData['summary']['total_views']) . '</td>';
            $html .= '<td>' . number_format($reportData['summary']['total_visitors']) . '</td>';
            $html .= '</tr></table>';

            if (!empty($reportData['top_products'])) {
                $html .= '<h2>Top 10 Produk</h2>';
                $html .= '<table border="1" cellspacing="0" cellpadding="4">';
                $html .= '<tr><th>Produk</th><th>Views</th><th>Terjual</th></tr>';
                foreach ($reportData['top_products'] as $product) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8') . '</td>';
                    $html .= '<td>' . number_format($product['views']) . '</td>';
                    $html .= '<td>' . number_format($product['sold']) . '</td>';
                    $html .= '</tr>';
                }
                $html .= '</table>';
            }
        } elseif ($type === 'product') {
            $html .= '<h2>Laporan Produk</h2>';
            $html .= '<table border="1" cellspacing="0" cellpadding="4">';
            $html .= '<tr><th>Produk</th><th>Kategori</th><th>Views</th><th>Terjual</th><th>Rating</th><th>Harga</th></tr>';
            foreach ($reportData['products'] as $product) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8') . '</td>';
                $html .= '<td>' . htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8') . '</td>';
                $html .= '<td>' . number_format($product['views']) . '</td>';
                $html .= '<td>' . number_format($product['sold']) . '</td>';
                $html .= '<td>' . number_format($product['rating'], 1) . '</td>';
                $html .= '<td>Rp ' . number_format($product['price'], 0, ',', '.') . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
        } elseif ($type === 'activity') {
            $html .= '<h2>Laporan Aktivitas</h2>';
            $html .= '<table border="1" cellspacing="0" cellpadding="4">';
            $html .= '<tr><th>Periode</th><th>Update Produk</th><th>Produk Baru</th><th>Update Profil</th><th>Total</th></tr>';
            foreach ($reportData['activities'] as $activity) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($activity['month'] ?? $activity['week'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
                $html .= '<td>' . $activity['product_updates'] . '</td>';
                $html .= '<td>' . $activity['product_creates'] . '</td>';
                $html .= '<td>' . $activity['profile_updates'] . '</td>';
                $html .= '<td>' . $activity['total'] . '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
        }

        $html .= '</body></html>';
        return $html;
    }
}

