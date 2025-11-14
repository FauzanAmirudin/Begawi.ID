@extends('layouts.desa')

@section('title', 'Tentang Kami - Desa Sejahtera')

@push('styles')
<style>
    .scroll-reveal {
        opacity: 0;
        transform: translateY(50px);
        transition: all 0.8s ease-out;
    }
    
    .scroll-reveal.revealed {
        opacity: 1;
        transform: translateY(0);
    }
    
    .fade-in-left {
        opacity: 0;
        transform: translateX(-50px);
        transition: all 0.8s ease-out;
    }
    
    .fade-in-right {
        opacity: 0;
        transform: translateX(50px);
        transition: all 0.8s ease-out;
    }
    
    .fade-in-left.revealed,
    .fade-in-right.revealed {
        opacity: 1;
        transform: translateX(0);
    }
    
    .dropcap::first-letter {
        float: left;
        font-size: 4rem;
        line-height: 3rem;
        padding-right: 8px;
        padding-top: 4px;
        font-weight: bold;
        color: #166534;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Progress bar */
    .progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 4px;
        background: linear-gradient(90deg, #166534, #FACC15);
        z-index: 100;
        transition: width 0.3s ease;
    }
    
    /* Timeline styles */
    .timeline-item {
        position: relative;
        padding-left: 2rem;
        border-left: 2px solid #166534;
        margin-bottom: 2rem;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 0;
        width: 10px;
        height: 10px;
        background: #166534;
        border-radius: 50%;
    }
    
    /* Sticky sidebar */
    .sticky-sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
    }
    
    @media (max-width: 1024px) {
        .sticky-sidebar {
            position: static;
        }
    }
</style>
@endpush

@section('content')
<!-- Progress Bar -->
<div class="progress-bar" id="progressBar"></div>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-green-50 to-amber-50 py-16">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="text-center scroll-reveal">
            <h1 class="text-4xl lg:text-6xl font-display font-bold text-green-900 mb-4">
                Tentang Kami
            </h1>
            <p class="text-lg lg:text-xl text-slate-600 max-w-3xl mx-auto">
                Mengenal lebih dekat Desa Sejahtera, sejarah, visi misi, dan struktur pemerintahan 
                yang mengayomi masyarakat menuju kemajuan bersama.
            </p>
        </div>
    </div>
</section>

<div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 py-16">
    <div class="grid grid-cols-12 gap-8">
        <!-- Sticky Sidebar (Desktop Only) -->
        <aside class="hidden lg:block col-span-3">
            <div class="sticky-sidebar bg-white rounded-2xl shadow-md p-6">
                <h3 class="font-display font-semibold text-lg text-green-900 mb-4">Daftar Isi</h3>
                <nav class="space-y-2">
                    <a href="#identitas" class="block text-slate-600 hover:text-green-700 py-2 px-3 rounded-lg hover:bg-green-50 transition-colors">
                        Identitas Desa
                    </a>
                    <a href="#visi-misi" class="block text-slate-600 hover:text-green-700 py-2 px-3 rounded-lg hover:bg-green-50 transition-colors">
                        Visi & Misi
                    </a>
                    <a href="#struktur" class="block text-slate-600 hover:text-green-700 py-2 px-3 rounded-lg hover:bg-green-50 transition-colors">
                        Struktur Pemerintahan
                    </a>
                    <a href="#sejarah" class="block text-slate-600 hover:text-green-700 py-2 px-3 rounded-lg hover:bg-green-50 transition-colors">
                        Sejarah & Geografi
                    </a>
                    <a href="#sosial-media" class="block text-slate-600 hover:text-green-700 py-2 px-3 rounded-lg hover:bg-green-50 transition-colors">
                        Media Sosial
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="col-span-12 lg:col-span-9 space-y-20">
            <!-- 1. Identitas Desa -->
            <section id="identitas" class="scroll-reveal">
                <div class="bg-white rounded-2xl shadow-md p-8">
                    <h2 class="text-3xl font-display font-bold text-green-900 border-b-4 border-yellow-400 inline-block pb-2 mb-8">
                        Identitas Desa
                    </h2>
                    
                    <div class="grid grid-cols-12 gap-8 items-center">
                        <!-- Logo & Nama -->
                        <div class="col-span-12 md:col-span-5 text-center">
                            <img src="{{ $identitas_desa['logo'] }}" alt="Logo Desa" 
                                 class="w-32 h-32 rounded-full shadow-lg object-cover border-4 border-green-600 mx-auto mb-4">
                            <h3 class="text-3xl font-display font-bold text-green-900">{{ $identitas_desa['nama'] }}</h3>
                            <p class="text-slate-600 mt-2">{{ $identitas_desa['kecamatan'] }}</p>
                        </div>
                        
                        <!-- Informasi Detail -->
                        <div class="col-span-12 md:col-span-7">
                            <div class="space-y-4">
                                <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-50 transition-colors">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <div>
                                        <span class="text-sm text-slate-500">Kode Desa</span>
                                        <p class="font-medium text-slate-700">{{ $identitas_desa['kode_desa'] }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-50 transition-colors">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    </svg>
                                    <div>
                                        <span class="text-sm text-slate-500">Alamat Lengkap</span>
                                        <p class="font-medium text-slate-700">{{ $identitas_desa['alamat'] }}, {{ $identitas_desa['kecamatan'] }}, {{ $identitas_desa['kabupaten'] }}, {{ $identitas_desa['provinsi'] }} {{ $identitas_desa['kode_pos'] }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-50 transition-colors">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <div>
                                        <span class="text-sm text-slate-500">Luas Wilayah</span>
                                        <p class="font-medium text-slate-700">{{ $identitas_desa['luas_wilayah'] }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-50 transition-colors">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    <div>
                                        <span class="text-sm text-slate-500">Jumlah Penduduk</span>
                                        <p class="font-medium text-slate-700">{{ $identitas_desa['jumlah_penduduk'] }} (Kepadatan: {{ $identitas_desa['kepadatan'] }})</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 2. Visi & Misi -->
            <section id="visi-misi" class="bg-green-50 py-16 px-8 rounded-3xl">
                <h2 class="text-3xl font-display font-bold text-green-900 text-center mb-12">
                    Visi & Misi Desa
                </h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Visi -->
                    <div class="fade-in-left">
                        <div class="bg-white rounded-2xl p-8 shadow-md">
                            <h3 class="text-2xl font-display font-bold text-green-900 mb-4">VISI</h3>
                            <p class="text-4xl font-display font-extrabold text-green-900 leading-tight mb-4">
                                {{ $visi_misi['visi'] }}
                            </p>
                            <p class="italic text-slate-700">{{ $visi_misi['visi_subtitle'] }}</p>
                        </div>
                    </div>
                    
                    <!-- Misi -->
                    <div class="fade-in-right">
                        <div class="bg-white rounded-2xl p-8 shadow-md">
                            <h3 class="text-2xl font-display font-bold text-green-900 mb-6">MISI</h3>
                            <ul class="space-y-4">
                                @foreach($visi_misi['misi'] as $index => $misi)
                                <li class="flex items-start gap-3 text-slate-700">
                                    <span class="flex-shrink-0 w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="text-base leading-relaxed">{{ $misi }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-8">
                    <a href="#" class="bg-yellow-400 hover:bg-yellow-500 rounded-xl px-8 py-3 text-green-900 font-semibold transition-colors inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Lihat Rencana Pembangunan
                    </a>
                </div>
            </section>

            <!-- 3. Struktur Pemerintahan -->
            <section id="struktur" class="scroll-reveal">
                <h2 class="text-3xl font-display font-bold text-green-900 border-b-4 border-yellow-400 inline-block pb-2 mb-12">
                    Struktur Pemerintahan
                </h2>
                
                <!-- Kepala Desa -->
                <div class="text-center mb-16">
                    <div class="inline-block bg-white rounded-2xl p-8 shadow-md hover:shadow-lg transition-shadow">
                        <img src="{{ $struktur_pemerintahan['kepala_desa']['foto'] ?? 'https://via.placeholder.com/200x200?text=No+Photo' }}" 
                             alt="{{ $struktur_pemerintahan['kepala_desa']['nama'] ?? 'Kepala Desa' }}" 
                             class="w-32 h-32 rounded-full object-cover shadow-md mx-auto mb-4 hover:-translate-y-2 transition-transform">
                        <h3 class="font-display font-semibold text-xl text-green-900">
                            {{ $struktur_pemerintahan['kepala_desa']['nama'] ?? 'Nama Tidak Tersedia' }}
                        </h3>
                        <p class="text-green-700 font-medium">{{ $struktur_pemerintahan['kepala_desa']['jabatan'] ?? 'Kepala Desa' }}</p>
                        <p class="text-sm text-slate-600 mt-1">Periode: {{ $struktur_pemerintahan['kepala_desa']['periode'] ?? '-' }}</p>
                    </div>
                </div>
                
                <!-- Perangkat Desa -->
                <div class="mb-16">
                    <h3 class="text-2xl font-display font-semibold text-green-900 mb-8 text-center">Perangkat Desa</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-8">
                        @foreach($struktur_pemerintahan['perangkat_desa'] as $perangkat)
                        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition-all duration-300 text-center group">
                            <img src="{{ $perangkat['foto'] ?? 'https://via.placeholder.com/200x200?text=No+Photo' }}" 
                                 alt="{{ $perangkat['nama'] ?? 'Perangkat Desa' }}" 
                                 class="w-24 h-24 rounded-full object-cover shadow-md mx-auto mb-4 group-hover:-translate-y-2 transition-transform">
                            <h4 class="font-display font-semibold text-green-900 mb-1">{{ $perangkat['nama'] ?? 'Nama Tidak Tersedia' }}</h4>
                            <p class="text-sm text-slate-600">{{ $perangkat['jabatan'] ?? 'Jabatan Tidak Tersedia' }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Lembaga Desa -->
                <div>
                    <h3 class="text-2xl font-display font-semibold text-green-900 mb-8 text-center">Lembaga Desa</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($struktur_pemerintahan['lembaga'] as $lembaga)
                        <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow border-l-4 border-green-600">
                            <h4 class="font-display font-semibold text-lg text-green-900 mb-2">{{ $lembaga['nama'] ?? 'Nama Lembaga' }}</h4>
                            <p class="text-slate-700 mb-1">Ketua: <span class="font-medium">{{ $lembaga['ketua'] ?? '-' }}</span></p>
                            <p class="text-sm text-slate-600">{{ $lembaga['anggota'] ?? '-' }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- 4. Sejarah & Geografi -->
            <section id="sejarah" class="scroll-reveal">
                <h2 class="text-3xl font-display font-bold text-green-900 border-b-4 border-yellow-400 inline-block pb-2 mb-12">
                    Sejarah & Geografi
                </h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Sejarah -->
                    <div class="space-y-8">
                        <div class="bg-white rounded-2xl p-8 shadow-md">
                            <h3 class="text-2xl font-display font-bold text-green-900 mb-6">Sejarah Desa</h3>
                            
                            <p class="text-slate-700 leading-relaxed text-justify mb-6 dropcap">
                                {{ $sejarah_geografi['sejarah']['cerita_singkat'] }}
                            </p>
                            
                            <div class="bg-green-50 rounded-xl p-6">
                                <h4 class="font-semibold text-green-900 mb-4">Asal Nama Desa</h4>
                                <p class="text-slate-700 text-sm leading-relaxed">
                                    {{ $sejarah_geografi['sejarah']['asal_nama'] }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Timeline Sejarah -->
                        <div class="bg-white rounded-2xl p-8 shadow-md">
                            <h4 class="text-xl font-display font-semibold text-green-900 mb-6">Tonggak Sejarah</h4>
                            <div class="space-y-4">
                                @foreach($sejarah_geografi['sejarah']['tonggak_sejarah'] as $tahun => $peristiwa)
                                <div class="timeline-item">
                                    <div class="flex items-start gap-4">
                                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-bold min-w-fit">
                                            {{ $tahun }}
                                        </span>
                                        <p class="text-slate-700 text-sm">{{ $peristiwa }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Geografi -->
                    <div class="space-y-8">
                        <!-- Foto Wilayah -->
                        <div class="bg-white rounded-2xl overflow-hidden shadow-md">
                            <div class="aspect-video bg-slate-200 relative overflow-hidden">
                                <img src="{{ $sejarah_geografi['foto_wilayah'][0] }}" 
                                     alt="Pemandangan Desa" 
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 text-white">
                                    <h4 class="font-semibold">Pemandangan Desa Sejahtera</h4>
                                    <p class="text-sm opacity-90">Hamparan sawah dan perbukitan</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Data Geografi -->
                        <div class="bg-white rounded-2xl p-8 shadow-md">
                            <h3 class="text-2xl font-display font-bold text-green-900 mb-6">Kondisi Geografi</h3>
                            
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between items-center py-2 border-b border-slate-100">
                                    <span class="text-slate-600">Ketinggian</span>
                                    <span class="font-medium">{{ $sejarah_geografi['geografi']['ketinggian'] }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-slate-100">
                                    <span class="text-slate-600">Topografi</span>
                                    <span class="font-medium">{{ $sejarah_geografi['geografi']['topografi'] }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-slate-100">
                                    <span class="text-slate-600">Iklim</span>
                                    <span class="font-medium">{{ $sejarah_geografi['geografi']['iklim'] }}</span>
                                </div>
                            </div>
                            
                            <!-- Batas Wilayah -->
                            <div class="bg-slate-50 rounded-xl p-6 mb-6">
                                <h4 class="font-semibold text-green-900 mb-4">Batas Wilayah</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    @foreach($sejarah_geografi['geografi']['batas_wilayah'] as $arah => $wilayah)
                                    <div class="flex justify-between">
                                        <span class="text-slate-600 capitalize">{{ $arah }}:</span>
                                        <span class="font-medium">{{ $wilayah }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Potensi Alam -->
                            <div>
                                <h4 class="font-semibold text-green-900 mb-4">Potensi Alam</h4>
                                <ul class="space-y-2">
                                    @foreach($sejarah_geografi['geografi']['potensi_alam'] as $potensi)
                                    <li class="flex items-center gap-2 text-sm text-slate-700">
                                        <span class="text-green-600">🌿</span>
                                        {{ $potensi }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 5. Sosial Media -->
            <section id="sosial-media" class="scroll-reveal">
                <div class="bg-green-800 text-white rounded-2xl p-8 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <pattern id="leaves" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                <path d="M10 2C15 7 15 13 10 18C5 13 5 7 10 2Z" fill="currentColor"/>
                            </pattern>
                            <rect width="100" height="100" fill="url(#leaves)"/>
                        </svg>
                    </div>
                    
                    <div class="relative z-10 flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-6 sm:mb-0">
                            <h2 class="text-3xl font-display font-semibold mb-3">Terhubung dengan Kami</h2>
                            <p class="text-green-100 text-lg max-w-md">
                                Ikuti media sosial resmi desa untuk mendapatkan berita dan informasi kegiatan terkini.
                            </p>
                        </div>
                        
                        <div class="flex items-center gap-6">
                            <a href="{{ $sosial_media['facebook'] }}" 
                               class="w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center hover:scale-110 hover:text-yellow-400 transition-all duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            
                            <a href="{{ $sosial_media['instagram'] }}" 
                               class="w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center hover:scale-110 hover:text-yellow-400 transition-all duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987c6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.73-3.016-1.8L12.017 8.2l6.584 6.988c-.568 1.07-1.719 1.8-3.016 1.8H8.449z"/>
                                </svg>
                            </a>
                            
                            <a href="{{ $sosial_media['youtube'] }}" 
                               class="w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center hover:scale-110 hover:text-yellow-400 transition-all duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            
                            <a href="{{ $sosial_media['whatsapp'] }}" 
                               class="w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center hover:scale-110 hover:text-yellow-400 transition-all duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.893 3.085"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Scroll reveal animation
function revealOnScroll() {
    const reveals = document.querySelectorAll('.scroll-reveal, .fade-in-left, .fade-in-right');
    
    reveals.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < window.innerHeight - elementVisible) {
            element.classList.add('revealed');
        }
    });
}

// Progress bar
function updateProgressBar() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
    const progress = (scrollTop / scrollHeight) * 100;
    
    document.getElementById('progressBar').style.width = progress + '%';
}

// Smooth scroll for sidebar links
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    revealOnScroll();
    updateProgressBar();
    initSmoothScroll();
});

window.addEventListener('scroll', function() {
    revealOnScroll();
    updateProgressBar();
});

// Mobile menu toggle (if needed)
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');

if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
    });
}
</script>
@endpush