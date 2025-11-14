@extends('layouts.admin')

@section('title', 'Statistik Pengunjung')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Statistik Pengunjung</h1>
            <p class="text-gray-600">Grafik pengunjung website desa (harian, mingguan, bulanan)</p>
            @if($village)
            <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-medium text-gray-700">{{ $village->name }}</span>
            </div>
            @endif
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.desa-management.reports.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Period Selector -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
        <div class="flex items-center gap-4">
            <span class="text-sm font-medium text-gray-700">Periode:</span>
            <a href="{{ route('admin.desa-management.reports.visitor-statistics', ['period' => 'daily']) }}" class="px-4 py-2 text-sm font-medium rounded-lg transition {{ request('period') === 'daily' || !request('period') ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Harian
            </a>
            <a href="{{ route('admin.desa-management.reports.visitor-statistics', ['period' => 'weekly']) }}" class="px-4 py-2 text-sm font-medium rounded-lg transition {{ request('period') === 'weekly' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Mingguan
            </a>
            <a href="{{ route('admin.desa-management.reports.visitor-statistics', ['period' => 'monthly']) }}" class="px-4 py-2 text-sm font-medium rounded-lg transition {{ request('period') === 'monthly' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Bulanan
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Total Pengunjung</p>
                    <p class="text-3xl font-bold mt-1">{{ $summary['total'] }}</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 0118 0 9 9 0 01-18 0zm9-3a3 3 0 100 6 3 3 0 000-6z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Rata-rata</p>
                    <p class="text-3xl font-bold mt-1">{{ $summary['average'] }}</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Maksimum</p>
                    <p class="text-3xl font-bold mt-1">{{ $summary['max'] }}</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Pertumbuhan</p>
                    <p class="text-3xl font-bold mt-1">{{ $summary['growth'] }}%</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Grafik Pengunjung</h3>
                <p class="text-sm text-gray-500 mt-1">
                    @if($period === 'daily')
                        Data 30 hari terakhir
                    @elseif($period === 'weekly')
                        Data 12 minggu terakhir
                    @else
                        Data 12 bulan terakhir
                    @endif
                </p>
            </div>
        </div>
        <div class="relative h-96">
            <canvas id="visitorChart"></canvas>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const visitorData = @json($visitorData);

    const ctx = document.getElementById('visitorChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: visitorData.labels,
            datasets: [{
                label: 'Pengunjung',
                data: visitorData.dataset,
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139,92,246,0.15)',
                tension: 0.35,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#8B5CF6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
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
                        label: context => ` ${context.parsed.y} pengunjung`
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
                    ticks: { color: '#9CA3AF', font: { size: 12 } },
                }
            }
        }
    });
});
</script>
@endsection

