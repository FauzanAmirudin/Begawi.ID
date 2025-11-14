@extends('layouts.admin')

@section('title', 'Detail Halaman Informasi')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Detail Halaman Informasi</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $page->title }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.content.pages.edit', $page) }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                Edit
            </a>
            <a href="{{ route('admin.content.pages.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="space-y-6">
            @if($page->featured_image)
            <div>
                <img src="{{ Storage::url($page->featured_image) }}" alt="{{ $page->title }}" class="w-full h-64 object-cover rounded-lg">
            </div>
            @endif

            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $page->title }}</h2>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800">
                        {{ ucfirst($page->page_type) }}
                    </span>
                    <span>Oleh: {{ $page->creator->name ?? 'N/A' }}</span>
                    <span>{{ $page->created_at->format('d M Y, H:i') }}</span>
                    <span>{{ number_format($page->views) }} views</span>
                    @if($page->is_featured)
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Featured</span>
                    @endif
                </div>
            </div>

            @if($page->excerpt)
            <div class="border-l-4 border-emerald-500 pl-4">
                <p class="text-gray-600 italic">{{ $page->excerpt }}</p>
            </div>
            @endif

            <div class="prose max-w-none">
                <div class="text-gray-700 whitespace-pre-wrap">{{ $page->content }}</div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                <div>
                    <span class="text-sm text-gray-500">Status:</span>
                    @if($page->is_published)
                        <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                    @else
                        <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                    @endif
                </div>
                @if($page->published_at)
                <div>
                    <span class="text-sm text-gray-500">Diterbitkan:</span>
                    <span class="ml-2 text-sm text-gray-700">{{ $page->published_at->format('d M Y, H:i') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

