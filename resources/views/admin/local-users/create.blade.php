@extends('layouts.admin')

@section('title', 'Tambah Pengguna Lokal')

@section('content')
<div class="p-6">
    <div class="flex gap-6">
        <!-- Main Column -->
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Tambah Pengguna Lokal</h1>
                    <p class="text-sm text-gray-500 mt-1">Buat akun baru untuk UMKM atau operator desa</p>
                </div>
                <a href="{{ route('admin.desa-management.local-users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form method="POST" action="{{ route('admin.desa-management.local-users.store') }}" class="space-y-6">
                    @csrf

                    @if ($errors->any())
                        <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Masukkan nama lengkap"
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="user@example.com"
                        >
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            minlength="8"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Minimal 8 karakter"
                        >
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            minlength="8"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Ulangi password"
                        >
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="role"
                            name="role"
                            required
                            onchange="toggleUmkmSelect()"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                            <option value="">Pilih Role</option>
                            <option value="admin_umkm" {{ old('role') == 'admin_umkm' ? 'selected' : '' }}>Admin UMKM</option>
                            <option value="editor_desa" {{ old('role') == 'editor_desa' ? 'selected' : '' }}>Editor Desa</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                            <span id="role-description-admin_umkm" class="hidden">Mengelola UMKM dan produk mereka</span>
                            <span id="role-description-editor_desa" class="hidden">Mengelola konten website desa</span>
                        </p>
                    </div>

                    <!-- UMKM Business (only for admin_umkm) -->
                    <div id="umkm-business-field" class="hidden">
                        <label for="umkm_business_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih UMKM <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="umkm_business_id"
                            name="umkm_business_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                            <option value="">Pilih UMKM</option>
                            @if($village)
                                @php
                                    $umkmBusinesses = \App\Models\UmkmBusiness::where('village_id', $village->id)
                                        ->whereNull('user_id')
                                        ->get();
                                @endphp
                                @foreach($umkmBusinesses as $umkm)
                                    <option value="{{ $umkm->id }}" {{ old('umkm_business_id') == $umkm->id ? 'selected' : '' }}>
                                        {{ $umkm->name }} - {{ $umkm->owner_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Pilih UMKM yang akan dikelola oleh pengguna ini</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <select
                            id="status"
                            name="status"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center gap-4 pt-4">
                        <button
                            type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-medium hover:shadow-lg transition"
                        >
                            Simpan Pengguna
                        </button>
                        <a href="{{ route('admin.desa-management.local-users.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="w-80">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-base font-semibold text-gray-800 mb-4">Informasi Role</h3>
                <div class="space-y-4">
                    <div class="p-4 rounded-xl bg-purple-50 border border-purple-100">
                        <h4 class="text-sm font-semibold text-purple-900 mb-2">Admin UMKM</h4>
                        <p class="text-xs text-purple-700 mb-3">Mengelola UMKM dan produk mereka</p>
                        <ul class="text-xs text-purple-600 space-y-1">
                            <li>• Mengelola produk UMKM</li>
                            <li>• Mengelola konten toko</li>
                            <li>• Melihat statistik penjualan</li>
                            <li>• Mengelola pesanan</li>
                        </ul>
                    </div>
                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-100">
                        <h4 class="text-sm font-semibold text-amber-900 mb-2">Editor Desa</h4>
                        <p class="text-xs text-amber-700 mb-3">Mengelola konten website desa</p>
                        <ul class="text-xs text-amber-600 space-y-1">
                            <li>• Mengelola berita desa</li>
                            <li>• Mengelola galeri</li>
                            <li>• Mengelola potensi & wisata</li>
                            <li>• Mengelola prestasi & program</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleUmkmSelect() {
    const role = document.getElementById('role').value;
    const umkmField = document.getElementById('umkm-business-field');
    const umkmSelect = document.getElementById('umkm_business_id');
    
    // Hide all role descriptions
    document.querySelectorAll('[id^="role-description-"]').forEach(el => {
        el.classList.add('hidden');
    });
    
    if (role === 'admin_umkm') {
        umkmField.classList.remove('hidden');
        umkmSelect.required = true;
        document.getElementById('role-description-admin_umkm').classList.remove('hidden');
    } else if (role === 'editor_desa') {
        umkmField.classList.add('hidden');
        umkmSelect.required = false;
        umkmSelect.value = '';
        document.getElementById('role-description-editor_desa').classList.remove('hidden');
    } else {
        umkmField.classList.add('hidden');
        umkmSelect.required = false;
        umkmSelect.value = '';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleUmkmSelect();
});
</script>
@endsection

