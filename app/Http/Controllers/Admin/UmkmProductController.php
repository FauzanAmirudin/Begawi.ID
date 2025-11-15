<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use App\Models\UmkmProduct;
use App\Models\UmkmProductCategory;
use App\Models\UmkmProductImage;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmProductController extends Controller
{
    /**
     * Get the UMKM business for the authenticated user
     * Returns null if not found (caller should handle redirect)
     */
    protected function getUmkmBusinessOrRedirect()
    {
        $user = Auth::user();
        $umkmBusiness = UmkmBusiness::where('user_id', $user->id)->first();
        
        if (!$umkmBusiness) {
            return redirect()->route('admin.umkm.setup')
                ->with('info', 'Silakan lengkapi informasi UMKM business Anda terlebih dahulu.');
        }
        
        return $umkmBusiness;
    }

    /**
     * Get the UMKM business for the authenticated user (returns object or null)
     */
    protected function getUmkmBusiness()
    {
        $user = Auth::user();
        return UmkmBusiness::where('user_id', $user->id)->first();
    }

    /**
     * Show setup page for users without UMKM business
     */
    public function setup()
    {
        $user = Auth::user();
        $umkmBusiness = UmkmBusiness::where('user_id', $user->id)->first();
        
        // If already has UMKM business, redirect to products
        if ($umkmBusiness) {
            return redirect()->route('admin.umkm.products.index');
        }

        return view('admin.admin-umkm.setup', [
            'user' => $user,
        ]);
    }

    /**
     * Create UMKM business for current user (quick setup)
     */
    public function createBusiness(Request $request)
    {
        $user = Auth::user();
        
        // Check if already has UMKM business
        if (UmkmBusiness::where('user_id', $user->id)->exists()) {
            return redirect()->route('admin.umkm.products.index')
                ->with('info', 'UMKM business sudah terdaftar.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:20',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Generate slug and subdomain
            $slug = Str::slug($validated['name']);
            $subdomain = Str::slug($validated['name']) . '-' . time();
            
            // Check if subdomain already exists
            $counter = 1;
            while (UmkmBusiness::where('subdomain', $subdomain)->exists()) {
                $subdomain = Str::slug($validated['name']) . '-' . time() . '-' . $counter;
                $counter++;
            }

            // Create website
            $website = Website::create([
                'name' => $validated['name'],
                'type' => 'umkm',
                'url' => $subdomain,
                'status' => 'active',
                'user_id' => $user->id,
            ]);

            // Create UMKM business
            $umkmBusiness = UmkmBusiness::create([
                'website_id' => $website->id,
                'village_id' => $user->village_id,
                'user_id' => $user->id,
                'name' => $validated['name'],
                'slug' => $slug,
                'subdomain' => $subdomain,
                'owner_name' => $validated['owner_name'],
                'owner_email' => $user->email,
                'owner_phone' => $validated['owner_phone'],
                'category' => $validated['category'],
                'description' => $validated['description'] ?? null,
                'status' => 'active',
            ]);

            DB::commit();

            return redirect()->route('admin.umkm.products.index')
                ->with('success', 'UMKM business berhasil dibuat! Anda sekarang dapat mulai menambahkan produk.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal membuat UMKM business: ' . $e->getMessage()]);
        }
    }

    /**
     * Display a listing of products
     */
    public function index()
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }
        
        $products = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->with(['category', 'primaryImage'])
            ->latest('updated_at')
            ->paginate(15);

        return view('admin.admin-umkm.products.index', [
            'products' => $products,
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }
        
        $categories = UmkmProductCategory::where('umkm_business_id', $umkmBusiness->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.admin-umkm.products.create', [
            'categories' => $categories,
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:umkm_product_categories,id',
            'stock' => 'required|integer|min:0',
            'availability_status' => 'required|in:ready,pre_order',
            'labels' => 'nullable|array',
            'labels.*' => 'in:best_seller,new,promo',
            'is_featured' => 'nullable|boolean',
            'variants' => 'nullable|array',
            'weight' => 'nullable|string|max:50',
            'dimension' => 'nullable|string|max:50',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Validate discount_price is less than price if provided
        if ($request->filled('discount_price') && $request->discount_price >= $validated['price']) {
            return back()->withErrors(['discount_price' => 'Harga diskon harus lebih kecil dari harga normal.'])->withInput();
        }

        // Generate slug
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->where('slug', $slug)
            ->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $product = UmkmProduct::create([
            'umkm_business_id' => $umkmBusiness->id,
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'discount_price' => !empty($validated['discount_price']) ? $validated['discount_price'] : null,
            'stock' => $validated['stock'],
            'availability_status' => $validated['availability_status'],
            'labels' => $validated['labels'] ?? [],
            'is_featured' => $request->has('is_featured') && $request->is_featured == '1',
            'variants' => $validated['variants'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'dimension' => $validated['dimension'] ?? null,
            'is_active' => true,
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $primarySet = false;
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('umkm/products', 'public');
                
                UmkmProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'sort_order' => $index,
                    'is_primary' => !$primarySet, // First image is primary
                ]);
                
                if (!$primarySet) {
                    $primarySet = true;
                }
            }
        }

        return redirect()->route('admin.umkm.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a product
     */
    public function edit(UmkmProduct $product)
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }
        
        // Ensure product belongs to this UMKM
        if ($product->umkm_business_id !== $umkmBusiness->id) {
            abort(403);
        }

        $categories = UmkmProductCategory::where('umkm_business_id', $umkmBusiness->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $product->load('images');

        return view('admin.admin-umkm.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Update a product
     */
    public function update(Request $request, UmkmProduct $product)
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }
        
        // Ensure product belongs to this UMKM
        if ($product->umkm_business_id !== $umkmBusiness->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:umkm_product_categories,id',
            'stock' => 'required|integer|min:0',
            'availability_status' => 'required|in:ready,pre_order',
            'labels' => 'nullable|array',
            'labels.*' => 'in:best_seller,new,promo',
            'is_featured' => 'nullable|boolean',
            'variants' => 'nullable|array',
            'weight' => 'nullable|string|max:50',
            'dimension' => 'nullable|string|max:50',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'exists:umkm_product_images,id',
        ]);

        // Validate discount_price is less than price if provided
        if ($request->filled('discount_price') && $request->discount_price >= $validated['price']) {
            return back()->withErrors(['discount_price' => 'Harga diskon harus lebih kecil dari harga normal.'])->withInput();
        }

        // Update slug if title changed
        if ($product->title !== $validated['title']) {
            $slug = Str::slug($validated['title']);
            $originalSlug = $slug;
            $counter = 1;
            while (UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
                ->where('slug', $slug)
                ->where('id', '!=', $product->id)
                ->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        $product->update([
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?? $product->slug,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'discount_price' => !empty($validated['discount_price']) ? $validated['discount_price'] : null,
            'stock' => $validated['stock'],
            'availability_status' => $validated['availability_status'],
            'labels' => $validated['labels'] ?? [],
            'is_featured' => $request->has('is_featured') && $request->is_featured == '1',
            'variants' => $validated['variants'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'dimension' => $validated['dimension'] ?? null,
        ]);

        // Handle existing images - delete removed ones
        if ($request->has('existing_images')) {
            $existingIds = $request->input('existing_images');
            UmkmProductImage::where('product_id', $product->id)
                ->whereNotIn('id', $existingIds)
                ->get()
                ->each(function ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                });
        } else {
            // Delete all existing images if none selected
            UmkmProductImage::where('product_id', $product->id)
                ->get()
                ->each(function ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                });
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $maxSortOrder = UmkmProductImage::where('product_id', $product->id)->max('sort_order') ?? -1;
            
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('umkm/products', 'public');
                
                UmkmProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'sort_order' => $maxSortOrder + $index + 1,
                    'is_primary' => false, // Don't change primary on update
                ]);
            }
        }

        // Ensure at least one primary image
        $hasPrimary = UmkmProductImage::where('product_id', $product->id)
            ->where('is_primary', true)
            ->exists();
        
        if (!$hasPrimary) {
            $firstImage = UmkmProductImage::where('product_id', $product->id)
                ->orderBy('sort_order')
                ->first();
            if ($firstImage) {
                $firstImage->update(['is_primary' => true]);
            }
        }

        return redirect()->route('admin.umkm.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove a product (soft delete by setting is_active to false)
     */
    public function destroy(UmkmProduct $product)
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }
        
        // Ensure product belongs to this UMKM
        if ($product->umkm_business_id !== $umkmBusiness->id) {
            abort(403);
        }

        $product->update(['is_active' => false]);

        return redirect()->route('admin.umkm.products.index')
            ->with('success', 'Produk berhasil dinonaktifkan.');
    }

    /**
     * Toggle product active status
     */
    public function toggleStatus(UmkmProduct $product)
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }
        
        if ($product->umkm_business_id !== $umkmBusiness->id) {
            abort(403);
        }

        $product->update(['is_active' => !$product->is_active]);

        return redirect()->back()
            ->with('success', 'Status produk berhasil diperbarui.');
    }

    /**
     * Display stock management page
     */
    public function stock()
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }
        
        $products = UmkmProduct::where('umkm_business_id', $umkmBusiness->id)
            ->with(['category', 'primaryImage'])
            ->orderBy('title')
            ->get();

        return view('admin.admin-umkm.products.stock', [
            'products' => $products,
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Update stock for a product
     */
    public function updateStock(Request $request, UmkmProduct $product)
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }
        
        if ($product->umkm_business_id !== $umkmBusiness->id) {
            abort(403);
        }

        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
            'availability_status' => 'required|in:ready,pre_order',
        ]);

        $product->update($validated);

        return redirect()->back()
            ->with('success', 'Stok produk berhasil diperbarui.');
    }

    /**
     * Display categories management page
     */
    public function categories()
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }
        
        $categories = UmkmProductCategory::where('umkm_business_id', $umkmBusiness->id)
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.admin-umkm.products.categories', [
            'categories' => $categories,
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Store a new category
     */
    public function storeCategory(Request $request)
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (UmkmProductCategory::where('umkm_business_id', $umkmBusiness->id)
            ->where('slug', $slug)
            ->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        UmkmProductCategory::create([
            'umkm_business_id' => $umkmBusiness->id,
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->back()
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Update a category
     */
    public function updateCategory(Request $request, UmkmProductCategory $category)
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }
        
        if ($category->umkm_business_id !== $umkmBusiness->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Update slug if name changed
        if ($category->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;
            while (UmkmProductCategory::where('umkm_business_id', $umkmBusiness->id)
                ->where('slug', $slug)
                ->where('id', '!=', $category->id)
                ->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        $category->update($validated);

        return redirect()->back()
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Delete a category
     */
    public function destroyCategory(UmkmProductCategory $category)
    {
        $umkmBusiness = $this->getUmkmBusinessOrRedirect();
        if ($umkmBusiness instanceof \Illuminate\Http\RedirectResponse) {
            return $umkmBusiness;
        }
        
        if ($category->umkm_business_id !== $umkmBusiness->id) {
            abort(403);
        }

        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }

        $category->delete();

        return redirect()->back()
            ->with('success', 'Kategori berhasil dihapus.');
    }
}

