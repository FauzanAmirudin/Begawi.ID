@extends('layouts.app')

@section('title', 'Template Website Gratis - Begawi.id')
@section('description', 'Koleksi template website gratis untuk desa, UMKM, dan komunitas. Responsive, SEO-friendly, dan mudah dikustomisasi.')

@section('content')
    <!-- Header Section -->
    <section class="pt-24 pb-12 bg-gradient-to-br from-emerald-50 to-emerald-100">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="font-manrope font-extrabold text-4xl md:text-6xl text-charcoal-grey mb-6">
                    Template Website
                    <span class="text-gradient">Premium Gratis</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    Koleksi template profesional yang dirancang khusus untuk desa, UMKM, dan komunitas Indonesia. Semua gratis dan mudah dikustomisasi.
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto mb-8">
                    <div class="relative">
                        <input type="text" id="templateSearch" placeholder="Cari template..." class="w-full px-6 py-4 pl-12 bg-white border border-gray-300 rounded-2xl text-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent shadow-lg">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="flex flex-wrap justify-center gap-8 text-center">
                    <div class="bg-white rounded-xl px-6 py-4 shadow-lg">
                        <div class="text-2xl font-bold text-emerald-600">50+</div>
                        <div class="text-sm text-gray-600">Template Tersedia</div>
                    </div>
                    <div class="bg-white rounded-xl px-6 py-4 shadow-lg">
                        <div class="text-2xl font-bold text-emerald-600">100%</div>
                        <div class="text-sm text-gray-600">Responsive</div>
                    </div>
                    <div class="bg-white rounded-xl px-6 py-4 shadow-lg">
                        <div class="text-2xl font-bold text-purple-600">Gratis</div>
                        <div class="text-sm text-gray-600">Selamanya</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Filter & Templates Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <!-- Category Filter -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button class="category-filter active px-6 py-3 bg-gradient-accent text-white font-semibold rounded-xl transition-all hover-glow" data-category="all">
                    Semua Template
                </button>
                <button class="category-filter px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-emerald-500 hover:text-emerald-600 transition-all" data-category="desa">
                    🌾 Desa
                </button>
                <button class="category-filter px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-emerald-500 hover:text-emerald-600 transition-all" data-category="umkm">
                    🛍️ UMKM
                </button>
                <button class="category-filter px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-emerald-500 hover:text-emerald-600 transition-all" data-category="komunitas">
                    👥 Komunitas
                </button>
                <button class="category-filter px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-emerald-500 hover:text-emerald-600 transition-all" data-category="ecommerce">
                    🛒 E-Commerce
                </button>
            </div>
            
            <!-- Sort & View Options -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
                <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                    <span class="text-gray-600">Urutkan:</span>
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option>Terpopuler</option>
                        <option>Terbaru</option>
                        <option>Rating Tertinggi</option>
                        <option>Nama A-Z</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button id="gridView" class="p-2 bg-emerald-600 text-white rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </button>
                    <button id="listView" class="p-2 bg-gray-200 text-gray-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Templates Grid -->
            <div id="templatesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @include('components.template-gallery')
            </div>
            
            <!-- Load More -->
            <div class="text-center mt-12">
                <button id="loadMore" class="inline-flex items-center px-8 py-4 bg-gradient-accent text-white font-poppins font-semibold text-lg rounded-xl hover-glow transition-all">
                    <span class="mr-2">🔄</span>
                    Muat Template Lainnya
                </button>
            </div>
        </div>
    </section>
    
    <!-- Template Builder CTA -->
    <section class="py-16 bg-gradient-to-br from-charcoal-grey to-gray-900">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-white mb-6">
                    Tidak Menemukan Template yang Cocok?
                </h2>
                <p class="text-xl text-gray-300 mb-8">
                    Buat template custom sesuai kebutuhan Anda dengan Template Builder kami
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-all">
                        <span class="mr-2">🎨</span>
                        Custom Template
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 border border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 transition-all">
                        <span class="mr-2">💬</span>
                        Request Template
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Template search functionality
        const searchInput = document.getElementById('templateSearch');
        const templateCards = document.querySelectorAll('.template-card');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            templateCards.forEach(card => {
                const templateName = card.querySelector('h3').textContent.toLowerCase();
                const templateDesc = card.querySelector('p').textContent.toLowerCase();
                
                if (templateName.includes(searchTerm) || templateDesc.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // View toggle functionality
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const templatesGrid = document.getElementById('templatesGrid');
        
        gridView.addEventListener('click', function() {
            templatesGrid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8';
            gridView.classList.add('bg-emerald-600', 'text-white');
            gridView.classList.remove('bg-gray-200', 'text-gray-600');
            listView.classList.add('bg-gray-200', 'text-gray-600');
            listView.classList.remove('bg-emerald-600', 'text-white');
        });
        
        listView.addEventListener('click', function() {
            templatesGrid.className = 'grid grid-cols-1 gap-6';
            listView.classList.add('bg-emerald-600', 'text-white');
            listView.classList.remove('bg-gray-200', 'text-gray-600');
            gridView.classList.add('bg-gray-200', 'text-gray-600');
            gridView.classList.remove('bg-emerald-600', 'text-white');
        });
        
        // Load more functionality
        let currentPage = 1;
        const loadMoreBtn = document.getElementById('loadMore');
        
        loadMoreBtn.addEventListener('click', function() {
            // Simulate loading
            this.innerHTML = '<span class="mr-2">⏳</span>Memuat...';
            
            setTimeout(() => {
                // Here you would typically make an AJAX request
                currentPage++;
                this.innerHTML = '<span class="mr-2">🔄</span>Muat Template Lainnya';
                showNotification('Template berhasil dimuat!', 'success');
            }, 1500);
        });
    });
</script>
@endpush