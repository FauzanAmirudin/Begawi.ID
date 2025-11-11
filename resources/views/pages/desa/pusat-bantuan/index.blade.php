{{-- resources/views/pages/desa/pusat-bantuan/index.blade.php --}}

@extends('layouts.desa')

@section('title', 'Pusat Bantuan - Desa Digital')

@section('content')
<!-- Breadcrumb -->
<div class="bg-white border-b border-slate-200 py-3">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <nav class="flex text-sm text-slate-600">
            <a href="{{ route('desa.home') }}" class="hover:text-sky-600 transition">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-sky-600 font-medium">Pusat Bantuan</span>
        </nav>
    </div>
</div>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-sky-50 to-blue-50 py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-6">
                Pusat Bantuan Desa Digital
            </h1>
            <p class="text-xl text-slate-600 leading-relaxed mb-8">
                Temukan panduan lengkap, tutorial video, dan bantuan teknis untuk memaksimalkan 
                penggunaan layanan digital desa. Kami siap membantu perjalanan digital Anda.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button 
                    onclick="scrollToSection('tutorial-web')"
                    class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Mulai Belajar
                </button>
                <button 
                    onclick="scrollToSection('bantuan-teknis')"
                    class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-sky-600 font-semibold px-8 py-4 rounded-xl border-2 border-sky-600 transition-all duration-300"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Butuh Bantuan?
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-sky-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-slate-800">{{ $statistik['total_tutorial'] }}</div>
                <div class="text-slate-600 text-sm">Tutorial</div>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-slate-800">{{ $statistik['total_video'] }}</div>
                <div class="text-slate-600 text-sm">Video Tutorial</div>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-slate-800">{{ $statistik['total_artikel'] }}</div>
                <div class="text-slate-600 text-sm">Artikel</div>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-slate-800">{{ number_format($statistik['rating_kepuasan'], 1) }}</div>
                <div class="text-slate-600 text-sm">Rating Kepuasan</div>
            </div>
        </div>
    </div>
</section>

<!-- Navigation Tabs -->
<div class="sticky top-[4.5rem] z-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <nav class="flex space-x-8 overflow-x-auto">
            <button onclick="scrollToSection('tutorial-web')" class="help-nav-tab active whitespace-nowrap py-4 px-2 border-b-2 border-sky-600 text-sky-600 font-medium">
                Tutorial Web
            </button>
            <button onclick="scrollToSection('video-pembelajaran')" class="help-nav-tab whitespace-nowrap py-4 px-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">
                Video Pembelajaran
            </button>
            <button onclick="scrollToSection('artikel-inspiratif')" class="help-nav-tab whitespace-nowrap py-4 px-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">
                Artikel Inspiratif
            </button>
            <button onclick="scrollToSection('bantuan-teknis')" class="help-nav-tab whitespace-nowrap py-4 px-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">
                Bantuan Teknis
            </button>
        </nav>
    </div>
</div>

<!-- Section 1: Tutorial Penggunaan Web -->
<section id="tutorial-web" class="py-12 md:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-800 mb-4">Tutorial Penggunaan Web</h2>
            <p class="text-slate-600 max-w-2xl mx-auto">
                Pelajari cara menggunakan berbagai fitur website desa dengan panduan langkah demi langkah yang mudah dipahami
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($tutorials as $tutorial)
            <div class="tutorial-card bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 cursor-pointer"
                 onclick="openTutorial({{ $tutorial['id'] }})">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-{{ $tutorial['color'] }}-100 rounded-xl flex items-center justify-center">
                        <x-desa.icon :name="$tutorial['icon']" class="w-6 h-6 text-{{ $tutorial['color'] }}-600" />
                    </div>
                    <div class="flex-1">
                        <span class="bg-{{ $tutorial['color'] }}-100 text-{{ $tutorial['color'] }}-700 text-xs font-medium px-2 py-1 rounded-full">
                            {{ $tutorial['kategori'] }}
                        </span>
                    </div>
                </div>
                
                <h3 class="text-lg font-semibold text-slate-800 mb-2">{{ $tutorial['judul'] }}</h3>
                <p class="text-slate-600 text-sm mb-4 leading-relaxed">{{ $tutorial['deskripsi'] }}</p>
                
                <div class="flex items-center justify-between text-sm text-slate-500">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $tutorial['durasi'] }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            {{ $tutorial['tingkat'] }}
                        </span>
                    </div>
                    <span class="text-{{ $tutorial['color'] }}-600 font-medium">Mulai →</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Section 2: Video Pembelajaran -->
<section id="video-pembelajaran" class="py-12 md:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-800 mb-4">Video Pembelajaran</h2>
            <p class="text-slate-600 max-w-2xl mx-auto">
                Belajar lebih mudah dengan video tutorial yang menjelaskan setiap fitur secara visual dan interaktif
            </p>
        </div>
        
        <!-- Video Carousel -->
        <div class="relative">
            <div class="overflow-x-auto">
                <div class="flex gap-6 pb-4" style="width: max-content;">
                    @foreach($videos as $video)
                    <div class="video-card bg-gray-50 border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02] cursor-pointer"
                         style="width: 320px; flex-shrink: 0;"
                         onclick="openVideo('{{ $video['youtube_id'] }}', '{{ $video['judul'] }}')">
                        <div class="relative">
                            <img 
                                src="{{ $video['thumbnail'] }}" 
                                alt="{{ $video['judul'] }}"
                                class="w-full h-48 object-cover"
                            />
                            <div class="absolute inset-0 flex items-center justify-center bg-black/40 hover:bg-black/30 transition">
                                <div class="w-16 h-16 bg-white/90 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-sky-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                {{ $video['durasi'] }}
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-sky-100 text-sky-700 text-xs font-medium px-2 py-1 rounded-full">
                                    {{ $video['kategori'] }}
                                </span>
                            </div>
                            <h3 class="font-semibold text-slate-800 mb-2 line-clamp-2">{{ $video['judul'] }}</h3>
                            <p class="text-slate-600 text-sm mb-3 line-clamp-2">{{ $video['deskripsi'] }}</p>
                            
                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ number_format($video['views']) }} views
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    {{ $video['likes'] }} likes
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Navigation Arrows -->
            <button id="prevVideo" class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 bg-white shadow-lg rounded-full p-2 hover:bg-gray-50 transition">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button id="nextVideo" class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 bg-white shadow-lg rounded-full p-2 hover:bg-gray-50 transition">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>
</section>

{{-- Lanjutan dari file sebelumnya, tambahkan setelah Section 2: Video Pembelajaran --}}

<!-- Section 3: Artikel Inspiratif -->
<section id="artikel-inspiratif" class="py-12 md:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-800 mb-4">Artikel Inspiratif</h2>
            <p class="text-slate-600 max-w-2xl mx-auto">
                Baca kisah inspiratif, tips, dan insight tentang transformasi digital desa serta inovasi pelayanan publik
            </p>
        </div>
        
        <!-- Filter Tags -->
        <div class="flex flex-wrap gap-3 justify-center mb-8">
            <button onclick="filterArticles('all')" class="article-filter active bg-sky-600 text-white px-4 py-2 rounded-full text-sm font-medium transition">
                Semua Artikel
            </button>
            <button onclick="filterArticles('digitalisasi')" class="article-filter bg-white text-slate-600 border border-slate-300 px-4 py-2 rounded-full text-sm font-medium hover:bg-slate-50 transition">
                #Digitalisasi
            </button>
            <button onclick="filterArticles('umkm')" class="article-filter bg-white text-slate-600 border border-slate-300 px-4 py-2 rounded-full text-sm font-medium hover:bg-slate-50 transition">
                #UMKM
            </button>
            <button onclick="filterArticles('partisipasi')" class="article-filter bg-white text-slate-600 border border-slate-300 px-4 py-2 rounded-full text-sm font-medium hover:bg-slate-50 transition">
                #PartisipasiWarga
            </button>
            <button onclick="filterArticles('keamanan')" class="article-filter bg-white text-slate-600 border border-slate-300 px-4 py-2 rounded-full text-sm font-medium hover:bg-slate-50 transition">
                #Keamanan
            </button>
        </div>
        
        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($articles as $article)
            <article class="article-card bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 cursor-pointer"
                     data-kategori="{{ strtolower($article['kategori']) }}"
                     onclick="openArticle({{ $article['id'] }})">
                <div class="relative overflow-hidden">
                    <img 
                        src="{{ $article['gambar'] }}" 
                        alt="{{ $article['judul'] }}"
                        class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-4 left-4 right-4">
                            <span class="text-white text-sm font-medium bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                Baca Selengkapnya →
                            </span>
                        </div>
                    </div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-white/90 backdrop-blur-sm text-slate-700 text-xs font-medium px-3 py-1 rounded-full">
                            {{ $article['kategori'] }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center gap-4 text-sm text-slate-500 mb-3">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $article['penulis'] }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h8m-8 0a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2"></path>
                            </svg>
                            {{ date('d M Y', strtotime($article['tanggal'])) }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $article['waktu_baca'] }}
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-800 mb-3 line-clamp-2">{{ $article['judul'] }}</h3>
                    <p class="text-slate-600 mb-4 line-clamp-3">{{ $article['excerpt'] }}</p>
                    
                    <div class="flex flex-wrap gap-2">
                        @foreach($article['tags'] as $tag)
                        <span class="text-xs text-sky-600 bg-sky-50 px-2 py-1 rounded-full">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <!-- Load More Button -->
        <div class="text-center mt-12">
            <button class="bg-white hover:bg-slate-50 text-slate-700 font-semibold px-8 py-3 rounded-xl border border-slate-300 transition-colors">
                Muat Artikel Lainnya
            </button>
        </div>
    </div>
</section>

<!-- Section 4: Bantuan Teknis -->
<section id="bantuan-teknis" class="py-12 md:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-800 mb-4">Bantuan Teknis</h2>
            <p class="text-slate-600 max-w-2xl mx-auto">
                Butuh bantuan teknis? Tim support kami siap membantu menyelesaikan masalah teknis yang Anda hadapi
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left Side - Illustration & Info -->
            <div class="space-y-8">
                <div class="bg-gradient-to-br from-sky-50 to-blue-50 rounded-2xl p-8 text-center">
                    <div class="w-24 h-24 bg-sky-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4">Tim Support 24/7</h3>
                    <p class="text-slate-600 mb-6">
                        Tim teknis kami siap membantu Anda mengatasi berbagai kendala teknis dalam menggunakan website desa
                    </p>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-sky-600">< 24h</div>
                            <div class="text-slate-600">Response Time</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-emerald-600">98%</div>
                            <div class="text-slate-600">Success Rate</div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div class="space-y-4">
                    <h4 class="font-semibold text-slate-800">Kontak Langsung:</h4>
                    <div class="space-y-3">
                        <a href="tel:+6281234567890" class="flex items-center gap-3 p-4 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition">
                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-slate-800">Telepon Support</div>
                                <div class="text-sm text-slate-600">+62 812-3456-7890</div>
                            </div>
                        </a>
                        
                        <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center gap-3 p-4 bg-green-50 rounded-xl hover:bg-green-100 transition">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-slate-800">WhatsApp Support</div>
                                <div class="text-sm text-slate-600">Chat langsung dengan tim</div>
                            </div>
                        </a>
                        
                        <a href="mailto:support@desa.go.id" class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-slate-800">Email Support</div>
                                <div class="text-sm text-slate-600">support@desa.go.id</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Form Pengaduan Teknis -->
            <div class="bg-slate-50 rounded-2xl p-8">
                <h3 class="text-2xl font-semibold text-slate-800 mb-6">Form Pengaduan Teknis</h3>
                
                <!-- Step Indicator -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-sky-600 text-white rounded-full flex items-center justify-center text-sm font-medium">1</div>
                        <span class="ml-2 text-sm font-medium text-slate-800">Isi Data</span>
                    </div>
                    <div class="flex-1 h-px bg-slate-200 mx-4"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-slate-200 text-slate-500 rounded-full flex items-center justify-center text-sm font-medium">2</div>
                        <span class="ml-2 text-sm text-slate-500">Deskripsi Masalah</span>
                    </div>
                    <div class="flex-1 h-px bg-slate-200 mx-4"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-slate-200 text-slate-500 rounded-full flex items-center justify-center text-sm font-medium">3</div>
                        <span class="ml-2 text-sm text-slate-500">Kirim</span>
                    </div>
                </div>
                
                <form id="laporanTeknisForm" onsubmit="submitLaporanTeknis(event)" class="space-y-6">
                    <!-- Personal Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap *</label>
                            <input 
                                type="text" 
                                name="nama" 
                                required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                placeholder="Masukkan nama lengkap"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Email *</label>
                            <input 
                                type="email" 
                                name="email" 
                                required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                placeholder="email@example.com"
                            >
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon</label>
                            <input 
                                type="tel" 
                                name="telepon" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                                placeholder="08xxxxxxxxxx"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Kategori Masalah *</label>
                            <select 
                                name="kategori" 
                                required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                            >
                                <option value="">Pilih Kategori</option>
                                <option value="website">Masalah Website</option>
                                <option value="akun">Masalah Akun</option>
                                <option value="layanan">Masalah Layanan</option>
                                <option value="performa">Masalah Performa</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Priority Level -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tingkat Prioritas *</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="flex items-center p-3 border border-slate-300 rounded-xl cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="prioritas" value="rendah" class="sr-only" required>
                                <div class="priority-indicator w-4 h-4 border-2 border-slate-300 rounded-full mr-3"></div>
                                <div>
                                    <div class="font-medium text-slate-800">Rendah</div>
                                    <div class="text-xs text-slate-600">Tidak mendesak</div>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border border-slate-300 rounded-xl cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="prioritas" value="sedang" class="sr-only" required>
                                <div class="priority-indicator w-4 h-4 border-2 border-slate-300 rounded-full mr-3"></div>
                                <div>
                                    <div class="font-medium text-slate-800">Sedang</div>
                                    <div class="text-xs text-slate-600">Perlu perhatian</div>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border border-slate-300 rounded-xl cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="prioritas" value="tinggi" class="sr-only" required>
                                <div class="priority-indicator w-4 h-4 border-2 border-slate-300 rounded-full mr-3"></div>
                                <div>
                                    <div class="font-medium text-slate-800">Tinggi</div>
                                    <div class="text-xs text-slate-600">Sangat mendesak</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Problem Description -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Judul Masalah *</label>
                        <input 
                            type="text" 
                            name="judul" 
                            required 
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                            placeholder="Ringkasan singkat masalah yang dihadapi"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Detail *</label>
                        <textarea 
                            name="deskripsi" 
                            rows="5" 
                            required 
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-400 focus:border-transparent transition resize-none"
                            placeholder="Jelaskan masalah secara detail termasuk:&#10;- Langkah yang sudah dicoba&#10;- Kapan masalah terjadi&#10;- Pesan error (jika ada)&#10;- Browser/device yang digunakan"
                        ></textarea>
                    </div>
                    
                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Screenshot/Bukti Masalah</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <input type="file" id="screenshot1" name="screenshot[]" accept="image/*,.pdf" class="hidden">
                                <label for="screenshot1" class="flex items-center gap-3 p-4 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-sky-400 hover:bg-sky-50 transition">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <div class="font-medium text-slate-700">Screenshot 1</div>
                                        <div class="text-sm text-slate-500" id="screenshot1-info">Klik untuk upload</div>
                                    </div>
                                </label>
                            </div>
                            <div>
                                <input type="file" id="screenshot2" name="screenshot[]" accept="image/*,.pdf" class="hidden">
                                <label for="screenshot2" class="flex items-center gap-3 p-4 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-sky-400 hover:bg-sky-50 transition">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <div class="font-medium text-slate-700">Screenshot 2</div>
                                        <div class="text-sm text-slate-500" id="screenshot2-info">Klik untuk upload</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl"
                    >
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Kirim Laporan Teknis
                        </span>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Riwayat Form Section -->
        <div class="mt-16">
            <h3 class="text-2xl font-bold text-slate-800 mb-8">Riwayat Laporan Teknis</h3>
            
            <!-- Filter Status -->
            <div class="flex flex-wrap gap-3 mb-6">
                <button onclick="filterRiwayat('semua')" class="riwayat-filter active bg-sky-600 text-white px-4 py-2 rounded-full text-sm font-medium transition">
                    Semua Status
                </button>
                <button onclick="filterRiwayat('proses')" class="riwayat-filter bg-white text-slate-600 border border-slate-300 px-4 py-2 rounded-full text-sm font-medium hover:bg-slate-50 transition">
                    Dalam Proses
                </button>
                <button onclick="filterRiwayat('selesai')" class="riwayat-filter bg-white text-slate-600 border border-slate-300 px-4 py-2 rounded-full text-sm font-medium hover:bg-slate-50 transition">
                    Selesai
                </button>
                <button onclick="filterRiwayat('revisi')" class="riwayat-filter bg-white text-slate-600 border border-slate-300 px-4 py-2 rounded-full text-sm font-medium hover:bg-slate-50 transition">
                    Perlu Revisi
                </button>
            </div>
            
            <!-- Riwayat Table -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-100 text-slate-700 font-medium">
                            <tr>
                                <th class="text-left py-4 px-6">Nomor Tiket</th>
                                <th class="text-left py-4 px-6">Tanggal</th>
                                <th class="text-left py-4 px-6">Deskripsi</th>
                                <th class="text-left py-4 px-6">Kategori</th>
                                <th class="text-left py-4 px-6">Prioritas</th>
                                <th class="text-left py-4 px-6">Status</th>
                                <th class="text-left py-4 px-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($riwayatForm as $riwayat)
                            <tr class="riwayat-row hover:bg-slate-50 transition-colors" data-status="{{ $riwayat['status'] }}">
                                <td class="py-4 px-6 font-mono text-sm text-slate-600">{{ $riwayat['id'] }}</td>
                                <td class="py-4 px-6 text-slate-800">{{ date('d/m/Y', strtotime($riwayat['tanggal'])) }}</td>
                                <td class="py-4 px-6 text-slate-800 max-w-xs">
                                    <div class="truncate">{{ $riwayat['deskripsi'] }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                        {{ ucfirst($riwayat['kategori']) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($riwayat['prioritas'] === 'tinggi')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full">Tinggi</span>
                                    @elseif($riwayat['prioritas'] === 'sedang')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">Sedang</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2 py-1 rounded-full">Rendah</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($riwayat['status'] === 'selesai')
                                        <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-3 py-1 rounded-full">Selesai</span>
                                    @elseif($riwayat['status'] === 'proses')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">Dalam Proses</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">Perlu Revisi</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <button 
                                        onclick="showRiwayatDetail('{{ $riwayat['id'] }}')"
                                        class="text-sky-600 hover:text-sky-700 text-sm font-medium"
                                    >
                                        Lihat Detail
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modals -->

<!-- Video Modal -->
<div id="videoModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b border-slate-200">
            <h3 id="videoTitle" class="text-xl font-bold text-slate-800"></h3>
            <button onclick="closeVideoModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="aspect-video">
            <iframe 
                id="videoIframe"
                width="100%" 
                height="100%" 
                src="" 
                frameborder="0" 
                allowfullscreen
                class="w-full h-full"
            ></iframe>
        </div>
    </div>
</div>

<!-- Tutorial Modal -->
<div id="tutorialModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div id="tutorialContent" class="p-6">
            <!-- Content akan diisi dengan JavaScript -->
        </div>
    </div>
</div>

<!-- Article Modal -->
<div id="articleModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div id="articleContent" class="p-6">
            <!-- Content akan diisi dengan JavaScript -->
        </div>
    </div>
</div>

<!-- Riwayat Detail Modal -->
<div id="riwayatModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div id="riwayatContent" class="p-6">
            <!-- Content akan diisi dengan JavaScript -->
        </div>
    </div>
</div>

@push('scripts')
<script>
// Navigation tabs for help sections
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    const offset = 120;
    const top = section.offsetTop - offset;
    
    window.scrollTo({
        top: top,
        behavior: 'smooth'
    });
    
    // Update active tab
    document.querySelectorAll('.help-nav-tab').forEach(tab => {
        tab.classList.remove('active', 'border-sky-600', 'text-sky-600');
        tab.classList.add('border-transparent', 'text-slate-500');
    });
    
    event.target.classList.add('active', 'border-sky-600', 'text-sky-600');
    event.target.classList.remove('border-transparent', 'text-slate-500');
}

// Open tutorial modal
function openTutorial(tutorialId) {
    // Fetch tutorial detail dan buka modal
    fetch(`/desa/pusat-bantuan/tutorial/${tutorialId}`)
        .then(response => response.json())
        .then(data => {
            showTutorialModal(data);
        });
}

// Open video modal
function openVideo(youtubeId, title) {
    const modal = document.getElementById('videoModal');
    const iframe = document.getElementById('videoIframe');
    const titleElement = document.getElementById('videoTitle');
    
    titleElement.textContent = title;
    iframe.src = `https://www.youtube.com/embed/${youtubeId}?autoplay=1`;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

// Close video modal
function closeVideoModal() {
    const modal = document.getElementById('videoModal');
    const iframe = document.getElementById('videoIframe');
    
    iframe.src = '';
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Tutorial modal functions
function showTutorialModal(tutorial) {
    const modal = document.getElementById('tutorialModal');
    const content = document.getElementById('tutorialContent');
    
    content.innerHTML = `
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold text-slate-800">${tutorial.judul}</h3>
                <p class="text-slate-600 mt-1">${tutorial.deskripsi}</p>
            </div>
            <button onclick="closeTutorialModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="mb-6">
            <div class="flex items-center gap-4 text-sm text-slate-600">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    ${tutorial.durasi}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    ${tutorial.tingkat}
                </span>
                <span class="bg-${tutorial.color}-100 text-${tutorial.color}-700 text-xs font-medium px-2 py-1 rounded-full">
                    ${tutorial.kategori}
                </span>
            </div>
        </div>
        
        <div class="space-y-4">
            <h4 class="font-semibold text-slate-800">Langkah-langkah:</h4>
            <div class="space-y-3">
                ${tutorial.langkah.map((step, index) => `
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-sky-600 text-white rounded-full flex items-center justify-center text-sm font-medium flex-shrink-0">
                            ${index + 1}
                        </div>
                        <div class="flex-1 pt-1">
                            <p class="text-slate-700">${step}</p>
                        </div>
                    </div>
                `).join('')}
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeTutorialModal() {
    const modal = document.getElementById('tutorialModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Video carousel navigation
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('#video-pembelajaran .overflow-x-auto');
    const prevBtn = document.getElementById('prevVideo');
    const nextBtn = document.getElementById('nextVideo');
    
    if (carousel && prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: -340, behavior: 'smooth' });
        });
        
        nextBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: 340, behavior: 'smooth' });
        });
    }
});

// Scroll spy for help navigation tabs
function updateActiveHelpTab() {
    const sections = ['tutorial-web', 'video-pembelajaran', 'artikel-inspiratif', 'bantuan-teknis'];
    const scrollPosition = window.scrollY + 200;
    
    sections.forEach(sectionId => {
        const section = document.getElementById(sectionId);
        const tab = document.querySelector(`button[onclick="scrollToSection('${sectionId}')"]`);
        
        if (section && tab) {
            const sectionTop = section.offsetTop;
            const sectionBottom = sectionTop + section.offsetHeight;
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                document.querySelectorAll('.help-nav-tab').forEach(t => {
                    t.classList.remove('active', 'border-sky-600', 'text-sky-600');
                    t.classList.add('border-transparent', 'text-slate-500');
                });
                
                tab.classList.add('active', 'border-sky-600', 'text-sky-600');
                tab.classList.remove('border-transparent', 'text-slate-500');
            }
        }
    });
}
// Filter articles
function filterArticles(kategori) {
    const articles = document.querySelectorAll('.article-card');
    const filters = document.querySelectorAll('.article-filter');
    
    // Update active filter
    filters.forEach(filter => {
        filter.classList.remove('active', 'bg-sky-600', 'text-white');
        filter.classList.add('bg-white', 'text-slate-600', 'border', 'border-slate-300');
    });
    
    event.target.classList.add('active', 'bg-sky-600', 'text-white');
    event.target.classList.remove('bg-white', 'text-slate-600', 'border', 'border-slate-300');
    
    // Filter articles
    articles.forEach(article => {
        if (kategori === 'all' || article.dataset.kategori === kategori) {
            article.style.display = 'block';
            setTimeout(() => {
                article.style.opacity = '1';
                article.style.transform = 'translateY(0)';
            }, 100);
        } else {
            article.style.opacity = '0';
            article.style.transform = 'translateY(20px)';
            setTimeout(() => {
                article.style.display = 'none';
            }, 300);
        }
    });
}

// Open article modal
function openArticle(articleId) {
    fetch(`/desa/pusat-bantuan/artikel/${articleId}`)
        .then(response => response.json())
        .then(data => {
            showArticleModal(data);
        });
}

function showArticleModal(article) {
    const modal = document.getElementById('articleModal');
    const content = document.getElementById('articleContent');
    
    content.innerHTML = `
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <span class="bg-white text-slate-700 text-sm font-medium px-3 py-1 rounded-full border">
                    ${article.kategori}
                </span>
            </div>
            <button onclick="closeArticleModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <img src="${article.gambar}" alt="${article.judul}" class="w-full h-64 object-cover rounded-xl mb-6">
        
        <h1 class="text-3xl font-bold text-slate-800 mb-4">${article.judul}</h1>
        
        <div class="flex items-center gap-4 text-sm text-slate-600 mb-6">
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                ${article.penulis}
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h8m-8 0a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2"></path>
                </svg>
                ${new Date(article.tanggal).toLocaleDateString('id-ID', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                })}
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                ${article.waktu_baca}
            </span>
        </div>
        
        <div class="prose prose-slate max-w-none">
            <p class="text-lg text-slate-700 leading-relaxed mb-6">${article.excerpt}</p>
            <p class="text-slate-700 leading-relaxed">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            </p>
            <p class="text-slate-700 leading-relaxed">
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. 
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.
            </p>
        </div>
        
        <div class="flex flex-wrap gap-2 mt-6">
            ${article.tags.map(tag => `<span class="text-xs text-sky-600 bg-sky-50 px-2 py-1 rounded-full">${tag}</span>`).join('')}
        </div>
    `;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeArticleModal() {
    const modal = document.getElementById('articleModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Submit laporan teknis
function submitLaporanTeknis(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    
    // Show loading state
    const submitBtn = event.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = `
        <span class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Mengirim...
        </span>
    `;
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        const ticketId = 'TKN-' + new Date().getFullYear() + 
                        String(new Date().getMonth() + 1).padStart(2, '0') + 
                        String(new Date().getDate()).padStart(2, '0') + '-' + 
                        Math.floor(Math.random() * 9000 + 1000);
        
        showToast(`✅ Laporan teknis berhasil dikirim! Nomor tiket: ${ticketId}. Tim teknis akan menindaklanjuti dalam 24 jam.`, 'success');
        event.target.reset();
        
        // Reset file input labels
        document.getElementById('screenshot1-info').textContent = 'Klik untuk upload';
        document.getElementById('screenshot2-info').textContent = 'Klik untuk upload';
        
        // Reset priority indicators
        document.querySelectorAll('.priority-indicator').forEach(indicator => {
            indicator.classList.remove('bg-sky-600', 'border-sky-600');
            indicator.classList.add('border-slate-300');
        });
        
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 2500);
}

// Handle file input changes for screenshots
document.addEventListener('change', function(e) {
    if (e.target.type === 'file' && e.target.name === 'screenshot[]') {
        const infoElement = document.getElementById(e.target.id + '-info');
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
            
            if (file.size > 5 * 1024 * 1024) { // 5MB limit
                showToast('Ukuran file maksimal 5MB', 'error');
                e.target.value = '';
                infoElement.textContent = 'Klik untuk upload';
                return;
            }
            
            infoElement.textContent = `${file.name} (${fileSize} MB)`;
            infoElement.className = 'text-sm text-emerald-600';
        } else {
            infoElement.textContent = 'Klik untuk upload';
            infoElement.className = 'text-sm text-slate-500';
        }
    }
});

// Handle priority radio buttons
document.addEventListener('change', function(e) {
    if (e.target.name === 'prioritas') {
        document.querySelectorAll('.priority-indicator').forEach(indicator => {
            indicator.classList.remove('bg-sky-600', 'border-sky-600');
            indicator.classList.add('border-slate-300');
        });
        
        const selectedIndicator = e.target.parentElement.querySelector('.priority-indicator');
        selectedIndicator.classList.add('bg-sky-600', 'border-sky-600');
        selectedIndicator.classList.remove('border-slate-300');
    }
});

// Filter riwayat
function filterRiwayat(status) {
    const rows = document.querySelectorAll('.riwayat-row');
    const filters = document.querySelectorAll('.riwayat-filter');
    
    // Update active filter
    filters.forEach(filter => {
        filter.classList.remove('active', 'bg-sky-600', 'text-white');
        filter.classList.add('bg-white', 'text-slate-600', 'border', 'border-slate-300');
    });
    
    event.target.classList.add('active', 'bg-sky-600', 'text-white');
    event.target.classList.remove('bg-white', 'text-slate-600', 'border', 'border-slate-300');
    
    // Filter rows
    rows.forEach(row => {
        if (status === 'semua' || row.dataset.status === status) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
}

// Show riwayat detail
function showRiwayatDetail(ticketId) {
    const modal = document.getElementById('riwayatModal');
    const content = document.getElementById('riwayatContent');
    
    // Simulate fetching detail data
    content.innerHTML = `
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-slate-800">Detail Laporan</h3>
            <button onclick="closeRiwayatModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="space-y-6">
            <div class="bg-slate-50 rounded-xl p-4">
                <div class="text-sm text-slate-600 mb-1">Nomor Tiket</div>
                <div class="font-mono text-lg font-semibold text-slate-800">${ticketId}</div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <div class="text-sm text-slate-600 mb-1">Status</div>
                    <span class="bg-emerald-100 text-emerald-800 text-sm font-medium px-3 py-1 rounded-full">Selesai</span>
                </div>
                <div>
                    <div class="text-sm text-slate-600 mb-1">Prioritas</div>
                    <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full">Tinggi</span>
                </div>
            </div>
            
            <div>
                <div class="text-sm text-slate-600 mb-2">Timeline Penanganan</div>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full mt-2"></div>
                        <div>
                            <div class="font-medium text-slate-800">Laporan Diterima</div>
                            <div class="text-sm text-slate-600">01 Des 2024, 09:00 WIB</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full mt-2"></div>
                        <div>
                            <div class="font-medium text-slate-800">Dalam Investigasi</div>
                            <div class="text-sm text-slate-600">01 Des 2024, 10:30 WIB</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full mt-2"></div>
                        <div>
                            <div class="font-medium text-slate-800">Masalah Teridentifikasi</div>
                            <div class="text-sm text-slate-600">01 Des 2024, 14:15 WIB</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full mt-2"></div>
                        <div>
                            <div class="font-medium text-slate-800">Perbaikan Selesai</div>
                            <div class="text-sm text-slate-600">01 Des 2024, 16:45 WIB</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <div class="font-medium text-emerald-800 mb-1">Resolusi</div>
                        <div class="text-sm text-emerald-700">
                            Masalah upload dokumen telah diperbaiki. Bug terjadi karena validasi file yang terlalu ketat. 
                            Sistem telah diperbarui dan sekarang dapat menerima berbagai format dokumen dengan ukuran hingga 10MB.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeRiwayatModal() {
    const modal = document.getElementById('riwayatModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Toast notification function
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 z-50 max-w-sm p-4 rounded-xl shadow-lg transform translate-y-full transition-transform duration-300 ${
        type === 'success' ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white'
    }`;
    toast.innerHTML = message;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.remove('translate-y-full');
    }, 100);
    
    setTimeout(() => {
        toast.classList.add('translate-y-full');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 5000);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    updateActiveHelpTab();
});
window.addEventListener('scroll', updateActiveHelpTab);
</script>
@endpush

@push('styles')
<style>
/* Line clamp utilities */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth transitions for articles */
.article-card {
    transition: all 0.3s ease-in-out;
}

/* Priority radio button styling */
input[type="radio"]:checked + .priority-indicator {
    background-color: rgb(2 132 199);
    border-color: rgb(2 132 199);
}

/* Scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Custom scrollbar for video carousel */
.overflow-x-auto::-webkit-scrollbar {
    height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: rgb(241 245 249);
    border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: rgb(148 163 184);
    border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: rgb(100 116 139);
}

/* Modal animations */
.modal-enter {
    animation: modalFadeIn 0.3s ease-out;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .help-nav-tab {
        font-size: 0.875rem;
        padding: 0.75rem 0.5rem;
    }
    
    .article-card,
    .tutorial-card,
    .video-card {
        margin-bottom: 1rem;
    }
    
    .grid.grid-cols-1.md\\:grid-cols-3 {
        gap: 1rem;
    }
    
    .grid.grid-cols-1.md\\:grid-cols-2 {
        gap: 1rem;
    }
}

/* Print styles */
@media print {
    .sticky,
    .fixed,
    button,
    .help-nav-tab {
        display: none !important;
    }
}
</style>
</script>

@endpush

@endsection