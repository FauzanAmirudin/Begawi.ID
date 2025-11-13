<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PlatformDirectoryController extends Controller
{
    /**
     * Ensure the authenticated user is a super admin.
     *
     * @return void
     */
    protected function ensureSuperAdmin(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user || $user->role !== User::ROLE_SUPER_ADMIN) {
            abort(403, 'Akses ditolak. Hanya Super Admin yang dapat mengakses halaman ini.');
        }
    }

    /**
     * Display the Begawi.ID platform directory overview.
     */
    public function index(Request $request): View
    {
        $this->ensureSuperAdmin();

        $allWebsites = Website::with('user')
            ->orderBy('name')
            ->get();

        $searchDesa = trim($request->get('desa_search', ''));
        $searchUmkm = trim($request->get('umkm_search', ''));
        $statusFilter = $request->get('status', 'active');

        $statsOverview = $this->buildStatsOverview($allWebsites);

        $desaDirectory = $this->buildDirectoryCollection(
            $allWebsites,
            'desa',
            $searchDesa,
            $statusFilter
        );

        $umkmDirectory = $this->buildDirectoryCollection(
            $allWebsites,
            'umkm',
            $searchUmkm,
            $statusFilter,
            true
        );

        $activityTrend = $this->buildActivityTrend($allWebsites);
        $activityRanking = $this->buildActivityRanking($allWebsites);

        return view('admin.platform-directory.index', compact(
            'statsOverview',
            'desaDirectory',
            'umkmDirectory',
            'activityTrend',
            'activityRanking',
            'searchDesa',
            'searchUmkm',
            'statusFilter'
        ));
    }

    /**
     * Prepare statistics cards for the overview section.
     */
    protected function buildStatsOverview(Collection $websites): array
    {
        $totalTenants = $websites->count();
        $activeTenants = $websites->where('status', 'active')->count();
        $desaActive = $websites->where('type', 'desa')->where('status', 'active')->count();
        $umkmActive = $websites->where('type', 'umkm')->where('status', 'active')->count();
        $suspended = $websites->where('status', 'suspended')->count();

        $activeRatio = $totalTenants > 0
            ? round(($activeTenants / $totalTenants) * 100)
            : 0;

        $desaRatio = $activeTenants > 0
            ? round(($desaActive / $activeTenants) * 100)
            : 0;

        $umkmRatio = $activeTenants > 0
            ? round(($umkmActive / $activeTenants) * 100)
            : 0;

        return [
            [
                'label' => 'Total Tenant Aktif',
                'value' => number_format($activeTenants),
                'description' => "{$activeRatio}% dari keseluruhan tenant",
                'gradient' => 'from-emerald-500 to-emerald-600',
                'icon' => 'grid',
            ],
            [
                'label' => 'Direktori Desa',
                'value' => number_format($desaActive),
                'description' => "{$desaRatio}% dari tenant aktif",
                'gradient' => 'from-blue-500 to-blue-600',
                'icon' => 'globe',
            ],
            [
                'label' => 'Direktori UMKM',
                'value' => number_format($umkmActive),
                'description' => "{$umkmRatio}% dari tenant aktif",
                'gradient' => 'from-purple-500 to-purple-600',
                'icon' => 'storefront',
            ],
            [
                'label' => 'Butuh Perhatian',
                'value' => number_format($suspended),
                'description' => 'Status suspend / pending aktivasi',
                'gradient' => 'from-orange-500 to-rose-500',
                'icon' => 'alert',
            ],
        ];
    }

    /**
     * Build directory listing collection for desa or UMKM websites.
     */
    protected function buildDirectoryCollection(
        Collection $websites,
        string $type,
        string $search,
        string $statusFilter,
        bool $includeCategory = false
    ): Collection {
        $filtered = $websites
            ->where('type', $type)
            ->filter(function (Website $website) use ($statusFilter) {
                if ($statusFilter === 'all') {
                    return true;
                }

                return $website->status === $statusFilter;
            })
            ->filter(function (Website $website) use ($search) {
                if ($search === '') {
                    return true;
                }

                $haystack = strtolower($website->name . ' ' . $website->url . ' ' . ($website->custom_domain ?? '') . ' ' . optional($website->user)->name);

                return str_contains($haystack, strtolower($search));
            })
            ->map(function (Website $website) use ($includeCategory) {
                return [
                    'name' => $website->name,
                    'url' => $this->formatWebsiteUrl($website),
                    'display_url' => $website->custom_domain ?: $website->url,
                    'owner' => optional($website->user)->name ?? 'Tidak diketahui',
                    'status' => ucfirst($website->status),
                    'status_color' => $website->status === 'active' ? 'emerald' : ($website->status === 'suspended' ? 'amber' : 'gray'),
                    'updated_at' => optional($website->updated_at)->translatedFormat('d M Y'),
                    'category' => $includeCategory ? $this->resolveUmkmCategory($website) : null,
                ];
            })
            ->values();

        return $filtered;
    }

    /**
     * Resolve a human friendly UMKM category label.
     */
    protected function resolveUmkmCategory(Website $website): string
    {
        if ($website->notes) {
            $normalized = trim(strip_tags(Str::of($website->notes)->replace(["\r\n", "\r"], "\n")->explode("\n")->first() ?? ''));

            if ($normalized !== '') {
                return Str::limit($normalized, 40);
            }
        }

        if ($website->template_id) {
            return Str::title(str_replace('-', ' ', $website->template_id));
        }

        return 'Umum';
    }

    /**
     * Build activity trend dataset (last 6 months).
     */
    protected function buildActivityTrend(Collection $websites): array
    {
        $months = collect(range(5, 0))->map(function ($offset) {
            $period = Carbon::now()->subMonths($offset);

            return [
                'key' => $period->format('Y-m'),
                'label' => $period->translatedFormat('M'),
            ];
        });

        $grouped = $websites->groupBy(function (Website $website) {
            $timestamp = $website->updated_at ?? $website->created_at ?? Carbon::now();

            return $timestamp->format('Y-m');
        });

        return $months->map(function (array $month) use ($grouped) {
            $count = $grouped->get($month['key'], collect())->count();

            return [
                'label' => $month['label'],
                'value' => $count,
            ];
        })->all();
    }

    /**
     * Build content activity ranking dataset.
     */
    protected function buildActivityRanking(Collection $websites): Collection
    {
        $ranking = $websites
            ->filter(fn (Website $website) => $website->status === 'active')
            ->map(function (Website $website) {
                $notesLength = strlen(strip_tags($website->notes ?? ''));

                $recencyScore = $website->updated_at
                    ? max(20, 120 - min(24, $website->updated_at->diffInDays(now())) * 4)
                    : 60;

                $engagementScore = min(60, max(10, (int) ($notesLength / 6)));

                $totalScore = $recencyScore + $engagementScore;

                $trend = $recencyScore >= 90 ? 'up' : ($recencyScore <= 40 ? 'down' : 'steady');

                return [
                    'name' => $website->name,
                    'type' => $website->type === 'desa' ? 'Website Desa' : 'Website UMKM',
                    'url' => $this->formatWebsiteUrl($website),
                    'owner' => optional($website->user)->name ?? 'Tidak diketahui',
                    'score' => $totalScore,
                    'trend' => $trend,
                ];
            })
            ->sortByDesc('score')
            ->values()
            ->take(6);

        if ($ranking->isEmpty()) {
            return collect([
                [
                    'name' => 'Belum ada data',
                    'type' => 'Tenant',
                    'url' => '#',
                    'owner' => '-',
                    'score' => 0,
                    'trend' => 'steady',
                ],
            ]);
        }

        return $ranking;
    }

    /**
     * Normalize a website URL for display/linking.
     */
    protected function formatWebsiteUrl(Website $website): string
    {
        $rawUrl = $website->custom_domain ?: $website->url;

        if (!Str::contains($rawUrl, '://')) {
            return 'https://' . ltrim($rawUrl, '/');
        }

        return $rawUrl;
    }
}

