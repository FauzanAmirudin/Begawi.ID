<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between py-4">
            <!-- Logo & Brand -->
            <div class="flex items-center space-x-3">
                <img src="https://via.placeholder.com/50x50" alt="Logo Desa" class="w-12 h-12 rounded-full">
                <div>
                    <h1 class="font-display font-bold text-xl text-green-900">Desa Sejahtera</h1>
                    <p class="text-xs text-slate-600">Kabupaten Makmur</p>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('desa.home') }}" class="text-slate-700 hover:text-green-700 font-medium transition {{ request()->routeIs('desa.home') ? 'text-green-700 font-semibold' : '' }}">Beranda</a>
                <a href="{{ route('desa.about') }}" class="text-slate-700 hover:text-green-700 font-medium transition {{ request()->routeIs('desa.about') ? 'text-green-700 font-semibold' : '' }}">Tentang</a>
                
                <!-- Dropdown Berita -->
                <div class="relative group">
                    <a href="{{ route('desa.berita.index') }}" class="text-slate-700 hover:text-green-700 font-medium transition flex items-center {{ request()->routeIs('desa.berita.*') ? 'text-green-700 font-semibold' : '' }}">
                        Berita
                        <svg class="w-4 h-4 ml-1 group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div class="absolute top-full left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="py-2">
                            <a href="{{ route('desa.berita.index') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-green-50 hover:text-green-700">📰 Semua Berita</a>
                            <a href="{{ route('desa.berita.agenda') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-green-50 hover:text-green-700">📅 Agenda Kegiatan</a>
                            <a href="{{ route('desa.berita.arsip') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-green-50 hover:text-green-700">📂 Arsip Berita</a>
                        </div>
                    </div>
                </div>
                
                <!-- Menu UMKM -->
                <a href="{{ route('desa.umkm.index') }}" class="text-slate-700 hover:text-green-700 font-medium transition {{ request()->routeIs('desa.umkm.*') ? 'text-green-700 font-semibold' : '' }}">UMKM</a>
                <a href="{{ route('desa.layanan.index') }}" class="text-slate-700 hover:text-green-700 font-medium transition {{ request()->routeIs('desa.layanan.*') ? 'text-green-700 font-semibold' : '' }}">Layanan</a>
                <a href="{{ route('desa.pusat-bantuan.index') }}" class="text-slate-700 hover:text-green-700 font-medium transition {{ request()->routeIs('desa.pusat-bantuan.*') ? 'text-green-700 font-semibold' : '' }}">Pusat Bantuan</a>
                <a href="{{ route('desa.contact') }}" class="text-slate-700 hover:text-green-700 font-medium transition {{ request()->routeIs('desa.contact') ? 'text-green-700 font-semibold' : '' }}">Kontak</a>
            </nav>
            
            
            <!-- Mobile Menu Button -->
            <button class="md:hidden p-2 rounded-lg hover:bg-slate-100 transition" id="mobile-menu-btn">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div class="md:hidden hidden pb-4" id="mobile-menu">
            <nav class="flex flex-col space-y-3">
                <a href="{{ route('desa.home') }}" class="text-slate-700 hover:text-green-700 font-medium transition py-2 {{ request()->routeIs('desa.home') ? 'text-green-700 font-semibold' : '' }}">Beranda</a>
                <a href="{{ route('desa.about') }}" class="text-slate-700 hover:text-green-700 font-medium transition py-2 {{ request()->routeIs('desa.about') ? 'text-green-700 font-semibold' : '' }}">Tentang</a>
                <a href="{{ route('desa.layanan.index') }}" class="text-slate-700 hover:text-green-700 font-medium transition py-2 {{ request()->routeIs('desa.layanan.*') ? 'text-green-700 font-semibold' : '' }}">Layanan</a>
                <a href="{{ route('desa.directory') }}" class="text-slate-700 hover:text-green-700 font-medium transition py-2 {{ request()->routeIs('desa.directory') ? 'text-green-700 font-semibold' : '' }}">Direktori</a>
                <a href="{{ route('desa.contact') }}" class="text-slate-700 hover:text-green-700 font-medium transition py-2 {{ request()->routeIs('desa.contact') ? 'text-green-700 font-semibold' : '' }}">Kontak</a>
            </nav>
        </div>
    </div>
</header>