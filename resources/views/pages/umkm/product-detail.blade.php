<x-umkm.layout :linkWA="$linkWA" :socials="$socials">

    <x-slot:title>
        Sneaky | {{ $produk->nama }}
    </x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12" 
             x-data="{
                qty: 1,
                stok: {{ $produk->stok }},
                
                increase() {
                    if (this.qty < this.stok) this.qty++;
                    this.updateWhatsAppLink();
                },
                decrease() {
                    if (this.qty > 1) this.qty--;
                    this.updateWhatsAppLink();
                },
                updateWhatsAppLink() {
                    const nomorWA = '6281234567890'; // ⬅️ GANTI NOMOR WA DI SINI
                    const pesan = `Halo, saya tertarik dengan produk '{{ $produk->nama }}' (Harga: Rp. {{ number_format($produk->harga, 0, ',', '.') }}) sebanyak ${this.qty} pcs. Apakah stoknya masih tersedia?`;
                    this.$refs.whatsappLink.href = `https://wa.me/${nomorWA}?text=` + encodeURIComponent(pesan);
                }
             }"
             x-init="updateWhatsAppLink()">

            {{-- Galeri Gambar Produk --}}
            <div class="w-full">
                <img src="{{ $produk->galeri_gambar[0] }}" alt="{{ $produk->nama }}"
                    class="bg-primary-darker w-full h-auto md:h-[500px] object-cover rounded-lg shadow-lg">

                @if(count($produk->galeri_gambar) > 1)
                    <div class="grid grid-cols-4 gap-4 mt-4">
                        @foreach($produk->galeri_gambar as $gambar)
                            <img src="{{ $gambar }}" alt="thumbnail"
                                class="bg-primary-darker h-24 w-full object-cover rounded-md cursor-pointer border-2 border-transparent hover:border-primary">
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Info Produk & Tombol Aksi --}}
            <div class="w-full">

                <h1 class="text-3xl md:text-4xl font-semibold text-dark mb-3">
                    {{ $produk->nama }}
                </h1>

                <p class="text-3xl font-semibold text-primary-dark mb-6">
                    @if(isset($produk->harga_diskon) && $produk->harga_diskon > 0)
                        <span class="line-through text-gray-400 text-xl">Rp. {{ number_format($produk->harga, 0, ',', '.') }}</span>
                        <span class="ml-2">Rp. {{ number_format($produk->harga_diskon, 0, ',', '.') }}</span>
                    @else
                        Rp. {{ number_format($produk->harga, 0, ',', '.') }}
                    @endif
                </p>

                {{-- Stok Produk --}}
                <div class="mb-6">
                    @if($produk->stok > 0)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Stok Tersedia: {{ $produk->stok }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            Stok Habis
                        </span>
                    @endif
                </div>

                {{-- Jumlah Pesanan --}}
                <div class="mb-6 flex items-center gap-4">
                    <span class="font-medium text-dark">Jumlah:</span>
                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                        <button type="button" @click="decrease()"
                            class="px-4 py-2 bg-gray-200 text-dark font-semibold">-</button>
                        
                        <input type="number" id="qtyInput" x-model.number="qty" min="1" :max="stok"
                            @input="updateWhatsAppLink()"
                            class="w-16 text-center border-l border-r border-gray-300 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        
                        <button type="button" @click="increase()"
                            class="px-4 py-2 bg-gray-200 text-dark font-semibold">+</button>
                    </div>
                </div>

                {{-- Tombol Aksi: WhatsApp & Keranjang --}}
                <div class="flex flex-col md:flex-row gap-4 mb-8">

                    <a href="#" x-ref="whatsappLink" target="_blank" rel="noopener noreferrer"
                        class="flex-1 inline-flex items-center justify-center px-6 py-4 bg-gradient-accent hover:bg-emerald-800 text-white text-lg font-semibold rounded-lg shadow-md transition-transform transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-12 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-1.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.451-4.43-9.887-9.886-9.887-5.452 0-9.887 4.434-9.889 9.886-.001 2.225.651 4.315 1.849 6.039l-1.218 4.439 4.542-1.192z" />
                        </svg>
                        Pesan Langsung via WhatsApp
                    </a>

                    <button type="button" @click="$store.cart.addItem({
                            id: {{ $produk->id }},
                            name: '{{ $produk->nama }}',
                            price: {{ $produk->harga }},
                            image: '{{ $produk->galeri_gambar[0] }}',
                            quantity: qty  
                        })" class="flex-1 inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 focus:ring-4 focus:outline-none focus:ring-purple-300 text-white  text-lg font-semibold rounded-lg shadow-md transition-transform transform hover:scale-105">
                        <svg class="w-6 h-6 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 15a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0h8m-8 0-1-4m9 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-9-4h10l2-7H3m2 7L3 4m0 0-.792-3H1" />
                        </svg>
                        Tambah ke Keranjang
                    </button>

                </div>

                {{-- Deskripsi Produk --}}
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h2 class="text-xl font-semibold text-dark mb-4">Deskripsi Produk</h2>
                    <div class="prose prose-lg text-gray-700">
                        {!! $produk->deskripsi !!}
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-umkm.layout>
