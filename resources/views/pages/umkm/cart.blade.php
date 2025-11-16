<x-umkm.layout :linkWA="$linkWA" :socials="$socials">
    <x-slot:title>
        Keranjang Belanja
    </x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-medium text-dark mb-8">
            Keranjang Anda
        </h1>

        <div x-data>
            {{-- Jika keranjang kosong --}}
            <div x-show="$store.cart.items.length === 0"
                class="bg-white p-8 rounded-lg shadow-md text-center">
                <p class="text-xl text-gray-700">
                    Keranjang Anda masih kosong.
                </p>
                <a href="{{ route('umkm.product') }}"
                    class="mt-4 inline-block text-primary-dark font-medium hover:underline">
                    &larr; Kembali Belanja
                </a>
            </div>

            {{-- Jika ada item --}}
            <div x-show="$store.cart.items.length > 0" x-transition class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Daftar Item --}}
                <div class="lg:col-span-2 space-y-4">
                    <template x-for="item in $store.cart.items" :key="item.id">
                        <div class="flex items-center gap-4 bg-white p-4 rounded-lg shadow-md">
                            <img :src="item.image" :alt="item.name" class="w-24 h-24 object-cover rounded-md">

                            <div class="flex-grow">
                                <h3 class="text-lg font-medium text-charcoal-grey" x-text="item.name"></h3>
                                <p class="text-md font-medium text-primary-dark" x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.price)"></p>
                            </div>

                            <div class="flex items-center gap-3">
                                {{-- Input jumlah --}}
                                <div class="flex items-center gap-4">
                                    <span class="font-medium text-dark">Jumlah:</span>
                                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                        <button type="button" @click="$store.cart.updateQuantity(item.id, Math.max(1, item.quantity - 1))"
                                            class="px-4 py-2 bg-gray-200 text-dark font-medium">-</button>

                                        <input type="number" :value="item.quantity"
                                            @change="$store.cart.updateQuantity(item.id, parseInt($event.target.value))"
                                            min="1"
                                            class="w-16 text-center border-l border-r border-gray-300 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">

                                        <button type="button" @click="$store.cart.updateQuantity(item.id, item.quantity + 1)"
                                            class="px-4 py-2 bg-gray-200 text-dark font-medium">+</button>
                                    </div>
                                </div>

                                {{-- Tombol hapus --}}
                                <button @click="$store.cart.removeItem(item.id)"
                                    class="text-error hover:text-error hover:bg-error/25 w-12 h-12 flex justify-center items-center rounded-xl transition-colors ease-in" title="Hapus produk ini">
                                    <img src="/images/Icon-Trash.png" alt="icon hapus" srcset="" class="w-8">
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Ringkasan & Checkout --}}
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-lg shadow-md sticky top-24">
                        <h2 class="text-2xl font-medium text-dark mb-4 border-b pb-2">
                            Ringkasan
                        </h2>

                        <div class="flex justify-between mb-2 text-gray-700">
                            <span>Total Item</span>
                            <span class="font-medium" x-text="$store.cart.totalCount()"></span>
                        </div>

                        <div class="flex justify-between mb-4 text-gray-700">
                            <span>Estimasi Harga</span>
                            <span class="font-medium" x-text="new Intl.NumberFormat('id-ID', { 
                                      style: 'currency', 
                                      currency: 'IDR', 
                                      minimumFractionDigits: 0 
                                  }).format($store.cart.totalPrice())">
                            </span>
                        </div>

                        {{-- Tombol Checkout WhatsApp --}}
                        <a :href="$store.cart.generateWhatsAppLink()" target="_blank" rel="noopener noreferrer" class="w-full inline-flex items-center justify-center px-6 py-3 
                                  bg-gradient-accent hover:bg-green-600 
                                  text-white text-lg font-medium rounded-full 
                                  shadow-md transition-transform transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946
                                         .003-6.556 5.338-11.891 11.893-11.891 
                                         3.181.001 6.167 1.24 8.413 3.488 
                                         2.245 2.248 3.481 5.236 3.48 8.414
                                         -.003 6.557-5.338 11.892-11.893 11.892
                                         -1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807
                                         c1.676.995 3.276 1.591 5.392 1.592 
                                         5.448 0 9.886-4.434 9.889-9.885
                                         .002-5.451-4.43-9.887-9.886-9.887
                                         -5.452 0-9.887 4.434-9.889 9.886
                                         -.001 2.225.651 4.315 1.849 6.039l-1.218 4.439 
                                         4.542-1.192z" />
                            </svg>
                            Checkout via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-umkm.layout>