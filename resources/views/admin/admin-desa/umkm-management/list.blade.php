@extends('layouts.admin')

@section('title', 'Daftar UMKM')

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-cloak>
    @if (session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
        <button class="text-xs text-emerald-600 hover:text-emerald-500" @click="$el.parentElement.remove()">Tutup</button>
    </div>
    @endif

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-emerald-500 font-semibold">Direktori UMKM</p>
            <h1 class="text-3xl font-semibold text-gray-900 mt-2">Daftar UMKM Terdaftar</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola profil, status, dan akses komunikasi setiap UMKM yang terintegrasi di website desa.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.desa-management.umkm-management.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl hover:opacity-95 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah UMKM Baru
            </a>
            <button class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
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
                    @foreach($umkmList as $umkm)
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
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600">
                                {{ $umkm['category'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-semibold {{ $umkm['status_badge'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $umkm['status'] === 'active' ? 'bg-emerald-500' : ($umkm['status'] === 'onboarding' ? 'bg-sky-500' : ($umkm['status'] === 'suspended' ? 'bg-rose-500' : 'bg-gray-400')) }}"></span>
                                {{ $umkm['status_label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-600 font-semibold">
                            {{ $umkm['products'] }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2 flex-wrap">
                                <a href="{{ route('admin.desa-management.umkm-management.monitoring') }}" class="text-xs font-semibold text-slate-400 hover:text-emerald-600">
                                    Monitor
                                </a>
                                @if($umkm['status'] === 'onboarding')
                                <form action="{{ route('admin.desa-management.umkm-management.update-status', $umkm['id']) }}" method="POST" class="inline" onsubmit="return confirm('Aktifkan UMKM ini?')">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                                        Aktifkan
                                    </button>
                                </form>
                                @elseif($umkm['status'] === 'active')
                                <form action="{{ route('admin.desa-management.umkm-management.update-status', $umkm['id']) }}" method="POST" class="inline" onsubmit="return confirm('Suspend UMKM ini?')">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="status" value="suspended">
                                    <button type="submit" class="text-xs font-semibold text-rose-500 hover:text-rose-600">
                                        Suspend
                                    </button>
                                </form>
                                @elseif($umkm['status'] === 'suspended')
                                <form action="{{ route('admin.desa-management.umkm-management.update-status', $umkm['id']) }}" method="POST" class="inline" onsubmit="return confirm('Aktifkan kembali UMKM ini?')">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                                        Aktifkan
                                    </button>
                                </form>
                                @endif
                                <button onclick="openAddProductModal({{ $umkm['id'] }}, '{{ $umkm['name'] }}')" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                                    Tambah Produk
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

