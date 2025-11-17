<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Website;
use App\Models\Village;
use App\Models\UmkmBusiness;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
     * Show create website form
     */
    public function create(Request $request): View
    {
        $this->checkSuperAdmin();

        $villages = Village::orderBy('name')->get(['id', 'name', 'location']);
        $defaultType = $request->get('type');
        if (!in_array($defaultType, ['desa', 'umkm'])) {
            $defaultType = 'desa';
        }

        $categoryOptions = [
            'Makanan & Minuman',
            'Kerajinan & Fashion',
            'Kesehatan & Herbal',
            'Pertanian & Perkebunan',
            'Teknologi & Digital',
            'Jasa & Layanan',
        ];

        return view('admin.super-admin.websites.create', compact('villages', 'defaultType', 'categoryOptions'));
    }

    /**
     * Store new website
     */
    public function store(Request $request): RedirectResponse
    {
        $this->checkSuperAdmin();

        $type = $request->input('type', 'desa');

        $rules = [
            'type' => ['required', Rule::in(['desa', 'umkm'])],
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255', 'unique:websites,url'],
            'custom_domain' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['active', 'suspended', 'inactive'])],
            'template_id' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'admin_phone' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:8'],
        ];

        if ($type === 'desa') {
            $rules = array_merge($rules, [
                'existing_village_id' => ['nullable', 'exists:villages,id'],
                'village_name' => ['required_without:existing_village_id', 'string', 'max:255'],
                'village_location' => ['nullable', 'string', 'max:255'],
                'village_tagline' => ['nullable', 'string', 'max:255'],
                'village_logo' => ['nullable', 'image', 'max:2048'],
                'village_banner' => ['nullable', 'image', 'max:4096'],
            ]);
        } else {
            $rules = array_merge($rules, [
                'umkm_category' => ['required', 'string', 'max:255'],
                'linked_village_id' => ['nullable', 'exists:villages,id'],
                'umkm_description' => ['nullable', 'string'],
                'umkm_logo' => ['nullable', 'image', 'max:2048'],
            ]);
        }

        $validated = $request->validate($rules);

        if ($type === 'desa' && !empty($validated['existing_village_id'])) {
            $existingVillage = Village::find($validated['existing_village_id']);
            if ($existingVillage && $existingVillage->website_id) {
                return back()
                    ->withInput()
                    ->withErrors(['existing_village_id' => 'Desa ini sudah memiliki website yang terhubung.']);
            }
        }

        $plainPassword = $validated['password'] ?? Str::random(12);

        $villageForDesa = null;
        if ($type === 'desa') {
            if (!empty($validated['existing_village_id'])) {
                $villageForDesa = Village::find($validated['existing_village_id']);
                if (!empty($validated['village_name'])) {
                    $villageForDesa->name = $validated['village_name'];
                }
                if (!empty($validated['village_location'])) {
                    $villageForDesa->location = $validated['village_location'];
                }
                if (!empty($validated['village_tagline'])) {
                    $villageForDesa->tagline = $validated['village_tagline'];
                }
                if (!$villageForDesa->slug) {
                    $villageForDesa->slug = Str::slug($villageForDesa->name);
                }
                $villageForDesa->save();
            } else {
                $villageForDesa = Village::create([
                    'name' => $validated['village_name'],
                    'slug' => Str::slug($validated['village_name']),
                    'location' => $validated['village_location'] ?? null,
                    'tagline' => $validated['village_tagline'] ?? null,
                ]);
            }

            if ($request->hasFile('village_logo') && $villageForDesa) {
                $logoPath = $request->file('village_logo')->store('villages/logos', 'public');
                $villageForDesa->logo_path = $logoPath;
            }

            if ($request->hasFile('village_banner') && $villageForDesa) {
                $bannerPath = $request->file('village_banner')->store('villages/banners', 'public');
                $villageForDesa->image = $bannerPath;
            }

            $villageForDesa?->save();
        }

        $user = User::create([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($plainPassword),
            'role' => $type === 'desa' ? User::ROLE_ADMIN_DESA : User::ROLE_ADMIN_UMKM,
            'status' => 'active',
            'village_id' => $type === 'desa'
                ? ($villageForDesa?->id)
                : ($validated['linked_village_id'] ?? null),
        ]);

        $website = Website::create([
            'name' => $validated['name'],
            'type' => $type,
            'url' => $validated['url'],
            'custom_domain' => $validated['custom_domain'] ?? null,
            'status' => $validated['status'],
            'user_id' => $user->id,
            'template_id' => $validated['template_id'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($type === 'desa' && $villageForDesa) {
            $villageForDesa->website_id = $website->id;
            $villageForDesa->save();
        }

        if ($type === 'umkm') {
            $umkmLogoPath = null;
            if ($request->hasFile('umkm_logo')) {
                $umkmLogoPath = $request->file('umkm_logo')->store('umkm/logos', 'public');
            }

            UmkmBusiness::create([
                'website_id' => $website->id,
                'village_id' => $validated['linked_village_id'] ?? null,
                'user_id' => $user->id,
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'subdomain' => $validated['url'],
                'owner_name' => $validated['admin_name'],
                'owner_email' => $validated['admin_email'],
                'owner_phone' => $validated['admin_phone'] ?? null,
                'whatsapp_number' => $validated['admin_phone'] ?? null,
                'category' => $validated['umkm_category'],
                'description' => $validated['umkm_description'] ?? null,
                'logo_path' => $umkmLogoPath,
                'status' => 'onboarding',
            ]);
        }

        $message = "Website baru berhasil dibuat. Kredensial admin: {$validated['admin_email']} / {$plainPassword}";

        return redirect()
            ->route('admin.websites.' . $website->type)
            ->with('success', $message);
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
     * Edit village profile
     */
    public function editVillageProfile(Website $website): View
    {
        $this->checkSuperAdmin();

        if ($website->type !== 'desa') {
            abort(404, 'Website ini bukan website desa.');
        }

        $village = Village::where('website_id', $website->id)->firstOrFail();

        return view('admin.super-admin.websites.village-profile', compact('website', 'village'));
    }

    /**
     * Update village profile
     */
    public function updateVillageProfile(Request $request, Website $website): RedirectResponse
    {
        $this->checkSuperAdmin();

        if ($website->type !== 'desa') {
            abort(404, 'Website ini bukan website desa.');
        }

        $village = Village::where('website_id', $website->id)->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'head' => ['nullable', 'string', 'max:255'],
            'head_title' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'population' => ['nullable', 'numeric'],
            'area' => ['nullable', 'numeric'],
            'density' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'vision_period' => ['nullable', 'string', 'max:100'],
            'missions' => ['nullable', 'string'],
            'contacts' => ['nullable', 'string'],
            'structures' => ['nullable', 'string'],
            'history' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'banner' => ['nullable', 'image', 'max:4096'],
        ]);

        $missions = $this->parseLines($validated['missions'] ?? null);
        $contacts = $this->parseJson($validated['contacts'] ?? null);
        $structures = $this->parseJson($validated['structures'] ?? null);
        $history = $this->parseJson($validated['history'] ?? null);

        $village->fill([
            'name' => $validated['name'],
            'slug' => $village->slug ?: Str::slug($validated['name']),
            'tagline' => $validated['tagline'] ?? null,
            'head' => $validated['head'] ?? null,
            'head_title' => $validated['head_title'] ?? null,
            'location' => $validated['location'] ?? null,
            'code' => $validated['code'] ?? null,
            'population' => $validated['population'] ?? null,
            'area' => $validated['area'] ?? null,
            'density' => $validated['density'] ?? null,
            'description' => $validated['description'] ?? null,
            'vision' => $validated['vision'] ?? null,
            'vision_period' => $validated['vision_period'] ?? null,
            'missions' => $missions,
            'contacts' => $contacts,
            'structures' => $structures,
            'history' => $history,
        ]);

        if ($request->hasFile('logo')) {
            if ($village->logo_path) {
                Storage::disk('public')->delete($village->logo_path);
            }
            $village->logo_path = $request->file('logo')->store('villages/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($village->image) {
                Storage::disk('public')->delete($village->image);
            }
            $village->image = $request->file('banner')->store('villages/banners', 'public');
        }

        $village->save();

        return redirect()
            ->route('admin.websites.village-profile.edit', $website)
            ->with('success', 'Profil desa berhasil diperbarui.');
    }

    /**
     * Edit UMKM profile
     */
    public function editUmkmProfile(Website $website): View
    {
        $this->checkSuperAdmin();

        if ($website->type !== 'umkm') {
            abort(404, 'Website ini bukan website UMKM.');
        }

        $umkm = UmkmBusiness::where('website_id', $website->id)->with('village')->firstOrFail();

        $villages = Village::orderBy('name')->get(['id', 'name', 'location']);

        return view('admin.super-admin.websites.umkm-profile', compact('website', 'umkm', 'villages'));
    }

    /**
     * Update UMKM profile
     */
    public function updateUmkmProfile(Request $request, Website $website): RedirectResponse
    {
        $this->checkSuperAdmin();

        if ($website->type !== 'umkm') {
            abort(404, 'Website ini bukan website UMKM.');
        }

        $umkm = UmkmBusiness::where('website_id', $website->id)->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'owner_name' => ['required', 'string', 'max:255'],
            'owner_email' => ['required', 'email', Rule::unique('umkm_businesses', 'owner_email')->ignore($umkm->id)],
            'owner_phone' => ['nullable', 'string', 'max:50'],
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'maps_embed_url' => ['nullable', 'string'],
            'branding_color' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
            'about_business' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['onboarding', 'active', 'suspended', 'inactive'])],
            'village_id' => ['nullable', 'exists:villages,id'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $umkm->fill([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'owner_name' => $validated['owner_name'],
            'owner_email' => $validated['owner_email'],
            'owner_phone' => $validated['owner_phone'] ?? null,
            'whatsapp_number' => $validated['whatsapp_number'] ?? null,
            'address' => $validated['address'] ?? null,
            'maps_embed_url' => $validated['maps_embed_url'] ?? null,
            'branding_color' => $validated['branding_color'] ?? null,
            'description' => $validated['description'] ?? null,
            'about_business' => $validated['about_business'] ?? null,
            'status' => $validated['status'],
            'village_id' => $validated['village_id'] ?? null,
        ]);

        if ($request->hasFile('logo')) {
            if ($umkm->logo_path) {
                Storage::disk('public')->delete($umkm->logo_path);
            }
            $umkm->logo_path = $request->file('logo')->store('umkm/logos', 'public');
        }

        $umkm->save();

        if ($umkm->user) {
            $umkm->user->update([
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
                'village_id' => $validated['village_id'] ?? $umkm->user->village_id,
            ]);
        }

        $website->update(['name' => $validated['name']]);

        return redirect()
            ->route('admin.websites.umkm-profile.edit', $website)
            ->with('success', 'Profil UMKM berhasil diperbarui.');
    }

    protected function parseLines(?string $value): ?array
    {
        if (!$value) {
            return null;
        }

        $lines = array_filter(array_map('trim', preg_split('/\r\n|\n|\r/', $value)));

        return !empty($lines) ? array_values($lines) : null;
    }

    protected function parseJson(?string $value): ?array
    {
        if (!$value) {
            return null;
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : null;
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
