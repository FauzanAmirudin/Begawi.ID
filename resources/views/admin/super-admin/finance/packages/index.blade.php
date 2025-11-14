@extends('layouts.admin')

@section('title', 'Paket Langganan')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Paket Langganan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola paket langganan (Gratis, Premium, Bisnis)</p>
        </div>
        <a href="{{ route('admin.finance.packages.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-medium hover:shadow-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Paket Baru
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    <!-- Packages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($packages as $package)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $package->name }}</h3>
                    @if($package->is_active)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Nonaktif</span>
                    @endif
                </div>
                
                <div class="mb-4">
                    <div class="text-3xl font-bold text-gray-900 mb-1">{{ $package->formatted_price }}</div>
                    <div class="text-sm text-gray-500">{{ $package->duration_label }}</div>
                </div>

                @if($package->description)
                <p class="text-sm text-gray-600 mb-4">{{ $package->description }}</p>
                @endif

                @if($package->benefits && count($package->benefits) > 0)
                <ul class="space-y-2 mb-4">
                    @foreach($package->benefits as $benefit)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>{{ $benefit }}</span>
                    </li>
                    @endforeach
                </ul>
                @endif

                <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.finance.packages.edit', $package) }}" class="flex-1 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg font-medium hover:bg-emerald-100 transition text-center">
                        Edit
                    </a>
                    <a href="{{ route('admin.finance.packages.show', $package) }}" class="flex-1 px-4 py-2 bg-gray-50 text-gray-700 rounded-lg font-medium hover:bg-gray-100 transition text-center">
                        Detail
                    </a>
                    <form action="{{ route('admin.finance.packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-50 text-red-700 rounded-lg font-medium hover:bg-red-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <p class="mt-2 text-sm text-gray-500">Belum ada paket langganan</p>
            <a href="{{ route('admin.finance.packages.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                Tambah Paket Pertama
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection

