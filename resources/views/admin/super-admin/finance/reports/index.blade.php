@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Laporan Keuangan</h1>
            <p class="text-sm text-gray-500 mt-1">Rekap bulanan & grafik pendapatan</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
        <form method="GET" action="{{ route('admin.finance.reports.index') }}" class="flex items-end gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                <input 
                    type="month" 
                    name="month" 
                    value="{{ $month }}"
                    class="px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                <input 
                    type="number" 
                    name="year" 
                    value="{{ $year }}"
                    min="2020"
                    max="{{ date('Y') }}"
                    class="px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                Filter
            </button>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white">
            <p class="text-green-100 text-sm font-medium mb-1">Total Pendapatan</p>
            <p class="text-3xl font-bold">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
            <p class="text-blue-100 text-sm font-medium mb-1">Pendapatan Bulanan</p>
            <p class="text-3xl font-bold">Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white">
            <p class="text-purple-100 text-sm font-medium mb-1">Total Transaksi</p>
            <p class="text-3xl font-bold">{{ number_format($stats['total_transactions']) }}</p>
        </div>
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white">
            <p class="text-orange-100 text-sm font-medium mb-1">Rata-rata Transaksi</p>
            <p class="text-3xl font-bold">Rp {{ number_format($stats['average_transaction'], 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Monthly Revenue Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan Bulanan ({{ $year }})</h2>
            <div style="position: relative; height: 300px;">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>

        <!-- Daily Revenue Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan Harian ({{ date('F Y', strtotime($month . '-01')) }})</h2>
            <div style="position: relative; height: 300px;">
                <canvas id="dailyRevenueChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue by Package -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan per Paket</h2>
            <div class="space-y-4">
                @forelse($revenueByPackage as $item)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">{{ $item->name }}</p>
                        <p class="text-sm text-gray-500">{{ number_format($item->count) }} transaksi</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Tidak ada data</p>
                @endforelse
            </div>
        </div>

        <!-- Revenue by Payment Method -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan per Metode Pembayaran</h2>
            <div class="space-y-4">
                @forelse($revenueByPaymentMethod as $item)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">
                            @if($item->payment_method === 'midtrans')
                                Midtrans
                            @elseif($item->payment_method === 'xendit')
                                Xendit
                            @else
                                Manual
                            @endif
                        </p>
                        <p class="text-sm text-gray-500">{{ number_format($item->count) }} transaksi</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Tidak ada data</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
// Store chart instances and initialization flag
let monthlyRevenueChart = null;
let dailyRevenueChart = null;
let chartsInitialized = false;

// Initialize charts only once
function initializeCharts() {
    // Prevent multiple initializations
    if (chartsInitialized) {
        return;
    }

    // Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded');
        return;
    }

    // Monthly Revenue Chart
    const monthlyCtxElement = document.getElementById('monthlyRevenueChart');
    if (monthlyCtxElement && !monthlyRevenueChart) {
        const monthlyData = @json($monthlyRevenue);
        
        // Validate data
        if (Array.isArray(monthlyData) && monthlyData.length > 0) {
            const ctx = monthlyCtxElement.getContext('2d');
            
            monthlyRevenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: monthlyData.map(item => {
                        try {
                            const date = new Date(item.month + '-01');
                            return date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
                        } catch (e) {
                            return item.month;
                        }
                    }),
                    datasets: [{
                        label: 'Pendapatan',
                        data: monthlyData.map(item => {
                            const value = parseFloat(item.total) || 0;
                            return isNaN(value) ? 0 : value;
                        }),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    // Daily Revenue Chart
    const dailyCtxElement = document.getElementById('dailyRevenueChart');
    if (dailyCtxElement && !dailyRevenueChart) {
        const dailyData = @json($dailyRevenue);
        
        // Validate data
        if (Array.isArray(dailyData) && dailyData.length > 0) {
            const ctx = dailyCtxElement.getContext('2d');
            
            dailyRevenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: dailyData.map(item => {
                        try {
                            const date = new Date(item.date);
                            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
                        } catch (e) {
                            return item.date;
                        }
                    }),
                    datasets: [{
                        label: 'Pendapatan',
                        data: dailyData.map(item => {
                            const value = parseFloat(item.total) || 0;
                            return isNaN(value) ? 0 : value;
                        }),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    chartsInitialized = true;
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeCharts);
} else {
    // DOM is already ready
    initializeCharts();
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (monthlyRevenueChart) {
        monthlyRevenueChart.destroy();
        monthlyRevenueChart = null;
    }
    if (dailyRevenueChart) {
        dailyRevenueChart.destroy();
        dailyRevenueChart = null;
    }
    chartsInitialized = false;
});
</script>
@endsection

