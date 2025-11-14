@extends('layouts.admin')

@section('title', 'Edit Konfigurasi Payment Gateway')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Edit Konfigurasi Payment Gateway</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $paymentGateway->gateway_label }}</p>
        </div>
        <a href="{{ route('admin.finance.payment-gateways.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
            Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.finance.payment-gateways.update', $paymentGateway) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gateway</label>
                    <input 
                        type="text" 
                        value="{{ $paymentGateway->gateway_label }}"
                        disabled
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Environment *</label>
                    <select 
                        name="environment" 
                        required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                        <option value="sandbox" {{ old('environment', $paymentGateway->environment) == 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                        <option value="production" {{ old('environment', $paymentGateway->environment) == 'production' ? 'selected' : '' }}>Production</option>
                    </select>
                    @error('environment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if($paymentGateway->gateway === 'midtrans')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Server Key</label>
                    <input 
                        type="text" 
                        name="server_key" 
                        value="{{ old('server_key', $paymentGateway->server_key) }}"
                        placeholder="Masukkan Server Key"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                    @error('server_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Client Key</label>
                    <input 
                        type="text" 
                        name="client_key" 
                        value="{{ old('client_key', $paymentGateway->client_key) }}"
                        placeholder="Masukkan Client Key"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                    @error('client_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @else
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                    <input 
                        type="text" 
                        name="api_key" 
                        value="{{ old('api_key', $paymentGateway->api_key) }}"
                        placeholder="Masukkan API Key"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                    @error('api_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Secret Key</label>
                    <input 
                        type="text" 
                        name="secret_key" 
                        value="{{ old('secret_key', $paymentGateway->secret_key) }}"
                        placeholder="Masukkan Secret Key"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                    @error('secret_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <div>
                    <label class="flex items-center gap-2">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            {{ old('is_active', $paymentGateway->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                        >
                        <span class="text-sm font-medium text-gray-700">Aktifkan Gateway</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-500">Hanya satu gateway yang dapat aktif pada satu waktu</p>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg font-medium hover:shadow-lg transition">
                        Simpan Konfigurasi
                    </button>
                    <a href="{{ route('admin.finance.payment-gateways.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

