@extends('layouts.admin')

@section('title', 'Integrasi Template')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Integrasi Template</h1>
            <p class="text-sm text-gray-500 mt-1">Pilih template default untuk website desa dan UMKM</p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <!-- Template Selection -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 max-w-3xl">
        <form method="POST" action="{{ route('admin.websites.template.update') }}" class="space-y-8">
            @csrf

            <!-- Template Desa -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-4">
                    Template Default untuk Website Desa
                </label>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($templates as $key => $name)
                    <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer hover:bg-gray-50 transition {{ (session('default_template_desa', $defaultTemplateDesa) == $key) ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200' }}">
                        <input type="radio" name="template_desa" value="{{ $key }}" {{ (session('default_template_desa', $defaultTemplateDesa) == $key) ? 'checked' : '' }} class="sr-only">
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">{{ $name }}</div>
                            <div class="text-xs text-gray-500 mt-1">Template {{ $key }}</div>
                        </div>
                        @if((session('default_template_desa', $defaultTemplateDesa) == $key))
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        @endif
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Template UMKM -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-4">
                    Template Default untuk Website UMKM
                </label>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($templates as $key => $name)
                    <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer hover:bg-gray-50 transition {{ (session('default_template_umkm', $defaultTemplateUmkm) == $key) ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200' }}">
                        <input type="radio" name="template_umkm" value="{{ $key }}" {{ (session('default_template_umkm', $defaultTemplateUmkm) == $key) ? 'checked' : '' }} class="sr-only">
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">{{ $name }}</div>
                            <div class="text-xs text-gray-500 mt-1">Template {{ $key }}</div>
                        </div>
                        @if((session('default_template_umkm', $defaultTemplateUmkm) == $key))
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        @endif
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Submit -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-medium hover:shadow-lg transition">
                    Simpan Template Default
                </button>
                <a href="{{ route('admin.websites.template') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

