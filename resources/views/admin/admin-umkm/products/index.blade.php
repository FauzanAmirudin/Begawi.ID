@extends('layouts.admin')

@section('title', 'Daftar Produk')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-data="{ deleteModal: false, selectedProduct: null }" x-cloak>
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
                <a href="{{ route('admin.dashboard.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">Manajemen Produk</p>
            </div>
            <h1 class="text-3xl font-semibold text-gray-900">Daftar Produk</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola semua produk UMKM Anda. Edit, hapus, atau nonaktifkan produk.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.umkm.products.categories') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-purple-600 bg-purple-50 rounded-xl hover:bg-purple-100 transition">
                Kategori
            </a>
            <a href="{{ route('admin.umkm.products.stock') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-purple-600 bg-purple-50 rounded-xl hover:bg-purple-100 transition">
                Stok & Ketersediaan
            </a>
            <a href="{{ route('admin.umkm.products.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-purple-600 rounded-xl hover:bg-purple-500 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Produk
            </a>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <h3 class="text-base font-semibold text-gray-900">Semua Produk</h3>
                <p class="text-xs text-gray-500 mt-1">{{ $products->total() }} produk ditemukan</p>
            </div>
            <div class="flex items-center gap-2">
                <button class="text-xs font-semibold px-3 py-2 rounded-lg border border-gray-200 text-gray-500 hover:text-purple-600 hover:border-purple-200 transition">
                    Filter
                </button>
                <button class="text-xs font-semibold px-3 py-2 rounded-lg border border-gray-200 text-gray-500 hover:text-purple-600 hover:border-purple-200 transition">
                    Export
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Harga</th>
                        <th class="px-6 py-3">Stok</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Terakhir Update</th>
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
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($product->hasLabel('best_seller'))
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-orange-100 text-orange-600">Best Seller</span>
                                        @endif
                                        @if($product->hasLabel('new'))
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-100 text-blue-600">Baru</span>
                                        @endif
                                        @if($product->hasLabel('promo'))
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-red-100 text-red-600">Promo</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                @if($product->discount_price)
                                <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-red-600 font-semibold mt-0.5">-{{ $product->discount_percentage }}%</p>
                                @else
                                <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $product->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-600' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $product->is_active ? 'bg-emerald-500' : 'bg-gray-500' }}"></span>
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $product->availability_status === 'ready' ? 'bg-blue-50 text-blue-600' : 'bg-amber-50 text-amber-600' }}">
                                    {{ $product->availability_status === 'ready' ? 'Ready' : 'Pre-order' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->category)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-600">
                                {{ $product->category->name }}
                            </span>
                            @else
                            <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $product->updated_at->translatedFormat('d M Y · H:i') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.umkm.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.umkm.products.toggle-status', $product) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-600 hover:text-gray-900" title="{{ $product->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        @if($product->is_active)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                        </svg>
                                        @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        @endif
                                    </button>
                                </form>
                                <button type="button" @click="deleteModal = true; selectedProduct = {{ $product->id }}" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <p class="text-sm font-semibold text-gray-500">Belum ada produk</p>
                                <p class="text-xs text-gray-400">Tambahkan produk pertama Anda untuk memulai</p>
                                <a href="{{ route('admin.umkm.products.create') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-purple-600 rounded-xl hover:bg-purple-500 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Produk
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <div
        x-show="deleteModal"
        x-transition.opacity
        @keydown.escape.window="deleteModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center px-4"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="deleteModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Produk?</h3>
            <p class="text-sm text-gray-500 mb-6">Produk akan dinonaktifkan dan tidak akan muncul di website. Anda dapat mengaktifkannya kembali kapan saja.</p>
            <div class="flex items-center justify-end gap-3">
                <button type="button" @click="deleteModal = false" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                    Batal
                </button>
                <form :action="`{{ route('admin.umkm.products.index') }}/${selectedProduct}`" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-xl hover:bg-red-500 transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

