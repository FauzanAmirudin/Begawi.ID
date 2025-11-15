@extends('layouts.app')

@section('title', 'Tips Pemasaran Digital - Strategi Marketing Online - Begawi.id')
@section('description', 'Pelajari tips dan strategi pemasaran digital yang efektif untuk meningkatkan visibilitas dan penjualan bisnis Anda secara online.')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-orange-50 via-pink-50 to-rose-50">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 right-0 w-72 h-72 bg-rose-400/10 rounded-full blur-3xl animate-float" style="animation-delay: -2s;"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10 pt-24 md:pt-32 pb-16">
            <div class="max-w-5xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-8">
                    <ol class="flex items-center space-x-2 text-sm text-gray-600">
                        <li><a href="{{ route('home') }}" class="hover:text-orange-600 transition">Beranda</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li><a href="{{ route('education') }}" class="hover:text-orange-600 transition">Edukasi</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-gray-900 font-medium">Tips Pemasaran Digital</li>
                    </ol>
                </nav>

                <div class="text-center">
                    <div class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-800 rounded-full text-sm font-semibold mb-6">
                        📣 TIPS PEMASARAN DIGITAL
                    </div>
                    <h1 class="font-manrope font-extrabold text-4xl md:text-6xl text-charcoal-grey mb-6">
                        Strategi Marketing
                        <span class="text-gradient bg-gradient-to-r from-orange-600 to-rose-500 bg-clip-text text-transparent">
                            Online yang Efektif
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-3xl mx-auto">
                        Pelajari tips dan strategi pemasaran digital yang praktis dan mudah diterapkan. Tingkatkan visibilitas, jangkauan, dan penjualan bisnis Anda melalui platform digital.
                    </p>
                    <div class="flex items-center justify-center gap-6 text-sm text-gray-500 flex-wrap">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            {{ $tips->count() }} Tips Tersedia
                        </span>
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Praktis & Aplikatif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Topics Covered Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                        Topik yang Akan Anda Pelajari
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Dari dasar hingga strategi lanjutan, pelajari semua aspek pemasaran digital
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl p-8 border border-orange-100 hover:shadow-xl transition-all">
                        <div class="w-16 h-16 bg-orange-600 rounded-xl flex items-center justify-center mb-6">
                            <span class="text-3xl">📱</span>
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-4">Social Media Marketing</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Pelajari cara memanfaatkan platform media sosial untuk meningkatkan brand awareness dan engagement.
                        </p>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl p-8 border border-orange-100 hover:shadow-xl transition-all">
                        <div class="w-16 h-16 bg-orange-600 rounded-xl flex items-center justify-center mb-6">
                            <span class="text-3xl">🔍</span>
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-4">SEO & Content Marketing</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Optimalkan website Anda untuk mesin pencari dan buat konten yang menarik perhatian target audience.
                        </p>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl p-8 border border-orange-100 hover:shadow-xl transition-all">
                        <div class="w-16 h-16 bg-orange-600 rounded-xl flex items-center justify-center mb-6">
                            <span class="text-3xl">📧</span>
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-4">Email Marketing</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Bangun hubungan dengan pelanggan melalui email marketing yang efektif dan personal.
                        </p>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl p-8 border border-orange-100 hover:shadow-xl transition-all">
                        <div class="w-16 h-16 bg-orange-600 rounded-xl flex items-center justify-center mb-6">
                            <span class="text-3xl">💰</span>
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-4">Paid Advertising</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Pelajari cara membuat iklan berbayar yang efektif di Google Ads, Facebook Ads, dan platform lainnya.
                        </p>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl p-8 border border-orange-100 hover:shadow-xl transition-all">
                        <div class="w-16 h-16 bg-orange-600 rounded-xl flex items-center justify-center mb-6">
                            <span class="text-3xl">📊</span>
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-4">Analytics & Tracking</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Ukur performa kampanye marketing Anda dengan tools analytics dan optimalkan berdasarkan data.
                        </p>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl p-8 border border-orange-100 hover:shadow-xl transition-all">
                        <div class="w-16 h-16 bg-orange-600 rounded-xl flex items-center justify-center mb-6">
                            <span class="text-3xl">🎯</span>
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-4">Branding & Positioning</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Bangun brand identity yang kuat dan posisikan bisnis Anda di pasar dengan strategi yang tepat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tips List Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                        Tips Pemasaran Digital
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Pilih tips yang ingin Anda pelajari dan terapkan untuk bisnis Anda
                    </p>
                </div>

                @if($tips->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($tips as $tip)
                    <a href="{{ route('education.article', $tip['slug']) }}" class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all hover-tilt">
                        <div class="relative">
                            @if($tip['image'])
                            <img src="{{ $tip['image'] }}" alt="{{ $tip['title'] }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                            <div class="w-full h-48 bg-gradient-to-br from-orange-500 to-rose-500 flex items-center justify-center">
                                <span class="text-6xl text-white opacity-50">💡</span>
                            </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-orange-600 text-white">
                                    TIPS
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-3 line-clamp-2 group-hover:text-orange-600 transition">
                                {{ $tip['title'] }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed line-clamp-3">
                                {{ $tip['excerpt'] }}
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $tip['duration'] }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ number_format($tip['views']) }} views
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Belum ada tips yang tersedia</p>
                    <p class="mt-1 text-xs text-gray-400">Tips akan segera ditambahkan</p>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                        Manfaat Pemasaran Digital
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Mengapa pemasaran digital penting untuk bisnis Anda?
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-white rounded-xl border border-orange-100">
                        <div class="text-4xl mb-4">📈</div>
                        <h3 class="font-bold text-charcoal-grey mb-2">Jangkauan Luas</h3>
                        <p class="text-sm text-gray-600">Jangkau lebih banyak calon pelanggan tanpa batasan geografis</p>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-white rounded-xl border border-orange-100">
                        <div class="text-4xl mb-4">💰</div>
                        <h3 class="font-bold text-charcoal-grey mb-2">Biaya Efektif</h3>
                        <p class="text-sm text-gray-600">Lebih hemat dibandingkan pemasaran tradisional</p>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-white rounded-xl border border-orange-100">
                        <div class="text-4xl mb-4">📊</div>
                        <h3 class="font-bold text-charcoal-grey mb-2">Terukur</h3>
                        <p class="text-sm text-gray-600">Hasil kampanye dapat diukur dan dianalisis dengan akurat</p>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-white rounded-xl border border-orange-100">
                        <div class="text-4xl mb-4">🎯</div>
                        <h3 class="font-bold text-charcoal-grey mb-2">Target Spesifik</h3>
                        <p class="text-sm text-gray-600">Sasarkan audiens yang tepat dengan lebih presisi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-orange-600 to-rose-600 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl mb-6">
                    Tingkatkan Penjualan dengan Pemasaran Digital
                </h2>
                <p class="text-xl text-orange-50 mb-8 leading-relaxed">
                    Mulai terapkan strategi pemasaran digital sekarang dan lihat bisnis Anda berkembang!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('templates') }}" class="px-8 py-4 bg-white text-orange-600 font-semibold rounded-xl hover:bg-orange-50 transition-all shadow-lg">
                        Mulai Sekarang
                    </a>
                    <a href="{{ route('education') }}" class="px-8 py-4 bg-orange-800 text-white font-semibold rounded-xl hover:bg-orange-900 transition-all border-2 border-white/20">
                        Kembali ke Edukasi
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation on scroll
        const cards = document.querySelectorAll('.hover-tilt');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                }
            });
        }, { threshold: 0.1 });
        
        cards.forEach(card => observer.observe(card));
    });
</script>
@endpush

