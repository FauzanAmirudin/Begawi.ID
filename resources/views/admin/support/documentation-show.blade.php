@extends('layouts.admin')

@section('title', $article->title)

@php
    use Illuminate\Support\Facades\Storage;
    $statusChip = $article->is_published
        ? ['label' => 'Published', 'classes' => 'bg-emerald-100 text-emerald-600']
        : ['label' => 'Draft', 'classes' => 'bg-gray-100 text-gray-600'];
@endphp
<div class="p-6">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ url()->previous() === url()->current() ? route('admin.support.documentation') : url()->previous() }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100 text-gray-500 hover:text-gray-700 hover:bg-gray-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Dokumentasi Bantuan</p>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $article->title }}</h1>
                    <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-gray-500">
                        <span class="px-3 py-1 bg-purple-50 text-purple-600 font-semibold uppercase tracking-wide rounded-full">{{ $article->category }}</span>
                        <span>{{ optional($article->published_at)->translatedFormat('d F Y H:i') ?? $article->created_at->translatedFormat('d F Y H:i') }}</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span>{{ number_format($article->views ?? 0) }} kali dibaca</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusChip['classes'] }}">{{ $statusChip['label'] }}</span>
                <a href="{{ route('admin.support.articles.edit', $article) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:border-gray-300 transition">
                    Edit Artikel
                </a>
            </div>
        </div>

        @if($article->featured_image)
        <div class="rounded-2xl overflow-hidden border border-gray-100">
            <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full object-cover max-h-[420px]">
        </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-6">
                @if($article->excerpt)
                <div class="p-5 bg-purple-50 border border-purple-100 rounded-xl">
                    <p class="text-sm text-purple-700 leading-relaxed">{{ $article->excerpt }}</p>
                </div>
                @endif

                <article class="prose prose-sm lg:prose-base max-w-none text-gray-700">
                    {!! $article->content !!}
                </article>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">Informasi Artikel</h2>
                    <dl class="mt-4 space-y-3 text-sm text-gray-600">
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-gray-500">Status</dt>
                            <dd><span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusChip['classes'] }}">{{ $statusChip['label'] }}</span></dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-gray-500">Kategori</dt>
                            <dd class="font-semibold text-gray-800">{{ $article->category }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-gray-500">Dipublikasikan</dt>
                            <dd>{{ optional($article->published_at)->translatedFormat('d F Y H:i') ?? '-' }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-gray-500">Dibuat oleh</dt>
                            <dd>{{ optional($article->creator)->name ?? 'Support Team' }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <dt class="text-gray-500">Dilihat</dt>
                            <dd>{{ number_format($article->views ?? 0) }} kali</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">Artikel Terkait</h2>
                    <div class="mt-4 space-y-4">
                        @forelse($relatedArticles as $related)
                        <div class="border border-gray-100 rounded-xl p-4 hover:border-purple-200 transition">
                            <p class="text-xs uppercase tracking-wide text-purple-600 font-semibold mb-1">{{ $related->category }}</p>
                            <h3 class="text-sm font-semibold text-gray-900">{{ $related->title }}</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ optional($related->published_at)->translatedFormat('d F Y') ?? $related->created_at->translatedFormat('d F Y') }}</p>
                            <a href="{{ route('admin.support.documentation.show', $related->slug) }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-purple-600 hover:text-purple-700">
                                Baca artikel
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Belum ada artikel lain dalam kategori ini.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-2xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold">Butuh tindak lanjut?</h2>
                    <p class="text-sm text-white/80 mt-2 leading-relaxed">Jika artikel ini belum menjawab pengaduan tenant, buat tiket eskalasi untuk tim teknis.</p>
                    <a href="{{ route('admin.support.contact') }}" class="mt-6 inline-flex items-center gap-2 bg-white/20 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/30 transition">
                        Buat Tiket
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

