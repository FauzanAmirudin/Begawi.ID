@extends('layouts.admin')

@section('title', 'Artikel Baru')

@section('content')
<div class="p-6">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Support &amp; Pengaduan</p>
                <h1 class="text-2xl font-semibold text-gray-900">Artikel Baru</h1>
                <p class="text-sm text-gray-500">Tuliskan panduan teknis agar tenant lebih cepat menyelesaikan kendala.</p>
            </div>
            <a href="{{ route('admin.support.articles.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:border-gray-300 transition">
                Kembali ke daftar
            </a>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <form action="{{ route('admin.support.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Judul Artikel</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="mt-2 w-full bg-gray-100 border-0 rounded-lg text-sm text-gray-700 px-3 py-2 focus:bg-white focus:ring-2 focus:ring-purple-500" placeholder="Contoh: Panduan Integrasi Domain Mandiri">
                            @error('title')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Ringkasan Singkat</label>
                            <textarea name="excerpt" rows="3" class="mt-2 w-full bg-gray-100 border-0 rounded-lg text-sm text-gray-700 px-3 py-2 focus:bg-white focus:ring-2 focus:ring-purple-500" placeholder="Ringkasan yang membantu tenant memahami isi artikel...">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Konten</label>
                            <textarea name="content" rows="16" class="mt-2 w-full bg-gray-100 border-0 rounded-xl text-sm text-gray-700 px-3 py-3 focus:bg-white focus:ring-2 focus:ring-purple-500" placeholder="Gunakan struktur langkah, sertakan catatan penting, dan jelaskan dampak.">{{ old('content') }}</textarea>
                            @error('content')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="border border-gray-100 rounded-xl p-4">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori</label>
                            <select name="category" class="mt-2 w-full bg-gray-100 border-0 text-sm text-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="">Pilih kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="border border-gray-100 rounded-xl p-4 space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">Publikasikan artikel</p>
                                    <p class="text-xs text-gray-500">Artikel akan tersedia di pusat bantuan</p>
                                </div>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_published" value="1" class="sr-only" {{ old('is_published', true) ? 'checked' : '' }}>
                                    <span class="w-10 h-5 bg-gray-200 rounded-full shadow-inner relative transition">
                                        <span class="absolute left-1 top-1 w-3 h-3 bg-white rounded-full shadow transition {{ old('is_published', true) ? 'translate-x-5 bg-purple-500' : '' }}"></span>
                                    </span>
                                </label>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal Publikasi (opsional)</label>
                                <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="mt-2 w-full bg-gray-100 border-0 text-sm text-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500">
                                @error('published_at')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="border border-gray-100 rounded-xl p-4">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Gambar Sampul</label>
                            <input type="file" name="featured_image" class="mt-2 block w-full text-sm text-gray-500 border border-dashed border-gray-300 rounded-lg px-3 py-2 cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG (maks 2MB)</p>
                            @error('featured_image')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.support.articles.index') }}" class="px-4 py-2 bg-gray-100 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:opacity-90 transition">
                        Simpan Artikel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

