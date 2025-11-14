@extends('layouts.admin')

@section('title', 'Laporan Digitalisasi Desa')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Digitalisasi Desa</h1>
            <p class="text-gray-600">Data ringkasan kegiatan digital (bisa diunduh PDF/Excel)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.desa-management.reports.digitalization-report', ['format' => 'pdf']) }}" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Unduh PDF
            </a>
            <a href="{{ route('admin.desa-management.reports.digitalization-report', ['format' => 'excel']) }}" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Unduh Excel
            </a>
            <a href="{{ route('admin.desa-management.reports.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Report Header -->
    <div class="bg-gradient-to-br from-orange-500 to-pink-500 rounded-2xl p-8 text-white mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">{{ $village->name ?? 'Desa' }}</h2>
                <p class="text-white/80">Laporan Digitalisasi Desa</p>
                <p class="text-white/70 text-sm mt-2">Dibuat pada: {{ $reportData['generated_at'] }}</p>
            </div>
            <div class="bg-white/15 rounded-xl p-4">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Berita Terbit</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($reportData['news_count']) }}</p>
                </div>
                <div class="bg-blue-100 rounded-xl p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 5H9a2 2 0 00-2 2v12m12-14h2a1 1 0 011 1v12a1 1 0 01-1 1h-2m0-14v14M7 9h6m-6 4h6m-6 4h6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Galeri & Dokumentasi</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($reportData['gallery_count']) }}</p>
                </div>
                <div class="bg-rose-100 rounded-xl p-3">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a2 2 0 012-2h12a2 2 0 012 2v6l-4-3-4 5-3-2-5 4V5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Potensi Unggulan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($reportData['potentials_count']) }}</p>
                </div>
                <div class="bg-emerald-100 rounded-xl p-3">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l2.09 6.26L20 9.27l-5 3.64 1.91 6.09L12 15.77l-4.91 3.23L9 12.91 4 9.27l5.91-.99L12 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-500 text-sm font-medium">UMKM Aktif</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($reportData['umkm_count']) }}</p>
                </div>
                <div class="bg-purple-100 rounded-xl p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Summary Table -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Ringkasan Aktivitas 6 Bulan Terakhir</h3>
                <p class="text-sm text-gray-500 mt-1">Data aktivitas digitalisasi desa per bulan</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Bulan</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Berita</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Galeri</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">UMKM Baru</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData['activity_summary'] as $activity)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-3 px-4 text-sm font-medium text-gray-900">{{ $activity['month'] }}</td>
                        <td class="py-3 px-4 text-sm text-center text-gray-600">{{ $activity['news'] }}</td>
                        <td class="py-3 px-4 text-sm text-center text-gray-600">{{ $activity['gallery'] }}</td>
                        <td class="py-3 px-4 text-sm text-center text-gray-600">{{ $activity['umkm'] }}</td>
                        <td class="py-3 px-4 text-sm text-center font-semibold text-gray-900">{{ $activity['news'] + $activity['gallery'] + $activity['umkm'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Validasi</h3>
            <div class="flex items-center justify-between p-4 rounded-xl bg-amber-50 border border-amber-200">
                <div class="flex items-center gap-3">
                    <div class="bg-amber-100 rounded-lg p-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Konten Menunggu Validasi</p>
                        <p class="text-xs text-gray-500">Perlu ditinjau dan disetujui</p>
                    </div>
                </div>
                <span class="text-2xl font-bold text-amber-600">{{ $reportData['pending_validations'] }}</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Website</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Status Website</span>
                    <span class="px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-600 rounded-full">
                        {{ ucfirst($website->status ?? 'Active') }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">URL Website</span>
                    <span class="text-sm font-medium text-gray-900">{{ $website->url ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Domain Custom</span>
                    <span class="text-sm font-medium text-gray-900">{{ $website->custom_domain ?? 'Belum diatur' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

