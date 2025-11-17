@extends('layouts.admin')

@section('title', 'Profil UMKM - ' . $umkm->name)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-orange-500 font-semibold">Manajemen UMKM</p>
            <h1 class="text-2xl font-semibold text-gray-800 mt-1">Profil UMKM {{ $umkm->name }}</h1>
            <p class="text-sm text-gray-500">Kelola informasi profil UMKM di bawah pembinaan desa.</p>
        </div>
        <a href="{{ route('admin.websites.show', $website) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-4 py-3">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.websites.umkm-profile.update', $website) }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        @method('PUT')

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Utama</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama UMKM <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $umkm->name) }}" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="category" value="{{ old('category', $umkm->category) }}" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik / PIC <span class="text-red-500">*</span></label>
                        <input type="text" name="owner_name" value="{{ old('owner_name', $umkm->owner_name) }}" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Pemilik <span class="text-red-500">*</span></label>
                        <input type="email" name="owner_email" value="{{ old('owner_email', $umkm->owner_email) }}" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" name="owner_phone" value="{{ old('owner_phone', $umkm->owner_phone) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Publik</label>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $umkm->whatsapp_number) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            @foreach(['onboarding' => 'Onboarding', 'active' => 'Aktif', 'suspended' => 'Ditangguhkan', 'inactive' => 'Tidak Aktif'] as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $umkm->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Terhubung ke Desa</label>
                        <select name="village_id" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">-- Pilih Desa --</option>
                            @foreach($villages as $village)
                                <option value="{{ $village->id }}" {{ (string) old('village_id', $umkm->village_id) === (string) $village->id ? 'selected' : '' }}>
                                    {{ $village->name }} {{ $village->location ? '('.$village->location.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea name="address" rows="2" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('address', $umkm->address) }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Embed Google Maps</label>
                        <input type="text" name="maps_embed_url" value="{{ old('maps_embed_url', $umkm->maps_embed_url) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Warna Branding (HEX)</label>
                        <input type="text" name="branding_color" value="{{ old('branding_color', $umkm->branding_color) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500" placeholder="#FF7F11">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('description', $umkm->description) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tentang Usaha</label>
                    <textarea name="about_business" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('about_business', $umkm->about_business) }}</textarea>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Media UMKM</h3>
                <div>
                    <label class="text-xs font-medium text-gray-600">Logo UMKM</label>
                    @if($umkm->logo_path)
                        <div class="mt-2 mb-3">
                            <img src="{{ asset('storage/' . $umkm->logo_path) }}" alt="Logo" class="w-24 h-24 object-cover rounded-xl border border-gray-200">
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100">
                    <p class="text-xs text-gray-400 mt-1">PNG / JPG maksimal 2MB</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <p class="text-sm text-gray-500">Perubahan profil UMKM akan langsung tampil di website publik UMKM.</p>
                <div class="mt-4 flex flex-col gap-2">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-orange-500 via-amber-500 to-yellow-400 text-white text-sm font-semibold shadow-lg hover:shadow-xl transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Profil UMKM
                    </button>
                    <a href="{{ route('admin.websites.show', $website) }}" class="text-sm text-gray-500 text-center hover:text-gray-700 transition">
                        Batalkan
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-3">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Statistik Singkat</h3>
                <p class="text-sm text-gray-600">Produk aktif: <span class="font-semibold text-gray-900">{{ number_format($umkm->products_count) }}</span></p>
                <p class="text-sm text-gray-600">Kunjungan tercatat: <span class="font-semibold text-gray-900">{{ number_format($umkm->visits_count) }}</span></p>
                <p class="text-sm text-gray-600">Pesanan tercatat: <span class="font-semibold text-gray-900">{{ number_format($umkm->orders_count) }}</span></p>
            </div>
        </div>
    </form>
</div>
@endsection

