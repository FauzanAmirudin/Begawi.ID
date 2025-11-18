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
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div
    class="p-6 space-y-6"
    x-data="{
        galleryModal: {{ $shouldOpenGalleryModal ? 'true' : 'false' }},
        contentType: '{{ $defaultContentType }}',
        uploadInfo: { name: '', size: null },
        handleFile(event) {
            const file = event.target.files?.[0];
            this.uploadInfo.name = file ? file.name : '';
            this.uploadInfo.size = file ? (file.size / 1024 / 1024).toFixed(2) : null;
        }
    }"
    x-cloak
>
    @if (session('success'))
    <div x-data="{ visible: true }" x-show="visible" x-transition class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex items-center justify-between shadow-sm">
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
    <div x-data="{ visible: true }" x-show="visible" x-transition class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-rose-100 text-rose-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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

    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.desa-management.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <p class="text-xs uppercase tracking-[0.3em] text-rose-500 font-semibold">Galeri Desa</p>
            </div>
            <h1 class="text-3xl font-semibold text-gray-900">Dokumentasi Foto & Video Kegiatan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelompokkan dokumentasi galeri berdasarkan kategori acara, pembangunan, dan sosial.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('desa.galeri-wisata.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-rose-600 bg-rose-50 rounded-xl hover:bg-rose-100 transition">
                Lihat Halaman Galeri
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <button type="button" @click="galleryModal = true" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-rose-500 rounded-xl hover:bg-rose-400 transition">
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
                <form action="{{ route('admin.desa-management.gallery.store') }}" method="POST" enctype="multipart/form-data" class="px-6 sm:px-10 py-8 space-y-8 bg-slate-50/60">
                    @csrf
                    <input type="hidden" name="form_context" value="gallery">
                    @if ($galleryErrors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl text-sm shadow-sm">
                        <p class="font-semibold mb-1">Periksa kembali formulir:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($galleryErrors->all() as $message)
                            <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <section class="space-y-5">
                            <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-2 shadow-sm">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-rose-500">Informasi Konten</p>
                                <h4 class="text-lg font-semibold text-gray-900">Detail Media</h4>
                                <p class="text-sm text-gray-500">Isi informasi dasar agar konten mudah dikenali pengunjung.</p>
                            </div>
                            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm space-y-4">
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700">Judul Konten <span class="text-rose-500">*</span></label>
                                    <input type="text" name="title" value="{{ $formContext === 'gallery' ? old('title') : '' }}" class="mt-2 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500 placeholder:text-sm" placeholder="Contoh: Festival Panen Raya 2025" />
                                    @error('title', 'gallery')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700">Deskripsi <span class="text-xs font-normal text-gray-400">(opsional)</span></label>
                                    <textarea name="description" rows="3" class="mt-2 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" placeholder="Ceritakan singkat mengenai kegiatan atau momen">{{ $formContext === 'gallery' ? old('description') : '' }}</textarea>
                                    @error('description', 'gallery')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700">Jenis Konten</label>
                                        <div class="mt-2 grid grid-cols-2 gap-2">
                                            @foreach([\App\Models\VillageGalleryItem::TYPE_PHOTO => 'Foto', \App\Models\VillageGalleryItem::TYPE_VIDEO => 'Video'] as $key => $label)
                                            <label class="flex items-center gap-2 rounded-xl border px-3 py-2 cursor-pointer text-sm font-medium"
                                                :class="contentType === '{{ $key }}' ? 'border-rose-500 bg-rose-50 text-rose-600' : 'border-gray-200 text-gray-600'">
                                                <input type="radio" name="type" value="{{ $key }}" class="hidden" x-model="contentType">
                                                <span>{{ $label }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                        @error('type', 'gallery')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700">Tanggal Dokumentasi</label>
                                        <input type="date" name="taken_at" value="{{ $formContext === 'gallery' ? old('taken_at') : '' }}" class="mt-2 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" />
                                        @error('taken_at', 'gallery')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Media Utama</p>
                                        <p class="text-xs text-gray-500">Unggah file berkualitas tinggi agar tampilan optimal.</p>
                                    </div>
                                    <span class="text-[11px] font-semibold text-rose-500 bg-rose-50 px-3 py-1 rounded-full">Wajib</span>
                                </div>
                                <div class="border-2 border-dashed border-rose-200 rounded-2xl bg-white/80" x-show="contentType === 'photo'">
                                    <label class="flex flex-col items-center justify-center text-center px-6 py-8 cursor-pointer hover:bg-rose-50 transition">
                                        <svg class="w-10 h-10 text-rose-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h10a4 4 0 004-4M7 10l5-5m0 0l5 5m-5-5v12"></path>
                                        </svg>
                                        <p class="text-sm font-semibold text-gray-800">Tarik & lepas foto</p>
                                        <p class="text-xs text-gray-500 mt-1">Atau <span class="text-rose-500">klik untuk pilih dari perangkat</span></p>
                                        <p class="text-xs text-gray-400 mt-2">Format JPG, PNG, GIF — maks. 6MB</p>
                                        <input type="file" name="media_file" accept="image/*" class="hidden" @change="handleFile" x-show="contentType === 'photo'">
                                    </label>
                                </div>
                                <div x-show="uploadInfo.name" class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                                    <p class="font-semibold" x-text="uploadInfo.name"></p>
                                    <p class="text-xs text-gray-500" x-text="uploadInfo.size ? uploadInfo.size + ' MB' : ''"></p>
                                </div>
                                @error('media_file', 'gallery')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror

                                <div x-show="contentType === 'photo'" class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Atau URL Foto</label>
                                    <input type="url" name="media_url" value="{{ $formContext === 'gallery' ? old('media_url') : '' }}" placeholder="https://example.com/image.jpg" class="w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" />
                                    <p class="text-xs text-gray-500">Gunakan jika file sudah tersimpan di layanan lain.</p>
                                    @error('media_url', 'gallery')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div x-show="contentType === 'video'" class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">URL Video (YouTube / Vimeo) <span class="text-rose-500">*</span></label>
                                    <input type="url" name="video_url" value="{{ $formContext === 'gallery' ? old('video_url') : '' }}" placeholder="https://youtube.com/watch?v=..." class="w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" :required="contentType === 'video'" />
                                    <p class="text-xs text-gray-500">Tempelkan tautan video; tidak perlu mengunggah file video.</p>
                                    @error('video_url', 'gallery')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>
                        <section class="space-y-5">
                            <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-2 shadow-sm">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-rose-500">Kategorisasi</p>
                                <h4 class="text-lg font-semibold text-gray-900">Pengelompokan Konten</h4>
                                <p class="text-sm text-gray-500">Tentukan kategori agar konten mudah ditemukan.</p>
                            </div>
                            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Pilih Kategori</label>
                                    <select name="category_id" class="mt-2 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($galleryCategoryOptions as $id => $name)
                                        <option value="{{ $id }}" {{ ($formContext === 'gallery' ? old('category_id') : null) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id', 'gallery')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="border-t border-dashed border-gray-200 pt-4 space-y-3">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Atau buat kategori baru</p>
                                    <div>
                                        <label class="text-sm font-medium text-gray-700">Nama Kategori Baru</label>
                                        <input type="text" name="new_category_name" value="{{ $formContext === 'gallery' ? old('new_category_name') : '' }}" class="mt-2 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" placeholder="Contoh: Infrastruktur, Karang Taruna" />
                                        @error('new_category_name', 'gallery')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-700">Deskripsi Kategori</label>
                                        <textarea name="new_category_description" rows="3" class="mt-2 w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" placeholder="Jelaskan tujuan kategori baru">{{ $formContext === 'gallery' ? old('new_category_description') : '' }}</textarea>
                                        @error('new_category_description', 'gallery')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Thumbnail (Opsional)</p>
                                        <p class="text-xs text-gray-500">Gunakan thumbnail khusus untuk video atau foto kolase.</p>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <input type="file" name="thumbnail_file" class="w-full text-sm text-gray-600 file:rounded-lg file:border-0 file:bg-rose-50 file:text-rose-600 file:font-semibold hover:file:bg-rose-100" accept="image/*">
                                    @error('thumbnail_file', 'gallery')
                                    <p class="text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                    <input type="url" name="thumbnail_url" value="{{ $formContext === 'gallery' ? old('thumbnail_url') : '' }}" placeholder="URL Thumbnail" class="w-full rounded-xl border-gray-200 focus:border-rose-500 focus:ring-rose-500" />
                                    @error('thumbnail_url', 'gallery')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                                <input type="hidden" name="is_published" value="0">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_published" id="gallery_is_published" value="1" class="rounded border-gray-300 text-rose-500 focus:ring-rose-500 h-5 w-5" {{ ($formContext === 'gallery' ? old('is_published', true) : true) ? 'checked' : '' }}>
                                    <label for="gallery_is_published" class="text-sm text-gray-700">Langsung tampil di website desa</label>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Nonaktifkan jika ingin meninjau terlebih dahulu sebelum tayang.</p>
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
</div>
@endsection

