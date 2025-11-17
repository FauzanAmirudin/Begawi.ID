@extends('layouts.admin')

@section('title', 'Profil Desa - ' . $village->name)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 font-semibold">Manajemen Desa</p>
            <h1 class="text-2xl font-semibold text-gray-800 mt-1">Profil Desa {{ $village->name }}</h1>
            <p class="text-sm text-gray-500">Perbarui informasi profil desa yang tampil pada website.</p>
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

    <form method="POST" action="{{ route('admin.websites.village-profile.update', $website) }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        @method('PUT')

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Umum</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Desa <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $village->name) }}" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $village->tagline) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kepala Desa</label>
                        <input type="text" name="head" value="{{ old('head', $village->head) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan Kepala Desa</label>
                        <input type="text" name="head_title" value="{{ old('head_title', $village->head_title) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi / Kabupaten</label>
                        <input type="text" name="location" value="{{ old('location', $village->location) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kode Desa</label>
                        <input type="text" name="code" value="{{ old('code', $village->code) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Penduduk</label>
                        <input type="number" step="any" name="population" value="{{ old('population', $village->population) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Luas Wilayah (km²)</label>
                        <input type="number" step="any" name="area" value="{{ old('area', $village->area) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kepadatan (jiwa/km²)</label>
                        <input type="number" step="any" name="density" value="{{ old('density', $village->density) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $village->description) }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Visi</label>
                        <textarea name="vision" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('vision', $village->vision) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Periode Visi</label>
                        <input type="text" name="vision_period" value="{{ old('vision_period', $village->vision_period) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Misi (satu per baris)</label>
                    <textarea name="missions" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('missions', collect($village->missions ?? [])->implode("\n")) }}</textarea>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <p class="text-sm font-semibold text-gray-900">Data Lainnya (format JSON)</p>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Kontak</label>
                    <textarea name="contacts" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder='[{"label":"Telepon","value":"+62..."}, ...]'>{{ old('contacts', $village->contacts ? json_encode($village->contacts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Struktur Organisasi</label>
                    <textarea name="structures" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder='[{"name":"Sekretaris Desa","person":"..."}, ...]'>{{ old('structures', $village->structures ? json_encode($village->structures, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Riwayat / Sejarah</label>
                    <textarea name="history" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder='["Didirikan tahun ...", "..."]'>{{ old('history', $village->history ? json_encode($village->history, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Media Desa</h3>
                <div>
                    <label class="text-xs font-medium text-gray-600">Logo Desa</label>
                    @if($village->logo_path)
                        <div class="mt-2 mb-3">
                            <img src="{{ asset('storage/' . $village->logo_path) }}" alt="Logo" class="w-20 h-20 object-contain rounded-lg border border-gray-200">
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600">Banner / Foto Sampul</label>
                    @if($village->image)
                        <div class="mt-2 mb-3">
                            <img src="{{ asset('storage/' . $village->image) }}" alt="Banner" class="w-full h-32 object-cover rounded-xl border border-gray-200">
                        </div>
                    @endif
                    <input type="file" name="banner" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <p class="text-sm text-gray-500">Perubahan akan langsung tersimpan dan memengaruhi halaman publik desa.</p>
                <div class="mt-4 flex flex-col gap-2">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-gradient-to-r from-indigo-500 via-blue-500 to-cyan-500 text-white text-sm font-semibold shadow-lg hover:shadow-xl transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Profil Desa
                    </button>
                    <a href="{{ route('admin.websites.show', $website) }}" class="text-sm text-gray-500 text-center hover:text-gray-700 transition">
                        Batalkan
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

