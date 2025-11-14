@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Detail Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1">#{{ $transaction->transaction_code }}</p>
        </div>
        <a href="{{ route('admin.finance.transactions.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Transaksi</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Kode Transaksi</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">#{{ $transaction->transaction_code }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jumlah</dt>
                        <dd class="mt-1 text-2xl font-bold text-gray-900">{{ $transaction->formatted_amount }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            @if($transaction->status === 'success')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Sukses</span>
                            @elseif($transaction->status === 'pending')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($transaction->status === 'failed')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">Gagal</span>
                            @else
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">Dibatalkan</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                        <dd class="mt-1 text-gray-900">{{ $transaction->payment_method_label }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Transaksi</dt>
                        <dd class="mt-1 text-gray-900">{{ $transaction->created_at->format('d F Y, H:i:s') }}</dd>
                    </div>
                    @if($transaction->paid_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Dibayar</dt>
                        <dd class="mt-1 text-gray-900">{{ $transaction->paid_at->format('d F Y, H:i:s') }}</dd>
                    </div>
                    @endif
                    @if($transaction->payment_gateway_transaction_id)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">ID Transaksi Gateway</dt>
                        <dd class="mt-1 text-gray-900 font-mono text-sm">{{ $transaction->payment_gateway_transaction_id }}</dd>
                    </div>
                    @endif
                    @if($transaction->notes)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                        <dd class="mt-1 text-gray-700">{{ $transaction->notes }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengguna</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama</dt>
                        <dd class="mt-1 text-gray-900">{{ $transaction->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-gray-900">{{ $transaction->user->email }}</dd>
                    </div>
                </dl>
            </div>

            @if($transaction->subscriptionPackage)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Paket Langganan</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Paket</dt>
                        <dd class="mt-1 text-gray-900">{{ $transaction->subscriptionPackage->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Durasi</dt>
                        <dd class="mt-1 text-gray-900">{{ $transaction->subscriptionPackage->duration_label }}</dd>
                    </div>
                </dl>
            </div>
            @endif

            @if($transaction->payment_gateway_response)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Response Payment Gateway</h2>
                <pre class="bg-gray-50 p-4 rounded-lg text-xs overflow-x-auto">{{ json_encode($transaction->payment_gateway_response, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan</h2>
                <dl class="space-y-4">
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Subtotal</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $transaction->formatted_amount }}</dd>
                    </div>
                    <div class="flex justify-between pt-4 border-t border-gray-200">
                        <dt class="text-base font-semibold text-gray-900">Total</dt>
                        <dd class="text-base font-bold text-gray-900">{{ $transaction->formatted_amount }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection

