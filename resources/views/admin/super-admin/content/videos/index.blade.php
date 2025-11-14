@extends('layouts.admin')

@section('title', 'Video & Dokumentasi')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Video & Dokumentasi</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola video YouTube dan file PDF dokumentasi</p>
        </div>
        <a href="{{ route('admin.content.videos.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-medium hover:shadow-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Video/Dokumentasi
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <!-- Videos Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($videos as $video)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
            @if($video->thumbnail)
            <img src="{{ Storage::url($video->thumbnail) }}" alt="{{ $video->title }}" class="w-full h-48 object-cover">
            @elseif($video->type === 'youtube')
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
            </div>
            @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            </div>
            @endif
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $video->type === 'youtube' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}
                    ">
                        {{ $video->type === 'youtube' ? 'YouTube' : 'PDF' }}
                    </span>
                    @if($video->is_published)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Draft</span>
                    @endif
                </div>
                
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ Str::limit($video->title, 50) }}</h3>
                
                @if($video->description)
                <p class="text-sm text-gray-600 mb-4">{{ Str::limit($video->description, 100) }}</p>
                @endif

                <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                    <span>{{ number_format($video->views) }} views</span>
                    @if($video->duration && $video->type === 'youtube')
                    <span>{{ $video->formatted_duration }}</span>
                    @endif
                </div>

                <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.content.videos.show', $video) }}" class="flex-1 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg font-medium hover:bg-emerald-100 transition text-center text-sm">
                        Detail
                    </a>
                    <a href="{{ route('admin.content.videos.edit', $video) }}" class="flex-1 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg font-medium hover:bg-blue-100 transition text-center text-sm">
                        Edit
                    </a>
                    <form action="{{ route('admin.content.videos.destroy', $video) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-50 text-red-700 rounded-lg font-medium hover:bg-red-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            <p class="mt-2 text-sm text-gray-500">Belum ada video atau dokumentasi</p>
            <a href="{{ route('admin.content.videos.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                Tambah Video/Dokumentasi Pertama
            </a>
        </div>
        @endforelse
    </div>

    @if($videos->hasPages())
    <div class="mt-6">
        {{ $videos->links() }}
    </div>
    @endif
</div>
@endsection

