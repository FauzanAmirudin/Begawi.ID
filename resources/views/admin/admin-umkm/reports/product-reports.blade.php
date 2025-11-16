@extends('layouts.admin')

@section('title', 'Laporan Produk')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Produk</h1>
            <p class="text-gray-600">
                @if($type === 'most-viewed')
                    Produk yang sering dilihat
                @else
                    Produk paling sering mendapat interaksi
                @endif
            </p>
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
                <a href="{{ route('admin.umkm.reports.product-reports', ['type' => 'most-viewed']) }}" 
                   class="px-4 py-2 text-sm font-medium rounded-md transition {{ $type === 'most-viewed' ? 'bg-purple-500 text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                    Paling Dilihat
                </a>
                <a href="{{ route('admin.umkm.reports.product-reports', ['type' => 'most-interactions']) }}" 
                   class="px-4 py-2 text-sm font-medium rounded-md transition {{ $type === 'most-interactions' ? 'bg-purple-500 text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                    Paling Interaktif
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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">
                        @if($type === 'most-viewed')
                            Total Views
                        @else
                            Total Interaksi
                        @endif
                    </p>
                    <p class="text-3xl font-bold mt-1">
                        @if($type === 'most-viewed')
                            {{ number_format($summary['total_views']) }}
                        @else
                            {{ number_format($summary['total_interactions']) }}
                        @endif
                    </p>
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

        <div class="bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Rata-rata</p>
                    <p class="text-3xl font-bold mt-1">
                        @if($type === 'most-viewed')
                            {{ number_format($summary['average_views']) }}
                        @else
                            {{ number_format($summary['average_interactions']) }}
                        @endif
                    </p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Total Produk</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summary['total_products']) }}</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
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
                <h3 class="text-lg font-semibold text-gray-800">Top 10 Produk</h3>
                <p class="text-sm text-gray-500 mt-1">
                    @if($type === 'most-viewed')
                        Produk dengan jumlah tampilan terbanyak
                    @else
                        Produk dengan interaksi terbanyak (views + penjualan + rating)
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.umkm.reports.export', ['format' => 'pdf', 'type' => 'product']) }}" class="px-3 py-2 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
                    <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    PDF
                </a>
                <a href="{{ route('admin.umkm.reports.export', ['format' => 'excel', 'type' => 'product']) }}" class="px-3 py-2 text-xs font-medium text-emerald-600 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition">
                    <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Excel
                </a>
            </div>
        </div>
        <div class="relative h-64">
            <canvas id="productChart"></canvas>
        </div>
    </div>

    <!-- Products List -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Produk</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">No</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Produk</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Kategori</th>
                        @if($type === 'most-viewed')
                            <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Views</th>
                        @else
                            <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Interaksi</th>
                            <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Views</th>
                            <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Terjual</th>
                            <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Rating</th>
                        @endif
                        <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-4 px-4 text-sm text-gray-600">{{ $products->firstItem() + $index }}</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                @if($product->primaryImage)
                                    <img src="{{ Storage::url($product->primaryImage->image_path) }}" alt="{{ $product->title }}" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $product->title }}</p>
                                    <p class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($product->description, 50) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-600">{{ $product->category->name ?? '-' }}</td>
                        @if($type === 'most-viewed')
                            <td class="py-4 px-4 text-sm text-gray-900 text-right font-medium">{{ number_format($product->view_count) }}</td>
                        @else
                            <td class="py-4 px-4 text-sm text-gray-900 text-right font-medium">{{ number_format($product->interaction_score ?? 0) }}</td>
                            <td class="py-4 px-4 text-sm text-gray-600 text-right">{{ number_format($product->view_count) }}</td>
                            <td class="py-4 px-4 text-sm text-gray-600 text-right">{{ number_format($product->sold_count) }}</td>
                            <td class="py-4 px-4 text-sm text-gray-600 text-right">{{ number_format($product->rating, 1) }} ⭐</td>
                        @endif
                        <td class="py-4 px-4 text-sm text-gray-900 text-right font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $type === 'most-viewed' ? '5' : '8' }}" class="py-8 text-center text-gray-500">
                            Tidak ada produk ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="mt-6">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const chartData = @json($chartData);
    
    const ctx = document.getElementById('productChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: '{{ $type === "most-viewed" ? "Views" : "Interaksi" }}',
                data: chartData.dataset,
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
                    backgroundColor: '#0F172A',
                    displayColors: false,
                    callbacks: {
                        label: context => ` ${context.parsed.y.toLocaleString()} {{ $type === "most-viewed" ? "views" : "interaksi" }}`
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

