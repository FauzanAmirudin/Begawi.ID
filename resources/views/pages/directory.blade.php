@extends('layouts.app')

@section('title', 'Direktori Desa & UMKM - Begawi.id')
@section('description', 'Temukan desa dan UMKM terdaftar di platform Begawi.id. Jelajahi website, produk, dan layanan dari seluruh Indonesia.')

@section('content')
    <!-- Header Section -->
    <section class="pt-24 pb-12 bg-gradient-to-br from-blue-50 to-emerald-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="font-manrope font-extrabold text-4xl md:text-6xl text-charcoal-grey mb-6">
                    Direktori
                    <span class="text-gradient">Desa & UMKM</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    Jelajahi ribuan desa dan UMKM yang telah bergabung dengan ekosistem digital Begawi.id di seluruh Indonesia.
                </p>
                
                <!-- Search & Filter -->
                <div class="max-w-3xl mx-auto">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input type="text" id="directorySearch" placeholder="Cari desa, UMKM, atau produk..." class="w-full px-6 py-4 pl-12 bg-white border border-gray-300 rounded-2xl text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-lg">
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <select class="px-6 py-4 bg-white border border-gray-300 rounded-2xl text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg">
                            <option>Semua Provinsi</option>
                            <option>DKI Jakarta</option>
                            <option>Jawa Barat</option>
                            <option>Jawa Tengah</option>
                            <option>Jawa Timur</option>
                            <option>Bali</option>
                            <option>Sumatera Utara</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Interactive Map Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-poppins font-bold text-3xl text-charcoal-grey mb-4">
                    Peta Interaktif Indonesia
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Klik pada provinsi untuk melihat desa dan UMKM yang terdaftar di wilayah tersebut
                </p>
            </div>
            
            <!-- Indonesia Map -->
            <div class="bg-gradient-to-br from-blue-50 to-emerald-50 rounded-3xl p-8 shadow-lg">
                <div id="indonesiaMap" class="w-full h-96 bg-white rounded-2xl shadow-inner flex items-center justify-center">
                    <!-- Placeholder for interactive map -->
                    <div class="text-center">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        <p class="text-gray-500">Peta Interaktif Indonesia</p>
                        <p class="text-sm text-gray-400">Klik provinsi untuk detail</p>
                    </div>
                </div>
                
                <!-- Map Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                    <div class="text-center p-4 bg-white rounded-xl shadow">
                        <div class="text-2xl font-bold text-emerald-600">1,250</div>
                        <div class="text-sm text-gray-600">Desa Aktif</div>
                    </div>
                    <div class="text-center p-4 bg-white rounded-xl shadow">
                        <div class="text-2xl font-bold text-blue-600">3,420</div>
                        <div class="text-sm text-gray-600">UMKM Aktif</div>
                    </div>
                    <div class="text-center p-4 bg-white rounded-xl shadow">
                        <div class="text-2xl font-bold text-purple-600">34</div>
                        <div class="text-sm text-gray-600">Provinsi</div>
                    </div>
                    <div class="text-center p-4 bg-white rounded-xl shadow">
                        <div class="text-2xl font-bold text-orange-600">514</div>
                        <div class="text-sm text-gray-600">Kab/Kota</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Directory Categories -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-poppins font-bold text-3xl text-charcoal-grey mb-4">
                    Jelajahi Berdasarkan Kategori
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Desa Category -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <span class="text-3xl">🌾</span>
                        </div>
                        <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-4">Website Desa</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Portal informasi dan layanan publik desa di seluruh Indonesia
                        </p>
                        <div class="text-3xl font-bold text-emerald-600 mb-2">1,250</div>
                        <div class="text-sm text-gray-500 mb-6">Desa Terdaftar</div>
                        <a href="{{ route('directory.type', 'desa') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-all">
                            Jelajahi Desa
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- UMKM Category -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <span class="text-3xl">🛍️</span>
                        </div>
                        <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-4">UMKM Digital</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Toko online dan bisnis UMKM yang telah go digital
                        </p>
                        <div class="text-3xl font-bold text-blue-600 mb-2">3,420</div>
                        <div class="text-sm text-gray-500 mb-6">UMKM Aktif</div>
                        <a href="{{ route('directory.type', 'umkm') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all">
                            Jelajahi UMKM
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Community Category -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <span class="text-3xl">👥</span>
                        </div>
                        <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-4">Komunitas</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Organisasi dan komunitas yang aktif di platform
                        </p>
                        <div class="text-3xl font-bold text-purple-600 mb-2">850</div>
                        <div class="text-sm text-gray-500 mb-6">Komunitas</div>
                        <a href="{{ route('directory.type', 'komunitas') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition-all">
                            Jelajahi Komunitas
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Listings -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-poppins font-bold text-3xl text-charcoal-grey mb-4">
                    Website Pilihan Minggu Ini
                </h2>
                <p class="text-gray-600">Website terbaik dan paling aktif di platform kami</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Featured Item 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="relative">
                        <img src="{{ asset('images/directory/desa-sukamaju.jpg') }}" alt="Desa Sukamaju" class="w-full h-48 object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full">DESA</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full">⭐ FEATURED</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Desa Sukamaju</h3>
                        <p class="text-gray-600 text-sm mb-4">Desa modern dengan transparansi APBDes dan pelayanan digital terdepan</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                Jawa Barat
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                2.5k pengunjung
                            </span>
                        </div>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-all">
                            Kunjungi Website
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Featured Item 2 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="relative">
                        <img src="{{ asset('images/directory/batik-nusantara.jpg') }}" alt="Batik Nusantara" class="w-full h-48 object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">UMKM</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full">⭐ FEATURED</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Batik Nusantara</h3>
                        <p class="text-gray-600 text-sm mb-4">Toko online batik tradisional dengan kualitas premium dan desain modern</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                Yogyakarta
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                150+ produk
                            </span>
                        </div>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all">
                            Belanja Sekarang
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Featured Item 3 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="relative">
                        <img src="{{ asset('images/directory/karang-taruna.jpg') }}" alt="Karang Taruna Maju" class="w-full h-48 object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full">KOMUNITAS</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full">⭐ FEATURED</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Karang Taruna Maju</h3>
                        <p class="text-gray-600 text-sm mb-4">Organisasi pemuda desa dengan program pemberdayaan dan kegiatan sosial</p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                Bali
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                200+ anggota
                            </span>
                        </div>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-all">
                            Lihat Kegiatan
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Join Directory CTA -->
    <section class="py-16 bg-gradient-to-br from-emerald-600 to-blue-600">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-white mb-6">
                    Daftarkan Website Anda di Direktori
                </h2>
                <p class="text-xl text-emerald-100 mb-8">
                    Bergabunglah dengan ribuan desa dan UMKM lainnya. Tingkatkan visibilitas dan jangkauan Anda.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#" class="inline-flex items-center px-6 py-3 bg-white text-emerald-600 font-semibold rounded-xl hover:bg-gray-100 transition-all">
                        <span class="mr-2">📝</span>
                        Daftar Gratis
                    </a>
                    <a href="#" class="inline-flex items-center px-6 py-3 border border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 transition-all">
                        <span class="mr-2">📞</span>
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
        // Directory search functionality
        const searchInput = document.getElementById('directorySearch');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            // Implement search logic here
            console.log('Searching for:', searchTerm);
        });
        
        // Interactive map placeholder
        const mapElement = document.getElementById('indonesiaMap');
        
        mapElement.addEventListener('click', function() {
            showNotification('Fitur peta interaktif akan segera tersedia!', 'info');
        });
    });
</script>
@endpush