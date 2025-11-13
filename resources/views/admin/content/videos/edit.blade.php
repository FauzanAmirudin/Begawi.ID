@extends('layouts.admin')

@section('title', 'Edit Video/Dokumentasi')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Edit Video/Dokumentasi</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $video->title }}</p>
        </div>
        <a href="{{ route('admin.content.videos.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.content.videos.update', $video) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul *</label>
                    <input type="text" name="title" value="{{ old('title', $video->title) }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('description', $video->description) }}</textarea>
                    @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe *</label>
                    <select name="type" id="type-select" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="youtube" {{ old('type', $video->type) === 'youtube' ? 'selected' : '' }}>YouTube Video</option>
                        <option value="pdf" {{ old('type', $video->type) === 'pdf' ? 'selected' : '' }}>PDF File</option>
                    </select>
                </div>

                <div id="youtube-field" style="display: {{ old('type', $video->type) === 'youtube' ? 'block' : 'none' }};">
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL YouTube *</label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url', $video->youtube_url) }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @error('youtube_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div id="pdf-field" style="display: {{ old('type', $video->type) === 'pdf' ? 'block' : 'none' }};">
                    <label class="block text-sm font-medium text-gray-700 mb-2">File PDF</label>
                    @if($video->pdf_file)
                    <div class="mb-2">
                        <a href="{{ Storage::url($video->pdf_file) }}" target="_blank" class="text-emerald-600 hover:text-emerald-700">Lihat PDF saat ini</a>
                    </div>
                    @endif
                    <input type="file" name="pdf_file" accept="application/pdf" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @error('pdf_file')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Thumbnail</label>
                        @if($video->thumbnail)
                        <div class="mb-2">
                            <img src="{{ Storage::url($video->thumbnail) }}" alt="Current thumbnail" class="w-32 h-32 object-cover rounded-lg">
                        </div>
                        @endif
                        <input type="file" name="thumbnail" accept="image/*" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div id="duration-field" style="display: {{ old('type', $video->type) === 'youtube' ? 'block' : 'none' }};">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Durasi (detik)</label>
                        <input type="number" name="duration" value="{{ old('duration', $video->duration) }}" min="0" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $video->is_published) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                            <span class="text-sm font-medium text-gray-700">Publikasikan</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $video->sort_order) }}" min="0" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg font-medium hover:shadow-lg transition">
                        Update
                    </button>
                    <a href="{{ route('admin.content.videos.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('type-select').addEventListener('change', function() {
    const type = this.value;
    document.getElementById('youtube-field').style.display = type === 'youtube' ? 'block' : 'none';
    document.getElementById('pdf-field').style.display = type === 'pdf' ? 'block' : 'none';
    document.getElementById('duration-field').style.display = type === 'youtube' ? 'block' : 'none';
});
</script>
@endsection

