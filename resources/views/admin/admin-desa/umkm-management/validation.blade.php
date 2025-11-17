@extends('layouts.admin')

@section('title', 'Validasi Konten UMKM')

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-data="{}" x-cloak>
    @if (session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
        <button class="text-xs text-emerald-600 hover:text-emerald-500" @click="$el.parentElement.remove()">Tutup</button>
    </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-amber-500 font-semibold">Validasi Konten UMKM</p>
            <h1 class="text-3xl font-semibold text-gray-900 mt-2">Tinjau Pengajuan Konten</h1>
            <p class="text-sm text-gray-500 mt-1">Setujui atau tolak produk, foto, dan promosi yang diajukan oleh admin UMKM.</p>
        </div>
        <span class="px-3 py-1 text-xs font-semibold bg-amber-50 text-amber-600 rounded-full">
            {{ $validationQueue->count() }} Konten Menunggu
        </span>
    </div>

    <div class="space-y-4">
        @php
            $statusStyles = [
                'review' => 'bg-sky-50 text-sky-600',
                'verification' => 'bg-purple-50 text-purple-600',
                'draft' => 'bg-gray-100 text-gray-600',
            ];
        @endphp
        @foreach($validationQueue as $item)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:border-amber-200 transition">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <span class="text-xs font-semibold text-amber-500 uppercase tracking-wide">{{ $item['type'] }}</span>
                    <h3 class="text-base font-semibold text-gray-900 mt-1">{{ $item['umkm'] }}</h3>
                    <p class="text-xs text-gray-400 mt-1">{{ $item['submitted_by'] }}</p>
                </div>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-semibold {{ $statusStyles[$item['status']] ?? 'bg-gray-100 text-gray-600' }}">
                    Status: {{ ucfirst($item['status']) }}
                </span>
            </div>
            <ul class="mt-4 space-y-2 text-sm text-gray-600">
                @foreach($item['items'] as $detail)
                <li class="flex items-start gap-2">
                    <span class="mt-1 w-2 h-2 rounded-full bg-amber-400"></span>
                    <span>{{ $detail }}</span>
                </li>
                @endforeach
            </ul>
            <div class="mt-5 flex flex-wrap gap-3">
                <form action="{{ route('admin.desa-management.umkm-management.content.approve', $item['id']) }}" method="POST" class="inline" onsubmit="return confirm('Setujui konten ini? Konten akan langsung muncul di website desa.')">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl hover:opacity-95 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Setujui Konten
                    </button>
                </form>
                <button onclick="openRejectModal({{ $item['id'] }})" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-rose-500 bg-rose-50 rounded-xl hover:bg-rose-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Tolak & Beri Catatan
                </button>
                <button onclick="openRevisionModal({{ $item['id'] }})" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-amber-600 bg-amber-50 rounded-xl hover:bg-amber-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Minta Revisi
                </button>
            </div>
        </div>
        @endforeach
    </div>
</div>

@include('admin.admin-desa.umkm-management.partials.reject-revision-modals')
@endsection

@push('scripts')
<script>
function openRejectModal(validationId) {
    const form = document.getElementById('rejectForm');
    form.action = '{{ route("admin.desa-management.umkm-management.content.reject", ":id") }}'.replace(':id', validationId);
    document.getElementById('rejectModal').style.display = 'flex';
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
    document.getElementById('rejectForm').reset();
}

function openRevisionModal(validationId) {
    const form = document.getElementById('revisionForm');
    form.action = '{{ route("admin.desa-management.umkm-management.content.revision", ":id") }}'.replace(':id', validationId);
    document.getElementById('revisionModal').style.display = 'flex';
}

function closeRevisionModal() {
    document.getElementById('revisionModal').style.display = 'none';
    document.getElementById('revisionForm').reset();
}
</script>
@endpush

