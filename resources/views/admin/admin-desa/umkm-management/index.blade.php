@extends('layouts.admin')

@section('title', 'Dashboard UMKM')

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-8" x-cloak>
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
                <a href="{{ route('admin.desa-management.umkm-management.create') }}" class="inline-flex items-center justify-center gap-2 bg-white text-gray-900 font-semibold px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition">
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

    <!-- Quick Navigation -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.desa-management.umkm-management.list') }}" class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 hover:border-emerald-200 hover:shadow-md transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Daftar UMKM</h3>
                    <p class="text-xs text-gray-500 mt-1">Kelola direktori UMKM</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.desa-management.umkm-management.monitoring') }}" class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 hover:border-purple-200 hover:shadow-md transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center group-hover:bg-purple-500 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Monitoring</h3>
                    <p class="text-xs text-gray-500 mt-1">Insight performansi</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.desa-management.umkm-management.validation') }}" class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 hover:border-amber-200 hover:shadow-md transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Validasi Konten</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $pendingValidations }} menunggu</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.desa-management.umkm-management.guides') }}" class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 hover:border-blue-200 hover:shadow-md transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Bimbingan Digital</h3>
                    <p class="text-xs text-gray-500 mt-1">Materi pendampingan</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900">UMKM Terbaru</h3>
                <a href="{{ route('admin.desa-management.umkm-management.list') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-500">
                    Lihat Semua
                </a>
            </div>
            <div class="space-y-3">
                @foreach($recentUmkm->take(5) as $umkm)
                <div class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/30 transition">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-900">{{ $umkm['name'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $umkm['owner'] }} · {{ $umkm['category'] }}</p>
                    </div>
                    <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $umkm['status_badge'] }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $umkm['status'] === 'active' ? 'bg-emerald-500' : ($umkm['status'] === 'onboarding' ? 'bg-sky-500' : 'bg-gray-400') }}"></span>
                        {{ $umkm['status_label'] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900">Pesan Terbaru</h3>
                <a href="{{ route('admin.desa-management.umkm-management.validation') }}" class="text-xs font-semibold text-amber-600 hover:text-amber-500">
                    Lihat Semua
                </a>
            </div>
            <div class="space-y-3">
                @foreach($latestMessages->take(5) as $message)
                <div class="p-3 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50/30 transition">
                    <p class="text-sm font-semibold text-gray-900">{{ $message['umkm'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $message['excerpt'] }}</p>
                    <p class="text-[11px] text-gray-400 mt-2">{{ $message['time'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

