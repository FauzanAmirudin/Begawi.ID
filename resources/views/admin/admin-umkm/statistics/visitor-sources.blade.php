@extends('layouts.admin')

@section('title', 'Sumber Pengunjung')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Sumber Pengunjung</h1>
            <p class="text-gray-600">Traffic dari sosial media, mesin pencari, dan sumber lainnya</p>
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
            <a href="{{ route('admin.umkm.statistics.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
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
            <a href="{{ route('admin.umkm.statistics.visitor-sources', ['period' => 'daily']) }}" class="px-4 py-2 text-sm font-medium rounded-lg transition {{ request('period') === 'daily' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Harian (30 hari)
            </a>
            <a href="{{ route('admin.umkm.statistics.visitor-sources', ['period' => 'weekly']) }}" class="px-4 py-2 text-sm font-medium rounded-lg transition {{ request('period') === 'weekly' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Mingguan (12 minggu)
            </a>
            <a href="{{ route('admin.umkm.statistics.visitor-sources', ['period' => 'monthly']) }}" class="px-4 py-2 text-sm font-medium rounded-lg transition {{ request('period') === 'monthly' || !request('period') ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Bulanan (12 bulan)
            </a>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="bg-gradient-to-br from-orange-500 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden mb-8">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-white/80 text-sm font-medium">Total Pengunjung</p>
                <p class="text-4xl font-bold mt-2">{{ number_format($sourcesData['total']) }}</p>
                <p class="text-white/70 text-sm mt-2">dari berbagai sumber</p>
            </div>
            <div class="bg-white/15 rounded-xl p-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
        <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-white/10 rounded-full"></div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Sources Chart -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Distribusi Sumber</h3>
                    <p class="text-sm text-gray-500 mt-1">Persentase pengunjung berdasarkan sumber</p>
                </div>
            </div>
            <div class="relative h-80">
                <canvas id="sourcesChart"></canvas>
            </div>
        </div>

        <!-- Social Media Sources -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Sosial Media</h3>
                    <p class="text-sm text-gray-500 mt-1">Traffic dari platform sosial media</p>
                </div>
            </div>
            <div class="space-y-4">
                @forelse($sourcesData['social_media'] as $social)
                <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-500 rounded-lg flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($social['name'], 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $social['name'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ number_format($social['count']) }}</p>
                        <p class="text-xs text-gray-500">pengunjung</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Tidak ada data dari sosial media</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Search Engines & Sources List -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Search Engines -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Mesin Pencari</h3>
                    <p class="text-sm text-gray-500 mt-1">Traffic dari search engines</p>
                </div>
            </div>
            <div class="space-y-4">
                @forelse($sourcesData['search_engines'] as $engine)
                <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($engine['name'], 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $engine['name'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ number_format($engine['count']) }}</p>
                        <p class="text-xs text-gray-500">pengunjung</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Tidak ada data dari mesin pencari</p>
                @endforelse
            </div>
        </div>

        <!-- All Sources -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Semua Sumber</h3>
                    <p class="text-sm text-gray-500 mt-1">Rincian semua sumber pengunjung</p>
                </div>
            </div>
            <div class="space-y-3">
                @foreach($sourcesData['sources'] as $source)
                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full 
                            @if($source['source'] === 'direct') bg-gray-400
                            @elseif($source['source'] === 'search_engine') bg-blue-500
                            @elseif($source['source'] === 'social_media') bg-pink-500
                            @else bg-purple-500
                            @endif">
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ ucfirst(str_replace('_', ' ', $source['source'])) }}
                                @if($source['source_detail'])
                                    - {{ ucfirst($source['source_detail']) }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ number_format($source['count']) }}</p>
                        <p class="text-xs text-gray-500">{{ $source['percentage'] }}%</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const chartData = @json($sourcesData['chart_data']);

    const ctx = document.getElementById('sourcesChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: chartData.labels,
            datasets: [{
                data: chartData.dataset,
                backgroundColor: [
                    '#8B5CF6',
                    '#3B82F6',
                    '#EC4899',
                    '#10B981',
                    '#F59E0B',
                    '#EF4444',
                ],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 12 },
                        color: '#6B7280',
                    }
                },
                tooltip: {
                    backgroundColor: '#111827',
                    displayColors: true,
                    callbacks: {
                        label: context => {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return ` ${context.label}: ${context.parsed} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection

