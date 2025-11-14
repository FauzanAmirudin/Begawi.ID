@extends('layouts.admin')

@section('title', 'Edit Halaman Informasi')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Edit Halaman Informasi</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $page->title }}</p>
        </div>
        <a href="{{ route('admin.content.pages.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.content.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Halaman *</label>
                    <input type="text" name="title" value="{{ old('title', $page->title) }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ringkasan</label>
                    <textarea name="excerpt" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('excerpt', $page->excerpt) }}</textarea>
                    @error('excerpt')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konten *</label>
                    <textarea name="content" rows="15" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('content', $page->content) }}</textarea>
                    @error('content')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Halaman *</label>
                        <select name="page_type" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @foreach($pageTypes as $type)
                            <option value="{{ $type }}" {{ old('page_type', $page->page_type) === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        @error('page_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Utama</label>
                        @if($page->featured_image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($page->featured_image) }}" alt="Current image" class="w-32 h-32 object-cover rounded-lg">
                        </div>
                        @endif
                        <input type="file" name="featured_image" accept="image/*" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('featured_image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $page->is_published) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                            <span class="text-sm font-medium text-gray-700">Publikasikan</span>
                        </label>
                    </div>

                    <div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $page->is_featured) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                            <span class="text-sm font-medium text-gray-700">Featured</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $page->sort_order) }}" min="0" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg font-medium hover:shadow-lg transition">
                        Update Halaman
                    </button>
                    <a href="{{ route('admin.content.pages.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

