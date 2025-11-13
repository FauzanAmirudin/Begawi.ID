@extends('layouts.admin')

@section('title', 'Detail Video/Dokumentasi')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Detail Video/Dokumentasi</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $video->title }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.content.videos.edit', $video) }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                Edit
            </a>
            <a href="{{ route('admin.content.videos.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="space-y-6">
            @if($video->type === 'youtube' && $video->youtube_embed_url)
            <div class="aspect-video w-full">
                <iframe src="{{ $video->youtube_embed_url }}" class="w-full h-full rounded-lg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            @elseif($video->type === 'pdf' && $video->pdf_file)
            <div class="border-2 border-gray-200 rounded-lg p-4">
                <a href="{{ Storage::url($video->pdf_file) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Buka PDF
                </a>
            </div>
            @endif

            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $video->title }}</h2>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span class="px-2 py-1 rounded-full {{ $video->type === 'youtube' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $video->type === 'youtube' ? 'YouTube' : 'PDF' }}
                    </span>
                    <span>Oleh: {{ $video->creator->name ?? 'N/A' }}</span>
                    <span>{{ $video->created_at->format('d M Y') }}</span>
                    <span>{{ number_format($video->views) }} views</span>
                    @if($video->duration && $video->type === 'youtube')
                    <span>{{ $video->formatted_duration }}</span>
                    @endif
                </div>
            </div>

            @if($video->description)
            <div class="prose max-w-none">
                <p class="text-gray-700">{{ $video->description }}</p>
            </div>
            @endif

            <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                <div>
                    <span class="text-sm text-gray-500">Status:</span>
                    @if($video->is_published)
                        <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                    @else
                        <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

