@extends('layouts.admin')

@section('title', 'Bimbingan Digital UMKM')

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-data="{}" x-cloak>
    @if (session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
        <button class="text-xs text-emerald-600 hover:text-emerald-500" @click="$el.parentElement.remove()">Tutup</button>
    </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-blue-500 font-semibold">Bimbingan Digital</p>
            <h1 class="text-3xl font-semibold text-gray-900 mt-2">Materi Pendampingan UMKM</h1>
            <p class="text-sm text-gray-500 mt-1">Upload artikel, tips promosi, dan jadwal pelatihan untuk UMKM binaan.</p>
        </div>
        <a href="#" class="px-4 py-2 text-xs font-semibold text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition">
            Kirim Materi via Email
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900">Perpustakaan Materi</h3>
                    <button class="text-xs font-semibold text-gray-500 hover:text-blue-500">Kelola Folder</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($digitalGuides as $guide)
                    <div class="p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition">
                        <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-semibold bg-blue-50 text-blue-600 rounded-full">
                            {{ $guide['category'] }}
                        </span>
                        <h4 class="text-sm font-semibold text-gray-900 mt-3 leading-snug">{{ $guide['title'] }}</h4>
                        <p class="text-xs text-gray-500 mt-2">{{ $guide['duration'] }}</p>
                        <p class="text-[11px] text-gray-400 mt-1">Update {{ $guide['updated_at'] }}</p>
                        <a href="{{ $guide['link'] }}" class="mt-3 inline-flex items-center gap-2 text-xs font-semibold text-blue-600 hover:text-blue-500 transition">
                            Buka Materi
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Upload Materi Bimbingan</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Materi akan tersedia di panel UMKM dan dapat dikirim via email otomatis</p>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('admin.desa-management.umkm-management.guides.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Judul Materi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}" required 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" 
                                placeholder="Contoh: Optimasi Foto Produk">
                            @error('title')
                            <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="category" required 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all duration-200">
                                <option value="">Pilih kategori</option>
                                <option value="tips" {{ old('category') === 'tips' ? 'selected' : '' }}>Tips Promosi</option>
                                <option value="pelatihan" {{ old('category') === 'pelatihan' ? 'selected' : '' }}>Pelatihan Online</option>
                                <option value="artikel" {{ old('category') === 'artikel' ? 'selected' : '' }}>Artikel Edukasi</option>
                            </select>
                            @error('category')
                            <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Deskripsi Singkat
                        </label>
                        <textarea name="description" rows="3" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 resize-none" 
                            placeholder="Tuliskan ringkasan materi dan tujuan bimbingan...">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-700">Upload File</label>
                            <div class="relative">
                                <input type="file" name="file" id="guideFileInput" accept=".pdf,.ppt,.pptx,.zip,.mp4" 
                                    class="hidden" 
                                    onchange="document.getElementById('guideFilePreview').textContent = this.files[0]?.name || 'Pilih file...'">
                                <label for="guideFileInput" 
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:border-blue-400 hover:bg-blue-50/30 cursor-pointer transition-all duration-200 group">
                                    <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-600 group-hover:text-blue-600" id="guideFilePreview">Klik untuk upload file</p>
                                    <p class="text-xs text-gray-400 mt-1">PDF, PPT, ZIP, MP4 · Max 20MB</p>
                                </label>
                            </div>
                            @error('file')
                            <div class="flex items-center gap-2 text-xs text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                Link Pelatihan <span class="text-gray-400 font-normal">(opsional)</span>
                            </label>
                            <input type="url" name="external_link" value="{{ old('external_link') }}" 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" 
                                placeholder="https://zoom.us/...">
                            @error('external_link')
                            <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-100">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="notify_all_umkm" value="1" 
                                class="mt-1 w-5 h-5 rounded border-2 border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all" 
                                {{ old('notify_all_umkm', true) ? 'checked' : '' }}>
                            <div class="flex-1">
                                <span class="block text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    Kirim Notifikasi ke Semua UMKM
                                </span>
                                <span class="block text-xs text-gray-500 mt-1">
                                    Semua admin UMKM akan menerima notifikasi tentang materi baru ini
                                </span>
                            </div>
                        </label>
                        <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-500 text-white text-sm font-semibold shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Terbitkan Materi
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Pelatihan Terdekat</h4>
                <div class="mt-4 space-y-4">
                    @foreach($upcomingTrainings as $training)
                    <div class="p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition">
                        <p class="text-xs font-semibold text-blue-500 uppercase tracking-wide">{{ $training['status'] }}</p>
                        <h5 class="text-sm font-semibold text-gray-900 mt-1">{{ $training['title'] }}</h5>
                        <p class="text-xs text-gray-500 mt-2">{{ $training['date'] }} · {{ $training['time'] }}</p>
                        <p class="text-xs text-gray-400">{{ $training['medium'] }}</p>
                        <button class="mt-3 text-xs font-semibold text-blue-600 hover:text-blue-500">Bagikan ke UMKM</button>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-500 rounded-2xl p-6 text-white">
                <h4 class="text-base font-semibold">Buat Rencana Pendampingan</h4>
                <p class="text-sm text-white/80 mt-2">Gunakan template monitoring untuk mencatat progres tiap UMKM secara berkala.</p>
                <a href="{{ route('admin.support.documentation') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/80 transition">
                    Lihat Template Monitoring
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

