<!-- Modal Reject -->
<div id="rejectModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center" style="display: none;" onclick="if(event.target === this) closeRejectModal()">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">Tolak Konten</h3>
            <p class="text-sm text-gray-500 mt-1">Berikan alasan penolakan konten ini</p>
        </div>
        <form id="rejectForm" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                <textarea name="rejection_reason" required rows="4" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-rose-500 focus:bg-white focus:ring-2 focus:ring-rose-500/20 transition-all resize-none" placeholder="Contoh: Foto produk tidak jelas, deskripsi kurang lengkap, dll."></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 rounded-xl bg-gradient-to-r from-rose-500 to-red-500 text-white font-semibold hover:opacity-95 transition">
                    Tolak Konten
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Revision -->
<div id="revisionModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center" style="display: none;" onclick="if(event.target === this) closeRevisionModal()">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">Minta Revisi</h3>
            <p class="text-sm text-gray-500 mt-1">Berikan catatan revisi untuk konten ini</p>
        </div>
        <form id="revisionForm" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Revisi <span class="text-red-500">*</span></label>
                <textarea name="revision_notes" required rows="4" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-amber-500 focus:bg-white focus:ring-2 focus:ring-amber-500/20 transition-all resize-none" placeholder="Contoh: Mohon perbaiki kualitas foto, lengkapi deskripsi produk, tambahkan informasi stok, dll."></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeRevisionModal()" class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold hover:opacity-95 transition">
                    Kirim Permintaan Revisi
                </button>
            </div>
        </form>
    </div>
</div>

