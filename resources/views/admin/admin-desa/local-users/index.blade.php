@extends('layouts.admin')

@section('title', 'Manajemen Pengguna Lokal')

@section('content')
<div class="p-6">
    <div class="flex gap-6">
        <!-- Main Column -->
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Manajemen Pengguna Lokal</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola pengguna di tingkat desa (UMKM & Operator)</p>
                </div>
                <a href="{{ route('admin.desa-management.local-users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-medium hover:shadow-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pengguna
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Total Pengguna</p>
                            <p class="text-3xl font-bold mt-1">{{ $stats['total'] }}</p>
                            <p class="text-white/60 text-xs mt-2">Semua pengguna desa</p>
                        </div>
                        <div class="bg-white/15 rounded-xl p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>

                <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Pengguna Aktif</p>
                            <p class="text-3xl font-bold mt-1">{{ $stats['active'] }}</p>
                            <p class="text-white/60 text-xs mt-2">Status aktif</p>
                        </div>
                        <div class="bg-white/15 rounded-xl p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 via-purple-600 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Admin UMKM</p>
                            <p class="text-3xl font-bold mt-1">{{ $stats['umkm_admins'] }}</p>
                            <p class="text-white/60 text-xs mt-2">Pemilik UMKM</p>
                        </div>
                        <div class="bg-white/15 rounded-xl p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>

                <div class="bg-gradient-to-br from-amber-500 via-orange-500 to-rose-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Editor Desa</p>
                            <p class="text-3xl font-bold mt-1">{{ $stats['editors'] }}</p>
                            <p class="text-white/60 text-xs mt-2">Operator konten</p>
                        </div>
                        <div class="bg-white/15 rounded-xl p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <form method="GET" action="{{ route('admin.desa-management.local-users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $filters['search'] ?? '' }}"
                            placeholder="Nama, Email, atau Nama UMKM..."
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select 
                            name="role" 
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                            <option value="">Semua Role</option>
                            <option value="admin_umkm" {{ ($filters['role'] ?? '') == 'admin_umkm' ? 'selected' : '' }}>Admin UMKM</option>
                            <option value="editor_desa" {{ ($filters['role'] ?? '') == 'editor_desa' ? 'selected' : '' }}>Editor Desa</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select 
                            name="status" 
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                            <option value="">Semua Status</option>
                            <option value="active" {{ ($filters['status'] ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ ($filters['status'] ?? '') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="w-full px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                            Filter
                        </button>
                        <a href="{{ route('admin.desa-management.local-users.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Results Info -->
            @if(request()->hasAny(['search', 'role', 'status']))
            <div class="mb-4 text-sm text-gray-600">
                Menampilkan <span class="font-semibold text-gray-900">{{ $users->total() }}</span> hasil
                @if(request()->filled('search'))
                    untuk "<span class="font-semibold text-gray-900">{{ request('search') }}</span>"
                @endif
                @if(request()->filled('role'))
                    dengan role <span class="font-semibold text-gray-900">{{ request('role') === 'admin_umkm' ? 'Admin UMKM' : 'Editor Desa' }}</span>
                @endif
                @if(request()->filled('status'))
                    dengan status <span class="font-semibold text-gray-900">{{ request('status') === 'active' ? 'Aktif' : 'Nonaktif' }}</span>
                @endif
            </div>
            @endif

            <!-- Users Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Login</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-semibold mr-3">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            @if($user->umkmBusinesses->count() > 0)
                                            <div class="text-xs text-gray-500">{{ $user->umkmBusinesses->first()->name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role === 'admin_umkm')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Admin UMKM</span>
                                    @elseif($user->role === 'editor_desa')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Editor Desa</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->status === 'active')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah login' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="openResetPasswordModal({{ $user->id }}, '{{ $user->name }}')" class="text-orange-600 hover:text-orange-900" title="Reset Password">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                            </svg>
                                        </button>
                                        <form action="{{ route('admin.desa-management.local-users.toggle-status', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-900" title="{{ $user->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                @if($user->status === 'active')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                    </svg>
                                    <p class="mt-2 text-sm">Tidak ada pengguna ditemukan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="w-80 space-y-6">
            <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-6 text-white shadow-lg border border-gray-800">
                <h3 class="text-lg font-semibold mb-4">Tindakan Cepat</h3>
                <div class="space-y-4">
                    <a href="{{ route('admin.desa-management.local-users.create') }}" class="block rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 p-4 hover:opacity-95 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/15 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">Tambah Pengguna</p>
                                <p class="text-xs text-white/70 mt-1">Buat akun baru</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('admin.desa-management.local-users.roles') }}" class="block rounded-xl bg-gradient-to-r from-purple-500 to-indigo-500 p-4 hover:opacity-95 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/15 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">Kelola Role</p>
                                <p class="text-xs text-white/70 mt-1">Atur akses pengguna</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div id="resetPasswordModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Reset Password</h3>
        <p class="text-sm text-gray-600 mb-4">Reset password untuk <span id="userNameModal"></span></p>
        <form id="resetPasswordForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                    Reset Password
                </button>
                <button type="button" onclick="closeResetPasswordModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openResetPasswordModal(userId, userName) {
    document.getElementById('userNameModal').textContent = userName;
    document.getElementById('resetPasswordForm').action = `/admin/desa-management/local-users/${userId}/reset-password`;
    document.getElementById('resetPasswordModal').classList.remove('hidden');
    document.getElementById('resetPasswordModal').classList.add('flex');
}

function closeResetPasswordModal() {
    document.getElementById('resetPasswordModal').classList.add('hidden');
    document.getElementById('resetPasswordModal').classList.remove('flex');
}
</script>
@endsection

