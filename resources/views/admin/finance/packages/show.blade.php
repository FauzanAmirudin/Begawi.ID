@extends('layouts.admin')

@section('title', 'Detail Paket Langganan')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Detail Paket Langganan</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $package->name }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.finance.packages.edit', $package) }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                Edit
            </a>
            <a href="{{ route('admin.finance.packages.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Paket</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Paket</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $package->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Harga</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $package->formatted_price }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Durasi</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $package->duration_label }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            @if($package->is_active)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Nonaktif</span>
                            @endif
                        </dd>
                    </div>
                    @if($package->description)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                        <dd class="mt-1 text-gray-700">{{ $package->description }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            @if($package->benefits && count($package->benefits) > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Benefit</h2>
                <ul class="space-y-2">
                    @foreach($package->benefits as $benefit)
                    <li class="flex items-start gap-2 text-gray-700">
                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>{{ $benefit }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistik</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Transaksi</dt>
                        <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $package->transactions()->count() }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Transaksi Sukses</dt>
                        <dd class="mt-1 text-2xl font-bold text-emerald-600">{{ $package->transactions()->where('status', 'success')->count() }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h2>
                <div class="space-y-2">
                    <a href="{{ route('admin.finance.packages.edit', $package) }}" class="block w-full px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition text-center">
                        Edit Paket
                    </a>
                    <form action="{{ route('admin.finance.packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="block w-full px-4 py-2 bg-red-50 text-red-700 rounded-lg font-medium hover:bg-red-100 transition">
                            Hapus Paket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

