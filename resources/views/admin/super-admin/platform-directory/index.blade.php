@extends('layouts.admin')

@section('title', 'Direktori Platform')

@section('content')
<div class="p-6">
    <div class="flex gap-6">
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                @foreach($statsOverview as $card)
                <div class="bg-gradient-to-br {{ $card['gradient'] }} rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-white/80 text-sm font-medium">{{ $card['label'] }}</p>
                            <p class="text-3xl font-bold mt-2">{{ $card['value'] }}</p>
                            <p class="text-white/70 text-xs mt-3">{{ $card['description'] }}</p>
                        </div>
                        <div class="bg-white/15 rounded-xl p-3">
                            @if($card['icon'] === 'grid')
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            @elseif($card['icon'] === 'globe')
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 002-2V7a2 2 0 012-2h1m4 0h1a2 2 0 012 2v2a2 2 0 002 2h1.945M15 21h-2a2 2 0 01-2-2v-2a2 2 0 00-2-2H7m-4 0h1a2 2 0 002-2v-2a2 2 0 012-2h2"></path>
                                </svg>
                            @elseif($card['icon'] === 'storefront')
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.571 4H7.429a1 1 0 00-.929.604L5 9zM9 13h6"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 1010 10A10.029 10.029 0 0012 2z"></path>
                                </svg>
                            @endif
                        </div>
                    </div>
                    <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-white/10 rounded-full"></div>
                </div>
                @endforeach
            </div>

            <!-- Global Filters -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 mb-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Filter Direktori</h3>
                        <p class="text-sm text-gray-500">Sesuaikan status dan pencarian untuk mempercepat navigasi tenant.</p>
                    </div>
                    <form method="GET" class="flex flex-wrap items-center gap-3">
                        <input type="hidden" name="desa_search" value="{{ $searchDesa }}">
                        <input type="hidden" name="umkm_search" value="{{ $searchUmkm }}">
                        <span class="text-xs uppercase tracking-wide text-gray-400">Status</span>
                        <div class="bg-gray-100 rounded-full p-1 flex items-center gap-1">
                            <button type="submit" name="status" value="active" class="px-4 py-2 text-xs font-semibold rounded-full transition {{ $statusFilter === 'active' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Aktif</button>
                            <button type="submit" name="status" value="suspended" class="px-4 py-2 text-xs font-semibold rounded-full transition {{ $statusFilter === 'suspended' ? 'bg-white text-orange-500 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Suspend</button>
                            <button type="submit" name="status" value="inactive" class="px-4 py-2 text-xs font-semibold rounded-full transition {{ $statusFilter === 'inactive' ? 'bg-white text-gray-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Nonaktif</button>
                            <button type="submit" name="status" value="all" class="px-4 py-2 text-xs font-semibold rounded-full transition {{ $statusFilter === 'all' ? 'bg-white text-purple-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Semua</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Directory Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
                <!-- Direktori Desa -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Direktori Desa</h3>
                            <p class="text-sm text-gray-500 mt-1">Seluruh website desa aktif di Begawi.ID lengkap dengan tautan.</p>
                        </div>
                        <form method="GET" class="flex items-center gap-3">
                            <input type="hidden" name="umkm_search" value="{{ $searchUmkm }}">
                            <input type="hidden" name="status" value="{{ $statusFilter }}">
                            <div class="relative">
                                <input type="text" name="desa_search" value="{{ $searchDesa }}" placeholder="Cari desa..." class="pl-9 pr-3 py-2 bg-gray-100 text-sm text-gray-600 rounded-lg focus:bg-white focus:ring-2 focus:ring-emerald-400 focus:outline-none w-40">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </span>
                            </div>
                            <button type="submit" class="px-3 py-2 text-xs font-semibold text-white bg-emerald-500 rounded-lg hover:bg-emerald-600 transition">Cari</button>
                        </form>
                    </div>

                    <div class="space-y-4 max-h-[420px] overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($desaDirectory as $desa)
                        <div class="border border-gray-100 rounded-xl p-4 hover:border-emerald-100 hover:shadow-md transition bg-gradient-to-r from-white to-emerald-50/30">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 font-semibold flex items-center justify-center">{{ strtoupper(substr($desa['name'], 0, 2)) }}</div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-800">{{ $desa['name'] }}</h4>
                                            <p class="text-xs text-gray-500">Pengelola: <span class="text-gray-700 font-medium">{{ $desa['owner'] }}</span></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 mt-3">
                                        <span class="px-2.5 py-1 text-xs rounded-full bg-emerald-100 text-emerald-600">{{ $desa['status'] }}</span>
                                        @if($desa['updated_at'])
                                        <span class="text-xs text-gray-400">Update {{ $desa['updated_at'] }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ $desa['url'] }}" target="_blank" class="inline-flex items-center gap-2 text-xs text-emerald-600 font-medium hover:text-emerald-700">
                                        Kunjungi
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6m0 0v6m0-6L10 16"></path>
                                        </svg>
                                    </a>
                                    <p class="text-[11px] text-gray-400 mt-1 truncate max-w-[160px]">{{ $desa['display_url'] }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="border border-dashed border-gray-200 rounded-xl p-6 text-center">
                            <h4 class="text-sm font-semibold text-gray-700">Belum ada website desa yang sesuai</h4>
                            <p class="text-xs text-gray-500 mt-1">Coba ubah kata kunci atau status filter.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Direktori UMKM -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Direktori UMKM</h3>
                            <p class="text-sm text-gray-500 mt-1">Website UMKM aktif lengkap dengan kategori usaha dan pengelola.</p>
                        </div>
                        <form method="GET" class="flex items-center gap-3">
                            <input type="hidden" name="desa_search" value="{{ $searchDesa }}">
                            <input type="hidden" name="status" value="{{ $statusFilter }}">
                            <div class="relative">
                                <input type="text" name="umkm_search" value="{{ $searchUmkm }}" placeholder="Cari UMKM..." class="pl-9 pr-3 py-2 bg-gray-100 text-sm text-gray-600 rounded-lg focus:bg-white focus:ring-2 focus:ring-purple-400 focus:outline-none w-40">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </span>
                            </div>
                            <button type="submit" class="px-3 py-2 text-xs font-semibold text-white bg-purple-500 rounded-lg hover:bg-purple-600 transition">Cari</button>
                        </form>
                    </div>

                    <div class="space-y-4 max-h-[420px] overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($umkmDirectory as $umkm)
                        <div class="border border-gray-100 rounded-xl p-4 hover:border-purple-100 hover:shadow-md transition bg-gradient-to-r from-white to-purple-50/40">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-600 font-semibold flex items-center justify-center">{{ strtoupper(substr($umkm['name'], 0, 2)) }}</div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-800">{{ $umkm['name'] }}</h4>
                                            <p class="text-xs text-purple-500 font-medium">{{ $umkm['category'] }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Pengelola: <span class="text-gray-700 font-medium">{{ $umkm['owner'] }}</span></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 mt-3">
                                        <span class="px-2.5 py-1 text-xs rounded-full bg-purple-100 text-purple-600">{{ $umkm['status'] }}</span>
                                        @if($umkm['updated_at'])
                                        <span class="text-xs text-gray-400">Update {{ $umkm['updated_at'] }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ $umkm['url'] }}" target="_blank" class="inline-flex items-center gap-2 text-xs text-purple-600 font-medium hover:text-purple-700">
                                        Buka Situs
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6m0 0v6m0-6L10 16"></path>
                                        </svg>
                                    </a>
                                    <p class="text-[11px] text-gray-400 mt-1 truncate max-w-[160px]">{{ $umkm['display_url'] }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="border border-dashed border-gray-200 rounded-xl p-6 text-center">
                            <h4 class="text-sm font-semibold text-gray-700">Belum ada website UMKM yang sesuai</h4>
                            <p class="text-xs text-gray-500 mt-1">Sesuaikan pencarian atau pilih status berbeda.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Statistik Aktivitas -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <!-- Aktivitas Konten -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Statistik Aktivitas Konten</h3>
                            <p class="text-sm text-gray-500 mt-1">Pergerakan aktivitas tenant selama 6 bulan terakhir.</p>
                        </div>
                        <div class="flex items-center gap-2 bg-gray-100 rounded-full p-1">
                            <span class="px-3 py-1 text-xs font-semibold bg-white rounded-full text-purple-600">6 Bulan</span>
                            <button class="px-3 py-1 text-xs text-gray-500 hover:text-gray-700">12 Bulan</button>
                        </div>
                    </div>
                    <div class="relative h-72">
                        <canvas id="activityTrendChart"></canvas>
                        <div class="absolute top-4 right-4 bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ collect($activityTrend)->sum('value') }} Aktivitas
                        </div>
                    </div>
                </div>

                <!-- Ranking Aktivitas -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Ranking Aktivitas Tenant</h3>
                            <p class="text-sm text-gray-500 mt-1">Peringkat berdasarkan konsistensi pembaruan dan interaksi.</p>
                        </div>
                        <button class="text-sm text-purple-600 font-semibold hover:text-purple-700">Lihat Detail</button>
                    </div>

                    <div class="space-y-4">
                        @foreach($activityRanking as $index => $item)
                        <div class="border border-gray-100 rounded-xl p-4 hover:border-purple-100 hover:shadow-md transition">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-purple-500/10 text-purple-600 font-semibold flex items-center justify-center">{{ $index + 1 }}</div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-800">{{ $item['name'] }}</h4>
                                        <p class="text-xs text-gray-500">{{ $item['type'] }} · {{ $item['owner'] }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-semibold text-purple-600">{{ $item['score'] }}</span>
                                    <div class="flex items-center gap-1 text-xs {{ $item['trend'] === 'up' ? 'text-emerald-500' : ($item['trend'] === 'down' ? 'text-rose-500' : 'text-gray-400') }}">
                                        @if($item['trend'] === 'up')
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                            </svg>
                                            <span>Naik</span>
                                        @elseif($item['trend'] === 'down')
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                            </svg>
                                            <span>Turun</span>
                                        @else
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16"></path>
                                            </svg>
                                            <span>Stabil</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                    <div class="h-2 rounded-full bg-gradient-to-r from-purple-500 to-purple-600" style="width: {{ min(100, max(10, $item['score'])) }}%"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="w-80 space-y-6">
            <!-- Highlight Cards -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Platform</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-emerald-50 to-emerald-100/60">
                        <div class="w-10 h-10 rounded-xl bg-white text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Konversi Aktif</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $statsOverview[0]['value'] }} tenant aktif</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-blue-50 to-blue-100/60">
                        <div class="w-10 h-10 rounded-xl bg-white text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Tenant Desa</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $statsOverview[1]['value'] }} website desa aktif</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-purple-50 to-purple-100/60">
                        <div class="w-10 h-10 rounded-xl bg-white text-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Tenant UMKM</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $statsOverview[2]['value'] }} website UMKM aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tautan Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.websites.desa') }}" class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Kelola Website Desa</p>
                            <p class="text-xs text-gray-500">Akses modul manajemen untuk tenant desa.</p>
                        </div>
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="{{ route('admin.websites.umkm') }}" class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50/50 transition">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Kelola Website UMKM</p>
                            <p class="text-xs text-gray-500">Update data tenant UMKM dan dukungan bisnis.</p>
                        </div>
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="{{ route('admin.websites.domain') }}" class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Status Aktivasi Domain</p>
                            <p class="text-xs text-gray-500">Pantau progres domain custom tenant.</p>
                        </div>
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Support CTA -->
            <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-6 text-white shadow-lg">
                <h3 class="text-lg font-semibold mb-2">Perlu bantuan cepat?</h3>
                <p class="text-sm text-white/70 mb-4">Tim support Begawi siap membantu aktivasi maupun kendala tenant secara real-time.</p>
                <a href="{{ route('admin.support.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-900 rounded-xl text-sm font-semibold hover:bg-gray-100 transition">
                    Hubungi Support
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6m0 0v6m0-6L10 16"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const trendCtx = document.getElementById('activityTrendChart');
    if (trendCtx) {
        const data = @json($activityTrend);
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: data.map(item => item.label),
                datasets: [{
                    data: data.map(item => item.value),
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139, 92, 246, 0.08)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#8B5CF6',
                    pointBorderWidth: 0,
                    pointRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111827',
                        padding: 12,
                        titleFont: { size: 13 },
                        bodyFont: { size: 12 },
                        displayColors: false,
                        callbacks: {
                            label: (context) => ` ${context.parsed.y} aktivitas`,
                        },
                    },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9CA3AF', font: { size: 12 } },
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(156, 163, 175, 0.15)', borderDash: [4, 4] },
                        ticks: { color: '#9CA3AF', font: { size: 11 }, precision: 0, stepSize: 1 },
                    },
                },
            },
        });
    }
});
</script>
@endsection

