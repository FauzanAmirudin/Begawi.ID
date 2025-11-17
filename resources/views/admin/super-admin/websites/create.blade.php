@extends('layouts.admin')

@section('title', 'Tambah Website Baru')

@section('content')
@php
    $currentType = old('type', $defaultType ?? 'desa');
    $backRoute = $currentType === 'umkm' ? route('admin.websites.umkm') : route('admin.websites.desa');
@endphp
<div class="p-6" x-data="{ type: '{{ $currentType }}' }">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Tambah Website Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Buat website desa atau UMKM baru dan hubungkan dengan data di basis data.</p>
        </div>
        <a href="{{ $backRoute }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-4 py-3">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.websites.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Jenis Website</h2>
                        <p class="text-xs text-gray-500">Pilih jenis website yang ingin dibuat</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 px-4 py-3 border rounded-2xl cursor-pointer transition"
                           :class="type === 'desa' ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200'">
                        <input type="radio" name="type" value="desa" class="hidden" x-model="type">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Website Desa</p>
                            <p class="text-xs text-gray-500 mt-1">Portal layanan dan profil pemerintah desa</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 px-4 py-3 border rounded-2xl cursor-pointer transition"
                           :class="type === 'umkm' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'">
                        <input type="radio" name="type" value="umkm" class="hidden" x-model="type">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Website UMKM</p>
                            <p class="text-xs text-gray-500 mt-1">Toko digital pelaku usaha di desa binaan</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Informasi Website</h2>
                        <p class="text-xs text-gray-500">Data dasar website dan konfigurasi</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Website <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subdomain / URL <span class="text-red-500">*</span></label>
                        <input type="text" name="url" value="{{ old('url') }}" placeholder="contoh: desamu.desa.begawi.id" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Domain Custom</label>
                        <input type="text" name="custom_domain" value="{{ old('custom_domain') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Ditangguhkan</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Template</label>
                        <input type="text" name="template_id" value="{{ old('template_id') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="default / modern / ...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <input type="text" name="notes" value="{{ old('notes') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Akun Admin</h2>
                        <p class="text-xs text-gray-500">Admin utama akan dibuat otomatis</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Admin <span class="text-red-500">*</span></label>
                        <input type="text" name="admin_name" value="{{ old('admin_name') }}" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Admin <span class="text-red-500">*</span></label>
                        <input type="email" name="admin_email" value="{{ old('admin_email') }}" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                        <input type="text" name="admin_phone" value="{{ old('admin_phone') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password (opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan untuk password otomatis"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>
                <p class="text-xs text-gray-500">Jika password dikosongkan, sistem akan membuat password acak dan ditampilkan pada notifikasi berhasil.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4" x-show="type === 'desa'">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 14l-9 4-9-4"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9 4 9-4"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Data Desa</h2>
                        <p class="text-xs text-gray-500">Hubungkan ke desa yang sudah ada atau buat baru</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Desa yang Sudah Ada</label>
                        <select name="existing_village_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">-- Buat Desa Baru --</option>
                            @foreach($villages as $village)
                                <option value="{{ $village->id }}" {{ (string) old('existing_village_id') === (string) $village->id ? 'selected' : '' }}>
                                    {{ $village->name }} {{ $village->location ? '('.$village->location.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Desa</label>
                            <input type="text" name="village_name" value="{{ old('village_name') }}"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Isi jika membuat desa baru">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi / Kabupaten</label>
                            <input type="text" name="village_location" value="{{ old('village_location') }}"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo Desa</label>
                            <input type="file" name="village_logo" accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-600 hover:file:bg-emerald-100">
                            <p class="text-xs text-gray-400 mt-1">PNG / JPG maksimal 2MB</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Banner / Foto Sampul</label>
                            <input type="file" name="village_banner" accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-600 hover:file:bg-emerald-100">
                            <p class="text-xs text-gray-400 mt-1">PNG / JPG maksimal 4MB</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tagline atau Motto Desa</label>
                        <input type="text" name="village_tagline" value="{{ old('village_tagline') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4" x-show="type === 'umkm'">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Detail UMKM</h2>
                        <p class="text-xs text-gray-500">Informasi dasar usaha binaan</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori UMKM <span class="text-red-500">*</span></label>
                            <select name="umkm_category" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Pilih kategori</option>
                                @foreach($categoryOptions as $category)
                                    <option value="{{ $category }}" {{ old('umkm_category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Terkait Desa</label>
                            <select name="linked_village_id" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Pilih Desa (opsional)</option>
                                @foreach($villages as $village)
                                    <option value="{{ $village->id }}" {{ (string) old('linked_village_id') === (string) $village->id ? 'selected' : '' }}>
                                        {{ $village->name }} {{ $village->location ? '('.$village->location.')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi UMKM</label>
                        <textarea name="umkm_description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                  placeholder="Produk unggulan, kapasitas produksi, atau layanan utama">{{ old('umkm_description') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo UMKM</label>
                        <input type="file" name="umkm_logo" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100">
                        <p class="text-xs text-gray-400 mt-1">PNG / JPG maksimal 2MB</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Ringkasan</h3>
                <p class="text-sm text-gray-500 mt-3">Pastikan data sudah sesuai. Admin baru akan dibuat beserta kredensialnya.</p>
                <ul class="mt-4 space-y-2 text-sm text-gray-600">
                    <li class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Website dan akun admin dibuat otomatis
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Website desa otomatis terhubung ke master desa
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Password admin tampil pada notifikasi sukses
                    </li>
                </ul>
                <div class="mt-6 flex flex-col gap-3">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-500 text-white text-sm font-semibold shadow-lg hover:shadow-xl transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan & Buat Website
                    </button>
                    <a href="{{ $backRoute }}" class="text-sm text-gray-500 text-center hover:text-gray-700 transition">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

