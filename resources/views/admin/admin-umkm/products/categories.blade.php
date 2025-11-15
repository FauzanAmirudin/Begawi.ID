@extends('layouts.admin')

@section('title', 'Kategori Produk')

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-data="{ categoryModal: false, editMode: false, selectedCategory: null }" x-cloak>
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
                <a href="{{ route('admin.umkm.products.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">Manajemen Produk</p>
            </div>
            <h1 class="text-3xl font-semibold text-gray-900">Kategori Produk</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola kategori produk untuk mengorganisir katalog Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.umkm.products.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-purple-600 bg-purple-50 rounded-xl hover:bg-purple-100 transition">
                Kembali ke Daftar
            </a>
            <button type="button" @click="categoryModal = true; editMode = false; selectedCategory = null" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-purple-600 rounded-xl hover:bg-purple-500 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kategori
            </button>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        @if($category->icon)
                        <span class="text-2xl">{{ $category->icon }}</span>
                        @else
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $category->products_count }} produk</p>
                        </div>
                    </div>
                    @if($category->description)
                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $category->description }}</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $category->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-600' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $category->is_active ? 'bg-emerald-500' : 'bg-gray-500' }}"></span>
                        {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="categoryModal = true; editMode = true; selectedCategory = {{ json_encode(['id' => $category->id, 'name' => $category->name, 'description' => $category->description, 'icon' => $category->icon, 'sort_order' => $category->sort_order, 'is_active' => $category->is_active]) }}" class="text-xs font-semibold text-purple-600 hover:text-purple-500">
                        Edit
                    </button>
                    <form action="{{ route('admin.umkm.products.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Produk dalam kategori ini tidak akan terhapus.')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-semibold text-gray-400 hover:text-red-500">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <p class="text-sm font-semibold text-gray-500 mb-2">Belum ada kategori</p>
            <p class="text-xs text-gray-400 mb-4">Tambahkan kategori pertama Anda untuk mengorganisir produk</p>
            <button type="button" @click="categoryModal = true; editMode = false; selectedCategory = null" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-purple-600 rounded-xl hover:bg-purple-500 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kategori
            </button>
        </div>
        @endforelse
    </div>

    <!-- Category Modal -->
    <div
        x-show="categoryModal"
        x-transition.opacity
        @keydown.escape.window="categoryModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center px-4"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="categoryModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2" x-text="editMode ? 'Edit Kategori' : 'Tambah Kategori'"></h3>
            <p class="text-sm text-gray-500 mb-6">Lengkapi informasi kategori produk.</p>
            
            <!-- Form untuk Tambah Kategori -->
            <form action="{{ route('admin.umkm.products.categories.store') }}" method="POST" x-show="!editMode">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                        @error('name')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition resize-none">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Icon (Emoji)</label>
                            <input type="text" name="icon" value="{{ old('icon') }}" placeholder="🍕" maxlength="2" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition text-center text-2xl">
                            @error('icon')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                            @error('sort_order')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <label class="text-sm text-gray-700">Aktif</label>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 mt-6">
                    <button type="button" @click="categoryModal = false; selectedCategory = null" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-purple-600 rounded-xl hover:bg-purple-500 transition">
                        Tambah
                    </button>
                </div>
            </form>

            <!-- Form untuk Edit Kategori -->
            <form :action="selectedCategory ? `{{ route('admin.umkm.products.categories.update', ['category' => '__ID__']) }}`.replace('__ID__', selectedCategory.id) : ''" method="POST" x-show="editMode && selectedCategory">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="name" :value="selectedCategory ? selectedCategory.name : ''" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                        @error('name')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" rows="3" x-init="$watch('selectedCategory', value => { if (value && $el) $el.value = value.description || '' })" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition resize-none"></textarea>
                        @error('description')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Icon (Emoji)</label>
                            <input type="text" name="icon" :value="selectedCategory ? selectedCategory.icon : ''" placeholder="🍕" maxlength="2" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition text-center text-2xl">
                            @error('icon')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                            <input type="number" name="sort_order" :value="selectedCategory ? selectedCategory.sort_order : 0" min="0" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                            @error('sort_order')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" :checked="selectedCategory ? selectedCategory.is_active : true" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <label class="text-sm text-gray-700">Aktif</label>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 mt-6">
                    <button type="button" @click="categoryModal = false; editMode = false; selectedCategory = null" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-purple-600 rounded-xl hover:bg-purple-500 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

