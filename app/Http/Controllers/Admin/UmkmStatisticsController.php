<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use App\Models\UmkmProduct;
use App\Models\UmkmVisitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UmkmStatisticsController extends Controller
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
     * Display statistics index page
     */
    public function index()
    {
        $umkmBusiness = $this->getUmkmBusiness();
        
        if (!$umkmBusiness) {
            return redirect()->route('admin.umkm.setup')
                ->with('error', 'UMKM business tidak ditemukan. Silakan setup terlebih dahulu.');
        }

        return view('admin.admin-umkm.statistics.index', [
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Statistik Pengunjung - Visitor Statistics
     */
    public function visitorStatistics(Request $request)
    {
        $umkmBusiness = $this->getUmkmBusiness();
        
        if (!$umkmBusiness) {
            return redirect()->route('admin.umkm.setup')
                ->with('error', 'UMKM business tidak ditemukan.');
        }

        $period = $request->get('period', 'monthly'); // daily, weekly, monthly

        // Generate visitor data based on period
        $visitorData = $this->generateVisitorData($period, $umkmBusiness);

        return view('admin.admin-umkm.statistics.visitor-statistics', [
            'period' => $period,
            'visitorData' => $visitorData,
            'summary' => $this->calculateVisitorSummary($visitorData),
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Produk Terpopuler - Popular Products
     */
    public function popularProducts(Request $request)
    {
        $umkmBusiness = $this->getUmkmBusiness();
        
        if (!$umkmBusiness) {
            return redirect()->route('admin.umkm.setup')
                ->with('error', 'UMKM business tidak ditemukan.');
        }

        // Get products ordered by view count
        $products = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->where('is_active', true)
            ->with(['category', 'primaryImage'])
            ->orderBy('view_count', 'desc')
            ->paginate(20);

        // Get top 10 products for chart
        $topProducts = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->where('is_active', true)
            ->orderBy('view_count', 'desc')
            ->take(10)
            ->get();

        $chartData = [
            'labels' => $topProducts->pluck('title')->map(fn($title) => Str::limit($title, 20))->all(),
            'dataset' => $topProducts->pluck('view_count')->all(),
        ];

        return view('admin.admin-umkm.statistics.popular-products', [
            'products' => $products,
            'chartData' => $chartData,
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Sumber Pengunjung - Visitor Sources
     */
    public function visitorSources(Request $request)
    {
        $umkmBusiness = $this->getUmkmBusiness();
        
        if (!$umkmBusiness) {
            return redirect()->route('admin.umkm.setup')
                ->with('error', 'UMKM business tidak ditemukan.');
        }

        $period = $request->get('period', 'monthly'); // daily, weekly, monthly

        // Get visitor sources data
        $sourcesData = $this->getVisitorSourcesData($period, $umkmBusiness);

        return view('admin.admin-umkm.statistics.visitor-sources', [
            'period' => $period,
            'sourcesData' => $sourcesData,
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Generate visitor data based on period
     */
    protected function generateVisitorData(string $period, UmkmBusiness $umkmBusiness): array
    {
        switch ($period) {
            case 'daily':
                return $this->generateDailyVisitorData($umkmBusiness);
            case 'weekly':
                return $this->generateWeeklyVisitorData($umkmBusiness);
            case 'monthly':
            default:
                return $this->generateMonthlyVisitorData($umkmBusiness);
        }
    }

    /**
     * Generate daily visitor data (last 30 days)
     */
    protected function generateDailyVisitorData(UmkmBusiness $umkmBusiness): array
    {
        $days = collect(range(29, 0))->map(function ($offset) {
            return Carbon::now()->subDays($offset);
        });

        $dataset = [];
        foreach ($days as $day) {
            $count = UmkmVisitor::where('umkm_business_id', $umkmBusiness->id)
                ->whereDate('visited_at', $day->format('Y-m-d'))
                ->count();
            $dataset[] = $count;
        }

        return [
            'labels' => $days->map(fn ($day) => $day->format('d M'))->all(),
            'dataset' => $dataset,
        ];
    }

    /**
     * Generate weekly visitor data (last 12 weeks)
     */
    protected function generateWeeklyVisitorData(UmkmBusiness $umkmBusiness): array
    {
        $weeks = collect(range(11, 0))->map(function ($offset) {
            $start = Carbon::now()->subWeeks($offset)->startOfWeek();
            return [
                'start' => $start,
                'end' => $start->copy()->endOfWeek(),
                'label' => $start->format('d M') . ' - ' . $start->copy()->endOfWeek()->format('d M'),
            ];
        });

        $dataset = [];
        foreach ($weeks as $week) {
            $count = UmkmVisitor::where('umkm_business_id', $umkmBusiness->id)
                ->whereBetween('visited_at', [$week['start'], $week['end']])
                ->count();
            $dataset[] = $count;
        }

        return [
            'labels' => collect($weeks)->pluck('label')->all(),
            'dataset' => $dataset,
        ];
    }

    /**
     * Generate monthly visitor data (last 12 months)
     */
    protected function generateMonthlyVisitorData(UmkmBusiness $umkmBusiness): array
    {
        $months = collect(range(11, 0))->map(function ($offset) {
            return Carbon::now()->subMonths($offset);
        });

        $dataset = [];
        foreach ($months as $month) {
            $count = UmkmVisitor::where('umkm_business_id', $umkmBusiness->id)
                ->whereYear('visited_at', $month->year)
                ->whereMonth('visited_at', $month->month)
                ->count();
            $dataset[] = $count;
        }

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
        $max = max($dataset ?: [0]);
        $min = min($dataset ?: [0]);
        
        // Calculate growth (compare last period with previous)
        $lastPeriod = end($dataset) ?: 0;
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
     * Get visitor sources data
     */
    protected function getVisitorSourcesData(string $period, UmkmBusiness $umkmBusiness): array
    {
        $startDate = match($period) {
            'daily' => Carbon::now()->subDays(30),
            'weekly' => Carbon::now()->subWeeks(12),
            'monthly' => Carbon::now()->subMonths(12),
            default => Carbon::now()->subMonths(12),
        };

        // Get sources summary
        $sources = UmkmVisitor::where('umkm_business_id', $umkmBusiness->id)
            ->where('visited_at', '>=', $startDate)
            ->selectRaw('source, source_detail, COUNT(*) as count')
            ->groupBy('source', 'source_detail')
            ->orderByDesc('count')
            ->get();

        // Get detailed social media sources
        $socialMediaSources = UmkmVisitor::where('umkm_business_id', $umkmBusiness->id)
            ->where('visited_at', '>=', $startDate)
            ->where('source', 'social_media')
            ->selectRaw('source_detail, COUNT(*) as count')
            ->groupBy('source_detail')
            ->orderByDesc('count')
            ->get();

        // Get search engine sources
        $searchEngineSources = UmkmVisitor::where('umkm_business_id', $umkmBusiness->id)
            ->where('visited_at', '>=', $startDate)
            ->where('source', 'search_engine')
            ->selectRaw('source_detail, COUNT(*) as count')
            ->groupBy('source_detail')
            ->orderByDesc('count')
            ->get();

        $total = $sources->sum('count');

        return [
            'total' => $total,
            'sources' => $sources->map(function ($item) use ($total) {
                return [
                    'source' => $item->source,
                    'source_detail' => $item->source_detail,
                    'count' => $item->count,
                    'percentage' => $total > 0 ? round(($item->count / $total) * 100, 1) : 0,
                ];
            })->all(),
            'social_media' => $socialMediaSources->map(function ($item) {
                return [
                    'name' => ucfirst($item->source_detail ?? 'Unknown'),
                    'count' => $item->count,
                ];
            })->all(),
            'search_engines' => $searchEngineSources->map(function ($item) {
                return [
                    'name' => ucfirst($item->source_detail ?? 'Unknown'),
                    'count' => $item->count,
                ];
            })->all(),
            'chart_data' => [
                'labels' => $sources->pluck('source_detail')->map(fn($s) => ucfirst($s ?? 'Direct'))->all(),
                'dataset' => $sources->pluck('count')->all(),
            ],
        ];
    }
}
