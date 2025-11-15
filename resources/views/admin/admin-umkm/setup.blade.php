@extends('layouts.admin')

@section('title', 'Setup UMKM Business')

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-cloak>
    @if (session('info'))
    <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-2xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm font-semibold">{{ session('info') }}</span>
        </div>
        <button class="text-xs text-blue-600 hover:text-blue-500" @click="$el.parentElement.remove()">Tutup</button>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl">
        <div class="flex items-center gap-3 mb-2">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span class="text-sm font-semibold">Terjadi kesalahan</span>
        </div>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Page Header -->
    <div class="text-center max-w-2xl mx-auto">
        <div class="mb-4">
            <div class="w-20 h-20 mx-auto bg-purple-100 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H9m0 0H5m0 0h2M7 21h10M9 7h6m-6 4h6m-2 4h2"></path>
                </svg>
            </div>
        </div>
        <h1 class="text-3xl font-semibold text-gray-900 mb-2">Setup UMKM Business</h1>
        <p class="text-sm text-gray-500">Lengkapi informasi UMKM business Anda untuk mulai menggunakan sistem manajemen produk.</p>
    </div>

    <!-- Setup Form -->
    <div class="max-w-2xl mx-auto">
        <form action="{{ route('admin.umkm.setup.store') }}" method="POST" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-10 space-y-6">
            @csrf

            <!-- Business Information -->
            <section class="space-y-5 pb-6 border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-purple-500">Informasi UMKM</p>
                    <h4 class="text-lg font-semibold text-gray-900 mt-1">Data Bisnis</h4>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama UMKM <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name . ' UMKM') }}" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                    @error('name')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Bisnis <span class="text-red-500">*</span></label>
                    <select name="category" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                        <option value="">Pilih Kategori</option>
                        <option value="Makanan & Minuman" {{ old('category') == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                        <option value="Kerajinan & Fashion" {{ old('category') == 'Kerajinan & Fashion' ? 'selected' : '' }}>Kerajinan & Fashion</option>
                        <option value="Kesehatan & Herbal" {{ old('category') == 'Kesehatan & Herbal' ? 'selected' : '' }}>Kesehatan & Herbal</option>
                        <option value="Jasa" {{ old('category') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Bisnis</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition resize-none" placeholder="Ceritakan tentang bisnis Anda...">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            <!-- Owner Information -->
            <section class="space-y-5 pb-6 border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-purple-500">Informasi Pemilik</p>
                    <h4 class="text-lg font-semibold text-gray-900 mt-1">Data Pemilik</h4>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik <span class="text-red-500">*</span></label>
                    <input type="text" name="owner_name" value="{{ old('owner_name', $user->name) }}" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                    @error('owner_name')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1.5">Email menggunakan email akun Anda</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
                    <input type="text" name="owner_phone" value="{{ old('owner_phone') }}" required placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                    @error('owner_phone')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-blue-900 mb-1">Informasi Penting</p>
                        <p class="text-xs text-blue-700">Setelah setup selesai, Anda akan dapat mengakses semua fitur manajemen produk. Subdomain website akan dibuat otomatis berdasarkan nama UMKM Anda.</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.dashboard.index') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                    Nanti Saja
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 text-white text-sm font-semibold hover:bg-purple-500 transition">
                    Buat UMKM Business
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

