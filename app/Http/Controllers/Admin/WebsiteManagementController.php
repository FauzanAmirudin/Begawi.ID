<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class WebsiteManagementController extends Controller
{
    /**
     * Check if current user is super admin
     */
    protected function checkSuperAdmin(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user || $user->role !== User::ROLE_SUPER_ADMIN) {
            abort(403, 'Akses ditolak. Hanya Super Admin yang dapat mengakses halaman ini.');
        }
    }

    /**
     * Website Desa - List all desa websites
     */
    public function desa(Request $request): View
    {
        $this->checkSuperAdmin();

        $query = Website::where('type', 'desa')
            ->with(['user', 'village']);

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('url', 'like', "%{$search}%")
                        ->orWhere('custom_domain', 'like', "%{$search}%")
                        ->orWhereHas('village', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                                ->orWhere('location', 'like', "%{$search}%");
                        });
                });
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $websites = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.super-admin.websites.desa', compact('websites'));
    }

    /**
     * Website UMKM - List all UMKM websites
     */
    public function umkm(Request $request): View
    {
        $this->checkSuperAdmin();

        $query = Website::where('type', 'umkm')
            ->with(['user', 'umkmBusiness.village']);

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('url', 'like', "%{$search}%")
                        ->orWhere('custom_domain', 'like', "%{$search}%")
                        ->orWhereHas('umkmBusiness', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                                ->orWhere('category', 'like', "%{$search}%")
                                ->orWhere('owner_name', 'like', "%{$search}%");
                        });
                });
            }
        }

        // Filter by desa (via UmkmBusiness->village)
        if ($request->filled('desa')) {
            $desa = trim($request->desa);
            if ($desa !== '') {
                $query->whereHas('umkmBusiness.village', function ($q) use ($desa) {
                    $q->where('name', 'like', "%{$desa}%")
                        ->orWhere('location', 'like', "%{$desa}%");
                });
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $websites = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.super-admin.websites.umkm', compact('websites'));
    }

    /**
     * Show website details
     */
    public function show(Website $website): View
    {
        $this->checkSuperAdmin();
        
        $website->load(['user', 'village']);
        
        // If it's a desa website, load village data
        if ($website->type === 'desa' && $website->village) {
            $village = $website->village;
            $village->load([
                'news',
                'galleryCategories.items',
                'potentials',
                'achievements',
                'programs',
                'users'
            ]);
            
            // Get UMKM businesses for this village
            $umkmBusinesses = \App\Models\UmkmBusiness::where('village_id', $village->id)
                ->with('user')
                ->get();
            
            // Calculate stats
            $villageStats = [
                'news_total' => $village->news->count(),
                'news_published' => $village->news->where('status', \App\Models\VillageNews::STATUS_PUBLISHED)->count(),
                'gallery_total' => $village->galleryCategories->sum(fn($cat) => $cat->items->count()),
                'potentials_total' => $village->potentials->count(),
                'achievements_total' => $village->achievements->count(),
                'programs_total' => $village->programs->count(),
                'umkm_total' => $umkmBusinesses->count(),
                'users_total' => $village->users->count(),
            ];
        } else {
            $village = null;
            $villageStats = null;
            $umkmBusinesses = collect([]);
        }
        
        return view('admin.super-admin.websites.show', compact('website', 'village', 'villageStats', 'umkmBusinesses'));
    }

    /**
     * Show village detail management (for super admin)
     */
    public function villageDetail(Website $website): View
    {
        $this->checkSuperAdmin();
        
        if ($website->type !== 'desa') {
            abort(404, 'Halaman ini hanya untuk website desa.');
        }
        
        $village = \App\Models\Village::where('website_id', $website->id)->first();
        
        if (!$village) {
            abort(404, 'Data desa tidak ditemukan untuk website ini.');
        }
        
        // Load all village data
        $village->load([
            'news' => function($q) {
                $q->orderBy('created_at', 'desc')->limit(10);
            },
            'galleryCategories' => function($q) {
                $q->with(['items' => function($q) {
                    $q->where('is_published', true)->limit(5);
                }]);
            },
            'potentials' => function($q) {
                $q->orderBy('created_at', 'desc')->limit(10);
            },
            'achievements' => function($q) {
                $q->orderBy('created_at', 'desc')->limit(10);
            },
            'programs' => function($q) {
                $q->orderBy('created_at', 'desc')->limit(10);
            },
            'users'
        ]);
        
        // Get UMKM businesses
        $umkmBusinesses = \App\Models\UmkmBusiness::where('village_id', $village->id)
            ->with(['user', 'products'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate comprehensive stats
        $stats = [
            'news_total' => \App\Models\VillageNews::where('village_id', $village->id)->count(),
            'news_published' => \App\Models\VillageNews::where('village_id', $village->id)
                ->where('status', \App\Models\VillageNews::STATUS_PUBLISHED)->count(),
            'news_draft' => \App\Models\VillageNews::where('village_id', $village->id)
                ->where('status', '!=', \App\Models\VillageNews::STATUS_PUBLISHED)->count(),
            'gallery_total' => \App\Models\VillageGalleryItem::whereHas('category', function($q) use ($village) {
                $q->where('village_id', $village->id);
            })->where('is_published', true)->count(),
            'potentials_total' => $village->potentials()->count(),
            'achievements_total' => $village->achievements()->count(),
            'programs_total' => $village->programs()->count(),
            'umkm_total' => $umkmBusinesses->count(),
            'umkm_active' => $umkmBusinesses->where('status', 'active')->count(),
            'users_total' => $village->users()->count(),
        ];
        
        return view('admin.super-admin.websites.village-detail', compact('website', 'village', 'stats', 'umkmBusinesses'));
    }

    /**
     * Edit website
     */
    public function edit(Website $website): View
    {
        $this->checkSuperAdmin();
        
        $website->load('user');
        
        return view('admin.super-admin.websites.edit', compact('website'));
    }

    /**
     * Update website
     */
    public function update(Request $request, Website $website): RedirectResponse
    {
        $this->checkSuperAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255|unique:websites,url,' . $website->id,
            'custom_domain' => 'nullable|string|max:255',
            'status' => 'required|in:active,suspended,inactive',
            'template_id' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $website->update($validated);

        return redirect()
            ->route('admin.websites.' . $website->type)
            ->with('success', 'Website berhasil diperbarui.');
    }

    /**
     * Suspend website
     */
    public function suspend(Website $website): RedirectResponse
    {
        $this->checkSuperAdmin();

        $website->update(['status' => 'suspended']);

        return redirect()
            ->back()
            ->with('success', 'Website berhasil ditangguhkan.');
    }

    /**
     * Activate website
     */
    public function activate(Website $website): RedirectResponse
    {
        $this->checkSuperAdmin();

        $website->update(['status' => 'active']);

        return redirect()
            ->back()
            ->with('success', 'Website berhasil diaktifkan.');
    }

    /**
     * Delete website
     */
    public function destroy(Website $website): RedirectResponse
    {
        $this->checkSuperAdmin();

        $type = $website->type;
        $website->delete();

        return redirect()
            ->route('admin.websites.' . $type)
            ->with('success', 'Website berhasil dihapus.');
    }

    /**
     * Status Aktivasi & Domain
     */
    public function domain(Request $request): View
    {
        $this->checkSuperAdmin();

        $query = Website::whereNotNull('custom_domain')->with('user');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('custom_domain', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Filter by DNS status
        if ($request->has('dns_status') && $request->dns_status !== '') {
            $query->where('dns_status', $request->dns_status);
        }

        $websites = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.super-admin.websites.domain', compact('websites'));
    }

    /**
     * Activate custom domain
     */
    public function activateDomain(Request $request, Website $website): RedirectResponse
    {
        $this->checkSuperAdmin();

        $validated = $request->validate([
            'custom_domain' => 'required|string|max:255',
            'dns_status' => 'required|in:pending,active,failed',
        ]);

        $website->update($validated);

        return redirect()
            ->route('admin.websites.domain')
            ->with('success', 'Domain berhasil diaktifkan.');
    }

    /**
     * Integrasi Template
     */
    public function template(): View
    {
        $this->checkSuperAdmin();

        $templates = [
            'default' => 'Template Default',
            'modern' => 'Template Modern',
            'classic' => 'Template Classic',
            'minimal' => 'Template Minimal',
        ];

        $defaultTemplateDesa = 'default';
        $defaultTemplateUmkm = 'default';

        return view('admin.super-admin.websites.template', compact('templates', 'defaultTemplateDesa', 'defaultTemplateUmkm'));
    }

    /**
     * Update default template
     */
    public function updateTemplate(Request $request): RedirectResponse
    {
        $this->checkSuperAdmin();

        $validated = $request->validate([
            'template_desa' => 'required|string',
            'template_umkm' => 'required|string',
        ]);

        // Simpan ke config atau database settings
        // Untuk sekarang kita simpan ke session atau bisa dibuat tabel settings
        session([
            'default_template_desa' => $validated['template_desa'],
            'default_template_umkm' => $validated['template_umkm'],
        ]);

        return redirect()
            ->route('admin.websites.template')
            ->with('success', 'Template default berhasil diperbarui.');
    }
}
