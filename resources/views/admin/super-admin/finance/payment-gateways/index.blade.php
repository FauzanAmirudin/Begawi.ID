@extends('layouts.admin')

@section('title', 'Integrasi Payment Gateway')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Integrasi Payment Gateway</h1>
            <p class="text-sm text-gray-500 mt-1">Konfigurasi API (Midtrans/Xendit)</p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <!-- Payment Gateways -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @php
            $midtrans = $gateways->firstWhere('gateway', 'midtrans');
            $xendit = $gateways->firstWhere('gateway', 'xendit');
        @endphp

        <!-- Midtrans -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold">
                            M
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Midtrans</h3>
                            @if($midtrans && $midtrans->is_active)
                                <span class="text-xs text-green-600 font-medium">● Aktif</span>
                            @else
                                <span class="text-xs text-gray-500 font-medium">● Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($midtrans)
                    <div class="space-y-2 mb-4 text-sm">
                        <div>
                            <span class="text-gray-500">Environment:</span>
                            <span class="font-medium text-gray-900">{{ $midtrans->environment_label }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Server Key:</span>
                            <span class="font-mono text-xs text-gray-600">{{ $midtrans->server_key ? substr($midtrans->server_key, 0, 20) . '...' : '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Client Key:</span>
                            <span class="font-mono text-xs text-gray-600">{{ $midtrans->client_key ? substr($midtrans->client_key, 0, 20) . '...' : '-' }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.finance.payment-gateways.edit', $midtrans) }}" class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition text-center">
                        Konfigurasi
                    </a>
                @else
                    <p class="text-sm text-gray-500 mb-4">Belum dikonfigurasi</p>
                    <form action="{{ route('admin.finance.payment-gateways.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="gateway" value="midtrans">
                        <button type="submit" class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                            Buat Konfigurasi
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Xendit -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold">
                            X
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Xendit</h3>
                            @if($xendit && $xendit->is_active)
                                <span class="text-xs text-green-600 font-medium">● Aktif</span>
                            @else
                                <span class="text-xs text-gray-500 font-medium">● Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($xendit)
                    <div class="space-y-2 mb-4 text-sm">
                        <div>
                            <span class="text-gray-500">Environment:</span>
                            <span class="font-medium text-gray-900">{{ $xendit->environment_label }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">API Key:</span>
                            <span class="font-mono text-xs text-gray-600">{{ $xendit->api_key ? substr($xendit->api_key, 0, 20) . '...' : '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Secret Key:</span>
                            <span class="font-mono text-xs text-gray-600">{{ $xendit->secret_key ? substr($xendit->secret_key, 0, 20) . '...' : '-' }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.finance.payment-gateways.edit', $xendit) }}" class="block w-full px-4 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition text-center">
                        Konfigurasi
                    </a>
                @else
                    <p class="text-sm text-gray-500 mb-4">Belum dikonfigurasi</p>
                    <form action="{{ route('admin.finance.payment-gateways.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="gateway" value="xendit">
                        <button type="submit" class="block w-full px-4 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition">
                            Buat Konfigurasi
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

