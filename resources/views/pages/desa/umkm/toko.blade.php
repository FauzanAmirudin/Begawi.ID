@extends('layouts.desa')

@section('title', ($umkm['nama'] ?? 'Toko UMKM') . ' - Desa Sejahtera')

@push('styles')
<style>
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }
    
    .fade-in-up.visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .product-card .product-image {
        transition: transform 0.3s ease;
    }
    
    .sticky-header {
        position: sticky;
        top: 80px;
        z-index: 40;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }
</style>
@endpush

@section('content')
@if(!$umkm)
    <!-- Error State -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 text-center">
            <div class="bg-white rounded-2xl shadow-md p-12">
                <svg class="w-24 h-24 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Toko Tidak Ditemukan</h2>
                <p class="text-slate-600 mb-6">Toko yang Anda cari tidak tersedia atau sudah tidak aktif.</p>
                <a href="{{ route('desa.umkm.index') }}" class="inline-block bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                    Kembali ke Daftar UMKM
                </a>
            </div>
        </div>
    </section>
@else
<!-- Breadcrumb -->
<div class="sticky-header border-b border-slate-200">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 py-3">
        <nav class="flex text-sm text-slate-600">
            <a href="{{ route('desa.home') }}" class="hover:text-green-700 transition">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('desa.umkm.index') }}" class="hover:text-green-700 transition">Produk UMKM</a>
            <span class="mx-2">/</span>
            <span class="text-green-700 font-medium">{{ $umkm['nama'] }}</span>
        </nav>
    </div>
</div>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-green-50 to-amber-50 py-12">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            <!-- Logo UMKM -->
            <div class="flex-shrink-0">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl overflow-hidden bg-white shadow-lg border-4 border-green-100">
                    <img src="{{ $umkm['logo'] }}" alt="{{ $umkm['nama'] }}" 
                         class="w-full h-full object-cover">
                </div>
            </div>
            
            <!-- Info UMKM -->
            <div class="flex-1 text-center md:text-left">
                <div class="mb-4">
                    <span class="inline-block bg-green-100 text-green-800 text-sm font-medium px-4 py-1.5 rounded-full mb-3">
                        {{ $umkm['kategori'] }}
                    </span>
                    <h1 class="text-3xl md:text-4xl font-display font-bold text-green-900 mb-2">
                        {{ $umkm['nama'] }}
                    </h1>
                    <p class="text-lg text-slate-600">
                        Pemilik: <span class="font-semibold">{{ $umkm['pemilik'] }}</span>
                    </p>
                </div>
                
                @if($umkm['deskripsi'])
                <p class="text-slate-700 leading-relaxed mb-6 max-w-3xl">
                    {{ $umkm['deskripsi'] }}
                </p>
                @endif
                
                <!-- Contact Info -->
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                    @if($umkm['kontak'])
                    <a href="https://wa.me/62{{ ltrim($umkm['kontak'], '0') }}?text=Halo, saya tertarik dengan produk dari {{ urlencode($umkm['nama']) }}" 
                       target="_blank"
                       class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-colors shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        Hubungi via WhatsApp
                    </a>
                    @endif
                    
                    @if($umkm['email'])
                    <a href="mailto:{{ $umkm['email'] }}" 
                       class="flex items-center gap-2 bg-white hover:bg-slate-50 text-green-700 border-2 border-green-200 px-5 py-2.5 rounded-xl font-semibold transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<div class="bg-white border-b border-slate-200">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 py-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-green-700 mb-1">{{ count($produk_toko) }}</div>
                <div class="text-sm text-slate-600">Total Produk</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-700 mb-1">{{ $umkm['kategori'] }}</div>
                <div class="text-sm text-slate-600">Kategori</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-700 mb-1">4.5</div>
                <div class="text-sm text-slate-600">Rating</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-pink-700 mb-1">
                    @php
                        $totalTerjual = collect($produk_toko)->sum('terjual');
                    @endphp
                    {{ $totalTerjual }}
                </div>
                <div class="text-sm text-slate-600">Produk Terjual</div>
            </div>
        </div>
    </div>
</div>

<!-- Products Section -->
<section class="py-12 bg-slate-50">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between mb-8 fade-in-up">
            <h2 class="text-3xl font-display font-bold text-green-900 border-b-4 border-yellow-400 inline-block pb-2">
                🛍️ Produk dari {{ $umkm['nama'] }}
            </h2>
            <span class="text-slate-600 text-sm">{{ count($produk_toko) }} produk</span>
        </div>
        
        @if(count($produk_toko) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($produk_toko as $item)
            <div class="product-card bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group fade-in-up">
                @if($item['unggulan'])
                <div class="absolute top-3 left-3 bg-yellow-400 text-green-900 text-xs px-2 py-1 rounded-full font-bold z-10">
                    ⭐ Unggulan
                </div>
                @endif
                
                <button class="absolute top-3 right-3 wishlist-btn p-2 bg-white/80 rounded-full hover:bg-white transition-colors z-10" 
                        onclick="toggleWishlist(this)">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
                
                <div class="aspect-square overflow-hidden">
                    <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}" 
                         class="product-image w-full h-full object-cover">
                </div>
                
                <div class="p-5">
                    <div class="mb-2">
                        <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">{{ $item['kategori'] }}</span>
                    </div>
                    <h3 class="text-lg font-display font-semibold text-green-900 mb-2 line-clamp-2 group-hover:text-green-700 transition-colors">
                        {{ $item['nama'] }}
                    </h3>
                    
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-sm text-slate-600">{{ $item['rating'] }}</span>
                        </div>
                        <span class="text-xs text-slate-500">{{ $item['terjual'] }} terjual</span>
                    </div>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-green-700 font-bold text-lg">{{ $item['harga_format'] }}</span>
                        <span class="text-xs text-slate-500">Stok: {{ $item['stok'] }}</span>
                    </div>
                    
                    <a href="{{ route('desa.umkm.detail', $item['slug']) }}" 
                       class="block bg-green-100 hover:bg-green-200 text-green-800 font-medium text-center py-2 rounded-xl transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-md p-12 text-center fade-in-up">
            <svg class="w-24 h-24 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <h3 class="text-xl font-semibold text-slate-800 mb-2">Belum Ada Produk</h3>
            <p class="text-slate-600 mb-6">Toko ini belum memiliki produk yang tersedia.</p>
            <a href="{{ route('desa.umkm.index') }}" class="inline-block bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                Lihat UMKM Lainnya
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Related UMKM Section -->
<section class="py-12 bg-white">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between mb-8 fade-in-up">
            <h2 class="text-3xl font-display font-bold text-green-900 border-b-4 border-yellow-400 inline-block pb-2">
                🏢 UMKM Lainnya
            </h2>
            <a href="{{ route('desa.umkm.index') }}" class="text-green-700 hover:text-green-800 font-medium">Lihat Semua →</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Placeholder for related UMKM - bisa diisi dengan data dari controller jika diperlukan -->
            <div class="bg-slate-50 rounded-2xl p-6 text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-green-900 mb-2">UMKM Lainnya</h3>
                <p class="text-sm text-slate-500 mb-4">Jelajahi UMKM lainnya</p>
                <a href="{{ route('desa.umkm.index') }}" class="text-green-700 hover:text-green-800 text-sm font-medium">
                    Lihat Semua →
                </a>
            </div>
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.fade-in-up').forEach(el => {
        observer.observe(el);
    });
});

// Toggle wishlist
function toggleWishlist(button) {
    button.classList.toggle('active');
    const svg = button.querySelector('svg');
    
    if (button.classList.contains('active')) {
        svg.setAttribute('fill', 'currentColor');
        svg.classList.add('text-yellow-500');
        showToast('Ditambahkan ke wishlist!');
    } else {
        svg.setAttribute('fill', 'none');
        svg.classList.remove('text-yellow-500');
        showToast('Dihapus dari wishlist!');
    }
}

// Show toast notification
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-green-800 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-y-full opacity-0 transition-all duration-300';
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.remove('translate-y-full', 'opacity-0');
    }, 100);
    
    setTimeout(() => {
        toast.classList.add('translate-y-full', 'opacity-0');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}
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

.wishlist-btn.active svg {
    fill: currentColor;
    color: #FACC15;
    animation: bounce 0.6s ease;
}

@keyframes bounce {
    0%, 20%, 60%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    80% { transform: translateY(-5px); }
}
</style>
@endpush

@endsection

