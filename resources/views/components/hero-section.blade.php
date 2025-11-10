<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Video -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero-bg.png') }}" alt="Latar belakang Begawi.id" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-charcoal-grey/70 to-black/60"></div>
    </div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 z-10">
        <div class="absolute top-20 left-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-400/10 rounded-full blur-3xl animate-float" style="animation-delay: -1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-r from-emerald-500/5 to-emerald-400/5 rounded-full blur-3xl animate-pulse"></div>
    </div>
    
    <!-- Content -->
    <div class="relative z-20 container mx-auto px-4 text-center pt-24 md:pt-32">
        <div class="max-w-4xl mx-auto">
            
            <!-- Main Heading -->
            <h1 class="font-manrope font-extrabold text-4xl md:text-6xl lg:text-7xl text-white mb-6 animate-fadeInUp" style="animation-delay: 0.2s;">
                Digitalisasi Desa dan UMKM.
                <span class="text-white">
                    Mulai dari Begawi.id
                </span>
            </h1>
            
            <!-- Subheading -->
            <p class="text-xl md:text-2xl text-gray-200 mb-8 max-w-3xl mx-auto leading-relaxed animate-fadeInUp" style="animation-delay: 0.4s;">
                Bangun website profesional gratis, kelola mandiri, dan kembangkan ekosistem digital lokal tanpa keahlian teknis.
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6 mb-12 animate-fadeInUp" style="animation-delay: 0.6s;">
                <a href="#" class="group inline-flex items-center px-8 py-4 bg-gradient-accent text-white font-poppins font-semibold text-lg rounded-xl hover-glow transition-all transform hover:scale-105">
                    <span class="mr-3 text-xl group-hover:animate-bounce">🚀</span>
                    Buat Website Gratis
                    <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="#" class="group inline-flex items-center px-8 py-4 glassmorphism text-white font-medium text-lg rounded-xl hover:bg-white/20 transition-all">
                    <span class="mr-3 text-xl">👁️</span>
                    Lihat Template
                    <div class="ml-2 w-5 h-5 border-2 border-current border-t-transparent rounded-full animate-spin opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </a>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="animate-bounce">
                <svg class="w-6 h-6 text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute bottom-10 left-10 z-20 animate-float">
        <div class="w-16 h-16 glassmorphism rounded-xl flex items-center justify-center text-emerald-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>
    </div>
    
    <div class="absolute bottom-20 right-20 z-20 animate-float" style="animation-delay: -0.5s;">
        <div class="w-20 h-20 glassmorphism rounded-full flex items-center justify-center text-emerald-300">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
            </svg>
        </div>
    </div>
</section>