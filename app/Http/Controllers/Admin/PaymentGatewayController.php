<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewayConfig;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaymentGatewayController extends Controller
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
     * Display payment gateway configurations
     */
    public function index(): View
    {
        $this->checkSuperAdmin();
        
        $gateways = PaymentGatewayConfig::all();

        return view('admin.super-admin.finance.payment-gateways.index', compact('gateways'));
    }

    /**
     * Show the form for editing payment gateway config
     */
    public function edit(PaymentGatewayConfig $paymentGateway): View
    {
        $this->checkSuperAdmin();
        
        return view('admin.super-admin.finance.payment-gateways.edit', compact('paymentGateway'));
    }

    /**
     * Update payment gateway configuration
     */
    public function update(Request $request, PaymentGatewayConfig $paymentGateway): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'environment' => 'required|in:sandbox,production',
            'server_key' => 'nullable|string',
            'client_key' => 'nullable|string',
            'api_key' => 'nullable|string',
            'secret_key' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $paymentGateway->update($validated);

        return redirect()
            ->route('admin.finance.payment-gateways.index')
            ->with('success', 'Konfigurasi payment gateway berhasil diperbarui.');
    }

    /**
     * Create or update payment gateway config
     */
    public function store(Request $request): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'gateway' => 'required|in:midtrans,xendit',
            'environment' => 'required|in:sandbox,production',
            'server_key' => 'nullable|string',
            'client_key' => 'nullable|string',
            'api_key' => 'nullable|string',
            'secret_key' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        PaymentGatewayConfig::updateOrCreate(
            ['gateway' => $validated['gateway']],
            $validated
        );

        return redirect()
            ->route('admin.finance.payment-gateways.index')
            ->with('success', 'Konfigurasi payment gateway berhasil disimpan.');
    }
}
