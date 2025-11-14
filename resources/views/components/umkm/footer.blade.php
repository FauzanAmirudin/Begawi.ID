{{-- 
  File: resources/views/components/umkm/footer.blade.php
  Footer responsive dengan dark/light theme dan ikon sosial media
--}}
<footer class="bg-primary-dark dark:bg-dark border-t border-gray-200 dark:border-gray-700 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- Bagian Atas: Logo & Navigasi Cepat --}}
        <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-8 md:gap-16">
            
            {{-- Brand / Logo --}}
            <div class="text-center md:text-left">
                <a href="{{ route('umkm.home') }}" class="text-2xl font-semibold text-light dark:text-light">
                    Sneaky
                </a>
                <p class="mt-1 text-sm text-light ">
                    Sneak Your Way.
                </p>
            </div>
            
            {{-- Navigasi Cepat --}}
            <nav class="flex flex-wrap justify-center md:justify-start gap-4 md:gap-6">
                <a href="{{ route('umkm.home') }}" class="text-sm font-medium text-light hover:text-accent dark:hover:text-primary-light transition-colors">
                    Home
                </a>
                <a href="{{ route('umkm.product') }}" class="text-sm font-medium text-light hover:text-accent dark:hover:text-primary-light transition-colors">
                    Produk
                </a>
                <a href="{{ route('umkm.about') }}" class="text-sm font-medium text-light hover:text-accent dark:hover:text-primary-light transition-colors">
                    Tentang Kami
                </a>
            </nav>
        </div>

        {{-- Garis Pemisah --}}
        <div class="mt-10 pt-8 border-t border-white dark:border-primary-light"></div>

        {{-- Bagian Bawah: Copyright & Sosial Media --}}
        <div class="flex flex-col-reverse sm:flex-row justify-between items-center sm:items-center gap-6 mt-4">
            
            {{-- Copyright --}}
            <span class="text-sm text-light text-center sm:text-left">
                &copy; {{ date('Y') }} Sneaky. All rights reserved.
            </span>

            {{-- Ikon Sosial Media --}}
            <div class="flex gap-6">
                {{-- Instagram --}}
                        <a href="{{ $socials['instagram'] }}" target="_blank" class="text-light dark:text-white hover:text-accent dark:hover:text-primary-light
              transition-transform transform hover:scale-110">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.75 2A5.75 5.75 0 0 0 2 7.75v8.5A5.75 5.75 0 0 0 7.75 22h8.5A5.75 5.75 0 0 0 22 16.25v-8.5A5.75 5.75 0 0 0 16.25 2h-8.5Zm8.75 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2Zm-4.5 2.25A4.25 4.25 0 1 1 7.75 11.5a4.25 4.25 0 0 1 4.25-4.25Zm0 2a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                            </svg>
                        </a>

                        {{-- Facebook --}}
                        <a href="{{ $socials['facebook'] }}" target="_blank" class="text-light dark:text-white hover:text-accent dark:hover:text-primary-light
              transition-transform transform hover:scale-110">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M13.5 9H16V6h-2.5c-2.1 0-3.5 1.4-3.5 3.5V12H8v3h2.5v7h3v-7H16l.5-3h-3v-2.5c0-.7.3-1.5 1-1.5Z" />
                            </svg>
                        </a>

                        {{-- TikTok --}}
                        <a href="{{ $socials['tiktok'] }}" target="_blank" class="text-light dark:text-white hover:text-accent dark:hover:text-primary-light
              transition-transform transform hover:scale-110">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.75 2h3.25c.1 1.2.6 2.3 1.5 3s2 .9 3.1 1v3.2c-1.7 0-3.4-.5-4.8-1.5v7.3c0 3.2-2.7 5.8-6 5.8S4.75 18.2 4.75 15s2.7-5.8 6-5.8c.3 0 .7 0 1 .1v3.3c-.3-.1-.6-.2-1-.2-1.4 0-2.5 1.1-2.5 2.5S9.35 17.5 10.75 17.5s2.5-1.1 2.5-2.5V2Z" />
                            </svg>
                        </a>
            </div>
        </div>
    </div>
</footer>

