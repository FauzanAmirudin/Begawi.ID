@extends('layouts.desa')

@section('title', 'Galeri & Wisata Desa')

@section('content')
<div class="min-h-screen bg-slate-50">
    
    <!-- ============================================ -->
    <!-- SECTION 1: GALERI DESA -->
    <!-- ============================================ -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <!-- Header Galeri -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-slate-800 mb-4">🖼️ Galeri Desa</h1>
                <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                    Dokumentasi kegiatan dan keindahan desa dalam bentuk foto dan video
                </p>
            </div>

            <!-- Sub-section: Upload Foto & Video -->
            <div class="mb-16">
                <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
                    <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Upload Foto & Video
                    </h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Form Upload -->
                        <div>
                                    @if (session('success'))
                                    <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl px-4 py-3 text-emerald-700 flex items-center gap-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm font-semibold">{{ session('success') }}</span>
                                    </div>
                                    @endif

                                    @if (session('error'))
                                    <div class="mb-6 bg-rose-50 border border-rose-200 rounded-2xl px-4 py-3 text-rose-600 flex items-center gap-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-sm font-semibold">{{ session('error') }}</span>
                                    </div>
                                    @endif

                                    @if ($errors->any())
                                    <div class="mb-6 bg-rose-50 border border-rose-200 rounded-2xl px-4 py-3 text-rose-600">
                                        <p class="text-sm font-semibold mb-2">Periksa kembali formulir:</p>
                                        <ul class="list-disc list-inside text-sm space-y-1">
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                            <form action="{{ route('desa.galeri-wisata.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                
                                <!-- Judul -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Judul Kegiatan</label>
                                            <input type="text" name="title" value="{{ old('title') }}" required
                                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                           placeholder="Contoh: Gotong Royong Januari 2025">
                                            @error('title')
                                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                            @enderror
                                </div>

                                <!-- Upload Area -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Upload File</label>
                                    <div class="border-2 border-dashed border-primary-400 rounded-2xl p-8 text-center hover:bg-primary-50 transition-colors cursor-pointer">
                                        <svg class="w-10 h-10 text-primary-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="text-slate-600 mb-2">Tarik file ke sini atau <span class="text-primary-600 font-semibold">pilih file</span></p>
                                                <p class="text-xs text-slate-500">Maksimal 6MB - Format: JPG, JPEG, PNG, GIF</p>
                                                <input type="file" name="file" accept="image/*" required class="hidden">
                                    </div>
                                            @error('file')
                                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                            @enderror
                                </div>

                                <!-- Row: Kategori & Tahun -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                                                <select name="category" required
                                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                    <option value="">Pilih Kategori</option>
                                                    <option value="kegiatan" {{ old('category') === 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                                    <option value="lomba" {{ old('category') === 'lomba' ? 'selected' : '' }}>Lomba</option>
                                                    <option value="sosialisasi" {{ old('category') === 'sosialisasi' ? 'selected' : '' }}>Sosialisasi</option>
                                                    <option value="hari-besar" {{ old('category') === 'hari-besar' ? 'selected' : '' }}>Hari Besar</option>
                                                    <option value="panen" {{ old('category') === 'panen' ? 'selected' : '' }}>Panen</option>
                                                    <option value="gotong-royong" {{ old('category') === 'gotong-royong' ? 'selected' : '' }}>Gotong Royong</option>
                                        </select>
                                                @error('category')
                                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                                @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
                                                <input type="number" name="year" required min="2000" max="{{ date('Y') + 1 }}" value="{{ old('year', date('Y')) }}"
                                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                @error('year')
                                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                                @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" 
                                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-300">
                                    Upload ke Galeri
                                </button>
                            </form>
                        </div>

                        <!-- Preview Area -->
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Preview Upload Terbaru</h3>
                            
                            <div class="space-y-4 mb-6">
                                <!-- Preview Item 1 -->
                                <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl">
                                    <div class="w-16 h-16 bg-primary-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-slate-800">Festival Budaya.jpg</h4>
                                        <p class="text-sm text-slate-500">2.3 MB • Kegiatan • 2024</p>
                                    </div>
                                    <span class="text-primary-600 font-medium text-sm">✓ Berhasil</span>
                                </div>

                                <!-- Preview Item 2 (Progress) -->
                                <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl">
                                    <div class="w-16 h-16 bg-amber-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-slate-800">Panen_Raya.mp4</h4>
                                        <p class="text-sm text-slate-500">8.7 MB • Panen • 2024</p>
                                        <div class="w-full bg-slate-200 rounded-full h-2 mt-2">
                                            <div class="bg-primary-500 h-2 rounded-full" style="width: 65%"></div>
                                        </div>
                                    </div>
                                    <span class="text-primary-600 font-medium text-sm">65%</span>
                                </div>
                            </div>

                            <!-- Upload Stats -->
                            <div class="pt-6 border-t border-slate-200">
                                <h4 class="font-semibold text-slate-800 mb-4">Statistik Upload</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center p-3 bg-primary-50 rounded-xl">
                                        <div class="text-2xl font-bold text-primary-600">{{ $totalFoto ?? 0 }}</div>
                                        <div class="text-sm text-slate-600">Total Foto</div>
                                    </div>
                                    <div class="text-center p-3 bg-amber-50 rounded-xl">
                                        <div class="text-2xl font-bold text-amber-600">{{ $totalVideo ?? 0 }}</div>
                                        <div class="text-sm text-slate-600">Total Video</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-section: Galeri -->
            <div>
                <div class="flex flex-col sm:flex-row gap-4 mb-8 justify-between items-center">
                    <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Galeri
                    </h2>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <!-- Filter Tahun -->
                        <select class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Semua Tahun</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                        </select>

                        <!-- Filter Jenis -->
                        <select class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Semua Konten</option>
                            <option value="foto">Foto</option>
                            <option value="video">Video</option>
                        </select>

                        <!-- Button Lihat Semua Foto -->
                        <a href="{{ route('desa.galeri-wisata.galeri-foto') }}" 
                           class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-2 rounded-xl transition-colors duration-300 flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Lihat Semua Foto
                        </a>
                    </div>
                </div>

                <!-- Gallery Grid -->
                @if(isset($galleryItems) && $galleryItems->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($galleryItems as $item)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-lg hover:scale-[1.02] transition-all duration-300 cursor-pointer group">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            @if($item['type'] === 'video')
                            <div class="absolute inset-0 bg-gradient-to-br from-primary-600 to-primary-800 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                            <img src="{{ $item['gambar'] }}" 
                                 alt="{{ $item['judul'] }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @if($item['type'] === 'video')
                            <div class="absolute top-3 right-3 bg-black/60 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                Video
                            </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $item['judul'] }}</h3>
                            <p class="text-slate-500 text-sm flex items-center gap-1 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $item['tanggal'] }}
                            </p>
                            @if(!empty($item['deskripsi']))
                            <p class="text-slate-600 text-sm leading-relaxed line-clamp-2">
                                {{ $item['deskripsi'] }}
                            </p>
                            @endif
                            @if(!empty($item['kategori']))
                            <p class="text-xs text-primary-600 mt-2 font-medium">{{ $item['kategori'] }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum ada konten galeri</h3>
                    <p class="text-slate-500">Konten galeri akan ditampilkan di sini setelah diupload melalui admin.</p>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- SECTION 2: POTENSI WISATA -->
    <!-- ============================================ -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <!-- Header Wisata -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-slate-800 mb-4">🏕️ Potensi Wisata Desa</h1>
                <p class="text-slate-600 text-lg max-w-3xl mx-auto">
                    Jelajahi keindahan alam dan budaya desa yang mempesona. Temukan destinasi wisata terbaik untuk pengalaman yang tak terlupakan.
                </p>
            </div>

            <!-- Sub-section: Daftar Destinasi -->
            <div class="mb-16">
                <div class="flex flex-col md:flex-row gap-4 mb-8 justify-between items-center">
                    <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Daftar Destinasi
                    </h2>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text" placeholder="Cari destinasi wisata..."
                                   class="pl-10 pr-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 w-64">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <!-- Filter Kategori -->
                        <select class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Semua Kategori</option>
                            <option value="alam">Wisata Alam</option>
                            <option value="budaya">Wisata Budaya</option>
                            <option value="ekonomi">Wisata Ekonomi</option>
                        </select>
                    </div>
                </div>

                <!-- Destinasi Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Destinasi 1 -->
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg hover:scale-[1.02] transition-all duration-300 group cursor-pointer border border-slate-100">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=400&fit=crop" 
                                 alt="Air Terjun Curug Indah" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="bg-primary-600 text-white px-3 py-1 rounded-full text-sm font-medium">Wisata Alam</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button class="bg-amber-400 text-slate-900 font-semibold px-4 py-2 rounded-lg w-full">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-800 mb-2">Air Terjun Curug Indah</h3>
                            <p class="flex items-center gap-1 text-slate-500 text-sm mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                2 km dari pusat desa
                            </p>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Air terjun setinggi 25 meter dengan kolam alami yang jernih. Cocok untuk berenang dan bersantai menikmati keindahan alam.
                            </p>
                        </div>
                    </div>

                    <!-- Destinasi 2 -->
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg hover:scale-[1.02] transition-all duration-300 group cursor-pointer border border-slate-100">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500&h=400&fit=crop" 
                                 alt="Rumah Adat Tradisional" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="bg-amber-600 text-white px-3 py-1 rounded-full text-sm font-medium">Wisata Budaya</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button class="bg-amber-400 text-slate-900 font-semibold px-4 py-2 rounded-lg w-full">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-800 mb-2">Rumah Adat Tradisional</h3>
                            <p class="flex items-center gap-1 text-slate-500 text-sm mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Pusat desa
                            </p>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Museum hidup yang menampilkan arsitektur tradisional dan koleksi benda-benda bersejarah. Tersedia pemandu wisata lokal.
                            </p>
                        </div>
                    </div>

                    <!-- Destinasi 3 -->
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg hover:scale-[1.02] transition-all duration-300 group cursor-pointer border border-slate-100">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500&h=400&fit=crop" 
                                 alt="Kebun Organik Desa" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">Wisata Ekonomi</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button class="bg-amber-400 text-slate-900 font-semibold px-4 py-2 rounded-lg w-full">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-800 mb-2">Kebun Organik Desa</h3>
                            <p class="flex items-center gap-1 text-slate-500 text-sm mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                1.5 km dari pusat desa
                            </p>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Pengalaman bercocok tanam organik dengan petani lokal. Wisatawan dapat ikut panen dan membeli produk segar langsung.
                            </p>
                        </div>
                    </div>

                    <!-- Destinasi 4 -->
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg hover:scale-[1.02] transition-all duration-300 group cursor-pointer border border-slate-100">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=500&h=400&fit=crop" 
                                 alt="Bukit Sunrise Point" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="bg-primary-600 text-white px-3 py-1 rounded-full text-sm font-medium">Wisata Alam</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button class="bg-amber-400 text-slate-900 font-semibold px-4 py-2 rounded-lg w-full">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-800 mb-2">Bukit Sunrise Point</h3>
                            <p class="flex items-center gap-1 text-slate-500 text-sm mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                3 km dari pusat desa
                            </p>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Spot terbaik untuk menikmati sunrise dan sunset dengan pemandangan 360 derajat. Tersedia area camping dan gazebo.
                            </p>
                        </div>
                    </div>

                    <!-- Destinasi 5 -->
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg hover:scale-[1.02] transition-all duration-300 group cursor-pointer border border-slate-100">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?w=500&h=400&fit=crop" 
                                 alt="Sanggar Kerajinan Bambu" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="bg-amber-600 text-white px-3 py-1 rounded-full text-sm font-medium">Wisata Budaya</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button class="bg-amber-400 text-slate-900 font-semibold px-4 py-2 rounded-lg w-full">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-800 mb-2">Sanggar Kerajinan Bambu</h3>
                            <p class="flex items-center gap-1 text-slate-500 text-sm mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                0.5 km dari pusat desa
                            </p>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Workshop membuat kerajinan bambu dengan pengrajin lokal. Wisatawan dapat belajar dan membawa pulang hasil karya.
                            </p>
                        </div>
                    </div>

                    <!-- Destinasi 6 -->
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg hover:scale-[1.02] transition-all duration-300 group cursor-pointer border border-slate-100">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1574263867128-a3d5c1b1decc?w=500&h=400&fit=crop" 
                                 alt="Danau Wisata Keluarga" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="bg-primary-600 text-white px-3 py-1 rounded-full text-sm font-medium">Wisata Alam</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button class="bg-amber-400 text-slate-900 font-semibold px-4 py-2 rounded-lg w-full">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-800 mb-2">Danau Wisata Keluarga</h3>
                            <p class="flex items-center gap-1 text-slate-500 text-sm mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                4 km dari pusat desa
                            </p>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Danau buatan dengan fasilitas perahu kayuh, area piknik, dan playground anak. Ideal untuk wisata keluarga dan rekreasi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-section: Fasilitas Pendukung -->
            <div class="mb-16">
                <div class="bg-slate-50 rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-slate-800 mb-8 flex items-center gap-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h10M7 11h10M7 15h10"></path>
                        </svg>
                        Fasilitas Pendukung
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Fasilitas 1: Transportasi -->
                        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                            <div class="w-16 h-16 bg-sky-100 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Transportasi</h3>
                            <p class="text-slate-600 text-sm mb-4">Layanan ojek dan angkot menuju destinasi wisata</p>
                            <div class="space-y-2 text-sm">
                                <p class="flex justify-between">
                                    <span class="text-slate-500">Kontak:</span>
                                    <span class="text-slate-800 font-medium">0812-3456-7890</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-slate-500">Tarif:</span>
                                    <span class="text-slate-800 font-medium">Rp 15.000/trip</span>
                                </p>
                            </div>
                            <button class="bg-primary-600 text-white text-sm px-3 py-1 rounded-lg mt-4 hover:bg-primary-700 transition-colors">
                                Hubungi
                            </button>
                        </div>

                        <!-- Fasilitas 2: Penginapan -->
                        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                            <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4M8 7h8"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Penginapan</h3>
                            <p class="text-slate-600 text-sm mb-4">Homestay dan guest house dengan fasilitas lengkap</p>
                            <div class="space-y-2 text-sm">
                                <p class="flex justify-between">
                                    <span class="text-slate-500">Kontak:</span>
                                    <span class="text-slate-800 font-medium">0813-4567-8901</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-slate-500">Tarif:</span>
                                    <span class="text-slate-800 font-medium">Rp 150.000/malam</span>
                                </p>
                            </div>
                            <button class="bg-primary-600 text-white text-sm px-3 py-1 rounded-lg mt-4 hover:bg-primary-700 transition-colors">
                                Hubungi
                            </button>
                        </div>

                        <!-- Fasilitas 3: Pemandu Wisata -->
                        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                            <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Pemandu Wisata</h3>
                            <p class="text-slate-600 text-sm mb-4">Guide lokal berpengalaman dan berlisensi</p>
                            <div class="space-y-2 text-sm">
                                <p class="flex justify-between">
                                    <span class="text-slate-500">Kontak:</span>
                                    <span class="text-slate-800 font-medium">0814-5678-9012</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="text-slate-500">Tarif:</span>
                                    <span class="text-slate-800 font-medium">Rp 100.000/hari</span>
                                </p>
                            </div>
                            <button class="bg-primary-600 text-white text-sm px-3 py-1 rounded-lg mt-4 hover:bg-primary-700 transition-colors">
                                Hubungi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-section: Peta Wisata -->
            <div>
                <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    Peta Wisata
                </h2>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-md overflow-hidden">
                    <!-- Map Controls -->
                    <div class="bg-slate-50 p-4 border-b border-slate-200">
                        <div class="flex flex-wrap gap-3 items-center">
                            <span class="text-sm font-medium text-slate-700">Filter Lokasi:</span>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" class="w-4 h-4 text-primary-600 rounded focus:ring-primary-500" checked>
                                <span class="text-sm text-primary-600">● Wisata Alam</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" class="w-4 h-4 text-amber-600 rounded focus:ring-amber-500" checked>
                                <span class="text-sm text-amber-600">● Wisata Budaya</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" class="w-4 h-4 text-primary-600 rounded focus:ring-green-500" checked>
                                <span class="text-sm text-primary-600">● Wisata Ekonomi</span>
                            </label>
                        </div>
                    </div>

                    <!-- Map Embed -->
                    <div class="aspect-[16/9] bg-slate-100 flex items-center justify-center">
                        <!-- Placeholder untuk Google Maps -->
                        <div class="text-center">
                            <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            <p class="text-slate-500 text-lg font-medium">Peta Interaktif Wisata Desa</p>
                            <p class="text-slate-400 text-sm">Google Maps akan dimuat di sini</p>
                        </div>
                        <!-- 
                        Untuk implementasi sesungguhnya, ganti dengan:
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=..." 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        -->
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection