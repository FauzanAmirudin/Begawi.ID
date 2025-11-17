{{-- resources/views/pages/desa/layanan/index.blade.php --}}
@php use Illuminate\Support\Str; @endphp

@extends('layouts.desa')

@section('title', 'Layanan & Administrasi Desa')

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-white border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <nav class="flex text-sm text-slate-600">
                <a href="{{ route('desa.home') }}" class="hover:text-teal-600 transition">Beranda</a>
                <span class="mx-2">/</span>
                <span class="text-teal-600 font-medium">Layanan & Administrasi</span>
            </nav>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-teal-50 to-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-4">
                    Layanan Digital Desa
                </h1>
                <p class="text-xl text-slate-600 leading-relaxed">
                    Nikmati kemudahan pelayanan administrasi desa secara online.
                    Transparan, efisien, dan dapat diakses kapan saja.
                </p>
            </div>
        </div>
    </section>

    <!-- Navigation Tabs -->
    <div class="sticky top-[4.5rem] z-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <nav class="flex space-x-8 overflow-x-auto">
                <button onclick="scrollToSection('surat-online')"
                    class="nav-tab active whitespace-nowrap py-4 px-2 border-b-2 border-teal-600 text-teal-600 font-medium">
                    Surat Online
                </button>
                <button onclick="scrollToSection('pengaduan-warga')"
                    class="nav-tab whitespace-nowrap py-4 px-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">
                    Pengaduan Warga
                </button>
                <button onclick="scrollToSection('kategori-pengaduan')"
                    class="nav-tab whitespace-nowrap py-4 px-2 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">
                    Kategori Pengaduan
                </button>
            </nav>
        </div>
    </div>

    <!-- Section 1: Surat Online -->
    <section id="surat-online" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800 mb-4">Surat Online</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">
                    Ajukan berbagai jenis surat keterangan secara online tanpa perlu datang ke kantor desa
                </p>
            </div>

            <div class="grid grid-cols-12 gap-8">
                <!-- Left Side - Jenis Surat -->
                <div class="col-span-12 lg:col-span-5">
                    <h3 class="text-xl font-semibold text-slate-800 mb-6">Pilih Jenis Surat</h3>
                    <div class="space-y-4">
                        @foreach ($jenisSurat as $index => $surat)
                            <div class="surat-card {{ $index === 0 ? 'active' : '' }} bg-white rounded-2xl shadow-md p-6 cursor-pointer transition-all duration-300 hover:shadow-lg border-2 border-transparent"
                                onclick="selectSurat('{{ $surat['id'] }}', this)">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                                        @if (Str::endsWith($surat['icon'], ['.png', '.jpg', '.jpeg', '.svg']))
                                            <img src="{{ asset('images/layanan/' . $surat['icon']) }}"
                                                class="w-12 h-12 object-contain" alt="icon">
                                        @else
                                            <x-desa.icon :name="$surat['icon']" class="w-6 h-6 text-teal-600" />
                                        @endif
                                    </div>

                                    <div class="flex-1">
                                        <h4 class="font-semibold text-slate-800 mb-1">{{ $surat['nama'] }}</h4>
                                        <p class="text-sm text-slate-600 mb-2">{{ $surat['deskripsi'] }}</p>
                                        <div class="flex items-center gap-2 text-xs text-slate-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $surat['estimasi'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right Side - Form Permohonan -->
                <div class="col-span-12 lg:col-span-7">
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h3 class="text-xl font-semibold text-slate-800 mb-6">Form Permohonan Surat</h3>

                        <!-- Step Indicator -->
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-teal-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                    1</div>
                                <span class="ml-2 text-sm font-medium text-slate-800">Pengajuan</span>
                            </div>
                            <div class="flex-1 h-px bg-slate-200 mx-4"></div>
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-slate-200 text-slate-500 rounded-full flex items-center justify-center text-sm font-medium">
                                    2</div>
                                <span class="ml-2 text-sm text-slate-500">Verifikasi</span>
                            </div>
                            <div class="flex-1 h-px bg-slate-200 mx-4"></div>
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-slate-200 text-slate-500 rounded-full flex items-center justify-center text-sm font-medium">
                                    3</div>
                                <span class="ml-2 text-sm text-slate-500">Diterbitkan</span>
                            </div>
                        </div>

                        <form id="suratForm" onsubmit="submitSurat(event)">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap *</label>
                                    <input type="text" name="nama" required
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">NIK *</label>
                                    <input type="text" name="nik" required
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon *</label>
                                    <input type="tel" name="telepon" required
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                                    <input type="email" name="email"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition">
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap *</label>
                                <textarea name="alamat" rows="3" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition"></textarea>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Keperluan/Tujuan *</label>
                                <textarea name="keperluan" rows="3" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition"
                                    placeholder="Jelaskan untuk keperluan apa surat ini dibutuhkan"></textarea>
                            </div>

                            <!-- Persyaratan -->
                            <div id="persyaratanSection" class="mb-6">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Upload Persyaratan</label>
                                <div id="persyaratanList" class="space-y-3">
                                    <!-- Will be populated by JavaScript -->
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Ajukan Permohonan
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section 3: Pengaduan Warga -->
    <section id="pengaduan-warga" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800 mb-4">Pengaduan Warga</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">
                    Sampaikan keluhan, saran, atau aspirasi Anda untuk pembangunan desa yang lebih baik.
                    Setiap suara Anda penting bagi kemajuan desa kita.
                </p>
            </div>

            <!-- Hero Illustration -->
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-3xl p-8 mb-12">
                <div class="flex flex-col lg:flex-row items-center gap-8">
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-slate-800 mb-4">Suara Anda, Perubahan Kita</h3>
                        <p class="text-slate-600 mb-6 leading-relaxed">
                            Kami berkomitmen untuk mendengarkan setiap aspirasi warga.
                            Laporan Anda akan ditindaklanjuti dengan transparan dan akuntabel.
                        </p>
                        <div class="flex items-center gap-6 text-sm text-slate-600">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                                <span>Respon Cepat</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span>Transparan</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                <span>Terpantau</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-80">
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800">{{ $statistikPengaduan['selesai'] }}
                                        Pengaduan</div>
                                    <div class="text-sm text-slate-600">Selesai ditangani</div>
                                </div>
                            </div>
                            <div class="text-xs text-slate-500">
                                Dari total {{ $statistikPengaduan['total'] }} laporan yang masuk
                            </div>
                            <div class="mt-3 bg-slate-100 rounded-full h-2">
                                <div class="bg-emerald-500 h-2 rounded-full"
                                    style="width: {{ ($statistikPengaduan['selesai'] / $statistikPengaduan['total']) * 100 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Pengaduan -->
            <div class="bg-white rounded-2xl shadow-md p-8">
                <h3 class="text-2xl font-semibold text-slate-800 mb-6">Sampaikan Aspirasi Anda</h3>

                <form id="pengaduanForm" onsubmit="submitPengaduan(event)" class="space-y-6">
                    <!-- Personal Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Nama Lengkap *
                            </label>
                            <input type="text" name="nama" required
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition"
                                placeholder="Masukkan nama lengkap Anda">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Nomor Telepon *
                            </label>
                            <input type="tel" name="telepon" required
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition"
                                placeholder="08xxxxxxxxxx">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Email
                            </label>
                            <input type="email" name="email"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition"
                                placeholder="email@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Kategori Pengaduan *
                            </label>
                            <select name="kategori" required
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategoriPengaduan as $kategori)
                                    <option value="{{ $kategori['id'] }}">{{ $kategori['nama'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Lokasi/Alamat Kejadian
                        </label>
                        <input type="text" name="lokasi"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition"
                            placeholder="Sebutkan lokasi spesifik (nama jalan, RT/RW, dsb)">
                    </div>

                    <!-- Judul Pengaduan -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Judul Pengaduan *
                        </label>
                        <input type="text" name="judul" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition"
                            placeholder="Ringkasan singkat masalah yang dilaporkan">
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Deskripsi Lengkap *
                        </label>
                        <textarea name="deskripsi" rows="5" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent transition resize-none"
                            placeholder="Jelaskan secara detail masalah yang ingin Anda laporkan, termasuk kronologi kejadian jika diperlukan"></textarea>
                        <div class="mt-2 text-sm text-slate-500">
                            Minimum 50 karakter. Semakin detail, semakin mudah kami menindaklanjuti.
                        </div>
                    </div>

                    <!-- Upload Bukti -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Upload Bukti Pendukung
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <input type="file" id="bukti1" name="bukti[]" accept="image/*,.pdf"
                                    class="hidden">
                                <label for="bukti1"
                                    class="flex items-center gap-3 p-4 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-teal-400 hover:bg-teal-50 transition">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <div>
                                        <div class="font-medium text-slate-700">Foto/Dokumen 1</div>
                                        <div class="text-sm text-slate-500" id="bukti1-info">Klik untuk upload</div>
                                    </div>
                                </label>
                            </div>
                            <div>
                                <input type="file" id="bukti2" name="bukti[]" accept="image/*,.pdf"
                                    class="hidden">
                                <label for="bukti2"
                                    class="flex items-center gap-3 p-4 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-teal-400 hover:bg-teal-50 transition">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <div>
                                        <div class="font-medium text-slate-700">Foto/Dokumen 2</div>
                                        <div class="text-sm text-slate-500" id="bukti2-info">Klik untuk upload</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-slate-500">
                            Format: JPG, PNG, PDF. Maksimal 5MB per file.
                        </div>
                    </div>

                    <!-- Privacy Notice -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-blue-800">
                                <div class="font-medium mb-1">Privasi & Keamanan Data</div>
                                <div class="text-blue-700">
                                    Data pribadi Anda akan dijaga kerahasiaannya dan hanya digunakan untuk keperluan
                                    penanganan pengaduan.
                                    Identitas pelapor dapat dirahasiakan jika diminta.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Anonymous Checkbox -->
                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1"
                            class="mt-1 w-4 h-4 text-teal-600 border-slate-300 rounded focus:ring-teal-400">
                        <label for="is_anonymous" class="text-sm text-slate-600">
                            Saya ingin identitas saya dirahasiakan (Anonim)
                        </label>
                    </div>

                    <!-- Checkbox Agreement -->
                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="agreement" name="agreement" required
                            class="mt-1 w-4 h-4 text-teal-600 border-slate-300 rounded focus:ring-teal-400">
                        <label for="agreement" class="text-sm text-slate-600">
                            Saya menyetujui bahwa informasi yang saya berikan adalah benar dan dapat dipertanggungjawabkan.
                            Saya memahami bahwa laporan palsu dapat dikenakan sanksi sesuai peraturan yang berlaku.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full md:w-auto bg-teal-600 hover:bg-teal-700 text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Kirim Pengaduan
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Section 4: Kategori Pengaduan -->
    <section id="kategori-pengaduan" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800 mb-4">Kategori Pengaduan</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">
                    Pilih kategori yang sesuai dengan masalah yang ingin Anda laporkan untuk memudahkan proses penanganan
                </p>
            </div>

            <!-- Kategori Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                @foreach ($kategoriPengaduan as $kategori)
                    <div class="kategori-card bg-{{ $kategori['color'] }}-50 hover:bg-{{ $kategori['color'] }}-100 rounded-2xl p-6 text-center cursor-pointer transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg border border-{{ $kategori['color'] }}-100"
                        onclick="selectKategori('{{ $kategori['id'] }}', this)">
                        <div class="w-16 h-16 flex items-center justify-center flex-shrink-0 mb-4 mx-auto">
                            @if (Str::endsWith($kategori['icon'], ['.png', '.jpg', '.jpeg', '.svg']))
                                <img src="{{ asset('images/layanan/' . $kategori['icon']) }}"
                                    class="w-16 h-16 object-contain" alt="icon">
                            @else
                                <x-desa.icon :name="$kategori['icon']" class="w-6 h-6 text-teal-600" />
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800 mb-2">{{ $kategori['nama'] }}</h3>
                        <p class="text-sm text-slate-600 mb-3 leading-relaxed">{{ $kategori['deskripsi'] }}</p>
                        <div class="flex items-center justify-center gap-2">
                            <span
                                class="bg-{{ $kategori['color'] }}-600 text-white text-xs font-medium px-3 py-1 rounded-full">
                                {{ $kategori['jumlah'] }} Laporan
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Statistik Detail -->
            <div class="bg-slate-50 rounded-2xl p-8">
                <h3 class="text-xl font-semibold text-slate-800 mb-6 text-center">Statistik Pengaduan</h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-slate-800 mb-2">{{ $statistikPengaduan['total'] }}</div>
                        <div class="text-slate-600 text-sm">Total Pengaduan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-amber-600 mb-2">{{ $statistikPengaduan['bulan_ini'] }}</div>
                        <div class="text-slate-600 text-sm">Bulan Ini</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-emerald-600 mb-2">{{ $statistikPengaduan['selesai'] }}</div>
                        <div class="text-slate-600 text-sm">Selesai</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $statistikPengaduan['proses'] }}</div>
                        <div class="text-slate-600 text-sm">Dalam Proses</div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-slate-700">Tingkat Penyelesaian</span>
                            <span
                                class="text-sm text-slate-600">{{ round(($statistikPengaduan['selesai'] / $statistikPengaduan['total']) * 100) }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-3">
                            <div class="bg-emerald-500 h-3 rounded-full transition-all duration-500"
                                style="width: {{ ($statistikPengaduan['selesai'] / $statistikPengaduan['total']) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-slate-700">Sedang Diproses</span>
                            <span
                                class="text-sm text-slate-600">{{ round(($statistikPengaduan['proses'] / $statistikPengaduan['total']) * 100) }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full transition-all duration-500"
                                style="width: {{ ($statistikPengaduan['proses'] / $statistikPengaduan['total']) * 100 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-12">
                <h3 class="text-xl font-semibold text-slate-800 mb-6 text-center">Pertanyaan Yang Sering Diajukan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
                        <h4 class="font-semibold text-slate-800 mb-2">Berapa lama pengaduan akan ditanggapi?</h4>
                        <p class="text-slate-600 text-sm">Pengaduan akan ditanggapi maksimal 3x24 jam setelah diterima.
                            Untuk kasus darurat, akan segera ditindaklanjuti.</p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
                        <h4 class="font-semibold text-slate-800 mb-2">Apakah identitas pelapor akan dirahasiakan?</h4>
                        <p class="text-slate-600 text-sm">Ya, identitas pelapor dapat dirahasiakan jika diminta. Namun data
                            kontak tetap diperlukan untuk komunikasi.</p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
                        <h4 class="font-semibold text-slate-800 mb-2">Bagaimana cara melacak status pengaduan?</h4>
                        <p class="text-slate-600 text-sm">Setelah mengirim pengaduan, Anda akan mendapat kode tracking yang
                            dapat digunakan untuk memantau progress.</p>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
                        <h4 class="font-semibold text-slate-800 mb-2">Apa saja yang tidak boleh dilaporkan?</h4>
                        <p class="text-slate-600 text-sm">Hindari laporan palsu, fitnah, atau hal-hal yang bersifat
                            pribadi. Fokus pada masalah yang berkaitan dengan kepentingan umum.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tracking Modal (sama seperti sebelumnya) -->
    <div id="trackingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-slate-800">Lacak Status</h3>
                <button onclick="closeTrackingModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form onsubmit="trackStatus(event)">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kode Tracking</label>
                    <input type="text" id="trackingCode"
                        placeholder="Masukkan kode tracking (contoh: SRT-20241201-001 atau ADU-20241201-001)"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-400 focus:border-transparent"
                        required />
                </div>
                <button type="submit"
                    class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-xl transition-colors">
                    Lacak Status
                </button>
            </form>
            <div id="trackingResult" class="mt-4 hidden">
                <!-- Result akan diisi dengan JavaScript -->
            </div>
        </div>
    </div>

    <!-- Continue with next sections... -->

    @push('scripts')
        <script>
            // Data jenis surat untuk JavaScript
            const jenisSurat = @json($jenisSurat);
            let selectedSuratId = 'ktp'; // Default

            // Navigation tabs
            function scrollToSection(sectionId) {
                const section = document.getElementById(sectionId);
                const offset = 120; // Account for sticky header
                const top = section.offsetTop - offset;

                window.scrollTo({
                    top: top,
                    behavior: 'smooth'
                });

                // Update active tab
                document.querySelectorAll('.nav-tab').forEach(tab => {
                    tab.classList.remove('active', 'border-teal-600', 'text-teal-600');
                    tab.classList.add('border-transparent', 'text-slate-500');
                });

                event.target.classList.add('active', 'border-teal-600', 'text-teal-600');
                event.target.classList.remove('border-transparent', 'text-slate-500');
            }

            // Select surat type
            function selectSurat(suratId, element) {
                selectedSuratId = suratId;

                // Update active card
                document.querySelectorAll('.surat-card').forEach(card => {
                    card.classList.remove('active', 'border-teal-600', 'bg-teal-50');
                    card.classList.add('border-transparent');
                });

                element.classList.add('active', 'border-teal-600', 'bg-teal-50');
                element.classList.remove('border-transparent');

                // Update persyaratan
                updatePersyaratan(suratId);
            }

            // Update persyaratan based on selected surat
            function updatePersyaratan(suratId) {
                const surat = jenisSurat.find(s => s.id === suratId);
                const container = document.getElementById('persyaratanList');

                container.innerHTML = '';

                surat.persyaratan.forEach((persyaratan, index) => {
                    const div = document.createElement('div');
                    div.className = 'flex items-center gap-3';
                    div.innerHTML = `
            <input type="file" id="file_${index}" name="persyaratan[]" accept=".pdf,.jpg,.jpeg,.png" class="hidden">
            <label for="file_${index}" class="flex-1 flex items-center gap-3 p-3 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-teal-400 transition">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <div>
                    <div class="font-medium text-slate-700">${persyaratan}</div>
                    <div class="text-sm text-slate-500">Klik untuk upload file (PDF, JPG, PNG)</div>
                </div>
            </label>
        `;
                    container.appendChild(div);
                });
            }

            // Submit surat form
            function submitSurat(event) {
                event.preventDefault();

                const formData = new FormData(event.target);
                formData.append('jenis_surat', selectedSuratId);

                // Show loading state
                const submitBtn = event.target.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = `
        <span class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Mengirim...
        </span>
    `;
                submitBtn.disabled = true;

                // Submit to backend
                fetch('{{ route('desa.layanan.submit-surat') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                                '',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Permohonan surat berhasil dikirim! Kode tracking: ' + data.tracking_id, 'success');
                            event.target.reset();
                            // Reset file inputs
                            document.querySelectorAll('input[type="file"]').forEach(input => {
                                input.value = '';
                                const label = input.nextElementSibling;
                                if (label) {
                                    const fileInfo = label.querySelector('div > div:last-child');
                                    if (fileInfo) {
                                        fileInfo.textContent = 'Klik untuk upload file (PDF, JPG, PNG)';
                                        fileInfo.className = 'text-sm text-slate-500';
                                    }
                                }
                            });
                        } else {
                            showToast(data.message || 'Terjadi kesalahan saat mengirim permohonan', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Terjadi kesalahan saat mengirim permohonan', 'error');
                    })
                    .finally(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    });
            }

            // Toast notification
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `fixed bottom-4 right-4 z-50 max-w-sm p-4 rounded-xl shadow-lg transform translate-y-full transition-transform duration-300 ${
        type === 'success' ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white'
    }`;
                toast.textContent = message;

                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.classList.remove('translate-y-full');
                }, 100);

                setTimeout(() => {
                    toast.classList.add('translate-y-full');
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 300);
                }, 5000);
            }

            // Submit pengaduan form
            function submitPengaduan(event) {
                event.preventDefault();

                const formData = new FormData(event.target);

                // Validasi deskripsi minimum 50 karakter
                const deskripsi = formData.get('deskripsi');
                if (deskripsi.length < 50) {
                    showToast('Deskripsi minimal 50 karakter untuk memudahkan penanganan', 'error');
                    return;
                }

                // Show loading state
                const submitBtn = event.target.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = `
        <span class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Mengirim...
        </span>
    `;
                submitBtn.disabled = true;

                // Submit to backend
                fetch('{{ route('desa.layanan.submit-pengaduan') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                                '',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(
                                `Pengaduan berhasil dikirim! Kode tracking: ${data.tracking_id}. Kami akan menindaklanjuti dalam 3x24 jam.`,
                                'success');
                            event.target.reset();

                            // Reset file input labels
                            document.getElementById('bukti1-info').textContent = 'Klik untuk upload';
                            document.getElementById('bukti2-info').textContent = 'Klik untuk upload';
                        } else {
                            showToast(data.message || 'Terjadi kesalahan saat mengirim pengaduan', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Terjadi kesalahan saat mengirim pengaduan', 'error');
                    })
                    .finally(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    });
            }

            // Select kategori pengaduan
            function selectKategori(kategoriId, element) {
                // Update form kategori select
                const kategoriSelect = document.querySelector('select[name="kategori"]');
                kategoriSelect.value = kategoriId;

                // Visual feedback
                document.querySelectorAll('.kategori-card').forEach(card => {
                    card.classList.remove('ring-2', 'ring-teal-400', 'bg-teal-50');
                });

                element.classList.add('ring-2', 'ring-teal-400');

                // Scroll to form
                const form = document.getElementById('pengaduanForm');
                const offset = 120;
                const top = form.offsetTop - offset;

                window.scrollTo({
                    top: top,
                    behavior: 'smooth'
                });

                // Focus on judul input after scroll
                setTimeout(() => {
                    document.querySelector('input[name="judul"]').focus();
                }, 800);
            }

            // Handle file input changes for bukti upload
            document.addEventListener('change', function(e) {
                if (e.target.type === 'file' && e.target.name === 'bukti[]') {
                    const infoElement = document.getElementById(e.target.id + '-info');
                    if (e.target.files.length > 0) {
                        const file = e.target.files[0];
                        const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB

                        if (file.size > 5 * 1024 * 1024) { // 5MB limit
                            showToast('Ukuran file maksimal 5MB', 'error');
                            e.target.value = '';
                            infoElement.textContent = 'Klik untuk upload';
                            return;
                        }

                        infoElement.textContent = `${file.name} (${fileSize} MB)`;
                        infoElement.className = 'text-sm text-emerald-600';
                    } else {
                        infoElement.textContent = 'Klik untuk upload';
                        infoElement.className = 'text-sm text-slate-500';
                    }
                }
            });

            // Character counter for deskripsi
            document.addEventListener('input', function(e) {
                if (e.target.name === 'deskripsi') {
                    const current = e.target.value.length;
                    const min = 50;

                    let counterElement = document.getElementById('deskripsi-counter');
                    if (!counterElement) {
                        counterElement = document.createElement('div');
                        counterElement.id = 'deskripsi-counter';
                        counterElement.className = 'text-sm mt-1';
                        e.target.parentNode.appendChild(counterElement);
                    }

                    if (current < min) {
                        counterElement.textContent = `${current}/${min} karakter (minimum)`;
                        counterElement.className = 'text-sm mt-1 text-amber-600';
                    } else {
                        counterElement.textContent = `${current} karakter`;
                        counterElement.className = 'text-sm mt-1 text-emerald-600';
                    }
                }
            });

            // Scroll spy for navigation tabs
            function updateActiveTab() {
                const sections = ['surat-online', 'arsip-surat', 'pengaduan-warga', 'kategori-pengaduan'];
                const scrollPosition = window.scrollY + 200;

                sections.forEach(sectionId => {
                    const section = document.getElementById(sectionId);
                    const tab = document.querySelector(`button[onclick="scrollToSection('${sectionId}')"]`);

                    if (section && tab) {
                        const sectionTop = section.offsetTop;
                        const sectionBottom = sectionTop + section.offsetHeight;

                        if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                            // Remove active from all tabs
                            document.querySelectorAll('.nav-tab').forEach(t => {
                                t.classList.remove('active', 'border-teal-600', 'text-teal-600');
                                t.classList.add('border-transparent', 'text-slate-500');
                            });

                            // Add active to current tab
                            tab.classList.add('active', 'border-teal-600', 'text-teal-600');
                            tab.classList.remove('border-transparent', 'text-slate-500');
                        }
                    }
                });
            }

            // Add scroll listener
            window.addEventListener('scroll', updateActiveTab);

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                updateActiveTab();
            });

            // Initialize
            document.addEventListener('DOMContentLoaded', function() {
                // Set default surat selection
                updatePersyaratan('ktp');

                // Handle file input changes
                document.addEventListener('change', function(e) {
                    if (e.target.type === 'file') {
                        const label = e.target.nextElementSibling;
                        const fileInfo = label.querySelector('div > div:last-child');
                        if (e.target.files.length > 0) {
                            fileInfo.textContent = `File dipilih: ${e.target.files[0].name}`;
                            fileInfo.className = 'text-sm text-emerald-600';
                        } else {
                            fileInfo.textContent = 'Klik untuk upload file (PDF, JPG, PNG)';
                            fileInfo.className = 'text-sm text-slate-500';
                        }
                    }
                });
            });
        </script>
    @endpush
    @push('styles')
        <style>
            /* Dynamic color classes untuk kategori */
            .bg-sky-50 {
                background-color: rgb(240 249 255);
            }

            .bg-sky-100 {
                background-color: rgb(224 242 254);
            }

            .bg-sky-600 {
                background-color: rgb(2 132 199);
            }

            .text-sky-600 {
                color: rgb(2 132 199);
            }

            .text-sky-700 {
                color: rgb(3 105 161);
            }

            .border-sky-100 {
                border-color: rgb(224 242 254);
            }

            .bg-amber-50 {
                background-color: rgb(255 251 235);
            }

            .bg-amber-100 {
                background-color: rgb(254 243 199);
            }

            .bg-amber-600 {
                background-color: rgb(217 119 6);
            }

            .text-amber-600 {
                color: rgb(217 119 6);
            }

            .text-amber-700 {
                color: rgb(180 83 9);
            }

            .border-amber-100 {
                border-color: rgb(254 243 199);
            }

            .bg-pink-50 {
                background-color: rgb(253 242 248);
            }

            .bg-pink-100 {
                background-color: rgb(252 231 243);
            }

            .bg-pink-600 {
                background-color: rgb(219 39 119);
            }

            .text-pink-600 {
                color: rgb(219 39 119);
            }

            .text-pink-700 {
                color: rgb(190 24 93);
            }

            .border-pink-100 {
                border-color: rgb(252 231 243);
            }

            .bg-indigo-50 {
                background-color: rgb(238 242 255);
            }

            .bg-indigo-100 {
                background-color: rgb(224 231 255);
            }

            .bg-indigo-600 {
                background-color: rgb(79 70 229);
            }

            .text-indigo-600 {
                color: rgb(79 70 229);
            }

            .text-indigo-700 {
                color: rgb(67 56 202);
            }

            .border-indigo-100 {
                border-color: rgb(224 231 255);
            }

            /* Smooth transitions */
            .kategori-card {
                transition: all 0.3s ease-in-out;
            }

            .kategori-card:hover {
                transform: translateY(-4px);
            }

            /* Progress bar animation */
            @keyframes progressFill {
                from {
                    width: 0%;
                }

                to {
                    width: var(--progress-width);
                }
            }

            .progress-animated {
                animation: progressFill 1s ease-out;
            }

            /* Form validation styles */
            .form-error {
                border-color: rgb(239 68 68);
                background-color: rgb(254 242 242);
            }

            .form-success {
                border-color: rgb(34 197 94);
                background-color: rgb(240 253 244);
            }

            /* Mobile responsive adjustments */
            @media (max-width: 768px) {
                .nav-tab {
                    font-size: 0.875rem;
                    padding: 0.75rem 0.5rem;
                }

                .kategori-card {
                    padding: 1rem;
                }

                .kategori-card h3 {
                    font-size: 1rem;
                }
            }
        </style>
    @endpush

@endsection
