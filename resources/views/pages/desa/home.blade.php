@extends('layouts.desa')

@section('title', 'Beranda - Desa Sejahtera')

@push('styles')
<style>
    /* Lightbox Styles */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.95);
        overflow: auto;
    }
    
    .lightbox.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .lightbox-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        margin: auto;
    }
    
    .lightbox-image {
        max-width: 100%;
        max-height: 90vh;
        object-fit: contain;
    }
    
    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        z-index: 10000;
    }
    
    .lightbox-close:hover {
        color: #FACC15;
    }
    
    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: none;
        padding: 1rem;
        cursor: pointer;
        font-size: 24px;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .lightbox-nav:hover {
        background: rgba(255, 255, 255, 0.3);
        color: #FACC15;
    }
    
    .lightbox-prev {
        left: 20px;
    }
    
    .lightbox-next {
        right: 20px;
    }
    
    .lightbox-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
        color: #fff;
        padding: 2rem;
        text-align: center;
    }
</style>
@endpush

@section('content')
    <!-- 1. Hero Section -->
    <section class="bg-gradient-light py-20">
        <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
            <div class="grid grid-cols-12 items-center gap-8">
                <!-- Left Content -->
                <div class="col-span-12 lg:col-span-7 animate-fadeInUp">
                    <div class="flex items-center space-x-4 mb-6 animate-scaleIn">
                        <img src="{{ asset('images/Logo-Begawi.png') }}" alt="Logo Desa"
                            class="w-20 h-20 object-contain shadow-lg">
                        <div>
                            <h1 class="text-4xl lg:text-6xl font-display font-bold text-primary-700 leading-tight">
                                Desa Sejahtera
                            </h1>
                            <p class="text-base lg:text-lg text-slate-600 mt-2">
                                Membangun Masa Depan Bersama
                            </p>
                        </div>
                    </div>

                    <p class="text-base lg:text-lg text-slate-600 mb-8 leading-relaxed">
                        Selamat datang di website resmi Desa Sejahtera. Kami berkomitmen untuk memberikan pelayanan terbaik
                        kepada seluruh warga dan mengembangkan potensi desa melalui inovasi dan gotong royong.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('desa.about') }}"
                            class="bg-gradient-accent hover:bg-primary-700 text-white px-8 py-4 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all duration-300 text-center">
                            Lihat Profil Desa
                        </a>
                    </div>
                </div>

                <!-- Right Content - Slideshow -->
                <div class="col-span-12 lg:col-span-5">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <div class="aspect-[4/3] bg-gradient-to-br from-primary-700/20 to-transparent relative">
                            <img src="{{ asset('images/gotong-royong.jpg') }}" alt="Kegiatan Desa"
                                class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy-900/30 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <h3 class="font-semibold text-lg">Gotong Royong Membangun Desa</h3>
                                <p class="text-sm opacity-90">Kebersamaan warga dalam pembangunan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Berita Terbaru -->
    <section class="py-20 bg-white">
        <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
            <div class="text-center mb-16">
                <h2
                    class="text-3xl lg:text-4xl font-display font-bold text-primary-700 border-b-4 border-primary-500 inline-block pb-2">
                    Berita Terbaru
                </h2>
                <p class="text-slate-600 mt-4 text-lg">Informasi terkini seputar kegiatan dan perkembangan desa</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($berita as $item)
                    <article
                        class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group">
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ $item['thumbnail'] }}" alt="{{ $item['judul'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-6">
                            <div class="text-sm text-primary-600 font-medium mb-2">
                                {{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}
                            </div>
                            <h3
                                class="text-xl font-display font-semibold text-slate-800 mb-3 group-hover:text-primary-600 transition-colors">
                                {{ $item['judul'] }}
                            </h3>
                            <p class="text-slate-600 mb-4 leading-relaxed">
                                {{ $item['ringkasan'] }}
                            </p>
                            <a href="{{ route('desa.berita.detail', $item['slug'] ?? '#') }}"
                                class="inline-flex items-center text-primary-600 font-semibold hover:text-primary-700 transition-colors">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('desa.berita.index') }}"
                    class="bg-gradient-accent hover:bg-primary-700 text-white px-8 py-3 rounded-xl font-semibold transition-colors">
                    Lihat Semua Berita
                </a>
            </div>
        </div>
    </section>

    <!-- 4. Produk UMKM Populer -->
    <section class="py-20 bg-white">
        <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-display font-bold text-primary-700">Produk UMKM Populer</h2>
                <p class="text-slate-600 mt-4 text-lg">Produk-produk paling diminati oleh masyarakat</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($umkm_populer as $produk)
                    <div
                        class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group relative">
                        <!-- Badge Populer -->
                        <div
                            class="absolute top-3 right-3 bg-primary-500 text-xs font-bold text-white rounded-full px-3 py-1 z-10">
                            🔥 Populer
                        </div>

                        <div class="aspect-square overflow-hidden">
                            <img src="{{ $produk['gambar'] }}" alt="{{ $produk['nama'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>

                        <div class="p-5">
                            <h3 class="font-display font-semibold text-lg text-slate-800 mb-1">{{ $produk['nama'] }}</h3>
                            <p class="text-xs text-slate-500 mb-2">{{ $produk['umkm'] }}</p>

                            <!-- Rating -->
                            <div class="flex items-center gap-1 mb-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($produk['rating']))
                                        <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                                <span class="text-sm text-slate-600 ml-1">({{ $produk['rating'] }})</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-primary-600 font-bold text-lg">{{ $produk['harga'] }}</span>
                                <a href="{{ route('desa.umkm.detail', $produk['slug'] ?? '#') }}"
                                    class="bg-gradient-accent hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Beli Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. Galeri Terbaru -->
    <section class="py-20 bg-slate-100">
        <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-display font-bold text-primary-700">Galeri Terbaru</h2>
                <p class="text-slate-600 mt-4 text-lg">Dokumentasi kegiatan dan momen berharga di desa</p>
            </div>

            <div class="flex justify-center">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl">
                    @foreach ($galeri as $item)
                        <div class="gallery-item group cursor-pointer" 
                             data-image="{{ $item['gambar'] }}"
                             data-title="{{ $item['judul'] }}"
                             data-description="{{ $item['deskripsi'] ?? '' }}">
                            <div class="relative rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow aspect-[4/3]">
                                <img src="{{ $item['gambar'] }}" alt="{{ $item['judul'] }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div
                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-slate-600 mt-2 text-center px-2">{{ $item['judul'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('desa.galeri-wisata.index') }}"
                    class="bg-gradient-accent hover:bg-primary-700 text-white px-8 py-3 rounded-xl font-semibold transition-colors">
                    Lihat Semua Foto
                </a>
            </div>
        </div>
    </section>

    <!-- 6. Wisata Populer -->
    <section class="py-20 bg-white">
        <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-display font-bold text-primary-700">Wisata Populer</h2>
                <p class="text-slate-600 mt-4 text-lg">Destinasi wisata menarik yang wajib dikunjungi</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($wisata as $tempat)
                    <div
                        class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group">
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ $tempat['gambar'] }}" alt="{{ $tempat['nama'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-display font-bold text-primary-700 mb-3">{{ $tempat['nama'] }}</h3>
                            <p class="text-slate-600 mb-4 leading-relaxed">{{ $tempat['deskripsi'] }}</p>
                            <a href="{{ route('desa.galeri-wisata.index') }}"
                                class="w-full bg-gradient-accent hover:bg-primary-700 text-white py-3 rounded-xl font-semibold transition-colors inline-block text-center">
                                Lihat Detail Wisata
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('desa.galeri-wisata.index') }}"
                    class="bg-gradient-accent hover:bg-primary-700 text-white px-8 py-3 rounded-xl font-semibold transition-colors">
                    Jelajahi Semua Wisata
                </a>
            </div>
        </div>
    </section>

    <!-- 7. Kalender Kegiatan Desa -->
    <section class="py-20 bg-gradient-light">
        <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-display font-bold text-primary-700">Kalender Kegiatan Desa</h2>
                <p class="text-slate-600 mt-4 text-lg">Jadwal kegiatan dan acara yang akan datang</p>
            </div>

            <!-- Desktop Calendar View -->
            <div class="hidden lg:block bg-white rounded-2xl shadow-lg p-8">
                @php
                    $currentMonth = now()->month;
                    $currentYear = now()->year;
                    $firstDay = \Carbon\Carbon::create($currentYear, $currentMonth, 1);
                    $lastDay = $firstDay->copy()->endOfMonth();
                    $startDate = $firstDay->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
                    $endDate = $lastDay->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);
                    
                    // Group kegiatan by date
                    $kegiatanByDate = collect($kegiatan)->groupBy('tanggal');
                @endphp
                
                <div class="mb-6 text-center">
                    <h3 class="text-xl font-bold text-slate-800">
                        {{ $firstDay->format('F Y') }}
                    </h3>
                </div>
                
                <div class="grid grid-cols-7 gap-4 mb-8">
                    <div class="text-center font-semibold text-slate-700 py-3">Minggu</div>
                    <div class="text-center font-semibold text-slate-700 py-3">Senin</div>
                    <div class="text-center font-semibold text-slate-700 py-3">Selasa</div>
                    <div class="text-center font-semibold text-slate-700 py-3">Rabu</div>
                    <div class="text-center font-semibold text-slate-700 py-3">Kamis</div>
                    <div class="text-center font-semibold text-slate-700 py-3">Jumat</div>
                    <div class="text-center font-semibold text-slate-700 py-3">Sabtu</div>

                    @php
                        $currentDate = $startDate->copy();
                    @endphp
                    @while($currentDate <= $endDate)
                        @php
                            $isCurrentMonth = $currentDate->month == $currentMonth;
                            $isToday = $currentDate->isToday();
                            $dateString = $currentDate->toDateString();
                            $dayKegiatan = $kegiatanByDate->get($dateString, collect());
                        @endphp
                        <div class="aspect-square border border-slate-200 rounded-lg p-2 hover:bg-slate-50 transition-colors {{ $isToday ? 'bg-primary-50 border-primary-300' : '' }} {{ !$isCurrentMonth ? 'opacity-40' : '' }}">
                            <div class="text-sm font-medium {{ $isToday ? 'text-primary-700 font-bold' : 'text-slate-700' }}">
                                {{ $currentDate->day }}
                            </div>
                            @if($dayKegiatan->isNotEmpty())
                                <div class="mt-1 space-y-1">
                                    @foreach($dayKegiatan->take(2) as $kegiatanItem)
                                        @php
                                            $categoryClass = match(strtolower($kegiatanItem['kategori'])) {
                                                'rapat' => 'bg-primary-200 text-primary-800',
                                                'pelatihan' => 'bg-primary-300 text-primary-800',
                                                'acara' => 'bg-primary-400 text-white',
                                                'kesehatan' => 'bg-pink-200 text-pink-800',
                                                default => 'bg-slate-200 text-slate-800',
                                            };
                                        @endphp
                                        <div class="{{ $categoryClass }} text-xs px-2 py-0.5 rounded truncate" title="{{ $kegiatanItem['judul'] }}">
                                            {{ $kegiatanItem['kategori'] }}
                                        </div>
                                    @endforeach
                                    @if($dayKegiatan->count() > 2)
                                        <div class="text-xs text-slate-500 text-center">
                                            +{{ $dayKegiatan->count() - 2 }} lagi
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @php
                            $currentDate->addDay();
                        @endphp
                    @endwhile
                </div>
            </div>

            <!-- Mobile List View -->
            <div class="lg:hidden space-y-4">
                @foreach ($kegiatan as $acara)
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                        <div class="flex items-start space-x-4">
                            <div class="text-center min-w-[60px]">
                                <div class="text-2xl font-bold text-green-700">
                                    {{ \Carbon\Carbon::parse($acara['tanggal'])->format('d') }}
                                </div>
                                <div class="text-sm text-slate-600">
                                    {{ \Carbon\Carbon::parse($acara['tanggal'])->format('M') }}
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-display font-semibold text-lg text-slate-800 mb-2">{{ $acara['judul'] }}
                                </h3>
                                <div class="flex items-center text-sm text-slate-600 mb-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $acara['waktu'] }}
                                </div>
                                <div class="flex items-center text-sm text-slate-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                    </svg>
                                    {{ $acara['tempat'] }}
                                </div>
                                <div class="mt-3">
                                    @php
                                        $categoryClass = match(strtolower($acara['kategori'] ?? $acara['jenis'] ?? '')) {
                                            'rapat' => 'bg-primary-200 text-primary-800',
                                            'pelatihan' => 'bg-primary-300 text-primary-800',
                                            'acara' => 'bg-primary-400 text-white',
                                            'kesehatan' => 'bg-pink-200 text-pink-800',
                                            default => 'bg-slate-200 text-slate-800',
                                        };
                                        $categoryLabel = $acara['kategori'] ?? ucfirst($acara['jenis'] ?? 'Acara');
                                    @endphp
                                    <span class="{{ $categoryClass }} text-xs px-3 py-1 rounded-full">
                                        {{ $categoryLabel }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('desa.berita.agenda') }}"
                    class="bg-gradient-accent hover:bg-primary-700 text-white px-8 py-3 rounded-xl font-semibold transition-colors">
                    Lihat Kalender Lengkap
                </a>
            </div>
        </div>
    </section>

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox">
        <span class="lightbox-close" id="lightboxClose">&times;</span>
        <button class="lightbox-nav lightbox-prev" id="lightboxPrev">&#10094;</button>
        <button class="lightbox-nav lightbox-next" id="lightboxNext">&#10095;</button>
        <div class="lightbox-content">
            <img id="lightboxImage" class="lightbox-image" src="" alt="">
            <div class="lightbox-info">
                <h3 id="lightboxTitle" class="text-xl font-bold mb-2"></h3>
                <p id="lightboxDescription" class="text-sm mt-2 opacity-75"></p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu) {
                    mobileMenu.classList.toggle('hidden');
                }
            });
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Lightbox functionality
        document.addEventListener('DOMContentLoaded', function() {
            const galleryItems = document.querySelectorAll('.gallery-item');
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightboxImage');
            const lightboxTitle = document.getElementById('lightboxTitle');
            const lightboxDescription = document.getElementById('lightboxDescription');
            const lightboxClose = document.getElementById('lightboxClose');
            const lightboxPrev = document.getElementById('lightboxPrev');
            const lightboxNext = document.getElementById('lightboxNext');
            
            let currentIndex = 0;
            let images = [];
            
            // Collect all images
            galleryItems.forEach((item, index) => {
                images.push({
                    image: item.dataset.image,
                    title: item.dataset.title,
                    description: item.dataset.description || ''
                });
                
                item.addEventListener('click', () => {
                    openLightbox(index);
                });
            });
            
            function openLightbox(index) {
                currentIndex = index;
                updateLightbox();
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            
            function closeLightbox() {
                lightbox.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
            
            function updateLightbox() {
                const current = images[currentIndex];
                lightboxImage.src = current.image;
                lightboxTitle.textContent = current.title;
                lightboxDescription.textContent = current.description || '';
            }
            
            function nextImage() {
                currentIndex = (currentIndex + 1) % images.length;
                updateLightbox();
            }
            
            function prevImage() {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                updateLightbox();
            }
            
            // Event listeners
            if (lightboxClose) {
                lightboxClose.addEventListener('click', closeLightbox);
            }
            if (lightboxNext) {
                lightboxNext.addEventListener('click', nextImage);
            }
            if (lightboxPrev) {
                lightboxPrev.addEventListener('click', prevImage);
            }
            
            // Close on background click
            if (lightbox) {
                lightbox.addEventListener('click', function(e) {
                    if (e.target === lightbox) {
                        closeLightbox();
                    }
                });
            }
            
            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (!lightbox || !lightbox.classList.contains('active')) return;
                
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowRight') {
                    nextImage();
                } else if (e.key === 'ArrowLeft') {
                    prevImage();
                }
            });
        });
    </script>
@endpush
