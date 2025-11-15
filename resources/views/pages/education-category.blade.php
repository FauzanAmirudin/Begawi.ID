@extends('layouts.app')

@section('title', $categoryData['title'] . ' - Pusat Edukasi Digital - Begawi.id')
@section('description', $categoryData['description'] ?? 'Pelajari ' . strtolower($categoryData['title']) . ' untuk mempercepat perjalanan digital Anda.')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-purple-50 to-pink-50">
        <div class="container mx-auto px-4 relative z-10 pt-24 md:pt-32 pb-12">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full text-sm font-semibold mb-6 shadow-lg">
                    <span class="text-2xl mr-2">{{ $categoryData['icon'] }}</span>
                    {{ $categoryData['subtitle'] }}
                </div>
                <h1 class="font-manrope font-extrabold text-4xl md:text-6xl text-charcoal-grey mb-6">
                    {{ $categoryData['title'] }}
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    {{ $categoryData['description'] }}
                </p>
            </div>
        </div>
    </section>
    
    <!-- Articles Listing Section -->
    <section class="py-20 px-6 bg-gray-50">
        <div class="container mx-auto px-4">
            @if($tutorials->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($tutorials as $tutorial)
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all hover-tilt">
                    <div class="relative">
                        @if($tutorial['image'])
                        <img src="{{ $tutorial['image'] }}" alt="{{ $tutorial['title'] }}" class="w-full h-48 object-cover">
                        @else
                        <div class="w-full h-48 bg-gradient-to-br 
                            {{ $category === 'tutorial' || $category === 'pemula' ? 'from-emerald-500 to-emerald-600' : '' }}
                            {{ $category === 'tips' || $category === 'menengah' ? 'from-orange-500 to-orange-600' : '' }}
                            {{ $category === 'update' || $category === 'mahir' ? 'from-purple-500 to-purple-600' : '' }}
                            flex items-center justify-center">
                            <span class="text-6xl text-white opacity-50">{{ $categoryData['icon'] }}</span>
                        </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 text-xs font-bold rounded-full text-white
                                {{ $tutorial['category'] === 'Tutorial' ? 'bg-emerald-600' : '' }}
                                {{ $tutorial['category'] === 'Tips' ? 'bg-orange-600' : '' }}
                                {{ $tutorial['category'] === 'Update' ? 'bg-purple-600' : '' }}
                            ">
                                {{ $tutorial['category'] }}
                            </span>
                        </div>
                        @if($tutorial['difficulty'])
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-white/90 backdrop-blur-sm text-gray-700">
                                {{ $tutorial['difficulty'] }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="font-poppins font-bold text-xl text-charcoal-grey mb-3 line-clamp-2">
                            {{ $tutorial['title'] }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed line-clamp-3">
                            {{ $tutorial['excerpt'] }}
                        </p>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $tutorial['duration'] }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ number_format($tutorial['views']) }} views
                            </span>
                        </div>
                        <a href="{{ route('education.article', $tutorial['slug']) }}" class="inline-flex items-center w-full justify-center px-4 py-2 
                            {{ $tutorial['category'] === 'Tutorial' ? 'bg-emerald-600 hover:bg-emerald-700' : '' }}
                            {{ $tutorial['category'] === 'Tips' ? 'bg-orange-600 hover:bg-orange-700' : '' }}
                            {{ $tutorial['category'] === 'Update' ? 'bg-purple-600 hover:bg-purple-700' : '' }}
                            text-white font-semibold rounded-lg transition-all">
                            Baca {{ $tutorial['category'] === 'Tips' ? 'Tips' : ($tutorial['category'] === 'Update' ? 'Update' : 'Tutorial') }}
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-500">Belum ada konten untuk kategori ini</p>
                <p class="mt-1 text-xs text-gray-400">Konten akan segera ditambahkan</p>
            </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation on scroll
        const cards = document.querySelectorAll('.hover-tilt');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                }
            });
        }, { threshold: 0.1 });
        
        cards.forEach(card => observer.observe(card));
    });
</script>
@endpush

