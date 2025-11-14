@extends('layouts.admin')

@section('title', 'Potensi & Wisata')

@php
    use App\Models\VillagePotential;
    use Illuminate\Support\Js;
    use Illuminate\Support\Facades\Storage;

    $formContext = old('form_context');
    $potentialErrorBag = $errors->getBag('potential');
    $shouldOpenPotentialModal = $formContext === 'potential' && ($potentialErrorBag->any() || old('form_mode'));
    $potentialStatuses = [
        VillagePotential::STATUS_ACTIVE,
        VillagePotential::STATUS_DEVELOPMENT,
        VillagePotential::STATUS_INACTIVE,
    ];
    $emptyPotentialData = [
        'id' => null,
        'title' => '',
        'category' => '',
        'status' => VillagePotential::STATUS_ACTIVE,
        'summary' => '',
        'description' => '',
        'map_embed' => '',
        'existing_featured_image' => '',
    ];
    $oldPotentialData = [
        'id' => $formContext === 'potential' ? old('potential_id') : null,
        'title' => $formContext === 'potential' ? old('title') : '',
        'category' => $formContext === 'potential' ? old('category') : '',
        'status' => $formContext === 'potential'
            ? old('status', VillagePotential::STATUS_ACTIVE)
            : VillagePotential::STATUS_ACTIVE,
        'summary' => $formContext === 'potential' ? old('summary') : '',
        'description' => $formContext === 'potential' ? old('description') : '',
        'map_embed' => $formContext === 'potential' ? old('map_embed') : '',
        'existing_featured_image' => $formContext === 'potential' ? old('existing_featured_image') : '',
    ];
    $oldFormMode = $formContext === 'potential' ? old('form_mode', 'create') : 'create';
    $oldFeaturedPreview = '';
    if (! empty($oldPotentialData['existing_featured_image'])) {
        $oldFeaturedPreview = filter_var($oldPotentialData['existing_featured_image'], FILTER_VALIDATE_URL)
            ? $oldPotentialData['existing_featured_image']
            : Storage::url($oldPotentialData['existing_featured_image']);
    }
@endphp

@push('styles')
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div
    class="p-6 space-y-6"
    x-data="{
        potentialModal: {{ $shouldOpenPotentialModal ? 'true' : 'false' }},
        mode: '{{ $oldFormMode }}',
        formAction: '{{ route('admin.desa-management.potentials.store') }}',
        form: {{ Js::from($formContext === 'potential' ? $oldPotentialData : $emptyPotentialData) }},
        featuredPreview: '{{ $formContext === 'potential' ? $oldFeaturedPreview : '' }}',
        resetForm() {
            this.form = {{ Js::from($emptyPotentialData) }};
            this.featuredPreview = '';
            this.formAction = '{{ route('admin.desa-management.potentials.store') }}';
            this.mode = 'create';
            if (this.$refs?.featuredInput) {
                this.$refs.featuredInput.value = '';
            }
        },
        openCreate() {
            this.resetForm();
            this.potentialModal = true;
        },
        openEdit(potential) {
            this.mode = 'edit';
            this.form = {
                id: potential.id,
                title: potential.title || '',
                category: potential.category || '',
                status: potential.status || '{{ VillagePotential::STATUS_ACTIVE }}',
                summary: potential.summary || '',
                description: potential.description || '',
                map_embed: potential.map_embed || '',
                existing_featured_image: potential.existing_featured_image || ''
            };
            this.formAction = potential.update_url;
            this.featuredPreview = potential.featured_image_url || '';
            this.potentialModal = true;
            if (this.$refs?.featuredInput) {
                this.$refs.featuredInput.value = '';
            }
        },
        handleFeaturedChange(event) {
            const file = event.target.files?.[0];
            if (!file) {
                this.featuredPreview = this.form.existing_featured_image ? this.form.existing_featured_image : '';
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => this.featuredPreview = e.target?.result ?? '';
            reader.readAsDataURL(file);
        }
    }"
    x-cloak
>
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
                <p class="text-xs uppercase tracking-[0.3em] text-emerald-500 font-semibold">Potensi & Wisata</p>
            </div>
            <h1 class="text-3xl font-semibold text-gray-900">Kelola Potensi Wisata, Alam, Budaya, dan Ekonomi</h1>
            <p class="text-sm text-gray-500 mt-1">Tambahkan deskripsi, status, dan embed lokasi peta untuk setiap potensi unggulan desa.</p>
        </div>
        <button type="button" @click="openCreate()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-emerald-500 rounded-xl hover:bg-emerald-400 transition">
            Tambah Potensi
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @foreach($potentials as $potential)
        @php
            $featuredImageUrl = $potential->featured_image
                ? Storage::url($potential->featured_image)
                : '';
        @endphp
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-500">{{ $potential->category ?? 'Potensi' }}</p>
                        <h3 class="text-lg font-semibold text-gray-900 mt-1">{{ $potential->title }}</h3>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold
                        {{ $potential->status === \App\Models\VillagePotential::STATUS_ACTIVE ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $potential->status === \App\Models\VillagePotential::STATUS_ACTIVE ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                            {{ $potential->status }}
                        </span>
                        <button
                            type="button"
                            class="text-xs font-semibold text-gray-400 hover:text-emerald-600"
                            @click="openEdit({
                                id: {{ $potential->id }},
                                title: @js($potential->title),
                                category: @js($potential->category),
                                status: @js($potential->status),
                                summary: @js($potential->summary),
                                description: @js($potential->description),
                                map_embed: @js($potential->map_embed),
                                featured_image_url: '{{ $featuredImageUrl }}',
                                existing_featured_image: @js($potential->featured_image),
                                update_url: '{{ route('admin.desa-management.potentials.update', $potential) }}'
                            })"
                        >
                            Edit
                        </button>
                    </div>
                </div>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $potential->summary }}</p>
            </div>
            <div class="aspect-video border-t border-gray-100">
                <iframe src="{{ $potential->map_embed }}" class="w-full h-full" loading="lazy"></iframe>
            </div>
            <div class="px-6 py-4 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100">
                <a href="#potency" class="font-semibold text-emerald-600 hover:text-emerald-500">Detail</a>
                <form action="{{ route('admin.desa-management.potentials.destroy', $potential) }}" method="POST" onsubmit="return confirm('Hapus potensi ini?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="font-semibold text-gray-400 hover:text-red-500">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Potential Modal -->
    <div
        x-show="potentialModal"
        x-transition.opacity
        x-trap="potentialModal"
        @keydown.escape.window="potentialModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-8"
    >
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="potentialModal = false"></div>
        <div class="relative w-full max-w-3xl lg:max-w-4xl bg-white rounded-[32px] shadow-2xl max-h-[90vh] overflow-hidden">
            <div class="sticky top-0 flex items-start justify-between gap-6 px-6 sm:px-10 py-6 bg-white/95 backdrop-blur border-b border-gray-100">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">Potensi Desa</p>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mt-2">Tambah Potensi Unggulan</h3>
                    <p class="text-sm text-gray-500 mt-1">Lengkapi detail potensi untuk memperkuat promosi desa.</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600" @click="potentialModal = false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="overflow-y-auto max-h-[calc(90vh-160px)]">
                <form x-bind:action="formAction" method="POST" enctype="multipart/form-data" class="px-6 sm:px-10 py-8 space-y-8 bg-slate-50/60">
                    @csrf
                    <template x-if="mode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <input type="hidden" name="form_context" value="potential">
                    <input type="hidden" name="form_mode" :value="mode">
                    <input type="hidden" name="potential_id" :value="form.id ?? ''">
                    <input type="hidden" name="existing_featured_image" :value="form.existing_featured_image ?? ''">

                    @if ($potentialErrorBag->any())
                    <div class="bg-rose-50 border border-rose-200 rounded-2xl px-4 py-3 text-rose-600 text-sm shadow-sm">
                        <p class="font-semibold mb-1">Periksa kembali formulir:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($potentialErrorBag->all() as $message)
                            <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <section class="space-y-5">
                            <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-2 shadow-sm">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-emerald-500">Informasi Potensi</p>
                                <h4 class="text-lg font-semibold text-gray-900">Detail Umum</h4>
                                <p class="text-sm text-gray-500">Tuliskan identitas utama potensi desa agar mudah dipahami.</p>
                            </div>
                            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm space-y-4">
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700">Judul Potensi <span class="text-rose-500">*</span></label>
                                    <input type="text" name="title" x-model="form.title" class="mt-2 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-sm" placeholder="Contoh: Bukit Sunrise Point" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Kategori</label>
                                    <input type="text" name="category" x-model="form.category" class="mt-2 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-sm" placeholder="Wisata Alam, Kuliner, Ekonomi" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Status</label>
                                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-3 gap-2">
                                        @foreach($potentialStatuses as $status)
                                        <label class="flex items-center gap-2 rounded-xl border px-3 py-2 cursor-pointer text-sm font-medium"
                                            :class="form.status === '{{ $status }}' ? 'border-emerald-500 bg-emerald-50 text-emerald-600' : 'border-gray-200 text-gray-600'">
                                            <input type="radio" name="status" value="{{ $status }}" class="hidden" x-model="form.status">
                                            <span>{{ $status }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="space-y-5">
                            <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-2 shadow-sm">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-emerald-500">Konten</p>
                                <h4 class="text-lg font-semibold text-gray-900">Deskripsi dan Lokasi</h4>
                                <p class="text-sm text-gray-500">Ringkas manfaat, jelaskan detail, dan sematkan lokasi Google Maps.</p>
                            </div>
                            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Ringkasan</label>
                                    <textarea name="summary" rows="3" x-model="form.summary" class="mt-2 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-sm" placeholder="Deskripsi singkat potensi"></textarea>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Deskripsi Lengkap</label>
                                    <textarea name="description" rows="4" x-model="form.description" class="mt-2 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-sm" placeholder="Ceritakan detail potensi, agenda, fasilitas, dll"></textarea>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Embed Peta (Google Maps)</label>
                                    <textarea name="map_embed" rows="2" x-model="form.map_embed" class="mt-2 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-sm" placeholder="https://maps.google.com/..."></textarea>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label class="text-sm font-medium text-gray-700">Gambar Utama</label>
                                        <span class="text-[11px] font-semibold text-emerald-500 bg-emerald-50 px-3 py-1 rounded-full">Disarankan</span>
                                    </div>
                                    <div class="border-2 border-dashed border-emerald-200 rounded-2xl bg-white/80">
                                        <label class="flex flex-col items-center justify-center text-center px-6 py-8 cursor-pointer hover:bg-emerald-50 transition">
                                            <svg class="w-10 h-10 text-emerald-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h10a4 4 0 004-4M7 10l5-5m0 0l5 5m-5-5v12"></path>
                                            </svg>
                                            <p class="text-sm font-semibold text-gray-800">Tarik & lepas gambar</p>
                                            <p class="text-xs text-gray-500 mt-1">Atau <span class="text-emerald-500">klik untuk pilih dari perangkat</span></p>
                                            <p class="text-xs text-gray-400 mt-2">Format JPG, PNG — maks. 4MB</p>
                                            <input type="file" name="featured_image" accept="image/*" class="hidden" x-ref="featuredInput" @change="handleFeaturedChange">
                                        </label>
                                    </div>
                                    <div x-show="featuredPreview" class="rounded-xl border border-gray-100 bg-gray-50 overflow-hidden">
                                        <img :src="featuredPreview" alt="Preview gambar potensi" class="w-full h-40 object-cover">
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="flex flex-wrap items-center justify-end gap-3 sticky bottom-0 pt-4 border-t border-gray-100 bg-white/90">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700" @click="potentialModal = false">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-500 transition" x-text="mode === 'edit' ? 'Perbarui Potensi' : 'Simpan Potensi'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

