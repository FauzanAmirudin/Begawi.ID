<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Village;
use App\Models\UmkmBusiness;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LocalUserManagementController extends Controller
{
    /**
     * Get village and website for current user
     */
    protected function getUserVillageData()
    {
        $user = Auth::user();
        
        if ($user->role === User::ROLE_SUPER_ADMIN) {
            $website = Website::where('type', 'desa')->first();
        } else {
            $website = Website::where('user_id', $user->id)
                ->where('type', 'desa')
                ->first();
        }

        // If website exists, get or create village
        if ($website) {
            $village = Village::where('website_id', $website->id)->first();
            
            // If village doesn't exist, create it (similar to VillageManagementController)
            if (!$village) {
                $village = Village::create([
                    'website_id' => $website->id,
                    'name' => $website->name ?? 'Desa',
                    'slug' => \Illuminate\Support\Str::slug($website->name ?? 'desa'),
                ]);
            }
        } else {
            // For admin_desa without website, create default village
            // This handles the case where website might not be set up yet
            if ($user->role === User::ROLE_ADMIN_DESA) {
                $village = Village::query()->firstOrCreate(
                    ['slug' => 'desa-sejahtera'],
                    ['name' => 'Desa Sejahtera']
                );
            } else {
                $village = null;
            }
        }

        return [
            'village' => $village,
            'website' => $website,
        ];
    }

    /**
     * Display a listing of local users
     */
    public function index(Request $request)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];
        
        // If still no village, show empty state instead of 404
        if (!$village) {
            return view('admin.local-users.index', [
                'users' => collect([])->paginate(15),
                'village' => null,
                'stats' => [
                    'total' => 0,
                    'active' => 0,
                    'umkm_admins' => 0,
                    'editors' => 0,
                ],
                'filters' => $request->only(['search', 'role', 'status']),
            ]);
        }

        $query = User::query()
            ->where(function ($q) use ($village) {
                // Users directly linked to village (operators/editors)
                $q->where('village_id', $village->id)
                    // Or users linked via UMKM businesses in this village
                    ->orWhereHas('umkmBusinesses', function ($q2) use ($village) {
                        $q2->where('village_id', $village->id);
                    });
            })
            ->where('role', '!=', User::ROLE_SUPER_ADMIN)
            ->with(['umkmBusinesses' => function ($q) use ($village) {
                $q->where('village_id', $village->id);
            }]);

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Role filter
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total' => User::where(function ($q) use ($village) {
                $q->where('village_id', $village->id)
                    ->orWhereHas('umkmBusinesses', function ($q2) use ($village) {
                        $q2->where('village_id', $village->id);
                    });
            })->where('role', '!=', User::ROLE_SUPER_ADMIN)->count(),
            'active' => User::where(function ($q) use ($village) {
                $q->where('village_id', $village->id)
                    ->orWhereHas('umkmBusinesses', function ($q2) use ($village) {
                        $q2->where('village_id', $village->id);
                    });
            })->where('role', '!=', User::ROLE_SUPER_ADMIN)
                ->where('status', 'active')->count(),
            'umkm_admins' => User::whereHas('umkmBusinesses', function ($q) use ($village) {
                $q->where('village_id', $village->id);
            })->where('role', User::ROLE_ADMIN_UMKM)->count(),
            'editors' => User::where('village_id', $village->id)
                ->where('role', 'editor_desa')->count(),
        ];

        return view('admin.local-users.index', [
            'users' => $users,
            'village' => $village,
            'stats' => $stats,
            'filters' => $request->only(['search', 'role', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];
        
        // If no village, redirect to index with message
        if (!$village) {
            return redirect()->route('admin.desa-management.local-users.index')
                ->with('error', 'Village belum dikonfigurasi. Silakan hubungi administrator.');
        }

        return view('admin.local-users.create', [
            'village' => $village,
        ]);
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];
        
        if (!$village) {
            abort(404, 'Village not found');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in([User::ROLE_ADMIN_UMKM, 'editor_desa'])],
            'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
            'umkm_business_id' => ['nullable', 'exists:umkm_businesses,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
            'village_id' => $validated['role'] === 'editor_desa' ? $village->id : null,
        ]);

        // If UMKM admin, link to UMKM business
        if ($validated['role'] === User::ROLE_ADMIN_UMKM && isset($validated['umkm_business_id'])) {
            UmkmBusiness::where('id', $validated['umkm_business_id'])
                ->update(['user_id' => $user->id]);
        }

        return redirect()->route('admin.desa-management.local-users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Display roles management page
     */
    public function roles()
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];
        
        // If no village, redirect to index with message
        if (!$village) {
            return redirect()->route('admin.desa-management.local-users.index')
                ->with('error', 'Village belum dikonfigurasi. Silakan hubungi administrator.');
        }

        // Get role statistics
        $roleStats = [
            'admin_umkm' => [
                'label' => 'Admin UMKM',
                'description' => 'Mengelola UMKM dan produk mereka',
                'count' => User::whereHas('umkmBusinesses', function ($q) use ($village) {
                    $q->where('village_id', $village->id);
                })->where('role', User::ROLE_ADMIN_UMKM)->count(),
                'permissions' => [
                    'Mengelola produk UMKM',
                    'Mengelola konten toko',
                    'Melihat statistik penjualan',
                    'Mengelola pesanan',
                ],
            ],
            'editor_desa' => [
                'label' => 'Editor Desa',
                'description' => 'Mengelola konten website desa',
                'count' => User::where('village_id', $village->id)
                    ->where('role', 'editor_desa')->count(),
                'permissions' => [
                    'Mengelola berita desa',
                    'Mengelola galeri',
                    'Mengelola potensi & wisata',
                    'Mengelola prestasi & program',
                ],
            ],
        ];

        return view('admin.local-users.roles', [
            'village' => $village,
            'roleStats' => $roleStats,
        ]);
    }

    /**
     * Reset password for a user
     */
    public function resetPassword(Request $request, User $user)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];
        
        // Verify user belongs to this village
        $belongsToVillage = $user->village_id === $village->id || 
            $user->umkmBusinesses()->where('village_id', $village->id)->exists();
        
        if (!$belongsToVillage) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()
            ->with('success', 'Password berhasil direset.');
    }

    /**
     * Toggle user status (activate/deactivate)
     */
    public function toggleStatus(User $user)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];
        
        // Verify user belongs to this village
        $belongsToVillage = $user->village_id === $village->id || 
            $user->umkmBusinesses()->where('village_id', $village->id)->exists();
        
        if (!$belongsToVillage) {
            abort(403, 'Unauthorized');
        }

        $user->update([
            'status' => $user->status === 'active' ? 'inactive' : 'active',
        ]);

        return redirect()->back()
            ->with('success', 'Status pengguna berhasil diubah.');
    }

    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];
        
        // Verify user belongs to this village
        $belongsToVillage = $user->village_id === $village->id || 
            $user->umkmBusinesses()->where('village_id', $village->id)->exists();
        
        if (!$belongsToVillage) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'role' => ['required', 'string', Rule::in([User::ROLE_ADMIN_UMKM, 'editor_desa'])],
        ]);

        $user->update([
            'role' => $validated['role'],
            'village_id' => $validated['role'] === 'editor_desa' ? $village->id : null,
        ]);

        return redirect()->back()
            ->with('success', 'Role pengguna berhasil diubah.');
    }
}
