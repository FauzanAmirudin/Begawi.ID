@extends('layouts.admin')

@section('title', 'Detail Desa - ' . $village->name)

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.websites.desa') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-2xl font-semibold text-gray-800">Detail Desa: {{ $village->name }}</h1>
            </div>
            <p class="text-sm text-gray-500">Kelola dan monitor semua data desa dari super admin</p>
            <div class="mt-3 flex items-center gap-4 text-sm text-gray-600">
                <a href="http://{{ $website->url }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 font-medium">
                    Lihat Website Desa →
                </a>
                <span>•</span>
                <span>Website: <span class="font-semibold">{{ $website->name }}</span></span>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Berita Terbit</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['news_published'] }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $stats['news_draft'] }} draft</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Item Galeri</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['gallery_total'] }}</p>
            <p class="text-xs text-gray-400 mt-1">foto & video</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Potensi Desa</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['potentials_total'] }}</p>
            <p class="text-xs text-gray-400 mt-1">wisata & ekonomi</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Prestasi</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['achievements_total'] }}</p>
            <p class="text-xs text-gray-400 mt-1">penghargaan</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Program Aktif</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['programs_total'] }}</p>
            <p class="text-xs text-gray-400 mt-1">program unggulan</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">UMKM</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['umkm_active'] }}</p>
            <p class="text-xs text-gray-400 mt-1">dari {{ $stats['umkm_total'] }} total</p>
        </div>
    </div>

    <!-- Village Profile Info -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Profil Desa</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <p class="text-xs text-gray-500 mb-1">Nama Desa</p>
                <p class="text-sm font-semibold text-gray-900">{{ $village->name }}</p>
            </div>
            @if($village->location)
            <div>
                <p class="text-xs text-gray-500 mb-1">Lokasi</p>
                <p class="text-sm font-semibold text-gray-900">{{ $village->location }}</p>
            </div>
            @endif
            @if($village->head)
            <div>
                <p class="text-xs text-gray-500 mb-1">Kepala Desa</p>
                <p class="text-sm font-semibold text-gray-900">{{ $village->head }}</p>
            </div>
            @endif
            @if($village->code)
            <div>
                <p class="text-xs text-gray-500 mb-1">Kode Desa</p>
                <p class="text-sm font-semibold text-gray-900">{{ $village->code }}</p>
            </div>
            @endif
            @if($village->population)
            <div>
                <p class="text-xs text-gray-500 mb-1">Jumlah Penduduk</p>
                <p class="text-sm font-semibold text-gray-900">{{ $village->population }}</p>
            </div>
            @endif
            @if($village->area)
            <div>
                <p class="text-xs text-gray-500 mb-1">Luas Wilayah</p>
                <p class="text-sm font-semibold text-gray-900">{{ $village->area }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Content Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- News Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Berita Terbaru</h3>
                <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-600 rounded-full">
                    {{ $stats['news_total'] }} Total
                </span>
            </div>
            <div class="space-y-3">
                @forelse($village->news->take(5) as $news)
                <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold 
                            {{ $news->status === \App\Models\VillageNews::STATUS_PUBLISHED ? 'text-green-600' : 'text-gray-500' }}
                            uppercase">
                            {{ $news->status === \App\Models\VillageNews::STATUS_PUBLISHED ? 'Published' : 'Draft' }}
                        </span>
                        <span class="text-xs text-gray-400">{{ $news->created_at->format('d M Y') }}</span>
                    </div>
                    <h4 class="text-sm font-semibold text-gray-900 line-clamp-1">{{ $news->title }}</h4>
                    @if($news->excerpt)
                    <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ $news->excerpt }}</p>
                    @endif
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada berita</p>
                @endforelse
            </div>
        </div>

        <!-- Gallery Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Galeri Desa</h3>
                <span class="px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-600 rounded-full">
                    {{ $stats['gallery_total'] }} Item
                </span>
            </div>
            <div class="space-y-3">
                @forelse($village->galleryCategories->take(3) as $category)
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-semibold text-gray-900">{{ $category->name }}</h4>
                        <span class="text-xs text-gray-500">{{ $category->items->count() }} item</span>
                    </div>
                    @if($category->items->count() > 0)
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($category->items->take(3) as $item)
                        <div class="aspect-square bg-gray-200 rounded overflow-hidden">
                            @if($item->media_path)
                            <img src="{{ Storage::url($item->media_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                            @elseif($item->thumbnail_path)
                            <img src="{{ Storage::url($item->thumbnail_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada galeri</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Potentials, Achievements, Programs -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Potentials -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Potensi Desa</h3>
                <span class="px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-600 rounded-full">
                    {{ $stats['potentials_total'] }}
                </span>
            </div>
            <div class="space-y-3">
                @forelse($village->potentials->take(5) as $potential)
                <div class="p-3 bg-gray-50 rounded-lg">
                    <h4 class="text-sm font-semibold text-gray-900 mb-1">{{ $potential->title }}</h4>
                    @if($potential->category)
                    <span class="text-xs text-emerald-600 bg-emerald-50 px-2 py-1 rounded">{{ $potential->category }}</span>
                    @endif
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada potensi</p>
                @endforelse
            </div>
        </div>

        <!-- Achievements -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Prestasi</h3>
                <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-600 rounded-full">
                    {{ $stats['achievements_total'] }}
                </span>
            </div>
            <div class="space-y-3">
                @forelse($village->achievements->take(5) as $achievement)
                <div class="p-3 bg-gray-50 rounded-lg">
                    <h4 class="text-sm font-semibold text-gray-900 mb-1">{{ $achievement->title }}</h4>
                    @if($achievement->year)
                    <span class="text-xs text-gray-500">{{ $achievement->year }}</span>
                    @endif
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada prestasi</p>
                @endforelse
            </div>
        </div>

        <!-- Programs -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Program</h3>
                <span class="px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-600 rounded-full">
                    {{ $stats['programs_total'] }}
                </span>
            </div>
            <div class="space-y-3">
                @forelse($village->programs->take(5) as $program)
                <div class="p-3 bg-gray-50 rounded-lg">
                    <h4 class="text-sm font-semibold text-gray-900 mb-1">{{ $program->title }}</h4>
                    @if($program->status)
                    <span class="text-xs 
                        {{ $program->status === 'active' ? 'text-green-600 bg-green-50' : 'text-gray-600 bg-gray-50' }}
                        px-2 py-1 rounded">
                        {{ ucfirst($program->status) }}
                    </span>
                    @endif
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada program</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- UMKM Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">UMKM di Desa Ini</h3>
            <span class="px-3 py-1 text-xs font-semibold bg-orange-100 text-orange-600 rounded-full">
                {{ $stats['umkm_active'] }} Aktif dari {{ $stats['umkm_total'] }} Total
            </span>
        </div>
        @if($umkmBusinesses->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($umkmBusinesses->take(6) as $umkm)
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 hover:border-emerald-200 transition">
                <div class="flex items-center gap-3 mb-3">
                    @if($umkm->logo_path)
                    <img src="{{ Storage::url($umkm->logo_path) }}" alt="{{ $umkm->name }}" class="w-12 h-12 rounded-lg object-cover">
                    @else
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-lg flex items-center justify-center text-white font-bold">
                        {{ substr($umkm->name, 0, 2) }}
                    </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $umkm->name }}</h4>
                        <p class="text-xs text-gray-500">{{ $umkm->category ?? 'UMKM' }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $umkm->user->name ?? 'N/A' }}
                    </span>
                    <span class="px-2 py-1 rounded text-xs font-semibold
                        {{ $umkm->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($umkm->status) }}
                    </span>
                </div>
                @if($umkm->products->count() > 0)
                <div class="mt-2 text-xs text-gray-500">
                    {{ $umkm->products->count() }} produk
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-gray-500 text-center py-4">Belum ada UMKM terdaftar</p>
        @endif
    </div>

    <!-- Users Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pengguna Desa</h3>
            <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-600 rounded-full">
                {{ $stats['users_total'] }} Pengguna
            </span>
        </div>
        @if($village->users->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($village->users->take(6) as $user)
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ substr($user->name, 0, 2) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $user->name }}</h4>
                        <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                        <span class="text-xs text-gray-400 mt-1">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-gray-500 text-center py-4">Belum ada pengguna terdaftar</p>
        @endif
    </div>
</div>
@endsection

