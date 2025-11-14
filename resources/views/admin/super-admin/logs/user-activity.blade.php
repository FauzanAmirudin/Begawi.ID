@extends('layouts.admin')

@section('title', 'Audit & Log Aktivitas - Aktivitas Pengguna')

@section('content')
<div class="p-6">
    <div class="flex gap-6">
        <div class="flex-1">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Total Aktivitas Hari Ini</p>
                            <p class="text-3xl font-bold">{{ number_format($activities->count()) }}</p>
                        </div>
                        <div class="text-green-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Filter</p>
                            <p class="text-sm">User, Tanggal, Pencarian</p>
                        </div>
                        <div class="text-purple-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6.414 6.414A1 1 0 0014 13v5l-4-2v-3a1 1 0 00-.293-.707L3.293 6.707A1 1 0 013 6V4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Status</p>
                            <p class="text-sm">Realtime Log</p>
                        </div>
                        <div class="text-orange-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-2v13"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">User</label>
                        <input type="text" name="user" value="{{ $filters['user'] }}" class="w-full px-3 py-2 bg-gray-100 border-0 rounded-lg text-sm text-gray-700 focus:bg-white focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Tanggal</label>
                        <input type="date" name="date" value="{{ $filters['date'] }}" class="w-full px-3 py-2 bg-gray-100 border-0 rounded-lg text-sm text-gray-700 focus:bg-white focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs text-gray-500 mb-1">Pencarian</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Cari aktivitas, deskripsi, konteks..." class="w-full pl-10 pr-3 py-2 bg-gray-100 border-0 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-purple-500">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-4 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.logs.download', ['type' => 'user', 'format' => 'xls']) }}" class="px-3 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600">Download Excel</a>
                        <a href="{{ route('admin.logs.download', ['type' => 'user', 'format' => 'pdf']) }}" class="px-3 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600">Download PDF</a>
                        <button class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700">Terapkan</button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Aktivitas Pengguna</h3>
                    <span class="text-xs text-gray-500">{{ now()->format('d M Y H:i') }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-xs text-gray-500 text-left">
                                <th class="px-4 py-2">Waktu</th>
                                <th class="px-4 py-2">User</th>
                                <th class="px-4 py-2">Aksi</th>
                                <th class="px-4 py-2">Konteks</th>
                                <th class="px-4 py-2">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @forelse($activities as $act)
                            <tr class="border-t border-gray-100 hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $act['time'] }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 text-white text-xs flex items-center justify-center">
                                            {{ strtoupper(substr($act['user'], 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $act['user'] }}</div>
                                            <div class="text-xs text-gray-400">{{ ucfirst(str_replace('_', ' ', $act['user_role'])) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $color = match($act['type']) {
                                            'create' => 'bg-emerald-100 text-emerald-700',
                                            'update' => 'bg-amber-100 text-amber-700',
                                            'delete' => 'bg-rose-100 text-rose-700',
                                            'login' => 'bg-indigo-100 text-indigo-700',
                                            'payment' => 'bg-purple-100 text-purple-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $color }}">{{ strtoupper($act['type']) }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $act['context'] }}</td>
                                <td class="px-4 py-3">{{ $act['desc'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada aktivitas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="w-80">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Ringkasan</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Aksi Terbanyak</span>
                        <span class="text-xs px-2 py-1 bg-emerald-100 text-emerald-700 rounded">CREATE</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">User Aktif</span>
                        <span class="text-xs px-2 py-1 bg-indigo-100 text-indigo-700 rounded">5 User</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Terakhir Update</span>
                        <span class="text-xs text-gray-500">{{ now()->format('H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


