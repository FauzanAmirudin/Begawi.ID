<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 glassmorphism">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/Logo-Begawi.png') }}" alt="Begawi.id" class="w-10 h-10 object-contain">
                <div class="font-manrope font-extrabold text-xl text-gradient">
                    Begawi.id
                </div>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="liquid-underline font-medium text-charcoal-grey hover:text-emerald-600 transition-colors">
                    Beranda
                </a>
                <a href="{{ route('templates') }}" class="liquid-underline font-medium text-charcoal-grey hover:text-emerald-600 transition-colors">
                    Template & Fitur
                </a>
                <a href="{{ route('directory') }}" class="liquid-underline font-medium text-charcoal-grey hover:text-emerald-600 transition-colors">
                    Direktori
                </a>
                <a href="{{ route('about') }}" class="liquid-underline font-medium text-charcoal-grey hover:text-emerald-600 transition-colors">
                    Tentang
                </a>
                <a href="{{ route('education') }}" class="liquid-underline font-medium text-charcoal-grey hover:text-emerald-600 transition-colors">
                    Edukasi
                </a>
                <a href="{{ route('contact') }}" class="liquid-underline font-medium text-charcoal-grey hover:text-emerald-600 transition-colors">
                    Kontak
                </a>
            </div>
            
            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <button id="themeToggle" class="w-10 h-10 rounded-lg glassmorphism hover-glow flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>
                
                <!-- CTA Button -->
                <a href="#" class="hidden lg:inline-flex items-center px-6 py-2.5 bg-gradient-accent text-white font-poppins font-semibold text-sm rounded-xl hover-glow transition-all">
                    <span class="mr-2">🚀</span>
                    Buat Website
                </a>
                
                <!-- Login Button -->
                @guest
                    <a href="{{ route('login') }}" class="hidden lg:inline-flex items-center px-4 py-2 border border-emerald-600 text-emerald-600 font-medium text-sm rounded-lg hover:bg-emerald-600 hover:text-white transition-all">
                        Login
                    </a>
                @else
                    <a href="{{ route('admin.dashboard.index') }}" class="hidden lg:inline-flex items-center px-4 py-2 border border-emerald-600 text-emerald-600 font-medium text-sm rounded-lg hover:bg-emerald-600 hover:text-white transition-all">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="hidden lg:block">
                        @csrf
                        <button type="submit" class="lg:ml-2 inline-flex items-center px-4 py-2 border border-gray-200 text-gray-600 font-medium text-sm rounded-lg hover:bg-gray-100 transition-all">
                            Keluar
                        </button>
                    </form>
                @endguest
                
                <!-- Mobile Menu Button -->
                <button id="mobileMenuToggle" class="lg:hidden w-10 h-10 rounded-lg glassmorphism flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="lg:hidden hidden bg-white border-t border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col space-y-4">
                <a href="{{ route('home') }}" class="font-medium text-charcoal-grey hover:text-emerald-600 transition-colors">
                    Beranda
                </a>
                <a href="{{ route('templates') }}" class="font-medium text-charcoal-grey hover:text-emerald-600 transition-colors">
                    Template & Fitur
                </a>
                <a href="{{ route('directory') }}" class="font-medium text-charcoal-grey hover:text-emerald-600 transition-colors">
                    Direktori
                </a>
                <a href="{{ route('about') }}" class="font-medium text-charcoal-grey hover:text-emerald-600 transition-colors">
                    Tentang
                </a>
                <a href="{{ route('education') }}" class="font-medium text-charcoal-grey hover:text-emerald-600 transition-colors">
                    Edukasi
                </a>
                <a href="{{ route('contact') }}" class="font-medium text-charcoal-grey hover:text-emerald-600 transition-colors">
                    Kontak
                </a>
                <div class="pt-4 border-t border-gray-200 flex flex-col space-y-3">
                    <a href="#" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-accent text-white font-poppins font-semibold text-sm rounded-xl">
                        <span class="mr-2">🚀</span>
                        Buat Website
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 border border-emerald-600 text-emerald-600 font-medium text-sm rounded-lg">
                            Login
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-emerald-600 text-emerald-600 font-medium text-sm rounded-lg">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full mt-3 inline-flex items-center justify-center px-4 py-2 border border-gray-200 text-gray-600 font-medium text-sm rounded-lg">
                                Keluar
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</nav>