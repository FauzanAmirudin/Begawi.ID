@extends('layouts.admin')

@section('title', 'Edit UMKM')

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@php
    $statusOptions = [
        'onboarding' => 'Onboarding',
        'active' => 'Aktif',
        'suspended' => 'Ditangguhkan',
        'inactive' => 'Tidak Aktif',
    ];
@endphp

@section('content')
<div class="p-6 space-y-6" x-data="{}" x-cloak>
    @if (session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
        <button class="text-xs text-emerald-600 hover:text-emerald-500" @click="$el.parentElement.remove()">Tutup</button>
    </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">Pengelolaan UMKM</p>
            <h1 class="text-3xl font-semibold text-gray-900 mt-2">Edit Profil UMKM</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi usaha, kontak, dan status penayangan.</p>
        </div>
        <div class="text-xs text-gray-400 space-y-1">
            <p>ID UMKM: <span class="font-semibold text-gray-600">{{ $umkm->id }}</span></p>
            <p>Subdomain: <span class="font-semibold text-gray-600">{{ $umkm->subdomain }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <form action="{{ route('admin.desa-management.umkm-management.update', $umkm) }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Informasi Utama</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Identitas usaha dan status</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Nama UMKM <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $umkm->name) }}" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all"
                                placeholder="Nama usaha" />
                            @error('name')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Status Penayangan <span class="text-red-500">*</span></label>
                            <select name="status" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all">
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}" {{ old('status', $umkm->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('status')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Pemilik / PIC <span class="text-red-500">*</span></label>
                            <input type="text" name="owner_name" value="{{ old('owner_name', $umkm->owner_name) }}" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" />
                            @error('owner_name')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Kategori UMKM <span class="text-red-500">*</span></label>
                            <select name="category" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all">
                                <option value="">Pilih kategori</option>
                                @foreach($categoryFilters as $category)
                                    <option value="{{ $category }}" {{ old('category', $umkm->category) === $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Email Login <span class="text-red-500">*</span></label>
                            <input type="email" name="owner_email" value="{{ old('owner_email', $umkm->owner_email) }}" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" />
                            @error('owner_email')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="owner_phone" value="{{ old('owner_phone', $umkm->owner_phone) }}" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="08xxxxxxxxxx" />
                            @error('owner_phone')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Nomor WhatsApp (Publik)</label>
                            <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $umkm->whatsapp_number) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="Nomor yang ditampilkan ke pengunjung" />
                            @error('whatsapp_number')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                            <input type="text" name="address" value="{{ old('address', $umkm->address) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="Alamat lokasi usaha" />
                            @error('address')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Warna Branding</label>
                            <input type="text" name="branding_color" value="{{ old('branding_color', $umkm->branding_color) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="#16a34a" />
                            @error('branding_color')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-semibold text-gray-700">Embed Google Maps</label>
                            <input type="text" name="maps_embed_url" value="{{ old('maps_embed_url', $umkm->maps_embed_url) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="URL iframe Google Maps" />
                            @error('maps_embed_url')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

        <div class="p-6 space-y-6 bg-gray-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Profil UMKM</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Deskripsi singkat untuk halaman publik</p>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700">Deskripsi Singkat</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all resize-none"
                    placeholder="Ceritakan profil singkat, produk unggulan, atau layanan utama">{{ old('description', $umkm->description) }}</textarea>
                @error('description')
                <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700">Tentang Usaha</label>
                <textarea name="about_business" rows="4"
                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all resize-none"
                    placeholder="Bagikan cerita, visi, atau proses produksi">{{ old('about_business', $umkm->about_business) }}</textarea>
                @error('about_business')
                <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Media & Dokumen</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Perbarui logo dan dokumen legal</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">Logo / Foto UMKM</label>
                    @if($umkm->logo_path)
                        <div class="rounded-xl border border-gray-200 p-3 flex items-center gap-3 bg-gray-50">
                            <img src="{{ asset('storage/' . $umkm->logo_path) }}" alt="Logo {{ $umkm->name }}" class="w-14 h-14 object-cover rounded-lg">
                            <div class="text-xs text-gray-500">
                                <p class="font-semibold text-gray-800">Logo saat ini</p>
                                <p>{{ basename($umkm->logo_path) }}</p>
                            </div>
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-600 hover:file:bg-emerald-100" />
                    @error('logo')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-3">
                    <label class="text-sm font-semibold text-gray-700">Dokumen Legalitas</label>
                    @if($umkm->legal_document_path)
                        <a href="{{ asset('storage/' . $umkm->legal_document_path) }}" target="_blank"
                            class="flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Lihat dokumen saat ini
                        </a>
                    @endif
                    <input type="file" name="legal_document" accept=".pdf,.jpg,.jpeg,.png"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-600 hover:file:bg-amber-100" />
                    @error('legal_document')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="p-6 bg-gradient-to-r from-gray-50 to-purple-50/40 border-t-2 border-purple-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <p class="text-sm text-gray-600">
                    Pastikan seluruh data sudah sesuai. Perubahan status akan langsung berdampak pada halaman publik UMKM.
                </p>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.desa-management.umkm-management.list') }}" class="px-5 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:text-gray-800 hover:bg-white transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-purple-500 via-indigo-500 to-blue-500 text-white text-sm font-semibold shadow-lg shadow-purple-500/25 hover:shadow-xl hover:shadow-purple-500/30 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
            </form>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold mb-4">Ringkasan</p>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Status</span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $umkm->status_badge }}">
                            {{ $umkm->status_label }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span>Produk Aktif</span>
                        <span class="font-semibold text-gray-900">{{ number_format($umkm->products_count) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total Kunjungan</span>
                        <span class="font-semibold text-gray-900">{{ number_format($umkm->visits_count) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Pesanan</span>
                        <span class="font-semibold text-gray-900">{{ number_format($umkm->orders_count) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl p-6 text-white">
                <h4 class="text-base font-semibold">Butuh bantuan?</h4>
                <p class="text-sm text-white/80 mt-2">Hubungi tim support untuk bantuan perubahan data yang sensitif seperti subdomain atau pemindahan kepemilikan.</p>
                <a href="{{ route('admin.support.contact') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/80 transition">
                    Hubungi Support
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

