<x-umkm.layout :linkWA="$linkWA" :socials="$socials">

    {{-- Judul Halaman --}}
    <x-slot:title>
        Beranda
    </x-slot:title>

    {{-- Banner / Hero --}}
<section class="mb-8 md:mb-12 w-full relative overflow-hidden">
    <div class="h-[500px] md:h-[700px] relative" 
         x-data="{
            images: ['/images/banner1.png', '/images/banner2.png', '/images/banner3.png'],
            current: 0,
            next() { this.current = (this.current + 1) % this.images.length; },
            init() { setInterval(() => this.next(), 3000); }
         }"
         x-init="init()"
    >
        <template x-for="(img, index) in images" :key="index">
            <img 
                :src="img"
                x-show="current === index"
                x-transition:enter="transition transform duration-1000"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition transform duration-1000 absolute inset-0"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="-translate-x-full opacity-0"
                class="absolute inset-0 w-full h-full object-cover"
                alt="slideshow image">
        </template>
    </div>
</section>



    {{-- Konten utama --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Produk Unggulan --}}
        <section class="mb-16">
            <div class="flex justify-between items-end md:px-4 mb-6">
                <h2 class="text-xl md:text-3xl font-medium text-center text-[var(--color-navy)]">
                    <img src="/images/Icon-Produk-Unggulan.png" alt="icon produk unggulan umk" class="inline-block w-10 mr-2"> Produk Unggulan Kami
                </h2>
                <a href="{{ route('umkm.product') }}" class="text-sm md:text-md font-medium text-primary-dark hover:text-primary mr-2">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($produkUnggulan as $produk)
                <div class="bg-white rounded-lg md:rounded-xl shadow-md overflow-hidden border-2 border-gray-100
                        transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <img src="{{ $produk['gambar'] }}" alt="{{ $produk['nama'] }}" class="h-48 w-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="p-3 md:p-6">
                        <h3 class="text-md md:text-lg font-medium text-[var(--color-navy)] truncate">{{ $produk['nama'] }}</h3>
                        <p class="text-md md:text-lg text-[var(--color-navy)] font-medium mt-1">
                            @if(isset($produk['harga_diskon']) && $produk['harga_diskon'] > 0)
                            <span class="line-through text-gray-400 text-sm">Rp. {{ number_format($produk['harga'], 0, ',', '.') }}</span>
                            <span class="ml-2">Rp. {{ number_format($produk['harga_diskon'], 0, ',', '.') }}</span>
                            @else
                            Rp. {{ number_format($produk['harga'], 0, ',', '.') }}
                            @endif
                        </p>

                        {{-- Tombol lihat detail --}}
                        <a href="{{ route('umkm.product.show', $produk['slug'] ?? $produk['id'] ?? '#') }}"
                            class="w-full block bg-primary-dark mt-4 text-xs md:text-md text-white p-2 md:p-2 text-center rounded hover:bg-primary font-medium transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        {{-- Produk Terbaru --}}
        <section class="mb-16">
            <div class="flex justify-between items-end md:px-4 mb-6">
                <h2 class="text-xl md:text-3xl font-medium text-center text-[var(--color-navy)]">
                    <img src="/images/Icon-Produk-Baru.png" alt="icon produk terbaru umk" class="inline-block w-10 mr-2"> Produk Terbaru
                </h2>
                <a href="{{ route('umkm.product') }}" class="text-sm md:text-md font-medium text-primary-dark hover:text-primary mr-2">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($produkTerbaru as $produk)
                <div class="bg-white rounded-lg md:rounded-xl shadow-md overflow-hidden border-2 border-gray-100
                        transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <img src="{{ $produk['gambar'] }}" alt="{{ $produk['nama'] }}" class="h-48 w-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="p-3 md:p-6">
                        <h3 class="text-md md:text-lg font-medium text-[var(--color-navy)] truncate">{{ $produk['nama'] }}</h3>
                        <p class="text-md md:text-lg text-[var(--color-navy)] font-medium mt-1">
                            @if(isset($produk['harga_diskon']) && $produk['harga_diskon'] > 0)
                            <span class="line-through text-gray-400 text-sm">Rp. {{ number_format($produk['harga'], 0, ',', '.') }}</span>
                            <span class="ml-2">Rp. {{ number_format($produk['harga_diskon'], 0, ',', '.') }}</span>
                            @else
                            Rp. {{ number_format($produk['harga'], 0, ',', '.') }}
                            @endif
                        </p>

                        {{-- Tombol lihat detail --}}
                        <a href="{{ route('umkm.product.show', $produk['slug'] ?? $produk['id'] ?? '#') }}"
                            class="w-full block bg-primary-dark mt-4 text-xs md:text-md text-white p-2 md:p-2 text-center rounded hover:bg-primary font-medium transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        {{-- CTA WhatsApp --}}
        <section id="call-to-action">
            <div class="bg-gradient-to-r from-primary-darker to-primary-dark p-8 rounded-lg text-center shadow-lg">
                <h2 class="text-2xl font-medium text-white mb-4">
                    Punya Pertanyaan atau Ingin Pesan Langsung?
                </h2>
                <p class="text-sm md:text-md text-white mb-6">
                    Klik tombol di bawah untuk terhubung langsung dengan kami via WhatsApp.
                </p>

                <a href="{{ $linkWA ?? '#' }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center px-8 md:px-10 py-4 bg-white hover:bg-gray-100 text-emerald-800 text-sm md:text-xl font-medium rounded-full shadow-md transition-transform transform hover:scale-105">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.451-4.43-9.887-9.886-9.887-5.452 0-9.887 4.434-9.889 9.886-.001 2.225.651 4.315 1.849 6.039l-1.218 4.439 4.542-1.192z" />
                    </svg>

                    Pesan Cepat via WhatsApp
                </a>
            </div>
        </section>

    </div>{{-- End Kontainer Utama --}}

</x-umkm.layout>