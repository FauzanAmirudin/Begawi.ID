<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use App\Models\UmkmContentValidation;
use App\Models\UmkmDigitalGuide;
use App\Models\User;
use App\Models\Village;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmManagementController extends Controller
{
    /**
     * Store a new UMKM business
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'owner_phone' => 'required|string|max:20',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'legal_document' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'send_credentials' => 'boolean',
        ]);

        $village = Village::where('slug', 'desa-sejahtera')->first();
        if (!$village) {
            return back()->withErrors(['error' => 'Village not found']);
        }

        DB::beginTransaction();
        try {
            // Generate subdomain
            $slug = Str::slug($validated['name']);
            $subdomain = UmkmBusiness::generateSubdomain($validated['name']);
            
            // Check if subdomain already exists
            $existing = UmkmBusiness::where('subdomain', $subdomain)->first();
            if ($existing) {
                $slug = $slug . '-' . time();
                $subdomain = UmkmBusiness::generateSubdomain($slug);
            }

            // Create user for UMKM admin
            $user = User::create([
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
                'password' => Hash::make(Str::random(12)), // Random password, will be sent via email
                'role' => User::ROLE_ADMIN_UMKM,
                'status' => 'active',
            ]);

            // Create website
            $website = Website::create([
                'name' => $validated['name'],
                'type' => 'umkm',
                'url' => $subdomain,
                'status' => 'active',
                'user_id' => $user->id,
            ]);

            // Handle file uploads
            $logoPath = null;
            $legalDocPath = null;

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('umkm/logos', 'public');
            }

            if ($request->hasFile('legal_document')) {
                $legalDocPath = $request->file('legal_document')->store('umkm/documents', 'public');
            }

            // Create UMKM business
            $umkm = UmkmBusiness::create([
                'website_id' => $website->id,
                'village_id' => $village->id,
                'user_id' => $user->id,
                'name' => $validated['name'],
                'slug' => $slug,
                'subdomain' => $subdomain,
                'owner_name' => $validated['owner_name'],
                'owner_email' => $validated['owner_email'],
                'owner_phone' => $validated['owner_phone'],
                'category' => $validated['category'],
                'description' => $validated['description'] ?? null,
                'logo_path' => $logoPath,
                'legal_document_path' => $legalDocPath,
                'status' => 'onboarding',
            ]);

            // TODO: Send credentials via email/WhatsApp if requested
            if ($request->boolean('send_credentials')) {
                // Implement email/WhatsApp notification
            }

            DB::commit();

            return redirect()->route('admin.desa-management.umkm')
                ->with('success', 'UMKM berhasil didaftarkan. Subdomain: ' . $subdomain);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mendaftarkan UMKM: ' . $e->getMessage()]);
        }
    }

    /**
     * Update UMKM status (suspend/activate)
     */
    public function updateStatus(Request $request, UmkmBusiness $umkm)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,suspended,inactive,onboarding',
        ]);

        $umkm->update(['status' => $validated['status']]);

        if ($umkm->website) {
            $websiteStatus = match($validated['status']) {
                'active' => 'active',
                'suspended', 'inactive' => 'suspended',
                default => 'pending',
            };
            $umkm->website->update(['status' => $websiteStatus]);
        }

        $message = match($validated['status']) {
            'active' => 'UMKM berhasil diaktifkan. Produk yang sudah disetujui akan muncul di website desa.',
            'suspended' => 'UMKM berhasil ditangguhkan. Produk tidak akan muncul di website desa.',
            'inactive' => 'UMKM berhasil dinonaktifkan.',
            default => 'Status UMKM berhasil diperbarui',
        };

        return back()->with('success', $message);
    }

    /**
     * Approve content validation
     */
    public function approveContent(UmkmContentValidation $validation)
    {
        $validation->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id() ?? 1,
            'reviewed_at' => now(),
        ]);

        // Update products count if it's a product
        if ($validation->content_type === 'product' && $validation->umkmBusiness) {
            $validation->umkmBusiness->increment('products_count');
        }

        return back()->with('success', 'Konten berhasil disetujui dan sudah muncul di website desa');
    }

    /**
     * Reject content validation
     */
    public function rejectContent(Request $request, UmkmContentValidation $validation)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $validation->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'reviewed_by' => auth()->id() ?? 1,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Konten ditolak dengan alasan yang diberikan');
    }

    /**
     * Request revision for content
     */
    public function requestRevision(Request $request, UmkmContentValidation $validation)
    {
        $validated = $request->validate([
            'revision_notes' => 'required|string',
        ]);

        $validation->update([
            'status' => 'revision_requested',
            'revision_notes' => $validated['revision_notes'],
            'reviewed_by' => auth()->id() ?? 1,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Permintaan revisi telah dikirim');
    }

    /**
     * Store product for UMKM
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'umkm_business_id' => 'required|exists:umkm_businesses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'weight' => 'nullable|string|max:50',
            'image' => 'required|image|max:2048',
            'auto_approve' => 'boolean',
        ]);

        $umkm = UmkmBusiness::findOrFail($validated['umkm_business_id']);

        // Handle image upload
        $imagePath = $request->file('image')->store('umkm/products', 'public');

        // Prepare content data
        $contentData = [
            'image' => $imagePath,
            'price' => (int) $validated['price'],
            'stock' => (int) ($validated['stock'] ?? 0),
            'rating' => (float) ($validated['rating'] ?? 4.5),
            'weight' => $validated['weight'] ?? '-',
            'sold' => 0,
            'terjual' => 0,
            'featured' => false,
            'unggulan' => false,
        ];

        // Determine status based on auto_approve
        $status = $request->boolean('auto_approve') ? 'approved' : 'review';

        // Create content validation
        $validation = UmkmContentValidation::create([
            'umkm_business_id' => $umkm->id,
            'submitted_by' => auth()->id() ?? 1,
            'content_type' => 'product',
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'content_data' => $contentData,
            'status' => $status,
        ]);

        // Update products count if approved
        if ($status === 'approved') {
            $umkm->increment('products_count');
        }

        $message = $status === 'approved' 
            ? 'Produk berhasil ditambahkan dan langsung disetujui. Produk sudah muncul di website desa.' 
            : 'Produk berhasil ditambahkan dan menunggu validasi.';

        return back()->with('success', $message);
    }

    /**
     * Store digital guide
     */
    public function storeGuide(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:tips,pelatihan,artikel,video,template',
            'file' => 'nullable|file|mimes:pdf,ppt,pptx,zip,mp4|max:20480',
            'external_link' => 'nullable|url',
            'duration_minutes' => 'nullable|integer|min:1',
            'notify_all_umkm' => 'boolean',
        ]);

        $village = Village::where('slug', 'desa-sejahtera')->first();

        $filePath = null;
        $fileType = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileType = match($extension) {
                'pdf' => 'pdf',
                'ppt', 'pptx' => 'ppt',
                'zip' => 'zip',
                'mp4', 'mov', 'avi' => 'video',
                default => 'file',
            };
            $filePath = $file->store('umkm/guides', 'public');
        }

        $guide = UmkmDigitalGuide::create([
            'village_id' => $village?->id,
            'created_by' => auth()->id() ?? 1,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'],
            'file_path' => $filePath,
            'file_type' => $fileType,
            'external_link' => $validated['external_link'] ?? null,
            'duration_minutes' => $validated['duration_minutes'] ?? null,
            'is_published' => true,
            'notify_all_umkm' => $request->boolean('notify_all_umkm'),
            'published_at' => now(),
        ]);

        // TODO: Send notification to all UMKM if requested

        return back()->with('success', 'Materi bimbingan berhasil diterbitkan');
    }
}

