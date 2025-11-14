<x-umkm.layout :linkWA="$linkWA" :socials="$socials">
    <x-slot:title>
        Sneaky | Katalog Produk
    </x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Produk Unggulan -->
        <section class="mb-16">
            <div class="flex items-center gap-4">
                <div class="bg-primary w-2 h-10 rounded-full"></div>
                <h2 class="text-3xl font-bold text-dark dark:text-white flex items-center gap-3">
                    Produk Unggulan <span class="text-2xl">🌟</span>
                </h2>
            </div>

            {{-- ubah ke 4 kolom --}}
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                @foreach($produkUnggulan as $produk)
                    <div class="bg-white dark:bg-dark rounded-lg md:rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700 relative
                                transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        @if($produk['diskon'])
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-sm font-semibold bg-red-500 text-white z-10">
                                Diskon {{ $produk['diskon'] }}%
                            </span>
                        @elseif($produk['unggulan'])
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-sm font-semibold bg-accent text-dark z-10">
                                Best Seller
                            </span>
                        @endif

                        <div class="relative group">
                            <img src="{{ $produk['gambar'] }}" alt="{{ $produk['nama'] }}"
                                class="h-48 md:h-56 w-full object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>

                        <div class="p-3 md:p-5">
                            <h3 class="text-md md:text-lg font-semibold text-dark dark:text-white truncate">
                                {{ $produk['nama'] }}
                            </h3>
                            <p class="text-primary font-bold mt-2 text-md md:text-lg dark:text-primary-light">
                                Rp. {{ number_format(intval(str_replace(['Rp', '.', ','], '', $produk['harga'])), 2, ',', '.') }}
                            </p>
                            <a href="{{ route('umkm.product.show', $produk['id'] ?? '#') }}"
                               class="w-full block bg-accent mt-4 text-xs md:text-md text-dark p-2 md:p-2 text-center rounded hover:opacity-80 font-medium transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Galeri Produk -->
        <section class="mt-20">
            <div class="flex items-center gap-4">
                <div class="bg-primary w-2 h-10 rounded-full"></div>
                <h2 class="text-3xl font-bold text-dark dark:text-white flex items-center gap-3">
                    Galeri Produk <span class="text-2xl">🛍️</span>
                </h2>
            </div>

            <!-- Search & Filter -->
            <form method="GET"
                class="mt-8 mb-8 p-6 bg-white dark:bg-dark rounded-xl shadow-md border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row gap-4">
                <div class="flex-grow">
                    <label for="search" class="block text-sm font-medium text-dark dark:text-light mb-1">Cari Produk</label>
                    <input type="text" name="search" id="search" placeholder="Ketik nama produk..."
                        value="{{ request('search') }}"
                        class="w-full dark:bg-dark-light rounded-lg border-gray-300 dark:border-gray-600 shadow-sm px-3 py-2 text-dark dark:text-white
                               focus:border-accent focus:ring-accent dark:focus:border-accent dark:focus:ring-accent">
                </div>

                <div class="md:w-1/4">
                    <label for="kategori" class="block text-sm font-medium text-dark dark:text-light mb-1">Kategori</label>
                    <select name="kategori" id="kategori"
                        class="w-full dark:bg-dark-light dark:text-white rounded-lg border-gray-300 dark:border-gray-600 shadow-sm px-3 py-2
                               focus:border-accent focus:ring-accent dark:focus:border-accent dark:focus:ring-accent">
                        <option value="">Semua Kategori</option>
                        <option value="kat1" @selected(request('kategori') == 'kat1')>Kategori 1</option>
                        <option value="kat2" @selected(request('kategori') == 'kat2')>Kategori 2</option>
                        <option value="kat3" @selected(request('kategori') == 'kat3')>Kategori 3</option>
                    </select>
                </div>

                <button type="submit"
                    class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition h-fit self-end">
                    Terapkan
                </button>
            </form>

            <!-- Grid Produk -->
            {{-- ubah ke 4 kolom juga agar konsisten --}}
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                @foreach($semuaProduk as $produk)
                    <div class="bg-white dark:bg-dark-light rounded-lg shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden
                            transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative group">
                            <img src="{{ $produk['gambar'] }}" alt="{{ $produk['nama'] }}"
                                class="h-48 md:h-56 w-full object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>

                        <div class="p-3 md:p-5">
                            <h3 class="text-md md:text-lg font-semibold text-dark dark:text-white truncate">
                                {{ $produk['nama'] }}
                            </h3>
                            <p class="text-primary font-bold mt-2 text-md md:text-lg dark:text-primary-light">
                                Rp. {{ number_format(intval(str_replace(['Rp', '.', ','], '', $produk['harga'])), 2, ',', '.') }}
                            </p>
                            <a href="{{ route('umkm.product.show', $produk['id']) }}"
                               class="w-full block bg-accent mt-4 text-xs md:text-md text-dark p-2 md:p-2 text-center rounded hover:opacity-80 font-medium transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $semuaProduk->withQueryString()->links('pagination::tailwind') }}
            </div>
        </section>
    </div>
</x-umkm.layout>

