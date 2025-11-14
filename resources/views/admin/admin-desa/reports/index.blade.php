@extends('layouts.admin')

@section('title', 'Laporan & Statistik')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan & Statistik</h1>
                <p class="text-gray-600">Modul analitik untuk memantau aktivitas digital desa dan UMKM</p>
                @if($village)
                <div class="mt-3 flex items-center gap-2 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium text-gray-700">{{ $village->name }}</span>
                    @if($website)
                    <span class="text-gray-400">•</span>
                    <span>{{ $website->url ?? '-' }}</span>
                    @endif
                </div>
                @else
                <div class="mt-3">
                    <p class="text-sm text-amber-600 bg-amber-50 px-3 py-2 rounded-lg inline-block">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Data desa belum terhubung. Silakan hubungkan website desa terlebih dahulu.
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Statistik Pengunjung -->
        <a href="{{ route('admin.desa-management.reports.visitor-statistics') }}" class="bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Statistik Pengunjung</p>
                    <p class="text-2xl font-bold mt-1">Website Desa</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 0118 0 9 9 0 01-18 0zm9-3a3 3 0 100 6 3 3 0 000-6z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Grafik pengunjung website desa (harian, mingguan, bulanan)</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>

        <!-- Statistik UMKM -->
        <a href="{{ route('admin.desa-management.reports.umkm-statistics') }}" class="bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Statistik UMKM</p>
                    <p class="text-2xl font-bold mt-1">Produk & Aktivitas</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Grafik jumlah produk, aktivitas, dan kunjungan UMKM</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>

        <!-- Laporan Digitalisasi Desa -->
        <a href="{{ route('admin.desa-management.reports.digitalization-report') }}" class="bg-gradient-to-br from-orange-500 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Laporan Digitalisasi</p>
                    <p class="text-2xl font-bold mt-1">Data Ringkasan</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Data ringkasan kegiatan digital (bisa diunduh PDF/Excel)</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>

        <!-- Ranking UMKM Aktif -->
        <a href="{{ route('admin.desa-management.reports.umkm-ranking') }}" class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Ranking UMKM</p>
                    <p class="text-2xl font-bold mt-1">Paling Produktif</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">UMKM paling produktif berdasarkan update & trafik</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>
    </div>
</div>
@endsection

