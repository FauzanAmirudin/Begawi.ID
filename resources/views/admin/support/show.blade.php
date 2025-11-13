@extends('layouts.admin')

@section('title', 'Detail Tiket ' . ($ticket['id'] ?? ''))

@section('content')
@php
    $statusLabels = [
        'open' => 'Open',
        'in_progress' => 'In Progress',
        'resolved' => 'Resolved',
    ];
    $statusColors = [
        'open' => 'bg-blue-100 text-blue-600',
        'in_progress' => 'bg-orange-100 text-orange-600',
        'resolved' => 'bg-emerald-100 text-emerald-600',
    ];
    $priorityLabels = [
        'high' => 'High',
        'medium' => 'Medium',
        'low' => 'Low',
    ];
    $priorityColors = [
        'high' => 'bg-red-100 text-red-600',
        'medium' => 'bg-amber-100 text-amber-600',
        'low' => 'bg-emerald-100 text-emerald-600',
    ];
    $priorityGradients = [
        'high' => 'from-red-500 to-orange-500',
        'medium' => 'from-yellow-500 to-amber-500',
        'low' => 'from-emerald-500 to-teal-500',
    ];
    $selectedStatus = $ticket['status'] ?? 'open';
    $selectedPriority = $ticket['priority'] ?? 'medium';
@endphp

<div class="p-6">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ url()->previous() === url()->current() ? route('admin.support.tickets') : url()->previous() }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100 text-gray-500 hover:text-gray-700 hover:bg-gray-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Support &amp; Pengaduan</p>
                    <h1 class="text-2xl font-semibold text-gray-900">Detail Tiket</h1>
                    <p class="text-sm text-gray-500">Pantau seluruh kronologi dan rencana tindak lanjut tiket tenant.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-gray-100 text-xs font-semibold text-gray-600 rounded-full uppercase">{{ $ticket['id'] ?? '-' }}</span>
                <a href="{{ route('admin.support.contact', ['ticket' => $ticket['id']]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:opacity-90 transition">
                    Tindak Lanjut
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div class="bg-gradient-to-br {{ $priorityGradients[$selectedPriority] ?? 'from-gray-500 to-gray-600' }} rounded-2xl p-6 text-white shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/70">Tiket Support</p>
                    <h2 class="text-2xl font-semibold mt-2">{{ $ticket['subject'] ?? '-' }}</h2>
                    <p class="mt-2 text-sm text-white/80 max-w-2xl leading-relaxed">{{ $ticket['impact'] ?? 'Tidak ada deskripsi dampak.' }}</p>
                </div>
                <div class="flex flex-wrap lg:flex-col gap-2 items-start">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$selectedStatus] ?? 'bg-white/20 text-white' }}">{{ $statusLabels[$selectedStatus] ?? 'Status Tidak Diketahui' }}</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $priorityColors[$selectedPriority] ?? 'bg-white/20 text-white' }}">Prioritas {{ $priorityLabels[$selectedPriority] ?? ucwords($selectedPriority) }}</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white">Diperbarui {{ $ticket['updated_at'] ?? '-' }}</span>
                </div>
            </div>
            <div class="mt-6 flex flex-wrap items-center gap-4 text-xs text-white/80">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-white/60"></span>
                    Dibuat {{ $ticket['created_at'] ?? '-' }}
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-white/60"></span>
                    Kanal: {{ $ticket['channel'] ?? 'Tidak diketahui' }}
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-white/60"></span>
                    Target SLA: {{ $ticket['sla_target'] ?? '-' }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Ringkasan Pengaduan</h3>
                            <p class="text-xs text-gray-500 mt-1">Detail kronologi dan konteks permasalahan.</p>
                        </div>
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-semibold rounded-full uppercase tracking-wide">
                            {{ $ticket['category'] ?? 'Kategori' }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mt-4 leading-relaxed">{{ $ticket['description'] ?? 'Belum ada deskripsi detail.' }}</p>

                    @if(!empty($ticket['tags']))
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach($ticket['tags'] as $tag)
                        <span class="px-3 py-1 bg-gray-100 text-xs font-semibold text-gray-600 rounded-full uppercase tracking-wide">{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Catatan Internal</h3>
                    <p class="text-xs text-gray-500 mt-1">Koordinasi teknis dan update yang tercatat oleh tim support.</p>

                    <div class="mt-5 space-y-5">
                        @forelse($ticket['notes'] ?? [] as $note)
                        <div class="border border-gray-100 rounded-xl p-4 hover:border-purple-200 transition">
                            <div class="flex items-center justify-between text-sm">
                                <div class="font-semibold text-gray-800">{{ $note['author'] ?? 'Support' }}</div>
                                <span class="text-xs text-gray-400">{{ $note['time'] ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-1 text-xs text-gray-500">
                                <span>{{ $note['role'] ?? 'Tim Support' }}</span>
                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                <span class="uppercase tracking-wide font-semibold {{ ($note['visibility'] ?? '') === 'internal' ? 'text-orange-500' : 'text-emerald-500' }}">
                                    {{ ($note['visibility'] ?? 'internal') === 'internal' ? 'Internal' : 'Publik' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-3 leading-relaxed">{{ $note['message'] ?? '-' }}</p>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Belum ada catatan internal yang ditambahkan.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Lampiran &amp; Dokumen</h3>
                        <span class="text-xs text-gray-400 uppercase tracking-wide">{{ count($ticket['attachments'] ?? []) }} berkas</span>
                    </div>
                    <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($ticket['attachments'] ?? [] as $attachment)
                        <div class="border border-gray-100 rounded-xl p-4 flex items-center gap-3 hover:border-purple-200 transition">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white flex items-center justify-center text-sm font-semibold">
                                {{ strtoupper(pathinfo($attachment['name'] ?? 'FILE', PATHINFO_EXTENSION)) ?: 'DOC' }}
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold text-gray-800 truncate">{{ $attachment['name'] ?? 'Lampiran' }}</div>
                                <div class="text-xs text-gray-500">{{ $attachment['size'] ?? '-' }}</div>
                            </div>
                            <button class="flex items-center gap-1 text-xs font-semibold text-purple-600 hover:text-purple-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10m-6 4h6M9 17l-5-5 5-5"></path>
                                </svg>
                                Unduh
                            </button>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Tidak ada lampiran untuk tiket ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Tiket</h3>
                    <div class="mt-4 space-y-4 text-sm text-gray-600">
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-500">Status</span>
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$selectedStatus] ?? 'bg-gray-100 text-gray-600' }}">{{ $statusLabels[$selectedStatus] ?? 'Status' }}</span>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-500">Prioritas</span>
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $priorityColors[$selectedPriority] ?? 'bg-gray-100 text-gray-600' }}">{{ $priorityLabels[$selectedPriority] ?? 'Prioritas' }}</span>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-500">Tenant</span>
                            <span class="font-semibold text-gray-800 text-right">{{ $ticket['tenant'] ?? '-' }}</span>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-500">Penanggung Jawab</span>
                            <span class="font-semibold text-gray-800 text-right">
                                {{ $ticket['assignee']['name'] ?? '-' }}
                                <span class="block text-xs text-gray-500">{{ $ticket['assignee']['role'] ?? '' }}</span>
                            </span>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-500">Kanal Masuk</span>
                            <span class="font-semibold text-gray-800 text-right">{{ $ticket['channel'] ?? '-' }}</span>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-500">Target SLA</span>
                            <span class="font-semibold text-gray-800 text-right">{{ $ticket['sla_target'] ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Kontak &amp; Pemangku Kepentingan</h3>
                    <div class="mt-4 space-y-4 text-sm text-gray-600">
                        <div class="border border-gray-100 rounded-xl p-4">
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Requester</p>
                            <p class="text-sm font-semibold text-gray-900 mt-1">{{ $ticket['requester']['name'] ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $ticket['requester']['role'] ?? '' }}</p>
                            <div class="mt-3 text-xs text-gray-500 space-y-1">
                                <p>{{ $ticket['requester']['email'] ?? '-' }}</p>
                                <p>{{ $ticket['requester']['phone'] ?? '-' }}</p>
                            </div>
                        </div>
                        @if(!empty($ticket['watchers']))
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Watcher</p>
                            <div class="space-y-2">
                                @foreach($ticket['watchers'] as $watcher)
                                <div class="flex items-center justify-between border border-gray-100 rounded-lg px-3 py-2">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $watcher['name'] ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">{{ $watcher['role'] ?? '' }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-600 rounded-full">Dipantau</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Timeline Penanganan</h3>
                        <span class="text-xs text-gray-400">Urut terbaru</span>
                    </div>
                    <div class="mt-6 space-y-6">
                        @forelse(array_reverse($ticket['history'] ?? []) as $event)
                        @php
                            $eventStatus = \Illuminate\Support\Str::slug($event['status'] ?? '', '_');
                            $badgeClass = $statusColors[$eventStatus] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <span class="text-xs font-semibold text-gray-400">{{ $event['time'] ?? '-' }}</span>
                                <span class="w-px flex-1 bg-gray-200 mt-2"></span>
                            </div>
                            <div class="flex-1">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wide {{ $badgeClass }}">
                                    {{ $event['status'] ?? '-' }}
                                </span>
                                <p class="mt-2 text-sm text-gray-700">{{ $event['note'] ?? '-' }}</p>
                                <p class="text-xs text-gray-400 mt-1">Oleh {{ $event['actor'] ?? 'Support' }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Belum ada aktivitas pada tiket ini.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Tiket Terkait</h3>
                        <a href="{{ route('admin.support.tickets') }}" class="text-xs font-semibold text-purple-600 hover:text-purple-700 uppercase tracking-wide">
                            Lihat semua
                        </a>
                    </div>
                    <div class="mt-4 space-y-4">
                        @forelse($relatedTickets as $related)
                        @php
                            $relatedStatus = $related['status'] ?? 'open';
                            $relatedPriority = $related['priority'] ?? 'medium';
                        @endphp
                        <div class="border border-gray-100 rounded-xl p-4 hover:border-purple-200 transition">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $related['subject'] ?? '-' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $related['tenant'] ?? '-' }}</p>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wide {{ $statusColors[$relatedStatus] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ $statusLabels[$relatedStatus] ?? 'Status' }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wide {{ $priorityColors[$relatedPriority] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ $priorityLabels[$relatedPriority] ?? 'Prioritas' }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xs text-gray-400">{{ $related['updated_at'] ?? '-' }}</span>
                                <a href="{{ route('admin.support.tickets.show', $related['id']) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-purple-600 hover:text-purple-700">
                                    Lihat Detail
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Belum ada tiket lain yang serupa.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

