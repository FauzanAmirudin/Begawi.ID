<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  array<int, string>  $roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $allowedRoles = $roles ?: [
            User::ROLE_SUPER_ADMIN,
            User::ROLE_ADMIN_DESA,
            User::ROLE_ADMIN_UMKM,
        ];

        if (! in_array($user->role, $allowedRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}

