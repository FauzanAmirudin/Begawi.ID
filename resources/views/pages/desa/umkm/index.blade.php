@extends('layouts.desa')

@section('title', 'Produk UMKM - Desa Sejahtera')

@push('styles')
<style>
    .sticky-filter {
        position: sticky;
        top: 80px;
        z-index: 40;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .product-card .product-image {
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
    
    .category-pill.active {
        background: #166534;
        color: white;
        transform: scale(1.05);
    }
    
    .category-pill {
        transition: all 0.3s ease;
    }
    
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }
    
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    
    .wishlist-btn.active {
        color: #FACC15;
        animation: bounce 0.6s ease;
    }
    
    @keyframes bounce {
        0%, 20%, 60%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        80% { transform: translateY(-5px); }
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
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-green-50 to-amber-50 py-16">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="text-center">
            <h1 class="text-4xl lg:text-6xl font-display font-bold text-green-900 mb-4">
                🏪 Produk UMKM Desa
            </h1>
            <p class="text-lg lg:text-xl text-slate-600 max-w-3xl mx-auto">
                Temukan berbagai produk unggulan dari pelaku UMKM Desa Sejahtera. 
                Dukung ekonomi lokal dengan berbelanja produk berkualitas dari tetangga kita.
            </p>
        </div>
        
        <!-- Search Bar Hero -->
        <div class="max-w-2xl mx-auto mt-8">
            <div class="relative">
                <input type="text" placeholder="Cari produk UMKM..." 
                       class="w-full bg-white rounded-full shadow-lg px-6 py-4 pr-16 focus:ring-4 focus:ring-green-200 focus:outline-none text-lg border-2 border-transparent focus:border-green-600" 
                       id="heroSearch">
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-green-700 hover:bg-green-800 text-white p-3 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Sticky Filter Bar -->
<div class="sticky-filter border-b border-slate-200">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 py-4">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <!-- Category Pills -->
            <div class="flex flex-wrap gap-3 flex-1">
                @foreach($kategori as $index => $kat)
                <button class="category-pill px-5 py-2 rounded-full bg-green-100 text-green-800 hover:bg-green-600 hover:text-white transition-all text-sm font-medium {{ $index === 0 ? 'active' : '' }}" 
                        data-category="{{ $index === 0 ? 'semua' : Str::slug($kat) }}">
                    {{ $kat }}
                </button>
                @endforeach
            </div>
            
            <!-- Sort & View Controls -->
            <div class="flex items-center space-x-4">
                <!-- Sort Dropdown -->
                <select class="border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-700 focus:outline-none text-sm" id="sortSelect">
                    <option value="terbaru">Terbaru</option>
                    <option value="terpopuler">Terpopuler</option>
                    <option value="termurah">Termurah</option>
                    <option value="termahal">Termahal</option>
                    <option value="rating">Rating Tertinggi</option>
                </select>
                
                <!-- View Toggle -->
                <div class="flex items-center space-x-1 border border-slate-300 rounded-lg p-1">
                    <button class="view-toggle active p-2 rounded transition-colors" data-view="grid">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </button>
                    <button class="view-toggle p-2 rounded transition-colors" data-view="list">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
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
        <span class="text-green-700 font-medium">Produk UMKM</span>
    </nav>
</div>

<div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 pb-16">
    <!-- Stats Bar -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12 fade-in-up">
        <div class="bg-white rounded-xl p-6 shadow-md text-center border-l-4 border-green-600">
            <div class="text-3xl font-bold text-green-700 mb-2">{{ $produk_count }}</div>
            <div class="text-sm text-slate-600">Total Produk</div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md text-center border-l-4 border-blue-600">
            <div class="text-3xl font-bold text-blue-700 mb-2">{{ count($umkm_terdaftar) }}</div>
            <div class="text-sm text-slate-600">UMKM Terdaftar</div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md text-center border-l-4 border-yellow-600">
            <div class="text-3xl font-bold text-yellow-700 mb-2">{{ count($kategori) - 1 }}</div>
            <div class="text-sm text-slate-600">Kategori</div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md text-center border-l-4 border-pink-600">
            <div class="text-3xl font-bold text-pink-700 mb-2">{{ count($produk_unggulan) }}</div>
            <div class="text-sm text-slate-600">Produk Unggulan</div>
        </div>
    </div>

    <!-- Featured Products -->
    @if(count($produk_unggulan) > 0)
    <section class="mb-16 fade-in-up">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-display font-bold text-green-900 border-b-4 border-yellow-400 inline-block pb-2">
                ⭐ Produk Unggulan
            </h2>
            <a href="#" class="text-green-700 hover:text-green-800 font-medium">Lihat Semua →</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach(array_slice($produk_unggulan, 0, 4) as $item)
            <div class="product-card bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                
                <!-- Wishlist Button -->
                <button class="absolute top-3 right-3 wishlist-btn p-2 bg-white/80 rounded-full hover:bg-white transition-colors z-10" 
                        onclick="toggleWishlist(this)">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
                
                <div class="aspect-square overflow-hidden">
                    <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}" 
                         class="product-image w-full h-full object-cover">
                </div>
                
                <div class="p-5">
                    <div class="mb-2">
                        <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">{{ $item['kategori'] }}</span>
                    </div>
                    <h3 class="text-lg font-display font-semibold text-green-900 mb-2 line-clamp-2 group-hover:text-green-700 transition-colors">
                        {{ $item['nama'] }}
                    </h3>
                    <p class="text-sm text-slate-500 mb-2">{{ $item['umkm']['nama'] }}</p>
                    
                    <!-- Rating & Sales -->
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-sm text-slate-600">{{ $item['rating'] }}</span>
                        </div>
                        <span class="text-xs text-slate-500">{{ $item['terjual'] }} terjual</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-green-700 font-bold text-lg">{{ $item['harga_format'] }}</span>
                        <span class="text-xs text-slate-500">Stok: {{ $item['stok'] }}</span>
                    </div>
                    
                    <a href="{{ route('desa.umkm.detail', $item['slug']) }}" 
                       class="block mt-4 bg-yellow-400 hover:bg-yellow-500 text-green-900 font-semibold text-center py-2 rounded-xl transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- UMKM Terdaftar Section -->
    @if(count($umkm_terdaftar) > 0)
    <section class="mb-16 fade-in-up">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-display font-bold text-green-900 border-b-4 border-yellow-400 inline-block pb-2">
                🏢 UMKM Terdaftar
            </h2>
            <a href="#" class="text-green-700 hover:text-green-800 font-medium">Lihat Semua →</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($umkm_terdaftar as $umkm)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="p-6">
                    <!-- Logo UMKM -->
                    <div class="flex justify-center mb-4">
                        <div class="w-24 h-24 rounded-full overflow-hidden bg-green-50 border-4 border-green-100 group-hover:border-green-300 transition-colors">
                            <img src="{{ $umkm['logo'] }}" alt="{{ $umkm['nama'] }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>
                    
                    <!-- Info UMKM -->
                    <div class="text-center">
                        <h3 class="text-lg font-display font-semibold text-green-900 mb-2 group-hover:text-green-700 transition-colors line-clamp-2">
                            {{ $umkm['nama'] }}
                        </h3>
                        
                        <div class="mb-3">
                            <span class="text-xs text-green-600 bg-green-50 px-3 py-1 rounded-full font-medium">
                                {{ $umkm['kategori'] }}
                            </span>
                        </div>
                        
                        <!-- Rating & Produk Count -->
                        <div class="flex items-center justify-center space-x-4 mb-4">
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-slate-600 font-medium">{{ $umkm['rating'] }}</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span class="text-sm text-slate-500">{{ $umkm['produk_count'] }} produk</span>
                            </div>
                        </div>
                        
                        <!-- Button -->
                        <a href="{{ route('desa.umkm.toko', $umkm['slug']) }}" 
                           class="block w-full bg-green-100 hover:bg-green-200 text-green-800 font-semibold text-center py-2.5 rounded-xl transition-colors">
                            Kunjungi Toko
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- All Products -->
    <section class="fade-in-up">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-display font-bold text-green-900 border-b-4 border-yellow-400 inline-block pb-2">
                🛍️ Semua Produk
            </h2>
        </div>
        
        <!-- Grid View -->
        <div id="gridView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($produk as $item)
            <div class="product-card bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group" 
                 data-category="{{ Str::slug($item['kategori']) }}" 
                 data-price="{{ $item['harga'] }}" 
                 data-rating="{{ $item['rating'] }}" 
                 data-sales="{{ $item['terjual'] }}">
                
                <button class="absolute top-3 right-3 wishlist-btn p-2 bg-white/80 rounded-full hover:bg-white transition-colors z-10" 
                        onclick="toggleWishlist(this)">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
                
                <div class="aspect-square overflow-hidden">
                    <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}" 
                         class="product-image w-full h-full object-cover">
                </div>
                
                <div class="p-5">
                    <div class="mb-2">
                        <span class="text-xs text-slate-600 bg-slate-100 px-2 py-1 rounded-full">{{ $item['kategori'] }}</span>
                    </div>
                    <h3 class="text-lg font-display font-semibold text-slate-800 mb-2 line-clamp-2 group-hover:text-green-700 transition-colors">
                        {{ $item['nama'] }}
                    </h3>
                    <p class="text-sm text-slate-500 mb-2">{{ $item['umkm']['nama'] }}</p>
                    
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-sm text-slate-600">{{ $item['rating'] }}</span>
                        </div>
                        <span class="text-xs text-slate-500">{{ $item['terjual'] }} terjual</span>
                    </div>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-green-700 font-bold text-lg">{{ $item['harga_format'] }}</span>
                        <span class="text-xs text-slate-500">Stok: {{ $item['stok'] }}</span>
                    </div>
                    
                    <a href="{{ route('desa.umkm.detail', $item['slug']) }}" 
                       class="block bg-green-100 hover:bg-green-200 text-green-800 font-medium text-center py-2 rounded-xl transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- List View (Hidden by default) -->
        <div id="listView" class="space-y-6 hidden">
            @foreach($produk as $item)
            <div class="product-card bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden" 
                 data-category="{{ Str::slug($item['kategori']) }}" 
                 data-price="{{ $item['harga'] }}" 
                 data-rating="{{ $item['rating'] }}" 
                 data-sales="{{ $item['terjual'] }}">
                <div class="flex flex-col sm:flex-row">
                    <div class="sm:w-1/4 aspect-square sm:aspect-auto overflow-hidden relative">
                        @if($item['unggulan'])
                        <div class="absolute top-3 left-3 bg-yellow-400 text-green-900 text-xs px-2 py-1 rounded-full font-bold z-10">
                            ⭐ Unggulan
                        </div>
                        @endif
                        <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}" 
                             class="product-image w-full h-full object-cover">
                    </div>
                    <div class="flex-1 p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <span class="text-xs text-slate-600 bg-slate-100 px-2 py-1 rounded-full">{{ $item['kategori'] }}</span>
                                <h3 class="text-xl font-display font-semibold text-slate-800 mt-2 mb-1 hover:text-green-700 transition-colors">
                                    {{ $item['nama'] }}
                                </h3>
                                <p class="text-sm text-slate-500 mb-2">{{ $item['umkm']['nama'] }}</p>
                            </div>
                            <button class="wishlist-btn p-2 hover:bg-slate-100 rounded-full transition-colors" 
                                    onclick="toggleWishlist(this)">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <p class="text-slate-600 mb-4 line-clamp-2">{{ Str::limit($item['deskripsi'], 120) }}</p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <span class="text-green-700 font-bold text-xl">{{ $item['harga_format'] }}</span>
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-sm text-slate-600">{{ $item['rating'] }}</span>
                                    <span class="text-sm text-slate-500">• {{ $item['terjual'] }} terjual</span>
                                </div>
                            </div>
                            <a href="{{ route('desa.umkm.detail', $item['slug']) }}" 
                               class="bg-yellow-400 hover:bg-yellow-500 text-green-900 font-semibold px-6 py-2 rounded-xl transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Pagination -->
    @if($produk->hasPages())
    <div class="flex justify-center mt-12">
        <nav class="flex items-center space-x-2">
            <a 
                href="{{ $produk->previousPageUrl() }}" 
                class="px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors {{ $produk->onFirstPage() ? 'opacity-50 pointer-events-none' : '' }}"
                aria-label="Halaman sebelumnya"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            
            @foreach ($produk->getUrlRange(1, $produk->lastPage()) as $page => $url)
                <a 
                    href="{{ $url }}" 
                    class="px-4 py-2 rounded-lg border border-slate-300 transition-colors {{ $page == $produk->currentPage() ? 'bg-green-700 text-white border-green-700' : 'hover:bg-green-700 hover:text-white' }}"
                >
                    {{ $page }}
                </a>
            @endforeach
            
            <a 
                href="{{ $produk->nextPageUrl() }}" 
                class="px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors {{ $produk->currentPage() == $produk->lastPage() ? 'opacity-50 pointer-events-none' : '' }}"
                aria-label="Halaman selanjutnya"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </nav>
    </div>
    @endif
</div>

<!-- CTA Section -->
<section class="bg-green-800 text-white py-16 mt-16">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 text-center">
        <div class="bg-green-900 rounded-3xl p-10">
            <h2 class="text-4xl font-display font-bold mb-4">
                🚀 Daftarkan UMKM Anda Sekarang!
            </h2>
            <p class="text-green-100 text-lg mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan marketplace lokal Desa Sejahtera. Jangkau lebih banyak pelanggan 
                dan kembangkan bisnis Anda bersama komunitas desa.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#" class="bg-yellow-400 hover:bg-yellow-500 text-green-900 px-8 py-4 rounded-xl font-semibold shadow-lg transition-colors inline-flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Daftar UMKM
                </a>
                <a href="{{ route('desa.contact') }}" class="border-2 border-white text-white hover:bg-white hover:text-green-900 px-8 py-4 rounded-xl font-semibold transition-colors inline-flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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

    // Category filter
    const categoryPills = document.querySelectorAll('.category-pill');
    const productCards = document.querySelectorAll('.product-card');
    
    categoryPills.forEach(pill => {
        pill.addEventListener('click', function() {
            // Remove active class from all pills
            categoryPills.forEach(p => p.classList.remove('active'));
            // Add active class to clicked pill
            this.classList.add('active');
            
            const category = this.getAttribute('data-category');
            filterProducts(category);
        });
    });
    
    // View toggle
    const viewToggleButtons = document.querySelectorAll('.view-toggle');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    
    viewToggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const view = this.getAttribute('data-view');
            
            viewToggleButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            if (view === 'grid') {
                gridView.classList.remove('hidden');
                listView.classList.add('hidden');
            } else {
                gridView.classList.add('hidden');
                listView.classList.remove('hidden');
            }
        });
    });
    
    // Sort functionality
    const sortSelect = document.getElementById('sortSelect');
    sortSelect.addEventListener('change', function() {
        sortProducts(this.value);
    });
    
    // Search functionality
    const searchInput = document.getElementById('heroSearch');
    searchInput.addEventListener('input', function() {
        searchProducts(this.value);
    });
});

// Filter products by category
function filterProducts(category) {
    const productCards = document.querySelectorAll('.product-card');
    let visibleCount = 0;
    
    productCards.forEach(card => {
        const cardCategory = card.getAttribute('data-category');
        
        if (category === 'semua' || cardCategory === category) {
            card.style.display = 'block';
            card.classList.add('fade-in-up');
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    document.getElementById('productCount').textContent = visibleCount;
}

// Sort products
function sortProducts(sortBy) {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const currentView = gridView.classList.contains('hidden') ? listView : gridView;
    
    const cards = Array.from(currentView.querySelectorAll('.product-card:not([style*="display: none"])'));
    
    cards.sort((a, b) => {
        switch(sortBy) {
            case 'termurah':
                return parseInt(a.getAttribute('data-price')) - parseInt(b.getAttribute('data-price'));
            case 'termahal':
                return parseInt(b.getAttribute('data-price')) - parseInt(a.getAttribute('data-price'));
            case 'rating':
                return parseFloat(b.getAttribute('data-rating')) - parseFloat(a.getAttribute('data-rating'));
            case 'terpopuler':
                return parseInt(b.getAttribute('data-sales')) - parseInt(a.getAttribute('data-sales'));
            default: // terbaru
                return 0;
        }
    });
    
    // Re-append sorted cards
    cards.forEach(card => currentView.appendChild(card));
}

// Search products
function searchProducts(query) {
    const productCards = document.querySelectorAll('.product-card');
    let visibleCount = 0;
    
    productCards.forEach(card => {
        const productName = card.querySelector('h3').textContent.toLowerCase();
        const umkmName = card.querySelector('p').textContent.toLowerCase();
        
        if (productName.includes(query.toLowerCase()) || umkmName.includes(query.toLowerCase()) || query === '') {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    document.getElementById('productCount').textContent = visibleCount;
}

// Toggle wishlist
function toggleWishlist(button) {
    button.classList.toggle('active');
    const svg = button.querySelector('svg');
    
    if (button.classList.contains('active')) {
        svg.setAttribute('fill', 'currentColor');
        // Show toast notification
        showToast('Ditambahkan ke wishlist!');
    } else {
        svg.setAttribute('fill', 'none');
        showToast('Dihapus dari wishlist!');
    }
}

// Show toast notification
function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-green-800 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-y-full opacity-0 transition-all duration-300';
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Show toast
    setTimeout(() => {
        toast.classList.remove('translate-y-full', 'opacity-0');
    }, 100);
    
    // Hide toast after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-y-full', 'opacity-0');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}
</script>
@endpush