@extends('layouts.admin')

@section('title', 'Detail Pesan Kontak')

@section('content')
<div class="p-6">
    <div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.contact-messages.index') }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100 text-gray-500 hover:text-gray-700 hover:bg-gray-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Pesan Kontak</p>
                    <h1 class="text-2xl font-semibold text-gray-900">Detail Pesan</h1>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($message->status === 'unread')
                    <span class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-semibold rounded-full">Belum Dibaca</span>
                @elseif($message->status === 'read')
                    <span class="px-3 py-1 bg-blue-100 text-blue-600 text-xs font-semibold rounded-full">Sudah Dibaca</span>
                @else
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-600 text-xs font-semibold rounded-full">Sudah Dibalas</span>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Message Card -->
        <div class="bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl p-6 text-white shadow-sm">
            <div class="flex flex-col gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/70">Pesan Kontak</p>
                    <h2 class="text-2xl font-semibold mt-2">{{ $message->subject }}</h2>
                </div>
                <div class="flex flex-wrap items-center gap-4 text-xs text-white/80">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-white/60"></span>
                        Dikirim {{ $message->created_at->format('d M Y, H:i') }}
                    </div>
                    @if($message->read_at)
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-white/60"></span>
                            Dibaca {{ $message->read_at->format('d M Y, H:i') }}
                        </div>
                    @endif
                    @if($message->replied_at)
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-white/60"></span>
                            Dibalas {{ $message->replied_at->format('d M Y, H:i') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="xl:col-span-2 space-y-6">
                <!-- Message Content -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Isi Pesan</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                    </div>
                </div>

                <!-- Admin Response -->
                @if($message->admin_response)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Balasan Admin</h3>
                        @if($message->responder)
                            <span class="text-sm text-gray-500">Oleh: {{ $message->responder->name }}</span>
                        @endif
                    </div>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $message->admin_response }}</p>
                    </div>
                </div>
                @endif

                <!-- Reply Form -->
                @if($message->status !== 'replied')
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Balas Pesan</h3>
                    <form action="{{ route('admin.contact-messages.update-status', $message->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="replied">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Balasan</label>
                            <textarea 
                                name="admin_response" 
                                rows="6" 
                                required
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Tulis balasan Anda di sini..."
                            ></textarea>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg font-medium hover:shadow-lg transition">
                                Kirim Balasan
                            </button>
                            @if($message->status === 'unread')
                            <form action="{{ route('admin.contact-messages.update-status', $message->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="read">
                                <button type="submit" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                                    Tandai Sebagai Dibaca
                                </button>
                            </form>
                            @endif
                        </div>
                    </form>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Sender Info -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengirim</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Nama</p>
                            <p class="text-sm font-medium text-gray-900">{{ $message->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Email</p>
                            <a href="mailto:{{ $message->email }}" class="text-sm text-emerald-600 hover:text-emerald-700">
                                {{ $message->email }}
                            </a>
                        </div>
                        @if($message->phone)
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Telepon</p>
                            <a href="tel:{{ $message->phone }}" class="text-sm text-emerald-600 hover:text-emerald-700">
                                {{ $message->phone }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                    <div class="space-y-3">
                        <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" 
                           class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Kirim Email
                        </a>
                        @if($message->phone)
                        <a href="tel:{{ $message->phone }}" 
                           class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Telepon
                        </a>
                        @endif
                        <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

