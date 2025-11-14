@extends('layouts.desa')

@section('title', $berita['judul'].' - Desa Sejahtera')

@push('styles')
<style>
    .hero-gradient {
        background: linear-gradient(135deg, #f0fdf4 0%, #fef3c7 45%, #fef8f6 100%);
    }
    .article-content p {
        @apply text-slate-700 leading-relaxed mb-5;
    }
    .article-content ul {
        @apply list-disc pl-6 text-slate-700 space-y-2 mb-6;
    }
    .share-button:hover {
        background: #166534;
        color: #fff;
    }
</style>
@endpush

@section('content')
<section class="hero-gradient pt-12 pb-16 border-b border-slate-200">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <nav class="text-sm text-slate-500 mb-6 flex items-center gap-2">
            <a href="{{ route('desa.home') }}" class="hover:text-green-700">Beranda</a>
            <span>/</span>
            <a href="{{ route('desa.berita.index') }}" class="hover:text-green-700">Berita</a>
            <span>/</span>
            <span class="text-green-700 font-medium line-clamp-1">{{ $berita['judul'] }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <div class="lg:col-span-8 space-y-6">
                <span class="inline-flex items-center gap-2 text-sm font-semibold bg-green-100 text-green-700 rounded-full px-4 py-2">
                    {{ $berita['kategori'] }}
                </span>
                <h1 class="text-3xl md:text-4xl font-display font-bold text-slate-900 leading-tight">
                    {{ $berita['judul'] }}
                </h1>
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 text-sm text-slate-600">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-600/10 text-green-700 flex items-center justify-center font-semibold">
                            {{ strtoupper(substr($berita['penulis'], 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">{{ $berita['penulis'] }}</p>
                            <p>{{ \Carbon\Carbon::parse($berita['tanggal'])->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-slate-500">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $berita['views'] }} kali dibaca
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8V4m0 4a4 4 0 100 8m0-8h4m-4 0H8"></path>
                            </svg>
                            Waktu baca ± 5 menit
                        </div>
                    </div>
                </div>
            </div>

            <aside class="lg:col-span-4 bg-white rounded-3xl shadow-lg border border-white/60 p-6 space-y-5">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-[0.3em]">Ringkasan Proyek</h2>
                <div class="grid grid-cols-1 gap-4">
                    @foreach($projectStats as $stat)
                    <div class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            @include('admin.dashboard.partials.icon', ['type' => $stat['icon'] ?? 'grid'])
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">{{ $stat['label'] }}</p>
                            <p class="text-lg font-semibold text-slate-900 mt-1">{{ $stat['value'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

            </aside>
        </div>
    </div>
</section>

<section class="pt-12 pb-20">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 grid grid-cols-1 lg:grid-cols-12 gap-10">
        <article class="lg:col-span-8 space-y-8">
            <div class="w-full overflow-hidden rounded-3xl shadow-lg border border-slate-100">
                <img src="{{ $berita['thumbnail'] }}" alt="{{ $berita['judul'] }}" class="w-full h-[360px] object-cover">
            </div>

            <div class="article-content text-base text-slate-700 leading-relaxed space-y-6">
                @foreach($content as $block)
                    @if($block['type'] === 'paragraph')
                        <p>{{ $block['text'] }}</p>
                    @elseif($block['type'] === 'quote')
                        <blockquote class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-900 rounded-2xl px-6 py-5 text-lg italic">
                            {{ $block['text'] }}
                        </blockquote>
                    @elseif($block['type'] === 'list')
                        <div>
                            <h3 class="font-semibold text-slate-900 mb-3">{{ $block['title'] }}</h3>
                            <ul class="list-disc pl-6 text-slate-700 space-y-2">
                                @foreach($block['items'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="bg-slate-50 border border-slate-100 rounded-3xl p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Bagikan Informasi Ini</h3>
                    <p class="text-sm text-slate-500">Sebarkan kabar baik kepada warga lainnya.</p>
                </div>
                <div class="flex items-center gap-3">
                    @foreach(['Whatsapp', 'Facebook', 'Twitter'] as $network)
                    <button class="share-button px-4 py-2 border border-green-600 text-green-700 rounded-xl text-sm font-semibold transition">
                        {{ $network }}
                    </button>
                    @endforeach
                </div>
            </div>
        </article>

        <aside class="lg:col-span-4 space-y-8">
            <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Berita Terbaru</h3>
                <div class="space-y-4">
                    @foreach($latest as $item)
                    <a href="{{ route('desa.berita.detail', $item['slug']) }}" class="flex gap-4 group">
                        <div class="w-20 h-20 rounded-xl overflow-hidden">
                            <img src="{{ $item['thumbnail'] }}" alt="{{ $item['judul'] }}" class="w-full h-full object-cover transition group-hover:scale-105">
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d M Y') }}</p>
                            <h4 class="text-sm font-semibold text-slate-900 group-hover:text-green-700 transition line-clamp-2">{{ $item['judul'] }}</h4>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Berita Terkait</h3>
                <div class="space-y-5">
                    @forelse($related as $item)
                    <div class="p-4 rounded-2xl border border-slate-100 hover:border-green-200 hover:bg-green-50/50 transition">
                        <p class="text-xs uppercase tracking-wide text-green-600 font-semibold mb-2">{{ $item['kategori'] }}</p>
                        <a href="{{ route('desa.berita.detail', $item['slug']) }}" class="text-sm font-semibold text-slate-900 hover:text-green-700 transition line-clamp-2">
                            {{ $item['judul'] }}
                        </a>
                        <p class="text-xs text-slate-500 mt-2">{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d M Y') }}</p>
                    </div>
                    @empty
                    <p class="text-sm text-slate-500">Belum ada berita terkait.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-3xl shadow-lg p-6 space-y-4">
                <h3 class="text-lg font-semibold">Ikuti Perkembangan Desa</h3>
                <p class="text-sm text-white/80">Dapatkan informasi terbaru seputar program desa, peluang UMKM, dan agenda kegiatan melalui buletin digital kami.</p>
                <form class="space-y-3">
                    <input type="text" placeholder="Nama lengkap" class="w-full px-4 py-3 rounded-xl border-0 text-sm text-slate-900 focus:ring-2 focus:ring-white/60">
                    <input type="email" placeholder="Alamat email" class="w-full px-4 py-3 rounded-xl border-0 text-sm text-slate-900 focus:ring-2 focus:ring-white/60">
                    <button type="submit" class="w-full px-4 py-3 bg-white text-green-700 font-semibold rounded-xl hover:bg-emerald-50 transition text-sm">Daftar Buletin</button>
                </form>
            </div>
        </aside>
    </div>
</section>
@endsection

