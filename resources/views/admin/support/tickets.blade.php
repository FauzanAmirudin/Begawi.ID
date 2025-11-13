@extends('layouts.admin')

@section('title', 'Tiket Pengaduan')

@section('content')
<div class="p-6">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Tiket Pengaduan</h1>
                <p class="text-sm text-gray-500">Kelola daftar pengaduan dari Admin Desa dan UMKM dengan filter status, prioritas, dan kategori.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-gray-300 transition">
                    Unduh Laporan (.CSV)
                </button>
                <a href="{{ route('admin.support.contact') }}" class="px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm font-medium rounded-lg shadow-sm hover:opacity-90 transition">
                    Buat Tiket Baru
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            <div class="xl:col-span-3 space-y-6">
                <!-- Filters -->
                @php
                    $hasActiveFilters = collect($formState ?? [])->filter(fn($value) => $value !== null && $value !== '')->isNotEmpty();
                @endphp
                <form method="GET" action="{{ route('admin.support.tickets') }}" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
                        <div class="lg:col-span-2">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pencarian</label>
                            <div class="relative mt-2">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </span>
                                <input type="text"
                                       name="search"
                                       value="{{ $formState['search'] ?? '' }}"
                                       placeholder="Cari tiket berdasarkan subjek, tenant, atau ID"
                                       class="w-full pl-10 pr-3 py-2 bg-gray-100 border-0 rounded-lg text-sm text-gray-700 focus:bg-white focus:ring-2 focus:ring-purple-500 focus:outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</label>
                            <select name="status" class="mt-2 w-full bg-gray-100 border-0 text-sm text-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500">
                                @foreach($filterOptions['status'] ?? [] as $value => $label)
                                <option value="{{ $value }}" {{ ($formState['status'] ?? '') === (string) $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Prioritas</label>
                            <select name="priority" class="mt-2 w-full bg-gray-100 border-0 text-sm text-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500">
                                @foreach($filterOptions['priority'] ?? [] as $value => $label)
                                <option value="{{ $value }}" {{ ($formState['priority'] ?? '') === (string) $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori</label>
                            <select name="category" class="mt-2 w-full bg-gray-100 border-0 text-sm text-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500">
                                @foreach($filterOptions['category'] ?? [] as $value => $label)
                                <option value="{{ $value }}" {{ ($formState['category'] ?? '') === (string) $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end gap-3">
                            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:opacity-90 transition">
                                Terapkan Filter
                            </button>
                            @if($hasActiveFilters)
                            <a href="{{ route('admin.support.tickets') }}" class="px-4 py-2 bg-gray-100 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-200 transition">
                                Reset
                            </a>
                            @endif
                        </div>
                    </div>
                </form>

                <!-- Tickets Table -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Daftar Tiket</h2>
                            <p class="text-xs text-gray-500">Status real-time tiket pengaduan.</p>
                        </div>
                        <div class="flex items-center gap-6">
                            <div class="text-xs text-gray-500 uppercase tracking-wide">
                                <span class="font-semibold text-gray-900">{{ $resultCount }}</span> tiket ditemukan
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-400 uppercase tracking-wide">
                                <span>Terakhir diperbarui</span>
                                <span class="font-semibold text-gray-500">13 Nov 2025 10:15</span>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr class="text-left text-xs uppercase tracking-wide text-gray-400">
                                    <th class="px-6 py-3">Tiket</th>
                                    <th class="px-6 py-3">Tenant</th>
                                    <th class="px-6 py-3">Kategori</th>
                                    <th class="px-6 py-3">Prioritas</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Dibuat</th>
                                    <th class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($tickets as $ticket)
                                @php
                                    $priorityColors = [
                                        'high' => 'bg-red-100 text-red-600',
                                        'medium' => 'bg-orange-100 text-orange-600',
                                        'low' => 'bg-emerald-100 text-emerald-600',
                                    ];
                                    $statusColors = [
                                        'open' => 'bg-blue-100 text-blue-600',
                                        'in_progress' => 'bg-orange-100 text-orange-600',
                                        'resolved' => 'bg-emerald-100 text-emerald-600',
                                    ];
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $ticket['subject'] ?? '-' }}</div>
                                        <div class="flex items-center gap-2 mt-1 text-xs text-gray-500">
                                            <span>{{ $ticket['id'] ?? '' }}</span>
                                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                            <a href="{{ route('admin.support.tickets.show', $ticket['id']) }}" class="inline-flex items-center gap-1 text-purple-600 hover:text-purple-700 font-semibold">
                                                Detail
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $ticket['tenant'] ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $ticket['category'] ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $priorityColors[$ticket['priority'] ?? 'low'] ?? 'bg-gray-100 text-gray-600' }}">
                                            {{ ucfirst($ticket['priority'] ?? '-') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$ticket['status'] ?? 'open'] ?? 'bg-gray-100 text-gray-600' }}">
                                            {{ ucwords(str_replace('_', ' ', $ticket['status'] ?? '-')) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">{{ $ticket['created_at'] ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.support.tickets.show', $ticket['id']) }}" class="px-3 py-1 border border-gray-200 text-xs font-medium text-gray-600 rounded-lg hover:border-gray-300 transition">
                                                Detail
                                            </a>
                                            <a href="{{ route('admin.support.contact', ['ticket' => $ticket['id']]) }}" class="px-3 py-1 bg-gradient-to-r from-purple-500 to-purple-600 text-xs font-semibold text-white rounded-lg hover:opacity-90 transition">
                                                Tindak Lanjut
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center gap-3">
                                            <p>Tidak ditemukan tiket yang sesuai dengan filter saat ini.</p>
                                            @if($hasActiveFilters)
                                            <a href="{{ route('admin.support.tickets') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-50 text-purple-600 text-xs font-semibold rounded-lg hover:bg-purple-100 transition">
                                                Reset Filter
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 5A8.001 8.001 0 014.582 9H9m-5 5v5h5m10-5a8.003 8.003 0 01-7.418 5H15m5-5V9h-5"></path>
                                                </svg>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">Ringkasan Status</h2>
                    <p class="text-xs text-gray-500 mt-1">Performa layanan dalam 7 hari terakhir.</p>
                    <div class="mt-6 space-y-4">
                        <div>
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>Tiket Open</span>
                                <span class="font-semibold text-gray-900">{{ number_format($stats['open'] ?? 0) }}</span>
                            </div>
                            <div class="w-full bg-gray-100 h-2 rounded-full mt-2 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600" style="width: {{ min(100, ($stats['open'] ?? 0) * 3) }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>Sedang Diproses</span>
                                <span class="font-semibold text-gray-900">{{ number_format($stats['in_progress'] ?? 0) }}</span>
                            </div>
                            <div class="w-full bg-gray-100 h-2 rounded-full mt-2 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-orange-500 to-orange-600" style="width: {{ min(100, ($stats['in_progress'] ?? 0) * 5) }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>Terselesaikan</span>
                                <span class="font-semibold text-gray-900">{{ number_format($stats['resolved'] ?? 0) }}</span>
                            </div>
                            <div class="w-full bg-gray-100 h-2 rounded-full mt-2 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-600" style="width: {{ min(100, ($stats['resolved'] ?? 0)) }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 p-4 bg-gray-50 rounded-xl text-xs text-gray-500 leading-relaxed">
                        Rata-rata waktu respon: <span class="text-gray-900 font-semibold">{{ $stats['avg_response_time'] ?? '-' }}</span>. Target SLA terpenuhi <span class="text-emerald-600 font-semibold">{{ ($stats['satisfaction'] ?? 0) }}%</span>.
                    </div>
                </div>

                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-sm">
                    <h2 class="text-lg font-semibold">Tim Support Aktif</h2>
                    <p class="text-sm text-white/80 mt-1">Pantau kapasitas agen teknis yang siap membantu.</p>
                    <div class="mt-5 space-y-4">
                        @foreach($agents as $agent)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-sm font-semibold">
                                {{ substr($agent['name'], 0, 2) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-semibold">{{ $agent['name'] }}</span>
                                    <span class="w-2.5 h-2.5 rounded-full {{ ($agent['online'] ?? false) ? 'bg-emerald-300' : 'bg-white/50' }}"></span>
                                </div>
                                <p class="text-xs text-white/70">{{ $agent['speciality'] }}</p>
                            </div>
                            <span class="text-xs font-semibold px-2 py-1 bg-white/20 rounded-full">{{ $agent['tickets'] }} tiket</span>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('admin.support.contact') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-gray-100">
                        Hubungi Koordinator
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

