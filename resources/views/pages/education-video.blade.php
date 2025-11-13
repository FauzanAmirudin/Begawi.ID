@extends('layouts.app')

@section('title', $video->title . ' - Begawi.id')
@section('description', $video->description ?? 'Video tutorial dan dokumentasi')

@section('content')
<div class="min-h-screen bg-gray-50 pt-24">
    <div class="container mx-auto px-4 py-12">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('education') }}" class="hover:text-emerald-600">Edukasi</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900 font-medium">{{ Str::limit($video->title, 50) }}</li>
            </ol>
        </nav>

        <div class="max-w-4xl mx-auto">
            <!-- Video Header -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                @if($video->type === 'youtube' && $video->youtube_embed_url)
                <div class="aspect-video w-full">
                    <iframe src="{{ $video->youtube_embed_url }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                @elseif($video->type === 'pdf' && $video->pdf_file)
                <div class="p-8 text-center">
                    <div class="mb-4">
                        <svg class="w-24 h-24 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <a href="{{ Storage::url($video->pdf_file) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download PDF
                    </a>
                </div>
                @endif
                
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">
                            {{ $video->type === 'youtube' ? 'VIDEO' : 'PDF' }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $video->created_at->format('d F Y') }}</span>
                        <span class="text-sm text-gray-500">{{ number_format($video->views) }} views</span>
                        @if($video->formatted_duration)
                        <span class="text-sm text-gray-500">{{ $video->formatted_duration }}</span>
                        @endif
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-bold text-charcoal-grey mb-4">{{ $video->title }}</h1>
                    
                    @if($video->description)
                    <p class="text-lg text-gray-600 mb-6">{{ $video->description }}</p>
                    @endif
                    
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span>Oleh: {{ $video->creator->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </div>

            <!-- Related Videos -->
            @if($related_videos->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-charcoal-grey mb-6">Video Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($related_videos as $related)
                    <a href="{{ route('education.video', $related->slug) }}" class="group">
                        <div class="bg-gray-50 rounded-xl overflow-hidden hover:shadow-md transition">
                            @if($related->thumbnail)
                            <img src="{{ Storage::url($related->thumbnail) }}" alt="{{ $related->title }}" class="w-full h-32 object-cover">
                            @else
                            <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 group-hover:text-red-600 transition mb-2">
                                    {{ Str::limit($related->title, 60) }}
                                </h3>
                                @if($related->description)
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($related->description, 80) }}</p>
                                @endif
                                <div class="flex items-center gap-3 text-xs text-gray-500">
                                    @if($related->formatted_duration)
                                    <span>{{ $related->formatted_duration }}</span>
                                    @endif
                                    <span>•</span>
                                    <span>{{ number_format($related->views) }} views</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

