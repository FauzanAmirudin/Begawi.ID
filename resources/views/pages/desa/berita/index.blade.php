@extends('layouts.desa')

@section('title', 'Berita - Desa Sejahtera')

@push('styles')
<style>
    .sticky-subnav {
        position: sticky;
        top: 80px;
        z-index: 40;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }
    
    .view-toggle.active {
        background: #166534;
        color: white;
    }
    
    .search-highlight {
        background: linear-gradient(120deg, #FACC15 0%, #FACC15 100%);
        background-repeat: no-repeat;
        background-size: 100% 0.2em;
        background-position: 0 88%;
    }
    
    .news-card:hover .news-image {
        transform: scale(1.05);
    }
    
    .news-card .news-image {
        transition: transform 0.3s ease;
    }
    
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }
    
    .fade-in-up.visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        border-top: 1px solid #e2e8f0;
        z-index: 50;
    }
    
    @media (min-width: 768px) {
        .bottom-nav {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-green-50 to-amber-50 py-16">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="text-center">
            <h1 class="text-4xl lg:text-6xl font-display font-bold text-green-900 mb-4">
                Berita & Informasi
            </h1>
            <p class="text-lg lg:text-xl text-slate-600 max-w-3xl mx-auto">
                Dapatkan informasi terkini seputar kegiatan, pembangunan, dan perkembangan Desa Sejahtera
            </p>
        </div>
    </div>
</section>

<!-- Sticky Sub Navigation -->
<div class="sticky-subnav border-b border-slate-200">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between py-4">
            <!-- Tab Navigation -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('desa.berita.index') }}" class="text-green-700 font-semibold border-b-2 border-green-700 pb-2">
                    📰 Berita
                </a>
                <a href="{{ route('desa.berita.agenda') }}" class="text-slate-600 hover:text-green-700 font-medium pb-2 transition-colors">
                    📅 Agenda
                </a>
            </div>
            
            <!-- Search Bar -->
            <div class="hidden md:flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Cari berita..." 
                           class="w-80 bg-white rounded-full shadow-sm px-5 py-3 pr-12 focus:ring-2 focus:ring-green-700 focus:outline-none border border-slate-200">
                    <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-500 hover:text-green-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Breadcrumb -->
<div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 py-4">
    <nav class="text-sm text-slate-600">
        <a href="{{ route('desa.home') }}" class="hover:text-green-700">Beranda</a>
        <span class="mx-2">/</span>
        <span class="text-green-700 font-medium">Berita</span>
    </nav>
</div>

<div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 pb-20">
    <div class="grid grid-cols-12 gap-8">
        <!-- Main Content -->
        <main class="col-span-12 lg:col-span-8">
            <!-- Filter & View Toggle -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <!-- Category Filter -->
                <div class="flex items-center space-x-4">
                    <span class="text-slate-600 font-medium">Filter:</span>
                    <select class="border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-700 focus:outline-none" id="categoryFilter">
                        @foreach($kategori as $kat)
                        <option value="{{ $kat }}">{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- View Toggle -->
                <div class="flex items-center space-x-2">
                    <span class="text-slate-600 text-sm">Tampilan:</span>
                    <button class="view-toggle active p-2 rounded-lg border transition-colors" data-view="grid">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </button>
                    <button class="view-toggle p-2 rounded-lg border transition-colors" data-view="list">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Featured News -->
            @if(collect($berita)->where('featured', true)->count() > 0)
            <section class="mb-12">
                <h2 class="text-2xl font-display font-bold text-green-900 mb-6 border-b-4 border-yellow-400 inline-block pb-2">
                    🌟 Berita Utama
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach(collect($berita)->where('featured', true)->take(2) as $item)
                    <article class="news-card bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group fade-in-up">
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ $item['thumbnail'] }}" alt="{{ $item['judul'] }}" 
                                 class="news-image w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">
                                    {{ $item['kategori'] }}
                                </span>
                                <span class="text-sm text-slate-500">
                                    {{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}
                                </span>
                            </div>
                            <h3 class="text-xl font-display font-semibold text-slate-800 mb-3 group-hover:text-green-700 transition-colors line-clamp-2">
                                {{ $item['judul'] }}
                            </h3>
                            <p class="text-slate-600 mb-4 leading-relaxed line-clamp-3">
                                {{ $item['ringkasan'] }}
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-slate-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ $item['views'] }} views
                                </div>
                                <a href="{{ route('desa.berita.detail', $item['slug']) }}" 
                                   class="text-green-700 font-semibold hover:text-green-800 transition-colors">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- All News -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-display font-bold text-green-900 border-b-4 border-yellow-400 inline-block pb-2">
                        📰 Semua Berita
                    </h2>
                    <a href="{{ route('desa.berita.arsip') }}" class="text-green-700 hover:text-green-800 font-medium text-sm">
                        Lihat Arsip →
                    </a>
                </div>
                
                <!-- Grid View -->
                <div id="gridView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(collect($berita)->where('featured', false) as $item)
                    <article class="news-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 group fade-in-up">
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ $item['thumbnail'] }}" alt="{{ $item['judul'] }}" 
                                 class="news-image w-full h-full object-cover">
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-2">
                                <span class="bg-slate-100 text-slate-700 text-xs px-2 py-1 rounded-full">
                                    {{ $item['kategori'] }}
                                </span>
                                <span class="text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}
                                </span>
                            </div>
                            <h3 class="text-lg font-display font-semibold text-slate-800 mb-2 group-hover:text-green-700 transition-colors line-clamp-2">
                                {{ $item['judul'] }}
                            </h3>
                            <p class="text-slate-600 text-sm mb-3 leading-relaxed line-clamp-2">
                                {{ $item['ringkasan'] }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-slate-500">{{ $item['views'] }} views</span>
                                <a href="{{ route('desa.berita.detail', $item['slug']) }}" 
                                   class="text-green-700 text-sm font-medium hover:text-green-800 transition-colors">
                                    Baca →
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
                
                <!-- List View (Hidden by default) -->
                <div id="listView" class="space-y-6 hidden">
                    @foreach(collect($berita)->where('featured', false) as $item)
                    <article class="news-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 group">
                        <div class="flex flex-col sm:flex-row">
                            <div class="sm:w-1/3 aspect-video sm:aspect-auto overflow-hidden">
                                <img src="{{ $item['thumbnail'] }}" alt="{{ $item['judul'] }}" 
                                     class="news-image w-full h-full object-cover">
                            </div>
                            <div class="flex-1 p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="bg-slate-100 text-slate-700 text-xs px-3 py-1 rounded-full">
                                        {{ $item['kategori'] }}
                                    </span>
                                    <span class="text-sm text-slate-500">
                                        {{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-display font-semibold text-slate-800 mb-3 group-hover:text-green-700 transition-colors">
                                    {{ $item['judul'] }}
                                </h3>
                                <p class="text-slate-600 mb-4 leading-relaxed line-clamp-2">
                                    {{ $item['ringkasan'] }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-slate-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ $item['views'] }} views
                                    </div>
                                    <a href="{{ route('desa.berita.detail', $item['slug']) }}" 
                                       class="text-green-700 font-semibold hover:text-green-800 transition-colors">
                                        Baca Selengkapnya →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>

            <!-- Pagination -->
            <div class="flex justify-center mt-12">
                <nav class="flex items-center space-x-2">
                    <button class="px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="px-4 py-2 bg-green-700 text-white rounded-lg">1</button>
                    <button class="px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">2</button>
                    <button class="px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">3</button>
                    <button class="px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </nav>
            </div>
        </main>

        <!-- Sidebar -->
        <aside class="col-span-12 lg:col-span-4">
            <!-- Search (Mobile) -->
            <div class="md:hidden mb-6">
                <div class="relative">
                    <input type="text" placeholder="Cari berita..." 
                           class="w-full bg-white rounded-lg shadow-sm px-4 py-3 pr-12 focus:ring-2 focus:ring-green-700 focus:outline-none border border-slate-200">
                    <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Popular News -->
            <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
                <h3 class="text-xl font-display font-bold text-green-900 mb-6 border-b-2 border-yellow-400 pb-2">
                    🔥 Berita Populer
                </h3>
                <div class="space-y-4">
                    @foreach($berita_populer as $index => $item)
                    <article class="flex items-start space-x-4 group">
                        <span class="flex-shrink-0 w-8 h-8 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-sm font-bold">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-slate-800 group-hover:text-green-700 transition-colors line-clamp-2 mb-1">
                                <a href="{{ route('desa.berita.detail', $item['slug']) }}">{{ $item['judul'] }}</a>
                            </h4>
                            <div class="flex items-center text-xs text-slate-500">
                                <span>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $item['views'] }} views</span>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>

            <!-- Categories -->
            <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
                <h3 class="text-xl font-display font-bold text-green-900 mb-6 border-b-2 border-yellow-400 pb-2">
                    📂 Kategori
                </h3>
                <div class="space-y-2">
                    @foreach(array_slice($kategori, 1) as $kat)
                    <a href="#" class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-green-50 transition-colors group">
                        <span class="text-slate-700 group-hover:text-green-700">{{ $kat }}</span>
                        <span class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-full">{{ rand(3, 15) }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-green-50 rounded-2xl p-6">
                <h3 class="text-xl font-display font-bold text-green-900 mb-6">
                    🔗 Tautan Cepat
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('desa.berita.agenda') }}" class="flex items-center space-x-3 text-slate-700 hover:text-green-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Agenda Kegiatan</span>
                    </a>
                    <a href="{{ route('desa.layanan.index') }}" class="flex items-center space-x-3 text-slate-700 hover:text-green-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>Hubungi Kami</span>
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>

<!-- Mobile Bottom Navigation -->
<div class="bottom-nav md:hidden">
    <div class="flex items-center justify-around py-3">
        <a href="{{ route('desa.berita.agenda') }}" class="flex flex-col items-center space-y-1 text-slate-600 hover:text-green-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="text-xs">Agenda</span>
        </a>
        <a href="{{ route('desa.berita.index') }}" class="flex flex-col items-center space-y-1 text-green-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <span class="text-xs font-medium">Berita</span>
        </a>
        <a href="{{ route('desa.berita.arsip') }}" class="flex flex-col items-center space-y-1 text-slate-600 hover:text-green-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
            </svg>
            <span class="text-xs">Arsip</span>
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
// View Toggle
document.addEventListener('DOMContentLoaded', function() {
    const viewToggleButtons = document.querySelectorAll('.view-toggle');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    
    viewToggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const view = this.getAttribute('data-view');
            
            // Remove active class from all buttons
            viewToggleButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            // Toggle views
            if (view === 'grid') {
                gridView.classList.remove('hidden');
                listView.classList.add('hidden');
            } else {
                gridView.classList.add('hidden');
                listView.classList.remove('hidden');
            }
        });
    });
    
    // Category Filter
    const categoryFilter = document.getElementById('categoryFilter');
    categoryFilter.addEventListener('change', function() {
        // Here you would implement the filtering logic
        console.log('Filter changed to:', this.value);
    });
    
    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.fade-in-up').forEach(el => {
        observer.observe(el);
    });
    
    // Search functionality
    const searchInputs = document.querySelectorAll('input[type="text"]');
    searchInputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                // Implement search logic here
                console.log('Searching for:', this.value);
            }
        });
    });
});
</script>
@endpush