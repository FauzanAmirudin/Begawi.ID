{{-- resources/views/pages/desa/umkm/detail.blade.php --}}

@extends('layouts.desa')

@section('title', $produk['nama'] . ' - Produk UMKM Desa')

@php
    $galleryImages = $galeri ?? ($produk['galeri'] ?? (isset($produk['gambar']) ? [$produk['gambar']] : []));
    if (empty($galleryImages)) {
        $galleryImages = ['https://via.placeholder.com/600x600'];
    }
    $firstImage = $galleryImages[0];
    $kategoriSlug = \Illuminate\Support\Str::slug($produk['kategori']);
    $nomorKontak = $produk['umkm']['kontak'] ?? ($produk['umkm']['telepon'] ?? '');
@endphp

@section('content')
<!-- Breadcrumb -->
<div class="sticky top-18 z-30 bg-white/90 backdrop-blur-sm border-b border-slate-200 py-2">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <nav class="flex text-sm text-slate-600">
            <a href="{{ route('desa.home') }}" class="hover:text-green-700 transition">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('desa.umkm.index') }}" class="hover:text-green-700 transition">Produk UMKM</a>
            <span class="mx-2">/</span>
            <span class="text-green-700 font-medium">{{ $produk['nama'] }}</span>
        </nav>
    </div>
</div>

<!-- Product Detail Section -->
<section class="py-8 bg-white">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left Side - Product Gallery -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="relative">
                    <img 
                        id="mainImage"
                        src="{{ $firstImage }}" 
                        alt="{{ $produk['nama'] }}"
                        class="w-full aspect-square object-cover rounded-2xl shadow-lg"
                    />
                    
                    <!-- Image Navigation Arrows -->
                    @if(count($galleryImages) > 1)
                    <button 
                        id="prevImage" 
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-green-900 p-2 rounded-full shadow-lg transition opacity-0 group-hover:opacity-100"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button 
                        id="nextImage" 
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-green-900 p-2 rounded-full shadow-lg transition opacity-0 group-hover:opacity-100"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    @endif
                    
                    <!-- Zoom Icon -->
                    <button 
                        id="zoomImage"
                        class="absolute top-4 right-4 bg-white/80 hover:bg-white text-green-900 p-2 rounded-full shadow-lg transition"
                        title="Perbesar gambar"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Thumbnail Gallery -->
                @if(count($galleryImages) > 1)
                <div class="flex gap-3 overflow-x-auto pb-2">
                    @foreach($galleryImages as $index => $gambar)
                    <button 
                        class="thumbnail-btn shrink-0 {{ $index === 0 ? 'ring-2 ring-yellow-400' : '' }}"
                        data-image="{{ $gambar }}"
                        data-index="{{ $index }}"
                    >
                        <img 
                            src="{{ $gambar }}" 
                            alt="Thumbnail {{ $index + 1 }}"
                            class="w-20 h-20 object-cover rounded-lg hover:opacity-75 transition"
                        />
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
            
            <!-- Right Side - Product Info -->
            <div class="space-y-6">
                <!-- Product Title & Category -->
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                            {{ $produk['kategori'] }}
                        </span>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-sm text-slate-600">{{ $produk['rating'] }} ({{ $produk['terjual'] }} ulasan)</span>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-green-900 leading-tight">
                        {{ $produk['nama'] }}
                    </h1>
                </div>
                
                <!-- Price & Stock -->
                <div class="border-b border-slate-200 pb-6">
                    <div class="flex items-baseline gap-4 mb-3">
                        <span class="text-3xl font-bold text-green-700">
                            Rp {{ number_format($produk['harga'], 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-slate-500">per unit</span>
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-slate-600">Stok tersedia: <strong>{{ $produk['stok'] }} unit</strong></span>
                        </div>
                        <span class="text-slate-400">•</span>
                        <span class="text-slate-600">{{ $produk['terjual'] }} terjual</span>
                    </div>
                </div>
                
                <!-- Description -->
                <div>
                    <h3 class="text-lg font-semibold text-green-900 mb-3">Deskripsi Produk</h3>
                    <div class="prose prose-slate max-w-none">
                        <p class="text-slate-700 leading-relaxed">
                            {{ $produk['deskripsi'] }}
                        </p>
                    </div>
                </div>
                
                <!-- UMKM Info -->
                <div class="bg-slate-50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Informasi UMKM
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-green-900">{{ $produk['umkm']['nama'] }}</h4>
                                <p class="text-slate-600">Pemilik: {{ $produk['umkm']['pemilik'] }}</p>
                                <p class="text-sm text-slate-500 mt-1">{{ $produk['umkm']['alamat'] }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- UMKM Actions -->
                    <div class="flex gap-3 mt-4">
                        <a 
                            href="{{ route('desa.umkm.toko', $produk['umkm']['slug']) }}"
                            class="flex-1 bg-white hover:bg-slate-50 text-green-900 font-medium text-center border border-slate-300 rounded-xl px-4 py-2 transition"
                        >
                            Lihat Toko
                        </a>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="space-y-4 pt-6 border-t border-slate-200">
                    <!-- WhatsApp Contact -->
                    <a 
                        @if($nomorKontak)
                            href="https://wa.me/62{{ ltrim($nomorKontak, '0') }}?text=Halo, saya tertarik dengan produk {{ urlencode($produk['nama']) }}"
                            target="_blank"
                        @else
                            href="javascript:void(0)"
                            aria-disabled="true"
                        @endif
                        class="flex items-center justify-center gap-3 w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 rounded-xl transition-colors duration-200 shadow-lg hover:shadow-xl{{ $nomorKontak ? '' : ' opacity-60 cursor-not-allowed pointer-events-none' }}"
                    >
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        Hubungi Penjual via WhatsApp
                    </a>
                    
                    <!-- Secondary Actions -->
                    <div class="grid grid-cols-2 gap-3">
                        <button 
                            id="shareProduct"
                            class="flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-3 rounded-xl transition"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                            </svg>
                            Bagikan
                        </button>
                        <button 
                            id="addToWishlist"
                            class="flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-3 rounded-xl transition"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Favorit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="py-12 bg-slate-50">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-green-900">Produk Serupa</h2>
            <a 
                href="{{ route('desa.umkm.kategori', $kategoriSlug) }}"
                class="text-green-700 hover:text-green-800 font-medium text-sm flex items-center gap-1"
            >
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Related products akan diisi dengan data dari controller -->
            @for($i = 1; $i <= 4; $i++)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                <div class="relative">
                    <img 
                        src="https://via.placeholder.com/300x300/166534/ffffff?text=Produk+{{ $i }}" 
                        alt="Produk Serupa {{ $i }}"
                        class="aspect-square object-cover w-full hover:scale-105 transition-transform duration-300"
                    />
                    <div class="absolute top-3 left-3">
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                            {{ $produk['kategori'] }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-green-900 mb-1">Produk Serupa {{ $i }}</h3>
                    <p class="text-sm text-slate-500 mb-2">UMKM Lainnya</p>
                    <div class="flex items-center justify-between">
                        <span class="text-green-700 font-bold">Rp {{ number_format(rand(10000, 50000), 0, ',', '.') }}</span>
                        <div class="flex items-center gap-1 text-xs text-slate-500">
                            <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            4.{{ $i }}
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        <button 
            id="closeModal"
            class="absolute top-4 right-4 bg-white text-black p-2 rounded-full hover:bg-gray-100 transition"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail-btn');
    const images = @json($galleryImages);
    let currentIndex = 0;
    
    // Thumbnail click handler
    thumbnails.forEach((thumb, index) => {
        thumb.addEventListener('click', function() {
            currentIndex = index;
            updateMainImage();
            updateThumbnailActive();
        });
    });
    
    // Navigation arrows
    const prevBtn = document.getElementById('prevImage');
    const nextBtn = document.getElementById('nextImage');
    
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            currentIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
            updateMainImage();
            updateThumbnailActive();
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            currentIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
            updateMainImage();
            updateThumbnailActive();
        });
    }
    
    // Image zoom modal
    const zoomBtn = document.getElementById('zoomImage');
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const closeModal = document.getElementById('closeModal');
    
    zoomBtn.addEventListener('click', function() {
        modalImage.src = mainImage.src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    });
    
    closeModal.addEventListener('click', function() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    });
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    });
    
    // Share functionality
    const shareBtn = document.getElementById('shareProduct');
    shareBtn.addEventListener('click', function() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $produk["nama"] }}',
                text: 'Lihat produk UMKM ini: {{ $produk["nama"] }}',
                url: window.location.href
            });
        } else {
            // Fallback - copy to clipboard
            navigator.clipboard.writeText(window.location.href).then(function() {
                showToast('Link produk berhasil disalin!');
            });
        }
    });
    
    // Wishlist functionality
    const wishlistBtn = document.getElementById('addToWishlist');
    wishlistBtn.addEventListener('click', function() {
        const heart = this.querySelector('svg');
        heart.classList.add('animate-bounce', 'text-red-500');
        this.classList.add('bg-red-50', 'text-red-700');
        showToast('Ditambahkan ke favorit!');
        
        setTimeout(() => {
            heart.classList.remove('animate-bounce');
        }, 600);
    });
    
    // Helper functions
    function updateMainImage() {
        mainImage.src = images[currentIndex];
    }
    
    function updateThumbnailActive() {
        thumbnails.forEach((thumb, index) => {
            if (index === currentIndex) {
                thumb.classList.add('ring-2', 'ring-yellow-400');
            } else {
                thumb.classList.remove('ring-2', 'ring-yellow-400');
            }
        });
    }
    
    function showToast(message) {
        // Simple toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-y-full transition-transform';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('translate-y-full');
        }, 100);
        
        setTimeout(() => {
            toast.classList.add('translate-y-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (modal.classList.contains('flex')) {
            if (e.key === 'Escape') {
                closeModal.click();
            } else if (e.key === 'ArrowLeft') {
                prevBtn?.click();
            } else if (e.key === 'ArrowRight') {
                nextBtn?.click();
            }
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.group:hover .opacity-0 {
    opacity: 1;
}

.prose p {
    margin-bottom: 1rem;
}
</style>
@endpush

@endsection