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
                    <button onclick="scrollToSection('tutorial-web')"
                        class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Mulai Belajar
                    </button>
                    <button onclick="scrollToSection('bantuan-teknis')"
                        class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-sky-600 font-semibold px-8 py-4 rounded-xl border-2 border-sky-600 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
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
                    <div class="w-16 h-16 flex items-center justify-center mx-auto mb-3">
                        <img src="{{ asset('images/help/tutorial.png') }}" alt="icon" class="w-16 h-16 ">
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ $statistik['total_tutorial'] }}</div>
                    <div class="text-slate-600 text-sm">Tutorial</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 flex items-center justify-center mx-auto mb-3">
                        <img src="{{ asset('images/help/video-tutorial.png') }}" alt="icon" class="w-16 h-16 ">
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ $statistik['total_video'] }}</div>
                    <div class="text-slate-600 text-sm">Video Tutorial</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 flex items-center justify-center mx-auto mb-3">
                        <img src="{{ asset('images/help/artikel.png') }}" alt="icon" class="w-16 h-16 ">
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ $statistik['total_artikel'] }}</div>
                    <div class="text-slate-600 text-sm">Artikel</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <div class="w-16 h-16 flex items-center justify-center mx-auto mb-3">
                            <img src="{{ asset('images/help/rating-kepuasan.png') }}" alt="icon" class="w-16 h-16 ">
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ number_format($statistik['rating_kepuasan'], 1) }}
                    </div>
                    <div class="text-slate-600 text-sm">Rating Kepuasan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Navigation Tabs -->
    <div class="sticky top-[4.5rem] z-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <nav class="flex space-x-8 overflow-x-auto">
                <button onclick="scrollToSection('tutorial-web')"
                    class="help-nav-tab active whitespace-nowrap py-4 px-2 border-b-2 border-sky-600 text-sky-600 font-medium">
                    Tutorial Web
                </button>
                <button onclick="scrollToSection('video-pembelajaran')"
                    class="help-nav-tab whitespace-nowrap py-4 px-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">
                    Video Pembelajaran
                </button>
                <button onclick="scrollToSection('artikel-inspiratif')"
                    class="help-nav-tab whitespace-nowrap py-4 px-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">
                    Artikel Inspiratif
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
                    Pelajari cara menggunakan berbagai fitur website desa dengan panduan langkah demi langkah yang mudah
                    dipahami
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($tutorials as $tutorial)
                    <div class="tutorial-card bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 cursor-pointer"
                        onclick="openTutorial({{ $tutorial['id'] }})">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-12 h-12 bg-{{ $tutorial['color'] }}-100 rounded-xl flex items-center justify-center">
                                <x-desa.icon :name="$tutorial['icon']" class="w-6 h-6 text-{{ $tutorial['color'] }}-600" />
                            </div>
                            <div class="flex-1">
                                <span
                                    class="bg-{{ $tutorial['color'] }}-100 text-{{ $tutorial['color'] }}-700 text-xs font-medium px-2 py-1 rounded-full">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $tutorial['durasi'] }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
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
                        @foreach ($videos as $video)
                            <div class="video-card bg-gray-50 border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02] cursor-pointer"
                                style="width: 320px; flex-shrink: 0;"
                                onclick="openVideo('{{ $video['youtube_id'] }}', '{{ $video['judul'] }}')">
                                <div class="relative">
                                    <img src="{{ $video['thumbnail'] }}" alt="{{ $video['judul'] }}"
                                        class="w-full h-48 object-cover" />
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-black/40 hover:bg-black/30 transition">
                                        <div class="w-16 h-16 bg-white/90 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-sky-600 ml-1" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div
                                        class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
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
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            {{ number_format($video['views']) }} views
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                </path>
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
                <button id="prevVideo"
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 bg-white shadow-lg rounded-full p-2 hover:bg-gray-50 transition">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button id="nextVideo"
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 bg-white shadow-lg rounded-full p-2 hover:bg-gray-50 transition">
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
                    Baca kisah inspiratif, tips, dan insight tentang transformasi digital desa serta inovasi pelayanan
                    publik
                </p>
            </div>

            <!-- Filter Tags -->
            <div class="flex flex-wrap gap-3 justify-center mb-8">
                <button onclick="filterArticles('all')"
                    class="article-filter active bg-sky-600 text-white px-4 py-2 rounded-full text-sm font-medium transition">
                    Semua Artikel
                </button>
                <button onclick="filterArticles('digitalisasi')"
                    class="article-filter bg-white text-slate-600 border border-slate-300 px-4 py-2 rounded-full text-sm font-medium hover:bg-slate-50 transition">
                    #Digitalisasi
                </button>
                <button onclick="filterArticles('umkm')"
                    class="article-filter bg-white text-slate-600 border border-slate-300 px-4 py-2 rounded-full text-sm font-medium hover:bg-slate-50 transition">
                    #UMKM
                </button>
                <button onclick="filterArticles('partisipasi')"
                    class="article-filter bg-white text-slate-600 border border-slate-300 px-4 py-2 rounded-full text-sm font-medium hover:bg-slate-50 transition">
                    #PartisipasiWarga
                </button>
                <button onclick="filterArticles('keamanan')"
                    class="article-filter bg-white text-slate-600 border border-slate-300 px-4 py-2 rounded-full text-sm font-medium hover:bg-slate-50 transition">
                    #Keamanan
                </button>
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($articles as $article)
                    <article
                        class="article-card bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 cursor-pointer"
                        data-kategori="{{ strtolower($article['kategori']) }}"
                        onclick="openArticle({{ $article['id'] }})">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('images/articles/' . $article['gambar']) }}"
                                alt="{{ $article['judul'] }}"
                                class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-900/70 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-4 left-4 right-4">
                                    <span
                                        class="text-white text-sm font-medium bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                        Baca Selengkapnya →
                                    </span>
                                </div>
                            </div>
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-white/90 backdrop-blur-sm text-slate-700 text-xs font-medium px-3 py-1 rounded-full">
                                    {{ $article['kategori'] }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center gap-4 text-sm text-slate-500 mb-3">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $article['penulis'] }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h8m-8 0a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2">
                                        </path>
                                    </svg>
                                    {{ date('d M Y', strtotime($article['tanggal'])) }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $article['waktu_baca'] }}
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-slate-800 mb-3 line-clamp-2">{{ $article['judul'] }}</h3>
                            <p class="text-slate-600 mb-4 line-clamp-3">{{ $article['excerpt'] }}</p>

                            <div class="flex flex-wrap gap-2">
                                @foreach ($article['tags'] as $tag)
                                    <span
                                        class="text-xs text-sky-600 bg-sky-50 px-2 py-1 rounded-full">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-12">
                <button
                    class="bg-white hover:bg-slate-50 text-slate-700 font-semibold px-8 py-3 rounded-xl border border-slate-300 transition-colors">
                    Muat Artikel Lainnya
                </button>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="aspect-video">
                <iframe id="videoIframe" width="100%" height="100%" src="" frameborder="0" allowfullscreen
                    class="w-full h-full"></iframe>
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
                        carousel.scrollBy({
                            left: -340,
                            behavior: 'smooth'
                        });
                    });

                    nextBtn.addEventListener('click', () => {
                        carousel.scrollBy({
                            left: 340,
                            behavior: 'smooth'
                        });
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

                    showToast(
                        `✅ Laporan teknis berhasil dikirim! Nomor tiket: ${ticketId}. Tim teknis akan menindaklanjuti dalam 24 jam.`,
                        'success');
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
            input[type="radio"]:checked+.priority-indicator {
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
