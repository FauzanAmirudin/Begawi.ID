@extends('layouts.admin')

@section('title', 'Statistik UMKM')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Statistik UMKM</h1>
            <p class="text-gray-600">Grafik jumlah produk, aktivitas, dan kunjungan UMKM</p>
            @if($village)
            <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-medium text-gray-700">{{ $village->name }}</span>
                <span class="text-gray-400">•</span>
                <span>{{ $umkmBusinesses->count() }} UMKM</span>
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

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Total Produk</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($productStats['total']) }}</p>
                    <p class="text-white/70 text-xs mt-2">Rata-rata {{ number_format($productStats['average']) }} produk per UMKM</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Aktivitas 30 Hari</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($activityStats['last_30_days']) }}</p>
                    <p class="text-white/70 text-xs mt-2">{{ number_format($activityStats['last_7_days']) }} aktivitas 7 hari terakhir</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Total Kunjungan</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($visitStats['total']) }}</p>
                    <p class="text-white/70 text-xs mt-2">Rata-rata {{ number_format($visitStats['average']) }} kunjungan</p>
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
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Product Distribution by Category -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Distribusi Produk per Kategori</h3>
                    <p class="text-sm text-gray-500 mt-1">Jumlah produk berdasarkan kategori UMKM</p>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="productCategoryChart"></canvas>
            </div>
        </div>

        <!-- Activity Trend -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Tren Aktivitas UMKM</h3>
                    <p class="text-sm text-gray-500 mt-1">Aktivitas UMKM 6 bulan terakhir</p>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="activityTrendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Visited UMKM -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">UMKM Paling Dikunjungi</h3>
                <p class="text-sm text-gray-500 mt-1">Top 5 UMKM berdasarkan jumlah kunjungan</p>
            </div>
        </div>
        <div class="space-y-4">
            @foreach($visitStats['top_visited'] as $index => $umkm)
            <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-emerald-200 transition">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg flex items-center justify-center text-white font-bold">
                        {{ $index + 1 }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ $umkm['name'] }}</p>
                        <p class="text-xs text-gray-500">{{ $umkm['category'] }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-900">{{ number_format($umkm['visits']) }} kunjungan</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const productStats = @json($productStats);
    const activityStats = @json($activityStats);

    // Product Category Chart
    const productCtx = document.getElementById('productCategoryChart').getContext('2d');
    new Chart(productCtx, {
        type: 'bar',
        data: {
            labels: productStats.labels,
            datasets: [{
                data: productStats.dataset,
                backgroundColor: '#10B981',
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0F172A',
                    displayColors: false,
                    callbacks: {
                        label: context => ` ${context.parsed.y} produk`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#9CA3AF', font: { size: 11 } },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(156,163,175,0.2)', borderDash: [4, 4] },
                    ticks: { color: '#9CA3AF', font: { size: 11 }, precision: 0 },
                }
            }
        }
    });

    // Activity Trend Chart
    const activityCtx = document.getElementById('activityTrendChart').getContext('2d');
    new Chart(activityCtx, {
        type: 'line',
        data: {
            labels: activityStats.trend.labels,
            datasets: [{
                label: 'Aktivitas',
                data: activityStats.trend.dataset,
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59,130,246,0.15)',
                tension: 0.35,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#3B82F6',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#111827',
                    displayColors: false,
                    callbacks: {
                        label: context => ` ${context.parsed.y} aktivitas`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#9CA3AF', font: { size: 12 } },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(156,163,175,0.15)', borderDash: [4, 4] },
                    ticks: { color: '#9CA3AF', font: { size: 12 }, precision: 0 },
                }
            }
        }
    });
});
</script>
@endsection

