@extends('layouts.app')

@section('title', 'Artikel Inspiratif - Kisah Sukses Digitalisasi - Begawi.id')
@section('description', 'Temukan kisah sukses digitalisasi desa dan UMKM di berbagai daerah sebagai sumber motivasi dan ide baru untuk bisnis Anda.')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-purple-50 via-purple-100 to-pink-50">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 right-0 w-72 h-72 bg-pink-400/10 rounded-full blur-3xl animate-float" style="animation-delay: -2s;"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10 pt-24 md:pt-32 pb-16">
            <div class="max-w-5xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-8">
                    <ol class="flex items-center space-x-2 text-sm text-gray-600">
                        <li><a href="{{ route('home') }}" class="hover:text-purple-600 transition">Beranda</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li><a href="{{ route('education') }}" class="hover:text-purple-600 transition">Edukasi</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-gray-900 font-medium">Artikel Inspiratif</li>
                    </ol>
                </nav>

                <div class="text-center">
                    <div class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold mb-6">
                        ✨ ARTIKEL INSPIRATIF
                    </div>
                    <h1 class="font-manrope font-extrabold text-4xl md:text-6xl text-charcoal-grey mb-6">
                        Kisah Sukses
                        <span class="text-gradient bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent">
                            Digitalisasi
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-3xl mx-auto">
                        Temukan inspirasi dari kisah sukses digitalisasi desa dan UMKM di berbagai daerah. Pelajari strategi mereka dan terapkan untuk mengembangkan bisnis digital Anda.
                    </p>
                    <div class="flex items-center justify-center gap-6 text-sm text-gray-500 flex-wrap">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            {{ $articles->count() }} Artikel Inspiratif
                        </span>
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            Kisah Nyata
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Read Stories Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold mb-6">
                            💡 MENGAPA MEMBACA KISAH INSPIRATIF?
                        </div>
                        <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                            Belajar dari Pengalaman Nyata
                        </h2>
                        <p class="text-lg text-gray-600 leading-relaxed mb-6">
                            Setiap kisah sukses memiliki pelajaran berharga. Dari desa yang berhasil meningkatkan transparansi melalui website, hingga UMKM yang berhasil mengembangkan bisnis melalui digitalisasi.
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-purple-600 rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-charcoal-grey mb-1">Strategi Terbukti</h3>
                                    <p class="text-gray-600 text-sm">Pelajari strategi yang sudah terbukti berhasil di lapangan</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-purple-600 rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-charcoal-grey mb-1">Tantangan & Solusi</h3>
                                    <p class="text-gray-600 text-sm">Pahami tantangan yang dihadapi dan bagaimana mereka mengatasinya</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-purple-600 rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-charcoal-grey mb-1">Motivasi & Inspirasi</h3>
                                    <p class="text-gray-600 text-sm">Dapatkan motivasi untuk memulai atau mengembangkan bisnis digital Anda</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="relative">
                        <div class="bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl p-8 shadow-2xl">
                            <div class="space-y-6">
                                <div class="bg-white rounded-xl p-6 shadow-lg">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                            DS
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-charcoal-grey">Desa Sejahtera</h4>
                                            <p class="text-sm text-gray-500">Jawa Barat</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 italic">"Website membantu kami meningkatkan transparansi anggaran dan mempercepat layanan publik. Warga sekarang bisa mengakses informasi kapan saja."</p>
                                </div>
                                <div class="bg-white rounded-xl p-6 shadow-lg">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                            UM
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-charcoal-grey">UMKM Nusantara</h4>
                                            <p class="text-sm text-gray-500">Yogyakarta</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 italic">"Setelah membuat website, penjualan kami meningkat 300%. Pelanggan dari luar kota sekarang bisa memesan produk kami dengan mudah."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Articles List Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                        Artikel Inspiratif Terbaru
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Baca kisah-kisah inspiratif dari desa dan UMKM yang berhasil melakukan digitalisasi
                    </p>
                </div>

                @if($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($articles as $article)
                    <a href="{{ route('education.article', $article['slug']) }}" class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all hover-tilt">
                        <div class="relative">
                            @if($article['image'])
                            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                            <div class="w-full h-48 bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                <span class="text-6xl text-white opacity-50">✨</span>
                            </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-purple-600 text-white">
                                    INSPIRATIF
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-3 line-clamp-2 group-hover:text-purple-600 transition">
                                {{ $article['title'] }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed line-clamp-3">
                                {{ $article['excerpt'] }}
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $article['duration'] }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ number_format($article['views']) }} views
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
                    <p class="mt-2 text-sm text-gray-500">Belum ada artikel inspiratif yang tersedia</p>
                    <p class="mt-1 text-xs text-gray-400">Artikel akan segera ditambahkan</p>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-purple-600 to-pink-600 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl mb-6">
                    Siap Menulis Kisah Sukses Anda?
                </h2>
                <p class="text-xl text-purple-50 mb-8 leading-relaxed">
                    Mulai digitalisasi bisnis atau organisasi Anda sekarang dan jadilah inspirasi bagi yang lain!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('templates') }}" class="px-8 py-4 bg-white text-purple-600 font-semibold rounded-xl hover:bg-purple-50 transition-all shadow-lg">
                        Mulai Sekarang
                    </a>
                    <a href="{{ route('education') }}" class="px-8 py-4 bg-purple-800 text-white font-semibold rounded-xl hover:bg-purple-900 transition-all border-2 border-white/20">
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

