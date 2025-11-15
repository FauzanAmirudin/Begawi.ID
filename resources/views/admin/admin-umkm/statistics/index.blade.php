@extends('layouts.admin')

@section('title', 'Statistik & Analitik')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Statistik & Analitik</h1>
                <p class="text-gray-600">Modul analitik untuk memantau aktivitas kunjungan website UMKM</p>
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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Statistik Pengunjung -->
        <a href="{{ route('admin.umkm.statistics.visitor-statistics') }}" class="bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Statistik Pengunjung</p>
                    <p class="text-2xl font-bold mt-1">Website UMKM</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 0118 0 9 9 0 01-18 0zm9-3a3 3 0 100 6 3 3 0 000-6z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Grafik pengunjung website UMKM (harian, mingguan, bulanan)</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>

        <!-- Produk Terpopuler -->
        <a href="{{ route('admin.umkm.statistics.popular-products') }}" class="bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Produk Terpopuler</p>
                    <p class="text-2xl font-bold mt-1">Berdasarkan Tampilan</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Daftar produk paling banyak dilihat berdasarkan jumlah tampilan</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>

        <!-- Sumber Pengunjung -->
        <a href="{{ route('admin.umkm.statistics.visitor-sources') }}" class="bg-gradient-to-br from-orange-500 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Sumber Pengunjung</p>
                    <p class="text-2xl font-bold mt-1">Traffic Sources</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Traffic dari sosial media, mesin pencari, dan sumber lainnya</p>
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

