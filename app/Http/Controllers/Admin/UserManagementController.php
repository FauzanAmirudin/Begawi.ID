<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserManagementController extends Controller
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
    public function index(Request $request): View
    {
        $this->checkSuperAdmin();
        
        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.super-admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->checkSuperAdmin();
        
        return view('admin.super-admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status ?? 'active',
            'email_verified_at' => now(),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $this->checkSuperAdmin();
        
        return view('admin.super-admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $this->checkSuperAdmin();
        
        return view('admin.super-admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status ?? $user->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        // Prevent deleting yourself
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();
        if ($user->id === $currentUser->id) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Toggle user status (activate/deactivate)
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $user->update([
            'status' => $user->status === 'active' ? 'inactive' : 'active',
        ]);

        $message = $user->status === 'active' 
            ? 'Pengguna berhasil diaktifkan.' 
            : 'Pengguna berhasil dinonaktifkan.';

        return redirect()
            ->route('admin.users.index')
            ->with('success', $message);
    }

    /**
     * Reset user password
     */
    public function resetPassword(User $user): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $newPassword = 'password123'; // Default password
        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Password pengguna berhasil direset. Password baru: {$newPassword}");
    }
}
