@extends('layouts.admin')

@section('title', 'Berita & Agenda')

@php
    $formContext = old('form_context');
@endphp

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-data="{ 
    newsModal: false, 
    editingNewsId: null,
    editingNews: null,
    openEditModal(news) {
        this.editingNewsId = news.id;
        this.editingNews = {
            id: news.id,
            title: news.title,
            category: news.category || '',
            writer: news.writer || '',
            summary: news.summary || '',
            content: news.content || '',
            status: news.status,
            published_at: news.published_at ? new Date(news.published_at).toISOString().split('T')[0] : '',
            is_featured: news.is_featured || false,
            featured_image_url: news.featured_image ? '{{ url("storage") }}/' + news.featured_image : null
        };
        this.newsModal = true;
    },
    openCreateModal() {
        this.editingNewsId = null;
        this.editingNews = null;
        this.newsModal = true;
    },
    closeModal() {
        this.newsModal = false;
        this.editingNewsId = null;
        this.editingNews = null;
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
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.desa-management.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 font-semibold">Berita & Agenda</p>
            </div>
            <h1 class="text-3xl font-semibold text-gray-900">Kelola Berita, Pengumuman, dan Agenda Kegiatan</h1>
            <p class="text-sm text-gray-500 mt-1">Publikasikan berita penting, atur jadwal agenda, dan kontrol status publish / draft.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('desa.berita.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition">
                Lihat Halaman Berita
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="{{ route('admin.desa-management.agendas') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition">
                Kelola Agenda
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </a>
            <button type="button" @click="openCreateModal()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-500 transition">
                Tambah Berita
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Berita Aktif</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $news->count() }} berita dipublikasikan</p>
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
                                    <a href="{{ route('desa.berita.detail', $item->slug) }}" target="_blank" class="text-emerald-600 hover:text-emerald-900" title="Lihat">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <button type="button" @click="openEditModal(@js([
                                        'id' => $item->id,
                                        'title' => $item->title,
                                        'category' => $item->category,
                                        'writer' => $item->writer,
                                        'summary' => $item->summary,
                                        'content' => $item->content,
                                        'status' => $item->status,
                                        'published_at' => $item->published_at?->toIso8601String(),
                                        'is_featured' => $item->is_featured,
                                        'featured_image' => $item->featured_image,
                                    ]))" class="text-blue-600 hover:text-blue-900" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.desa-management.news.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
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

    <!-- News Modal -->
    <div
        x-show="newsModal"
        x-transition.opacity
        x-trap="newsModal"
        @keydown.escape.window="closeModal()"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeModal()"></div>
        <div class="relative w-full max-w-4xl lg:max-w-5xl bg-white rounded-[32px] shadow-2xl max-h-[90vh] overflow-hidden">
            <div class="sticky top-0 flex items-start justify-between gap-6 px-6 sm:px-10 py-6 bg-white/95 backdrop-blur border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-indigo-500">Konten Berita</p>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mt-2" x-text="editingNewsId ? 'Edit Berita' : 'Tambah Berita Baru'"></h3>
                    <p class="text-sm text-gray-500 mt-1">Isi informasi lengkap agar berita tampil maksimal pada halaman publik.</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600" @click="closeModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto max-h-[calc(90vh-160px)]">
                <form :action="editingNewsId ? '{{ route('admin.desa-management.news.update', ':id') }}'.replace(':id', editingNewsId) : '{{ route('admin.desa-management.news.store') }}'" method="POST" enctype="multipart/form-data" class="px-6 sm:px-10 py-6 space-y-8">
                    @csrf
                    <input type="hidden" name="_method" :value="editingNewsId ? 'PUT' : 'POST'">
                    <input type="hidden" name="form_context" value="news">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <section class="space-y-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-indigo-500">Informasi Utama</p>
                                <h4 class="text-lg font-semibold text-gray-900 mt-1">Detail Berita</h4>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul Berita</label>
                                <input type="text" name="title" :value="editingNews ? editingNews.title : '{{ $formContext === 'news' ? old('title') : '' }}'" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />
                                @error('title', 'news')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <input type="text" name="category" :value="editingNews ? editingNews.category : '{{ $formContext === 'news' ? old('category') : '' }}'" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />
                                    @error('category', 'news')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Penulis</label>
                                    <input type="text" name="writer" :value="editingNews ? editingNews.writer : '{{ $formContext === 'news' ? old('writer', auth()->user()->name ?? 'Admin Desa') : (auth()->user()->name ?? 'Admin Desa') }}'" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />
                                    @error('writer', 'news')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach(['draft' => 'Draft', 'published' => 'Publish', 'archived' => 'Arsip'] as $value => $label)
                                        <option :value="'{{ $value }}'" :selected="editingNews ? editingNews.status === '{{ $value }}' : {{ ($formContext === 'news' ? old('status') : null) === $value ? 'true' : 'false' }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('status', 'news')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Publikasi</label>
                                    <input type="date" name="published_at" :value="editingNews ? editingNews.published_at : '{{ $formContext === 'news' ? old('published_at') : '' }}'" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />
                                    @error('published_at', 'news')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="is_featured" id="is_featured" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" :checked="editingNews ? editingNews.is_featured : {{ ($formContext === 'news' ? old('is_featured') : false) ? 'true' : 'false' }}">
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
                                <textarea name="summary" rows="3" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" x-bind:value="editingNews ? editingNews.summary : ''">{{ $formContext === 'news' ? old('summary') : '' }}</textarea>
                                @error('summary', 'news')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Konten Lengkap</label>
                                <textarea name="content" rows="6" class="mt-1 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" x-bind:value="editingNews ? editingNews.content : ''">{{ $formContext === 'news' ? old('content') : '' }}</textarea>
                                @error('content', 'news')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gambar Utama</label>
                                <template x-if="editingNews && editingNews.featured_image_url">
                                    <div class="mb-2">
                                        <img :src="editingNews.featured_image_url" alt="Current image" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                        <p class="text-xs text-gray-500 mt-1">Gambar saat ini (pilih file baru untuk mengganti)</p>
                                    </div>
                                </template>
                                <input type="file" name="featured_image" accept="image/*" class="mt-2 w-full text-sm">
                                @error('featured_image', 'news')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </section>
                    </div>
                    <div class="flex flex-wrap items-center justify-end gap-3 sticky bottom-0 pt-4 border-t border-gray-100 bg-white">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" @click="closeModal()">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-500 transition" x-text="editingNewsId ? 'Simpan Perubahan' : 'Publikasikan'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

