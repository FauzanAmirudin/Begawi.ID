@extends('layouts.app')

@section('title', 'Begawi.id - Platform Website Instan untuk Desa & UMKM Indonesia')
@section('description', 'Platform pembuat website instan berbasis lokal untuk UMKM dan lembaga desa. Tanpa keahlian teknis, tanpa biaya besar. Mulai digitalisasi dari Begawi.id')

@section('content')
    <!-- Hero Section -->
    @include('components.hero-section')
    
    <!-- Stats Section -->
    @include('components.stats-section')
    
    <!-- Quick Actions Section -->
    @include('components.quick-actions')
    
    <!-- Features Timeline Section -->
    <section class="py-20 bg-gradient-to-br from-emerald-50 to-blue-50 relative overflow-hidden">
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h2 class="font-manrope font-extrabold text-4xl md:text-5xl text-charcoal-grey mb-4">
                    Mengapa Memilih
                    <span class="text-gradient">Begawi.id?</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Platform yang dirancang khusus untuk kebutuhan digitalisasi Indonesia
                </p>
            </div>
            
            <div class="max-w-6xl mx-auto">
                <!-- Timeline -->
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-emerald-400 to-blue-400 rounded-full"></div>
                    
                    <!-- Timeline Items -->
                    <div class="space-y-16">
                        <!-- Item 1 -->
                        <div class="flex flex-col lg:flex-row items-center">
                            <div class="lg:w-1/2 lg:pr-12 mb-8 lg:mb-0">
                                <div class="bg-white rounded-2xl p-8 shadow-xl hover-tilt">
                                    <div class="flex items-center mb-6">
                                        <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center mr-4">
                                            <span class="text-white font-bold">1</span>
                                        </div>
                                        <h3 class="font-poppins font-bold text-2xl text-charcoal-grey">Mudah Digunakan</h3>
                                    </div>
                                    <p class="text-gray-600 leading-relaxed mb-6">
                                        Interface drag-and-drop yang intuitif. Tidak perlu coding atau keahlian teknis. Siapapun bisa membuat website profesional dalam hitungan menit.
                                    </p>
                                    <ul class="space-y-2 text-sm text-gray-500">
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Visual Editor
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            One-Click Setup
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Tutorial Lengkap
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="lg:w-1/2 lg:pl-12">
                                <div class="relative">
                                    <img src="{{ asset('images/features/easy-to-use.jpg') }}" alt="Easy to Use" class="w-full rounded-2xl shadow-2xl">
                                    <div class="absolute inset-0 bg-gradient-to-tr from-emerald-600/20 to-transparent rounded-2xl"></div>
                                </div>
                            </div>
                            <!-- Timeline Dot -->
                            <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-emerald-500 rounded-full border-4 border-white shadow-lg"></div>
                        </div>
                        
                        <!-- Item 2 -->
                        <div class="flex flex-col lg:flex-row-reverse items-center">
                            <div class="lg:w-1/2 lg:pl-12 mb-8 lg:mb-0">
                                <div class="bg-white rounded-2xl p-8 shadow-xl hover-tilt">
                                    <div class="flex items-center mb-6">
                                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
                                            <span class="text-white font-bold">2</span>
                                        </div>
                                        <h3 class="font-poppins font-bold text-2xl text-charcoal-grey">Fokus Lokal</h3>
                                    </div>
                                    <p class="text-gray-600 leading-relaxed mb-6">
                                        Template dan fitur yang disesuaikan dengan kebutuhan desa dan UMKM Indonesia. Mendukung bahasa lokal dan budaya setempat.
                                    </p>
                                    <ul class="space-y-2 text-sm text-gray-500">
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Template Khusus Indonesia
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Dukungan Bahasa Daerah
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Integrasi Payment Lokal
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="lg:w-1/2 lg:pr-12">
                                <div class="relative">
                                    <img src="{{ asset('images/features/local-focus.jpg') }}" alt="Local Focus" class="w-full rounded-2xl shadow-2xl">
                                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/20 to-transparent rounded-2xl"></div>
                                </div>
                            </div>
                            <!-- Timeline Dot -->
                            <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-blue-500 rounded-full border-4 border-white shadow-lg"></div>
                        </div>
                        
                        <!-- Item 3 -->
                        <div class="flex flex-col lg:flex-row items-center">
                            <div class="lg:w-1/2 lg:pr-12 mb-8 lg:mb-0">
                                <div class="bg-white rounded-2xl p-8 shadow-xl hover-tilt">
                                    <div class="flex items-center mb-6">
                                        <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mr-4">
                                            <span class="text-white font-bold">3</span>
                                        </div>
                                        <h3 class="font-poppins font-bold text-2xl text-charcoal-grey">Gratis Selamanya</h3>
                                    </div>
                                    <p class="text-gray-600 leading-relaxed mb-6">
                                        Komitmen kami untuk mendukung digitalisasi Indonesia. Fitur dasar gratis selamanya, upgrade premium dengan harga terjangkau.
                                    </p>
                                    <ul class="space-y-2 text-sm text-gray-500">
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Website Gratis Selamanya
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Hosting Reliable
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Support 24/7
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="lg:w-1/2 lg:pl-12">
                                <div class="relative">
                                    <img src="{{ asset('images/features/free-forever.jpg') }}" alt="Free Forever" class="w-full rounded-2xl shadow-2xl">
                                    <div class="absolute inset-0 bg-gradient-to-tr from-purple-600/20 to-transparent rounded-2xl"></div>
                                </div>
                            </div>
                            <!-- Timeline Dot -->
                            <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-purple-500 rounded-full border-4 border-white shadow-lg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Templates Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-manrope font-extrabold text-4xl md:text-5xl text-charcoal-grey mb-4">
                    Template Pilihan
                    <span class="text-gradient">Terpopuler</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Template yang paling banyak digunakan dan disukai komunitas
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                @foreach($featured_templates as $template)
                <div class="template-card group">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover-tilt">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('images/' . $template['image']) }}" alt="{{ $template['name'] }}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="absolute bottom-4 left-4 right-4 flex space-x-2">
                                    <button class="flex-1 bg-white/20 backdrop-blur-sm text-white font-medium py-2 px-4 rounded-lg hover:bg-white/30 transition-all">
                                        👁️ Preview
                                    </button>
                                    <button class="flex-1 bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-emerald-700 transition-all">
                                        🚀 Pakai
                                    </button>
                                </div>
                            </div>
                            <div class="absolute top-4 left-4">
                                <span class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                    {{ strtoupper($template['category']) }}
                                </span>
                            </div>
                            @if($template['is_premium'])
                            <div class="absolute top-4 right-4">
                                <span class="bg-orange-500 text-white text-xs font-medium px-2 py-1 rounded-full">PREMIUM</span>
                            </div>
                            @else
                            <div class="absolute top-4 right-4">
                                <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-2 py-1 rounded-full">GRATIS</span>
                            </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">{{ $template['name'] }}</h3>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ number_format($template['views']) }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        {{ $template['likes'] }}
                                    </span>
                                </div>
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= $template['rating']; $i++)
                                        ⭐
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center">
                <a href="{{ route('templates') }}" class="inline-flex items-center px-8 py-4 bg-gradient-accent text-white font-poppins font-semibold text-lg rounded-xl hover-glow transition-all">
                    <span class="mr-2">🎨</span>
                    Lihat Semua Template
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    @include('components.testimonial-section')
    
    <!-- Success Stories Section -->
    <section class="py-20 bg-gradient-to-br from-warm-ivory to-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-manrope font-extrabold text-4xl md:text-5xl text-charcoal-grey mb-4">
                    Kisah Sukses
                    <span class="text-gradient">Komunitas Kami</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Dampak nyata digitalisasi untuk desa dan UMKM Indonesia
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Success Story 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="text-4xl mb-4">🌾</div>
                    <h3 class="font-poppins font-bold text-xl mb-4">Desa Sukamaju Go Digital</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Transparansi APBDes meningkat 90%, pelayanan administrasi 3x lebih cepat, dan partisipasi warga dalam pembangunan naik signifikan.
                    </p>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-emerald-600 font-semibold">+90% Transparansi</span>
                        <span class="text-gray-500">Jawa Barat</span>
                    </div>
                </div>
                
                <!-- Success Story 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="text-4xl mb-4">🛍️</div>
                    <h3 class="font-poppins font-bold text-xl mb-4">UMKM Batik Nusantara</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Penjualan online meningkat 300% dalam 3 bulan, jangkauan pasar meluas ke seluruh Indonesia, omzet naik 5x lipat.
                    </p>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-blue-600 font-semibold">+300% Penjualan</span>
                        <span class="text-gray-500">Yogyakarta</span>
                    </div>
                </div>
                
                <!-- Success Story 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="text-4xl mb-4">👥</div>
                    <h3 class="font-poppins font-bold text-xl mb-4">Karang Taruna Digital</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Koordinasi kegiatan lebih efektif, partisipasi pemuda meningkat 150%, program pemberdayaan berjalan optimal.
                    </p>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-purple-600 font-semibold">+150% Partisipasi</span>
                        <span class="text-gray-500">Bali</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-charcoal-grey to-gray-900 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 right-0 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl animate-float" style="animation-delay: -1s;"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="font-manrope font-extrabold text-4xl md:text-6xl text-white mb-6">
                    Siap Memulai Perjalanan
                    <span class="text-gradient bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">
                        Digital Anda?
                    </span>
                </h2>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Bergabunglah dengan ribuan desa dan UMKM yang telah merasakan manfaat digitalisasi bersama Begawi.id
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6 mb-12">
                    <a href="#" class="group inline-flex items-center px-8 py-4 bg-gradient-accent text-white font-poppins font-semibold text-lg rounded-xl hover-glow transition-all transform hover:scale-105">
                        <span class="mr-3 text-xl group-hover:animate-bounce">🚀</span>
                        Buat Website Gratis
                        <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="group inline-flex items-center px-8 py-4 glassmorphism text-white font-medium text-lg rounded-xl hover:bg-white/20 transition-all">
                        <span class="mr-3 text-xl">💬</span>
                        Konsultasi Gratis
                    </a>
                </div>
                
                <!-- Trust Badges -->
                <div class="flex flex-wrap justify-center items-center space-x-8 opacity-60">
                    <div class="text-white/60 text-sm">Dipercaya oleh:</div>
                    <div class="text-lg font-bold text-white/60">1000+ Desa</div>
                    <div class="text-lg font-bold text-white/60">3000+ UMKM</div>
                    <div class="text-lg font-bold text-white/60">500+ Komunitas</div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Initialize homepage specific functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Animate timeline items on scroll
        const timelineItems = document.querySelectorAll('.timeline-item');
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                }
            });
        }, observerOptions);
        
        timelineItems.forEach(item => {
            timelineObserver.observe(item);
        });
    });
</script>
@endpush