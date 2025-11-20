@extends('layouts.admin')

@section('title', 'Profil Desa')

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

@push('styles')
<style>
[x-cloak] { 
    display: none !important; 
}
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-data="structureManagement()">
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

    @if (session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span class="text-sm font-semibold">{{ session('error') }}</span>
        </div>
        <button class="text-xs text-red-600 hover:text-red-500" @click="$el.parentElement.remove()">Tutup</button>
    </div>
    @endif

    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.desa-management.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-500 font-semibold">Profil Desa</p>
            </div>
            <h1 class="text-3xl font-semibold text-gray-900">Identitas & Struktur Pemerintahan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data identitas desa, visi misi, serta struktur organisasi pemerintahan desa.</p>
        </div>
        <button type="button" @click="profileModal = true" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-emerald-600 rounded-xl hover:bg-emerald-500 transition">
            Update Profil
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 overflow-hidden flex items-center justify-center">
                        @if(!empty($profile['logo']))
                        <img src="{{ Str::startsWith($profile['logo'], ['http', 'https']) ? $profile['logo'] : Storage::url($profile['logo']) }}?v={{ $village->updated_at->timestamp ?? time() }}" alt="Logo Desa" class="w-16 h-16 object-cover">
                        @else
                        <div class="w-16 h-16 flex items-center justify-center text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide">Desa</p>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $profile['name'] }}</h3>
                        <p class="text-sm text-gray-500">{{ $profile['tagline'] }}</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    <p class="font-medium text-gray-900">{{ $profile['head'] }}</p>
                    <p>Kepala Desa</p>
                    <p>{{ $profile['code'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
                <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4">
                    <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wide">Alamat Kantor</p>
                    <p class="text-sm text-gray-700 mt-2 leading-relaxed">{{ $profile['location'] }}</p>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Jumlah Penduduk</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $profile['population'] }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Luas Wilayah</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $profile['area'] }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Kepadatan</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $profile['density'] }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Visi Desa</h4>
                    <p class="text-xs text-gray-400 mt-1">{{ $visionMission['vision_period'] }}</p>
                    <p class="text-sm text-gray-600 mt-3 leading-relaxed">{{ $visionMission['vision'] }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Misi Desa</h4>
                    <ul class="mt-3 space-y-2 text-sm text-gray-600">
                        @foreach($visionMission['missions'] as $mission)
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>{{ $mission }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Kontak Resmi</h4>
                <div class="mt-4 space-y-3">
                    @foreach($contacts as $contact)
                    <div class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/60 transition">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            @include('admin.dashboard.partials.icon', ['type' => $contact['icon']])
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">{{ $contact['label'] }}</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $contact['value'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Struktur Inti</h4>
                    <button type="button" @click="openStructureModal()" class="inline-flex items-center justify-center w-9 h-9 text-white bg-emerald-600 rounded-lg hover:bg-emerald-500 transition" title="Tambah Perangkat Desa">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>
                <div class="mt-4 space-y-4">
                    @forelse($structures as $index => $person)
                    <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/30 transition">
                        <div class="w-12 h-12 rounded-2xl bg-gray-100 overflow-hidden shrink-0">
                            <img src="{{ $person['photo'] ?? 'https://via.placeholder.com/200x200?text=No+Photo' }}" alt="{{ $person['name'] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">{{ $person['name'] ?? 'Nama Tidak Tersedia' }}</p>
                            <p class="text-xs text-gray-500">{{ $person['role'] ?? 'Jabatan Tidak Tersedia' }}</p>
                            <p class="text-xs text-gray-400">{{ $person['since'] ?? '' }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="openStructureModal({{ $index }})" class="p-2 text-emerald-600 hover:text-emerald-500 rounded-lg hover:bg-emerald-50 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <form action="{{ route('admin.desa-management.structures.destroy', $index) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perangkat desa ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:text-red-500 rounded-lg hover:bg-red-50 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-sm">Belum ada data perangkat desa</p>
                        <button type="button" @click="openStructureModal()" class="mt-3 inline-flex items-center justify-center w-10 h-10 text-emerald-600 hover:text-emerald-500 bg-emerald-50 hover:bg-emerald-100 rounded-full transition" title="Tambah perangkat desa pertama">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Tonggak Sejarah</h4>
                <div class="mt-4 space-y-3">
                    @foreach($history as $item)
                    <div class="flex gap-3">
                        <div class="pt-1">
                            <span class="text-xs font-semibold text-emerald-500">{{ $item['year'] }}</span>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $item['event'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @php
        $missionsText = implode("\n", $visionMission['missions'] ?? []);
        $formContext = old('form_context');
    @endphp

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
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Perbarui Profil</p>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mt-2">Identitas Website Desa</h3>
                    <p class="text-sm text-gray-500 mt-1">Sesuaikan informasi utama desa agar sinkron dengan tampilan publik.</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600" @click="profileModal = false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto max-h-[calc(90vh-160px)]">
                <form action="{{ route('admin.desa-management.profile.update') }}" method="POST" enctype="multipart/form-data" class="px-6 sm:px-10 py-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_context" value="profile">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Section: Identitas Desa -->
                        <section class="bg-gray-50 rounded-2xl border border-gray-200 p-6 space-y-5">
                            <div class="pb-4 border-b border-gray-200">
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-500">Identitas Desa</p>
                                <h4 class="text-lg font-semibold text-gray-900 mt-1">Informasi Dasar</h4>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Desa</label>
                                    <input type="text" name="name" value="{{ $formContext === 'profile' ? old('name') : $profile['name'] }}" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"/>
                                    @error('name', 'profile')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tagline</label>
                                    <input type="text" name="tagline" value="{{ $formContext === 'profile' ? old('tagline') : $profile['tagline'] }}" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"/>
                                    @error('tagline', 'profile')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kepala Desa</label>
                                    <input type="text" name="head" value="{{ $formContext === 'profile' ? old('head') : $profile['head'] }}" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"/>
                                    @error('head', 'profile')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                                    <input type="text" name="head_title" value="{{ $formContext === 'profile' ? old('head_title') : ($profile['head_title'] ?? 'Kepala Desa') }}" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"/>
                                    @error('head_title', 'profile')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <textarea name="location" rows="3" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition resize-none">{{ $formContext === 'profile' ? old('location') : $profile['location'] }}</textarea>
                                @error('location', 'profile')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </section>

                        <!-- Section: Statistik & Data Wilayah -->
                        <section class="bg-gray-50 rounded-2xl border border-gray-200 p-6 space-y-5">
                            <div class="pb-4 border-b border-gray-200">
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-500">Statistik</p>
                                <h4 class="text-lg font-semibold text-gray-900 mt-1">Data Wilayah</h4>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Desa</label>
                                    <input type="text" name="code" value="{{ $formContext === 'profile' ? old('code') : $profile['code'] }}" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"/>
                                    @error('code', 'profile')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Penduduk</label>
                                    <input type="text" name="population" value="{{ $formContext === 'profile' ? old('population') : $profile['population'] }}" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"/>
                                    @error('population', 'profile')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Luas Wilayah</label>
                                    <input type="text" name="area" value="{{ $formContext === 'profile' ? old('area') : $profile['area'] }}" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"/>
                                    @error('area', 'profile')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kepadatan</label>
                                    <input type="text" name="density" value="{{ $formContext === 'profile' ? old('density') : $profile['density'] }}" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"/>
                                    @error('density', 'profile')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Periode Visi</label>
                                    <input type="text" name="vision_period" value="{{ $formContext === 'profile' ? old('vision_period') : ($visionMission['vision_period'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"/>
                                    @error('vision_period', 'profile')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo Desa</label>
                                    <div class="mt-2 flex items-center gap-4 p-3 rounded-xl border-2 border-gray-200 bg-white">
                                        @if(!empty($profile['logo']))
                                        <img src="{{ Str::startsWith($profile['logo'], ['http', 'https']) ? $profile['logo'] : Storage::url($profile['logo']) }}?v={{ $village->updated_at->timestamp ?? time() }}" alt="Logo Desa" class="w-16 h-16 rounded-xl object-cover border-2 border-gray-100">
                                        @endif
                                        <input type="file" name="logo" accept="image/*" class="flex-1 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-2 file:border-gray-200 file:bg-white file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-50 file:cursor-pointer">
                                    </div>
                                    @error('logo', 'profile')
                                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Section: Visi & Misi -->
                    <section class="bg-gray-50 rounded-2xl border border-gray-200 p-6 space-y-5">
                        <div class="pb-4 border-b border-gray-200">
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-500">Visi & Misi</p>
                            <h4 class="text-lg font-semibold text-gray-900 mt-1">Arah Pembangunan Desa</h4>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Visi Desa</label>
                                <textarea name="vision" rows="4" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition resize-none">{{ $formContext === 'profile' ? old('vision') : ($visionMission['vision'] ?? '') }}</textarea>
                                @error('vision', 'profile')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Misi Desa</label>
                                <p class="text-xs text-gray-500 mb-2">Satu baris per poin misi</p>
                                <textarea name="missions" rows="4" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition resize-none">{{ $formContext === 'profile' ? old('missions') : $missionsText }}</textarea>
                                @error('missions', 'profile')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>
                    <div class="flex flex-wrap items-center justify-end gap-3 sticky bottom-0 pt-6 mt-6 border-t-2 border-gray-200 bg-white">
                        <button type="button" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition" @click="profileModal = false">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-500 border-2 border-emerald-600 hover:border-emerald-500 transition shadow-sm hover:shadow-md">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Structure Modal -->
    <div
        x-show="structureModal"
        x-cloak
        x-transition
        @keydown.escape.window="closeStructureModal()"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8"
        style="display: none !important;"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeStructureModal()"></div>
        <div class="relative w-full max-w-2xl bg-white rounded-[32px] shadow-2xl max-h-[90vh] overflow-hidden">
            <div class="sticky top-0 flex items-start justify-between gap-6 px-6 sm:px-10 py-6 bg-white/95 backdrop-blur border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">
                        <span x-text="structureIndex !== null ? 'Edit' : 'Tambah'"></span> Perangkat Desa
                    </p>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mt-2">Struktur Inti Pemerintahan</h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola data perangkat desa yang akan ditampilkan di halaman publik.</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600" @click="closeStructureModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto max-h-[calc(90vh-160px)]">
                <form 
                    id="structureForm"
                    method="POST" 
                    enctype="multipart/form-data" 
                    class="px-6 sm:px-10 py-6 space-y-6"
                    :action="structureActionUrl"
                >
                    @csrf
                    <input type="hidden" name="_method" :value="structureIndex !== null ? 'PUT' : 'POST'">
                    
                    <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6 space-y-5">
                        <div class="pb-4 border-b border-gray-200">
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-500">Informasi Perangkat Desa</p>
                            <h4 class="text-lg font-semibold text-gray-900 mt-1">Data Dasar</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    x-model="structureForm.name"
                                    required
                                    class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"
                                    placeholder="Masukkan nama lengkap"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                                <input 
                                    type="text" 
                                    name="role" 
                                    x-model="structureForm.role"
                                    required
                                    class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"
                                    placeholder="Contoh: Sekretaris Desa"
                                />
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Periode / Sejak</label>
                            <input 
                                type="text" 
                                name="since" 
                                x-model="structureForm.since"
                                class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"
                                placeholder="Contoh: 2020 - Sekarang"
                            />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                            <div class="mt-2 flex items-center gap-4 p-3 rounded-xl border-2 border-gray-200 bg-white">
                                <img 
                                    x-show="structureIndex !== null && structureForm.photo"
                                    :src="structureForm.photo" 
                                    alt="Foto saat ini" 
                                    class="w-16 h-16 rounded-xl object-cover border-2 border-gray-100"
                                />
                                <input 
                                    type="file" 
                                    name="photo" 
                                    accept="image/*" 
                                    class="flex-1 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-2 file:border-gray-200 file:bg-white file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-50 file:cursor-pointer"
                                />
                            </div>
                            <p class="text-xs text-gray-500 mt-1.5">Format: JPG, PNG, maksimal 2MB. <span x-show="structureIndex !== null">Kosongkan jika tidak ingin mengubah foto.</span></p>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap items-center justify-end gap-3 sticky bottom-0 pt-6 mt-6 border-t-2 border-gray-200 bg-white">
                        <button type="button" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition" @click="closeStructureModal()">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-500 border-2 border-emerald-600 hover:border-emerald-500 transition shadow-sm hover:shadow-md">
                            <span x-text="structureIndex !== null ? 'Simpan Perubahan' : 'Tambah Perangkat Desa'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function structureManagement() {
        return {
            profileModal: false,
            structureModal: false,
            structureIndex: null,
            structureForm: {
                name: '',
                role: '',
                since: '',
                photo: null
            },
            structuresData: @json($structures->values()->all() ?? []),
            get structureActionUrl() {
                if (this.structureIndex !== null) {
                    const baseUrl = '{{ route('admin.desa-management.structures.update', 999) }}';
                    return baseUrl.replace('999', this.structureIndex);
                }
                return '{{ route('admin.desa-management.structures.store') }}';
            },
            openStructureModal(index = null) {
                console.log('openStructureModal called with index:', index);
                this.structureIndex = index !== null ? parseInt(index) : null;
                
                if (this.structureIndex !== null && this.structuresData && this.structuresData[this.structureIndex]) {
                    const structure = this.structuresData[this.structureIndex];
                    this.structureForm = {
                        name: structure.name || '',
                        role: structure.role || '',
                        since: structure.since || '',
                        photo: structure.photo || null
                    };
                } else {
                    this.structureForm = {
                        name: '',
                        role: '',
                        since: '',
                        photo: null
                    };
                }
                
                this.structureModal = true;
                
                this.$nextTick(() => {
                    const form = document.getElementById('structureForm');
                    if (form) {
                        form.action = this.structureActionUrl;
                        const methodInput = form.querySelector('input[name="_method"]');
                        if (methodInput) {
                            methodInput.value = this.structureIndex !== null ? 'PUT' : 'POST';
                        }
                        console.log('Form action updated to:', form.action);
                        console.log('Form method:', methodInput ? methodInput.value : 'not found');
                    }
                });
            },
            closeStructureModal() {
                this.structureModal = false;
                this.structureIndex = null;
                this.structureForm = {
                    name: '',
                    role: '',
                    since: '',
                    photo: null
                };
            }
        }
    }
    
    // Ensure Alpine.js is loaded before using x-data
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Alpine === 'undefined') {
            console.error('Alpine.js is not loaded! Please check if app.js is loaded correctly.');
        } else {
            console.log('Alpine.js is loaded successfully');
            
            // Wait for Alpine to initialize
            Alpine.nextTick(() => {
                console.log('Alpine.js initialized');
            });
        }
    });
</script>
@endpush
@endsection

