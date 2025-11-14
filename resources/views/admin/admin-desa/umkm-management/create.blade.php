@extends('layouts.admin')

@section('title', 'Tambah UMKM Baru')

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-data="umkmPanel()" x-cloak>
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
            <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 font-semibold">Registrasi UMKM</p>
            <h1 class="text-3xl font-semibold text-gray-900 mt-2">Tambah UMKM Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi data usaha untuk otomatis membuat subdomain dan akses panel admin UMKM.</p>
        </div>
        <div class="text-xs text-gray-400">
            Subdomain default: <span class="font-semibold text-gray-600" x-text="subdomainPreview"></span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <form action="{{ route('admin.desa-management.umkm-management.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
                @csrf
                
                <!-- Section 1: Informasi Dasar -->
                <div class="p-6 space-y-6">
                    <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Informasi Dasar UMKM</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Data identitas dan kontak utama</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Nama UMKM <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200" 
                                placeholder="Contoh: UD Berkah Jaya" x-model="newUmkm.name" />
                            @error('name')
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 5c-4.418 0-8 2.239-8 5v1a1 1 0 001 1h14a1 1 0 001-1v-1c0-2.761-3.582-5-8-5z"></path>
                                </svg>
                                Pemilik / PIC <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="owner_name" value="{{ old('owner_name') }}" required 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200" 
                                placeholder="Nama lengkap pemilik" />
                            @error('owner_name')
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
                                Kategori UMKM <span class="text-red-500">*</span>
                            </label>
                            <select name="category" required 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200">
                                <option value="">Pilih kategori</option>
                                @foreach($categoryFilters as $category)
                                <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
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
                        
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.494a1 1 0 01-.502 1.21l-1.518.76a11.042 11.042 0 006.105 6.105l.76-1.518a1 1 0 011.21-.502l4.494 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                WhatsApp Aktif <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="owner_phone" value="{{ old('owner_phone') }}" required 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200" 
                                placeholder="08xxxxxxxxxx" />
                            @error('owner_phone')
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Email Login <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="owner_email" value="{{ old('owner_email') }}" required 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200" 
                                placeholder="admin@umkm.com" />
                            @error('owner_email')
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                                Subdomain
                            </label>
                            <div class="px-4 py-3 rounded-xl border-2 border-dashed border-emerald-300 bg-gradient-to-br from-emerald-50 to-teal-50 text-sm font-semibold text-emerald-700 flex items-center gap-2" x-text="subdomainPreview">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Subdomain akan dibuat otomatis berdasarkan nama UMKM</p>
                        </div>
                    </div>
                </div>
                
                <!-- Section 2: Deskripsi -->
                <div class="p-6 space-y-4 bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Deskripsi Usaha</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Ceritakan profil singkat UMKM Anda</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <textarea name="description" rows="4" 
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200 resize-none" 
                            placeholder="Ceritakan profil singkat UMKM, produk unggulan, atau prestasi yang telah dicapai...">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="flex items-center gap-2 text-xs text-red-600 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Section 3: Upload Dokumen -->
                <div class="p-6 space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Dokumen & Media</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Upload logo dan dokumen legalitas</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-700">Logo / Foto UMKM</label>
                            <div class="relative">
                                <input type="file" name="logo" id="logoInput" accept="image/*" 
                                    class="hidden" 
                                    onchange="document.getElementById('logoPreview').textContent = this.files[0]?.name || 'Pilih file...'">
                                <label for="logoInput" 
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:border-emerald-400 hover:bg-emerald-50/30 cursor-pointer transition-all duration-200 group">
                                    <svg class="w-8 h-8 text-gray-400 group-hover:text-emerald-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-600 group-hover:text-emerald-600" id="logoPreview">Klik untuk upload logo</p>
                                    <p class="text-xs text-gray-400 mt-1">JPG, PNG · Max 2MB</p>
                                </label>
                            </div>
                            @error('logo')
                            <div class="flex items-center gap-2 text-xs text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-700">
                                Dokumen Legalitas <span class="text-gray-400 font-normal">(opsional)</span>
                            </label>
                            <div class="relative">
                                <input type="file" name="legal_document" id="legalInput" accept=".pdf,.jpg,.png" 
                                    class="hidden" 
                                    onchange="document.getElementById('legalPreview').textContent = this.files[0]?.name || 'Pilih file...'">
                                <label for="legalInput" 
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:border-emerald-400 hover:bg-emerald-50/30 cursor-pointer transition-all duration-200 group">
                                    <svg class="w-8 h-8 text-gray-400 group-hover:text-emerald-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-600 group-hover:text-emerald-600" id="legalPreview">Klik untuk upload dokumen</p>
                                    <p class="text-xs text-gray-400 mt-1">PDF, JPG, PNG · Max 5MB</p>
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">SIUP / NIB / Sertifikat Halal</p>
                            @error('legal_document')
                            <div class="flex items-center gap-2 text-xs text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Section 4: Action Footer -->
                <div class="p-6 bg-gradient-to-r from-gray-50 to-emerald-50/30 border-t-2 border-emerald-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="send_credentials" id="sendCredentials" value="1" 
                                class="mt-1 w-5 h-5 rounded border-2 border-gray-300 text-emerald-600 focus:ring-2 focus:ring-emerald-500/20 transition-all" 
                                {{ old('send_credentials', true) ? 'checked' : '' }}>
                            <div class="flex-1">
                                <span class="block text-sm font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">
                                    Kirim Kredensial Otomatis
                                </span>
                                <span class="block text-xs text-gray-500 mt-1">
                                    Kredensial panel admin UMKM akan dikirim via email & WhatsApp setelah pendaftaran
                                </span>
                            </div>
                        </label>
                        <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:shadow-emerald-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan & Buat Subdomain
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Alur Onboarding</h4>
                <ol class="mt-4 space-y-3 text-sm text-gray-600">
                    <li class="flex gap-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-semibold">1</span>
                        <div>
                            <p class="font-semibold text-gray-900">Validasi Dokumen</p>
                            <p class="text-xs text-gray-500 mt-1">Pastikan data pemilik dan dokumen usaha lengkap untuk aktivasi.</p>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-semibold">2</span>
                        <div>
                            <p class="font-semibold text-gray-900">Konfigurasi Subdomain</p>
                            <p class="text-xs text-gray-500 mt-1">Subdomain otomatis dibuat di platform Begawi.ID tanpa konfigurasi manual.</p>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-semibold">3</span>
                        <div>
                            <p class="font-semibold text-gray-900">Training Admin UMKM</p>
                            <p class="text-xs text-gray-500 mt-1">Sediakan jadwal bimbingan onboarding agar admin UMKM siap mempublikasi konten.</p>
                        </div>
                    </li>
                </ol>
            </div>
            <div class="bg-gradient-to-br from-sky-500 via-blue-500 to-indigo-500 rounded-2xl p-6 text-white">
                <h4 class="text-base font-semibold">Gunakan Template UMKM</h4>
                <p class="text-sm text-white/80 mt-2">Aktifkan template e-commerce siap pakai untuk UMKM baru agar cepat go-digital.</p>
                <a href="{{ route('admin.desa-management.umkm-management.guides') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/80 transition">
                    Lihat panduan implementasi
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function umkmPanel() {
    return {
        domainSuffix: @json($domainSuffix),
        newUmkm: {
            name: '',
        },
        get subdomainPreview() {
            const slugified = this.newUmkm.name
                ? this.newUmkm.name.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')
                : 'umkm-baru';
            return `${slugified || 'umkm-baru'}.${this.domainSuffix}`;
        }
    };
}
</script>
@endpush

