@extends('layouts.admin')

@section('title', 'Audit & Log Aktivitas - Audit Sistem')

@section('content')
<div class="p-6">
    <div class="flex gap-6">
        <div class="flex-1">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Status Backup Terakhir</p>
                            <p class="text-3xl font-bold">{{ strtoupper($backupSummary['last_backup_status']) }}</p>
                        </div>
                        <div class="text-blue-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-blue-100 text-sm">Waktu: {{ $backupSummary['last_backup_at'] }}</div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium">Penyimpanan Backup</p>
                            <p class="text-3xl font-bold">{{ $backupSummary['storage_used'] }}</p>
                        </div>
                        <div class="text-emerald-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 10h14M7 13h10M9 16h6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-emerald-100 text-sm">Berkas: {{ number_format($backupSummary['files_count']) }}</div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Backup Berikutnya</p>
                            <p class="text-3xl font-bold">{{ $backupSummary['next_backup_eta'] }}</p>
                        </div>
                        <div class="text-purple-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Level</label>
                        <select name="level" class="w-full px-3 py-2 bg-gray-100 border-0 rounded-lg text-sm text-gray-700 focus:bg-white focus:ring-2 focus:ring-purple-500">
                            <option value="">Semua</option>
                            <option value="INFO" @if(($filters['level'] ?? '')==='INFO') selected @endif>INFO</option>
                            <option value="WARNING" @if(($filters['level'] ?? '')==='WARNING') selected @endif>WARNING</option>
                            <option value="ERROR" @if(($filters['level'] ?? '')==='ERROR') selected @endif>ERROR</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Tanggal</label>
                        <input type="date" name="date" value="{{ $filters['date'] }}" class="w-full px-3 py-2 bg-gray-100 border-0 rounded-lg text-sm text-gray-700 focus:bg-white focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs text-gray-500 mb-1">Pencarian</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Cari komponen, pesan error, metadata..." class="w-full pl-10 pr-3 py-2 bg-gray-100 border-0 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-purple-500">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-4 flex items-center justify-end gap-3">
                        @php
                            $downloadParams = array_merge(['type' => 'system', 'format' => 'xls'], array_filter($filters, fn($value) => !empty($value)));
                        @endphp
                        <a href="{{ route('admin.logs.download', $downloadParams) }}" class="px-3 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600">Download Excel</a>
                        @php
                            $downloadParamsPdf = array_merge(['type' => 'system', 'format' => 'pdf'], array_filter($filters, fn($value) => !empty($value)));
                        @endphp
                        <a href="{{ route('admin.logs.download', $downloadParamsPdf) }}" class="px-3 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600">Download PDF</a>
                        <button class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700">Terapkan</button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Audit Sistem</h3>
                    <span class="text-xs text-gray-500">{{ now()->format('d M Y H:i') }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-xs text-gray-500 text-left">
                                <th class="px-4 py-2">Waktu</th>
                                <th class="px-4 py-2">Level</th>
                                <th class="px-4 py-2">Komponen</th>
                                <th class="px-4 py-2">Pesan</th>
                                <th class="px-4 py-2">Metadata</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @forelse($systemLogs as $log)
                            <tr class="border-t border-gray-100 hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $log['time'] }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $badge = match($log['level']) {
                                            'INFO' => 'bg-blue-100 text-blue-700',
                                            'WARNING' => 'bg-amber-100 text-amber-700',
                                            'ERROR' => 'bg-rose-100 text-rose-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $badge }}">{{ $log['level'] }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $log['component'] }}</td>
                                <td class="px-4 py-3">{{ $log['message'] }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($log['meta'] as $k => $v)
                                            <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 text-xs">{{ $k }}: {{ is_array($v) ? json_encode($v) : $v }}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada log sistem.</td>
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
                    <h3 class="text-lg font-semibold text-gray-800">Tindakan</h3>
                </div>
                <div class="space-y-3">
                    @php
                        $downloadParamsXlsx = array_merge(['type' => 'system', 'format' => 'xlsx'], array_filter($filters, fn($value) => !empty($value)));
                    @endphp
                    <a href="{{ route('admin.logs.download', $downloadParamsXlsx) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-500 text-white rounded-lg text-sm hover:bg-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16M8 8l8 8M16 8l-8 8"></path>
                        </svg>
                        Ekspor XLSX
                    </a>
                    @php
                        $downloadParamsPdfSidebar = array_merge(['type' => 'system', 'format' => 'pdf'], array_filter($filters, fn($value) => !empty($value)));
                    @endphp
                    <a href="{{ route('admin.logs.download', $downloadParamsPdfSidebar) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-rose-500 text-white rounded-lg text-sm hover:bg-rose-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m-4-4h8M4 4h16v16H4z"></path>
                        </svg>
                        Ekspor PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


