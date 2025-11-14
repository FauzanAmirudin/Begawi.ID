@extends('layouts.admin')

@section('title', 'Manajemen Website Desa')

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
<div class="p-6 space-y-8" x-data="{
        profileModal: false,
        newsModal: false,
        galleryModal: false,
        potentialModal: false,
        achievementModal: false,
        achievementTab: 'prestasi',
        init() {
            const ctx = {{ json_encode(old('form_context')) }};
            if (ctx === 'profile') this.profileModal = true;
            if (ctx === 'news') this.newsModal = true;
            if (ctx === 'gallery') this.galleryModal = true;
            if (ctx === 'potential') this.potentialModal = true;
            if (ctx === 'achievement') this.achievementModal = true;
            if (ctx === 'program') {
                this.achievementModal = true;
                this.achievementTab = 'program';
            }
        }
    }" x-cloak>
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
    <div class="bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-500 rounded-3xl p-8 text-white shadow-lg">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-xs font-semibold uppercase tracking-wide">
                    Manajemen Website Desa
                </div>
                <h1 class="text-3xl lg:text-4xl font-semibold mt-4">Panel Manajemen Desa Sejahtera</h1>
                <p class="text-white/70 mt-3 max-w-3xl">
                    Kelola identitas desa, berita & pengumuman, galeri kegiatan, potensi wisata, hingga prestasi dan program unggulan.
                    Gunakan panel ini untuk memastikan seluruh informasi pada website desa selalu akurat dan terkini.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('desa.home') }}" target="_blank"
                   class="inline-flex items-center justify-center gap-2 bg-white/15 hover:bg-white/25 text-white font-semibold px-5 py-3 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Lihat Website Desa
                </a>
                <a href="#konten-baru" class="inline-flex items-center justify-center gap-2 bg-white text-emerald-600 font-semibold px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Konten Baru
                </a>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-4">
            <div class="bg-white/15 rounded-2xl px-4 py-3">
                <p class="text-xs uppercase tracking-wide text-white/60">Berita Terbit</p>
                <p class="text-2xl font-semibold mt-2">{{ $stats['news_published'] }}</p>
                <p class="text-xs text-white/50 mt-1">Konten live di website</p>
            </div>
            <div class="bg-white/15 rounded-2xl px-4 py-3">
                <p class="text-xs uppercase tracking-wide text-white/60">Draft Konten</p>
                <p class="text-2xl font-semibold mt-2">{{ $stats['news_draft'] }}</p>
                <p class="text-xs text-white/50 mt-1">Menunggu review</p>
            </div>
            <div class="bg-white/15 rounded-2xl px-4 py-3">
                <p class="text-xs uppercase tracking-wide text-white/60">Item Galeri</p>
                <p class="text-2xl font-semibold mt-2">{{ $stats['gallery_total'] }}</p>
                <p class="text-xs text-white/50 mt-1">Foto & video kegiatan</p>
            </div>
            <div class="bg-white/15 rounded-2xl px-4 py-3">
                <p class="text-xs uppercase tracking-wide text-white/60">Potensi Desa</p>
                <p class="text-2xl font-semibold mt-2">{{ $stats['potentials_total'] }}</p>
                <p class="text-xs text-white/50 mt-1">Wisata & ekonomi</p>
            </div>
            <div class="bg-white/15 rounded-2xl px-4 py-3">
                <p class="text-xs uppercase tracking-wide text-white/60">Prestasi</p>
                <p class="text-2xl font-semibold mt-2">{{ $stats['achievements_total'] }}</p>
                <p class="text-xs text-white/50 mt-1">Penghargaan desa</p>
            </div>
            <div class="bg-white/15 rounded-2xl px-4 py-3">
                <p class="text-xs uppercase tracking-wide text-white/60">Program Aktif</p>
                <p class="text-2xl font-semibold mt-2">{{ $stats['programs_total'] }}</p>
                <p class="text-xs text-white/50 mt-1">Program strategis</p>
            </div>
        </div>
    </div>

    <!-- Section Navigation -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl px-6 py-4 flex flex-wrap gap-3">
        @foreach($tabs as $anchor => $label)
        <a href="#{{ $anchor }}"
           class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 transition">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <!-- Profil Desa -->
    <section id="profile" class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-500 font-semibold">01 · Profil Desa</p>
                <h2 class="text-2xl font-semibold text-gray-900 mt-2">Identitas & Struktur Pemerintahan</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data identitas desa, visi misi, serta struktur organisasi pemerintahan desa.</p>
            </div>
            <button type="button" @click="profileModal = true" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-emerald-600 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition">
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
    </section>

    <!-- Berita & Agenda -->
    <section id="news" class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 font-semibold">02 · Berita & Agenda</p>
                <h2 class="text-2xl font-semibold text-gray-900 mt-2">Kelola Berita, Pengumuman, dan Agenda Kegiatan</h2>
                <p class="text-sm text-gray-500 mt-1">Publikasikan berita penting, atur jadwal agenda, dan kontrol status publish / draft.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('desa.berita.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition">
                    Lihat Halaman Berita
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <button type="button" @click="newsModal = true" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-500 transition">
                    Tambah Berita
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Berita Aktif</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $stats['news_total'] }} berita dipublikasikan</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="text-xs font-semibold px-3 py-2 rounded-lg border border-gray-200 text-gray-500 hover:text-indigo-600 hover:border-indigo-200 transition">
                            Filter
                        </button>
                        <button class="text-xs font-semibold px-3 py-2 rounded-lg border border-gray-200 text-gray-500 hover:text-indigo-600 hover:border-indigo-200 transition">
                            Export
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-sm">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                <th class="px-6 py-3">Judul</th>
                                <th class="px-6 py-3">Kategori</th>
                                <th class="px-6 py-3">Penulis</th>
                                <th class="px-6 py-3">Publikasi</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($news as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">{{ $item->title }}</p>
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $item->summary }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600">
                                        {{ $item->category ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <p class="font-medium text-sm">{{ $item->writer ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-400">{{ number_format($item->views ?? 0) }} views</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ optional($item->published_at)->translatedFormat('d M Y') ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $item->status === \App\Models\VillageNews::STATUS_PUBLISHED ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('desa.berita.detail', $item->slug) }}" target="_blank" class="text-xs font-semibold text-slate-400 hover:text-indigo-500">
                                            Lihat
                                        </a>
                                        <form action="{{ route('admin.desa-management.news.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold text-gray-400 hover:text-red-500">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Draft & Review</h4>
                            <p class="text-xs text-gray-500 mt-1">{{ $drafts->count() }} konten perlu tindakan</p>
                        </div>
                        <button class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">Kelola</button>
                    </div>
                    <div class="mt-4 space-y-3">
                        @foreach($drafts as $draft)
                        <div class="rounded-xl border border-gray-100 px-4 py-3 hover:border-indigo-200 hover:bg-indigo-50/50 transition">
                            <p class="text-sm font-semibold text-gray-900">{{ $draft->title }}</p>
                            <div class="flex items-center justify-between mt-2 text-xs text-gray-500">
                                <span>{{ $draft->category ?? 'Umum' }} · {{ $draft->writer ?? 'Admin' }}</span>
                                <span>{{ optional($draft->updated_at)->diffForHumans() }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold
                                    {{ $draft->status === \App\Models\VillageNews::STATUS_DRAFT ? 'bg-gray-100 text-gray-600' : 'bg-amber-100 text-amber-600' }}">
                                    {{ ucfirst($draft->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Agenda Desa</h4>
                            <p class="text-xs text-gray-500 mt-1">{{ $agendas->count() }} agenda terdekat</p>
                        </div>
                        <button class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">Tambah Agenda</button>
                    </div>
                    <div class="mt-4 space-y-4">
                        @foreach($agendas as $agenda)
                        <div class="rounded-xl border border-gray-100 px-4 py-3 hover:border-indigo-200 hover:bg-indigo-50/50 transition">
                            <p class="text-sm font-semibold text-gray-900">{{ $agenda['title'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $agenda['date'] }} · {{ $agenda['time'] }}</p>
                            <p class="text-xs text-gray-500">{{ $agenda['location'] }}</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-600">
                                    {{ $agenda['category'] }}
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-600">
                                    {{ $agenda['status'] }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Galeri Desa -->
    <section id="gallery" class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-rose-500 font-semibold">03 · Galeri Desa</p>
                <h2 class="text-2xl font-semibold text-gray-900 mt-2">Dokumentasi Foto & Video Kegiatan</h2>
                <p class="text-sm text-gray-500 mt-1">Kelompokkan dokumentasi galeri berdasarkan kategori acara, pembangunan, dan sosial.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('desa.galeri-wisata.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-rose-600 bg-rose-50 rounded-xl hover:bg-rose-100 transition">
                    Lihat Halaman Galeri
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <button type="button" @click="galleryModal = true" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-rose-500 rounded-xl hover:bg-rose-400 transition">
                    Upload Konten
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            @forelse($galleryCategories as $category)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-rose-500">{{ $category->name }}</p>
                            <h3 class="text-lg font-semibold text-gray-900 mt-1">Koleksi {{ $category->name }}</h3>
                        </div>
                        <span class="text-xs font-semibold text-rose-500 bg-rose-50 px-3 py-1 rounded-full">
                            {{ $category->items->count() }} Item
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-3">{{ $category->description }}</p>
                </div>
                <div class="grid grid-cols-2 gap-3 px-6 pb-6">
                    @forelse($category->items as $item)
                    @php
                        $thumbPath = $item->thumbnail_path
                            ? (Str::startsWith($item->thumbnail_path, ['http', 'https'])
                                ? $item->thumbnail_path
                                : Storage::url($item->thumbnail_path))
                            : (Str::startsWith($item->media_path, ['http', 'https'])
                                ? $item->media_path
                                : Storage::url($item->media_path));
                        $displayDate = optional($item->taken_at)->translatedFormat('M Y')
                            ?? optional($item->created_at)->translatedFormat('M Y')
                            ?? '—';
                    @endphp
                    <div class="rounded-xl overflow-hidden border border-gray-100">
                        <div class="relative aspect-[4/3]">
                            <img src="{{ $thumbPath }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                            <span class="absolute top-3 right-3 inline-flex items-center px-2 py-1 rounded-full text-[11px] font-semibold bg-white/80 text-gray-700">
                                {{ ucfirst($item->type) }}
                            </span>
                        </div>
                        <div class="px-3 py-2">
                            <p class="text-sm font-semibold text-gray-900 line-clamp-1">{{ $item->title }}</p>
                            <p class="text-xs text-gray-500">{{ $displayDate }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-2 flex items-center justify-center text-sm text-gray-400 italics py-6">
                        Belum ada konten pada kategori ini.
                    </div>
                    @endforelse
                </div>
                <div class="px-6 pb-6">
                    <p class="text-xs text-gray-400 text-center">Gunakan tombol Upload Konten untuk menambah item.</p>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="border border-dashed border-rose-200 rounded-3xl py-16 text-center">
                    <h3 class="text-lg font-semibold text-rose-500">Belum ada konten galeri</h3>
                    <p class="text-sm text-gray-500 mt-2">Klik tombol <strong>Upload Konten</strong> untuk mulai menambahkan dokumentasi.</p>
                </div>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Potensi & Wisata -->
    <section id="potency" class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-500 font-semibold">04 · Potensi & Wisata</p>
                <h2 class="text-2xl font-semibold text-gray-900 mt-2">Kelola Potensi Wisata, Alam, Budaya, dan Ekonomi</h2>
                <p class="text-sm text-gray-500 mt-1">Tambahkan deskripsi, status, dan embed lokasi peta untuk setiap potensi unggulan desa.</p>
            </div>
            <button type="button" @click="potentialModal = true" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-emerald-500 rounded-xl hover:bg-emerald-400 transition">
                Tambah Potensi
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @foreach($potentials as $potential)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500">{{ $potential->category ?? 'Potensi' }}</p>
                            <h3 class="text-lg font-semibold text-gray-900 mt-1">{{ $potential->title }}</h3>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold
                            {{ $potential->status === \App\Models\VillagePotential::STATUS_ACTIVE ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $potential->status === \App\Models\VillagePotential::STATUS_ACTIVE ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                            {{ $potential->status }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $potential->summary }}</p>
                </div>
                <div class="aspect-video border-t border-gray-100">
                    <iframe src="{{ $potential->map_embed }}" class="w-full h-full" loading="lazy"></iframe>
                </div>
                <div class="px-6 py-4 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100">
                    <a href="#potency" class="font-semibold text-emerald-600 hover:text-emerald-500">Detail</a>
                    <form action="{{ route('admin.desa-management.potentials.destroy', $potential) }}" method="POST" onsubmit="return confirm('Hapus potensi ini?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-semibold text-gray-400 hover:text-red-500">Hapus</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Prestasi & Program -->
    <section id="achievement" class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">05 · Prestasi & Program</p>
                <h2 class="text-2xl font-semibold text-gray-900 mt-2">Catatan Prestasi dan Program Unggulan Desa</h2>
                <p class="text-sm text-gray-500 mt-1">Dokumentasikan raihan prestasi desa serta program strategis yang sedang berjalan.</p>
            </div>
            <button type="button" @click="achievementModal = true" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-purple-500 rounded-xl hover:bg-purple-400 transition">
                Tambah Prestasi / Program
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Prestasi Desa</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $achievements->count() }} penghargaan dicatat</p>
                    </div>
                    <button class="text-xs font-semibold text-purple-500 hover:text-purple-400">Kelola</button>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($achievements as $achievement)
                    <div class="px-6 py-4 hover:bg-purple-50/40 transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $achievement->title }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $achievement->organizer }} · {{ $achievement->category }}</p>
                            </div>
                            <span class="text-xs font-semibold text-purple-500 bg-purple-50 px-3 py-1 rounded-full">
                                {{ $achievement->year }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mt-3 leading-relaxed">{{ $achievement->description }}</p>
                        <form action="{{ route('admin.desa-management.achievements.destroy', $achievement) }}" method="POST" onsubmit="return confirm('Hapus prestasi ini?')" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-gray-400 hover:text-red-500">Hapus</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Program Unggulan</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $programs->count() }} program aktif</p>
                    </div>
                    <button class="text-xs font-semibold text-purple-500 hover:text-purple-400">Kelola</button>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($programs as $program)
                    <div class="px-6 py-4 hover:bg-purple-50/40 transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $program->title }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $program->lead }} · {{ $program->period }}</p>
                            </div>
                            <span class="inline-flex items-center gap-2 text-xs font-semibold text-purple-500">
                                <span class="w-20 h-2 bg-purple-100 rounded-full overflow-hidden">
                                    <span class="block h-full bg-purple-500" style="width: {{ $program->progress ?? 0 }}%"></span>
                                </span>
                                {{ $program->progress ?? 0 }}%
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mt-3 leading-relaxed">{{ $program->description }}</p>
                        <form action="{{ route('admin.desa-management.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Hapus program ini?')" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-gray-400 hover:text-red-500">Hapus</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Konten Baru CTA -->
    <section id="konten-baru" class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 border border-gray-800 rounded-3xl text-white p-8 shadow-xl">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold uppercase tracking-wide">
                    KONTEN BARU
                </div>
                <h2 class="text-2xl lg:text-3xl font-semibold mt-4">Lengkapi Website Desa dengan Konten Terbaru</h2>
                <p class="text-white/70 mt-3">
                    Gunakan tombol cepat di bawah ini untuk menambahkan konten baru. Semua konten langsung terintegrasi dengan halaman publik
                    website desa Begawi.ID.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full lg:w-auto">
                <a href="{{ route('desa.umkm.index') }}" class="flex flex-col gap-2 px-4 py-4 rounded-2xl bg-white/10 hover:bg-white/15 transition">
                    <span class="text-xs font-semibold text-white/70 uppercase tracking-wide">Tambah</span>
                    <span class="text-sm font-semibold text-white">Profil Desa</span>
                </a>
                <a href="{{ route('desa.berita.index') }}" class="flex flex-col gap-2 px-4 py-4 rounded-2xl bg-white/10 hover:bg-white/15 transition">
                    <span class="text-xs font-semibold text-white/70 uppercase tracking-wide">Tambah</span>
                    <span class="text-sm font-semibold text-white">Berita Baru</span>
                </a>
                <a href="{{ route('desa.galeri-wisata.index') }}" class="flex flex-col gap-2 px-4 py-4 rounded-2xl bg-white/10 hover:bg-white/15 transition">
                    <span class="text-xs font-semibold text-white/70 uppercase tracking-wide">Upload</span>
                    <span class="text-sm font-semibold text-white">Galeri Kegiatan</span>
                </a>
            </div>
        </div>
    </section>

    @php
        $missionsText = implode("\n", $visionMission['missions'] ?? []);
        $formContext = old('form_context');
        $galleryCategoryOptions = $galleryCategories->pluck('name', 'id');
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

    <!-- News Modal -->
    <div
        x-show="newsModal"
        x-transition.opacity
        x-trap="newsModal"
        @keydown.escape.window="newsModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="newsModal = false"></div>
        <div class="relative w-full max-w-4xl lg:max-w-5xl bg-white rounded-[32px] shadow-2xl max-h-[90vh] overflow-hidden">
            <div class="sticky top-0 flex items-start justify-between gap-6 px-6 sm:px-10 py-6 bg-white/95 backdrop-blur border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-indigo-500">Konten Berita</p>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mt-2">Tambah Berita Baru</h3>
                    <p class="text-sm text-gray-500 mt-1">Isi informasi lengkap agar berita tampil maksimal pada halaman publik.</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600" @click="newsModal = false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto max-h-[calc(90vh-160px)]">
                <form action="{{ route('admin.desa-management.news.store') }}" method="POST" enctype="multipart/form-data" class="px-6 sm:px-10 py-6 space-y-8">
                    @csrf
                    <input type="hidden" name="form_context" value="news">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <section class="space-y-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-indigo-500">Informasi Utama</p>
                                <h4 class="text-lg font-semibold text-gray-900 mt-1">Detail Berita</h4>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul Berita</label>
                                <input type="text" name="title" value="{{ $formContext === 'news' ? old('title') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />
                                @error('title', 'news')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <input type="text" name="category" value="{{ $formContext === 'news' ? old('category') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />
                                    @error('category', 'news')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Penulis</label>
                                    <input type="text" name="writer" value="{{ $formContext === 'news' ? old('writer', auth()->user()->name ?? 'Admin Desa') : (auth()->user()->name ?? 'Admin Desa') }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />
                                    @error('writer', 'news')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach(['draft' => 'Draft', 'published' => 'Publish', 'archived' => 'Arsip'] as $value => $label)
                                        <option value="{{ $value }}" {{ ($formContext === 'news' ? old('status') : null) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('status', 'news')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Publikasi</label>
                                    <input type="date" name="published_at" value="{{ $formContext === 'news' ? old('published_at') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />
                                    @error('published_at', 'news')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="is_featured" id="is_featured" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ ($formContext === 'news' ? old('is_featured') : false) ? 'checked' : '' }}>
                                <label for="is_featured" class="text-sm text-gray-700">Tandai sebagai berita unggulan</label>
                            </div>
                        </section>
                        <section class="space-y-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-indigo-500">Konten</p>
                                <h4 class="text-lg font-semibold text-gray-900 mt-1">Isi Berita</h4>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ringkasan</label>
                                <textarea name="summary" rows="3" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500">{{ $formContext === 'news' ? old('summary') : '' }}</textarea>
                                @error('summary', 'news')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Konten Lengkap</label>
                                <textarea name="content" rows="6" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500">{{ $formContext === 'news' ? old('content') : '' }}</textarea>
                                @error('content', 'news')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gambar Utama</label>
                                <input type="file" name="featured_image" accept="image/*" class="mt-2 w-full text-sm">
                                @error('featured_image', 'news')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </section>
                    </div>
                    <div class="flex flex-wrap items-center justify-end gap-3 sticky bottom-0 pt-4 border-t border-gray-100 bg-white">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" @click="newsModal = false">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-500 transition">Publikasikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Gallery Modal -->
    <div
        x-show="galleryModal"
        x-transition.opacity
        x-trap="galleryModal"
        @keydown.escape.window="galleryModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="galleryModal = false"></div>
        <div class="relative w-full max-w-4xl lg:max-w-5xl bg-white rounded-[32px] shadow-2xl max-h-[90vh] overflow-hidden">
            <div class="sticky top-0 flex items-start justify-between gap-6 px-6 sm:px-10 py-6 bg-white/95 backdrop-blur border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-rose-500">Galeri Desa</p>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mt-2">Upload Foto & Video</h3>
                    <p class="text-sm text-gray-500 mt-1">Pastikan konten visual memiliki informasi yang lengkap dan rapi.</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600" @click="galleryModal = false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto max-h-[calc(90vh-160px)]">
                <form action="{{ route('admin.desa-management.gallery.store') }}" method="POST" enctype="multipart/form-data" class="px-6 sm:px-10 py-6 space-y-8">
                    @csrf
                    <input type="hidden" name="form_context" value="gallery">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <section class="space-y-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-rose-500">Informasi Konten</p>
                                <h4 class="text-lg font-semibold text-gray-900 mt-1">Detail Media</h4>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul Konten</label>
                                <input type="text" name="title" value="{{ $formContext === 'gallery' ? old('title') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" />
                                @error('title', 'gallery')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="description" rows="3" class="mt-1 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500">{{ $formContext === 'gallery' ? old('description') : '' }}</textarea>
                                @error('description', 'gallery')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jenis Konten</label>
                                    <select name="type" class="mt-1 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500">
                                        @foreach([\App\Models\VillageGalleryItem::TYPE_PHOTO => 'Foto', \App\Models\VillageGalleryItem::TYPE_VIDEO => 'Video'] as $key => $label)
                                        <option value="{{ $key }}" {{ ($formContext === 'gallery' ? old('type') : null) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('type', 'gallery')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Dokumentasi</label>
                                    <input type="date" name="taken_at" value="{{ $formContext === 'gallery' ? old('taken_at') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" />
                                    @error('taken_at', 'gallery')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Upload File</label>
                                <input type="file" name="media_file" class="mt-2 w-full text-sm">
                                @error('media_file', 'gallery')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">URL Media</label>
                                <input type="url" name="media_url" value="{{ $formContext === 'gallery' ? old('media_url') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" />
                                @error('media_url', 'gallery')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">URL Video</label>
                                <input type="url" name="video_url" value="{{ $formContext === 'gallery' ? old('video_url') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" />
                                @error('video_url', 'gallery')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </section>
                        <section class="space-y-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-rose-500">Kategorisasi</p>
                                <h4 class="text-lg font-semibold text-gray-900 mt-1">Pengelompokan Konten</h4>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select name="category_id" class="mt-1 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($galleryCategoryOptions as $id => $name)
                                    <option value="{{ $id }}" {{ ($formContext === 'gallery' ? old('category_id') : null) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id', 'gallery')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Kategori Baru</label>
                                <input type="text" name="new_category_name" value="{{ $formContext === 'gallery' ? old('new_category_name') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" />
                                @error('new_category_name', 'gallery')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi Kategori Baru</label>
                                <textarea name="new_category_description" rows="3" class="mt-1 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500">{{ $formContext === 'gallery' ? old('new_category_description') : '' }}</textarea>
                                @error('new_category_description', 'gallery')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Thumbnail (opsional)</label>
                                <input type="file" name="thumbnail_file" class="mt-2 w-full text-sm">
                                @error('thumbnail_file', 'gallery')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                                <input type="url" name="thumbnail_url" value="{{ $formContext === 'gallery' ? old('thumbnail_url') : '' }}" placeholder="URL Thumbnail" class="mt-3 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" />
                                @error('thumbnail_url', 'gallery')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="is_published" id="gallery_is_published" class="rounded border-gray-300 text-rose-500 focus:ring-rose-500" {{ ($formContext === 'gallery' ? old('is_published', true) : true) ? 'checked' : '' }}>
                                <label for="gallery_is_published" class="text-sm text-gray-700">Tampilkan di website desa</label>
                            </div>
                        </section>
                    </div>
                    <div class="flex flex-wrap items-center justify-end gap-3 sticky bottom-0 pt-4 border-t border-gray-100 bg-white">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" @click="galleryModal = false">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-rose-500 text-white text-sm font-semibold hover:bg-rose-400 transition">Simpan Konten</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Potential Modal -->
    <div
        x-show="potentialModal"
        x-transition.opacity
        x-trap="potentialModal"
        @keydown.escape.window="potentialModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="potentialModal = false"></div>
        <div class="relative w-full max-w-3xl lg:max-w-4xl bg-white rounded-[32px] shadow-2xl max-h-[90vh] overflow-hidden">
            <div class="sticky top-0 flex items-start justify-between gap-6 px-6 sm:px-10 py-6 bg-white/95 backdrop-blur border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Potensi Desa</p>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mt-2">Tambah Potensi Unggulan</h3>
                    <p class="text-sm text-gray-500 mt-1">Lengkapi detail potensi untuk memperkuat promosi desa.</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600" @click="potentialModal = false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto max-h-[calc(90vh-160px)]">
                <form action="{{ route('admin.desa-management.potentials.store') }}" method="POST" enctype="multipart/form-data" class="px-6 sm:px-10 py-6 space-y-8">
                    @csrf
                    <input type="hidden" name="form_context" value="potential">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <section class="space-y-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-500">Informasi Potensi</p>
                                <h4 class="text-lg font-semibold text-gray-900 mt-1">Detail Umum</h4>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul Potensi</label>
                                <input type="text" name="title" value="{{ $formContext === 'potential' ? old('title') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500" />
                                @error('title', 'potential')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                <input type="text" name="category" value="{{ $formContext === 'potential' ? old('category') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500" />
                                @error('category', 'potential')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500">
                                    @foreach([\App\Models\VillagePotential::STATUS_ACTIVE, \App\Models\VillagePotential::STATUS_DEVELOPMENT, \App\Models\VillagePotential::STATUS_INACTIVE] as $status)
                                    <option value="{{ $status }}" {{ ($formContext === 'potential' ? old('status') : null) === $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status', 'potential')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </section>
                        <section class="space-y-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-500">Konten</p>
                                <h4 class="text-lg font-semibold text-gray-900 mt-1">Deskripsi Potensi</h4>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ringkasan</label>
                                <textarea name="summary" rows="3" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500">{{ $formContext === 'potential' ? old('summary') : '' }}</textarea>
                                @error('summary', 'potential')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi Lengkap</label>
                                <textarea name="description" rows="4" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500">{{ $formContext === 'potential' ? old('description') : '' }}</textarea>
                                @error('description', 'potential')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Embed Peta (Google Maps)</label>
                                <textarea name="map_embed" rows="2" class="mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500" placeholder="https://maps.google.com/...">{{ $formContext === 'potential' ? old('map_embed') : '' }}</textarea>
                                @error('map_embed', 'potential')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gambar Utama</label>
                                <input type="file" name="featured_image" accept="image/*" class="mt-2 w-full text-sm">
                                @error('featured_image', 'potential')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </section>
                    </div>
                    <div class="flex flex-wrap items-center justify-end gap-3 sticky bottom-0 pt-4 border-t border-gray-100 bg-white">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" @click="potentialModal = false">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-500 transition">Simpan Potensi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Achievement / Program Modal -->
    <div
        x-show="achievementModal"
        x-transition.opacity
        x-trap="achievementModal"
        @keydown.escape.window="achievementModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="achievementModal = false"></div>
        <div class="relative w-full max-w-4xl lg:max-w-5xl bg-white rounded-[32px] shadow-2xl max-h-[90vh] overflow-hidden">
            <div class="sticky top-0 flex items-start justify-between gap-6 px-6 sm:px-10 py-6 bg-white/95 backdrop-blur border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-purple-500">Prestasi & Program</p>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mt-2">Catat Prestasi atau Program</h3>
                    <p class="text-sm text-gray-500 mt-1">Gunakan tab di bawah ini untuk memilih jenis data yang akan ditambahkan.</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600" @click="achievementModal = false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto max-h-[calc(90vh-160px)]">
                <div class="px-6 sm:px-10 pt-6">
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" @click="achievementTab = 'prestasi'" :class="achievementTab === 'prestasi' ? 'bg-purple-600 text-white' : 'bg-purple-50 text-purple-600'" class="px-4 py-2 rounded-xl text-sm font-semibold transition">Prestasi</button>
                        <button type="button" @click="achievementTab = 'program'" :class="achievementTab === 'program' ? 'bg-purple-600 text-white' : 'bg-purple-50 text-purple-600'" class="px-4 py-2 rounded-xl text-sm font-semibold transition">Program Unggulan</button>
                    </div>
                </div>
                <div class="px-6 sm:px-10 py-6 space-y-8">
                    <form x-show="achievementTab === 'prestasi'" x-transition.opacity action="{{ route('admin.desa-management.achievements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="form_context" value="achievement">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul Prestasi</label>
                                <input type="text" name="title" value="{{ $formContext === 'achievement' ? old('title') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('title', 'achievement')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tahun</label>
                                <input type="number" name="year" value="{{ $formContext === 'achievement' ? old('year') : now()->year }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('year', 'achievement')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                <input type="text" name="category" value="{{ $formContext === 'achievement' ? old('category') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('category', 'achievement')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Penyelenggara</label>
                                <input type="text" name="organizer" value="{{ $formContext === 'achievement' ? old('organizer') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('organizer', 'achievement')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" rows="4" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500">{{ $formContext === 'achievement' ? old('description') : '' }}</textarea>
                            @error('description', 'achievement')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lampiran (PDF/Foto)</label>
                            <input type="file" name="attachment" class="mt-2 w-full text-sm">
                            @error('attachment', 'achievement')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-wrap items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" @click="achievementModal = false">Tutup</button>
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 text-white text-sm font-semibold hover:bg-purple-500 transition">Simpan Prestasi</button>
                        </div>
                    </form>

                    <form x-show="achievementTab === 'program'" x-transition.opacity action="{{ route('admin.desa-management.programs.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="form_context" value="program">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul Program</label>
                            <input type="text" name="title" value="{{ $formContext === 'program' ? old('title') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                            @error('title', 'program')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Periode</label>
                                <input type="text" name="period" value="{{ $formContext === 'program' ? old('period') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('period', 'program')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                                <input type="text" name="lead" value="{{ $formContext === 'program' ? old('lead') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('lead', 'program')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Progress (%)</label>
                                <input type="number" name="progress" value="{{ $formContext === 'program' ? old('progress', 0) : 0 }}" min="0" max="100" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('progress', 'program')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status Program</label>
                                <select name="status" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500">
                                    @foreach([\App\Models\VillageProgram::STATUS_ACTIVE, \App\Models\VillageProgram::STATUS_COMPLETED, \App\Models\VillageProgram::STATUS_ON_HOLD] as $status)
                                    <option value="{{ $status }}" {{ ($formContext === 'program' ? old('status') : null) === $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status', 'program')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Mulai</label>
                                    <input type="date" name="start_date" value="{{ $formContext === 'program' ? old('start_date') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                    @error('start_date', 'program')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Selesai</label>
                                    <input type="date" name="end_date" value="{{ $formContext === 'program' ? old('end_date') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                    @error('end_date', 'program')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi Program</label>
                            <textarea name="description" rows="4" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500">{{ $formContext === 'program' ? old('description') : '' }}</textarea>
                            @error('description', 'program')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-wrap items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" @click="achievementModal = false">Tutup</button>
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 text-white text-sm font-semibold hover:bg-purple-500 transition">Simpan Program</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


