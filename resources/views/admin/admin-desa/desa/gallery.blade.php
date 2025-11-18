@extends('layouts.admin')

@section('title', 'Galeri Desa')

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $formContext = old('form_context');
    $galleryCategoryOptions = $galleryCategories->pluck('name', 'id');
    $galleryErrors = $errors->getBag('gallery');
    $shouldOpenGalleryModal = session('open_gallery_modal') || (($formContext === 'gallery') && $galleryErrors->any());
    $defaultContentType = ($formContext === 'gallery' ? old('type') : null) ?? \App\Models\VillageGalleryItem::TYPE_PHOTO;
@endphp

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <div class="p-6 space-y-6" x-data="{
            galleryModal: {{ $shouldOpenGalleryModal ? 'true' : 'false' }},
            modalMode: 'upload', // 'upload' atau 'edit'

            // --- KONFIGURASI URL ---
            actionUrl: '{{ route('admin.desa-management.gallery.store') }}',
            updateUrlTemplate: '{{ route('admin.desa-management.gallery.update', 0) }}', // ID 0 dummy

            // --- STATE PREVIEW GAMBAR ---
            currentPreview: null,          // Untuk Media Utama
            currentThumbnailPreview: null, // Untuk Thumbnail

            // --- STATE INFO UPLOAD ---
            uploadInfo: { name: '', size: null },
            thumbnailUploadInfo: { name: '', size: null },

            // --- DATA FORM ---
            formData: {
                id: null,
                title: '{{ old('title') }}',
                description: '{{ old('description') }}',
                type: '{{ $defaultContentType }}',
                taken_at: '{{ old('taken_at') }}',
                media_url: '{{ old('media_url') }}',
                video_url: '{{ old('video_url') }}',
                category_id: '{{ old('category_id') }}',
                is_published: {{ old('is_published', 'true') == '1' ? 'true' : 'false' }}, 
                thumbnail_url: '{{ old('thumbnail_url') }}'
            },

            // --- HANDLER FILE ---
            handleFile(event) {
                const file = event.target.files?.[0];
                this.uploadInfo.name = file ? file.name : '';
                this.uploadInfo.size = file ? (file.size / 1024 / 1024).toFixed(2) : null;
            },

            handleThumbnailFile(event) {
                const file = event.target.files?.[0];
                this.thumbnailUploadInfo.name = file ? file.name : '';
                this.thumbnailUploadInfo.size = file ? (file.size / 1024 / 1024).toFixed(2) : null;
            },

            // --- LOGIKA MODAL ---
            openUploadModal() {
                this.modalMode = 'upload';
                this.actionUrl = '{{ route('admin.desa-management.gallery.store') }}';
                this.resetForm();
                this.galleryModal = true;
            },

            openEditModal(item) {
                this.modalMode = 'edit';

                // 1. Ganti URL Action (Replace ID 0 dengan ID asli)
                this.actionUrl = this.updateUrlTemplate.replace('/0', '/' + item.id);

                // 2. Isi Data Form Dasar
                this.formData.id = item.id;
                this.formData.title = item.title;
                this.formData.description = item.description || '';
                this.formData.type = item.type;
                this.formData.taken_at = item.taken_at ? item.taken_at.split('T')[0] : ''; 
                this.formData.category_id = item.category_id;
                this.formData.is_published = item.is_published == 1; 

                // 3. Logika Media Utama (URL vs File)
                this.formData.video_url = '';
                this.formData.media_url = '';
                this.currentPreview = null;

                if (item.type === 'video') {
                    this.formData.video_url = item.media_path; 
                } else {
                    // Cek apakah path di database berupa URL http
                    let isUrl = item.media_path && (item.media_path.startsWith('http') || item.media_path.startsWith('//'));

                    if (isUrl) {
                        this.formData.media_url = item.media_path;
                        this.currentPreview = item.media_path;
                    } else {
                        this.formData.media_url = '';
                        this.currentPreview = '/storage/' + item.media_path;
                    }
                }

                // 4. Logika Thumbnail (URL vs File)
                this.formData.thumbnail_url = '';
                this.currentThumbnailPreview = null;

                if (item.thumbnail_path) {
                    let isThumbUrl = item.thumbnail_path.startsWith('http') || item.thumbnail_path.startsWith('//');
                    if (isThumbUrl) {
                        this.formData.thumbnail_url = item.thumbnail_path;
                        this.currentThumbnailPreview = item.thumbnail_path;
                    } else {
                        this.formData.thumbnail_url = '';
                        this.currentThumbnailPreview = '/storage/' + item.thumbnail_path;
                    }
                }

                // Reset info upload baru
                this.uploadInfo = { name: '', size: null };
                this.thumbnailUploadInfo = { name: '', size: null };
                this.galleryModal = true;
            },
            deleteModal: false,
    deleteActionUrl: '',
    deleteUrlTemplate: '{{ route('admin.desa-management.gallery.destroy', 0) }}', // ID 0 dummy

    openDeleteModal(id) {
        // Ganti ID dummy 0 dengan ID asli item yang dipilih
        this.deleteActionUrl = this.deleteUrlTemplate.replace('/0', '/' + id);
        this.deleteModal = true;
    },

            resetForm() {
                this.formData = {
                    id: null, title: '', description: '', type: 'photo', taken_at: '',
                    media_url: '', video_url: '', category_id: '', is_published: true, thumbnail_url: ''
                };
                this.currentPreview = null;
                this.currentThumbnailPreview = null;
                this.uploadInfo = { name: '', size: null };
                this.thumbnailUploadInfo = { name: '', size: null };
                document.querySelectorAll('input[type=file]').forEach(el => el.value = '');
            }
        }" x-cloak>
        {{-- Notifikasi Sukses/Error --}}
        @if (session('success'))
            <div x-data="{ visible: true }" x-show="visible" x-transition
                class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex items-center justify-between shadow-sm mb-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-semibold">Berhasil</p>
                        <p class="text-xs">{{ session('success') }}</p>
                    </div>
                </div>
                <button class="text-xs text-emerald-600 hover:text-emerald-500" @click="visible = false">Tutup</button>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ visible: true }" x-show="visible" x-transition
                class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl flex items-center justify-between shadow-sm mb-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-rose-100 text-rose-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-semibold">Gagal Mengunggah</p>
                        <p class="text-xs">{{ session('error') }}</p>
                    </div>
                </div>
                <button class="text-xs text-rose-600 hover:text-rose-500" @click="visible = false">Tutup</button>
            </div>
        @endif

        {{-- Header Halaman --}}
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('admin.desa-management.index') }}" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <p class="text-xs uppercase tracking-[0.3em] text-rose-500 font-semibold">Galeri Desa</p>
                </div>
                <h1 class="text-3xl font-semibold text-gray-900">Dokumentasi Foto & Video</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola dokumentasi kegiatan desa dalam bentuk foto dan video.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('desa.galeri-wisata.index') }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-rose-600 bg-rose-50 rounded-xl hover:bg-rose-100 transition">
                    Lihat Website
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>
                <button type="button" @click="openUploadModal()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-rose-500 rounded-xl hover:bg-rose-400 transition">
                    Upload Konten
                </button>
            </div>
        </div>

        {{-- Grid Kategori & Item --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-6">
            @forelse($galleryCategories as $category)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
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
                        <p class="text-sm text-gray-500 mt-3 line-clamp-2">{{ $category->description }}</p>
                    </div>

                    {{-- List Item --}}
                    <div class="grid grid-cols-2 gap-3 px-6 pb-6 flex-1 content-start">
                        @forelse($category->items as $item)
                            @php
                                // Logika Thumbnail PHP untuk tampilan awal
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
                            <div class="rounded-xl overflow-hidden border border-gray-100 group relative">
                                <div class="relative aspect-[4/3]">
                                    <img src="{{ $thumbPath }}" alt="{{ $item->title }}" class="w-full h-full object-cover">

                                    {{-- Overlay Edit --}}
                                    <div
                                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                                        <button type="button" @click="openEditModal({{ $item->toJson() }})"
                                            class="p-2 bg-white rounded-full text-gray-700 hover:text-rose-500 transition shadow-sm transform hover:scale-110"
                                            title="Edit Item">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button type="button" 
        @click="openDeleteModal({{ $item->id }})"
        class="p-2 bg-white rounded-full text-gray-700 hover:text-rose-600 transition shadow-sm transform hover:scale-110"
        title="Hapus Item">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
    </button>
                                    </div>
                                    <span
                                        class="absolute top-3 right-3 inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-white/90 text-gray-800 shadow-sm">
                                        {{ $item->type }}
                                    </span>
                                </div>
                                <div class="px-3 py-2 bg-gray-50/50">
                                    <p class="text-sm font-semibold text-gray-900 line-clamp-1" title="{{ $item->title }}">
                                        {{ $item->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $displayDate }}</p>
                                </div>
                            </div>
                        @empty
                            <div
                                class="col-span-2 flex flex-col items-center justify-center text-sm text-gray-400 italics py-8 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <span class="text-2xl mb-2">📷</span>
                                Belum ada konten.
                            </div>
                        @endforelse
                    </div>
                    <div class="px-6 pb-6 text-center mt-auto">
                        <p class="text-xs text-gray-400">Gunakan tombol "Upload Konten" untuk menambah.</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="border border-dashed border-rose-200 rounded-3xl py-16 text-center bg-rose-50/30">
                        <h3 class="text-lg font-semibold text-rose-500">Belum ada konten galeri</h3>
                        <p class="text-sm text-gray-500 mt-2">Klik tombol <strong>Upload Konten</strong> untuk mulai menambahkan
                            dokumentasi.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- MODAL --}}
        <div x-show="galleryModal" x-transition.opacity x-trap="galleryModal" @keydown.escape.window="galleryModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8" style="display: none;">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="galleryModal = false"></div>

            <div
                class="relative w-full max-w-4xl lg:max-w-5xl bg-white rounded-[32px] shadow-2xl max-h-[90vh] overflow-hidden flex flex-col">

                {{-- Modal Header --}}
                <div
                    class="shrink-0 flex items-start justify-between gap-6 px-6 sm:px-10 py-6 bg-white/95 backdrop-blur border-b border-gray-100 z-10">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-rose-500">Galeri Desa</p>
                        <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mt-2"
                            x-text="modalMode === 'upload' ? 'Upload Foto & Video' : 'Edit Konten'">
                        </h3>
                        <p class="text-sm text-gray-500 mt-1"
                            x-text="modalMode === 'upload' ? 'Pastikan konten visual memiliki informasi yang lengkap.' : 'Perbarui informasi konten galeri ini.'">
                        </p>
                    </div>
                    <button type="button"
                        class="text-gray-400 hover:text-gray-600 transition p-2 hover:bg-gray-100 rounded-full"
                        @click="galleryModal = false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                {{-- Modal Content (Scrollable) --}}
                <div class="overflow-y-auto flex-1">
                    <form method="POST" enctype="multipart/form-data"
                        class="px-6 sm:px-10 py-8 space-y-8 bg-slate-50/60 h-full" :action="actionUrl">
                        @csrf

                        {{-- METHOD SPOOFING: Jika mode Edit, kirim PUT. Jika Upload, kirim POST (default form) --}}
                        <input type="hidden" name="_method" :value="modalMode === 'edit' ? 'PUT' : 'POST'">
                        <input type="hidden" name="form_context" value="gallery">

                        @if ($galleryErrors->any())
                            <div
                                class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl text-sm shadow-sm">
                                <p class="font-semibold mb-1">Periksa kembali formulir:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($galleryErrors->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                            {{-- KOLOM KIRI --}}
                            <section class="space-y-5">
                                <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-2 shadow-sm">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-rose-500">Informasi
                                        Konten</p>
                                    <h4 class="text-lg font-semibold text-gray-900">Detail Media</h4>
                                    <p class="text-sm text-gray-500">Isi informasi dasar agar konten mudah dikenali
                                        pengunjung.</p>
                                </div>

                                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm space-y-4">
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700">Judul
                                            Konten <span class="text-rose-500">*</span></label>
                                        <input type="text" name="title" x-model="formData.title"
                                            class="mt-2 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500 placeholder:text-sm"
                                            placeholder="Contoh: Festival Panen Raya 2025" />
                                        @error('title', 'gallery') <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700">Deskripsi
                                            <span class="text-xs font-normal text-gray-400">(opsional)</span></label>
                                        <textarea name="description" rows="3" x-model="formData.description"
                                            class="mt-2 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500"
                                            placeholder="Ceritakan singkat mengenai kegiatan atau momen"></textarea>
                                        @error('description', 'gallery') <p class="text-xs text-red-500 mt-1">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700">Jenis
                                                Konten</label>
                                            <div class="mt-2 grid grid-cols-2 gap-2">
                                                <label
                                                    class="flex items-center gap-2 rounded-xl border px-3 py-2 cursor-pointer text-sm font-medium transition"
                                                    :class="formData.type === 'photo' ? 'border-rose-500 bg-rose-50 text-rose-600' : 'border-gray-200 text-gray-600 hover:border-gray-300'">
                                                    <input type="radio" name="type" value="photo" class="hidden"
                                                        x-model="formData.type">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <span>Foto</span>
                                                </label>
                                                <label
                                                    class="flex items-center gap-2 rounded-xl border px-3 py-2 cursor-pointer text-sm font-medium transition"
                                                    :class="formData.type === 'video' ? 'border-rose-500 bg-rose-50 text-rose-600' : 'border-gray-200 text-gray-600 hover:border-gray-300'">
                                                    <input type="radio" name="type" value="video" class="hidden"
                                                        x-model="formData.type">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <span>Video</span>
                                                </label>
                                            </div>
                                            @error('type', 'gallery') <p class="text-xs text-red-500 mt-1">{{ $message }}
                                            </p> @enderror
                                        </div>

                                        <div>
                                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700">Tanggal
                                                Dokumentasi</label>
                                            <input type="date" name="taken_at" x-model="formData.taken_at"
                                                class="mt-2 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" />
                                            @error('taken_at', 'gallery') <p class="text-xs text-red-500 mt-1">
                                            {{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Media Utama</p>
                                            <p class="text-xs text-gray-500">Unggah file berkualitas tinggi agar tampilan
                                                optimal.</p>
                                        </div>
                                        <span
                                            class="text-[10px] font-bold text-rose-500 bg-rose-50 px-3 py-1 rounded-full">WAJIB</span>
                                    </div>

                                    {{-- INPUT FOTO --}}
                                    <div x-show="formData.type === 'photo'">

                                        {{-- Preview Foto Saat Ini (Hanya di Mode Edit & Jika File Lokal) --}}
                                        <div x-show="modalMode === 'edit' && currentPreview"
                                            class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                            <p class="text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wide">File
                                                Saat Ini:</p>
                                            <div
                                                class="relative w-40 aspect-[4/3] rounded-lg overflow-hidden border border-gray-200 shadow-sm group">
                                                <img :src="currentPreview" class="w-full h-full object-cover bg-white">
                                            </div>
                                            <p class="text-[11px] text-gray-400 mt-2">Upload file baru di bawah untuk
                                                mengganti foto ini.</p>
                                        </div>

                                        <div class="border-2 border-dashed border-rose-200 rounded-2xl bg-white/80">
                                            <label
                                                class="flex flex-col items-center justify-center text-center px-6 py-8 cursor-pointer hover:bg-rose-50 transition">
                                                <svg class="w-10 h-10 text-rose-500 mb-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 15a4 4 0 004 4h10a4 4 0 004-4M7 10l5-5m0 0l5 5m-5-5v12">
                                                    </path>
                                                </svg>
                                                <p class="text-sm font-semibold text-gray-800">Tarik & lepas foto</p>
                                                <p class="text-xs text-gray-500 mt-1">Atau <span class="text-rose-500">klik
                                                        untuk pilih dari perangkat</span></p>
                                                <p class="text-xs text-gray-400 mt-2">Format JPG, PNG, GIF — maks. 6MB</p>
                                                <input type="file" name="media_file" accept="image/*" class="hidden"
                                                    @change="handleFile">
                                            </label>
                                        </div>

                                        <div x-show="uploadInfo.name"
                                            class="mt-2 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm text-gray-700 flex justify-between items-center">
                                            <span class="font-semibold line-clamp-1" x-text="uploadInfo.name"></span>
                                            <span class="text-xs text-gray-500 shrink-0"
                                                x-text="uploadInfo.size ? uploadInfo.size + ' MB' : ''"></span>
                                        </div>
                                        @error('media_file', 'gallery') <p class="text-xs text-red-500 mt-1">{{ $message }}
                                        </p> @enderror

                                        <div class="mt-4 space-y-2 border-t border-gray-100 pt-4">
                                            <label class="text-sm font-medium text-gray-700">Atau Gunakan Link (URL)</label>
                                            <input type="url" name="media_url" x-model="formData.media_url"
                                                placeholder="https://example.com/image.jpg"
                                                class="w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" />
                                            <p class="text-xs text-gray-400">Isi ini jika gambar berasal dari website lain
                                                (bukan upload).</p>
                                            @error('media_url', 'gallery') <p class="text-xs text-red-500 mt-1">
                                            {{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    {{-- INPUT VIDEO --}}
                                    <div x-show="formData.type === 'video'" class="space-y-2">
                                        <label class="text-sm font-medium text-gray-700">URL Video (YouTube / Vimeo) <span
                                                class="text-rose-500">*</span></label>
                                        <input type="url" name="video_url" x-model="formData.video_url"
                                            placeholder="https://youtube.com/watch?v=..."
                                            class="w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500"
                                            :required="formData.type === 'video'" />
                                        <p class="text-xs text-gray-500">Tempelkan tautan video; tidak perlu mengunggah file
                                            video.</p>
                                        @error('video_url', 'gallery') <p class="text-xs text-red-500 mt-1">{{ $message }}
                                        </p> @enderror
                                    </div>
                                </div>
                            </section>

                            {{-- KOLOM KANAN --}}
                            <section class="space-y-5">
                                <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-2 shadow-sm">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-rose-500">
                                        Kategorisasi</p>
                                    <h4 class="text-lg font-semibold text-gray-900">Pengelompokan Konten</h4>
                                    <p class="text-sm text-gray-500">Tentukan kategori agar konten mudah ditemukan.</p>
                                </div>

                                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-700">Pilih Kategori</label>
                                        <select name="category_id" x-model="formData.category_id"
                                            class="mt-2 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($galleryCategoryOptions as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id', 'gallery') <p class="text-xs text-red-500 mt-1">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    <div class="border-t border-dashed border-gray-200 pt-4 space-y-3"
                                        x-show="modalMode === 'upload'">
                                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Atau buat
                                            kategori baru</p>
                                        <div>
                                            <label class="text-sm font-medium text-gray-700">Nama Kategori Baru</label>
                                            <input type="text" name="new_category_name"
                                                value="{{ $formContext === 'gallery' ? old('new_category_name') : '' }}"
                                                class="mt-2 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500"
                                                placeholder="Contoh: Infrastruktur, Karang Taruna" />
                                            @error('new_category_name', 'gallery') <p class="text-xs text-red-500 mt-1">
                                            {{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-gray-700">Deskripsi Kategori</label>
                                            <textarea name="new_category_description" rows="3"
                                                class="mt-2 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500"
                                                placeholder="Jelaskan tujuan kategori baru">{{ $formContext === 'gallery' ? old('new_category_description') : '' }}</textarea>
                                            @error('new_category_description', 'gallery') <p
                                            class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Thumbnail (Opsional)</p>
                                            <p class="text-xs text-gray-500">Khusus video atau jika ingin cover berbeda.</p>
                                        </div>
                                    </div>

                                    {{-- Preview Thumbnail Saat Ini (Hanya di Mode Edit) --}}
                                    <div x-show="modalMode === 'edit' && currentThumbnailPreview"
                                        class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                        <p class="text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wide">
                                            Thumbnail Saat Ini:</p>
                                        <div
                                            class="relative w-40 aspect-[4/3] rounded-lg overflow-hidden border border-gray-200 shadow-sm group">
                                            <img :src="currentThumbnailPreview" class="w-full h-full object-cover bg-white">
                                        </div>
                                        <p class="text-[11px] text-gray-400 mt-2">Upload file baru di bawah untuk mengganti
                                            thumbnail ini.</p>
                                    </div>

                                    {{-- Upload Box (Dashed) --}}
                                    <div class="border-2 border-dashed border-rose-200 rounded-2xl bg-white/80">
                                        <label
                                            class="flex flex-col items-center justify-center text-center px-6 py-8 cursor-pointer hover:bg-rose-50 transition">
                                            <svg class="w-10 h-10 text-rose-500 mb-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <p class="text-sm font-semibold text-gray-800">Tarik & lepas thumbnail</p>
                                            <p class="text-xs text-gray-500 mt-1">Atau <span class="text-rose-500">klik
                                                    untuk pilih dari perangkat</span></p>
                                            <p class="text-xs text-gray-400 mt-2">Format JPG, PNG — maks. 5MB</p>

                                            {{-- Perhatikan nama fungsi handler di sini --}}
                                            <input type="file" name="thumbnail_file" accept="image/*" class="hidden"
                                                @change="handleThumbnailFile">
                                        </label>
                                    </div>

                                    {{-- Info File yang Baru Diupload --}}
                                    <div x-show="thumbnailUploadInfo.name"
                                        class="mt-2 rounded-xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm text-gray-700 flex justify-between items-center">
                                        <span class="font-semibold line-clamp-1" x-text="thumbnailUploadInfo.name"></span>
                                        <span class="text-xs text-gray-500 shrink-0"
                                            x-text="thumbnailUploadInfo.size ? thumbnailUploadInfo.size + ' MB' : ''"></span>
                                    </div>
                                    @error('thumbnail_file', 'gallery') <p class="text-xs text-red-500 mt-1">{{ $message }}
                                    </p> @enderror

                                    {{-- Input URL Alternatif --}}
                                    <div class="mt-4 space-y-2 border-t border-gray-100 pt-4">
                                        <label class="text-sm font-medium text-gray-700">Atau Gunakan Link (URL)</label>
                                        <input type="url" name="thumbnail_url" x-model="formData.thumbnail_url"
                                            placeholder="https://example.com/thumb.jpg"
                                            class="w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" />
                                        <p class="text-xs text-gray-400">Isi ini jika thumbnail berasal dari website lain
                                            (bukan upload).</p>
                                        @error('thumbnail_url', 'gallery') <p class="text-xs text-red-500 mt-1">
                                        {{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                                    <input type="hidden" name="is_published" value="0">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" name="is_published" id="gallery_is_published" value="1"
                                            x-model="formData.is_published"
                                            class="rounded border-gray-300 text-rose-500 focus:ring-rose-500 h-5 w-5">
                                        <label for="gallery_is_published" class="text-sm text-gray-700">Langsung tampil di
                                            website desa</label>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Nonaktifkan jika ingin meninjau terlebih dahulu
                                        sebelum tayang.</p>
                                </div>
                            </section>
                        </div>

                        {{-- Footer Modal (Sticky Bottom) --}}
                        <div
                            class="flex flex-wrap items-center justify-end gap-3 sticky bottom-0 pt-4 border-t border-gray-100 bg-white pb-2">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700"
                                @click="galleryModal = false">Batal</button>
                            <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-rose-500 text-white text-sm font-semibold hover:bg-rose-400 transition shadow-md hover:shadow-lg transform active:scale-95"
                                x-text="modalMode === 'upload' ? 'Simpan Konten' : 'Perbarui Konten'">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div x-show="deleteModal" x-trap="deleteModal" class="fixed inset-0 z-[60] flex items-center justify-center px-4 py-8" style="display: none;">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="deleteModal = false"></div>

        {{-- Modal Panel --}}
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden p-6 text-center" @click.away="deleteModal = false">
            
            {{-- Ikon Sampah --}}
            <div class="w-16 h-16 bg-rose-100 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>

            <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Item Galeri?</h3>
            <p class="text-sm text-gray-500 mb-6">
                Apakah Anda yakin ingin menghapus item ini? <br>
                Tindakan ini tidak dapat dibatalkan.
            </p>

            {{-- FORM DELETE SINGLE SHARED --}}
            <form :action="deleteActionUrl" method="POST" class="flex gap-3 justify-center">
                @csrf
                @method('DELETE')
                
                <button type="button" @click="deleteModal = false" class="px-5 py-2.5 rounded-xl text-gray-600 bg-gray-100 font-semibold hover:bg-gray-200 transition">
                    Batal
                </button>
                
                <button type="submit" class="px-5 py-2.5 rounded-xl text-white bg-rose-600 font-semibold hover:bg-rose-700 transition shadow-lg shadow-rose-200">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
    </div>
@endsection