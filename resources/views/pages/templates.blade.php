@extends('layouts.app')

@section('title', 'Template Website Gratis - Begawi.id')
@section('description', 'Koleksi template website gratis untuk Desa dan UMKM. Responsive, SEO-friendly, dan mudah dikustomisasi.')

@section('content')
    <!-- Header Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-emerald-50 to-emerald-100">
        <div class="container mx-auto px-4 relative z-10 pt-24 md:pt-32">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="font-manrope font-extrabold text-4xl md:text-6xl text-charcoal-grey mb-6">
                    Template Website
                    <span class="text-gradient">Premium </span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    Koleksi template profesional yang dirancang khusus untuk Desa dan UMKM Indonesia. Semua gratis dan mudah dikustomisasi.
                </p>
            
            </div>
        </div>
    </section>
    
    <!-- Filter & Templates Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
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