<x-umkm.layout :linkWA="$linkWA" :socials="$socials">
    <x-slot:title>
        Sneaky | Katalog Produk
    </x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Produk Unggulan -->
        <section class="mb-16">
            <div class="flex items-center gap-4">
                <div class="bg-primary-dark w-2 h-10 rounded-full"></div>
                <h2 class="text-3xl font-semibold text-charcoal-grey flex items-center gap-3">
                    Produk Unggulan <span class="text-2xl"><img src="/images/Icon-Produk-Unggulan.png" alt="icon produk unggulan umk" class="inline-block w-10 ml-2"></span>
                </h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                @foreach($produkUnggulan as $produk)
                    <div class="bg-white rounded-lg md:rounded-xl shadow-md overflow-hidden border-2 border-gray-100 relative
                                transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        @if($produk['diskon'])
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-sm font-semibold bg-red-500 text-white z-10">
                                Diskon {{ $produk['diskon'] }}%
                            </span>
                        @elseif($produk['unggulan'])
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-sm font-semibold bg-primary-dark text-white z-10">
                                Best Seller
                            </span>
                        @endif

                        <div class="relative group">
                            <img src="{{ $produk['gambar'] }}" alt="{{ $produk['nama'] }}"
                                class="h-48 md:h-56 w-full object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>

                        <div class="p-3 md:p-5">
                            <h3 class="text-md md:text-lg font-semibold text-[var(--color-navy)] truncate">
                                {{ $produk['nama'] }}
                            </h3>
                            <p class="text-[var(--color-navy)] font-semibold mt-2 text-md md:text-lg">
                                @if(isset($produk['harga_diskon']) && $produk['harga_diskon'] > 0)
                                    <span class="line-through text-gray-400 text-sm">Rp. {{ number_format($produk['harga'], 0, ',', '.') }}</span>
                                    <span class="ml-2">Rp. {{ number_format($produk['harga_diskon'], 0, ',', '.') }}</span>
                                @else
                                    Rp. {{ number_format($produk['harga'], 0, ',', '.') }}
                                @endif
                            </p>
                            <a href="{{ route('umkm.product.show', $produk['slug'] ?? $produk['id'] ?? '#') }}"
                               class="w-full block bg-primary-dark mt-4 text-xs md:text-md text-white p-2 md:p-2 text-center rounded hover:bg-primary font-medium transition">
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
                <div class="bg-primary-dark w-2 h-10 rounded-full"></div>
                <h2 class="text-3xl font-semibold text-charcoal-grey flex items-center gap-3">
                    Galeri Produk <span class="text-2xl"><img src="/images/Icon-Galeri-Produk.png" alt="icon produk unggulan umk" class="inline-block w-10 ml-2"></span>
                </h2>
            </div>

            <!-- Search & Filter -->
            <form method="GET"
                class="mt-8 mb-8 p-6 bg-white rounded-xl shadow-md border-2 border-gray-100 flex flex-col md:flex-row gap-4">
                <div class="flex-grow">
                    <label for="search" class="block text-sm font-medium text-[var(--color-navy)] mb-1">Cari Produk</label>
                    <input type="text" name="search" id="search" placeholder="Ketik nama produk..."
                        value="{{ request('search') }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm px-3 py-2 text-[var(--color-navy)]
                               focus:border-primary-dark focus:ring-primary-dark">
                </div>

                <div class="md:w-1/4">
                    <label for="kategori" class="block text-sm font-medium text-[var(--color-navy)] mb-1">Kategori</label>
                    <select name="kategori" id="kategori"
                        class="w-full rounded-lg border-gray-300 shadow-sm px-3 py-2 text-[var(--color-navy)]
                               focus:border-primary-dark focus:ring-primary-dark">
                        <option value="">Semua Kategori</option>
                        @if(isset($kategories) && $kategories->count() > 0)
                            @foreach($kategories as $kategori)
                                <option value="{{ $kategori->slug }}" @selected(request('kategori') == $kategori->slug)>
                                    {{ $kategori->name }}
                                </option>
                            @endforeach
                        @else
                            <option value="kat1" @selected(request('kategori') == 'kat1')>Kategori 1</option>
                            <option value="kat2" @selected(request('kategori') == 'kat2')>Kategori 2</option>
                            <option value="kat3" @selected(request('kategori') == 'kat3')>Kategori 3</option>
                        @endif
                    </select>
                </div>

                <button type="submit"
                    class="bg-primary-dark text-white px-6 py-2 rounded-lg hover:bg-primary transition h-fit self-end">
                    Terapkan
                </button>
            </form>

            <!-- Grid Produk -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                @foreach($semuaProduk as $produk)
                    <div class="bg-white rounded-lg shadow-md border-2 border-gray-100 overflow-hidden
                            transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative group">
                            <img src="{{ $produk['gambar'] }}" alt="{{ $produk['nama'] }}"
                                class="h-48 md:h-56 w-full object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>

                        <div class="p-3 md:p-5">
                            <h3 class="text-md md:text-lg font-semibold text-[var(--color-navy)] truncate">
                                {{ $produk['nama'] }}
                            </h3>
                            <p class="text-[var(--color-navy)] font-semibold mt-2 text-md md:text-lg">
                                @if(isset($produk['harga_diskon']) && $produk['harga_diskon'] > 0)
                                    <span class="line-through text-gray-400 text-sm">Rp. {{ number_format($produk['harga'], 0, ',', '.') }}</span>
                                    <span class="ml-2">Rp. {{ number_format($produk['harga_diskon'], 0, ',', '.') }}</span>
                                @else
                                    Rp. {{ number_format($produk['harga'], 0, ',', '.') }}
                                @endif
                            </p>
                            <a href="{{ route('umkm.product.show', $produk['slug'] ?? $produk['id'] ?? '#') }}"
                               class="w-full block bg-primary-dark mt-4 text-xs md:text-md text-white p-2 md:p-2 text-center rounded hover:bg-primary font-medium transition">
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
