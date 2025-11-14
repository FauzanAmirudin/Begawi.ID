@extends('layouts.admin')

@section('title', 'Ranking UMKM Aktif')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Ranking UMKM Aktif</h1>
            <p class="text-gray-600">UMKM paling produktif berdasarkan update & trafik</p>
            @if($village)
            <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-medium text-gray-700">{{ $village->name }}</span>
                <span class="text-gray-400">•</span>
                <span>{{ count($rankings) }} UMKM</span>
            </div>
            @endif
        </div>
        <a href="{{ route('admin.desa-management.reports.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Ranking Criteria Info -->
    <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl p-6 text-white mb-8">
        <div class="flex items-center gap-4">
            <div class="bg-white/15 rounded-xl p-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Kriteria Penilaian</h3>
                <p class="text-white/90 text-sm">Ranking dihitung berdasarkan: Jumlah Produk (×10), Kunjungan (×5), Pesanan (×15), dan Aktivitas Terkini (hingga 50 poin)</p>
            </div>
        </div>
    </div>

    <!-- Ranking List -->
    <div class="space-y-4">
        @foreach($rankings as $ranking)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-blue-200 transition">
            <div class="flex items-center justify-between">
                <!-- Rank & UMKM Info -->
                <div class="flex items-center gap-6">
                    <!-- Rank Badge -->
                    <div class="flex-shrink-0">
                        @if($ranking['rank'] === 1)
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        @elseif($ranking['rank'] === 2)
                        <div class="w-16 h-16 bg-gradient-to-br from-gray-300 to-gray-400 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        @elseif($ranking['rank'] === 3)
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-600 to-amber-700 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        @else
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                            #{{ $ranking['rank'] }}
                        </div>
                        @endif
                    </div>

                    <!-- UMKM Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $ranking['umkm']->name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ $ranking['umkm']->category }}</p>
                        <div class="flex items-center gap-4 text-xs text-gray-600">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                                </svg>
                                {{ $ranking['umkm']->products_count ?? 0 }} Produk
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ number_format($ranking['umkm']->visits_count ?? 0) }} Kunjungan
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                {{ number_format($ranking['umkm']->orders_count ?? 0) }} Pesanan
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Score Details -->
                <div class="text-right">
                    <div class="mb-2">
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($ranking['score']) }}</p>
                        <p class="text-xs text-gray-500">Total Skor</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-600">
                        <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded">Produk: {{ $ranking['product_score'] }}</span>
                        <span class="px-2 py-1 bg-purple-100 text-purple-600 rounded">Kunjungan: {{ $ranking['visit_score'] }}</span>
                        <span class="px-2 py-1 bg-emerald-100 text-emerald-600 rounded">Pesanan: {{ $ranking['order_score'] }}</span>
                        <span class="px-2 py-1 bg-orange-100 text-orange-600 rounded">Aktivitas: {{ $ranking['activity_score'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if(count($rankings) === 0)
    <div class="bg-white rounded-2xl p-12 text-center border border-gray-100">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <p class="text-gray-500 text-lg">Belum ada data UMKM untuk ditampilkan</p>
    </div>
    @endif
</div>
@endsection

