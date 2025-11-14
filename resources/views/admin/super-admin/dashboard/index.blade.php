@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="p-6">
    <div class="flex gap-6">
        <!-- Main Content Area -->
        <div class="flex-1">
            <!-- Stats Cards Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($overviewCards as $card)
                <div class="bg-gradient-to-br {{ $card['gradient'] }} rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-white/80 text-sm font-medium">{{ $card['label'] }}</p>
                            <p class="text-3xl font-bold mt-1">{{ $card['value'] }}</p>
                            <p class="text-white/60 text-xs mt-2">{{ $card['description'] }}</p>
                        </div>
                        <div class="bg-white/15 rounded-xl p-3">
                            @include('admin.dashboard.partials.icon', ['type' => $card['icon']])
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-sm text-white/80">
                        <a href="{{ $card['link'] }}" class="flex items-center gap-2 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            {{ $card['link_label'] }}
                        </a>
                        @if(isset($card['badge']))
                        <span class="flex items-center gap-1 bg-white/15 px-2.5 py-1 rounded-full text-xs font-semibold">
                            {{ $card['badge']['label'] }}
                            <span class="text-white/60 font-medium">{{ $card['badge']['text'] }}</span>
                        </span>
                        @endif
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>
                @endforeach
            </div>

            <!-- Second Row Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($secondaryCards as $card)
                <div class="bg-gradient-to-br {{ $card['gradient'] }} rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-white/70 text-sm font-medium">{{ $card['label'] }}</p>
                            <p class="text-3xl font-bold mt-1">{{ $card['value'] }}</p>
                            <p class="text-white/60 text-xs mt-2">{{ $card['description'] }}</p>
                        </div>
                        <div class="bg-white/15 rounded-xl p-3">
                            @include('admin.dashboard.partials.icon', ['type' => $card['icon']])
                        </div>
                    </div>
                    <a href="{{ $card['link'] }}" class="flex items-center gap-2 text-sm text-white/80 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        {{ $card['link_label'] }}
                    </a>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>
                @endforeach
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Tenant Growth Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Pertumbuhan Tenant</h3>
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-600 rounded-full">
                                {{ $charts['tenant_growth']['highlight']['value'] }} · {{ $charts['tenant_growth']['highlight']['label'] }}
                            </span>
                        </div>
                    </div>
                    <div class="relative">
                        <canvas id="tenantGrowthChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Operational Metrics -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Ringkasan Operasional</h3>
                        <div class="flex items-center gap-4 text-sm text-gray-400">
                            <span>Bulan Ini</span>
                        </div>
                    </div>
                    <div class="space-y-6">
                        @foreach($operationalMetrics as $metric)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ $metric['label'] }}</span>
                            <div class="flex items-center gap-3">
                                <div class="w-32 bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="{{ $metric['color'] }} h-2 rounded-full" style="width: {{ $metric['percentage'] }}%"></div>
                                </div>
                                <span class="text-xs text-gray-500 font-semibold">{{ $metric['badge'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Status & Financial Overview -->
            @php
                $statusColors = [
                    'Aktif' => '#22C55E',
                    'Suspend' => '#F97316',
                    'Nonaktif' => '#9CA3AF',
                ];

                $statusLabels = $charts['status_distribution']['labels'];
                $statusValues = $charts['status_distribution']['values'];
                $totalStatus = array_sum($statusValues);

                $financial = $charts['financial_highlight'];
                $transactionTotal = max(1, $financial['pending'] + $financial['failed']); // avoid division by zero
                $pendingPercentage = round(($financial['pending'] / $transactionTotal) * 100);
                $failedPercentage = round(($financial['failed'] / $transactionTotal) * 100);
            @endphp

            <div class="mt-6 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-6 shadow-lg border border-gray-800 text-white">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold">Distribusi Tenant & Finansial</h3>
                        <p class="text-sm text-white/60 mt-1">Ikhtisar kesehatan tenant Begawi.ID dalam satu tampilan.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-white/80">Live Monitoring</span>
                </div>

                <div class="grid lg:grid-cols-3 gap-6">
                    <!-- Tenant Status Chart -->
                    <div class="bg-white/10 rounded-2xl p-6 flex flex-col items-center justify-center">
                        <div class="relative w-48 h-48">
                            <canvas id="tenantStatusChart" width="200" height="200"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-xs text-white/50 uppercase tracking-wide">Total Tenant</span>
                                <span class="text-3xl font-semibold text-white">{{ $totalStatus }}</span>
                                <span class="text-[11px] text-white/40 mt-1">Aktif {{ $statusValues[0] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="mt-6 w-full space-y-2">
                            @foreach($statusLabels as $index => $label)
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full" style="background: {{ $statusColors[$label] ?? '#ffffff' }}"></span>
                                        <span class="text-white/70">{{ $label }}</span>
                                    </div>
                                    <span class="text-white font-semibold">{{ $statusValues[$index] ?? 0 }}</span>
                                </div>
                                <div class="w-full h-1.5 rounded-full bg-white/10 overflow-hidden">
                                    <div class="h-full rounded-full" style="width: {{ $totalStatus > 0 ? (($statusValues[$index] ?? 0) / $totalStatus) * 100 : 0 }}%; background: {{ $statusColors[$label] ?? '#ffffff' }}"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Financial Overview -->
                    <div class="lg:col-span-2 grid md:grid-cols-3 gap-4">
                        <div class="bg-white/10 rounded-2xl p-5 flex flex-col justify-between backdrop-blur">
                            <div>
                                <div class="flex items-center gap-2 text-white/70 text-xs uppercase tracking-wide">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Pendapatan Tahun Ini
                                </div>
                                <div class="text-3xl font-semibold mt-3">{{ $financial['this_year'] }}</div>
                                <p class="text-white/50 text-xs mt-2">Termasuk seluruh transaksi sukses yang tercatat.</p>
                            </div>
                            <a href="{{ route('admin.finance.transactions.index') }}" class="mt-4 inline-flex items-center gap-2 text-xs text-emerald-300 hover:text-emerald-200 transition">
                                Lihat riwayat transaksi
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-5 flex flex-col gap-4 backdrop-blur">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs uppercase tracking-wide text-white/60">Transaksi Pending</span>
                                    <span class="text-xs font-semibold text-amber-300">{{ $pendingPercentage }}%</span>
                                </div>
                                <div class="text-2xl font-semibold text-amber-200 mt-1">{{ $financial['pending'] }}</div>
                                <div class="w-full h-2 rounded-full bg-white/10 overflow-hidden mt-3">
                                    <div class="h-full rounded-full bg-gradient-to-r from-amber-400 to-orange-400" style="width: {{ $pendingPercentage }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs uppercase tracking-wide text-white/60">Transaksi Gagal</span>
                                    <span class="text-xs font-semibold text-rose-300">{{ $failedPercentage }}%</span>
                                </div>
                                <div class="text-xl font-semibold text-rose-200 mt-1">{{ $financial['failed'] }}</div>
                                <div class="w-full h-2 rounded-full bg-white/10 overflow-hidden mt-3">
                                    <div class="h-full rounded-full bg-gradient-to-r from-rose-400 to-pink-500" style="width: {{ $failedPercentage }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-5 backdrop-blur flex flex-col gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/15 text-emerald-300 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-white/60">Tenant Aktif</p>
                                    <p class="text-2xl font-semibold text-white">{{ $statusValues[0] ?? 0 }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-white/50 leading-relaxed">
                                    Termasuk tenant desa dan UMKM yang saat ini berstatus <span class="text-emerald-200 font-medium">aktif</span>.
                                </p>
                                <a href="{{ route('admin.platform-directory.index') }}" class="mt-3 inline-flex items-center gap-2 text-xs text-white/70 hover:text-white transition">
                                    Buka direktori platform
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar - Latest Events -->
        <div class="w-80">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h3>
                    <button class="text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    @foreach($latestEvents as $event)
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            @include('admin.dashboard.partials.event-icon', ['type' => $event['type']])
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">{{ $event['time'] }}</span>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900 mb-1">{{ $event['title'] }}</h4>
                            <p class="text-xs text-gray-500 mb-1">{{ $event['user'] }}</p>
                            <p class="text-xs text-gray-600 leading-relaxed">{{ $event['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tenantGrowthData = @json($charts['tenant_growth']);
    const statusDistribution = @json($charts['status_distribution']);

    const tenantCtx = document.getElementById('tenantGrowthChart').getContext('2d');
    new Chart(tenantCtx, {
        type: 'bar',
        data: {
            labels: tenantGrowthData.labels,
            datasets: [{
                data: tenantGrowthData.dataset,
                backgroundColor: '#8B5CF6',
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
                    backgroundColor: '#111827',
                    displayColors: false,
                    callbacks: {
                        label: context => ` ${context.parsed.y} tenant`,
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
                    grid: { color: 'rgba(156,163,175,0.2)', borderDash: [4, 4] },
                    ticks: { color: '#9CA3AF', font: { size: 11 }, precision: 0 },
                }
            }
        }
    });

    const statusCtx = document.getElementById('tenantStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusDistribution.labels,
            datasets: [{
                data: statusDistribution.values,
                backgroundColor: ['#22C55E', '#F97316', '#9CA3AF'],
                borderWidth: 0,
                cutout: '75%'
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
                        label: context => ` ${context.label}: ${context.parsed}`,
                    }
                }
            }
        }
    });
});
</script>
@endsection