@extends('layouts.admin')

@section('title', 'Detail Permohonan Surat')

@section('content')
<div class="p-6">
    <div class="flex gap-6">
        <!-- Main Column -->
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <a href="{{ route('admin.desa-management.letters.index') }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium mb-2 inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Daftar
                    </a>
                    <h1 class="text-2xl font-semibold text-gray-800">Detail Permohonan Surat</h1>
                    <p class="text-sm text-gray-500 mt-1">Kode: {{ $submission->tracking_code }}</p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Submission Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Submission Info -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pemohon</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                                <p class="text-gray-900">{{ $submission->nama }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">NIK</label>
                                <p class="text-gray-900 font-mono">{{ $submission->nik }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Telepon</label>
                                <p class="text-gray-900">{{ $submission->telepon }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                <p class="text-gray-900">{{ $submission->email ?? '-' }}</p>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                                <p class="text-gray-900">{{ $submission->alamat }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Letter Details -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Surat</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Surat</label>
                                <p class="text-gray-900">{{ $submission->letter_type_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Keperluan</label>
                                <p class="text-gray-900">{{ $submission->keperluan }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Pengajuan</label>
                                <p class="text-gray-900">{{ $submission->created_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Requirements Files -->
                    @if($submission->requirements_files && count($submission->requirements_files) > 0)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Dokumen Persyaratan</h2>
                        <div class="space-y-3">
                            @foreach($submission->requirements_files as $index => $file)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700">{{ basename($file) }}</span>
                                </div>
                                <a href="{{ route('admin.desa-management.letters.download-requirement', ['id' => $submission->id, 'index' => $index]) }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium">
                                    Download
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Admin Notes -->
                    @if($submission->admin_notes)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Catatan Admin</h2>
                        <p class="text-gray-700">{{ $submission->admin_notes }}</p>
                    </div>
                    @endif

                    <!-- Rejection Reason -->
                    @if($submission->status === 'rejected' && $submission->rejection_reason)
                    <div class="bg-red-50 rounded-2xl border border-red-200 p-6">
                        <h2 class="text-lg font-semibold text-red-800 mb-4">Alasan Penolakan</h2>
                        <p class="text-red-700">{{ $submission->rejection_reason }}</p>
                    </div>
                    @endif
                </div>

                <!-- Right Column - Status Management -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Status</h2>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'verified' => 'bg-blue-100 text-blue-800',
                                'processed' => 'bg-purple-100 text-purple-800',
                                'completed' => 'bg-emerald-100 text-emerald-800',
                                'rejected' => 'bg-red-100 text-red-800',
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'verified' => 'Terverifikasi',
                                'processed' => 'Diproses',
                                'completed' => 'Selesai',
                                'rejected' => 'Ditolak',
                            ];
                        @endphp
                        <div class="mb-4">
                            <span class="px-4 py-2 text-sm font-medium rounded-full {{ $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$submission->status] ?? $submission->status }}
                            </span>
                        </div>

                        @if($submission->processor)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Diproses Oleh</label>
                            <p class="text-gray-900">{{ $submission->processor->name }}</p>
                        </div>
                        @endif

                        @if($submission->verified_at)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Diverifikasi</label>
                            <p class="text-gray-900 text-sm">{{ $submission->verified_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif

                        @if($submission->completed_at)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Selesai</label>
                            <p class="text-gray-900 text-sm">{{ $submission->completed_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Update Status Form -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Ubah Status</h2>
                        <form action="{{ route('admin.desa-management.letters.update-status', $submission->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                                <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                    <option value="pending" {{ $submission->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="verified" {{ $submission->status === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                                    <option value="processed" {{ $submission->status === 'processed' ? 'selected' : '' }}>Diproses</option>
                                    <option value="completed" {{ $submission->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="rejected" {{ $submission->status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <div class="mb-4" id="rejection-reason-field" style="display: none;">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan *</label>
                                <textarea name="rejection_reason" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Jelaskan alasan penolakan">{{ $submission->rejection_reason }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                                <textarea name="admin_notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Tambahkan catatan (opsional)">{{ $submission->admin_notes }}</textarea>
                            </div>

                            <button type="submit" class="w-full px-4 py-2 bg-teal-600 text-white rounded-xl font-medium hover:bg-teal-700 transition">
                                Perbarui Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.querySelector('select[name="status"]');
    const rejectionField = document.getElementById('rejection-reason-field');
    const rejectionTextarea = document.querySelector('textarea[name="rejection_reason"]');

    function toggleRejectionField() {
        if (statusSelect.value === 'rejected') {
            rejectionField.style.display = 'block';
            rejectionTextarea.required = true;
        } else {
            rejectionField.style.display = 'none';
            rejectionTextarea.required = false;
        }
    }

    statusSelect.addEventListener('change', toggleRejectionField);
    toggleRejectionField(); // Initial check
});
</script>
@endpush
@endsection

