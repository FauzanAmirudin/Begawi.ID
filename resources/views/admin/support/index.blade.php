@extends('layouts.admin')

@section('title', 'Support & Pengaduan')

@section('content')
<div class="p-6">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Support & Pengaduan</h1>
                <p class="text-sm text-gray-500">Pusat layanan untuk memantau tiket, dokumentasi bantuan, dan komunikasi dengan tim teknis.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.support.tickets') }}" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-pink-500 text-white text-sm font-medium rounded-lg shadow-sm hover:opacity-90 transition">
                    Lihat Semua Tiket
                </a>
                <a href="{{ route('admin.support.contact') }}" class="px-4 py-2 bg-white border border-gray-200 text-sm font-medium rounded-lg text-gray-700 hover:border-gray-300 hover:text-gray-900 transition">
                    Hubungi Tim Teknis
                </a>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-sm">
                <p class="text-emerald-100 text-sm font-medium">Tiket Open</p>
                <p class="text-3xl font-bold mt-2">{{ number_format($stats['open'] ?? 0) }}</p>
                <p class="text-xs text-emerald-100 mt-2">Menunggu respon awal</p>
            </div>
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-sm">
                <p class="text-blue-100 text-sm font-medium">Sedang Diproses</p>
                <p class="text-3xl font-bold mt-2">{{ number_format($stats['in_progress'] ?? 0) }}</p>
                <p class="text-xs text-blue-100 mt-2">Dalam penanganan tim teknis</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-sm">
                <p class="text-purple-100 text-sm font-medium">Terselesaikan Bulan Ini</p>
                <p class="text-3xl font-bold mt-2">{{ number_format($stats['resolved'] ?? 0) }}</p>
                <p class="text-xs text-purple-100 mt-2">Median penanganan &lt; 6 jam</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-medium text-gray-500">Kinerja Support</span>
                    <span class="bg-emerald-50 text-emerald-600 text-xs font-semibold px-2 py-1 rounded-full">{{ ($stats['satisfaction'] ?? 0) }}%</span>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Rata-rata respon</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $stats['avg_response_time'] ?? '-' }}</p>
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                            <span>Resolusi</span>
                            <span>{{ ($stats['satisfaction'] ?? 0) }}% SLA terpenuhi</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-orange-500 to-pink-500" style="width: {{ min(100, (int)($stats['satisfaction'] ?? 0)) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets & Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Tiket Pengaduan Terbaru</h2>
                        <p class="text-xs text-gray-500">Prioritaskan tindak lanjut sesuai urgensi tenant.</p>
                    </div>
                    <a href="{{ route('admin.support.tickets') }}" class="text-sm font-semibold text-purple-600 hover:text-purple-700">
                        Kelola Tiket
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs uppercase tracking-wide text-gray-400">
                                <th class="pb-4 pr-4">Tiket</th>
                                <th class="pb-4 pr-4">Tenant</th>
                                <th class="pb-4 pr-4">Kategori</th>
                                <th class="pb-4 pr-4">Prioritas</th>
                                <th class="pb-4 pr-4">Status</th>
                                <th class="pb-4 pr-4">Update Terakhir</th>
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
                                <td class="py-4 pr-4">
                                    <div class="font-semibold text-gray-900">{{ $ticket['subject'] ?? 'Tiket' }}</div>
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
                                <td class="py-4 pr-4 text-gray-600">{{ $ticket['tenant'] ?? '-' }}</td>
                                <td class="py-4 pr-4">
                                    <span class="text-xs font-medium text-gray-500">{{ $ticket['category'] ?? '-' }}</span>
                                </td>
                                <td class="py-4 pr-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $priorityColors[$ticket['priority'] ?? 'low'] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($ticket['priority'] ?? '-') }}
                                    </span>
                                </td>
                                <td class="py-4 pr-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$ticket['status'] ?? 'open'] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ ucwords(str_replace('_', ' ', $ticket['status'] ?? '-')) }}
                                    </span>
                                </td>
                                <td class="py-4 pr-4 text-gray-500">{{ $ticket['updated_at'] ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-sm text-gray-500">Belum ada tiket terbaru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">Aktivitas Support</h2>
                    <span class="text-xs text-gray-400">Hari ini</span>
                </div>
                <div class="space-y-5">
                    @forelse($activities as $activity)
                    @php
                        $badgeColors = [
                            'resolved' => 'bg-emerald-50 text-emerald-600',
                            'in_progress' => 'bg-orange-50 text-orange-600',
                            'open' => 'bg-blue-50 text-blue-600',
                        ];
                    @endphp
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <span class="text-xs font-semibold text-gray-400">{{ $activity['time'] ?? '-' }}</span>
                            <span class="w-px flex-1 bg-gray-200 mt-2"></span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wide {{ $badgeColors[$activity['status'] ?? 'open'] ?? 'bg-gray-100 text-gray-500' }}">
                                    {{ strtoupper(str_replace('_', ' ', $activity['status'] ?? '-')) }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">{{ $activity['description'] ?? '-' }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500">Tidak ada aktivitas terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Knowledge & Resources -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Dokumentasi Bantuan</h2>
                        <p class="text-xs text-gray-500">FAQ teknis yang paling sering diakses.</p>
                    </div>
                    <a href="{{ route('admin.support.documentation') }}" class="text-sm font-semibold text-purple-600 hover:text-purple-700">
                        Buka Dokumentasi
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse($faqs as $faq)
                    <div class="border border-gray-100 rounded-xl p-5 hover:border-purple-200 transition">
                        <div class="flex items-start justify-between gap-3">
                            <h3 class="text-sm font-semibold text-gray-900">{{ $faq['question'] ?? 'Pertanyaan' }}</h3>
                            <div class="flex gap-2">
                                @foreach(($faq['tags'] ?? []) as $tag)
                                <span class="px-2 py-0.5 bg-purple-50 text-purple-600 text-[11px] font-semibold rounded-full uppercase tracking-wide">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $faq['answer'] ?? '-' }}</p>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500">Belum ada FAQ yang terdaftar.</p>
                    @endforelse
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl p-6 text-white shadow-sm">
                    <h3 class="text-lg font-semibold">Butuh Bantuan Cepat?</h3>
                    <p class="text-sm text-cyan-100 mt-2 leading-relaxed">Hubungi tim teknis langsung melalui hotline atau buat tiket baru untuk eskalasi.</p>
                    <div class="mt-4 flex flex-col gap-2 text-sm">
                        <span class="flex items-center gap-2 text-white/80">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m-4 4h8a2 2 0 002-2V8a2 2 0 00-2-2H11a2 2 0 00-2 2v8a2 2 0 002 2zm-6 0h.01"></path>
                            </svg>
                            Hotline: 0800-123-000
                        </span>
                        <span class="flex items-center gap-2 text-white/80">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                            Telegram: @begawi-support
                        </span>
                    </div>
                    <a href="{{ route('admin.support.contact') }}" class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-white/20 text-sm font-semibold rounded-lg hover:bg-white/30 transition">
                        Hubungi Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Resource Terbaru</h3>
                    <div class="space-y-4">
                        @forelse($resources as $resource)
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white flex items-center justify-center text-sm font-semibold">
                                {{ substr($resource['type'] ?? 'DOC', 0, 3) }}
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-gray-900">{{ $resource['title'] ?? 'Dokumen' }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $resource['size'] ?? '-' }} • Update {{ $resource['updated_at'] ?? '-' }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Belum ada resource terbaru.</p>
                        @endforelse
                    </div>
                    <a href="{{ route('admin.support.documentation') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-purple-600 hover:text-purple-700">
                        Lihat Semua Resource
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

