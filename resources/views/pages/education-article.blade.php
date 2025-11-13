@extends('layouts.app')

@section('title', $articleData['title'] . ' - Begawi.id')
@section('description', $articleData['excerpt'] ?? Str::limit(strip_tags($articleData['content']), 160))

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
                <li class="text-gray-900 font-medium">{{ Str::limit($articleData['title'], 50) }}</li>
            </ol>
        </nav>

        <div class="max-w-4xl mx-auto">
            <!-- Article Header -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                @if($articleData['image'])
                <img src="{{ $articleData['image'] }}" alt="{{ $articleData['title'] }}" class="w-full h-64 md:h-96 object-cover">
                @endif
                
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="px-3 py-1 text-xs font-bold rounded-full 
                            {{ $articleData['category'] === 'Tutorial' ? 'bg-emerald-100 text-emerald-800' : '' }}
                            {{ $articleData['category'] === 'Tips' ? 'bg-orange-100 text-orange-800' : '' }}
                            {{ $articleData['category'] === 'Update' ? 'bg-purple-100 text-purple-800' : '' }}
                        ">
                            {{ $articleData['category'] }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $articleData['published_at'] }}</span>
                        <span class="text-sm text-gray-500">{{ number_format($articleData['views']) }} views</span>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-bold text-charcoal-grey mb-4">{{ $articleData['title'] }}</h1>
                    
                    @if($articleData['excerpt'])
                    <p class="text-xl text-gray-600 mb-6">{{ $articleData['excerpt'] }}</p>
                    @endif
                    
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span>Oleh: {{ $articleData['author'] }}</span>
                        <span>•</span>
                        <span>{{ $articleData['duration'] }} membaca</span>
                    </div>
                </div>
            </div>

            <!-- Article Content -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
                <div class="prose prose-lg max-w-none text-gray-700">
                    {!! $articleData['content'] !!}
                </div>
            </div>

            <!-- Related Articles -->
            @if($related_articles->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-charcoal-grey mb-6">Artikel Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($related_articles as $related)
                    <a href="{{ route('education.article', $related['slug']) }}" class="group">
                        <div class="bg-gray-50 rounded-xl overflow-hidden hover:shadow-md transition">
                            @if($related['image'])
                            <img src="{{ $related['image'] }}" alt="{{ $related['title'] }}" class="w-full h-32 object-cover">
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 group-hover:text-emerald-600 transition mb-2">
                                    {{ Str::limit($related['title'], 60) }}
                                </h3>
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($related['excerpt'], 80) }}</p>
                                <div class="flex items-center gap-3 text-xs text-gray-500">
                                    <span>{{ $related['duration'] }}</span>
                                    <span>•</span>
                                    <span>{{ number_format($related['views']) }} views</span>
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

