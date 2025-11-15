@extends('layouts.app')

@section('title', $articleData['title'] . ' - Begawi.id')
@section('description', $articleData['excerpt'] ?? Str::limit(strip_tags($articleData['content']), 160))

@push('styles')
<style>
    .article-content {
        @apply text-gray-700 leading-relaxed;
    }
    .article-content p {
        @apply mb-6 text-lg;
    }
    .article-content h2 {
        @apply text-2xl font-bold text-charcoal-grey mt-8 mb-4;
    }
    .article-content h3 {
        @apply text-xl font-bold text-charcoal-grey mt-6 mb-3;
    }
    .article-content ul, .article-content ol {
        @apply mb-6 pl-6 space-y-2;
    }
    .article-content ul {
        @apply list-disc;
    }
    .article-content ol {
        @apply list-decimal;
    }
    .article-content a {
        @apply text-emerald-600 hover:text-emerald-700 underline;
    }
    .article-content blockquote {
        @apply border-l-4 border-emerald-500 pl-6 py-4 my-6 italic bg-emerald-50 rounded-r-xl;
    }
    .article-content img {
        @apply rounded-xl my-6 shadow-lg;
    }
    .article-content code {
        @apply bg-gray-100 px-2 py-1 rounded text-sm font-mono;
    }
    .article-content pre {
        @apply bg-gray-900 text-gray-100 p-4 rounded-xl overflow-x-auto my-6;
    }
    .article-content pre code {
        @apply bg-transparent text-gray-100 p-0;
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-[50vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-purple-50 to-pink-50 pt-24">
        <div class="container mx-auto px-4 relative z-10 py-12">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-8">
                    <ol class="flex items-center space-x-2 text-sm text-gray-600">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-600 transition">Beranda</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li><a href="{{ route('education') }}" class="hover:text-emerald-600 transition">Edukasi</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-gray-900 font-medium">{{ Str::limit($articleData['title'], 50) }}</li>
                    </ol>
                </nav>

                <!-- Article Header -->
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center gap-4 mb-6 flex-wrap">
                        <span class="px-4 py-2 text-xs font-bold rounded-full 
                            {{ $articleData['category'] === 'Tutorial' ? 'bg-emerald-100 text-emerald-800' : '' }}
                            {{ $articleData['category'] === 'Tips' ? 'bg-orange-100 text-orange-800' : '' }}
                            {{ $articleData['category'] === 'Update' ? 'bg-purple-100 text-purple-800' : '' }}
                        ">
                            {{ $articleData['category'] }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $articleData['published_at'] }}</span>
                        <span class="text-sm text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ number_format($articleData['views']) }} views
                        </span>
                    </div>
                    
                    <h1 class="font-manrope font-extrabold text-3xl md:text-5xl text-charcoal-grey mb-6 leading-tight">
                        {{ $articleData['title'] }}
                    </h1>
                    
                    @if($articleData['excerpt'])
                    <p class="text-xl text-gray-600 mb-6 max-w-3xl mx-auto leading-relaxed">
                        {{ $articleData['excerpt'] }}
                    </p>
                    @endif
                    
                    <div class="flex items-center justify-center gap-6 text-sm text-gray-500 flex-wrap">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($articleData['author'], 0, 1)) }}
                            </div>
                            <span>Oleh: <span class="font-semibold text-gray-700">{{ $articleData['author'] }}</span></span>
                        </div>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $articleData['duration'] }} membaca
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Content Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                @if($articleData['image'])
                <div class="mb-8 rounded-2xl overflow-hidden shadow-xl">
                    <img src="{{ $articleData['image'] }}" alt="{{ $articleData['title'] }}" class="w-full h-auto object-cover">
                </div>
                @endif

                <!-- Article Content -->
                <div class="bg-white rounded-2xl p-8 md:p-12 mb-8">
                    <div class="article-content">
                        {!! $articleData['content'] !!}
                    </div>
                </div>

                <!-- Share Section -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-2xl p-6 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-charcoal-grey mb-1">Bagikan Artikel Ini</h3>
                        <p class="text-sm text-gray-600">Bantu teman-teman Anda belajar juga!</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button onclick="shareToWhatsApp()" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            WhatsApp
                        </button>
                        <button onclick="shareToFacebook()" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </button>
                        <button onclick="copyLink()" class="px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-all flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Salin Link
                        </button>
                    </div>
                </div>

                <!-- Related Articles -->
                @if($related_articles->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h2 class="font-manrope font-extrabold text-2xl md:text-3xl text-charcoal-grey mb-6">Artikel Terkait</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($related_articles as $related)
                        <a href="{{ route('education.article', $related['slug']) }}" class="group bg-gray-50 rounded-xl overflow-hidden hover:shadow-xl transition-all hover-tilt">
                            @if($related['image'])
                            <img src="{{ $related['image'] }}" alt="{{ $related['title'] }}" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                            <div class="w-full h-40 bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                                <span class="text-4xl text-white opacity-50">📄</span>
                            </div>
                            @endif
                            <div class="p-5">
                                <h3 class="font-poppins font-bold text-lg text-charcoal-grey group-hover:text-emerald-600 transition mb-2 line-clamp-2">
                                    {{ Str::limit($related['title'], 60) }}
                                </h3>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($related['excerpt'], 80) }}</p>
                                <div class="flex items-center gap-3 text-xs text-gray-500">
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $related['duration'] }}
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ number_format($related['views']) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function shareToWhatsApp() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('{{ $articleData["title"] }}');
        window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
    }

    function shareToFacebook() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link berhasil disalin!');
        }).catch(() => {
            alert('Gagal menyalin link');
        });
    }
</script>
@endpush

