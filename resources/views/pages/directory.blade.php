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
                        <!-- Item Desa -->
                        <div class="relative flex flex-col rounded-2xl bg-white bg-clip-border text-gray-700 shadow-md hover:shadow-xl transition-all">
                            <div class="relative mx-4 -mt-8 h-44 overflow-hidden rounded-3xl shadow-lg shadow-emerald-500/40">
                                <img src="{{ asset('images/web1.png') }}" alt="Desa Sukamaju" class="h-full w-full object-cover" loading="lazy">
                            </div>
                            <div class="p-6 pt-8 space-y-3">
                                <span class="inline-block text-xs font-semibold uppercase tracking-wide text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Desa Digital Unggulan</span>
                                <div>
                                    <h4 class="text-2xl font-extrabold text-charcoal-grey">Desa Sukamaju</h4>
                                    <p class="text-sm font-medium text-gray-500">Kabupaten Bandung, Jawa Barat</p>
                                </div>
                                <p class="text-sm leading-relaxed text-gray-600">Platform layanan publik terpadu dengan dashboard transparansi anggaran, layanan surat digital, dan monitoring program desa.</p>
                            </div>
                            <div class="p-6 pt-0">
                                <a href="#" class="inline-flex items-center gap-2 select-none rounded-lg bg-emerald-500 py-3 px-5 text-center text-xs font-bold uppercase tracking-wide text-white shadow-md shadow-emerald-500/30 transition-all hover:bg-emerald-600 focus:outline-none">
                                    Kunjungi Website
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="relative flex flex-col rounded-2xl bg-white bg-clip-border text-gray-700 shadow-md hover:shadow-xl transition-all">
                            <div class="relative mx-4 -mt-8 h-44 overflow-hidden rounded-3xl shadow-lg shadow-amber-500/40">
                                <img src="{{ asset('images/directory/desa-harapan-jaya.jpg') }}" alt="Desa Harapan Jaya" class="h-full w-full object-cover" loading="lazy">
                            </div>
                            <div class="p-6 pt-8 space-y-3">
                                <span class="inline-block text-xs font-semibold uppercase tracking-wide text-orange-600 bg-orange-50 px-3 py-1 rounded-full">Smart Village</span>
                                <div>
                                    <h4 class="text-2xl font-extrabold text-charcoal-grey">Desa Harapan Jaya</h4>
                                    <p class="text-sm font-medium text-gray-500">Kabupaten Sleman, DI Yogyakarta</p>
                                </div>
                                <p class="text-sm leading-relaxed text-gray-600">Portal layanan mandiri dengan integrasi e-budgeting, katalog produk BUMDes, dan laporan aktivitas masyarakat terkini.</p>
                            </div>
                            <div class="p-6 pt-0">
                                <a href="#" class="inline-flex items-center gap-2 select-none rounded-lg bg-emerald-500 py-3 px-5 text-center text-xs font-bold uppercase tracking-wide text-white shadow-md shadow-emerald-500/30 transition-all hover:bg-emerald-600 focus:outline-none">
                                    Kunjungi Website
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="relative flex flex-col rounded-2xl bg-white bg-clip-border text-gray-700 shadow-md hover:shadow-xl transition-all">
                            <div class="relative mx-4 -mt-8 h-44 overflow-hidden rounded-3xl shadow-lg shadow-sky-500/40">
                                <img src="{{ asset('images/directory/desa-tunas-mekar.jpg') }}" alt="Desa Tunas Mekar" class="h-full w-full object-cover" loading="lazy">
                            </div>
                            <div class="p-6 pt-8 space-y-3">
                                <span class="inline-block text-xs font-semibold uppercase tracking-wide text-sky-600 bg-sky-50 px-3 py-1 rounded-full">Ekowisata & UMKM</span>
                                <div>
                                    <h4 class="text-2xl font-extrabold text-charcoal-grey">Desa Tunas Mekar</h4>
                                    <p class="text-sm font-medium text-gray-500">Kabupaten Badung, Bali</p>
                                </div>
                                <p class="text-sm leading-relaxed text-gray-600">Tampilkan kalender budaya, marketplace produk unggulan, serta pemesanan wisata terpadu berbasis komunitas lokal.</p>
                            </div>
                            <div class="p-6 pt-0">
                                <a href="#" class="inline-flex items-center gap-2 select-none rounded-lg bg-emerald-500 py-3 px-5 text-center text-xs font-bold uppercase tracking-wide text-white shadow-md shadow-emerald-500/30 transition-all hover:bg-emerald-600 focus:outline-none">
                                    Kunjungi Website
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Statistik Aktivitas -->
                <div>
                    <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-4">Statistik Aktivitas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-2xl p-6 shadow-lg">
                            <div class="text-sm text-gray-500 mb-2">Jumlah Pengunjung</div>
                            <div class="text-3xl font-extrabold text-emerald-600">58,240</div>
                            <div class="text-xs text-gray-400 mt-1">30 hari terakhir</div>
                        </div>
                        <div class="bg-white rounded-2xl p-6 shadow-lg">
                            <div class="text-sm text-gray-500 mb-2">Konten Terbaru</div>
                            <div class="text-3xl font-extrabold text-emerald-600">312</div>
                            <div class="text-xs text-gray-400 mt-1">Artikel & Agenda</div>
                        </div>
                        <div class="bg-white rounded-2xl p-6 shadow-lg">
                            <div class="text-sm text-gray-500 mb-2">Produk Unggulan</div>
                            <div class="text-3xl font-extrabold text-emerald-600">124</div>
                            <div class="text-xs text-gray-400 mt-1">Dari desa binaan</div>
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
                        <button class="umkm-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-xl" data-category="kuliner">Kuliner</button>
                        <button class="umkm-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-xl" data-category="kerajinan">Kerajinan</button>
                        <button class="umkm-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-xl" data-category="jasa">Jasa</button>
                        <button class="umkm-filter px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-xl" data-category="pertanian">Pertanian</button>
                    </div>
                </div>
                <!-- Katalog UMKM -->
                <div>
                    <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-12">Katalog UMKM</h3>
                    <div id="umkmGallery" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Card UMKM -->
                        <div class="umkm-card relative flex flex-col rounded-2xl bg-white bg-clip-border text-gray-700 shadow-md hover:shadow-xl transition-all" data-category="kuliner">
                            <div class="relative mx-4 -mt-8 h-44 overflow-hidden rounded-3xl shadow-lg shadow-orange-500/40">
                                <img src="{{ asset('images/directory/umkm-keripik-singkong-rempah.jpg') }}" alt="Keripik Singkong Rempah" class="h-full w-full object-cover" loading="lazy">
                            </div>
                            <div class="p-6 pt-8 space-y-3">
                                <span class="inline-block text-xs font-semibold uppercase tracking-wide text-orange-600 bg-orange-50 px-3 py-1 rounded-full">Kategori Kuliner</span>
                                <div>
                                    <h4 class="text-2xl font-extrabold text-charcoal-grey">Keripik Singkong Rempah</h4>
                                    <p class="text-sm font-medium text-gray-500">UMKM Cita Rasa Nusantara</p>
                                </div>
                                <p class="text-sm leading-relaxed text-gray-600">Keripik singkong artisan dengan baluran sambal matah dan kemasan ramah lingkungan, tersedia dalam varian pedas dan original.</p>
                                <div class="text-xs font-semibold inline-flex items-center gap-2 rounded-full bg-orange-100 px-3 py-1 text-orange-700 uppercase tracking-wide">Produk Unggulan</div>
                            </div>
                            <div class="p-6 pt-0">
                                <a href="#" class="inline-flex items-center gap-2 select-none rounded-lg bg-emerald-500 py-3 px-5 text-center text-xs font-bold uppercase tracking-wide text-white shadow-md shadow-emerald-500/30 transition-all hover:bg-emerald-600 focus:outline-none">
                                    Kunjungi Website UMKM
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="umkm-card relative flex flex-col rounded-2xl bg-white bg-clip-border text-gray-700 shadow-md hover:shadow-xl transition-all" data-category="kerajinan">
                            <div class="relative mx-4 -mt-8 h-44 overflow-hidden rounded-3xl shadow-lg shadow-emerald-500/40">
                                <img src="{{ asset('images/directory/umkm-anyaman-bambu-prakarsa.jpg') }}" alt="Anyaman Bambu Prakarsa" class="h-full w-full object-cover" loading="lazy">
                            </div>
                            <div class="p-6 pt-8 space-y-3">
                                <span class="inline-block text-xs font-semibold uppercase tracking-wide text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Kategori Kerajinan</span>
                                <div>
                                    <h4 class="text-2xl font-extrabold text-charcoal-grey">Anyaman Bambu Prakarsa</h4>
                                    <p class="text-sm font-medium text-gray-500">Komunitas Perajin Kulon Progo</p>
                                </div>
                                <p class="text-sm leading-relaxed text-gray-600">Rangkaian keranjang premium dengan desain kontemporer, menggunakan bahan bambu terpilih dan finishing food grade.</p>
                                <div class="text-xs font-semibold inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-emerald-700 uppercase tracking-wide">Sertifikasi HALAL &amp; SNI</div>
                            </div>
                            <div class="p-6 pt-0">
                                <a href="#" class="inline-flex items-center gap-2 select-none rounded-lg bg-emerald-500 py-3 px-5 text-center text-xs font-bold uppercase tracking-wide text-white shadow-md shadow-emerald-500/30 transition-all hover:bg-emerald-600 focus:outline-none">
                                    Kunjungi Website UMKM
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="umkm-card relative flex flex-col rounded-2xl bg-white bg-clip-border text-gray-700 shadow-md hover:shadow-xl transition-all" data-category="jasa">
                            <div class="relative mx-4 -mt-8 h-44 overflow-hidden rounded-3xl shadow-lg shadow-purple-500/40">
                                <img src="{{ asset('images/web1.png') }}" alt="Studio Desain Kemasan" class="h-full w-full object-cover" loading="lazy">
                            </div>
                            <div class="p-6 pt-8 space-y-3">
                                <span class="inline-block text-xs font-semibold uppercase tracking-wide text-purple-600 bg-purple-50 px-3 py-1 rounded-full">Kategori Jasa</span>
                                <div>
                                    <h4 class="text-2xl font-extrabold text-charcoal-grey">Studio Desain Kemasan</h4>
                                    <p class="text-sm font-medium text-gray-500">Creative House Lampung</p>
                                </div>
                                <p class="text-sm leading-relaxed text-gray-600">Layanan branding, desain kemasan fleksibel, mockup 3D, dan konsultasi strategi pemasaran untuk UMKM naik kelas.</p>
                                <div class="text-xs font-semibold inline-flex items-center gap-2 rounded-full bg-purple-100 px-3 py-1 text-purple-700 uppercase tracking-wide">Starter Kit Branding</div>
                            </div>
                            <div class="p-6 pt-0">
                                <a href="#" class="inline-flex items-center gap-2 select-none rounded-lg bg-emerald-500 py-3 px-5 text-center text-xs font-bold uppercase tracking-wide text-white shadow-md shadow-emerald-500/30 transition-all hover:bg-emerald-600 focus:outline-none">
                                    Kunjungi Website UMKM
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
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