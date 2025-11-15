@extends('layouts.admin')

@section('title', 'Dashboard UMKM')

@section('content')
<div class="p-6">
    @if(isset($errorMessage))
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 font-medium">{{ $errorMessage }}</p>
            </div>
        </div>
    </div>
    @endif
    <div class="flex gap-6">
        <!-- Main Column -->
        <div class="flex-1">
            <!-- Primary Stats -->
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

            <!-- Secondary Stats -->
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

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Statistik Pengunjung</h3>
                            <p class="text-sm text-gray-500 mt-1">Rangkuman 6 bulan terakhir</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-600 rounded-full">
                            {{ $visitorSummary['total'] }} · Total
                        </span>
                    </div>
                    <div class="flex items-center gap-6 mb-6">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-400">Rata-rata Harian</p>
                            <p class="text-xl font-semibold text-gray-800 mt-1">{{ $visitorSummary['average'] }}</p>
                        </div>
                        <div class="px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-xs font-semibold">
                            +{{ $visitorSummary['growth'] }}% bulan ini
                        </div>
                    </div>
                    <div class="relative h-64">
                        <canvas id="umkmVisitorChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Tren Produk</h3>
                        <span class="px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-600 rounded-full">
                            {{ $sidebarHighlights['stats']['totalProducts'] }} Produk Aktif
                        </span>
                    </div>
                    <div class="relative h-64">
                        <canvas id="umkmProductsChart"></canvas>
                    </div>
                    <div class="mt-6 space-y-2">
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <span>Total Produk</span>
                            <span class="font-semibold text-gray-900">{{ $sidebarHighlights['stats']['totalProducts'] }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <span>Menunggu Verifikasi</span>
                            <span class="font-semibold text-gray-900">{{ $sidebarHighlights['stats']['pendingProducts'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity & Validation -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terakhir</h3>
                            <p class="text-sm text-gray-500 mt-1">Update produk, upload foto, dll.</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-600 rounded-full">
                            Pembaruan Real-Time
                        </span>
                    </div>
                    <div class="space-y-4">
                        @forelse($activityFeed as $activity)
                        <div class="flex gap-4">
                            @include('admin.dashboard.partials.event-icon', ['type' => $activity['type']])
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400 uppercase tracking-wide">{{ $activity['time'] }}</span>
                                </div>
                                <h4 class="text-sm font-semibold text-gray-900">{{ $activity['title'] }}</h4>
                                <p class="text-xs text-gray-500">{{ $activity['user'] }}</p>
                                <p class="text-xs text-gray-600 leading-relaxed mt-1">{{ $activity['desc'] }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <p class="text-sm">Belum ada aktivitas</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Notifikasi</h3>
                            <p class="text-sm text-gray-500 mt-1">Produk menunggu verifikasi / update template</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold bg-amber-100 text-amber-600 rounded-full">
                            {{ count($pendingValidations) }} Konten
                        </span>
                    </div>
                    <div class="space-y-4">
                        @forelse($pendingValidations as $validation)
                        <div class="p-4 rounded-xl border border-gray-100 hover:border-amber-200 transition">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-amber-500 uppercase tracking-wide">{{ $validation['type'] }}</span>
                                <span class="text-xs text-gray-400">{{ $validation['submitted_at'] }}</span>
                            </div>
                            <h4 class="text-sm font-semibold text-gray-900">{{ $validation['title'] }}</h4>
                            <p class="text-xs text-gray-500 mt-1">Diajukan oleh {{ $validation['submitted_by'] }}</p>
                            <div class="mt-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold
                                    {{ $validation['status'] === 'review' ? 'bg-sky-100 text-sky-600' : '' }}
                                    {{ $validation['status'] === 'verification' ? 'bg-purple-100 text-purple-600' : '' }}
                                    {{ $validation['status'] === 'draft' ? 'bg-gray-100 text-gray-600' : '' }}">
                                    {{ ucfirst($validation['status']) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <p class="text-sm">Tidak ada notifikasi</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="w-80 space-y-6">
            <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-2xl p-6 text-white shadow-lg border border-gray-800">
                <h3 class="text-lg font-semibold mb-4">Tindakan Cepat</h3>
                <div class="space-y-4">
                    @foreach($quickActions as $action)
                    <a href="{{ $action['link'] }}" class="block rounded-xl bg-gradient-to-r {{ $action['color'] }} p-4 hover:opacity-95 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/15 rounded-lg flex items-center justify-center">
                                @include('admin.dashboard.partials.icon', ['type' => $action['icon']])
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">{{ $action['label'] }}</p>
                                <p class="text-xs text-white/70 mt-1">{{ $action['description'] }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-800">Produk Paling Dilihat</h3>
                    <span class="px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-600 rounded-full">
                        Top 3
                    </span>
                </div>
                <div class="space-y-4">
                    @forelse($sidebarHighlights['topProducts'] as $product)
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $product['title'] }}</p>
                            <p class="text-xs text-gray-500">{{ number_format($product['views']) }} kali dilihat</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-500">
                        <p class="text-xs">Belum ada produk</p>
                    </div>
                    @endforelse
                </div>
                <div class="mt-6 p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Total Produk</span>
                        <span class="font-semibold text-gray-900">{{ $sidebarHighlights['stats']['totalProducts'] }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm mt-2">
                        <span class="text-gray-500">Menunggu Verifikasi</span>
                        <span class="font-semibold text-gray-900">{{ $sidebarHighlights['stats']['pendingProducts'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const visitors = @json($charts['visitors']);
    const products = @json($charts['products']);

    const visitorCtx = document.getElementById('umkmVisitorChart').getContext('2d');
    new Chart(visitorCtx, {
        type: 'line',
        data: {
            labels: visitors.labels,
            datasets: [{
                label: 'Pengunjung',
                data: visitors.dataset,
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139,92,246,0.15)',
                tension: 0.35,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#8B5CF6',
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
                    grid: { color: 'rgba(156,163,175,0.15)', borderDash: [4, 4] },
                    ticks: { color: '#9CA3AF', font: { size: 12 } },
                }
            }
        }
    });

    const productsCtx = document.getElementById('umkmProductsChart').getContext('2d');
    new Chart(productsCtx, {
        type: 'bar',
        data: {
            labels: products.labels,
            datasets: [{
                data: products.dataset,
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
});
</script>
@endsection

