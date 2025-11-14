@extends('layouts.admin')

@section('title', 'Prestasi & Program')

@php
    $formContext = old('form_context');
@endphp

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6" x-data="{ achievementModal: false, achievementTab: 'prestasi' }" x-cloak>
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

    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.desa-management.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 font-semibold">Prestasi & Program</p>
            </div>
            <h1 class="text-3xl font-semibold text-gray-900">Catatan Prestasi dan Program Unggulan Desa</h1>
            <p class="text-sm text-gray-500 mt-1">Dokumentasikan raihan prestasi desa serta program strategis yang sedang berjalan.</p>
        </div>
        <button type="button" @click="achievementModal = true" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-purple-500 rounded-xl hover:bg-purple-400 transition">
            Tambah Prestasi / Program
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Prestasi Desa</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $achievements->count() }} penghargaan dicatat</p>
                </div>
                <button class="text-xs font-semibold text-purple-500 hover:text-purple-400">Kelola</button>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($achievements as $achievement)
                <div class="px-6 py-4 hover:bg-purple-50/40 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $achievement->title }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $achievement->organizer }} · {{ $achievement->category }}</p>
                        </div>
                        <span class="text-xs font-semibold text-purple-500 bg-purple-50 px-3 py-1 rounded-full">
                            {{ $achievement->year }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mt-3 leading-relaxed">{{ $achievement->description }}</p>
                    <form action="{{ route('admin.desa-management.achievements.destroy', $achievement) }}" method="POST" onsubmit="return confirm('Hapus prestasi ini?')" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-semibold text-gray-400 hover:text-red-500">Hapus</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Program Unggulan</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $programs->count() }} program aktif</p>
                </div>
                <button class="text-xs font-semibold text-purple-500 hover:text-purple-400">Kelola</button>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($programs as $program)
                <div class="px-6 py-4 hover:bg-purple-50/40 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $program->title }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $program->lead }} · {{ $program->period }}</p>
                        </div>
                        <span class="inline-flex items-center gap-2 text-xs font-semibold text-purple-500">
                            <span class="w-20 h-2 bg-purple-100 rounded-full overflow-hidden">
                                <span class="block h-full bg-purple-500" style="width: {{ $program->progress ?? 0 }}%"></span>
                            </span>
                            {{ $program->progress ?? 0 }}%
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mt-3 leading-relaxed">{{ $program->description }}</p>
                    <form action="{{ route('admin.desa-management.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Hapus program ini?')" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-semibold text-gray-400 hover:text-red-500">Hapus</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Achievement / Program Modal -->
    <div
        x-show="achievementModal"
        x-transition.opacity
        x-trap="achievementModal"
        @keydown.escape.window="achievementModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="achievementModal = false"></div>
        <div class="relative w-full max-w-4xl lg:max-w-5xl bg-white rounded-[32px] shadow-2xl max-h-[90vh] overflow-hidden">
            <div class="sticky top-0 flex items-start justify-between gap-6 px-6 sm:px-10 py-6 bg-white/95 backdrop-blur border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-purple-500">Prestasi & Program</p>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mt-2">Catat Prestasi atau Program</h3>
                    <p class="text-sm text-gray-500 mt-1">Gunakan tab di bawah ini untuk memilih jenis data yang akan ditambahkan.</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600" @click="achievementModal = false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto max-h-[calc(90vh-160px)]">
                <div class="px-6 sm:px-10 pt-6">
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" @click="achievementTab = 'prestasi'" :class="achievementTab === 'prestasi' ? 'bg-purple-600 text-white' : 'bg-purple-50 text-purple-600'" class="px-4 py-2 rounded-xl text-sm font-semibold transition">Prestasi</button>
                        <button type="button" @click="achievementTab = 'program'" :class="achievementTab === 'program' ? 'bg-purple-600 text-white' : 'bg-purple-50 text-purple-600'" class="px-4 py-2 rounded-xl text-sm font-semibold transition">Program Unggulan</button>
                    </div>
                </div>
                <div class="px-6 sm:px-10 py-6 space-y-8">
                    <form x-show="achievementTab === 'prestasi'" x-transition.opacity action="{{ route('admin.desa-management.achievements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="form_context" value="achievement">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul Prestasi</label>
                                <input type="text" name="title" value="{{ $formContext === 'achievement' ? old('title') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('title', 'achievement')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tahun</label>
                                <input type="number" name="year" value="{{ $formContext === 'achievement' ? old('year') : now()->year }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('year', 'achievement')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                <input type="text" name="category" value="{{ $formContext === 'achievement' ? old('category') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('category', 'achievement')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Penyelenggara</label>
                                <input type="text" name="organizer" value="{{ $formContext === 'achievement' ? old('organizer') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('organizer', 'achievement')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" rows="4" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500">{{ $formContext === 'achievement' ? old('description') : '' }}</textarea>
                            @error('description', 'achievement')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lampiran (PDF/Foto)</label>
                            <input type="file" name="attachment" class="mt-2 w-full text-sm">
                            @error('attachment', 'achievement')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-wrap items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" @click="achievementModal = false">Tutup</button>
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 text-white text-sm font-semibold hover:bg-purple-500 transition">Simpan Prestasi</button>
                        </div>
                    </form>

                    <form x-show="achievementTab === 'program'" x-transition.opacity action="{{ route('admin.desa-management.programs.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="form_context" value="program">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul Program</label>
                            <input type="text" name="title" value="{{ $formContext === 'program' ? old('title') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                            @error('title', 'program')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Periode</label>
                                <input type="text" name="period" value="{{ $formContext === 'program' ? old('period') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('period', 'program')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                                <input type="text" name="lead" value="{{ $formContext === 'program' ? old('lead') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('lead', 'program')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Progress (%)</label>
                                <input type="number" name="progress" value="{{ $formContext === 'program' ? old('progress', 0) : 0 }}" min="0" max="100" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                @error('progress', 'program')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status Program</label>
                                <select name="status" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500">
                                    @foreach([\App\Models\VillageProgram::STATUS_ACTIVE, \App\Models\VillageProgram::STATUS_COMPLETED, \App\Models\VillageProgram::STATUS_ON_HOLD] as $status)
                                    <option value="{{ $status }}" {{ ($formContext === 'program' ? old('status') : null) === $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status', 'program')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Mulai</label>
                                    <input type="date" name="start_date" value="{{ $formContext === 'program' ? old('start_date') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                    @error('start_date', 'program')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Selesai</label>
                                    <input type="date" name="end_date" value="{{ $formContext === 'program' ? old('end_date') : '' }}" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500" />
                                    @error('end_date', 'program')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi Program</label>
                            <textarea name="description" rows="4" class="mt-1 w-full rounded-xl border-gray-200 focus:border-purple-500 focus:ring-purple-500">{{ $formContext === 'program' ? old('description') : '' }}</textarea>
                            @error('description', 'program')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-wrap items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" @click="achievementModal = false">Tutup</button>
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 text-white text-sm font-semibold hover:bg-purple-500 transition">Simpan Program</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

