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

        $query = Website::where('type', 'desa')->with('user');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%")
                    ->orWhere('custom_domain', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $websites = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.super-admin.websites.desa', compact('websites'));
    }

    /**
     * Website UMKM - List all UMKM websites
     */
    public function umkm(Request $request): View
    {
        $this->checkSuperAdmin();

        $query = Website::where('type', 'umkm')->with('user');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%")
                    ->orWhere('custom_domain', 'like', "%{$search}%");
            });
        }

        // Filter by desa (via user)
        if ($request->has('desa') && $request->desa) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->desa}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $websites = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.super-admin.websites.umkm', compact('websites'));
    }

    /**
     * Show website details
     */
    public function show(Website $website): View
    {
        $this->checkSuperAdmin();
        
        $website->load('user');
        
        return view('admin.super-admin.websites.show', compact('website'));
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
