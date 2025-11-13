@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="p-6">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Support &amp; Pengaduan</p>
                <h1 class="text-2xl font-semibold text-gray-900">Edit Artikel</h1>
                <p class="text-sm text-gray-500">Perbarui konten agar panduan selalu relevan untuk tenant.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.support.documentation.show', $article->slug) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:border-gray-300 transition">
                    Pratinjau
                </a>
                <a href="{{ route('admin.support.articles.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:border-gray-300 transition">
                    Kembali ke daftar
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-100 text-sm text-emerald-700 rounded-xl">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <form action="{{ route('admin.support.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Judul Artikel</label>
                            <input type="text" name="title" value="{{ old('title', $article->title) }}" class="mt-2 w-full bg-gray-100 border-0 rounded-lg text-sm text-gray-700 px-3 py-2 focus:bg-white focus:ring-2 focus:ring-purple-500">
                            @error('title')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Ringkasan Singkat</label>
                            <textarea name="excerpt" rows="3" class="mt-2 w-full bg-gray-100 border-0 rounded-lg text-sm text-gray-700 px-3 py-2 focus:bg-white focus:ring-2 focus:ring-purple-500">{{ old('excerpt', $article->excerpt) }}</textarea>
                            @error('excerpt')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Konten</label>
                            <textarea name="content" rows="16" class="mt-2 w-full bg-gray-100 border-0 rounded-xl text-sm text-gray-700 px-3 py-3 focus:bg-white focus:ring-2 focus:ring-purple-500">{{ old('content', $article->content) }}</textarea>
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
                                <option value="{{ $category }}" {{ old('category', $article->category) === $category ? 'selected' : '' }}>{{ $category }}</option>
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
                                    <input type="checkbox" name="is_published" value="1" class="sr-only" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                                    <span class="w-10 h-5 bg-gray-200 rounded-full shadow-inner relative transition">
                                        <span class="absolute left-1 top-1 w-3 h-3 bg-white rounded-full shadow transition {{ old('is_published', $article->is_published) ? 'translate-x-5 bg-purple-500' : '' }}"></span>
                                    </span>
                                </label>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal Publikasi</label>
                                <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}" class="mt-2 w-full bg-gray-100 border-0 text-sm text-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500">
                                @error('published_at')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="border border-gray-100 rounded-xl p-4 space-y-3">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Gambar Sampul</label>
                            <input type="file" name="featured_image" class="block w-full text-sm text-gray-500 border border-dashed border-gray-300 rounded-lg px-3 py-2 cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <p class="text-xs text-gray-400">Format: JPG, PNG (maks 2MB)</p>
                            @error('featured_image')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                            @if($article->featured_image)
                            <div class="mt-3">
                                <p class="text-xs text-gray-500 mb-2">Pratinjau saat ini</p>
                                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Featured image" class="rounded-lg border border-gray-100">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.support.articles.index') }}" class="px-4 py-2 bg-gray-100 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:opacity-90 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

