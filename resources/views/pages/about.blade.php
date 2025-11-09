@extends('layouts.app')

@section('title', 'Tentang Begawi.id - Misi Digitalisasi Indonesia')
@section('description', 'Pelajari visi, misi, dan cerita di balik Begawi.id. Platform yang berkomitmen memajukan digitalisasi desa dan UMKM Indonesia.')

@section('content')
    <!-- Hero Section -->
    <section class="pt-24 pb-12 bg-gradient-to-br from-charcoal-grey to-gray-900 text-white relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 right-0 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl animate-float" style="animation-delay: -2s;"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="font-manrope font-extrabold text-4xl md:text-6xl mb-6">
                    Membangun Indonesia Digital
                    <span class="text-gradient bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">
                        dari Akar Rumput
                    </span>
                </h1>
                <p class="text-xl text-gray-300 mb-8 leading-relaxed max-w-3xl mx-auto">
                    Begawi.id lahir dari visi untuk mewujudkan Indonesia yang digital dan inklusif. Kami percaya bahwa setiap desa dan UMKM berhak mendapatkan akses teknologi yang mudah dan terjangkau.
                </p>
                
                <!-- Key Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-emerald-400 mb-2">2024</div>
                        <div class="text-sm text-gray-400">Tahun Berdiri</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-400 mb-2">1,250+</div>
                        <div class="text-sm text-gray-400">Desa Aktif</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-400 mb-2">3,420+</div>
                        <div class="text-sm text-gray-400">UMKM Digital</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-orange-400 mb-2">34</div>
                        <div class="text-sm text-gray-400">Provinsi</div>
                    </div>
                </div>
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
                        <div class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-800 rounded-full text-sm font-semibold mb-6">
                            🎯 MISI KAMI
                        </div>
                        <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                            Memberdayakan Setiap Desa dan UMKM
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-6 text-lg">
                            Kami berkomitmen untuk memberikan akses teknologi yang mudah, terjangkau, dan berkelanjutan kepada seluruh lapisan masyarakat Indonesia. Melalui platform Begawi.id, kami ingin menjadi jembatan menuju transformasi digital yang inklusif.
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-emerald-600 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-charcoal-grey mb-1">Akses Teknologi untuk Semua</h3>
                                    <p class="text-gray-600 text-sm">Memberikan platform gratis dan mudah digunakan tanpa batasan geografis</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-emerald-600 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-charcoal-grey mb-1">Pemberdayaan Ekonomi Lokal</h3>
                                    <p class="text-gray-600 text-sm">Membantu UMKM berkembang melalui digitalisasi dan e-commerce</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="w-6 h-6 bg-emerald-600 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-charcoal-grey mb-1">Transparansi & Akuntabilitas</h3>
                                    <p class="text-gray-600 text-sm">Mendorong tata kelola yang baik melalui transparansi digital</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Vision Image -->
                    <div class="relative">
                        <img src="{{ asset('images/about/mission.jpg') }}" alt="Mission" class="w-full rounded-2xl shadow-2xl">
                        <div class="absolute inset-0 bg-gradient-to-tr from-emerald-600/20 to-transparent rounded-2xl"></div>
                        <!-- Floating Elements -->
                        <div class="absolute -top-6 -right-6 w-24 h-24 bg-emerald-600 rounded-2xl flex items-center justify-center text-white text-2xl animate-float">
                            🚀
                        </div>
                        <div class="absolute -bottom-6 -left-6 w-20 h-20 bg-blue-600 rounded-xl flex items-center justify-center text-white text-xl animate-float" style="animation-delay: -1s;">
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
                    <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-emerald-400 to-blue-400 rounded-full"></div>
                    
                    <!-- Timeline Items -->
                    <div class="space-y-12">
                        <!-- Item 1 -->
                        <div class="flex items-center">
                            <div class="w-1/2 pr-8 text-right">
                                <div class="bg-white rounded-xl p-6 shadow-lg">
                                    <div class="text-emerald-600 font-bold text-sm mb-2">2023 - AWAL MULA</div>
                                    <h3 class="font-poppins font-bold text-lg mb-3">Identifikasi Masalah</h3>
                                    <p class="text-gray-600 text-sm">
                                        Riset mendalam tentang kesenjangan digital di desa-desa Indonesia. Kami menemukan 70% desa belum memiliki website resmi.
                                    </p>
                                </div>
                            </div>
                            <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-emerald-500 rounded-full border-4 border-white shadow-lg z-10"></div>
                            <div class="w-1/2 pl-8"></div>
                        </div>
                        
                        <!-- Item 2 -->
                        <div class="flex items-center">
                            <div class="w-1/2 pr-8"></div>
                            <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-blue-500 rounded-full border-4 border-white shadow-lg z-10"></div>
                            <div class="w-1/2 pl-8">
                                <div class="bg-white rounded-xl p-6 shadow-lg">
                                    <div class="text-blue-600 font-bold text-sm mb-2">2024 - PENGEMBANGAN</div>
                                    <h3 class="font-poppins font-bold text-lg mb-3">Membangun Solusi</h3>
                                    <p class="text-gray-600 text-sm">
                                        Mengembangkan platform dengan fokus pada kemudahan penggunaan dan kebutuhan spesifik Indonesia.
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
                            <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-purple-500 rounded-full border-4 border-white shadow-lg z-10"></div>
                            <div class="w-1/2 pl-8"></div>
                        </div>
                        
                        <!-- Item 4 -->
                        <div class="flex items-center">
                            <div class="w-1/2 pr-8"></div>
                            <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-orange-500 rounded-full border-4 border-white shadow-lg z-10"></div>
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Team Member 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                    <div class="relative mb-6">
                        <img src="{{ asset('images/team/ceo.jpg') }}" alt="CEO" class="w-24 h-24 rounded-full mx-auto object-cover">
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-600 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Andi Prasetyo</h3>
                    <p class="text-emerald-600 font-semibold mb-4">CEO & Founder</p>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                        10+ tahun pengalaman dalam teknologi dan pemberdayaan masyarakat. Alumni ITB dengan passion untuk Indonesia digital.
                    </p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 hover:bg-gray-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Team Member 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                    <div class="relative mb-6">
                        <img src="{{ asset('images/team/cto.jpg') }}" alt="CTO" class="w-24 h-24 rounded-full mx-auto object-cover">
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Sari Indrawati</h3>
                    <p class="text-blue-600 font-semibold mb-4">CTO & Co-Founder</p>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                        Expert dalam pengembangan platform scalable. Berpengalaman membangun sistem untuk jutaan pengguna.
                    </p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 hover:bg-purple-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Team Member 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                    <div class="relative mb-6">
                        <img src="{{ asset('images/team/cmo.jpg') }}" alt="CMO" class="w-24 h-24 rounded-full mx-auto object-cover">
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Budi Hartono</h3>
                    <p class="text-purple-600 font-semibold mb-4">Head of Community</p>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                        Ahli dalam community building dan digital marketing. Fokus pada pengembangan ekosistem pengguna.
                    </p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600 hover:bg-green-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Values Section -->
    <section class="py-20 bg-gradient-to-br from-emerald-50 to-blue-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-6">
                    Nilai-Nilai
                    <span class="text-gradient">yang Kami Junjung</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Prinsip-prinsip yang memandu setiap langkah kami dalam membangun Indonesia digital
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Value 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl">🤝</span>
                    </div>
                    <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-4">Inklusivitas</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kami percaya teknologi harus dapat diakses oleh semua orang, tanpa memandang latar belakang ekonomi atau geografis.
                    </p>
                </div>
                
                <!-- Value 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl">💎</span>
                    </div>
                    <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-4">Kualitas</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Setiap produk dan layanan yang kami berikan harus memenuhi standar kualitas tertinggi dan memberikan nilai nyata.
                    </p>
                </div>
                
                <!-- Value 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl">🌱</span>
                    </div>
                    <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-4">Keberlanjutan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kami membangun solusi yang berkelanjutan untuk jangka panjang, mendukung pertumbuhan ekonomi lokal.
                    </p>
                </div>
                
                <!-- Value 4 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl">🔒</span>
                    </div>
                    <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-4">Transparansi</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Keterbukaan dalam setiap aspek bisnis kami, dari pengembangan produk hingga penggunaan data pengguna.
                    </p>
                </div>
                
                <!-- Value 5 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                    <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl">🚀</span>
                    </div>
                    <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-4">Inovasi</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Terus berinovasi untuk menghadirkan solusi terdepan yang sesuai dengan perkembangan teknologi.
                    </p>
                </div>
                
                <!-- Value 6 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="text-2xl">❤️</span>
                    </div>
                    <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-4">Empati</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Memahami kebutuhan dan tantangan yang dihadapi masyarakat Indonesia dalam era digital.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-charcoal-grey to-gray-900">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-white mb-6">
                    Bergabunglah dalam Misi
                    <span class="text-gradient bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">
                        Indonesia Digital
                    </span>
                </h2>
                <p class="text-xl text-gray-300 mb-8">
                    Jadilah bagian dari perubahan. Mari bersama-sama membangun Indonesia yang lebih digital dan inklusif.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-all">
                        <span class="mr-2">🚀</span>
                        Mulai Sekarang
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 border border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 transition-all">
                        <span class="mr-2">💬</span>
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