@extends('layouts.admin')

@section('title', 'Role Lokal')

@section('content')
<div class="p-6">
    <div class="flex gap-6">
        <!-- Main Column -->
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Role Lokal</h1>
                    <p class="text-sm text-gray-500 mt-1">Pembagian akses di tingkat desa</p>
                </div>
                <a href="{{ route('admin.desa-management.local-users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Role Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Admin UMKM -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Admin UMKM</h3>
                                <p class="text-sm text-gray-500">{{ $roleStats['admin_umkm']['description'] }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-600 rounded-full">
                            {{ $roleStats['admin_umkm']['count'] }} Pengguna
                        </span>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Hak Akses:</h4>
                        <ul class="space-y-2">
                            @foreach($roleStats['admin_umkm']['permissions'] as $permission)
                            <li class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $permission }}
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.desa-management.local-users.index', ['role' => 'admin_umkm']) }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                            Lihat Semua Admin UMKM →
                        </a>
                    </div>
                </div>

                <!-- Editor Desa -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Editor Desa</h3>
                                <p class="text-sm text-gray-500">{{ $roleStats['editor_desa']['description'] }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold bg-amber-100 text-amber-600 rounded-full">
                            {{ $roleStats['editor_desa']['count'] }} Pengguna
                        </span>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Hak Akses:</h4>
                        <ul class="space-y-2">
                            @foreach($roleStats['editor_desa']['permissions'] as $permission)
                            <li class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $permission }}
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.desa-management.local-users.index', ['role' => 'editor_desa']) }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                            Lihat Semua Editor Desa →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Role Comparison Table -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Perbandingan Role</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Fitur</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-purple-700">Admin UMKM</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-amber-700">Editor Desa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600">Mengelola Produk UMKM</td>
                                <td class="px-4 py-3 text-center">
                                    <svg class="w-5 h-5 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <svg class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600">Mengelola Konten Toko</td>
                                <td class="px-4 py-3 text-center">
                                    <svg class="w-5 h-5 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <svg class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600">Mengelola Berita Desa</td>
                                <td class="px-4 py-3 text-center">
                                    <svg class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <svg class="w-5 h-5 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600">Mengelola Galeri</td>
                                <td class="px-4 py-3 text-center">
                                    <svg class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <svg class="w-5 h-5 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600">Mengelola Potensi & Wisata</td>
                                <td class="px-4 py-3 text-center">
                                    <svg class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <svg class="w-5 h-5 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-600">Melihat Statistik Penjualan</td>
                                <td class="px-4 py-3 text-center">
                                    <svg class="w-5 h-5 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <svg class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="w-80">
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
                    <a href="{{ route('admin.desa-management.local-users.index') }}" class="block rounded-xl bg-gradient-to-r from-blue-500 to-indigo-500 p-4 hover:opacity-95 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/15 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">Daftar Pengguna</p>
                                <p class="text-xs text-white/70 mt-1">Lihat semua pengguna</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

