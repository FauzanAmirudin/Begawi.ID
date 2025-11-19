@extends('layouts.app')

@section('title', 'Tentang Begawi.id - Misi Digitalisasi Indonesia')
@section('description',
    'Pelajari visi, misi, dan cerita di balik Begawi.id. Platform yang berkomitmen memajukan
    digitalisasi desa dan UMKM Indonesia.')

@section('content')
    <!-- Hero Section -->
    <section
        class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-charcoal-grey to-gray-900 text-white">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 right-0 w-72 h-72 bg-emerald-400/10 rounded-full blur-3xl animate-float"
                style="animation-delay: -2s;"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 pt-24 md:pt-32">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="font-manrope font-extrabold text-4xl md:text-6xl mb-6">
                    Membangun Indonesia Digital
                    <span
                        class="text-gradient bg-gradient-to-r from-emerald-500 to-emerald-300 bg-clip-text text-transparent">
                        dari Akar Rumput
                    </span>
                </h1>
                <p class="text-xl text-gray-300 mb-8 leading-relaxed max-w-3xl mx-auto">
                    Begawi.id lahir dari visi untuk mewujudkan Indonesia yang digital dan inklusif. Kami percaya bahwa
                    setiap desa dan UMKM berhak mendapatkan akses teknologi yang mudah dan terjangkau.
                </p>
            </div>
        </div>
    </section>

    <!-- Profile Section -->
    <section class="py-20 bg-linear-to-br from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center space-y-6">
                <div
                    class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-800 rounded-full text-sm font-semibold">
                    🏢 PROFIL BEGAWI.ID
                </div>
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey">
                    Platform Digital untuk Desa &amp; UMKM
                </h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Begawi.id (Bersama Galang Website Instan) adalah solusi cepat dan mudah bagi Desa dan UMKM untuk
                    memiliki kehadiran online profesional. Kami menyediakan ratusan template website instan yang dirancang
                    khusus untuk kebutuhan lokal, memungkinkan Anda go online dalam hitungan menit, tanpa perlu keahlian
                    coding!
                </p>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <!-- Mission -->
                    <div>
                        <div
                            class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-800 rounded-full text-sm font-semibold mb-6">
                            🎯 MISI DAN TUJUAN
                        </div>
                        <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                            Memberdayakan Setiap Desa dan UMKM
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-6 text-lg">
                            Misi utama kami adalah Memperkuat Ekonomi Lokal. Kami bertujuan untuk menyediakan website
                            mandiri yang mudah diakses dan dikelola oleh Desa dan pelaku UMKM, sehingga mereka dapat
                            memperluas jangkauan pasar, meningkatkan transparansi informasi, dan pada akhirnya, mendorong
                            pertumbuhan ekonomi daerah secara berkelanjutan.
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-emerald-600 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-charcoal-grey mb-1">Akses Teknologi untuk Semua</h3>
                                    <p class="text-gray-600 text-sm">Memberikan platform gratis dan mudah digunakan tanpa
                                        batasan geografis</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-emerald-600 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-charcoal-grey mb-1">Pemberdayaan Ekonomi Lokal</h3>
                                    <p class="text-gray-600 text-sm">Membantu UMKM berkembang melalui digitalisasi dan
                                        e-commerce</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-emerald-600 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-charcoal-grey mb-1">Transparansi & Akuntabilitas</h3>
                                    <p class="text-gray-600 text-sm">Mendorong tata kelola yang baik melalui transparansi
                                        digital</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Vision Image -->
                    <div class="relative">
                        <img src="{{ asset('images/visi-tujuan.jpg') }}" alt="Mission"
                            class="w-full rounded-2xl shadow-2xl">
                        <div class="absolute inset-0 bg-gradient-to-tr from-emerald-600/20 to-transparent rounded-2xl">
                        </div>
                        <!-- Floating Elements -->
                        <div
                            class="absolute -top-6 -right-6 w-24 h-24 bg-emerald-600 rounded-2xl flex items-center justify-center text-white text-2xl animate-float">
                            🚀
                        </div>
                        <div class="absolute -bottom-6 -left-6 w-20 h-20 bg-emerald-600 rounded-xl flex items-center justify-center text-white text-xl animate-float"
                            style="animation-delay: -1s;">
                            💡
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center mb-16">
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                    Cerita di Balik
                    <span class="text-gradient">Begawi.id</span>
                </h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Perjalanan kami dimulai dari keprihatinan terhadap kesenjangan digital di Indonesia
                </p>
            </div>

            <!-- Timeline -->
            <div class="max-w-4xl mx-auto">
                <div class="relative">
                    <!-- Timeline Line -->
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-emerald-500 to-emerald-300 rounded-full">
                    </div>

                    <!-- Timeline Items -->
                    <div class="space-y-12">
                        <!-- Item 1 -->
                        <div class="flex items-center">
                            <div class="w-1/2 pr-8 text-right">
                                <div class="bg-white rounded-xl p-6 shadow-lg">
                                    <div class="text-emerald-600 font-bold text-sm mb-2">2023 - AWAL MULA</div>
                                    <h3 class="font-poppins font-bold text-lg mb-3">Identifikasi Masalah</h3>
                                    <p class="text-gray-600 text-sm">
                                        Riset mendalam tentang kesenjangan digital di desa-desa Indonesia. Kami menemukan
                                        70% desa belum memiliki website resmi.
                                    </p>
                                </div>
                            </div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-emerald-500 rounded-full border-4 border-white shadow-lg z-10">
                            </div>
                            <div class="w-1/2 pl-8"></div>
                        </div>

                        <!-- Item 2 -->
                        <div class="flex items-center">
                            <div class="w-1/2 pr-8"></div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-emerald-500 rounded-full border-4 border-white shadow-lg z-10">
                            </div>
                            <div class="w-1/2 pl-8">
                                <div class="bg-white rounded-xl p-6 shadow-lg">
                                    <div class="text-emerald-600 font-bold text-sm mb-2">2024 - PENGEMBANGAN</div>
                                    <h3 class="font-poppins font-bold text-lg mb-3">Membangun Solusi</h3>
                                    <p class="text-gray-600 text-sm">
                                        Mengembangkan platform dengan fokus pada kemudahan penggunaan dan kebutuhan spesifik
                                        Indonesia.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="flex items-center">
                            <div class="w-1/2 pr-8 text-right">
                                <div class="bg-white rounded-xl p-6 shadow-lg">
                                    <div class="text-purple-600 font-bold text-sm mb-2">2024 - PELUNCURAN</div>
                                    <h3 class="font-poppins font-bold text-lg mb-3">Beta Launch</h3>
                                    <p class="text-gray-600 text-sm">
                                        Meluncurkan versi beta dengan 50 desa dan 100 UMKM sebagai pilot project.
                                    </p>
                                </div>
                            </div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-purple-500 rounded-full border-4 border-white shadow-lg z-10">
                            </div>
                            <div class="w-1/2 pl-8"></div>
                        </div>

                        <!-- Item 4 -->
                        <div class="flex items-center">
                            <div class="w-1/2 pr-8"></div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-orange-500 rounded-full border-4 border-white shadow-lg z-10">
                            </div>
                            <div class="w-1/2 pl-8">
                                <div class="bg-white rounded-xl p-6 shadow-lg">
                                    <div class="text-orange-600 font-bold text-sm mb-2">SEKARANG - EKSPANSI</div>
                                    <h3 class="font-poppins font-bold text-lg mb-3">Jangkauan Nasional</h3>
                                    <p class="text-gray-600 text-sm">
                                        Melayani 1,250+ desa dan 3,420+ UMKM di 34 provinsi Indonesia.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                    Tim di Balik
                    <span class="text-gradient">Begawi.id</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Profesional berpengalaman yang berkomitmen untuk memajukan Indonesia digital
                </p>
            </div>

            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    <!-- Team Member 1 -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                        <div class="relative mb-6">
                            <img src="{{ asset('images/team/husnu.jpg') }}" alt="M. Husnu Al Hafidz"
                                class="w-24 h-24 rounded-full mx-auto object-cover">
                            <div
                                class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-600 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">M. Husnu Al Hafidz</h3>
                        <p class="text-emerald-600 font-semibold mb-4">Ketua Tim, Pengembang Web dan Backend</p>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                            Memimpin keseluruhan arah kerja tim, serta bertanggung jawab membangun dan mengelola sistem
                            website serta memastikan performa backend berjalan stabil, aman, dan efisien.
                        </p>
                        <div class="flex justify-center space-x-3">
                            <a href="#"
                                class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 hover:bg-gray-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                        <div class="relative mb-6">
                            <img src="{{ asset('images/team/suci.jpg') }}" alt="Suci Khalishah"
                                class="w-24 h-24 rounded-full mx-auto object-cover">
                            <div
                                class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-600 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Suci Khalishah</h3>
                        <p class="text-emerald-600 font-semibold mb-4">Desain UI/UX &amp; Penulisan</p>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                            Menciptakan tampilan antarmuka yang intuitif dan pengalaman pengguna yang nyaman, sekaligus
                            menghasilkan konten tulisan yang jelas dan menarik.
                        </p>
                        <div class="flex justify-center space-x-3">
                            <a href="#"
                                class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 hover:bg-purple-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                        <div class="relative mb-6">
                            <img src="{{ asset('images/team/merici.jpg') }}" alt="Angela Merici Resti Restu Herlina"
                                class="w-24 h-24 rounded-full mx-auto object-cover">
                            <div
                                class="absolute -bottom-2 -right-2 w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Angela Merici Resti Restu
                            Herlina</h3>
                        <p class="text-purple-600 font-semibold mb-4">Marketing, Operasional & Komunikasi Mitra</p>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                            Mengembangkan strategi pemasaran, mengelola operasional harian, dan membangun komunikasi yang
                            baik dengan mitra untuk memperluas jaringan kerja sama.
                        </p>
                        <div class="flex justify-center space-x-3">
                            <a href="#"
                                class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600 hover:bg-green-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Team Member 4 -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                        <div class="relative mb-6">
                            <img src="{{ asset('images/team/laurino.jpg') }}" alt="Laurino Pangestu"
                                class="w-24 h-24 rounded-full mx-auto object-cover">
                            <div
                                class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Laurino Pangestu</h3>
                        <p class="text-emerald-500 font-semibold mb-4">Keuangan, Administrasi & Legalitas Usaha</p>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                            Mengatur arus keuangan, dokumentasi administrasi, serta memastikan semua aktivitas usaha sesuai
                            peraturan dan legalitas yang berlaku.
                        </p>
                        <div class="flex justify-center space-x-3">
                            <a href="#"
                                class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.35 3.608 1.325.975.975 1.263 2.242 1.325 3.608.058 1.266.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.85-.062 1.366-.35 2.633-1.325 3.608-.975.975-2.242 1.263-3.608 1.325-1.266.058-1.645.069-4.85.069s-3.584-.012-4.85-.069c-1.366-.062-2.633-.35-3.608-1.325-.975-.975-1.263-2.242-1.325-3.608C2.175 15.584 2.163 15.205 2.163 12c0-3.204.012-3.583.07-4.849.062-1.366.35-2.633 1.325-3.608.975-.975 2.242-1.263 3.608-1.325C8.416 2.175 8.795 2.163 12 2.163zm0-2.163C8.741 0 8.332.012 7.052.07 5.771.128 4.636.443 3.68 1.399c-.957.956-1.271 2.091-1.329 3.372C2.012 5.332 2 5.741 2 9s.012 3.668.07 4.948c.058 1.281.372 2.416 1.329 3.372.956.957 2.091 1.271 3.372 1.329C8.332 18.988 8.741 19 12 19s3.668-.012 4.948-.07c1.281-.058 2.416-.372 3.372-1.329.957-.956 1.271-2.091 1.329-3.372.058-1.28.07-1.689.07-4.948s-.012-3.668-.07-4.948c-.058-1.281-.372-2.416-1.329-3.372-.956-.957-2.091-1.271-3.372-1.329C15.668.012 15.259 0 12 0z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Team Member 5 -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                        <div class="relative mb-6">
                            <img src="{{ asset('images/team/novita.jpg') }}" alt="Novita Fitriyani"
                                class="w-24 h-24 rounded-full mx-auto object-cover">
                            <div
                                class="absolute -bottom-2 -right-2 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 1.567-3 3.5S10.343 15 12 15s3-1.567 3-3.5S13.657 8 12 8z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Novita Fitriyani</h3>
                        <p class="text-orange-500 font-semibold mb-4">Promosi Media Sosial & Produksi Konten Kreatif</p>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                            Mengelola strategi promosi di berbagai platform sosial media dan menghasilkan konten kreatif
                            yang menarik untuk meningkatkan brand awareness.
                        </p>
                        <div class="flex justify-center space-x-3">
                            <a href="#"
                                class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 hover:bg-gray-600 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="py-20 bg-linear-to-br from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center mb-16">
                <div
                    class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-800 rounded-full text-sm font-semibold mb-6">
                    🤝 MITRA &amp; KOLABORATOR
                </div>
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                    Bersama Menguatkan Ekosistem Digital
                </h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Kami percaya pada kekuatan kolaborasi. Ekosistem Begawi.id didukung oleh berbagai instansi pemerintah,
                    universitas, dan lembaga yang memiliki visi yang sama untuk memajukan Desa dan UMKM. Daftar mitra kami
                    mencerminkan komitmen kami untuk memberikan dukungan yang komprehensif dan terpercaya kepada setiap
                    pengguna Begawi.id.
                </p>
            </div>

            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all">
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-semibold uppercase tracking-wide mb-5">
                            Instansi Pemerintah
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Kementerian Desa PDTT</h3>
                        <p class="text-sm text-gray-600 leading-relaxed mb-4">
                            Dukungan program digitalisasi pelayanan desa, pengembangan dashboard transparansi, dan
                            monitoring data pembangunan desa.
                        </p>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">KOLABORASI SEJAK 2023
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all">
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-full bg-sky-50 text-sky-600 text-xs font-semibold uppercase tracking-wide mb-5">
                            Instansi Pemerintah
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Pemprov Jawa Barat</h3>
                        <p class="text-sm text-gray-600 leading-relaxed mb-4">
                            Akselerasi Desa Digital Juara melalui portal informasi, marketplace produk UMKM, dan integrasi
                            kanal layanan publik.
                        </p>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">INISIATIF BERLANJUT</div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all">
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-full bg-purple-50 text-purple-600 text-xs font-semibold uppercase tracking-wide mb-5">
                            Universitas
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Institut Teknologi Bandung</h3>
                        <p class="text-sm text-gray-600 leading-relaxed mb-4">
                            Riset user experience, penyusunan modul literasi digital, serta program magang pengembangan
                            teknologi untuk Begawi.id.
                        </p>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">KEMITRAAN AKADEMIS</div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all">
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-semibold uppercase tracking-wide mb-5">
                            Universitas
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Universitas Gadjah Mada</h3>
                        <p class="text-sm text-gray-600 leading-relaxed mb-4">
                            Pemberdayaan UMKM binaan melalui klinik bisnis digital, pelatihan branding, dan penerapan model
                            ekonomi kreatif lokal.
                        </p>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">PENGEMBANGAN KAPASITAS
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all">
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-xs font-semibold uppercase tracking-wide mb-5">
                            Lembaga
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">BPD HIPMI</h3>
                        <p class="text-sm text-gray-600 leading-relaxed mb-4">
                            Pendampingan go-digital untuk UMKM anggota dan penyediaan akses jaringan pemasaran nasional
                            melalui platform Begawi.id.
                        </p>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">INKUBASI BISNIS</div>
                    </div>

                    <!-- Card 6 -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all">
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-full bg-slate-50 text-slate-600 text-xs font-semibold uppercase tracking-wide mb-5">
                            Lembaga
                        </div>
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Bank Pembangunan Daerah</h3>
                        <p class="text-sm text-gray-600 leading-relaxed mb-4">
                            Penyediaan solusi pembayaran digital, integrasi QRIS, dan akses pembiayaan mikro untuk mitra
                            desa dan UMKM Begawi.id.
                        </p>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">SOLUSI KEUANGAN</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
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
