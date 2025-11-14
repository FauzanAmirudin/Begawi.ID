@extends('layouts.admin')

@section('title', 'Profil Desa')

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
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
                        <img src="{{ $profile['logo'] }}" alt="Logo Desa" class="w-16 h-16 object-cover">
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
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Struktur Inti</h4>
                <div class="mt-4 space-y-4">
                    @foreach($structures as $person)
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gray-100 overflow-hidden">
                            <img src="{{ $person['photo'] }}" alt="{{ $person['name'] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">{{ $person['name'] }}</p>
                            <p class="text-xs text-gray-500">{{ $person['role'] }}</p>
                            <p class="text-xs text-gray-400">{{ $person['since'] }}</p>
                        </div>
                        <button class="text-xs font-semibold text-emerald-600 hover:text-emerald-500">Edit</button>
                    </div>
                    @endforeach
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
                <form action="{{ route('admin.desa-management.profile.update') }}" method="POST" enctype="multipart/form-data" class="px-6 sm:px-10 py-6 space-y-8">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_context" value="profile">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <section class="space-y-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-500">Identitas Desa</p>
                                <h4 class="text-lg font-semibold text-gray-900 mt-1">Informasi Dasar</h4>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Desa</label>
                                    <input type="text" name="name" value="{{ $formContext === 'profile' ? old('name') : $profile['name'] }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500"/>
                                    @error('name', 'profile')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tagline</label>
                                    <input type="text" name="tagline" value="{{ $formContext === 'profile' ? old('tagline') : $profile['tagline'] }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500"/>
                                    @error('tagline', 'profile')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kepala Desa</label>
                                    <input type="text" name="head" value="{{ $formContext === 'profile' ? old('head') : $profile['head'] }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500"/>
                                    @error('head', 'profile')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                                    <input type="text" name="head_title" value="{{ $formContext === 'profile' ? old('head_title') : ($profile['head_title'] ?? 'Kepala Desa') }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500"/>
                                    @error('head_title', 'profile')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="location" rows="3" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500">{{ $formContext === 'profile' ? old('location') : $profile['location'] }}</textarea>
                                @error('location', 'profile')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </section>
                        <section class="space-y-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-500">Statistik</p>
                                <h4 class="text-lg font-semibold text-gray-900 mt-1">Data Wilayah</h4>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kode Desa</label>
                                    <input type="text" name="code" value="{{ $formContext === 'profile' ? old('code') : $profile['code'] }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500"/>
                                    @error('code', 'profile')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jumlah Penduduk</label>
                                    <input type="text" name="population" value="{{ $formContext === 'profile' ? old('population') : $profile['population'] }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500"/>
                                    @error('population', 'profile')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Luas Wilayah</label>
                                    <input type="text" name="area" value="{{ $formContext === 'profile' ? old('area') : $profile['area'] }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500"/>
                                    @error('area', 'profile')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kepadatan</label>
                                    <input type="text" name="density" value="{{ $formContext === 'profile' ? old('density') : $profile['density'] }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500"/>
                                    @error('density', 'profile')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Periode Visi</label>
                                    <input type="text" name="vision_period" value="{{ $formContext === 'profile' ? old('vision_period') : ($visionMission['vision_period'] ?? '') }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500"/>
                                    @error('vision_period', 'profile')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Logo Desa</label>
                                    <div class="mt-2 flex items-center gap-4">
                                        @if(!empty($profile['logo']))
                                        <img src="{{ Str::startsWith($profile['logo'], ['http', 'https']) ? $profile['logo'] : Storage::url($profile['logo']) }}" alt="Logo Desa" class="w-16 h-16 rounded-2xl object-cover border border-gray-100">
                                        @endif
                                        <input type="file" name="logo" accept="image/*" class="w-full text-sm">
                                    </div>
                                    @error('logo', 'profile')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>
                    </div>
                    <section class="space-y-5">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Visi Desa</label>
                                <textarea name="vision" rows="4" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500">{{ $formContext === 'profile' ? old('vision') : ($visionMission['vision'] ?? '') }}</textarea>
                                @error('vision', 'profile')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Misi Desa (satu baris per poin)</label>
                                <textarea name="missions" rows="4" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500">{{ $formContext === 'profile' ? old('missions') : $missionsText }}</textarea>
                                @error('missions', 'profile')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>
                    <div class="flex flex-wrap items-center justify-end gap-3 sticky bottom-0 pt-4 border-t border-gray-100 bg-white">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" @click="profileModal = false">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-500 transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

