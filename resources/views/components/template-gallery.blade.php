<section class="py-20 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <h2 class="font-manrope font-extrabold text-4xl md:text-5xl text-charcoal-grey mb-4">
                Template Premium untuk
                <span class="text-gradient">Setiap Kebutuhan</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-8">
                Koleksi template yang dirancang khusus untuk desa, UMKM, dan komunitas lokal
            </p>
            
            <!-- Category Filter -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button class="category-filter active px-6 py-3 bg-gradient-accent text-white font-semibold rounded-xl transition-all hover-glow" data-category="all">
                    Semua Template
                </button>
                <button class="category-filter px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-emerald-500 hover:text-emerald-600 transition-all" data-category="desa">
                    🌾 Desa
                </button>
                <button class="category-filter px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-emerald-500 hover:text-emerald-600 transition-all" data-category="umkm">
                    🛍️ UMKM
                </button>
                <button class="category-filter px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-emerald-500 hover:text-emerald-600 transition-all" data-category="komunitas">
                    👥 Komunitas
                </button>
                <button class="category-filter px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-emerald-500 hover:text-emerald-600 transition-all" data-category="ecommerce">
                    🛒 E-Commerce
                </button>
            </div>
        </div>
        
        <!-- Template Grid -->
        <div class="template-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Template Card 1 -->
            <div class="template-card group" data-category="desa">
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover-tilt">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('images/templates/desa-modern.jpg') }}" alt="Template Desa Modern" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
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
                            <span class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full">🌾 DESA</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-2 py-1 rounded-full">GRATIS</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Desa Modern</h3>
                        <p class="text-gray-600 text-sm mb-4">Template untuk website desa dengan fitur lengkap administrasi dan informasi publik</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    1.2k
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    89
                                </span>
                            </div>
                            <div class="flex text-yellow-400">
                                ⭐⭐⭐⭐⭐
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Template Card 2 -->
            <div class="template-card group" data-category="umkm">
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover-tilt">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('images/templates/toko-online.jpg') }}" alt="Template Toko Online" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
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
                            <span class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full">🛍️ UMKM</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-orange-500 text-white text-xs font-medium px-2 py-1 rounded-full">PREMIUM</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Toko Online Pro</h3>
                        <p class="text-gray-600 text-sm mb-4">E-commerce lengkap dengan sistem pembayaran dan manajemen inventori</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    2.8k
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    156
                                </span>
                            </div>
                            <div class="flex text-yellow-400">
                                ⭐⭐⭐⭐⭐
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Template Card 3 -->
            <div class="template-card group" data-category="komunitas">
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover-tilt">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('images/templates/karang-taruna.jpg') }}" alt="Template Karang Taruna" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="absolute bottom-4 left-4 right-4 flex space-x-2">
                                <button class="flex-1 bg-white/20 backdrop-blur-sm text-white font-medium py-2 px-4 rounded-lg hover:bg-white/30 transition-all">
                                    👁️ Preview
                                </button>
                                <button class="flex-1 bg-purple-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-purple-700 transition-all">
                                    🚀 Pakai
                                </button>
                            </div>
                        </div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full">👥 KOMUNITAS</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-2 py-1 rounded-full">GRATIS</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-2">Karang Taruna</h3>
                        <p class="text-gray-600 text-sm mb-4">Template untuk organisasi pemuda dengan fitur event dan galeri kegiatan</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    856
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    43
                                </span>
                            </div>
                            <div class="flex text-yellow-400">
                                ⭐⭐⭐⭐⭐
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- More template cards... -->
        </div>
        
        <!-- Load More Button -->
        <div class="text-center mt-12">
            <button class="inline-flex items-center px-8 py-4 bg-gradient-accent text-white font-poppins font-semibold text-lg rounded-xl hover-glow transition-all">
                <span class="mr-2">🔄</span>
                Muat Template Lainnya
            </button>
        </div>
    </div>
</section>