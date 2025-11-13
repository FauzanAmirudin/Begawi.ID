@extends('layouts.admin')

@section('title', 'Edit Paket Langganan')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Edit Paket Langganan</h1>
            <p class="text-sm text-gray-500 mt-1">Edit paket: {{ $package->name }}</p>
        </div>
        <a href="{{ route('admin.finance.packages.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
            Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.finance.packages.update', $package) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Paket *</label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name', $package->name) }}"
                        required
                        placeholder="Contoh: Premium, Bisnis, Gratis"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea 
                        name="description" 
                        rows="3"
                        placeholder="Deskripsi paket..."
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >{{ old('description', $package->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp) *</label>
                        <input 
                            type="number" 
                            name="price" 
                            value="{{ old('price', $package->price) }}"
                            required
                            min="0"
                            step="0.01"
                            placeholder="0"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Durasi (Hari) *</label>
                        <input 
                            type="number" 
                            name="duration_days" 
                            value="{{ old('duration_days', $package->duration_days) }}"
                            required
                            min="1"
                            placeholder="30"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                        @error('duration_days')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Benefit</label>
                    <div id="benefits-container" class="space-y-2">
                        @php
                            $benefits = old('benefits', $package->benefits ?? []);
                        @endphp
                        @if(count($benefits) > 0)
                            @foreach($benefits as $index => $benefit)
                            <div class="flex gap-2">
                                <input 
                                    type="text" 
                                    name="benefits[]" 
                                    value="{{ $benefit }}"
                                    placeholder="Contoh: Unlimited storage"
                                    class="flex-1 px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                >
                                <button type="button" onclick="removeBenefit(this)" class="px-4 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition">
                                    Hapus
                                </button>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" onclick="addBenefit()" class="mt-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                        + Tambah Benefit
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="flex items-center gap-2">
                            <input 
                                type="checkbox" 
                                name="is_active" 
                                value="1"
                                {{ old('is_active', $package->is_active) ? 'checked' : '' }}
                                class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                            >
                            <span class="text-sm font-medium text-gray-700">Aktif</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
                        <input 
                            type="number" 
                            name="sort_order" 
                            value="{{ old('sort_order', $package->sort_order) }}"
                            min="0"
                            placeholder="0"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg font-medium hover:shadow-lg transition">
                        Update Paket
                    </button>
                    <a href="{{ route('admin.finance.packages.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function addBenefit() {
    const container = document.getElementById('benefits-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = `
        <input 
            type="text" 
            name="benefits[]" 
            placeholder="Contoh: Unlimited storage"
            class="flex-1 px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
        >
        <button type="button" onclick="removeBenefit(this)" class="px-4 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition">
            Hapus
        </button>
    `;
    container.appendChild(div);
}

function removeBenefit(button) {
    button.parentElement.remove();
}
</script>
@endsection

