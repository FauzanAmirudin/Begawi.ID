@extends('layouts.admin')

@section('title', 'Dokumentasi Bantuan')

@section('content')
<div class="p-6">
    <div class="flex flex-col gap-6">
        <div class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl p-8 text-white shadow-sm">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="max-w-xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">Knowledge Base</p>
                    <h1 class="text-3xl font-semibold mt-2">Dokumentasi Bantuan</h1>
                    <p class="text-sm text-white/80 mt-3 leading-relaxed">
                        Temukan panduan teknis, FAQ, dan tutorial terbaru untuk Admin Desa dan UMKM.
                        Gunakan pencarian untuk mendapatkan jawaban lebih cepat.
                    </p>
                </div>
                <div class="flex flex-col items-end gap-3 w-full lg:w-auto">
                    <div class="bg-white/10 rounded-xl p-4 w-full lg:w-72">
                        <p class="text-xs text-white/70 uppercase font-semibold">Ringkasan</p>
                        <div class="mt-3 space-y-2">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-white/80">Total Artikel</span>
                                <span class="font-semibold">{{ number_format($articles->total()) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-white/80">Sorotan</span>
                                <span class="font-semibold">{{ $featuredArticles->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-white/80">Kategori</span>
                                <span class="font-semibold">{{ $categories->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.support.articles.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 text-white/90 text-sm font-semibold rounded-lg hover:bg-white/25 transition">
                        Kelola Artikel
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="mt-6">
                <form method="GET" class="relative">
                    <input type="text"
                           name="search"
                           value="{{ $filters['search'] ?? '' }}"
                           class="w-full rounded-xl bg-white/15 border border-white/20 text-sm text-white placeholder-white/60 py-3 pl-12 pr-4 focus:outline-none focus:ring-2 focus:ring-white/60"
                           placeholder="Cari artikel, topik, atau kata kunci...">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/70">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    @if(!empty($filters['category']))
                    <input type="hidden" name="category" value="{{ $filters['category'] }}">
                    @endif
                </form>
            </div>
        </div>

        <!-- Categories -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Kategori Utama</h2>
                <div class="flex items-center gap-3 text-xs text-purple-100">
                    <span class="px-3 py-1 bg-purple-600/60 rounded-full">Filter berdasarkan kategori</span>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                @foreach($categories as $category)
                <a href="{{ route('admin.support.documentation', array_filter(['category' => $category['label'], 'search' => $filters['search'] ?? null])) }}"
                   class="bg-white rounded-2xl p-6 shadow-sm border {{ $category['active'] ? 'border-purple-200 ring-2 ring-purple-100' : 'border-gray-100' }} hover:border-purple-200 transition flex flex-col h-full">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white flex items-center justify-center text-sm font-semibold">
                        {{ strtoupper(substr($category['label'], 0, 2)) }}
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ $category['label'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mt-2 flex-1">{{ $category['description'] }}</p>
                    <div class="mt-4 flex items-center justify-between text-xs uppercase tracking-wide">
                        <span class="text-purple-600 font-semibold">{{ $category['count'] }} artikel</span>
                        @if($category['active'])
                        <span class="text-purple-500 font-semibold">Sedang dipilih</span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Articles & Release Notes -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Artikel Terbaru</h2>
                            <p class="text-xs text-gray-500">{{ $articles->total() }} artikel ditemukan</p>
                        </div>
                        @if(!empty($filters['search']) || !empty($filters['category']))
                        <a href="{{ route('admin.support.documentation') }}" class="text-sm font-semibold text-purple-600 hover:text-purple-700">
                            Reset Filter
                        </a>
                        @endif
                    </div>
                    <div class="space-y-4">
                        @forelse($articles as $article)
                        <div class="border border-gray-100 rounded-xl p-5 hover:border-purple-200 transition">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 text-xs text-purple-600 font-semibold uppercase tracking-wide">
                                        <span>{{ $article->category }}</span>
                                        <span class="w-1 h-1 rounded-full bg-purple-200"></span>
                                        <span>{{ optional($article->published_at)->translatedFormat('d F Y') ?? $article->created_at->translatedFormat('d F Y') }}</span>
                                        <span class="w-1 h-1 rounded-full bg-purple-200"></span>
                                        <span>{{ number_format($article->views ?? 0) }} kali dibaca</span>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mt-2">{{ $article->title }}</h3>
                                    @if($article->excerpt)
                                    <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $article->excerpt }}</p>
                                    @else
                                    <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ \Illuminate\Support\Str::limit(strip_tags($article->content), 180) }}</p>
                                    @endif
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <a href="{{ route('admin.support.documentation.show', $article->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm font-semibold rounded-lg hover:opacity-90 transition">
                                        Baca Panduan
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.support.articles.edit', $article) }}" class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1 0v14m-7-7h14"></path>
                                        </svg>
                                        Edit Cepat
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 text-sm text-gray-500">
                            Tidak ada artikel yang sesuai. Coba ubah kata kunci atau kategori.
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $articles->links() }}
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-800">Artikel Sorotan</h2>
                        <span class="text-xs text-gray-400 uppercase tracking-wide">Paling sering diakses</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($featuredArticles as $featured)
                        <div class="border border-gray-100 rounded-xl p-5 hover:border-purple-200 transition">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-purple-600 font-semibold">{{ $featured['category'] }}</p>
                                    <h3 class="text-sm font-semibold text-gray-900 mt-1">{{ $featured['title'] }}</h3>
                                    <p class="text-xs text-gray-500 mt-2">Pembacaan {{ $featured['reading_time'] }} • Update {{ $featured['updated_at'] }}</p>
                                </div>
                                <a href="{{ route('admin.support.documentation.show', $featured['slug']) }}" class="px-3 py-1 bg-purple-50 text-purple-600 text-xs font-semibold rounded-lg hover:bg-purple-100 transition">
                                    Baca
                                </a>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Belum ada artikel sorotan.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">Catatan Rilis</h2>
                    <p class="text-xs text-gray-500 mt-1">Pelajari fitur terbaru untuk tenant.</p>
                    <div class="mt-4 space-y-4">
                        @forelse($releaseNotes as $release)
                        <div class="border border-gray-100 rounded-xl p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-900">{{ $release['version'] ?? 'v0.0.0' }}</span>
                                <span class="text-xs text-gray-400">{{ $release['date'] ?? '-' }}</span>
                            </div>
                            <ul class="mt-3 space-y-2 text-xs text-gray-600">
                                @forelse($release['highlights'] ?? [] as $highlight)
                                <li class="flex gap-2">
                                    <span class="text-purple-500">•</span>
                                    <span>{{ $highlight }}</span>
                                </li>
                                @empty
                                <li class="text-gray-400">Tidak ada highlight yang tersedia.</li>
                                @endforelse
                            </ul>
                            @if(!empty($release['slug']))
                            <a href="{{ route('admin.support.documentation.show', $release['slug']) }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-purple-600 hover:text-purple-700">
                                Lihat detail
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            @endif
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Belum ada catatan rilis terbaru.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-2xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold">Tidak menemukan jawaban?</h2>
                    <p class="text-sm text-white/80 mt-2 leading-relaxed">Buat tiket baru atau hubungi tim teknis untuk mendapatkan panduan langsung.</p>
                    <div class="mt-4 space-y-2 text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2v-9a2 2 0 012-2h2"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v9m0-9l3 3m-3-3l-3 3M12 3v9"></path>
                            </svg>
                            Panduan langkah demi langkah
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414M6.05 17.95l-1.414 1.414M9 5H5a2 2 0 00-2 2v4m16 0v4a2 2 0 01-2 2h-4"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h.01M19 9h.01M9 15h.01M5 15h.01"></path>
                            </svg>
                            Template respon siap pakai
                        </div>
                    </div>
                    <a href="{{ route('admin.support.contact') }}" class="mt-6 inline-flex items-center gap-2 bg-white/20 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/30 transition">
                        Hubungi Support
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

