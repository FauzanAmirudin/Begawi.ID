<x-umkm.layout :linkWA="$linkWA" :socials="$socials">
    <x-slot:title>
        Tentang Kami
    </x-slot:title>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 space-y-12">
                <section class="bg-white dark:bg-dark-light shadow-lg rounded-2xl p-8 hover:shadow-xl transition">
                    <h2 class="text-3xl font-bold text-dark dark:text-white mb-6 border-b-2 border-primary dark:border-primary-light pb-3">
                        Profil Usaha
                    </h2>

                    <div
                        class="prose prose-lg dark:prose-invert text-gray-700 dark:text-gray-300 max-w-none leading-relaxed">
                        <p>{{ $profile['deskripsi'] }}</p>

                        <h3 class="text-xl font-semibold text-dark dark:text-white mt-8">Visi Kami</h3>
                        <p>{{ $profile['visi'] }}</p>
                    </div>

                    <h3 class="text-xl font-semibold text-dark dark:text-white mt-10 mb-4">
                        Informasi Usaha
                    </h3>
                    <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                        <li class="flex items-start">
                            <span class="w-40 font-semibold">Nama Usaha</span>
                            <span class="mr-2">:</span>
                            <span>{{ $profile['nama_usaha'] }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-40 font-semibold">Telepon</span>
                            <span class="mr-2">:</span>
                            <span>{{ $profile['telepon'] }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-40 font-semibold">Jam Operasional</span>
                            <span class="mr-2">:</span>
                            <span>{{ $profile['jam_operasional'] }}</span>
                        </li>
                    </ul>
                </section>

                <section class="bg-white dark:bg-dark-light shadow-lg rounded-2xl p-8 hover:shadow-xl transition">
                    <h2 class="text-3xl font-bold text-dark dark:text-white mb-4 border-b-2 border-primary dark:border-primary-light  pb-3">
                        Ikuti Kami
                    </h2>
                    <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">
                        Dapatkan update produk terbaru dan promosi spesial melalui media sosial kami.
                    </p>

                    <div class="flex space-x-6">

                        {{-- Instagram --}}
                        <a href="{{ $socials['instagram'] }}" target="_blank" class="text-dark dark:text-white hover:text-primary dark:hover:text-primary-light
              transition-transform transform hover:scale-110">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.75 2A5.75 5.75 0 0 0 2 7.75v8.5A5.75 5.75 0 0 0 7.75 22h8.5A5.75 5.75 0 0 0 22 16.25v-8.5A5.75 5.75 0 0 0 16.25 2h-8.5Zm8.75 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2Zm-4.5 2.25A4.25 4.25 0 1 1 7.75 11.5a4.25 4.25 0 0 1 4.25-4.25Zm0 2a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                            </svg>
                        </a>

                        {{-- Facebook --}}
                        <a href="{{ $socials['facebook'] }}" target="_blank" class="text-dark dark:text-white hover:text-primary dark:hover:text-primary-light
              transition-transform transform hover:scale-110">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M13.5 9H16V6h-2.5c-2.1 0-3.5 1.4-3.5 3.5V12H8v3h2.5v7h3v-7H16l.5-3h-3v-2.5c0-.7.3-1.5 1-1.5Z" />
                            </svg>
                        </a>

                        {{-- TikTok --}}
                        <a href="{{ $socials['tiktok'] }}" target="_blank" class="text-dark dark:text-white hover:text-primary dark:hover:text-primary-light
              transition-transform transform hover:scale-110">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.75 2h3.25c.1 1.2.6 2.3 1.5 3s2 .9 3.1 1v3.2c-1.7 0-3.4-.5-4.8-1.5v7.3c0 3.2-2.7 5.8-6 5.8S4.75 18.2 4.75 15s2.7-5.8 6-5.8c.3 0 .7 0 1 .1v3.3c-.3-.1-.6-.2-1-.2-1.4 0-2.5 1.1-2.5 2.5S9.35 17.5 10.75 17.5s2.5-1.1 2.5-2.5V2Z" />
                            </svg>
                        </a>

                    </div>
                </section>
            </div>

            <div class="lg:col-span-1">
                <section
                    class="bg-white dark:bg-dark-light shadow-lg rounded-2xl p-8 sticky top-24 hover:shadow-xl transition">
                    <h2 class="text-3xl font-bold text-dark dark:text-white mb-6 border-b-2 border-primary dark:border-primary-light  pb-3">
                        Lokasi Kami
                    </h2>

                    <address class="text-lg text-gray-700 dark:text-gray-300 not-italic leading-relaxed mb-6">
                        {{ $profile['alamat'] }}
                    </address>

                    <div
                        class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm">
                        <iframe src="{{ $mapEmbedUrl }}" width="100%" height="100%" style="border:0;" loading="lazy"
                            allowfullscreen></iframe>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-umkm.layout>

