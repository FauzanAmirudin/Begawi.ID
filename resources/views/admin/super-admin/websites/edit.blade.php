@extends('layouts.admin')

@section('title', 'Edit Website')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Edit Website</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi website</p>
        </div>
        <a href="{{ route('admin.websites.show', $website) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 max-w-2xl">
        <form method="POST" action="{{ route('admin.websites.update', $website) }}" class="space-y-6">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Website</label>
                <input type="text" id="name" name="name" value="{{ old('name', $website->name) }}" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div>
                <label for="url" class="block text-sm font-medium text-gray-700 mb-2">URL</label>
                <input type="text" id="url" name="url" value="{{ old('url', $website->url) }}" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div>
                <label for="custom_domain" class="block text-sm font-medium text-gray-700 mb-2">Domain Custom</label>
                <input type="text" id="custom_domain" name="custom_domain" value="{{ old('custom_domain', $website->custom_domain) }}" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status" name="status" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="active" {{ old('status', $website->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="suspended" {{ old('status', $website->status) == 'suspended' ? 'selected' : '' }}>Ditangguhkan</option>
                    <option value="inactive" {{ old('status', $website->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div>
                <label for="template_id" class="block text-sm font-medium text-gray-700 mb-2">Template</label>
                <input type="text" id="template_id" name="template_id" value="{{ old('template_id', $website->template_id) }}" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea id="notes" name="notes" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('notes', $website->notes) }}</textarea>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-medium hover:shadow-lg transition">
                    Perbarui Website
                </button>
                <a href="{{ route('admin.websites.show', $website) }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

