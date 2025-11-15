@extends('layouts.admin')

@section('title', 'Laporan UMKM')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan UMKM</h1>
                <p class="text-gray-600">Fasilitas untuk mengunduh laporan bulanan UMKM</p>
                @if($umkmBusiness)
                <div class="mt-3 flex items-center gap-2 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="font-medium text-gray-700">{{ $umkmBusiness->name }}</span>
                    @if($umkmBusiness->subdomain)
                    <span class="text-gray-400">•</span>
                    <a href="https://{{ $umkmBusiness->subdomain }}" target="_blank" class="text-emerald-600 hover:text-emerald-500">
                        {{ $umkmBusiness->subdomain }}
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Total Produk</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summary['total_products']) }}</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Total Views</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summary['total_views']) }}</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Total Pengunjung</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summary['total_visitors']) }}</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 0118 0 9 9 0 01-18 0zm9-3a3 3 0 100 6 3 3 0 000-6z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Aktivitas 30 Hari</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summary['recent_activity']) }}</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Laporan Produk -->
        <a href="{{ route('admin.umkm.reports.product-reports', ['type' => 'most-viewed']) }}" class="bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Laporan Produk</p>
                    <p class="text-2xl font-bold mt-1">Produk Terpopuler</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Produk yang sering dilihat dan paling sering mendapat interaksi</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>

        <!-- Laporan Aktivitas -->
        <a href="{{ route('admin.umkm.reports.activity-reports') }}" class="bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Laporan Aktivitas</p>
                    <p class="text-2xl font-bold mt-1">Rekap Update Konten</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Rekap update konten UMKM (produk, profil, dll)</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>

        <!-- Export Laporan -->
        <div class="bg-gradient-to-br from-orange-500 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Export Laporan</p>
                    <p class="text-2xl font-bold mt-1">PDF / Excel</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Unduh laporan bulanan dalam format PDF atau Excel</p>
            <div class="flex items-center gap-2 mt-4">
                <a href="{{ route('admin.umkm.reports.export', ['format' => 'pdf', 'type' => 'monthly']) }}" class="flex-1 px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm font-medium transition text-center">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    PDF
                </a>
                <a href="{{ route('admin.umkm.reports.export', ['format' => 'excel', 'type' => 'monthly']) }}" class="flex-1 px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm font-medium transition text-center">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Excel
                </a>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>
    </div>
</div>
@endsection

