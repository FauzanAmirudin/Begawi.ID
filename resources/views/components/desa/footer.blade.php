<footer class="bg-green-900 text-white">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Brand -->
            <div class="lg:col-span-1">
                <div class="flex items-center space-x-3 mb-6">
                    <img src="https://via.placeholder.com/50x50" alt="Logo Desa" class="w-12 h-12 rounded-full">
                    <div>
                        <h3 class="font-display font-bold text-xl">Desa Sejahtera</h3>
                        <p class="text-green-200 text-sm">Kabupaten Makmur</p>
                    </div>
                </div>
                <p class="text-green-100 leading-relaxed">
                    Membangun desa yang maju, mandiri, dan sejahtera melalui gotong royong dan inovasi berkelanjutan.
                </p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="font-display font-semibold text-lg mb-6">Tautan Cepat</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('desa.home') }}" class="text-green-100 hover:text-yellow-400 transition-colors">Beranda</a></li>
                    <li><a href="{{ route('desa.about') }}" class="text-green-100 hover:text-yellow-400 transition-colors">Tentang Desa</a></li>
                    <li><a href="{{ route('desa.education') }}" class="text-green-100 hover:text-yellow-400 transition-colors">Pendidikan</a></li>
                    <li><a href="{{ route('desa.directory') }}" class="text-green-100 hover:text-yellow-400 transition-colors">Direktori</a></li>
                </ul>
            </div>
            
            <!-- Services -->
            <div>
                <h4 class="font-display font-semibold text-lg mb-6">Layanan</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="text-green-100 hover:text-yellow-400 transition-colors">Surat Keterangan</a></li>
                    <li><a href="#" class="text-green-100 hover:text-yellow-400 transition-colors">Pelayanan KTP</a></li>
                    <li><a href="#" class="text-green-100 hover:text-yellow-400 transition-colors">Surat Domisili</a></li>
                    <li><a href="#" class="text-green-100 hover:text-yellow-400 transition-colors">Pengaduan Online</a></li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h4 class="font-display font-semibold text-lg mb-6">Kontak</h4>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-green-300 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        <p class="text-green-100 text-sm">Jl. Desa Sejahtera No. 123<br>Kabupaten Makmur, 12345</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <p class="text-green-100 text-sm">(021) 123-4567</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-green-100 text-sm">info@desasejahtera.id</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="border-t border-green-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-green-200 text-sm">© 2024 Desa Sejahtera. Semua hak cipta dilindungi.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="{{ route('desa.privacy') }}" class="text-green-200 hover:text-yellow-400 text-sm transition-colors">Kebijakan Privasi</a>
                <a href="{{ route('desa.terms') }}" class="text-green-200 hover:text-yellow-400 text-sm transition-colors">Syarat & Ketentuan</a>
                <a href="{{ route('desa.sitemap') }}" class="text-green-200 hover:text-yellow-400 text-sm transition-colors">Peta Situs</a>
            </div>
        </div>
    </div>
</footer>