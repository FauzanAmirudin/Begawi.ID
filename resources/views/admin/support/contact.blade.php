@extends('layouts.admin')

@section('title', 'Hubungi Tim Teknis')

@section('content')
<div class="p-6">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Hubungi Tim Teknis</h1>
                <p class="text-sm text-gray-500">Formulir integrasi dengan sistem email internal untuk kebutuhan eskalasi tenant.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.support.tickets') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-gray-300">
                    Lihat Tiket Aktif
                </a>
                <a href="{{ route('admin.support.documentation') }}" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:opacity-90">
                    Buka Dokumentasi
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Contact Form -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">Formulir Pengaduan Teknis</h2>
                    <span class="text-xs text-gray-400 uppercase tracking-wide">Estimasi respon &lt; 1 jam</span>
                </div>

                @if(!empty($prefill['ticket_id']))
                <div class="mb-6 p-4 bg-purple-50 border border-purple-100 rounded-xl text-sm text-purple-700 flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 18a9 9 0 110-18 9 9 0 010 18z"></path>
                    </svg>
                    <div>
                        <p class="font-semibold">Menindaklanjuti tiket {{ $prefill['ticket_id'] ?? '' }}</p>
                        <p class="text-xs text-purple-600/80 mt-1">Subjek: {{ $prefill['subject'] ?? '-' }}</p>
                    </div>
                </div>
                @endif

                @if(session('status'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
                @endif

                <form action="{{ route('admin.support.contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Subjek</label>
                        <input type="text" name="subject" value="{{ old('subject', $prefill['subject'] ?? '') }}" required class="mt-2 w-full bg-gray-100 border-0 rounded-lg text-sm text-gray-700 px-3 py-2 focus:bg-white focus:ring-2 focus:ring-purple-500" placeholder="Masukkan subjek pengaduan">
                        @error('subject')
                        <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori</label>
                        <select name="category" required class="mt-2 w-full bg-gray-100 border-0 rounded-lg text-sm text-gray-700 px-3 py-2 focus:bg-white focus:ring-2 focus:ring-purple-500">
                            <option value="">Pilih kategori</option>
                            <option value="Integrasi" {{ old('category', $prefill['category'] ?? '') === 'Integrasi' ? 'selected' : '' }}>Integrasi</option>
                            <option value="Akses Akun" {{ old('category', $prefill['category'] ?? '') === 'Akses Akun' ? 'selected' : '' }}>Akses Akun</option>
                            <option value="Data & Analitik" {{ old('category', $prefill['category'] ?? '') === 'Data & Analitik' ? 'selected' : '' }}>Data & Analitik</option>
                            <option value="Pelatihan" {{ old('category', $prefill['category'] ?? '') === 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                            <option value="Bug & Gangguan Sistem" {{ old('category', $prefill['category'] ?? '') === 'Bug & Gangguan Sistem' ? 'selected' : '' }}>Bug & Gangguan Sistem</option>
                            <option value="Permintaan Fitur Baru" {{ old('category', $prefill['category'] ?? '') === 'Permintaan Fitur Baru' ? 'selected' : '' }}>Permintaan Fitur Baru</option>
                            <option value="Lainnya" {{ old('category', $prefill['category'] ?? '') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                        <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Prioritas</label>
                        <div class="mt-3 flex items-center gap-3">
                            <label class="flex items-center gap-2 text-sm text-gray-600">
                                <input type="radio" name="priority" value="low" class="text-purple-600 focus:ring-purple-500" {{ old('priority', $prefill['priority'] ?? 'medium') === 'low' ? 'checked' : '' }}>
                                <span>Rendah</span>
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-600">
                                <input type="radio" name="priority" value="medium" class="text-purple-600 focus:ring-purple-500" {{ old('priority', $prefill['priority'] ?? 'medium') === 'medium' ? 'checked' : '' }}>
                                <span>Sedang</span>
                            </label>
                            <label class="flex items-center gap-2 text-sm text-gray-600">
                                <input type="radio" name="priority" value="high" class="text-purple-600 focus:ring-purple-500" {{ old('priority', $prefill['priority'] ?? '') === 'high' ? 'checked' : '' }}>
                                <span>Tinggi</span>
                            </label>
                        </div>
                        @error('priority')
                        <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pesan</label>
                        <textarea name="message" rows="6" required class="mt-2 w-full bg-gray-100 border-0 rounded-xl text-sm text-gray-700 px-3 py-3 focus:bg-white focus:ring-2 focus:ring-purple-500" placeholder="Jelaskan masalah atau kendala yang Anda alami...">{{ old('message', $prefill['message'] ?? '') }}</textarea>
                        @error('message')
                        <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <input type="hidden" name="ticket_id" value="{{ old('ticket_id', $prefill['ticket_id'] ?? '') }}">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="text-xs text-gray-400">
                            Dengan mengirimkan formulir ini, tiket akan tercatat dan notifikasi otomatis dikirim ke email internal support.
                        </div>
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:opacity-90 transition">
                            Kirim Permintaan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Details -->
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-2xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold">Kanal Support</h2>
                    <p class="text-sm text-white/80 mt-1">Akses cepat ke tim support sesuai kebutuhan.</p>
                    <div class="mt-4 space-y-4">
                        @foreach($channels as $channel)
                        <div class="bg-white/15 rounded-xl p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold">{{ $channel['name'] ?? 'Channel' }}</span>
                                <span class="text-xs text-white/70 uppercase tracking-wide">{{ $channel['availability'] ?? '-' }}</span>
                            </div>
                            <p class="text-sm text-white mt-2">{{ $channel['value'] ?? '-' }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">SLA Respon Pengaduan</h2>
                    <p class="text-xs text-gray-500 mt-1">Standar komitmen layanan untuk tiap prioritas.</p>
                    <div class="mt-4 space-y-4">
                        <div class="border border-gray-100 rounded-xl p-4 hover:border-purple-200 transition">
                            <div class="flex items-center justify-between text-sm font-semibold text-gray-900">
                                <span>Prioritas Tinggi</span>
                                <span class="text-red-500 uppercase">Urgent</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">{{ $sla['high'] ?? '-' }}</p>
                        </div>
                        <div class="border border-gray-100 rounded-xl p-4 hover:border-purple-200 transition">
                            <div class="flex items-center justify-between text-sm font-semibold text-gray-900">
                                <span>Prioritas Menengah</span>
                                <span class="text-orange-500 uppercase">Standard</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">{{ $sla['medium'] ?? '-' }}</p>
                        </div>
                        <div class="border border-gray-100 rounded-xl p-4 hover:border-purple-200 transition">
                            <div class="flex items-center justify-between text-sm font-semibold text-gray-900">
                                <span>Prioritas Rendah</span>
                                <span class="text-emerald-500 uppercase">Scheduled</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">{{ $sla['low'] ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="mt-6 p-4 bg-gray-50 rounded-xl text-xs text-gray-500 leading-relaxed">
                        SLA dihitung sejak tiket tercatat di sistem internal. Pastikan informasi yang diberikan lengkap untuk mempercepat proses investigasi.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

