@extends('layouts.admin')

@section('title', 'Manajemen UMKM Desa')

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-8" x-data="umkmPanel()" x-cloak>
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
    <div class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 rounded-3xl p-8 text-white shadow-lg">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold uppercase tracking-wide">
                    Manajemen UMKM Desa
                </div>
                <h1 class="text-3xl lg:text-4xl font-semibold mt-4">Panel Pengelolaan UMKM Desa {{ $village->name ?? 'Sejahtera' }}</h1>
                <p class="text-white/70 mt-3 max-w-3xl">
                    Monitor seluruh aktivitas UMKM desa, validasi konten baru, dan berikan bimbingan digital terintegrasi.
                    Semua data tersinkron dengan halaman publik <strong>Begawi.ID</strong> dan subdomain UMKM desa.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('desa.umkm.index') }}" target="_blank"
                   class="inline-flex items-center justify-center gap-2 bg-white/15 hover:bg-white/25 text-white font-semibold px-5 py-3 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Lihat Direktori UMKM
                </a>
                <a href="#tambah-umkm-baru" class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 font-semibold px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Daftar UMKM Baru
                </a>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach($overviewCards as $card)
            <div class="bg-gradient-to-br {{ $card['gradient'] }} rounded-2xl p-6 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/70 text-xs font-semibold uppercase tracking-wide">{{ $card['label'] }}</p>
                        <p class="text-3xl font-semibold mt-2">{{ $card['value'] }}</p>
                        <p class="text-white/60 text-xs mt-2">{{ $card['description'] }}</p>
                    </div>
                    <div class="bg-white/15 rounded-xl p-3">
                        @include('admin.dashboard.partials.icon', ['type' => $card['icon']])
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between text-xs text-white/80">
                    <a href="{{ $card['link'] }}" class="inline-flex items-center gap-2 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        {{ $card['link_label'] }}
                    </a>
                    @if(isset($card['badge']))
                    <span class="inline-flex items-center gap-1 bg-white/15 px-2.5 py-1 rounded-full text-[11px] font-semibold">
                        {{ $card['badge']['label'] }}
                        <span class="text-white/70 font-medium">{{ $card['badge']['text'] }}</span>
                    </span>
                    @endif
                </div>
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full"></div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Section Navigation -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl px-6 py-4 flex flex-wrap gap-3">
        <a href="#daftar-umkm" class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 transition">
            Daftar UMKM
        </a>
        <a href="#tambah-umkm-baru" class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 transition">
            Tambah UMKM Baru
        </a>
        <a href="#monitoring-aktivitas" class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 transition">
            Monitoring Aktivitas
        </a>
        <a href="#validasi-konten" class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 transition">
            Validasi Konten
        </a>
        <a href="#bimbingan-digital" class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 transition">
            Bimbingan Digital
        </a>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="flex-1 space-y-8">
            <!-- Daftar UMKM -->
            <section id="daftar-umkm" class="space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-emerald-500 font-semibold">01 · Direktori UMKM</p>
                        <h2 class="text-2xl font-semibold text-gray-900 mt-2">Daftar UMKM Terdaftar</h2>
                        <p class="text-sm text-gray-500 mt-1">Kelola profil, status, dan akses komunikasi setiap UMKM yang terintegrasi di website desa.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                            Export Data
                        </button>
                    </div>
                </div>

                {{-- <div class="flex flex-wrap gap-2">
                    @foreach($categoryFilters as $category)
                    <span class="px-3 py-1 text-xs font-medium rounded-full border border-gray-200 text-gray-600">
                        {{ $category }}
                    </span>
                    @endforeach
                </div> --}}

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
                                            <a href="#monitoring-aktivitas" class="text-xs font-semibold text-slate-400 hover:text-emerald-600">
                                                Monitor
                                            </a>
                                            @if($umkm['status'] === 'onboarding')
                                            <form action="{{ route('admin.desa-management.umkm.update-status', $umkm['id']) }}" method="POST" class="inline" onsubmit="return confirm('Aktifkan UMKM ini?')">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="status" value="active">
                                                <button type="submit" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                                                    Aktifkan
                                                </button>
                                            </form>
                                            @elseif($umkm['status'] === 'active')
                                            <form action="{{ route('admin.desa-management.umkm.update-status', $umkm['id']) }}" method="POST" class="inline" onsubmit="return confirm('Suspend UMKM ini?')">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="status" value="suspended">
                                                <button type="submit" class="text-xs font-semibold text-rose-500 hover:text-rose-600">
                                                    Suspend
                                                </button>
                                            </form>
                                            @elseif($umkm['status'] === 'suspended')
                                            <form action="{{ route('admin.desa-management.umkm.update-status', $umkm['id']) }}" method="POST" class="inline" onsubmit="return confirm('Aktifkan kembali UMKM ini?')">
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
            </section>

            <!-- Tambah UMKM Baru -->
            <section id="tambah-umkm-baru" class="space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 font-semibold">02 · Registrasi UMKM</p>
                        <h2 class="text-2xl font-semibold text-gray-900 mt-2">Tambah UMKM Baru</h2>
                        <p class="text-sm text-gray-500 mt-1">Lengkapi data usaha untuk otomatis membuat subdomain dan akses panel admin UMKM.</p>
                    </div>
                    <div class="text-xs text-gray-400">
                        Subdomain default: <span class="font-semibold text-gray-600" x-text="subdomainPreview"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <form action="{{ route('admin.desa-management.umkm.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
                            @csrf
                            
                            <!-- Section 1: Informasi Dasar -->
                            <div class="p-6 space-y-6">
                                <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-900">Informasi Dasar UMKM</h3>
                                        <p class="text-xs text-gray-500 mt-0.5">Data identitas dan kontak utama</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            Nama UMKM
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="name" value="{{ old('name') }}" required 
                                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200" 
                                            placeholder="Contoh: UD Berkah Jaya" />
                                        @error('name')
                                        <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 5c-4.418 0-8 2.239-8 5v1a1 1 0 001 1h14a1 1 0 001-1v-1c0-2.761-3.582-5-8-5z"></path>
                                            </svg>
                                            Pemilik / PIC
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="owner_name" value="{{ old('owner_name') }}" required 
                                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200" 
                                            placeholder="Nama lengkap pemilik" />
                                        @error('owner_name')
                                        <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Kategori UMKM
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <select name="category" required 
                                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200">
                                            <option value="">Pilih kategori</option>
                                            @foreach($categoryFilters as $category)
                                            <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                        <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.494a1 1 0 01-.502 1.21l-1.518.76a11.042 11.042 0 006.105 6.105l.76-1.518a1 1 0 011.21-.502l4.494 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            WhatsApp Aktif
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="owner_phone" value="{{ old('owner_phone') }}" required 
                                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200" 
                                            placeholder="08xxxxxxxxxx" />
                                        @error('owner_phone')
                                        <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            Email Login
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" name="owner_email" value="{{ old('owner_email') }}" required 
                                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200" 
                                            placeholder="admin@umkm.com" />
                                        @error('owner_email')
                                        <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                            </svg>
                                            Subdomain
                                        </label>
                                        <div class="px-4 py-3 rounded-xl border-2 border-dashed border-emerald-300 bg-gradient-to-br from-emerald-50 to-teal-50 text-sm font-semibold text-emerald-700 flex items-center gap-2" x-text="subdomainPreview">
                                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Subdomain akan dibuat otomatis berdasarkan nama UMKM</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section 2: Deskripsi -->
                            <div class="p-6 space-y-4 bg-gray-50/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-900">Deskripsi Usaha</h3>
                                        <p class="text-xs text-gray-500 mt-0.5">Ceritakan profil singkat UMKM Anda</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <textarea name="description" rows="4" 
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200 resize-none" 
                                        placeholder="Ceritakan profil singkat UMKM, produk unggulan, atau prestasi yang telah dicapai...">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Section 3: Upload Dokumen -->
                            <div class="p-6 space-y-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-900">Dokumen & Media</h3>
                                        <p class="text-xs text-gray-500 mt-0.5">Upload logo dan dokumen legalitas</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="space-y-3">
                                        <label class="block text-sm font-semibold text-gray-700">
                                            Logo / Foto UMKM
                                        </label>
                                        <div class="relative">
                                            <input type="file" name="logo" id="logoInput" accept="image/*" 
                                                class="hidden" 
                                                onchange="document.getElementById('logoPreview').textContent = this.files[0]?.name || 'Pilih file...'">
                                            <label for="logoInput" 
                                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:border-emerald-400 hover:bg-emerald-50/30 cursor-pointer transition-all duration-200 group">
                                                <svg class="w-8 h-8 text-gray-400 group-hover:text-emerald-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="text-sm font-medium text-gray-600 group-hover:text-emerald-600" id="logoPreview">Klik untuk upload logo</p>
                                                <p class="text-xs text-gray-400 mt-1">JPG, PNG · Max 2MB</p>
                                            </label>
                                        </div>
                                        @error('logo')
                                        <div class="flex items-center gap-2 text-xs text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <label class="block text-sm font-semibold text-gray-700">
                                            Dokumen Legalitas <span class="text-gray-400 font-normal">(opsional)</span>
                                        </label>
                                        <div class="relative">
                                            <input type="file" name="legal_document" id="legalInput" accept=".pdf,.jpg,.png" 
                                                class="hidden" 
                                                onchange="document.getElementById('legalPreview').textContent = this.files[0]?.name || 'Pilih file...'">
                                            <label for="legalInput" 
                                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:border-emerald-400 hover:bg-emerald-50/30 cursor-pointer transition-all duration-200 group">
                                                <svg class="w-8 h-8 text-gray-400 group-hover:text-emerald-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <p class="text-sm font-medium text-gray-600 group-hover:text-emerald-600" id="legalPreview">Klik untuk upload dokumen</p>
                                                <p class="text-xs text-gray-400 mt-1">PDF, JPG, PNG · Max 5MB</p>
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">SIUP / NIB / Sertifikat Halal</p>
                                        @error('legal_document')
                                        <div class="flex items-center gap-2 text-xs text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section 4: Action Footer -->
                            <div class="p-6 bg-gradient-to-r from-gray-50 to-emerald-50/30 border-t-2 border-emerald-100">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="send_credentials" id="sendCredentials" value="1" 
                                            class="mt-1 w-5 h-5 rounded border-2 border-gray-300 text-emerald-600 focus:ring-2 focus:ring-emerald-500/20 transition-all" 
                                            {{ old('send_credentials', true) ? 'checked' : '' }}>
                                        <div class="flex-1">
                                            <span class="block text-sm font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">
                                                Kirim Kredensial Otomatis
                                            </span>
                                            <span class="block text-xs text-gray-500 mt-1">
                                                Kredensial panel admin UMKM akan dikirim via email & WhatsApp setelah pendaftaran
                                            </span>
                                        </div>
                                    </label>
                                    <button type="submit" 
                                        class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:shadow-emerald-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Simpan & Buat Subdomain
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Alur Onboarding</h4>
                            <ol class="mt-4 space-y-3 text-sm text-gray-600">
                                <li class="flex gap-3">
                                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-semibold">1</span>
                                    <div>
                                        <p class="font-semibold text-gray-900">Validasi Dokumen</p>
                                        <p class="text-xs text-gray-500 mt-1">Pastikan data pemilik dan dokumen usaha lengkap untuk aktivasi.</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-semibold">2</span>
                                    <div>
                                        <p class="font-semibold text-gray-900">Konfigurasi Subdomain</p>
                                        <p class="text-xs text-gray-500 mt-1">Subdomain otomatis dibuat di platform Begawi.ID tanpa konfigurasi manual.</p>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-semibold">3</span>
                                    <div>
                                        <p class="font-semibold text-gray-900">Training Admin UMKM</p>
                                        <p class="text-xs text-gray-500 mt-1">Sediakan jadwal bimbingan onboarding agar admin UMKM siap mempublikasi konten.</p>
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="bg-gradient-to-br from-sky-500 via-blue-500 to-indigo-500 rounded-2xl p-6 text-white">
                            <h4 class="text-base font-semibold">Gunakan Template UMKM</h4>
                            <p class="text-sm text-white/80 mt-2">Aktifkan template e-commerce siap pakai untuk UMKM baru agar cepat go-digital.</p>
                            <a href="#bimbingan-digital" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/80 transition">
                                Lihat panduan implementasi
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Monitoring Aktivitas -->
            <section id="monitoring-aktivitas" class="space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">03 · Monitoring Aktivitas</p>
                        <h2 class="text-2xl font-semibold text-gray-900 mt-2">Insight Performansi UMKM</h2>
                        <p class="text-sm text-gray-500 mt-1">Pantau tren kunjungan, produk aktif, dan performa penjualan secara real-time.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-3 py-1 rounded-full">
                            Periode: 6 Bulan Terakhir
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($monitoringSummary as $summary)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ $summary['label'] }}</p>
                        <p class="text-2xl font-semibold text-gray-900 mt-2">{{ $summary['value'] }}</p>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $summary['badge'] }} mt-3">
                            {{ $summary['delta'] }}
                        </span>
                    </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                    <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Grafik Kunjungan & Konversi</h3>
                                <p class="text-xs text-gray-500 mt-1">Insight performa rata-rata seluruh UMKM</p>
                            </div>
                            <div class="flex items-center gap-3 text-xs text-gray-400">
                                <span class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span> Kunjungan
                                </span>
                                <span class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-indigo-500"></span> Konversi (%)
                                </span>
                            </div>
                        </div>
                        <div class="relative h-72">
                            <canvas id="umkmVisitChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h3 class="text-base font-semibold text-gray-900">Performa UMKM</h3>
                        <p class="text-xs text-gray-500 mt-1">Tiga UMKM dengan pertumbuhan tertinggi</p>
                        <div class="mt-4 space-y-4">
                            @foreach($monitoringDetails->take(3) as $detail)
                            <div class="p-4 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50/40 transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $detail['name'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $detail['subdomain'] }}</p>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $detail['status_badge'] }}">
                                        {{ $detail['status_label'] }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-3 gap-3 text-xs text-gray-500 mt-3">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $detail['products'] }}</p>
                                        <p>Produk</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ number_format($detail['visits']) }}</p>
                                        <p>Kunjungan</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $detail['conversion'] }}%</p>
                                        <p>Konversi</p>
                                    </div>
                                </div>
                                <p class="text-[11px] text-gray-400 mt-3">Update {{ $detail['last_update'] }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-gray-900">Ringkasan Aktivitas</h3>
                        <a href="#validasi-konten" class="text-xs font-semibold text-purple-600 hover:text-purple-500">
                            Lihat Validasi Konten
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-xs text-gray-400 uppercase tracking-wide">
                                <tr>
                                    <th class="py-2 text-left">UMKM</th>
                                    <th class="py-2 text-center">Produk Aktif</th>
                                    <th class="py-2 text-center">Kunjungan</th>
                                    <th class="py-2 text-center">Pesanan</th>
                                    <th class="py-2 text-center">Konversi</th>
                                    <th class="py-2 text-right">Update Terakhir</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                @foreach($monitoringDetails as $detail)
                                <tr class="border-t border-gray-50">
                                    <td class="py-3 pr-4">
                                        <div class="font-semibold text-gray-900">{{ $detail['name'] }}</div>
                                        <div class="text-xs text-gray-400">{{ $detail['subdomain'] }}</div>
                                    </td>
                                    <td class="py-3 text-center font-semibold">{{ $detail['products'] }}</td>
                                    <td class="py-3 text-center">{{ number_format($detail['visits']) }}</td>
                                    <td class="py-3 text-center">{{ number_format($detail['orders']) }}</td>
                                    <td class="py-3 text-center">{{ $detail['conversion'] }}%</td>
                                    <td class="py-3 text-right text-xs text-gray-400">{{ $detail['last_update'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Validasi Konten -->
            <section id="validasi-konten" class="space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-amber-500 font-semibold">04 · Validasi Konten UMKM</p>
                        <h2 class="text-2xl font-semibold text-gray-900 mt-2">Tinjau Pengajuan Konten</h2>
                        <p class="text-sm text-gray-500 mt-1">Setujui atau tolak produk, foto, dan promosi yang diajukan oleh admin UMKM.</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold bg-amber-50 text-amber-600 rounded-full">
                        {{ $validationQueue->count() }} Konten Menunggu
                    </span>
                </div>

                <div class="space-y-4">
                    @php
                        $statusStyles = [
                            'review' => 'bg-sky-50 text-sky-600',
                            'verification' => 'bg-purple-50 text-purple-600',
                            'draft' => 'bg-gray-100 text-gray-600',
                        ];
                    @endphp
                    @foreach($validationQueue as $item)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:border-amber-200 transition">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <span class="text-xs font-semibold text-amber-500 uppercase tracking-wide">{{ $item['type'] }}</span>
                                <h3 class="text-base font-semibold text-gray-900 mt-1">{{ $item['umkm'] }}</h3>
                                <p class="text-xs text-gray-400 mt-1">{{ $item['submitted_by'] }}</p>
                            </div>
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-semibold {{ $statusStyles[$item['status']] ?? 'bg-gray-100 text-gray-600' }}">
                                Status: {{ ucfirst($item['status']) }}
                            </span>
                        </div>
                        <ul class="mt-4 space-y-2 text-sm text-gray-600">
                            @foreach($item['items'] as $detail)
                            <li class="flex items-start gap-2">
                                <span class="mt-1 w-2 h-2 rounded-full bg-amber-400"></span>
                                <span>{{ $detail }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="mt-5 flex flex-wrap gap-3">
                            <form action="{{ route('admin.desa-management.umkm.content.approve', $item['id']) }}" method="POST" class="inline" onsubmit="return confirm('Setujui konten ini? Konten akan langsung muncul di website desa.')">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl hover:opacity-95 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Setujui Konten
                                </button>
                            </form>
                            <button onclick="openRejectModal({{ $item['id'] }})" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-rose-500 bg-rose-50 rounded-xl hover:bg-rose-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tolak & Beri Catatan
                            </button>
                            <button onclick="openRevisionModal({{ $item['id'] }})" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-amber-600 bg-amber-50 rounded-xl hover:bg-amber-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Minta Revisi
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- Bimbingan Digital -->
            <section id="bimbingan-digital" class="space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-blue-500 font-semibold">05 · Bimbingan Digital</p>
                        <h2 class="text-2xl font-semibold text-gray-900 mt-2">Materi Pendampingan UMKM</h2>
                        <p class="text-sm text-gray-500 mt-1">Upload artikel, tips promosi, dan jadwal pelatihan untuk UMKM binaan.</p>
                    </div>
                    <a href="#tambah-umkm-baru" class="px-4 py-2 text-xs font-semibold text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition">
                        Kirim Materi via Email
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-base font-semibold text-gray-900">Perpustakaan Materi</h3>
                                <button class="text-xs font-semibold text-gray-500 hover:text-blue-500">Kelola Folder</button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($digitalGuides as $guide)
                                <div class="p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition">
                                    <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-semibold bg-blue-50 text-blue-600 rounded-full">
                                        {{ $guide['category'] }}
                                    </span>
                                    <h4 class="text-sm font-semibold text-gray-900 mt-3 leading-snug">{{ $guide['title'] }}</h4>
                                    <p class="text-xs text-gray-500 mt-2">{{ $guide['duration'] }}</p>
                                    <p class="text-[11px] text-gray-400 mt-1">Update {{ $guide['updated_at'] }}</p>
                                    <a href="{{ $guide['link'] }}" class="mt-3 inline-flex items-center gap-2 text-xs font-semibold text-blue-600 hover:text-blue-500 transition">
                                        Buka Materi
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-900">Upload Materi Bimbingan</h3>
                                        <p class="text-xs text-gray-500 mt-0.5">Materi akan tersedia di panel UMKM dan dapat dikirim via email otomatis</p>
                                    </div>
                                </div>
                            </div>
                            
                            <form action="{{ route('admin.desa-management.umkm.guides.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                                @csrf
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Judul Materi
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="title" value="{{ old('title') }}" required 
                                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" 
                                            placeholder="Contoh: Optimasi Foto Produk">
                                        @error('title')
                                        <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Kategori
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <select name="category" required 
                                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all duration-200">
                                            <option value="">Pilih kategori</option>
                                            <option value="tips" {{ old('category') === 'tips' ? 'selected' : '' }}>Tips Promosi</option>
                                            <option value="pelatihan" {{ old('category') === 'pelatihan' ? 'selected' : '' }}>Pelatihan Online</option>
                                            <option value="artikel" {{ old('category') === 'artikel' ? 'selected' : '' }}>Artikel Edukasi</option>
                                        </select>
                                        @error('category')
                                        <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                        </svg>
                                        Deskripsi Singkat
                                    </label>
                                    <textarea name="description" rows="3" 
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 resize-none" 
                                        placeholder="Tuliskan ringkasan materi dan tujuan bimbingan...">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="space-y-3">
                                        <label class="block text-sm font-semibold text-gray-700">
                                            Upload File
                                        </label>
                                        <div class="relative">
                                            <input type="file" name="file" id="guideFileInput" accept=".pdf,.ppt,.pptx,.zip,.mp4" 
                                                class="hidden" 
                                                onchange="document.getElementById('guideFilePreview').textContent = this.files[0]?.name || 'Pilih file...'">
                                            <label for="guideFileInput" 
                                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:border-blue-400 hover:bg-blue-50/30 cursor-pointer transition-all duration-200 group">
                                                <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                </svg>
                                                <p class="text-sm font-medium text-gray-600 group-hover:text-blue-600" id="guideFilePreview">Klik untuk upload file</p>
                                                <p class="text-xs text-gray-400 mt-1">PDF, PPT, ZIP, MP4 · Max 20MB</p>
                                            </label>
                                        </div>
                                        @error('file')
                                        <div class="flex items-center gap-2 text-xs text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                            Link Pelatihan <span class="text-gray-400 font-normal">(opsional)</span>
                                        </label>
                                        <input type="url" name="external_link" value="{{ old('external_link') }}" 
                                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" 
                                            placeholder="https://zoom.us/...">
                                        @error('external_link')
                                        <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-100">
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="notify_all_umkm" value="1" 
                                            class="mt-1 w-5 h-5 rounded border-2 border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all" 
                                            {{ old('notify_all_umkm', true) ? 'checked' : '' }}>
                                        <div class="flex-1">
                                            <span class="block text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                                Kirim Notifikasi ke Semua UMKM
                                            </span>
                                            <span class="block text-xs text-gray-500 mt-1">
                                                Semua admin UMKM akan menerima notifikasi tentang materi baru ini
                                            </span>
                                        </div>
                                    </label>
                                    <button type="submit" 
                                        class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-500 text-white text-sm font-semibold shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Terbitkan Materi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Pelatihan Terdekat</h4>
                            <div class="mt-4 space-y-4">
                                @foreach($upcomingTrainings as $training)
                                <div class="p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition">
                                    <p class="text-xs font-semibold text-blue-500 uppercase tracking-wide">{{ $training['status'] }}</p>
                                    <h5 class="text-sm font-semibold text-gray-900 mt-1">{{ $training['title'] }}</h5>
                                    <p class="text-xs text-gray-500 mt-2">{{ $training['date'] }} · {{ $training['time'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $training['medium'] }}</p>
                                    <button class="mt-3 text-xs font-semibold text-blue-600 hover:text-blue-500">Bagikan ke UMKM</button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-500 rounded-2xl p-6 text-white">
                            <h4 class="text-base font-semibold">Buat Rencana Pendampingan</h4>
                            <p class="text-sm text-white/80 mt-2">Gunakan template monitoring untuk mencatat progres tiap UMKM secara berkala.</p>
                            <a href="{{ route('admin.support.documentation') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/80 transition">
                                Lihat Template Monitoring
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Sidebar -->
        <aside class="w-full lg:w-80 space-y-6">
            <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-6 text-white shadow-lg border border-gray-800">
                <h3 class="text-lg font-semibold mb-4">Tindakan Cepat</h3>
                <div class="space-y-4">
                    @foreach($quickActions as $action)
                    <a href="{{ $action['link'] }}" class="block rounded-xl bg-gradient-to-r {{ $action['color'] }} p-4 hover:opacity-95 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/15 rounded-lg flex items-center justify-center">
                                @include('admin.dashboard.partials.icon', ['type' => $action['icon']])
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">{{ $action['label'] }}</p>
                                <p class="text-xs text-white/70 mt-1">{{ $action['description'] }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold text-gray-800">Pesan Terbaru</h3>
                    <span class="px-3 py-1 text-xs font-semibold bg-purple-50 text-purple-600 rounded-full">Inbox</span>
                </div>
                <div class="mt-4 space-y-3">
                    @foreach($latestMessages as $message)
                    <div class="p-4 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50/50 transition">
                        <p class="text-sm font-semibold text-gray-900">{{ $message['umkm'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $message['excerpt'] }}</p>
                        <p class="text-[11px] text-gray-400 mt-2">{{ $message['time'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-800">Butuh Bantuan?</h3>
                <p class="text-sm text-gray-500 mt-2">Hubungi tim support Begawi.ID jika membutuhkan bantuan teknis untuk UMKM.</p>
                <div class="mt-4 space-y-3 text-sm text-gray-600">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            @include('admin.dashboard.partials.icon', ['type' => 'phone'])
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Live Support</p>
                            <p class="text-xs text-gray-500">Senin - Jumat · 08:00 - 17:00</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            @include('admin.dashboard.partials.icon', ['type' => 'mail'])
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">support@begawi.id</p>
                            <p class="text-xs text-gray-500">Respons maksimal 1x24 jam</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.support.contact') }}" class="mt-4 inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl hover:opacity-95 transition">
                    Hubungi Support
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-800">Status Domain UMKM</h3>
                <p class="text-sm text-gray-500 mt-2">Semua subdomain UMKM menggunakan suffix <span class="font-semibold text-gray-900">.{{ $domainSuffix }}</span>.</p>
                <div class="mt-4 space-y-2 text-xs text-gray-500">
                    <p>✓ SSL otomatis aktif</p>
                    <p>✓ Dukungan custom domain</p>
                    <p>✓ Integrasi template UMKM</p>
                </div>
            </div>
        </aside>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div id="addProductModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center" style="display: none;" onclick="if(event.target === this) closeAddProductModal()">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-900">Tambah Produk UMKM</h3>
                <button onclick="closeAddProductModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-gray-500 mt-1" id="modalUmkmName"></p>
        </div>
        <form action="{{ route('admin.desa-management.umkm.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="umkm_business_id" id="modalUmkmId">
            
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="title" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="Contoh: Keripik Singkong Renyah">
            </div>
            
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Deskripsi Produk</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all resize-none" placeholder="Deskripsi lengkap produk..."></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Harga <span class="text-red-500">*</span></label>
                    <input type="number" name="price" required min="0" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="15000">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Stok</label>
                    <input type="number" name="stock" min="0" value="0" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="25">
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Rating</label>
                    <input type="number" name="rating" min="0" max="5" step="0.1" value="4.5" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="4.5">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Berat</label>
                    <input type="text" name="weight" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="250gr">
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Foto Produk <span class="text-red-500">*</span></label>
                <input type="file" name="image" accept="image/*" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all">
                <p class="text-xs text-gray-500 mt-1">Format JPG/PNG, maksimal 2MB</p>
            </div>
            
            <div class="flex items-center gap-3 p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                <input type="checkbox" name="auto_approve" id="autoApprove" value="1" checked class="w-5 h-5 rounded border-2 border-gray-300 text-emerald-600 focus:ring-2 focus:ring-emerald-500/20">
                <label for="autoApprove" class="text-sm text-gray-700 cursor-pointer">
                    <span class="font-semibold">Setujui otomatis</span> - Produk akan langsung muncul di website desa tanpa perlu validasi ulang
                </label>
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeAddProductModal()" class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold hover:opacity-95 transition">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reject -->
<div id="rejectModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center" style="display: none;" onclick="if(event.target === this) closeRejectModal()">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">Tolak Konten</h3>
            <p class="text-sm text-gray-500 mt-1">Berikan alasan penolakan konten ini</p>
        </div>
        <form id="rejectForm" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                <textarea name="rejection_reason" required rows="4" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-rose-500 focus:bg-white focus:ring-2 focus:ring-rose-500/20 transition-all resize-none" placeholder="Contoh: Foto produk tidak jelas, deskripsi kurang lengkap, dll."></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 rounded-xl bg-gradient-to-r from-rose-500 to-red-500 text-white font-semibold hover:opacity-95 transition">
                    Tolak Konten
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Revision -->
<div id="revisionModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center" style="display: none;" onclick="if(event.target === this) closeRevisionModal()">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">Minta Revisi</h3>
            <p class="text-sm text-gray-500 mt-1">Berikan catatan revisi untuk konten ini</p>
        </div>
        <form id="revisionForm" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Revisi <span class="text-red-500">*</span></label>
                <textarea name="revision_notes" required rows="4" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-amber-500 focus:bg-white focus:ring-2 focus:ring-amber-500/20 transition-all resize-none" placeholder="Contoh: Mohon perbaiki kualitas foto, lengkapi deskripsi produk, tambahkan informasi stok, dll."></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeRevisionModal()" class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold hover:opacity-95 transition">
                    Kirim Permintaan Revisi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function umkmPanel() {
    return {
        domainSuffix: @json($domainSuffix),
        newUmkm: {
            name: '',
            owner: '',
            category: '',
            whatsapp: '',
            email: '',
            description: ''
        },
        get subdomainPreview() {
            const slugified = this.newUmkm.name
                ? this.newUmkm.name.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')
                : 'umkm-baru';
            return `${slugified || 'umkm-baru'}.${this.domainSuffix}`;
        }
    };
}

// Modal functions
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

function openRejectModal(validationId) {
    const form = document.getElementById('rejectForm');
    form.action = '{{ route("admin.desa-management.umkm.content.reject", ":id") }}'.replace(':id', validationId);
    document.getElementById('rejectModal').style.display = 'flex';
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
    document.getElementById('rejectForm').reset();
}

function openRevisionModal(validationId) {
    const form = document.getElementById('revisionForm');
    form.action = '{{ route("admin.desa-management.umkm.content.revision", ":id") }}'.replace(':id', validationId);
    document.getElementById('revisionModal').style.display = 'flex';
}

function closeRevisionModal() {
    document.getElementById('revisionModal').style.display = 'none';
    document.getElementById('revisionForm').reset();
}

document.addEventListener('DOMContentLoaded', () => {
    const chartElement = document.getElementById('umkmVisitChart');
    if (!chartElement) return;

    const visits = @json($chart['visits']);
    const conversion = @json($chart['conversion']);

    new Chart(chartElement.getContext('2d'), {
        type: 'line',
        data: {
            labels: visits.labels,
            datasets: [
                {
                    label: 'Kunjungan',
                    data: visits.dataset,
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16,185,129,0.12)',
                    tension: 0.35,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#10B981',
                    yAxisID: 'y'
                },
                {
                    label: 'Konversi (%)',
                    data: conversion.dataset,
                    borderColor: '#6366F1',
                    backgroundColor: 'rgba(99,102,241,0.12)',
                    tension: 0.35,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#6366F1',
                    yAxisID: 'y1'
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            stacked: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#111827',
                    displayColors: true,
                    callbacks: {
                        label: context => {
                            if (context.dataset.label.includes('Konversi')) {
                                return ` ${context.dataset.label}: ${context.parsed.y}%`;
                            }
                            return ` ${context.dataset.label}: ${context.parsed.y.toLocaleString('id-ID')} kunjungan`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    grid: { color: 'rgba(156,163,175,0.2)', borderDash: [4, 4] },
                    ticks: { color: '#9CA3AF', font: { size: 11 } },
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: { color: '#9CA3AF', font: { size: 11 }, callback: value => `${value}%` },
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#9CA3AF', font: { size: 11 } },
                }
            }
        }
    });
});
</script>
@endsection

