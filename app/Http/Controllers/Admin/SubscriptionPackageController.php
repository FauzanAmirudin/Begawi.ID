<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPackage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SubscriptionPackageController extends Controller
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
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->checkSuperAdmin();
        
        $packages = SubscriptionPackage::orderBy('sort_order')->orderBy('price')->get();

        return view('admin.super-admin.finance.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->checkSuperAdmin();
        
        return view('admin.super-admin.finance.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        SubscriptionPackage::create($validated);

        return redirect()
            ->route('admin.finance.packages.index')
            ->with('success', 'Paket langganan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionPackage $package): View
    {
        $this->checkSuperAdmin();
        
        return view('admin.super-admin.finance.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubscriptionPackage $package): View
    {
        $this->checkSuperAdmin();
        
        return view('admin.super-admin.finance.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscriptionPackage $package): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $package->update($validated);

        return redirect()
            ->route('admin.finance.packages.index')
            ->with('success', 'Paket langganan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPackage $package): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        // Check if package has transactions
        if ($package->transactions()->count() > 0) {
            return redirect()
                ->route('admin.finance.packages.index')
                ->with('error', 'Paket tidak dapat dihapus karena memiliki transaksi terkait.');
        }

        $package->delete();

        return redirect()
            ->route('admin.finance.packages.index')
            ->with('success', 'Paket langganan berhasil dihapus.');
    }
}
