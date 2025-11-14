@extends('layouts.admin')

@section('title', 'Monitoring UMKM')

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-cloak>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">Monitoring Aktivitas</p>
            <h1 class="text-3xl font-semibold text-gray-900 mt-2">Insight Performansi UMKM</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau tren kunjungan, produk aktif, dan performa penjualan secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-3 py-1 rounded-full">
                Periode: 6 Bulan Terakhir
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($monitoringSummary as $summary)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ $summary['label'] }}</p>
            <p class="text-2xl font-semibold text-gray-900 mt-2">{{ $summary['value'] }}</p>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $summary['badge'] }} mt-3">
                {{ $summary['delta'] }}
            </span>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Grafik Kunjungan & Konversi</h3>
                    <p class="text-xs text-gray-500 mt-1">Insight performa rata-rata seluruh UMKM</p>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-400">
                    <span class="flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span> Kunjungan
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-indigo-500"></span> Konversi (%)
                    </span>
                </div>
            </div>
            <div class="relative h-72">
                <canvas id="umkmVisitChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-base font-semibold text-gray-900">Performa UMKM</h3>
            <p class="text-xs text-gray-500 mt-1">Tiga UMKM dengan pertumbuhan tertinggi</p>
            <div class="mt-4 space-y-4">
                @foreach($monitoringDetails->take(3) as $detail)
                <div class="p-4 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50/40 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $detail['name'] }}</p>
                            <p class="text-xs text-gray-500">{{ $detail['subdomain'] }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $detail['status_badge'] }}">
                            {{ $detail['status_label'] }}
                        </span>
                    </div>
                    <div class="grid grid-cols-3 gap-3 text-xs text-gray-500 mt-3">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $detail['products'] }}</p>
                            <p>Produk</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ number_format($detail['visits']) }}</p>
                            <p>Kunjungan</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $detail['conversion'] }}%</p>
                            <p>Konversi</p>
                        </div>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-3">Update {{ $detail['last_update'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-900">Ringkasan Aktivitas</h3>
            <a href="{{ route('admin.desa-management.umkm-management.validation') }}" class="text-xs font-semibold text-purple-600 hover:text-purple-500">
                Lihat Validasi Konten
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-xs text-gray-400 uppercase tracking-wide">
                    <tr>
                        <th class="py-2 text-left">UMKM</th>
                        <th class="py-2 text-center">Produk Aktif</th>
                        <th class="py-2 text-center">Kunjungan</th>
                        <th class="py-2 text-center">Pesanan</th>
                        <th class="py-2 text-center">Konversi</th>
                        <th class="py-2 text-right">Update Terakhir</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach($monitoringDetails as $detail)
                    <tr class="border-t border-gray-50">
                        <td class="py-3 pr-4">
                            <div class="font-semibold text-gray-900">{{ $detail['name'] }}</div>
                            <div class="text-xs text-gray-400">{{ $detail['subdomain'] }}</div>
                        </td>
                        <td class="py-3 text-center font-semibold">{{ $detail['products'] }}</td>
                        <td class="py-3 text-center">{{ number_format($detail['visits']) }}</td>
                        <td class="py-3 text-center">{{ number_format($detail['orders']) }}</td>
                        <td class="py-3 text-center">{{ $detail['conversion'] }}%</td>
                        <td class="py-3 text-right text-xs text-gray-400">{{ $detail['last_update'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const chartElement = document.getElementById('umkmVisitChart');
    if (!chartElement) return;

    const visits = @json($chart['visits']);
    const conversion = @json($chart['conversion']);

    new Chart(chartElement.getContext('2d'), {
        type: 'line',
        data: {
            labels: visits.labels,
            datasets: [
                {
                    label: 'Kunjungan',
                    data: visits.dataset,
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16,185,129,0.12)',
                    tension: 0.35,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#10B981',
                    yAxisID: 'y'
                },
                {
                    label: 'Konversi (%)',
                    data: conversion.dataset,
                    borderColor: '#6366F1',
                    backgroundColor: 'rgba(99,102,241,0.12)',
                    tension: 0.35,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#6366F1',
                    yAxisID: 'y1'
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            stacked: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#111827',
                    displayColors: true,
                    callbacks: {
                        label: context => {
                            if (context.dataset.label.includes('Konversi')) {
                                return ` ${context.dataset.label}: ${context.parsed.y}%`;
                            }
                            return ` ${context.dataset.label}: ${context.parsed.y.toLocaleString('id-ID')} kunjungan`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    grid: { color: 'rgba(156,163,175,0.2)', borderDash: [4, 4] },
                    ticks: { color: '#9CA3AF', font: { size: 11 } },
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: { color: '#9CA3AF', font: { size: 11 }, callback: value => `${value}%` },
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#9CA3AF', font: { size: 11 } },
                }
            }
        }
    });
});
</script>
@endpush

