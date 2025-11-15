@extends('layouts.admin')

@section('title', 'Manajemen Pengaduan Warga')

@section('content')
<div class="p-6">
    <div class="flex gap-6">
        <!-- Main Column -->
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Manajemen Pengaduan Warga</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola pengaduan dan aspirasi dari warga</p>
                </div>
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

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Total Pengaduan</p>
                            <p class="text-3xl font-bold mt-1">{{ $stats['total'] }}</p>
                            <p class="text-white/60 text-xs mt-2">Semua pengaduan</p>
                        </div>
                        <div class="bg-white/15 rounded-xl p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>

                <div class="bg-gradient-to-br from-yellow-500 via-amber-500 to-orange-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Menunggu</p>
                            <p class="text-3xl font-bold mt-1">{{ $stats['pending'] }}</p>
                            <p class="text-white/60 text-xs mt-2">Belum ditinjau</p>
                        </div>
                        <div class="bg-white/15 rounded-xl p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>

                <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Diproses</p>
                            <p class="text-3xl font-bold mt-1">{{ $stats['in_progress'] }}</p>
                            <p class="text-white/60 text-xs mt-2">Sedang ditangani</p>
                        </div>
                        <div class="bg-white/15 rounded-xl p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 via-purple-600 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Selesai</p>
                            <p class="text-3xl font-bold mt-1">{{ $stats['resolved'] }}</p>
                            <p class="text-white/60 text-xs mt-2">Sudah ditindaklanjuti</p>
                        </div>
                        <div class="bg-white/15 rounded-xl p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                <form method="GET" action="{{ route('admin.desa-management.complaints.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Kode, nama, judul..." class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="reviewed" {{ ($filters['status'] ?? '') === 'reviewed' ? 'selected' : '' }}>Ditinjau</option>
                            <option value="in_progress" {{ ($filters['status'] ?? '') === 'in_progress' ? 'selected' : '' }}>Diproses</option>
                            <option value="resolved" {{ ($filters['status'] ?? '') === 'resolved' ? 'selected' : '' }}>Selesai</option>
                            <option value="rejected" {{ ($filters['status'] ?? '') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <option value="">Semua Kategori</option>
                            <option value="pelayanan-umum" {{ ($filters['kategori'] ?? '') === 'pelayanan-umum' ? 'selected' : '' }}>Pelayanan Umum</option>
                            <option value="infrastruktur" {{ ($filters['kategori'] ?? '') === 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                            <option value="sosial" {{ ($filters['kategori'] ?? '') === 'sosial' ? 'selected' : '' }}>Sosial Kemasyarakatan</option>
                            <option value="keamanan" {{ ($filters['kategori'] ?? '') === 'keamanan' ? 'selected' : '' }}>Keamanan & Ketertiban</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-2 bg-teal-600 text-white rounded-xl font-medium hover:bg-teal-700 transition">Filter</button>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($complaints as $complaint)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-mono font-medium text-gray-900">{{ $complaint->tracking_code }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $complaint->judul }}</div>
                                    <div class="text-xs text-gray-500 mt-1 line-clamp-1">{{ \Illuminate\Support\Str::limit($complaint->deskripsi, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $complaint->is_anonymous ? 'Anonim' : $complaint->nama }}</div>
                                    <div class="text-xs text-gray-500">{{ $complaint->telepon }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $complaint->category_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $complaint->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $complaint->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'reviewed' => 'bg-blue-100 text-blue-800',
                                            'in_progress' => 'bg-purple-100 text-purple-800',
                                            'resolved' => 'bg-emerald-100 text-emerald-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'reviewed' => 'Ditinjau',
                                            'in_progress' => 'Diproses',
                                            'resolved' => 'Selesai',
                                            'rejected' => 'Ditolak',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusColors[$complaint->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusLabels[$complaint->status] ?? $complaint->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.desa-management.complaints.show', $complaint->id) }}" class="text-teal-600 hover:text-teal-700">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Tidak ada pengaduan</p>
                                        <p class="text-sm mt-1">Belum ada pengaduan yang masuk</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($complaints->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $complaints->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

