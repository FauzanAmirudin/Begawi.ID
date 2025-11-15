@extends('layouts.admin')

@section('title', 'Profil Usaha')

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
    
    $operatingHours = $umkmBusiness->operating_hours ?? [];
    $socialMedia = $umkmBusiness->social_media ?? [];
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
@endphp

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-data="{ profileModal: false }" x-cloak>
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

    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.dashboard.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">Profil Usaha</p>
            </div>
            <h1 class="text-3xl font-semibold text-gray-900">Identitas & Informasi Usaha</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data identitas UMKM, informasi umum, dan identitas visual usaha Anda.</p>
        </div>
        <button type="button" @click="profileModal = true" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-purple-600 rounded-xl hover:bg-purple-500 transition">
            Update Profil
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Identitas Usaha -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-gray-100 overflow-hidden flex items-center justify-center">
                            @if($umkmBusiness->logo_path)
                                <img src="{{ Str::startsWith($umkmBusiness->logo_path, ['http', 'https']) ? $umkmBusiness->logo_path : Storage::url($umkmBusiness->logo_path) }}" alt="Logo" class="w-16 h-16 object-cover">
                            @else
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide">UMKM</p>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $umkmBusiness->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $umkmBusiness->category }}</p>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500">
                        <p class="font-medium text-gray-900">{{ $umkmBusiness->owner_name }}</p>
                        <p>Pemilik</p>
                    </div>
                </div>

                <!-- Informasi Umum -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
                    <div class="bg-purple-50 border border-purple-100 rounded-2xl p-4">
                        <p class="text-xs font-semibold text-purple-600 uppercase tracking-wide">Alamat Lengkap</p>
                        <p class="text-sm text-gray-700 mt-2 leading-relaxed">{{ $umkmBusiness->address ?? 'Belum diisi' }}</p>
                    </div>
                    <div class="space-y-3">
                        <div class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">WhatsApp</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $umkmBusiness->whatsapp_number ?? 'Belum diisi' }}</p>
                        </div>
                        <div class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Telepon</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $umkmBusiness->owner_phone ?? 'Belum diisi' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Peta Lokasi -->
                @if($umkmBusiness->maps_embed_url)
                <div class="mt-6">
                    <p class="text-xs font-semibold text-gray-900 uppercase tracking-wide mb-3">Peta Lokasi</p>
                    <div class="rounded-2xl overflow-hidden border border-gray-100">
                        {!! $umkmBusiness->maps_embed_url !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Tentang Usaha -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Tentang Usaha</h4>
                <div class="space-y-4">
                    @if($umkmBusiness->description)
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Deskripsi Singkat</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $umkmBusiness->description }}</p>
                    </div>
                    @endif
                    @if($umkmBusiness->about_business)
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Tentang Usaha</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $umkmBusiness->about_business }}</p>
                    </div>
                    @endif
                    @if(!$umkmBusiness->description && !$umkmBusiness->about_business)
                    <p class="text-sm text-gray-400 italic">Belum ada informasi tentang usaha.</p>
                    @endif
                </div>
            </div>

            <!-- Banner -->
            @if($umkmBusiness->banner_path)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Banner Utama</h4>
                <div class="rounded-2xl overflow-hidden">
                    <img src="{{ Str::startsWith($umkmBusiness->banner_path, ['http', 'https']) ? $umkmBusiness->banner_path : Storage::url($umkmBusiness->banner_path) }}" alt="Banner" class="w-full h-64 object-cover">
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Jam Operasional -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Jam Operasional</h4>
                <div class="space-y-2">
                    @if(!empty($operatingHours))
                        @foreach($operatingHours as $hour)
                        <div class="flex items-center justify-between text-sm py-2 border-b border-gray-100 last:border-0">
                            <span class="text-gray-700 font-medium">{{ $hour['day'] ?? '' }}</span>
                            @if(isset($hour['is_closed']) && $hour['is_closed'])
                                <span class="text-red-500 text-xs">Tutup</span>
                            @else
                                <span class="text-gray-600">{{ ($hour['open_time'] ?? '') . ' - ' . ($hour['close_time'] ?? '') }}</span>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-400 italic">Belum diatur</p>
                    @endif
                </div>
            </div>

            <!-- Sosial Media -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Sosial Media</h4>
                <div class="space-y-3">
                    @if(!empty($socialMedia))
                        @if(isset($socialMedia['instagram']))
                        <a href="{{ $socialMedia['instagram'] }}" target="_blank" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50/60 transition">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 text-white flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Instagram</p>
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ Str::limit($socialMedia['instagram'], 30) }}</p>
                            </div>
                        </a>
                        @endif
                        @if(isset($socialMedia['facebook']))
                        <a href="{{ $socialMedia['facebook'] }}" target="_blank" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/60 transition">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Facebook</p>
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ Str::limit($socialMedia['facebook'], 30) }}</p>
                            </div>
                        </a>
                        @endif
                        @if(isset($socialMedia['tiktok']))
                        <a href="{{ $socialMedia['tiktok'] }}" target="_blank" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-gray-800 hover:bg-gray-50 transition">
                            <div class="w-10 h-10 rounded-xl bg-gray-900 text-white flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">TikTok</p>
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ Str::limit($socialMedia['tiktok'], 30) }}</p>
                            </div>
                        </a>
                        @endif
                        @if(isset($socialMedia['youtube']))
                        <a href="{{ $socialMedia['youtube'] }}" target="_blank" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-red-200 hover:bg-red-50/60 transition">
                            <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">YouTube</p>
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ Str::limit($socialMedia['youtube'], 30) }}</p>
                            </div>
                        </a>
                        @endif
                    @else
                        <p class="text-sm text-gray-400 italic">Belum ada sosial media yang ditambahkan</p>
                    @endif
                </div>
            </div>

            <!-- Branding Color -->
            @if($umkmBusiness->branding_color)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Warna Branding</h4>
                <div class="flex items-center gap-3">
                    <div class="w-16 h-16 rounded-xl" style="background-color: {{ $umkmBusiness->branding_color }}"></div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ $umkmBusiness->branding_color }}</p>
                        <p class="text-xs text-gray-500">Kode warna</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Profile Modal -->
    <div
        x-show="profileModal"
        x-transition.opacity
        x-trap="profileModal"
        @keydown.escape.window="profileModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="profileModal = false"></div>
        <div class="relative w-full max-w-4xl lg:max-w-5xl bg-white rounded-[32px] shadow-2xl max-h-[90vh] overflow-hidden">
            <div class="sticky top-0 flex items-start justify-between gap-6 px-6 sm:px-10 py-6 bg-white/95 backdrop-blur border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-purple-500">Perbarui Profil</p>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mt-2">Profil Usaha UMKM</h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola informasi identitas dan profil usaha Anda.</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600" @click="profileModal = false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto max-h-[calc(90vh-160px)]">
                <form action="{{ route('admin.umkm.profile.update') }}" method="POST" enctype="multipart/form-data" class="px-6 sm:px-10 py-6 space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Informasi Umum -->
                    <section class="space-y-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-purple-500">Informasi Umum</p>
                            <h4 class="text-lg font-semibold text-gray-900 mt-1">Data Dasar Usaha</h4>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Usaha *</label>
                                <input type="text" name="name" value="{{ old('name', $umkmBusiness->name) }}" required class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500"/>
                                @error('name')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $umkmBusiness->whatsapp_number) }}" placeholder="081234567890" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500"/>
                                @error('whatsapp_number')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                            <textarea name="address" rows="3" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500">{{ old('address', $umkmBusiness->address) }}</textarea>
                            @error('address')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Peta Lokasi (Google Maps Embed)</label>
                            <textarea name="maps_embed_url" rows="4" placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>' class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 font-mono text-xs">{{ old('maps_embed_url', $umkmBusiness->maps_embed_url) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Salin kode embed dari Google Maps</p>
                            @error('maps_embed_url')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>

                    <!-- Tentang Usaha -->
                    <section class="space-y-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-purple-500">Tentang Usaha</p>
                            <h4 class="text-lg font-semibold text-gray-900 mt-1">Deskripsi & Informasi</h4>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                            <textarea name="description" rows="3" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500">{{ old('description', $umkmBusiness->description) }}</textarea>
                            @error('description')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tentang Usaha (Detail)</label>
                            <textarea name="about_business" rows="5" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500">{{ old('about_business', $umkmBusiness->about_business) }}</textarea>
                            @error('about_business')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>

                    <!-- Identitas Visual -->
                    <section class="space-y-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-purple-500">Identitas Visual</p>
                            <h4 class="text-lg font-semibold text-gray-900 mt-1">Logo, Banner & Branding</h4>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Logo</label>
                                <div class="mt-2 flex items-center gap-4">
                                    @if($umkmBusiness->logo_path)
                                    <img src="{{ Str::startsWith($umkmBusiness->logo_path, ['http', 'https']) ? $umkmBusiness->logo_path : Storage::url($umkmBusiness->logo_path) }}" alt="Logo" class="w-16 h-16 rounded-2xl object-cover border border-gray-100">
                                    @endif
                                    <input type="file" name="logo" accept="image/*" class="w-full text-sm">
                                </div>
                                @error('logo')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Banner Utama</label>
                                <div class="mt-2 flex items-center gap-4">
                                    @if($umkmBusiness->banner_path)
                                    <img src="{{ Str::startsWith($umkmBusiness->banner_path, ['http', 'https']) ? $umkmBusiness->banner_path : Storage::url($umkmBusiness->banner_path) }}" alt="Banner" class="w-16 h-16 rounded-2xl object-cover border border-gray-100">
                                    @endif
                                    <input type="file" name="banner" accept="image/*" class="w-full text-sm">
                                </div>
                                @error('banner')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Warna Branding (Opsional)</label>
                            <div class="mt-2 flex items-center gap-3">
                                <input type="color" id="branding_color_picker" value="{{ old('branding_color_text', $umkmBusiness->branding_color ?? '#6366f1') }}" class="w-16 h-10 rounded-lg border border-gray-200">
                                <input type="text" name="branding_color_text" id="branding_color_text" value="{{ old('branding_color_text', $umkmBusiness->branding_color ?? '#6366f1') }}" placeholder="#6366f1" pattern="^#[0-9A-Fa-f]{6}$" class="flex-1 rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Pilih warna utama untuk branding usaha</p>
                            @error('branding_color')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>

                    <!-- Jam Operasional -->
                    <section class="space-y-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-purple-500">Jam Operasional</p>
                            <h4 class="text-lg font-semibold text-gray-900 mt-1">Hari & Jam Buka</h4>
                        </div>
                        <div class="space-y-3">
                            @foreach($days as $day)
                            @php
                                $hour = collect($operatingHours)->firstWhere('day', $day);
                            @endphp
                            <div class="grid grid-cols-12 gap-3 items-center">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">{{ $day }}</label>
                                </div>
                                <div class="col-span-9 grid grid-cols-12 gap-2">
                                    <div class="col-span-4">
                                        <input type="time" name="operating_hours[{{ $loop->index }}][open_time]" value="{{ old("operating_hours.{$loop->index}.open_time", $hour['open_time'] ?? '') }}" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 text-sm">
                                    </div>
                                    <div class="col-span-1 text-center text-gray-400">-</div>
                                    <div class="col-span-4">
                                        <input type="time" name="operating_hours[{{ $loop->index }}][close_time]" value="{{ old("operating_hours.{$loop->index}.close_time", $hour['close_time'] ?? '') }}" class="w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500 text-sm">
                                    </div>
                                    <div class="col-span-3">
                                        <label class="flex items-center gap-2 text-sm">
                                            <input type="checkbox" name="operating_hours[{{ $loop->index }}][is_closed]" value="1" {{ old("operating_hours.{$loop->index}.is_closed", isset($hour['is_closed']) && $hour['is_closed'] ? 'checked' : '') }} class="rounded border-gray-200 text-purple-600 focus:ring-purple-500">
                                            <span class="text-gray-600">Tutup</span>
                                        </label>
                                    </div>
                                    <input type="hidden" name="operating_hours[{{ $loop->index }}][day]" value="{{ $day }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- Sosial Media -->
                    <section class="space-y-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-purple-500">Sosial Media</p>
                            <h4 class="text-lg font-semibold text-gray-900 mt-1">Link Media Sosial</h4>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Instagram</label>
                                <input type="url" name="social_instagram" value="{{ old('social_instagram', $socialMedia['instagram'] ?? '') }}" placeholder="https://instagram.com/username" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500"/>
                                @error('social_instagram')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Facebook</label>
                                <input type="url" name="social_facebook" value="{{ old('social_facebook', $socialMedia['facebook'] ?? '') }}" placeholder="https://facebook.com/username" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500"/>
                                @error('social_facebook')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">TikTok</label>
                                <input type="url" name="social_tiktok" value="{{ old('social_tiktok', $socialMedia['tiktok'] ?? '') }}" placeholder="https://tiktok.com/@username" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500"/>
                                @error('social_tiktok')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">YouTube</label>
                                <input type="url" name="social_youtube" value="{{ old('social_youtube', $socialMedia['youtube'] ?? '') }}" placeholder="https://youtube.com/@username" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500"/>
                                @error('social_youtube')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <div class="flex flex-wrap items-center justify-end gap-3 sticky bottom-0 pt-4 border-t border-gray-100 bg-white">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" @click="profileModal = false">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 text-white text-sm font-semibold hover:bg-purple-500 transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Sync color picker with text input
document.addEventListener('DOMContentLoaded', function() {
    const colorPicker = document.getElementById('branding_color_picker');
    const colorText = document.getElementById('branding_color_text');
    
    if (colorPicker && colorText) {
        colorPicker.addEventListener('input', function(e) {
            colorText.value = e.target.value;
        });
        
        colorText.addEventListener('input', function(e) {
            if (/^#[0-9A-Fa-f]{6}$/.test(e.target.value)) {
                colorPicker.value = e.target.value;
            }
        });
    }
});
</script>
@endsection

