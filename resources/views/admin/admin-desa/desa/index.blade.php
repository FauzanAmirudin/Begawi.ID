@extends('layouts.admin')

@section('title', 'Manajemen Website Desa')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Manajemen Website Desa</h1>
                <p class="text-gray-600">Kelola identitas desa, berita, galeri, potensi wisata, prestasi dan program unggulan</p>
                @if($village)
                <div class="mt-3 flex items-center gap-2 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium text-gray-700">{{ $village->name }}</span>
                    <a href="{{ route('desa.home') }}" target="_blank" class="text-emerald-600 hover:text-emerald-500">
                        Lihat Website Desa →
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Berita Terbit</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['news_published'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Draft Konten</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['news_draft'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Item Galeri</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['gallery_total'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Potensi Desa</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['potentials_total'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Prestasi</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['achievements_total'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Program Aktif</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $stats['programs_total'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Profil Desa -->
        <a href="{{ route('admin.desa-management.profile') }}" class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Profil Desa</p>
                    <p class="text-2xl font-bold mt-1">Identitas & Struktur</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 5c-4.418 0-8 2.239-8 5v1a1 1 0 001 1h14a1 1 0 001-1v-1c0-2.761-3.582-5-8-5z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Kelola data identitas desa, visi misi, serta struktur organisasi pemerintahan desa</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Kelola Profil</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>

        <!-- Berita & Agenda -->
        <a href="{{ route('admin.desa-management.news') }}" class="bg-gradient-to-br from-indigo-500 via-indigo-600 to-purple-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Berita & Agenda</p>
                    <p class="text-2xl font-bold mt-1">Konten Publikasi</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 5H9a2 2 0 00-2 2v12m12-14h2a1 1 0 011 1v12a1 1 0 01-1 1h-2m0-14v14M7 9h6m-6 4h6m-6 4h6"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Publikasikan berita penting, atur jadwal agenda, dan kontrol status publish / draft</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Kelola Berita</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>

        <!-- Galeri Desa -->
        <a href="{{ route('admin.desa-management.gallery') }}" class="bg-gradient-to-br from-rose-500 via-rose-600 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Galeri Desa</p>
                    <p class="text-2xl font-bold mt-1">Foto & Video</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a2 2 0 012-2h12a2 2 0 012 2v6l-4-3-4 5-3-2-5 4V5z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Kelompokkan dokumentasi galeri berdasarkan kategori acara, pembangunan, dan sosial</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Kelola Galeri</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>

        <!-- Potensi & Wisata -->
        <a href="{{ route('admin.desa-management.potentials') }}" class="bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Potensi & Wisata</p>
                    <p class="text-2xl font-bold mt-1">Wisata & Ekonomi</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l2.09 6.26L20 9.27l-5 3.64 1.91 6.09L12 15.77l-4.91 3.23L9 12.91 4 9.27l5.91-.99L12 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Tambahkan deskripsi, status, dan embed lokasi peta untuk setiap potensi unggulan desa</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Kelola Potensi</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>

        <!-- Prestasi & Program -->
        <a href="{{ route('admin.desa-management.achievements') }}" class="bg-gradient-to-br from-purple-500 via-purple-600 to-indigo-500 rounded-2xl p-6 text-white relative overflow-hidden hover:opacity-95 transition group">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-white/80 text-sm font-medium">Prestasi & Program</p>
                    <p class="text-2xl font-bold mt-1">Penghargaan & Program</p>
                </div>
                <div class="bg-white/15 rounded-xl p-3 group-hover:bg-white/20 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-white/70 text-sm mb-4">Dokumentasikan raihan prestasi desa serta program strategis yang sedang berjalan</p>
            <div class="flex items-center gap-2 text-sm text-white/80 group-hover:text-white transition">
                <span>Kelola Prestasi</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
        </a>
    </div>
</div>
@endsection

