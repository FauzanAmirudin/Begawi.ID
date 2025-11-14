@extends('layouts.desa')

@section('title', $agenda['judul'].' - Agenda Desa Sejahtera')

@push('styles')
<style>
    .hero-bg {
        background: radial-gradient(circle at top left, #dcfce7, #e0f2fe);
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, rgba(22,101,52,0.2), rgba(22,101,52,0.6));
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -2.15rem;
        top: 0.4rem;
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 9999px;
        background: #166534;
        box-shadow: 0 0 0 4px rgba(22,101,52,0.15);
    }
</style>
@endpush

@section('content')
<section class="hero-bg pt-14 pb-16 border-b border-slate-200">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <nav class="text-sm text-slate-500 mb-6 flex items-center gap-2">
            <a href="{{ route('desa.home') }}" class="hover:text-green-700">Beranda</a>
            <span>/</span>
            <a href="{{ route('desa.berita.agenda') }}" class="hover:text-green-700">Agenda</a>
            <span>/</span>
            <span class="text-green-700 font-medium line-clamp-1">{{ $agenda['judul'] }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <div class="lg:col-span-8 space-y-6">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-100 text-sky-700 text-sm font-semibold">
                    {{ $agenda['kategori'] }}
                </span>
                <h1 class="text-3xl md:text-4xl font-display font-bold text-slate-900 leading-tight">
                    {{ $agenda['judul'] }}
                </h1>
                <p class="text-lg text-slate-600">
                    {{ $agenda['deskripsi'] }}
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-white shadow-sm border border-white/70">
                        <svg class="w-5 h-5 text-green-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Tanggal</p>
                            <p class="text-base font-semibold text-slate-900">
                                {{ \Carbon\Carbon::parse($agenda['tanggal'])->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-white shadow-sm border border-white/70">
                        <svg class="w-5 h-5 text-green-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Waktu</p>
                            <p class="text-base font-semibold text-slate-900">{{ $agenda['waktu'] }} WIB</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-white shadow-sm border border-white/70">
                        <svg class="w-5 h-5 text-green-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12.414a4 4 0 10-1.414 1.414l4.243 4.243a1 1 0 001.414-1.414zM11 14a3 3 0 110-6 3 3 0 010 6z"></path>
                        </svg>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Lokasi</p>
                            <p class="text-base font-semibold text-slate-900">{{ $agenda['tempat'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="lg:col-span-4 bg-white rounded-3xl shadow-lg border border-white/60 p-6 space-y-4">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-[0.3em]">Kontak Penyelenggara</h2>
                <div class="space-y-4">
                    @foreach($organizers as $organizer)
                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50">
                        <p class="text-sm font-semibold text-slate-900">{{ $organizer['name'] }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $organizer['contact'] }}</p>
                        <p class="text-xs text-slate-500">{{ $organizer['phone'] }}</p>
                    </div>
                    @endforeach
                </div>
                <button class="w-full px-4 py-3 text-sm font-semibold text-white bg-green-600 rounded-xl hover:bg-green-700 transition">
                    Konfirmasi Kehadiran
                </button>
            </aside>
        </div>
    </div>
</section>

<section class="py-16">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 grid grid-cols-1 lg:grid-cols-12 gap-10">
        <div class="lg:col-span-8 space-y-10">
            <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-8">
                <h2 class="text-2xl font-display font-bold text-slate-900 mb-6">Alur Acara</h2>
                <div class="relative timeline pl-12 space-y-6">
                    @foreach($timeline as $step)
                    <div class="relative timeline-item pl-3">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <span class="text-sm font-semibold text-green-700">{{ $step['time'] }} WIB</span>
                            <h3 class="text-lg font-semibold text-slate-900">{{ $step['title'] }}</h3>
                        </div>
                        <p class="text-sm text-slate-600 mt-2">{{ $step['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-slate-50 rounded-3xl border border-slate-100 p-8">
                <h2 class="text-xl font-semibold text-slate-900 mb-4">Checklist Peserta</h2>
                <ul class="space-y-3 text-sm text-slate-600">
                    @foreach($checklist as $item)
                    <li class="flex items-start gap-3">
                        <span class="mt-1 w-2 h-2 rounded-full bg-green-600"></span>
                        <span>{{ $item }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <aside class="lg:col-span-4 space-y-8">
            <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Agenda Lainnya</h3>
                <div class="space-y-4">
                    @foreach($related as $item)
                    <a href="{{ route('desa.berita.agenda-detail', $item['id']) }}" class="block p-4 rounded-2xl border border-slate-100 hover:border-green-200 hover:bg-green-50/60 transition">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500">{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d M Y') }}</span>
                            <span class="text-xs font-semibold text-green-600 bg-green-100 px-3 py-1 rounded-full">{{ $item['kategori'] }}</span>
                        </div>
                        <h4 class="text-sm font-semibold text-slate-900 mt-2 leading-snug line-clamp-2">{{ $item['judul'] }}</h4>
                        <p class="text-xs text-slate-500 mt-1">{{ $item['tempat'] }} · {{ $item['waktu'] }} WIB</p>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="bg-gradient-to-r from-sky-500 to-blue-500 text-white rounded-3xl shadow-lg p-6 space-y-4">
                <h3 class="text-lg font-semibold">Butuh Bantuan?</h3>
                <p class="text-sm text-white/80">Hubungi pusat layanan desa untuk pertanyaan seputar agenda atau kebutuhan khusus.</p>
                <a href="{{ route('desa.contact') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-sky-600 font-semibold rounded-xl hover:bg-blue-50 transition text-sm">
                    Hubungi Sekarang
                </a>
            </div>
        </aside>
    </div>
</section>
@endsection

