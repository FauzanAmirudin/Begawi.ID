@extends('layouts.desa')

@section('title', 'Galeri Foto - Desa Sejahtera')

@push('styles')
<style>
    .gallery-item {
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .gallery-item:hover {
        transform: translateY(-4px);
    }
    
    .gallery-item img {
        transition: transform 0.5s ease;
    }
    
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    
    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 1rem;
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    
    /* Lightbox Styles */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.95);
        overflow: auto;
    }
    
    .lightbox.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .lightbox-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        margin: auto;
    }
    
    .lightbox-image {
        max-width: 100%;
        max-height: 90vh;
        object-fit: contain;
    }
    
    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        z-index: 10000;
    }
    
    .lightbox-close:hover {
        color: #FACC15;
    }
    
    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: none;
        padding: 1rem;
        cursor: pointer;
        font-size: 24px;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .lightbox-nav:hover {
        background: rgba(255, 255, 255, 0.3);
        color: #FACC15;
    }
    
    .lightbox-prev {
        left: 20px;
    }
    
    .lightbox-next {
        right: 20px;
    }
    
    .lightbox-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
        color: #fff;
        padding: 2rem;
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-primary-50 to-amber-50 py-16">
        <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
            <div class="text-center">
                <h1 class="text-4xl lg:text-5xl font-display font-bold text-primary-700 mb-4">
                    📸 Galeri Foto Desa
                </h1>
                <p class="text-lg lg:text-xl text-slate-600 max-w-3xl mx-auto">
                    Dokumentasi lengkap kegiatan, momen berharga, dan keindahan desa dalam koleksi foto
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
            <!-- Filter Section -->
            <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
                <form method="GET" action="{{ route('desa.galeri-wisata.galeri-foto') }}" class="flex flex-col md:flex-row gap-4">
                    <!-- Filter Kategori -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                        <select name="kategori" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori }}" {{ $kategori_selected == $kategori ? 'selected' : '' }}>
                                {{ $kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Tahun -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
                        <select name="tahun" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Semua Tahun</option>
                            @foreach($tahuns as $tahun)
                            <option value="{{ $tahun }}" {{ $tahun_selected == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Button Filter -->
                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full md:w-auto bg-primary-600 hover:bg-primary-700 text-white font-semibold px-8 py-3 rounded-xl transition-colors duration-300">
                            Filter
                        </button>
                    </div>

                    <!-- Reset Filter -->
                    @if($kategori_selected || $tahun_selected)
                    <div class="flex items-end">
                        <a href="{{ route('desa.galeri-wisata.galeri-foto') }}" 
                           class="w-full md:w-auto bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-colors duration-300">
                            Reset
                        </a>
                    </div>
                    @endif
                </form>
            </div>

            <!-- Gallery Grid -->
            @if($fotos->count() > 0)
            <div class="mb-6">
                <p class="text-slate-600">
                    Menampilkan <span class="font-semibold text-primary-600">{{ $fotos->total() }}</span> foto
                    @if($kategori_selected)
                        dalam kategori <span class="font-semibold">{{ $kategori_selected }}</span>
                    @endif
                    @if($tahun_selected)
                        tahun <span class="font-semibold">{{ $tahun_selected }}</span>
                    @endif
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                @foreach($fotos as $foto)
                <div class="gallery-item bg-white rounded-2xl overflow-hidden shadow-md" 
                     data-id="{{ $foto['id'] }}"
                     data-image="{{ $foto['gambar_full'] }}"
                     data-title="{{ $foto['judul'] }}"
                     data-description="{{ $foto['deskripsi'] ?? '' }}"
                     data-date="{{ $foto['tanggal'] }}"
                     data-category="{{ $foto['kategori'] }}">
                    <div class="aspect-square relative">
                        <img src="{{ $foto['gambar'] }}" 
                             alt="{{ $foto['judul'] }}" 
                             class="w-full h-full object-cover">
                        <div class="gallery-overlay">
                            <div class="text-white w-full">
                                <h3 class="font-semibold text-lg mb-1">{{ $foto['judul'] }}</h3>
                                <p class="text-sm opacity-90">{{ $foto['tanggal'] }}</p>
                                <p class="text-xs mt-1">
                                    <span class="bg-primary-600 px-2 py-1 rounded-full">{{ $foto['kategori'] }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $fotos->links() }}
            </div>
            @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                <svg class="w-24 h-24 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Tidak Ada Foto</h3>
                <p class="text-slate-600 mb-6">
                    @if($kategori_selected || $tahun_selected)
                        Tidak ada foto yang ditemukan dengan filter yang dipilih.
                    @else
                        Belum ada foto yang diunggah ke galeri.
                    @endif
                </p>
                @if($kategori_selected || $tahun_selected)
                <a href="{{ route('desa.galeri-wisata.galeri-foto') }}" 
                   class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors">
                    Lihat Semua Foto
                </a>
                @endif
            </div>
            @endif
        </div>
    </section>
</div>

<!-- Lightbox -->
<div id="lightbox" class="lightbox">
    <span class="lightbox-close" id="lightboxClose">&times;</span>
    <button class="lightbox-nav lightbox-prev" id="lightboxPrev">&#10094;</button>
    <button class="lightbox-nav lightbox-next" id="lightboxNext">&#10095;</button>
    <div class="lightbox-content">
        <img id="lightboxImage" class="lightbox-image" src="" alt="">
        <div class="lightbox-info">
            <h3 id="lightboxTitle" class="text-xl font-bold mb-2"></h3>
            <p id="lightboxDate" class="text-sm opacity-90"></p>
            <p id="lightboxDescription" class="text-sm mt-2 opacity-75"></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const galleryItems = document.querySelectorAll('.gallery-item');
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxTitle = document.getElementById('lightboxTitle');
    const lightboxDate = document.getElementById('lightboxDate');
    const lightboxDescription = document.getElementById('lightboxDescription');
    const lightboxClose = document.getElementById('lightboxClose');
    const lightboxPrev = document.getElementById('lightboxPrev');
    const lightboxNext = document.getElementById('lightboxNext');
    
    let currentIndex = 0;
    let images = [];
    
    // Collect all images
    galleryItems.forEach((item, index) => {
        images.push({
            image: item.dataset.image,
            title: item.dataset.title,
            description: item.dataset.description,
            date: item.dataset.date,
            category: item.dataset.category
        });
        
        item.addEventListener('click', () => {
            openLightbox(index);
        });
    });
    
    function openLightbox(index) {
        currentIndex = index;
        updateLightbox();
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
    
    function updateLightbox() {
        const current = images[currentIndex];
        lightboxImage.src = current.image;
        lightboxTitle.textContent = current.title;
        lightboxDate.textContent = current.date;
        lightboxDescription.textContent = current.description || '';
    }
    
    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        updateLightbox();
    }
    
    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateLightbox();
    }
    
    // Event listeners
    lightboxClose.addEventListener('click', closeLightbox);
    lightboxNext.addEventListener('click', nextImage);
    lightboxPrev.addEventListener('click', prevImage);
    
    // Close on background click
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (!lightbox.classList.contains('active')) return;
        
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowRight') {
            nextImage();
        } else if (e.key === 'ArrowLeft') {
            prevImage();
        }
    });
});
</script>
@endpush

