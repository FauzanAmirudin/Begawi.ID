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
                <div class="flex items-center">
                    <button id="listView" class="p-2 bg-emerald-600 text-white rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Templates Grid -->
            <div id="templatesGrid" class="grid grid-cols-1 gap-6">
                @include('components.template-gallery')
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
        
        // View (fixed to list view)
        const listView = document.getElementById('listView');
        const templatesGrid = document.getElementById('templatesGrid');
        
        // Ensure list view is applied by default
        templatesGrid.className = 'grid grid-cols-1 gap-6';
        if (listView) {
            listView.classList.add('bg-emerald-600', 'text-white');
            listView.classList.remove('bg-gray-200', 'text-gray-600');
            // Optional: clicking keeps list view (idempotent)
            listView.addEventListener('click', function() {
                templatesGrid.className = 'grid grid-cols-1 gap-6';
            });
        }
        
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