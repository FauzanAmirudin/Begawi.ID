<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use App\Models\User;
use App\Models\Village;
use App\Models\VillageNews;
use App\Models\VillageGalleryItem;
use App\Models\VillagePotential;
use App\Models\UmkmContentValidation;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Get village and website for current user
     * Returns array with 'village' and 'website' keys
     */
    protected function getUserVillageData()
    {
        $user = Auth::user();
        
        // For super admin, we might want to show all data or require village selection
        // For now, we'll get the first village website for super admin
        // For admin_desa, get their specific village
        if ($user->role === User::ROLE_SUPER_ADMIN) {
            // Super admin can see all, but for reports we'll use first village
            // In production, you might want to add village selection
            $website = Website::where('type', 'desa')->first();
        } else {
            // Get village website for admin_desa
            $website = Website::where('user_id', $user->id)
                ->where('type', 'desa')
                ->first();
        }

        $village = $website ? Village::where('website_id', $website->id)->first() : null;

        return [
            'village' => $village,
            'website' => $website,
        ];
    }

    /**
     * Display the reports index page
     */
    public function index()
    {
        $villageData = $this->getUserVillageData();
        
        return view('admin.admin-desa.reports.index', [
            'village' => $villageData['village'],
            'website' => $villageData['website'],
        ]);
    }

    /**
     * Statistik Pengunjung - Visitor Statistics
     */
    public function visitorStatistics(Request $request)
    {
        $period = $request->get('period', 'monthly'); // daily, weekly, monthly
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];
        $website = $villageData['website'];

        // Generate visitor data based on period and village
        $visitorData = $this->generateVisitorData($period, $village);

        return view('admin.admin-desa.reports.visitor-statistics', [
            'period' => $period,
            'visitorData' => $visitorData,
            'summary' => $this->calculateVisitorSummary($visitorData),
            'village' => $village,
            'website' => $website,
        ]);
    }

    /**
     * Statistik UMKM - UMKM Statistics
     */
    public function umkmStatistics(Request $request)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];
        $website = $villageData['website'];
        
        // Get UMKM data filtered by village
        $umkmBusinesses = collect();
        if ($village) {
            $umkmBusinesses = UmkmBusiness::where('village_id', $village->id)->get();
        } elseif ($website) {
            // Fallback to website_id if village not found
            $umkmBusinesses = UmkmBusiness::where('website_id', $website->id)->get();
        }

        $productStats = $this->calculateProductStats($umkmBusinesses);
        $activityStats = $this->calculateActivityStats($umkmBusinesses);
        $visitStats = $this->calculateVisitStats($umkmBusinesses);

        return view('admin.admin-desa.reports.umkm-statistics', [
            'productStats' => $productStats,
            'activityStats' => $activityStats,
            'visitStats' => $visitStats,
            'umkmBusinesses' => $umkmBusinesses,
            'village' => $village,
            'website' => $website,
        ]);
    }

    /**
     * Laporan Digitalisasi Desa - Village Digitalization Report
     */
    public function digitalizationReport(Request $request)
    {
        $format = $request->get('format', 'view'); // view, pdf, excel
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];
        $website = $villageData['website'];

        // Collect all digitalization data filtered by village
        $reportData = $this->collectDigitalizationData($village, $website);

        if ($format === 'pdf') {
            return $this->exportPdf($reportData, $village);
        }

        if ($format === 'excel') {
            return $this->exportExcel($reportData, $village);
        }

        return view('admin.admin-desa.reports.digitalization-report', [
            'reportData' => $reportData,
            'village' => $village,
            'website' => $website,
        ]);
    }

    /**
     * Ranking UMKM Aktif - Active UMKM Ranking
     */
    public function umkmRanking(Request $request)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];
        $website = $villageData['website'];
        
        // Get UMKM businesses filtered by village
        $umkmBusinesses = collect();
        if ($village) {
            $umkmBusinesses = UmkmBusiness::where('village_id', $village->id)->get();
        } elseif ($website) {
            // Fallback to website_id if village not found
            $umkmBusinesses = UmkmBusiness::where('website_id', $website->id)->get();
        }

        // Calculate ranking based on activity and traffic
        $rankings = $this->calculateUmkmRankings($umkmBusinesses);

        return view('admin.admin-desa.reports.umkm-ranking', [
            'rankings' => $rankings,
            'village' => $village,
            'website' => $website,
        ]);
    }

    /**
     * Generate visitor data based on period and village
     */
    protected function generateVisitorData(string $period, $village = null): array
    {
        switch ($period) {
            case 'daily':
                return $this->generateDailyVisitorData($village);
            case 'weekly':
                return $this->generateWeeklyVisitorData($village);
            case 'monthly':
            default:
                return $this->generateMonthlyVisitorData($village);
        }
    }

    /**
     * Generate daily visitor data (last 30 days)
     * Note: This is simulated data. In production, integrate with analytics service
     */
    protected function generateDailyVisitorData($village = null): array
    {
        $days = collect(range(29, 0))->map(function ($offset) {
            return Carbon::now()->subDays($offset);
        });

        $dataset = [];
        foreach ($days as $day) {
            // Simulate visitor data (in real app, this would come from analytics)
            // TODO: Integrate with actual analytics data filtered by village/website
            $baseVisitors = 50;
            $variation = rand(-15, 25);
            $weekendBoost = in_array($day->dayOfWeek, [0, 6]) ? 10 : 0;
            $dataset[] = $baseVisitors + $variation + $weekendBoost;
        }

        return [
            'labels' => $days->map(fn ($day) => $day->format('d M'))->all(),
            'dataset' => $dataset,
        ];
    }

    /**
     * Generate weekly visitor data (last 12 weeks)
     * Note: This is simulated data. In production, integrate with analytics service
     */
    protected function generateWeeklyVisitorData($village = null): array
    {
        $weeks = collect(range(11, 0))->map(function ($offset) {
            $start = Carbon::now()->subWeeks($offset)->startOfWeek();
            return [
                'start' => $start,
                'label' => $start->format('d M') . ' - ' . $start->copy()->endOfWeek()->format('d M'),
            ];
        });

        $dataset = [];
        foreach ($weeks as $week) {
            // Simulate weekly visitor data
            // TODO: Integrate with actual analytics data filtered by village/website
            $baseVisitors = 350;
            $variation = rand(-50, 100);
            $dataset[] = $baseVisitors + $variation;
        }

        return [
            'labels' => collect($weeks)->pluck('label')->all(),
            'dataset' => $dataset,
        ];
    }

    /**
     * Generate monthly visitor data (last 12 months)
     * Note: This is simulated data. In production, integrate with analytics service
     */
    protected function generateMonthlyVisitorData($village = null): array
    {
        $months = collect(range(11, 0))->map(function ($offset) {
            return Carbon::now()->subMonths($offset);
        });

        // TODO: Replace with actual analytics data filtered by village/website
        $dataset = [1280, 1420, 1510, 1680, 1850, 2100, 1950, 2200, 2350, 2100, 2400, 2600];

        return [
            'labels' => $months->map(fn ($month) => $month->translatedFormat('M Y'))->all(),
            'dataset' => $dataset,
        ];
    }

    /**
     * Calculate visitor summary statistics
     */
    protected function calculateVisitorSummary(array $visitorData): array
    {
        $dataset = $visitorData['dataset'];
        $total = array_sum($dataset);
        $average = count($dataset) > 0 ? round($total / count($dataset)) : 0;
        $max = max($dataset);
        $min = min($dataset);
        
        // Calculate growth (compare last period with previous)
        $lastPeriod = end($dataset);
        $previousPeriod = count($dataset) > 1 ? $dataset[count($dataset) - 2] : $lastPeriod;
        $growth = $previousPeriod > 0 ? round((($lastPeriod - $previousPeriod) / $previousPeriod) * 100) : 0;

        return [
            'total' => number_format($total),
            'average' => number_format($average),
            'max' => number_format($max),
            'min' => number_format($min),
            'growth' => $growth,
        ];
    }

    /**
     * Calculate product statistics for UMKM
     */
    protected function calculateProductStats($umkmBusinesses): array
    {
        $totalProducts = $umkmBusinesses->sum('products_count') ?: 0;
        $activeUmkm = $umkmBusinesses->where('status', 'active')->count();
        $avgProductsPerUmkm = $activeUmkm > 0 ? round($totalProducts / $activeUmkm) : 0;

        // Product growth by category
        $categoryProducts = $umkmBusinesses->groupBy('category')
            ->map(function ($group) {
                return $group->sum('products_count');
            });

        return [
            'total' => $totalProducts,
            'average' => $avgProductsPerUmkm,
            'by_category' => $categoryProducts->toArray(),
            'labels' => $categoryProducts->keys()->all(),
            'dataset' => $categoryProducts->values()->all(),
        ];
    }

    /**
     * Calculate activity statistics for UMKM
     */
    protected function calculateActivityStats($umkmBusinesses): array
    {
        $last30Days = Carbon::now()->subDays(30);
        $last7Days = Carbon::now()->subDays(7);

        $activities30d = $umkmBusinesses->filter(function ($umkm) use ($last30Days) {
            return $umkm->last_activity_at && $umkm->last_activity_at->greaterThanOrEqualTo($last30Days);
        })->count();

        $activities7d = $umkmBusinesses->filter(function ($umkm) use ($last7Days) {
            return $umkm->last_activity_at && $umkm->last_activity_at->greaterThanOrEqualTo($last7Days);
        })->count();

        // Activity trend (last 6 months)
        $months = collect(range(5, 0))->map(function ($offset) {
            return Carbon::now()->subMonths($offset);
        });

        $activityTrend = [];
        foreach ($months as $month) {
            $count = $umkmBusinesses->filter(function ($umkm) use ($month) {
                return $umkm->last_activity_at && 
                       $umkm->last_activity_at->greaterThanOrEqualTo($month->startOfMonth()) &&
                       $umkm->last_activity_at->lessThanOrEqualTo($month->endOfMonth());
            })->count();
            $activityTrend[] = $count;
        }

        return [
            'last_30_days' => $activities30d,
            'last_7_days' => $activities7d,
            'trend' => [
                'labels' => $months->map(fn ($m) => $m->translatedFormat('M'))->all(),
                'dataset' => $activityTrend,
            ],
        ];
    }

    /**
     * Calculate visit statistics for UMKM
     */
    protected function calculateVisitStats($umkmBusinesses): array
    {
        $totalVisits = $umkmBusinesses->sum('visits_count') ?: 0;
        $avgVisits = $umkmBusinesses->count() > 0 ? round($totalVisits / $umkmBusinesses->count()) : 0;
        
        $topVisited = $umkmBusinesses->sortByDesc('visits_count')->take(5);

        return [
            'total' => $totalVisits,
            'average' => $avgVisits,
            'top_visited' => $topVisited->map(function ($umkm) {
                return [
                    'name' => $umkm->name,
                    'visits' => $umkm->visits_count ?: 0,
                    'category' => $umkm->category,
                ];
            })->all(),
        ];
    }

    /**
     * Collect all digitalization data for report
     */
    protected function collectDigitalizationData($village, $website): array
    {
        $villageId = $village ? $village->id : null;
        $websiteId = $website ? $website->id : null;

        // News count
        $newsCount = $villageId ? VillageNews::where('village_id', $villageId)
            ->where('status', VillageNews::STATUS_PUBLISHED)
            ->count() : 0;

        // Gallery items count
        $galleryCount = $villageId ? VillageGalleryItem::where('village_id', $villageId)->count() : 0;

        // Potentials count
        $potentialsCount = $villageId ? VillagePotential::where('village_id', $villageId)->count() : 0;

        // UMKM count
        $umkmCount = 0;
        if ($villageId) {
            $umkmCount = UmkmBusiness::where('village_id', $villageId)
                ->where('status', 'active')
                ->count();
        } elseif ($websiteId) {
            $umkmCount = UmkmBusiness::where('website_id', $websiteId)
                ->where('status', 'active')
                ->count();
        }

        // Content validations - filter by village or website
        $pendingValidations = 0;
        if ($villageId) {
            $pendingValidations = UmkmContentValidation::whereHas('umkmBusiness', function ($query) use ($villageId) {
                $query->where('village_id', $villageId);
            })->where('status', 'pending')->count();
        } elseif ($websiteId) {
            $pendingValidations = UmkmContentValidation::whereHas('umkmBusiness', function ($query) use ($websiteId) {
                $query->where('website_id', $websiteId);
            })->where('status', 'pending')->count();
        }

        // Activity summary (last 6 months)
        $activitySummary = $this->generateActivitySummary($villageId, $websiteId);

        return [
            'news_count' => $newsCount,
            'gallery_count' => $galleryCount,
            'potentials_count' => $potentialsCount,
            'umkm_count' => $umkmCount,
            'pending_validations' => $pendingValidations,
            'activity_summary' => $activitySummary,
            'generated_at' => Carbon::now()->format('d F Y H:i:s'),
        ];
    }

    /**
     * Generate activity summary for last 6 months
     */
    protected function generateActivitySummary($villageId, $websiteId): array
    {
        $months = collect(range(5, 0))->map(function ($offset) {
            return Carbon::now()->subMonths($offset);
        });

        $summary = [];
        foreach ($months as $month) {
            $news = $villageId ? VillageNews::where('village_id', $villageId)
                ->whereBetween('created_at', [$month->startOfMonth(), $month->endOfMonth()])
                ->count() : 0;

            $gallery = $villageId ? VillageGalleryItem::where('village_id', $villageId)
                ->whereBetween('created_at', [$month->startOfMonth(), $month->endOfMonth()])
                ->count() : 0;

            $umkm = 0;
            if ($villageId) {
                $umkm = UmkmBusiness::where('village_id', $villageId)
                    ->whereBetween('created_at', [$month->startOfMonth(), $month->endOfMonth()])
                    ->count();
            } elseif ($websiteId) {
                $umkm = UmkmBusiness::where('website_id', $websiteId)
                    ->whereBetween('created_at', [$month->startOfMonth(), $month->endOfMonth()])
                    ->count();
            }

            $summary[] = [
                'month' => $month->translatedFormat('F Y'),
                'news' => $news,
                'gallery' => $gallery,
                'umkm' => $umkm,
            ];
        }

        return $summary;
    }

    /**
     * Calculate UMKM rankings based on activity and traffic
     */
    protected function calculateUmkmRankings($umkmBusinesses): array
    {
        return $umkmBusinesses->map(function ($umkm) {
            // Calculate score based on multiple factors
            $productScore = ($umkm->products_count ?: 0) * 10;
            $visitScore = ($umkm->visits_count ?: 0) * 5;
            $orderScore = ($umkm->orders_count ?: 0) * 15;
            
            // Activity score (recent activity gets higher score)
            $activityScore = 0;
            if ($umkm->last_activity_at) {
                $daysSinceActivity = Carbon::now()->diffInDays($umkm->last_activity_at);
                if ($daysSinceActivity <= 7) {
                    $activityScore = 50;
                } elseif ($daysSinceActivity <= 30) {
                    $activityScore = 30;
                } elseif ($daysSinceActivity <= 90) {
                    $activityScore = 10;
                }
            }

            $totalScore = $productScore + $visitScore + $orderScore + $activityScore;

            return [
                'umkm' => $umkm,
                'score' => $totalScore,
                'product_score' => $productScore,
                'visit_score' => $visitScore,
                'order_score' => $orderScore,
                'activity_score' => $activityScore,
            ];
        })
        ->sortByDesc('score')
        ->values()
        ->map(function ($item, $index) {
            $item['rank'] = $index + 1;
            return $item;
        })
        ->all();
    }

    /**
     * Export report as PDF
     */
    protected function exportPdf(array $reportData, $village)
    {
        // For now, return a simple response
        // In production, use a library like dompdf or barryvdh/laravel-dompdf
        return response()->json([
            'message' => 'PDF export akan segera tersedia',
            'data' => $reportData,
        ]);
    }

    /**
     * Export report as Excel
     */
    protected function exportExcel(array $reportData, $village)
    {
        // For now, return a simple response
        // In production, use a library like maatwebsite/excel
        return response()->json([
            'message' => 'Excel export akan segera tersedia',
            'data' => $reportData,
        ]);
    }
}

