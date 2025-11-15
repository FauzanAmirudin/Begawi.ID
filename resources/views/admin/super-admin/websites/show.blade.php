@extends('layouts.admin')

@section('title', 'Detail Website')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Detail Website</h1>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap website</p>
        </div>
        <a href="{{ route('admin.websites.' . $website->type) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Website</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $website->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tipe</dt>
                        <dd class="mt-1">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $website->type === 'desa' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800' }}">
                                {{ $website->type_label }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">URL</dt>
                        <dd class="mt-1">
                            <a href="http://{{ $website->url }}" target="_blank" class="text-emerald-600 hover:text-emerald-900">
                                {{ $website->url }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Domain Custom</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $website->custom_domain ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            @if($website->status === 'active')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @elseif($website->status === 'suspended')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditangguhkan</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Nonaktif</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Template</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $website->template_id ?: 'Default' }}</dd>
                    </div>
                </dl>
            </div>

            @if($website->notes)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Catatan</h3>
                <p class="text-sm text-gray-600">{{ $website->notes }}</p>
            </div>
            @endif

            @if($website->type === 'desa' && $village)
            <!-- Village Data Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Data Desa</h3>
                    <a href="{{ route('admin.websites.village-detail', $website) }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                        Lihat Detail Lengkap →
                    </a>
                </div>
                
                @if($villageStats)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4">
                        <p class="text-xs text-gray-600 mb-1">Berita</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $villageStats['news_published'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">dari {{ $villageStats['news_total'] }} total</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4">
                        <p class="text-xs text-gray-600 mb-1">Galeri</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $villageStats['gallery_total'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">item foto/video</p>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-4">
                        <p class="text-xs text-gray-600 mb-1">Potensi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $villageStats['potentials_total'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">wisata & ekonomi</p>
                    </div>
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4">
                        <p class="text-xs text-gray-600 mb-1">UMKM</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $villageStats['umkm_total'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">bisnis aktif</p>
                    </div>
                </div>
                @endif

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">Nama Desa</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $village->name }}</span>
                    </div>
                    @if($village->location)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">Lokasi</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $village->location }}</span>
                    </div>
                    @endif
                    @if($village->head)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">Kepala Desa</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $village->head }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Admin</h3>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                        {{ substr($website->user->name ?? 'U', 0, 2) }}
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $website->user->name ?? '-' }}</div>
                        <div class="text-xs text-gray-500">{{ $website->user->email ?? '-' }}</div>
                    </div>
                </div>
            </div>

            @if($website->custom_domain)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Domain Info</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs font-medium text-gray-500">Status DNS</dt>
                        <dd class="mt-1">
                            @if($website->dns_status === 'active')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @elseif($website->dns_status === 'pending')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($website->dns_status === 'failed')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Gagal</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">-</span>
                            @endif
                        </dd>
                    </div>
                    @if($website->domain_expires_at)
                    <div>
                        <dt class="text-xs font-medium text-gray-500">Expires At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $website->domain_expires_at->format('d M Y') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.websites.edit', $website) }}" class="block w-full px-4 py-2 bg-emerald-600 text-white text-center rounded-lg font-medium hover:bg-emerald-700 transition">
                        Edit Website
                    </a>
                    @if($website->status === 'active')
                    <form action="{{ route('admin.websites.suspend', $website) }}" method="POST" onsubmit="return confirm('Yakin ingin menangguhkan?')">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg font-medium hover:bg-orange-700 transition">
                            Suspend
                        </button>
                    </form>
                    @else
                    <form action="{{ route('admin.websites.activate', $website) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                            Aktifkan
                        </button>
                    </form>
                    @endif
                    <form action="{{ route('admin.websites.destroy', $website) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

