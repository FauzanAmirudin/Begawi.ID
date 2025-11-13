@extends('layouts.admin')

@section('title', 'Status Aktivasi & Domain')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Status Aktivasi & Domain</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola aktivasi domain custom dan status DNS</p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
        <form method="GET" action="{{ route('admin.websites.domain') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Domain atau Nama..."
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status DNS</label>
                <select 
                    name="dns_status" 
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('dns_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="active" {{ request('dns_status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="failed" {{ request('dns_status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="w-full px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                    Filter
                </button>
                <a href="{{ route('admin.websites.domain') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Websites Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Website</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domain Custom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status DNS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires At</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($websites as $website)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $website->name }}</div>
                            <div class="text-xs text-gray-500">{{ $website->url }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $website->custom_domain }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($website->dns_status === 'active')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @elseif($website->dns_status === 'pending')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($website->dns_status === 'failed')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Gagal</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                {{ $website->domain_expires_at ? $website->domain_expires_at->format('d M Y') : '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="openDomainModal({{ $website->id }}, '{{ $website->custom_domain }}', '{{ $website->dns_status }}')" class="text-emerald-600 hover:text-emerald-900" title="Aktifkan Domain">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            <p class="mt-2 text-sm">Tidak ada domain custom ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($websites->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $websites->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Activate Domain -->
<div id="domainModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Aktifkan Domain</h3>
        <form id="domainForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Domain Custom</label>
                <input type="text" name="custom_domain" id="modal_domain" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status DNS</label>
                <select name="dns_status" id="modal_dns_status" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="pending">Pending</option>
                    <option value="active">Aktif</option>
                    <option value="failed">Gagal</option>
                </select>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                    Simpan
                </button>
                <button type="button" onclick="closeDomainModal()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openDomainModal(websiteId, domain, dnsStatus) {
    document.getElementById('domainForm').action = `/admin/websites/${websiteId}/activate-domain`;
    document.getElementById('modal_domain').value = domain || '';
    document.getElementById('modal_dns_status').value = dnsStatus || 'pending';
    document.getElementById('domainModal').classList.remove('hidden');
}

function closeDomainModal() {
    document.getElementById('domainModal').classList.add('hidden');
}
</script>
@endsection

