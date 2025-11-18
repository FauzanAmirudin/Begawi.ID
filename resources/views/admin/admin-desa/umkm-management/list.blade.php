@extends('layouts.admin')

@section('title', 'Daftar UMKM')

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <div class="p-6 space-y-6" x-data="{}" x-cloak>
        @if (session('success'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
                <button class="text-xs text-emerald-600 hover:text-emerald-500"
                    @click="$el.parentElement.remove()">Tutup</button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-500 font-semibold">Direktori UMKM</p>
                <h1 class="text-3xl font-semibold text-gray-900 mt-2">Daftar UMKM Terdaftar</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola profil, status, dan akses komunikasi setiap UMKM yang
                    terintegrasi di website desa.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.desa-management.umkm-management.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl hover:opacity-95 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah UMKM Baru
                </a>
                <button
                    class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                    Export Data
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <th class="px-6 py-3">Nama UMKM</th>
                            <th class="px-6 py-3">Pemilik</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3 text-center">Status Aktif</th>
                            <th class="px-6 py-3 text-center">Produk</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($umkmList as $umkm)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $umkm['name'] }}</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ $umkm['subdomain'] }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <p class="font-medium text-sm">{{ $umkm['owner'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $umkm['created_at'] }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600">
                                        {{ $umkm['category'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-semibold {{ $umkm['status_badge'] }}">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full {{ $umkm['status'] === 'active' ? 'bg-emerald-500' : ($umkm['status'] === 'onboarding' ? 'bg-sky-500' : ($umkm['status'] === 'suspended' ? 'bg-rose-500' : 'bg-gray-400')) }}"></span>
                                        {{ $umkm['status_label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-600 font-semibold">
                                    {{ $umkm['products'] }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2 flex-wrap">

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.desa-management.umkm-management.edit', $umkm['id']) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 3.487a2.25 2.25 0 0 1 3.182 3.182L8.25 18.463 4.5 19.5l1.037-3.75 11.325-12.263z" />
                                            </svg>
                                            <span class="sr-only">Edit</span>
                                        </a>

                                        {{-- Monitor --}}
                                        <a href="{{ route('admin.desa-management.umkm-management.monitoring') }}"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 text-slate-500 hover:bg-emerald-50 hover:text-emerald-600"
                                            title="Monitor">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 4.5h18M4.5 9h15l-2.25 10.5h-10.5L4.5 9zM9 13.5h1.5m3 0H15" />
                                            </svg>
                                            <span class="sr-only">Monitor</span>
                                        </a>

                                        {{-- Status: onboarding → aktifkan --}}
                                        @if ($umkm['status'] === 'onboarding')
                                            <form
                                                action="{{ route('admin.desa-management.umkm-management.update-status', $umkm['id']) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Aktifkan UMKM ini?')">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="status" value="active">
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-100"
                                                    title="Aktifkan">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9.75 21.75 3 12l6.75-9.75M15 4.5h6M15 9h6M15 13.5h6M15 18h6" />
                                                    </svg>
                                                    <span class="sr-only">Aktifkan</span>
                                                </button>
                                            </form>

                                            {{-- Status: active → suspend --}}
                                        @elseif($umkm['status'] === 'active')
                                            <form
                                                action="{{ route('admin.desa-management.umkm-management.update-status', $umkm['id']) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Suspend UMKM ini?')">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="status" value="suspended">
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-rose-50 text-rose-500 hover:bg-rose-100"
                                                    title="Suspend">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.75 5.25v13.5M17.25 5.25v13.5" />
                                                    </svg>
                                                    <span class="sr-only">Suspend</span>
                                                </button>
                                            </form>

                                            {{-- Status: suspended → aktifkan --}}
                                        @elseif($umkm['status'] === 'suspended')
                                            <form
                                                action="{{ route('admin.desa-management.umkm-management.update-status', $umkm['id']) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Aktifkan kembali UMKM ini?')">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="status" value="active">
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-100"
                                                    title="Aktifkan kembali">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 4.5v15m7.5-7.5h-15" />
                                                    </svg>
                                                    <span class="sr-only">Aktifkan kembali</span>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Tambah Produk --}}
                                        <button type="button"
                                            onclick="openAddProductModal({{ $umkm['id'] }}, '{{ $umkm['name'] }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100"
                                            title="Tambah Produk">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                            <span class="sr-only">Tambah Produk</span>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.admin-desa.umkm-management.partials.add-product-modal')
@endsection

@push('scripts')
    <script>
        function openAddProductModal(umkmId, umkmName) {
            document.getElementById('modalUmkmId').value = umkmId;
            document.getElementById('modalUmkmName').textContent = 'UMKM: ' + umkmName;
            document.getElementById('addProductModal').style.display = 'flex';
        }

        function closeAddProductModal() {
            document.getElementById('addProductModal').style.display = 'none';
            const form = document.getElementById('addProductModal').querySelector('form');
            if (form) form.reset();
        }
    </script>
@endpush
