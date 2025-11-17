@extends('layouts.app')

@section('title', 'Direktori Desa & UMKM - Begawi.id')
@section('description', 'Temukan desa dan UMKM terdaftar di platform Begawi.id. Jelajahi website, produk, dan layanan dari seluruh Indonesia.')

@section('content')
<!-- Header Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-emerald-50 to-emerald-100">
    <div class="container mx-auto px-4 relative z-10 pt-24 md:pt-32">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="font-manrope font-extrabold text-4xl md:text-6xl text-charcoal-grey mb-6">
                DIREKTORI
                <span class="text-gradient">UMKM & DESA</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                Jelajahi daftar Desa Digital dan UMKM aktif. Temukan website resmi, produk unggulan, dan statistik aktivitas terbaru.
            </p>
        </div>
    </div>
</section>

<!-- Tabs: Direktori Desa / Direktori UMKM -->
<section class="py-16 px-6 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <div class="inline-flex bg-gray-100 rounded-2xl p-1 shadow-inner">
                <button id="tabDesa" class="px-6 py-3 rounded-xl font-semibold bg-white text-emerald-700 shadow">
                    📍 Direktori Desa
                </button>
                <button id="tabUmkm" class="px-6 py-3 rounded-xl font-semibold text-gray-600 hover:text-emerald-700 transition">
                    🛍️ Direktori UMKM
                </button>
            </div>
        </div>

        <!-- Panel: Direktori Desa -->
        <div id="panelDesa">
            <!-- Daftar Desa Digital -->
            <div class="mb-10">
                <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-12">Daftar Desa Digital</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($allVillages ?? [] as $desa)
                    <div class="relative flex flex-col rounded-2xl bg-white bg-clip-border text-gray-700 shadow-md hover:shadow-xl transition-all">
                        <div class="relative mx-4 -mt-8 h-44 overflow-hidden rounded-3xl shadow-lg shadow-emerald-500/40 bg-gray-100">
                            <img src="{{ $desa['image'] ?? asset('images/directory/default-desa.png') }}"
                                 alt="{{ $desa['name'] }}"
                                 class="h-full w-full object-cover"
                                 loading="lazy"
                                 onerror="this.onerror=null;this.src='{{ asset('images/directory/default-desa.png') }}';">
                        </div>
                        <div class="p-6 pt-8 space-y-3">
                            <span class="inline-block text-xs font-semibold uppercase tracking-wide text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Desa Digital</span>
                            <div>
                                <h4 class="text-2xl font-extrabold text-charcoal-grey">{{ $desa['name'] }}</h4>
                                <p class="text-sm font-medium text-gray-500">{{ $desa['location'] }}</p>
                            </div>
                            <p class="text-sm leading-relaxed text-gray-600">{{ Str::limit($desa['description'] ?? 'Desa digital dengan layanan terpadu', 100) }}</p>
                        </div>
                        <div class="p-6 pt-0">
                            <a href="{{ $desa['url'] }}" target="_blank" class="inline-flex items-center gap-2 select-none rounded-lg bg-emerald-500 py-3 px-5 text-center text-xs font-bold uppercase tracking-wide text-white shadow-md shadow-emerald-500/30 transition-all hover:bg-emerald-600 focus:outline-none">
                                Kunjungi Website
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Belum ada desa yang terdaftar.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            <!-- Statistik Aktivitas -->
            <div>
                <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-4">Statistik Aktivitas</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-2xl p-6 shadow-lg flex justify-between items-center">
                        <!-- Bagian Teks (kiri) -->
                        <div>
                            <div class="text-sm text-gray-500 mb-1">Jumlah Pengunjung</div>
                            <div class="text-3xl font-extrabold text-emerald-600">58,240</div>
                            <div class="text-xs text-gray-400 mt-1">30 hari terakhir</div>
                        </div>
                        <!-- Bagian Gambar (kanan) -->
                        <div class="w-16 h-16 flex items-center justify-center">
                            <img src="{{ asset('images/directory/jumlah-pengunjung.png') }}"
                                alt=""
                                class="w-16 h-16">
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-lg flex justify-between items-center">
                        <!-- Bagian Teks (kiri) -->
                        <div>
                            <div class="text-sm text-gray-500 mb-2">Konten Terbaru</div>
                            <div class="text-3xl font-extrabold text-emerald-600">312</div>
                            <div class="text-xs text-gray-400 mt-1">Artikel & Agenda</div>
                        </div>
                        <!-- Bagian Gambar (kanan) -->
                        <div class="w-16 h-16 flex items-center justify-center">
                            <img src="{{ asset('images/directory/konten-terbaru.png') }}"
                                alt=""
                                class="w-16 h-16">
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-lg flex justify-between items-center">
                        <!-- Bagian Teks (kiri) -->
                        <div>
                            <div class="text-sm text-gray-500 mb-2">Produk Unggulan</div>
                            <div class="text-3xl font-extrabold text-emerald-600">124</div>
                            <div class="text-xs text-gray-400 mt-1">Dari desa binaan</div>
                        </div>
                        <!-- Bagian Gambar (kanan) -->
                        <div class="w-16 h-16 flex items-center justify-center">
                            <img src="{{ asset('images/directory/produk-unggulan.png') }}"
                                alt=""
                                class="w-16 h-16">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel: Direktori UMKM -->
        <div id="panelUmkm" class="hidden">
            <!-- Filter Kategori -->
            <div class="mb-8">
                <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-4">Filter Kategori</h3>
                <div class="flex flex-wrap gap-3">
                    <button class="umkm-filter px-4 py-2 bg-gradient-accent text-white rounded-xl font-semibold" data-category="all">Semua</button>
                    @php
                    $categories = collect($allUmkm ?? [])->pluck('category')->filter()->unique()->values();
                    @endphp
                    @foreach($categories as $cat)
                    <button class="umkm-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-xl" data-category="{{ Str::slug($cat) }}">{{ $cat }}</button>
                    @endforeach
                </div>
            </div>
            <!-- Katalog UMKM -->
            <div>
                <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-12">Katalog UMKM</h3>
                <div id="umkmGallery" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($allUmkm ?? [] as $umkm)
                    <div class="umkm-card relative flex flex-col rounded-2xl bg-white bg-clip-border text-gray-700 shadow-md hover:shadow-xl transition-all" data-category="{{ Str::slug($umkm['category'] ?? 'umum') }}">
                        <div class="relative mx-4 -mt-8 h-44 overflow-hidden rounded-3xl shadow-lg shadow-orange-500/40 bg-gray-100">
                            <img src="{{ $umkm['image'] ?? asset('images/directory/default-umkm.png') }}"
                                 alt="{{ $umkm['name'] }}"
                                 class="h-full w-full object-cover"
                                 loading="lazy"
                                 onerror="this.onerror=null;this.src='{{ asset('images/directory/default-umkm.png') }}';">
                        </div>
                        <div class="p-6 pt-8 space-y-3">
                            <span class="inline-block text-xs font-semibold uppercase tracking-wide text-orange-600 bg-orange-50 px-3 py-1 rounded-full">{{ $umkm['category'] ?? 'UMKM' }}</span>
                            <div>
                                <h4 class="text-2xl font-extrabold text-charcoal-grey">{{ $umkm['name'] }}</h4>
                                <p class="text-sm font-medium text-gray-500">{{ $umkm['location'] }}</p>
                            </div>
                            <p class="text-sm leading-relaxed text-gray-600">{{ Str::limit($umkm['description'] ?? 'UMKM digital dengan produk berkualitas', 100) }}</p>
                            @if(isset($umkm['products']) && $umkm['products'] > 0)
                            <div class="text-xs font-semibold inline-flex items-center gap-2 rounded-full bg-orange-100 px-3 py-1 text-orange-700 uppercase tracking-wide">{{ $umkm['products'] }} Produk</div>
                            @endif
                        </div>
                        <div class="p-6 pt-0">
                            <a href="{{ $umkm['url'] }}" target="_blank" class="inline-flex items-center gap-2 select-none rounded-lg bg-emerald-500 py-3 px-5 text-center text-xs font-bold uppercase tracking-wide text-white shadow-md shadow-emerald-500/30 transition-all hover:bg-emerald-600 focus:outline-none">
                                Kunjungi Website UMKM
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Belum ada UMKM yang terdaftar.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tabs toggle
        const tabDesa = document.getElementById('tabDesa');
        const tabUmkm = document.getElementById('tabUmkm');
        const panelDesa = document.getElementById('panelDesa');
        const panelUmkm = document.getElementById('panelUmkm');

        function activateTab(target) {
            const isDesa = target === 'desa';
            panelDesa.classList.toggle('hidden', !isDesa);
            panelUmkm.classList.toggle('hidden', isDesa);

            if (isDesa) {
                tabDesa.classList.add('bg-white', 'text-emerald-700', 'shadow');
                tabUmkm.classList.remove('bg-white', 'text-emerald-700', 'shadow');
                tabUmkm.classList.add('text-gray-600');
            } else {
                tabUmkm.classList.add('bg-white', 'text-emerald-700', 'shadow');
                tabDesa.classList.remove('bg-white', 'text-emerald-700', 'shadow');
                tabDesa.classList.add('text-gray-600');
            }
        }

        tabDesa.addEventListener('click', () => activateTab('desa'));
        tabUmkm.addEventListener('click', () => activateTab('umkm'));
        // default
        activateTab('desa');

        // UMKM category filtering
        const filterButtons = document.querySelectorAll('.umkm-filter');
        const umkmCards = document.querySelectorAll('.umkm-card');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const category = btn.getAttribute('data-category');

                // Visual active state
                filterButtons.forEach(b => {
                    b.classList.remove('bg-gradient-accent', 'text-white');
                    b.classList.add('bg-white', 'border', 'border-gray-300', 'text-gray-700');
                });
                btn.classList.add('bg-gradient-accent', 'text-white');
                btn.classList.remove('bg-white', 'border', 'border-gray-300', 'text-gray-700');

                // Filter logic
                umkmCards.forEach(card => {
                    const cardCat = card.getAttribute('data-category');
                    if (category === 'all' || category === cardCat) {
                        card.style.display = 'block';
                        card.classList.add('animate-fadeInUp');
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush