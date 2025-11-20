@extends('layouts.desa')

@section('title', 'Beranda - Desa Sejahtera')

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

            <div class="columns-2 md:columns-3 lg:columns-4 gap-4">
                @foreach ($galeri as $item)
                    <div class="mb-4 break-inside-avoid group cursor-pointer">
                        <div class="relative rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                            <img src="{{ $item['gambar'] }}" alt="{{ $item['judul'] }}"
                                class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-300">
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
                <div class="grid grid-cols-7 gap-4 mb-8">
                    <div class="text-center font-semibold text-slate-700 py-3">Minggu</div>
                    <div class="text-center font-semibold text-slate-700 py-3">Senin</div>
                    <div class="text-center font-semibold text-slate-700 py-3">Selasa</div>
                    <div class="text-center font-semibold text-slate-700 py-3">Rabu</div>
                    <div class="text-center font-semibold text-slate-700 py-3">Kamis</div>
                    <div class="text-center font-semibold text-slate-700 py-3">Jumat</div>
                    <div class="text-center font-semibold text-slate-700 py-3">Sabtu</div>

                    <!-- Calendar Days (simplified) -->
                    @for ($i = 1; $i <= 31; $i++)
                        <div
                            class="aspect-square border border-slate-200 rounded-lg p-2 hover:bg-slate-50 transition-colors cursor-pointer">
                            <div class="text-sm font-medium text-slate-700">{{ $i }}</div>
                            @if (in_array($i, [20, 22, 28]))
                                <div class="mt-1">
                                    @if ($i == 20)
                                        <div class="bg-primary-200 text-primary-800 text-xs px-2 py-1 rounded mb-1">Rapat
                                        </div>
                                    @elseif($i == 22)
                                        <div class="bg-primary-300 text-primary-800 text-xs px-2 py-1 rounded mb-1">
                                            Pelatihan</div>
                                    @elseif($i == 28)
                                        <div class="bg-primary-400 text-white text-xs px-2 py-1 rounded mb-1">Acara</div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endfor
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
                                    @if ($acara['jenis'] == 'rapat')
                                        <span
                                            class="bg-primary-200 text-primary-800 text-xs px-3 py-1 rounded-full">Rapat</span>
                                    @elseif($acara['jenis'] == 'pelatihan')
                                        <span
                                            class="bg-primary-300 text-primary-800 text-xs px-3 py-1 rounded-full">Pelatihan</span>
                                    @else
                                        <span class="bg-primary-400 text-white text-xs px-3 py-1 rounded-full">Acara
                                            Umum</span>
                                    @endif
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
@endsection

@push('scripts')
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endpush
