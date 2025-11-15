@extends('layouts.admin')

@section('title', 'Stok & Ketersediaan')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-data="{ editModal: false, selectedProduct: null }" x-cloak>
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
            <h1 class="text-3xl font-semibold text-gray-900">Stok & Ketersediaan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola stok dan status ketersediaan produk Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.umkm.products.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-purple-600 bg-purple-50 rounded-xl hover:bg-purple-100 transition">
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Stock Management Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <h3 class="text-base font-semibold text-gray-900">Semua Produk</h3>
                <p class="text-xs text-gray-500 mt-1">{{ $products->count() }} produk ditemukan</p>
            </div>
            <div class="flex items-center gap-2">
                <button class="text-xs font-semibold px-3 py-2 rounded-lg border border-gray-200 text-gray-500 hover:text-purple-600 hover:border-purple-200 transition">
                    Filter
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Stok Saat Ini</th>
                        <th class="px-6 py-3">Status Ketersediaan</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($product->primaryImage)
                                <img src="{{ Storage::url($product->primaryImage->image_path) }}" alt="{{ $product->title }}" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $product->title }}</p>
                                    @if($product->category)
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $product->category->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                {{ $product->stock }} unit
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $product->availability_status === 'ready' ? 'bg-blue-50 text-blue-600' : 'bg-amber-50 text-amber-600' }}">
                                {{ $product->availability_status === 'ready' ? 'Ready' : 'Pre-order' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button type="button" @click="editModal = true; selectedProduct = {{ json_encode(['id' => $product->id, 'title' => $product->title, 'stock' => $product->stock, 'availability_status' => $product->availability_status]) }}" class="text-xs font-semibold text-purple-600 hover:text-purple-500">
                                Edit
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <p class="text-sm font-semibold text-gray-500">Belum ada produk</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Stock Modal -->
    <div
        x-show="editModal"
        x-transition.opacity
        @keydown.escape.window="editModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center px-4"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="editModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2" x-text="selectedProduct ? 'Edit Stok: ' + selectedProduct.title : 'Edit Stok'"></h3>
            <p class="text-sm text-gray-500 mb-6">Perbarui stok dan status ketersediaan produk.</p>
            
            <form :action="`{{ route('admin.umkm.products.index') }}/${selectedProduct ? selectedProduct.id : ''}/stock`" method="POST" x-show="selectedProduct">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" :value="selectedProduct ? selectedProduct.stock : 0" min="0" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Ketersediaan <span class="text-red-500">*</span></label>
                        <select name="availability_status" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-900 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                            <option value="ready" :selected="selectedProduct && selectedProduct.availability_status === 'ready'">Ready</option>
                            <option value="pre_order" :selected="selectedProduct && selectedProduct.availability_status === 'pre_order'">Pre-order</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 mt-6">
                    <button type="button" @click="editModal = false" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
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

