@extends('layouts.admin')

@section('title', 'Laporan Aktivitas')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Aktivitas</h1>
            <p class="text-gray-600">Rekap update konten UMKM</p>
            @if($umkmBusiness)
            <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="font-medium text-gray-700">{{ $umkmBusiness->name }}</span>
            </div>
            @endif
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-lg p-1">
                <a href="{{ route('admin.umkm.reports.activity-reports', ['period' => 'monthly']) }}" 
                   class="px-4 py-2 text-sm font-medium rounded-md transition {{ $period === 'monthly' ? 'bg-emerald-500 text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                    Bulanan
                </a>
                <a href="{{ route('admin.umkm.reports.activity-reports', ['period' => 'weekly']) }}" 
                   class="px-4 py-2 text-sm font-medium rounded-md transition {{ $period === 'weekly' ? 'bg-emerald-500 text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                    Mingguan
                </a>
            </div>
            <a href="{{ route('admin.umkm.reports.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Total Update</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($activityData['summary']['total_updates']) }}</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Update Produk</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($activityData['summary']['total_product_updates']) }}</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Produk Baru</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($activityData['summary']['total_product_creates']) }}</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Update Profil</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($activityData['summary']['total_profile_updates']) }}</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 5c-4.418 0-8 2.239-8 5v1a1 1 0 001 1h14a1 1 0 001-1v-1c0-2.761-3.582-5-8-5z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Tren Aktivitas</h3>
                <p class="text-sm text-gray-500 mt-1">
                    @if($period === 'monthly')
                        Aktivitas 6 bulan terakhir
                    @else
                        Aktivitas 12 minggu terakhir
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.umkm.reports.export', ['format' => 'pdf', 'type' => 'activity']) }}" class="px-3 py-2 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
                    <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    PDF
                </a>
                <a href="{{ route('admin.umkm.reports.export', ['format' => 'excel', 'type' => 'activity']) }}" class="px-3 py-2 text-xs font-medium text-emerald-600 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition">
                    <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Excel
                </a>
            </div>
        </div>
        <div class="relative h-64">
            <canvas id="activityChart"></canvas>
        </div>
    </div>

    <!-- Activity Table -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Detail Aktivitas</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">
                            @if($period === 'monthly')
                                Bulan
                            @else
                                Minggu
                            @endif
                        </th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Update Produk</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Produk Baru</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Update Profil</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activityData['activities'] as $activity)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-4 px-4 text-sm font-medium text-gray-900">
                            {{ $activity['month'] ?? $activity['week'] ?? '-' }}
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-600 text-right">{{ number_format($activity['product_updates']) }}</td>
                        <td class="py-4 px-4 text-sm text-gray-600 text-right">{{ number_format($activity['product_creates']) }}</td>
                        <td class="py-4 px-4 text-sm text-gray-600 text-right">{{ number_format($activity['profile_updates']) }}</td>
                        <td class="py-4 px-4 text-sm font-semibold text-gray-900 text-right">{{ number_format($activity['total']) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">
                            Tidak ada aktivitas ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const activities = @json($activityData['activities']);
    
    const labels = activities.map(a => a.month || a.week || '');
    const productUpdates = activities.map(a => a.product_updates);
    const productCreates = activities.map(a => a.product_creates);
    const profileUpdates = activities.map(a => a.profile_updates);
    
    const ctx = document.getElementById('activityChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Update Produk',
                    data: productUpdates,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59,130,246,0.15)',
                    tension: 0.35,
                    fill: true,
                },
                {
                    label: 'Produk Baru',
                    data: productCreates,
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139,92,246,0.15)',
                    tension: 0.35,
                    fill: true,
                },
                {
                    label: 'Update Profil',
                    data: profileUpdates,
                    borderColor: '#F59E0B',
                    backgroundColor: 'rgba(245,158,11,0.15)',
                    tension: 0.35,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    backgroundColor: '#111827',
                    displayColors: true,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#9CA3AF', font: { size: 11 } },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(156,163,175,0.15)', borderDash: [4, 4] },
                    ticks: { color: '#9CA3AF', font: { size: 11 }, precision: 0 },
                }
            }
        }
    });
});
</script>
@endsection

