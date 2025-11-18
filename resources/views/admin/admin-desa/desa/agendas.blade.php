@extends('layouts.admin')

@section('title', 'Agenda Kegiatan')

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <div class="p-6 space-y-6" x-data="{ agendaModal: {{ isset($editingAgenda) ? 'true' : 'false' }}, editingAgenda: {{ $editingAgenda->id ?? 'null' }} }" x-cloak>
        @if (session('success'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
                <button class="text-xs text-emerald-600 hover:text-emerald-500"
                    @click="$el.parentElement.remove()">Tutup</button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('admin.desa-management.index') }}" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 font-semibold">Agenda Kegiatan</p>
                </div>
                <h1 class="text-3xl font-semibold text-gray-900">Kelola Agenda Kegiatan Desa</h1>
                <p class="text-sm text-gray-500 mt-1">Atur jadwal kegiatan, rapat, pelatihan, dan acara desa.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('desa.berita.agenda') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition">
                    Lihat Halaman Agenda
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <button type="button" @click="agendaModal = true; editingAgenda = null"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-500 transition">
                    Tambah Agenda
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Daftar Agenda</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $agendas->count() }} agenda tersedia</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            <th class="px-6 py-3">Judul</th>
                            <th class="px-6 py-3">Tanggal & Waktu</th>
                            <th class="px-6 py-3">Lokasi</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($agendas as $agenda)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">{{ $agenda->title }}</p>
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $agenda->description }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $agenda->date->translatedFormat('d M Y') }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($agenda->time)->format('H:i') }} WIB</p>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <p class="text-sm">{{ $agenda->location }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600">
                                        {{ $agenda->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $agenda->is_published ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-600' }}">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full {{ $agenda->is_published ? 'bg-emerald-500' : 'bg-gray-500' }}"></span>
                                        {{ $agenda->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('desa.berita.agenda-detail', $agenda->id) }}" target="_blank"
                                            class="text-xs font-semibold text-slate-400 hover:text-indigo-500">
                                            Lihat
                                        </a>
                                        <a href="{{ route('admin.desa-management.agendas.edit', $agenda) }}"
                                            class="text-xs font-semibold text-slate-400 hover:text-indigo-500">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.desa-management.agendas.destroy', $agenda) }}"
                                            method="POST" onsubmit="return confirm('Hapus agenda ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-xs font-semibold text-gray-400 hover:text-red-500">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <p class="text-sm text-gray-500">Belum ada agenda. Klik "Tambah Agenda" untuk membuat
                                        agenda baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Agenda Modal -->
        <div x-show="agendaModal" x-transition.opacity x-trap="agendaModal" @keydown.escape.window="agendaModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="agendaModal = false"></div>
            <div class="relative w-full max-w-4xl bg-white rounded-[32px] shadow-2xl max-h-[90vh] overflow-hidden">
                <div
                    class="sticky top-0 flex items-start justify-between gap-6 px-6 sm:px-10 py-6 bg-white/95 backdrop-blur border-b border-gray-100">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-indigo-500">Agenda Kegiatan</p>
                        <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mt-2"
                            x-text="editingAgenda ? 'Edit Agenda' : 'Tambah Agenda Baru'"></h3>
                        <p class="text-sm text-gray-500 mt-1">Isi informasi lengkap untuk agenda kegiatan desa.</p>
                    </div>
                    <button type="button" class="text-gray-400 hover:text-gray-600"
                        @click="agendaModal = false; editingAgenda = null">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="overflow-y-auto max-h-[calc(90vh-160px)]">
                    <form
                        action="{{ isset($editingAgenda) ? route('admin.desa-management.agendas.update', $editingAgenda) : route('admin.desa-management.agendas.store') }}"
                        method="POST" class="px-6 sm:px-10 py-6 space-y-8">
                        @csrf
                        @if (isset($editingAgenda))
                            @method('PUT')
                        @endif
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <section class="space-y-5">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-indigo-500">Informasi
                                        Utama</p>
                                    <h4 class="text-lg font-semibold text-gray-900 mt-1">Detail Agenda</h4>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Judul Agenda</label>
                                    <input type="text" name="title"
                                        value="{{ old('title', $editingAgenda->title ?? '') }}" required
                                        class="mt-1 w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2" />
                                    @error('title', 'agenda')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea name="description" rows="3"
                                        class="mt-1 w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2">{{ old('description', $editingAgenda->description ?? '') }}</textarea>
                                    @error('description', 'agenda')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                                        <input type="date" name="date"
                                            value="{{ old('date', isset($editingAgenda) ? $editingAgenda->date->format('Y-m-d') : '') }}"
                                            required
                                            class="mt-1 w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2" />
                                        @error('date', 'agenda')
                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Waktu</label>
                                        <input type="time" name="time"
                                            value="{{ old('time', isset($editingAgenda) ? \Carbon\Carbon::parse($editingAgenda->time)->format('H:i') : '') }}"
                                            required
                                            class="mt-1 w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2" />
                                        @error('time', 'agenda')
                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                                    <input type="text" name="location"
                                        value="{{ old('location', $editingAgenda->location ?? '') }}" required
                                        class="mt-1 w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2" />
                                    @error('location', 'agenda')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <select name="category" required
                                        class="mt-1 w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2">
                                        @php
                                            $selectedCategory = old('category', $editingAgenda->category ?? 'Acara');
                                        @endphp
                                        <option value="Rapat" {{ $selectedCategory === 'Rapat' ? 'selected' : '' }}>Rapat
                                        </option>
                                        <option value="Pelatihan"
                                            {{ $selectedCategory === 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                        <option value="Acara" {{ $selectedCategory === 'Acara' ? 'selected' : '' }}>Acara
                                        </option>
                                        <option value="Kesehatan"
                                            {{ $selectedCategory === 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                    </select>
                                    @error('category', 'agenda')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="is_published" id="is_published" value="1"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                        {{ old('is_published', isset($editingAgenda) ? $editingAgenda->is_published : true) ? 'checked' : '' }}>
                                    <label for="is_published" class="text-sm text-gray-700">Publikasikan agenda</label>
                                </div>
                            </section>
                            <section class="space-y-5">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-indigo-500">Informasi
                                        Tambahan</p>
                                    <h4 class="text-lg font-semibold text-gray-900 mt-1">Detail Acara</h4>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Alur Acara
                                        (Timeline)</label>
                                    <div id="timeline-container" class="space-y-2">
                                        <div class="timeline-item flex gap-2">
                                            <input type="text" name="timeline[0][time]"
                                                placeholder="Waktu (contoh: 08.00)"
                                                class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
                                            <input type="text" name="timeline[0][title]" placeholder="Judul"
                                                class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
                                            <input type="text" name="timeline[0][desc]" placeholder="Deskripsi"
                                                class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
                                        </div>
                                    </div>
                                    <button type="button" onclick="addTimelineItem()"
                                        class="mt-2 text-xs text-indigo-600 hover:text-indigo-500">+ Tambah Item</button>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Checklist Peserta</label>
                                    <div id="checklist-container" class="space-y-2">
                                        <input type="text" name="checklist[0]" placeholder="Item checklist"
                                            class="w-full rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
                                    </div>
                                    <button type="button" onclick="addChecklistItem()"
                                        class="mt-2 text-xs text-indigo-600 hover:text-indigo-500">+ Tambah Item</button>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kontak
                                        Penyelenggara</label>
                                    <div id="organizers-container" class="space-y-2">
                                        <div class="organizer-item flex gap-2">
                                            <input type="text" name="organizers[0][name]" placeholder="Nama"
                                                class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
                                            <input type="text" name="organizers[0][contact]" placeholder="Email"
                                                class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
                                            <input type="text" name="organizers[0][phone]" placeholder="Telepon"
                                                class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
                                        </div>
                                    </div>
                                    <button type="button" onclick="addOrganizerItem()"
                                        class="mt-2 text-xs text-indigo-600 hover:text-indigo-500">+ Tambah
                                        Penyelenggara</button>
                                </div>
                            </section>
                        </div>
                        <div
                            class="flex flex-wrap items-center justify-end gap-3 sticky bottom-0 pt-4 border-t border-gray-100 bg-white">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700"
                                @click="agendaModal = false; editingAgenda = null">Batal</button>
                            <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-500 transition">Simpan
                                Agenda</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let timelineIndex = 1;
            let checklistIndex = 1;
            let organizerIndex = 1;

            function addTimelineItem() {
                const container = document.getElementById('timeline-container');
                const item = document.createElement('div');
                item.className = 'timeline-item flex gap-2';
                item.innerHTML = `
        <input type="text" name="timeline[${timelineIndex}][time]" placeholder="Waktu" class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
        <input type="text" name="timeline[${timelineIndex}][title]" placeholder="Judul" class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
        <input type="text" name="timeline[${timelineIndex}][desc]" placeholder="Deskripsi" class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 px-2">×</button>
    `;
                container.appendChild(item);
                timelineIndex++;
            }

            function addChecklistItem() {
                const container = document.getElementById('checklist-container');
                const item = document.createElement('div');
                item.className = 'flex gap-2';
                item.innerHTML = `
        <input type="text" name="checklist[${checklistIndex}]" placeholder="Item checklist" class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 px-2">×</button>
    `;
                container.appendChild(item);
                checklistIndex++;
            }

            function addOrganizerItem() {
                const container = document.getElementById('organizers-container');
                const item = document.createElement('div');
                item.className = 'organizer-item flex gap-2';
                item.innerHTML = `
        <input type="text" name="organizers[${organizerIndex}][name]" placeholder="Nama" class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
        <input type="text" name="organizers[${organizerIndex}][contact]" placeholder="Email" class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
        <input type="text" name="organizers[${organizerIndex}][phone]" placeholder="Telepon" class="flex-1 rounded-lg border-2 border-gray-300 text-sm px-2 py-1.5" />
        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 px-2">×</button>
    `;
                container.appendChild(item);
                organizerIndex++;
            }
        </script>
    @endpush
@endsection
