@extends('layouts.admin')

@section('title', 'Detail Artikel')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Detail Artikel</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $article->title }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.content.articles.edit', $article) }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                Edit
            </a>
            <a href="{{ route('admin.content.articles.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                Kembali
            </a>
        </div>
    </div>

    <!-- Article Details -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="space-y-6">
            @if($article->featured_image)
            <div>
                <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-64 object-cover rounded-lg">
            </div>
            @endif

            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $article->title }}</h2>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span class="px-2 py-1 rounded-full 
                        {{ $article->category === 'Tutorial' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $article->category === 'Update' ? 'bg-purple-100 text-purple-800' : '' }}
                        {{ $article->category === 'Tips' ? 'bg-orange-100 text-orange-800' : '' }}
                    ">
                        {{ $article->category }}
                    </span>
                    <span>Oleh: {{ $article->creator->name ?? 'N/A' }}</span>
                    <span>{{ $article->created_at->format('d M Y, H:i') }}</span>
                    <span>{{ number_format($article->views) }} views</span>
                </div>
            </div>

            @if($article->excerpt)
            <div class="border-l-4 border-emerald-500 pl-4">
                <p class="text-gray-600 italic">{{ $article->excerpt }}</p>
            </div>
            @endif

            <div class="prose max-w-none">
                <div class="text-gray-700 whitespace-pre-wrap">{{ $article->content }}</div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                <div>
                    <span class="text-sm text-gray-500">Status:</span>
                    @if($article->is_published)
                        <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                    @else
                        <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                    @endif
                </div>
                @if($article->published_at)
                <div>
                    <span class="text-sm text-gray-500">Diterbitkan:</span>
                    <span class="ml-2 text-sm text-gray-700">{{ $article->published_at->format('d M Y, H:i') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

