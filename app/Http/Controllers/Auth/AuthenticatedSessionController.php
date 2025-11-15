<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login form.
     */
    public function create(Request $request): View|RedirectResponse
    {
        if ($request->user()) {
            return redirect()->route('admin.dashboard.index');
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        /** @var User $user */
        $user = $request->user();

        if (! in_array($user->role, [
            User::ROLE_SUPER_ADMIN,
            User::ROLE_ADMIN_DESA,
            User::ROLE_ADMIN_UMKM,
        ], true)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Akun Anda belum memiliki akses ke dashboard.',
                ], 'login');
        }

        // Update last login timestamp
        $user->update(['last_login_at' => now()]);

        return redirect()->route('admin.dashboard.index');
    }

    /**
     * Destroy an authenticated session.
     * Handles both POST (with CSRF) and GET (direct URL access) requests.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            // Logout user (safe to call even if already logged out)
            if (Auth::check()) {
                Auth::guard('web')->logout();
            }

            // Invalidate session if it exists
            if ($request->hasSession()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            // Redirect to home with success message
            return redirect()->route('home')->with('status', 'Anda telah berhasil logout.');
        } catch (\Exception $e) {
            // If there's any error (e.g., session expired), just redirect to home
            return redirect()->route('home');
        }
    }
}

