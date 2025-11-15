@extends('layouts.desa')

@section('title', $wisata['judul'] . ' - Potensi Wisata Desa')

@section('content')
<div class="min-h-screen bg-slate-50">
    <!-- Breadcrumb -->
    <div class="sticky top-18 z-30 bg-white/90 backdrop-blur-sm border-b border-slate-200 py-2">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <nav class="flex text-sm text-slate-600">
                <a href="{{ route('desa.home') }}" class="hover:text-primary-600 transition">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('desa.galeri-wisata.index') }}" class="hover:text-primary-600 transition">Galeri & Wisata</a>
                <span class="mx-2">/</span>
                <span class="text-primary-600 font-medium">{{ $wisata['judul'] }}</span>
            </nav>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="relative">
        <div class="relative h-[400px] md:h-[500px] overflow-hidden">
            <img src="{{ $wisata['gambar'] }}" 
                 alt="{{ $wisata['judul'] }}" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/40 to-transparent"></div>
            
            <!-- Category Badge -->
            <div class="absolute top-6 left-6">
                @php
                    $categoryColors = [
                        'Wisata Alam' => 'bg-primary-600',
                        'Wisata Budaya' => 'bg-amber-600',
                        'Wisata Ekonomi' => 'bg-green-600',
                    ];
                    $colorClass = $categoryColors[$wisata['kategori']] ?? 'bg-primary-600';
                @endphp
                <span class="{{ $colorClass }} text-white px-4 py-2 rounded-full text-sm font-medium">
                    {{ $wisata['kategori'] }}
                </span>
            </div>

            <!-- Title Overlay -->
            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-12">
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 drop-shadow-lg">
                    {{ $wisata['judul'] }}
                </h1>
                @if(!empty($wisata['ringkasan']))
                <p class="text-lg md:text-xl text-white/90 max-w-3xl drop-shadow-md">
                    {{ $wisata['ringkasan'] }}
                </p>
                @endif
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Description -->
                    @if(!empty($wisata['deskripsi']))
                    <div class="bg-white rounded-2xl shadow-md p-8">
                        <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Tentang Destinasi
                        </h2>
                        <div class="prose prose-slate max-w-none">
                            <div class="text-slate-700 leading-relaxed whitespace-pre-line">
                                {!! nl2br(e($wisata['deskripsi'])) !!}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Map Section -->
                    @if(!empty($wisata['map_embed']))
                    <div class="bg-white rounded-2xl shadow-md p-8">
                        <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Lokasi
                        </h2>
                        <div class="rounded-xl overflow-hidden border border-slate-200">
                            <div class="aspect-[16/9]">
                                {!! $wisata['map_embed'] !!}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Share Section -->
                    <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 mb-1">Bagikan Destinasi Ini</h3>
                            <p class="text-sm text-slate-600">Sebarkan informasi wisata kepada teman dan keluarga.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="shareWhatsApp()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                                WhatsApp
                            </button>
                            <button onclick="shareFacebook()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </button>
                            <button onclick="shareTwitter()" class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                                Twitter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <aside class="space-y-6">
                    <!-- Back Button -->
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <a href="{{ route('desa.galeri-wisata.index') }}" class="flex items-center gap-3 text-primary-600 hover:text-primary-700 font-semibold transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar Wisata
                        </a>
                    </div>

                    <!-- Related Wisata -->
                    @if($relatedWisata->count() > 0)
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            Wisata Terkait
                        </h3>
                        <div class="space-y-4">
                            @foreach($relatedWisata as $related)
                            <a href="{{ route('desa.galeri-wisata.detail', $related['slug']) }}" class="block group">
                                <div class="flex gap-4 hover:bg-slate-50 p-2 rounded-lg transition-colors">
                                    <div class="flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden">
                                        <img src="{{ $related['gambar'] }}" 
                                             alt="{{ $related['judul'] }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-slate-800 group-hover:text-primary-600 transition-colors line-clamp-2 mb-1">
                                            {{ $related['judul'] }}
                                        </h4>
                                        <p class="text-xs text-primary-600 mb-1">{{ $related['kategori'] }}</p>
                                        @if(!empty($related['ringkasan']))
                                        <p class="text-sm text-slate-600 line-clamp-2">
                                            {{ \Illuminate\Support\Str::limit($related['ringkasan'], 60) }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Info Box -->
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl border border-primary-200 p-6">
                        <h3 class="text-lg font-bold text-primary-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Informasi
                        </h3>
                        <div class="space-y-3 text-sm text-primary-800">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-primary-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Status: <strong>{{ $wisata['status'] }}</strong></span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-primary-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span>Kategori: <strong>{{ $wisata['kategori'] }}</strong></span>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    function shareWhatsApp() {
        const url = window.location.href;
        const text = '{{ $wisata["judul"] }} - {{ $wisata["ringkasan"] ?? "Lihat destinasi wisata menarik ini!" }}';
        window.open(`https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`, '_blank');
    }

    function shareFacebook() {
        const url = window.location.href;
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
    }

    function shareTwitter() {
        const url = window.location.href;
        const text = '{{ $wisata["judul"] }}';
        window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`, '_blank');
    }
</script>
@endpush
@endsection

