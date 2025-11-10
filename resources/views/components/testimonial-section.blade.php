<section class="py-20 bg-gray-900 relative overflow-hidden">
    <!-- Random Green Pattern Background -->
    <div class="absolute inset-0 pointer-events-none">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <defs>
                <!-- Fractal noise for random grain pattern -->
                <filter id="greenNoise">
                    <feTurbulence type="fractalNoise" baseFrequency="0.7" numOctaves="3" stitchTiles="stitch" seed="7" />
                    <feColorMatrix type="matrix" values="
                        0 0 0 0 0
                        0 0 0 0.9 0
                        0 0 0 0 0
                        0 0 0 0.18 0" />
                </filter>
                <!-- Subtle dot overlay -->
                <pattern id="dots" width="28" height="28" patternUnits="userSpaceOnUse">
                    <circle cx="6" cy="10" r="1.2" fill="#10b981" />
                    <circle cx="20" cy="4" r="1" fill="#34d399" />
                    <circle cx="14" cy="22" r="1" fill="#059669" />
                    <circle cx="2" cy="2" r="0.8" fill="#22c55e" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="#10232f" />
            <rect width="100%" height="100%" filter="url(#greenNoise)" />
            <rect width="100%" height="100%" fill="url(#dots)" opacity="0.35" />
        </svg>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <h2 class="font-manrope font-extrabold text-4xl md:text-5xl text-white mb-4">
                Cerita Sukses dari
                    <span class="text-gradient bg-gradient-to-r from-emerald-500 to-emerald-300 bg-clip-text text-transparent">
                    Komunitas Kami
                </span>
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Dengarkan langsung dari para pengguna yang telah merasakan manfaat Begawi.id
            </p>
        </div>
        
        <!-- Testimonial Carousel (Auto-scrolling marquee) -->
        <div class="testimonial-carousel relative">
            <div class="marquee overflow-hidden">
                <div class="marquee-track flex items-stretch gap-6">
                <!-- Testimonial Card 1 -->
                <div class="testimonial-card flex-shrink-0 w-80 lg:w-96">
                    <div class="glassmorphism-dark rounded-2xl p-8 h-full hover-glow transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <img src="{{ asset('images/testimonials/pak-budi.jpg') }}" alt="Pak Budi" class="w-16 h-16 rounded-full object-cover mr-4">
                            <div>
                                <h4 class="font-poppins font-semibold text-white text-lg">Pak Budi Santoso</h4>
                                <p class="text-emerald-400 text-sm">Kepala Desa Sukamaju</p>
                                <div class="flex text-yellow-400 mt-1">
                                    <span>⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                        </div>
                        <blockquote class="text-gray-300 text-base leading-relaxed mb-4">
                            "Berkat Begawi.id, desa kami kini punya website profesional yang memudahkan warga mengakses informasi. Pelayanan administrasi jadi lebih efisien dan transparan. Luar biasa!"
                        </blockquote>
                        <div class="flex items-center text-sm text-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            Desa Sukamaju, Jawa Barat
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial Card 2 -->
                <div class="testimonial-card flex-shrink-0 w-80 lg:w-96">
                    <div class="glassmorphism-dark rounded-2xl p-8 h-full hover-glow transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <img src="{{ asset('images/testimonials/ibu-sari.jpg') }}" alt="Ibu Sari" class="w-16 h-16 rounded-full object-cover mr-4">
                            <div>
                                <h4 class="font-poppins font-semibold text-white text-lg">Ibu Sari Dewi</h4>
                                <p class="text-emerald-400 text-sm">Owner Batik Nusantara</p>
                                <div class="flex text-yellow-400 mt-1">
                                    <span>⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                        </div>
                        <blockquote class="text-gray-300 text-base leading-relaxed mb-4">
                            "Sebagai pemilik UMKM, saya sangat terbantu dengan template e-commerce Begawi.id. Penjualan online meningkat 300% dalam 3 bulan. Fitur pembayarannya juga lengkap!"
                        </blockquote>
                        <div class="flex items-center text-sm text-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Batik Nusantara, Yogyakarta
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial Card 3 -->
                <div class="testimonial-card flex-shrink-0 w-80 lg:w-96">
                    <div class="glassmorphism-dark rounded-2xl p-8 h-full hover-glow transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <img src="{{ asset('images/testimonials/mas-andi.jpg') }}" alt="Mas Andi" class="w-16 h-16 rounded-full object-cover mr-4">
                            <div>
                                <h4 class="font-poppins font-semibold text-white text-lg">Mas Andi Pratama</h4>
                                <p class="text-purple-400 text-sm">Ketua Karang Taruna</p>
                                <div class="flex text-yellow-400 mt-1">
                                    <span>⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                        </div>
                        <blockquote class="text-gray-300 text-base leading-relaxed mb-4">
                            "Platform yang user-friendly banget! Kami bisa bikin website komunitas tanpa ribet. Fitur event management-nya membantu koordinasi kegiatan pemuda desa."
                        </blockquote>
                        <div class="flex items-center text-sm text-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            Karang Taruna Maju Bersama
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial Card 4 -->
                <div class="testimonial-card flex-shrink-0 w-80 lg:w-96">
                    <div class="glassmorphism-dark rounded-2xl p-8 h-full hover-glow transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <img src="{{ asset('images/testimonials/ibu-rina.jpg') }}" alt="Ibu Rina" class="w-16 h-16 rounded-full object-cover mr-4">
                            <div>
                                <h4 class="font-poppins font-semibold text-white text-lg">Ibu Rina Kusuma</h4>
                                <p class="text-pink-400 text-sm">Pengrajin Kerajinan Tangan</p>
                                <div class="flex text-yellow-400 mt-1">
                                    <span>⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                        </div>
                        <blockquote class="text-gray-300 text-base leading-relaxed mb-4">
                            "Dulunya susah jual kerajinan online, sekarang dengan Begawi.id semua jadi mudah. Katalog produk rapi, sistem ordernya jelas, customer puas!"
                        </blockquote>
                        <div class="flex items-center text-sm text-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Kerajinan Nusantara
                        </div>
                    </div>
                </div>

                    <!-- Duplicate set for seamless loop -->
                    <div class="testimonial-card flex-shrink-0 w-80 lg:w-96">
                        <div class="glassmorphism-dark rounded-2xl p-8 h-full hover-glow transition-all duration-300">
                            <div class="flex items-center mb-6">
                                <img src="{{ asset('images/testimonials/pak-budi.jpg') }}" alt="Pak Budi" class="w-16 h-16 rounded-full object-cover mr-4">
                                <div>
                                    <h4 class="font-poppins font-semibold text-white text-lg">Pak Budi Santoso</h4>
                                    <p class="text-emerald-400 text-sm">Kepala Desa Sukamaju</p>
                                    <div class="flex text-yellow-400 mt-1">
                                        <span>⭐⭐⭐⭐⭐</span>
                                    </div>
                                </div>
                            </div>
                            <blockquote class="text-gray-300 text-base leading-relaxed mb-4">
                                "Berkat Begawi.id, desa kami kini punya website profesional yang memudahkan warga mengakses informasi. Pelayanan administrasi jadi lebih efisien dan transparan. Luar biasa!"
                            </blockquote>
                            <div class="flex items-center text-sm text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                Desa Sukamaju, Jawa Barat
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card flex-shrink-0 w-80 lg:w-96">
                        <div class="glassmorphism-dark rounded-2xl p-8 h-full hover-glow transition-all duration-300">
                            <div class="flex items-center mb-6">
                                <img src="{{ asset('images/testimonials/ibu-sari.jpg') }}" alt="Ibu Sari" class="w-16 h-16 rounded-full object-cover mr-4">
                                <div>
                                    <h4 class="font-poppins font-semibold text-white text-lg">Ibu Sari Dewi</h4>
                                    <p class="text-emerald-400 text-sm">Owner Batik Nusantara</p>
                                    <div class="flex text-yellow-400 mt-1">
                                        <span>⭐⭐⭐⭐⭐</span>
                                    </div>
                                </div>
                            </div>
                            <blockquote class="text-gray-300 text-base leading-relaxed mb-4">
                                "Sebagai pemilik UMKM, saya sangat terbantu dengan template e-commerce Begawi.id. Penjualan online meningkat 300% dalam 3 bulan. Fitur pembayarannya juga lengkap!"
                            </blockquote>
                            <div class="flex items-center text-sm text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Batik Nusantara, Yogyakarta
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card flex-shrink-0 w-80 lg:w-96">
                        <div class="glassmorphism-dark rounded-2xl p-8 h-full hover-glow transition-all duration-300">
                            <div class="flex items-center mb-6">
                                <img src="{{ asset('images/testimonials/mas-andi.jpg') }}" alt="Mas Andi" class="w-16 h-16 rounded-full object-cover mr-4">
                                <div>
                                    <h4 class="font-poppins font-semibold text-white text-lg">Mas Andi Pratama</h4>
                                    <p class="text-purple-400 text-sm">Ketua Karang Taruna</p>
                                    <div class="flex text-yellow-400 mt-1">
                                        <span>⭐⭐⭐⭐⭐</span>
                                    </div>
                                </div>
                            </div>
                            <blockquote class="text-gray-300 text-base leading-relaxed mb-4">
                                "Platform yang user-friendly banget! Kami bisa bikin website komunitas tanpa ribet. Fitur event management-nya membantu koordinasi kegiatan pemuda desa."
                            </blockquote>
                            <div class="flex items-center text-sm text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Karang Taruna Maju Bersama
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card flex-shrink-0 w-80 lg:w-96">
                        <div class="glassmorphism-dark rounded-2xl p-8 h-full hover-glow transition-all duration-300">
                            <div class="flex items-center mb-6">
                                <img src="{{ asset('images/testimonials/ibu-rina.jpg') }}" alt="Ibu Rina" class="w-16 h-16 rounded-full object-cover mr-4">
                                <div>
                                    <h4 class="font-poppins font-semibold text-white text-lg">Ibu Rina Kusuma</h4>
                                    <p class="text-pink-400 text-sm">Pengrajin Kerajinan Tangan</p>
                                    <div class="flex text-yellow-400 mt-1">
                                        <span>⭐⭐⭐⭐⭐</span>
                                    </div>
                                </div>
                            </div>
                            <blockquote class="text-gray-300 text-base leading-relaxed mb-4">
                                "Dulunya susah jual kerajinan online, sekarang dengan Begawi.id semua jadi mudah. Katalog produk rapi, sistem ordernya jelas, customer puas!"
                            </blockquote>
                            <div class="flex items-center text-sm text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Kerajinan Nusantara
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>