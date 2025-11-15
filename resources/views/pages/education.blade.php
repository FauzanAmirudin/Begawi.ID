@extends('layouts.app')

@section('title', 'Pusat Edukasi Digital - Begawi.id')
@section('description', 'Pelajari cara membuat dan mengelola website, tips digital marketing, dan panduan lengkap digitalisasi untuk desa dan UMKM.')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-purple-50 to-pink-50">
        <div class="container mx-auto px-4 relative z-10 pt-24 md:pt-32">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="font-manrope font-extrabold text-4xl md:text-6xl text-charcoal-grey mb-6">
                    Pusat Edukasi
                    <span class="text-gradient">Digital</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    Pelajari semua yang perlu Anda ketahui tentang digitalisasi, dari dasar hingga mahir. Gratis untuk semua!
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto mb-8">
                    <div class="relative">
                        <input type="text" id="educationSearch" placeholder="Cari tutorial, artikel, atau video..." class="w-full px-6 py-4 pl-12 bg-white border border-gray-300 rounded-2xl text-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-lg">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>                
            </div>
        </div>
    </section>
    
    <!-- Articles & Guides Section -->
    <section class="py-20 px-6 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                    Artikel &amp; Panduan
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Temukan inspirasi, pengetahuan, dan tips praktis untuk mempercepat perjalanan digital Anda
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center mb-6 mx-auto md:mx-0">
                        <span class="text-2xl text-white">🛠️</span>
                    </div>
                    <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-4">Tutorial Penggunaan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Panduan praktis pembuatan website untuk pengguna baru agar dapat memulai tanpa kebingungan.
                    </p>
                    <a href="{{ route('education.tutorial-detail') }}" class="inline-flex items-center mt-6 text-emerald-600 font-semibold hover:text-emerald-700 transition-all">
                        Pelajari Lebih Lanjut
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-6 mx-auto md:mx-0">
                        <span class="text-2xl text-white">✨</span>
                    </div>
                    <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-4">Artikel Inspiratif</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kisah sukses digitalisasi desa dan UMKM di berbagai daerah sebagai sumber motivasi dan ide baru.
                    </p>
                    <a href="{{ route('education.inspiratif-detail') }}" class="inline-flex items-center mt-6 text-purple-600 font-semibold hover:text-purple-700 transition-all">
                        Baca Ceritanya
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center mb-6 mx-auto md:mx-0">
                        <span class="text-2xl text-white">📣</span>
                    </div>
                    <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-4">Tips Pemasaran Digital</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Konten edukatif mengenai promosi efektif, strategi branding, dan pemasaran online yang relevan.
                    </p>
                    <a href="{{ route('education.tips-detail') }}" class="inline-flex items-center mt-6 text-pink-600 font-semibold hover:text-pink-700 transition-all">
                        Lihat Tipsnya
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Content -->
    <section class="py-20 px-6 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                    Konten
                    <span class="text-gradient">Terpopuler</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Tutorial dan artikel yang paling banyak dibaca minggu ini
                </p>
            </div>
            
            <!-- Content Tabs -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button class="content-tab active px-6 py-3 bg-gradient-accent text-white font-semibold rounded-xl transition-all hover-glow" data-tab="all">
                    Semua Konten
                </button>
                <button class="content-tab px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-purple-500 hover:text-purple-600 transition-all" data-tab="tutorial">
                    📝 Tutorial
                </button>
                <button class="content-tab px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-purple-500 hover:text-purple-600 transition-all" data-tab="video">
                    🎥 Video
                </button>
                <button class="content-tab px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-purple-500 hover:text-purple-600 transition-all" data-tab="tips">
                    💡 Tips
                </button>
                <button class="content-tab px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-purple-500 hover:text-purple-600 transition-all" data-tab="update">
                    📢 Update
                </button>
            </div>
            
            <!-- Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featured_content as $content)
                <div class="content-item bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all hover-tilt" data-category="{{ $content['type'] }}">
                    <div class="relative">
                        <img src="{{ $content['image'] }}" alt="{{ $content['title'] }}" class="w-full h-48 object-cover">
                        @if($content['type'] === 'video')
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center group-hover:bg-black/60 transition-all">
                            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            @if($content['type'] === 'tutorial')
                                <span class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full">TUTORIAL</span>
                            @elseif($content['type'] === 'video')
                                <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">VIDEO</span>
                            @elseif($content['type'] === 'tips')
                                <span class="bg-orange-600 text-white text-xs font-bold px-3 py-1 rounded-full">TIPS</span>
                            @elseif($content['type'] === 'update')
                                <span class="bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full">UPDATE</span>
                            @endif
                        </div>
                        @if(isset($content['is_hot']) && $content['is_hot'])
                        <div class="absolute top-4 right-4">
                            <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full">🔥 HOT</span>
                        </div>
                        @endif
                        @if($content['type'] === 'video' && isset($content['duration']))
                        <div class="absolute bottom-4 right-4">
                            <span class="bg-black/50 text-white text-xs px-2 py-1 rounded">{{ $content['duration'] }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-3">{{ Str::limit($content['title'], 60) }}</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                            {{ Str::limit($content['description'], 120) }}
                        </p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $content['duration'] ?? '5 menit' }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ number_format($content['views']) }} views
                            </span>
                        </div>
                        @if($content['type'] === 'video')
                        <a href="{{ route('education.video', $content['slug']) }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-all">
                            Tonton Video
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </a>
                        @else
                        <a href="{{ route('education.article', $content['slug']) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-all">
                            Baca {{ $content['type'] === 'tips' ? 'Tips' : ($content['type'] === 'update' ? 'Update' : 'Tutorial') }}
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Belum ada konten yang tersedia</p>
                </div>
                @endforelse
            </div>
            
            <!-- Load More -->
            <div class="text-center mt-12">
                <button class="inline-flex items-center px-8 py-4 bg-gradient-accent text-white font-poppins font-semibold text-lg rounded-xl hover-glow transition-all">
                    <span class="mr-2">📚</span>
                    Muat Konten Lainnya
                </button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Content tabs functionality
        const contentTabs = document.querySelectorAll('.content-tab');
        const contentItems = document.querySelectorAll('.content-item');
        
        contentTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const category = this.getAttribute('data-tab');
                
                // Update active tab
                contentTabs.forEach(t => {
                    t.classList.remove('active', 'bg-gradient-accent', 'text-white', 'border-purple-500', 'text-purple-600');
                    t.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
                });
                
                this.classList.add('active', 'bg-gradient-accent', 'text-white');
                this.classList.remove('bg-white', 'border-gray-300', 'text-gray-700', 'border-purple-500', 'text-purple-600');
                
                // Filter content
                contentItems.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');
                    if (category === 'all' || itemCategory === category) {
                        item.style.display = 'block';
                        item.classList.add('animate-fadeInUp');
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Search functionality
        const searchInput = document.getElementById('educationSearch');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            // Implement search logic here
            console.log('Searching for:', searchTerm);
        });
    });
</script>
@endpush