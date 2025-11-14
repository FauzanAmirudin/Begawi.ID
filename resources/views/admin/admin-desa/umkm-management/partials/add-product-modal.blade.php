<!-- Modal Tambah Produk -->
<div id="addProductModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center" style="display: none;" onclick="if(event.target === this) closeAddProductModal()">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-900">Tambah Produk UMKM</h3>
                <button onclick="closeAddProductModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-gray-500 mt-1" id="modalUmkmName"></p>
        </div>
        <form action="{{ route('admin.desa-management.umkm-management.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="umkm_business_id" id="modalUmkmId">
            
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="title" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="Contoh: Keripik Singkong Renyah">
            </div>
            
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Deskripsi Produk</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all resize-none" placeholder="Deskripsi lengkap produk..."></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Harga <span class="text-red-500">*</span></label>
                    <input type="number" name="price" required min="0" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="15000">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Stok</label>
                    <input type="number" name="stock" min="0" value="0" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="25">
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Rating</label>
                    <input type="number" name="rating" min="0" max="5" step="0.1" value="4.5" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="4.5">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Berat</label>
                    <input type="text" name="weight" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" placeholder="250gr">
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Foto Produk <span class="text-red-500">*</span></label>
                <input type="file" name="image" accept="image/*" required class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all">
                <p class="text-xs text-gray-500 mt-1">Format JPG/PNG, maksimal 2MB</p>
            </div>
            
            <div class="flex items-center gap-3 p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                <input type="checkbox" name="auto_approve" id="autoApprove" value="1" checked class="w-5 h-5 rounded border-2 border-gray-300 text-emerald-600 focus:ring-2 focus:ring-emerald-500/20">
                <label for="autoApprove" class="text-sm text-gray-700 cursor-pointer">
                    <span class="font-semibold">Setujui otomatis</span> - Produk akan langsung muncul di website desa tanpa perlu validasi ulang
                </label>
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeAddProductModal()" class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold hover:opacity-95 transition">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

