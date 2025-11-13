@extends('layouts.admin')

@section('title', 'Kelola Artikel Bantuan')

@section('content')
<div class="p-6">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Support &amp; Pengaduan</p>
                <h1 class="text-2xl font-semibold text-gray-900">Kelola Artikel Bantuan</h1>
                <p class="text-sm text-gray-500">Buat, perbarui, dan publikasikan artikel pusat bantuan untuk seluruh tenant.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.support.documentation') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:border-gray-300 transition">
                    Lihat Dokumentasi
                </a>
                <a href="{{ route('admin.support.articles.create') }}" class="px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:opacity-90 transition">
                    Artikel Baru
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-100 text-sm text-emerald-700 rounded-xl">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pencarian</label>
                    <div class="relative mt-2">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text"
                               name="search"
                               value="{{ $filters['search'] ?? '' }}"
                               class="w-full pl-10 pr-3 py-2 bg-gray-100 border-0 rounded-lg text-sm text-gray-700 focus:bg-white focus:ring-2 focus:ring-purple-500 focus:outline-none"
                               placeholder="Cari judul atau ringkasan artikel...">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori</label>
                    <select name="category" class="mt-2 w-full bg-gray-100 border-0 text-sm text-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <option value="">Semua kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category }}" {{ ($filters['category'] ?? '') === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</label>
                    <select name="status" class="mt-2 w-full bg-gray-100 border-0 text-sm text-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <option value="">Semua status</option>
                        <option value="published" {{ ($filters['status'] ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ ($filters['status'] ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="md:col-span-4 flex items-center justify-end gap-3">
                    @if(!empty($filters))
                    <a href="{{ route('admin.support.articles.index') }}" class="px-4 py-2 bg-gray-100 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-200 transition">
                        Reset
                    </a>
                    @endif
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:opacity-90 transition">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Artikel</h2>
                    <p class="text-xs text-gray-500">{{ $articles->total() }} artikel</p>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-400 uppercase tracking-wide">
                    <span>Terakhir diperbarui</span>
                    <span class="font-semibold text-gray-500">{{ now()->translatedFormat('d M Y') }}</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-xs uppercase tracking-wide text-gray-400">
                            <th class="px-6 py-3">Judul</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Dipublikasikan</th>
                            <th class="px-6 py-3">Views</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($articles as $article)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $article->title }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $article->slug }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $article->category }}</td>
                            <td class="px-6 py-4">
                                @if($article->is_published)
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-600">Published</span>
                                @else
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ optional($article->published_at)->translatedFormat('d M Y H:i') ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ number_format($article->views ?? 0) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.support.documentation.show', $article->slug) }}" class="px-3 py-1 border border-gray-200 text-xs font-medium text-gray-600 rounded-lg hover:border-gray-300 transition">
                                        Pratinjau
                                    </a>
                                    <a href="{{ route('admin.support.articles.edit', $article) }}" class="px-3 py-1 bg-gradient-to-r from-purple-500 to-purple-600 text-xs font-semibold text-white rounded-lg hover:opacity-90 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.support.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 text-xs font-semibold text-red-500 hover:text-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                Belum ada artikel yang dibuat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

