@extends('layouts.admin')

@section('title', 'Tambah Produk')

@push('styles')
<style>
[x-cloak] { display: none !important; }
.image-preview-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 1rem;
}
.image-preview-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 0.75rem;
    overflow: hidden;
    border: 2px solid #e5e7eb;
}
.image-preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.image-preview-item .remove-btn {
    position: absolute;
    top: 0.25rem;
    right: 0.25rem;
    background: rgba(239, 68, 68, 0.9);
    color: white;
    border-radius: 50%;
    width: 1.5rem;
    height: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-data="productForm()" x-cloak>
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
                <a href="{{ route('admin.umkm.products.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">Manajemen Produk</p>
            </div>
            <h1 class="text-3xl font-semibold text-gray-900">Tambah Produk Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi informasi produk untuk menambahkannya ke katalog.</p>
        </div>
    </div>

    <!-- Product Form -->
    <form action="{{ route('admin.umkm.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        @csrf
        <div class="p-6 sm:p-10 space-y-8">
            <!-- Basic Information -->
            <section class="space-y-5 pb-6 border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-purple-500">Informasi Utama</p>
                    <h4 class="text-lg font-semibold text-gray-900 mt-1">Detail Produk</h4>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                    @error('title')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition resize-none">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Ketersediaan <span class="text-red-500">*</span></label>
                        <select name="availability_status" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                            <option value="ready" {{ old('availability_status', 'ready') == 'ready' ? 'selected' : '' }}>Ready</option>
                            <option value="pre_order" {{ old('availability_status') == 'pre_order' ? 'selected' : '' }}>Pre-order</option>
                        </select>
                        @error('availability_status')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <!-- Pricing & Stock -->
            <section class="space-y-5 pb-6 border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-purple-500">Harga & Stok</p>
                    <h4 class="text-lg font-semibold text-gray-900 mt-1">Informasi Harga</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                            <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                        </div>
                        @error('price')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Diskon <span class="text-gray-400 text-xs">(Opsional)</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                            <input type="number" name="discount_price" value="{{ old('discount_price') }}" step="0.01" min="0" placeholder="Kosongkan jika tidak ada diskon" class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika produk tidak memiliki diskon</p>
                        @error('discount_price')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                        @error('stock')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <!-- Labels -->
            <section class="space-y-5 pb-6 border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-purple-500">Label Produk</p>
                    <h4 class="text-lg font-semibold text-gray-900 mt-1">Tandai Produk</h4>
                </div>

                <div class="flex flex-wrap gap-3">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="labels[]" value="best_seller" {{ in_array('best_seller', old('labels', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="text-sm text-gray-700">Best Seller</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="labels[]" value="new" {{ in_array('new', old('labels', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="text-sm text-gray-700">Baru</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="labels[]" value="promo" {{ in_array('promo', old('labels', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="text-sm text-gray-700">Promo</span>
                    </label>
                </div>
                @error('labels')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <div class="pt-3 border-t border-gray-100">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="text-sm font-medium text-gray-700">🌟 Tandai sebagai Produk Unggulan</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 ml-6">Produk unggulan akan ditampilkan di halaman beranda</p>
                    @error('is_featured')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            <!-- Additional Information -->
            <section class="space-y-5 pb-6 border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-purple-500">Informasi Tambahan</p>
                    <h4 class="text-lg font-semibold text-gray-900 mt-1">Detail Lainnya</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Berat</label>
                        <input type="text" name="weight" value="{{ old('weight') }}" placeholder="Contoh: 500g, 1kg" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                        @error('weight')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dimensi</label>
                        <input type="text" name="dimension" value="{{ old('dimension') }}" placeholder="Contoh: 20x15x10 cm" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                        @error('dimension')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <!-- Images Upload -->
            <section class="space-y-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-purple-500">Gambar Produk</p>
                    <h4 class="text-lg font-semibold text-gray-900 mt-1">Unggah Foto Produk <span class="text-red-500">*</span></h4>
                    <p class="text-xs text-gray-500 mt-1">Gambar pertama akan menjadi gambar utama produk</p>
                </div>

                <div>
                    <input type="file" name="images[]" multiple accept="image/*" @change="handleImageUpload($event)" required class="hidden" id="image-upload">
                    <label for="image-upload" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-purple-600 bg-purple-50 rounded-xl hover:bg-purple-100 cursor-pointer transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Pilih Gambar
                    </label>
                    @error('images')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div x-show="previewImages.length > 0" class="image-preview-container">
                    <template x-for="(image, index) in previewImages" :key="index">
                        <div class="image-preview-item">
                            <img :src="image.url" :alt="'Preview ' + (index + 1)">
                            <button type="button" @click="removeImage(index)" class="remove-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </section>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3 px-6 sm:px-10 py-6 border-t border-gray-100 bg-gray-50">
            <a href="{{ route('admin.umkm.products.index') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 text-white text-sm font-semibold hover:bg-purple-500 transition">
                Simpan Produk
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function productForm() {
    return {
        previewImages: [],
        
        handleImageUpload(event) {
            const files = Array.from(event.target.files);
            files.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewImages.push({
                            file: file,
                            url: e.target.result
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });
        },
        
        removeImage(index) {
            this.previewImages.splice(index, 1);
            // Update file input
            const input = document.getElementById('image-upload');
            const dt = new DataTransfer();
            this.previewImages.forEach(img => {
                dt.items.add(img.file);
            });
            input.files = dt.files;
        }
    }
}
</script>
@endpush
@endsection

