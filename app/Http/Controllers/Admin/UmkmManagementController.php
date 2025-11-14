<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use App\Models\UmkmContentValidation;
use App\Models\UmkmDigitalGuide;
use App\Models\User;
use App\Models\Village;
use App\Models\Website;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmManagementController extends Controller
{
    protected function getVillage()
    {
        return Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );
    }

    protected function getCategoryPool()
    {
        return [
            'Makanan & Minuman',
            'Kerajinan & Fashion',
            'Kesehatan & Herbal',
            'Pertanian & Perkebunan',
            'Teknologi & Digital',
            'Jasa & Layanan',
        ];
    }

    protected function getUmkmCollection()
    {
        $umkmBusinesses = UmkmBusiness::query()
            ->with(['user', 'village'])
            ->orderByDesc('created_at')
            ->get();

        return $umkmBusinesses->map(function (UmkmBusiness $umkm) {
            $created = optional($umkm->created_at)->translatedFormat('d M Y');
            $lastActivity = optional($umkm->last_activity_at ?? $umkm->updated_at)->diffForHumans();

            return [
                'id' => $umkm->id,
                'name' => $umkm->name,
                'owner' => $umkm->owner_name,
                'category' => $umkm->category,
                'status' => $umkm->status,
                'status_label' => $umkm->status_label,
                'status_badge' => $umkm->status_badge,
                'subdomain' => $umkm->subdomain,
                'products' => $umkm->products_count,
                'visits' => $umkm->visits_count,
                'orders' => $umkm->orders_count,
                'conversion' => round(($umkm->orders_count / max($umkm->visits_count, 1)) * 100, 1),
                'messages' => $umkm->contentValidations()->where('status', 'review')->count(),
                'last_update' => $lastActivity,
                'created_at' => $created,
            ];
        });
    }

    /**
     * Dashboard UMKM Management
     */
    public function index(): View
    {
        $village = $this->getVillage();
        $umkmCollection = $this->getUmkmCollection();

        if ($umkmCollection->isEmpty()) {
            $umkmCollection = collect([
                [
                    'id' => 1,
                    'name' => 'UD Berkah Jaya',
                    'owner' => 'Ibu Siti Nurhaliza',
                    'category' => 'Makanan & Minuman',
                    'status' => 'active',
                    'status_label' => 'Aktif',
                    'status_badge' => 'bg-emerald-50 text-emerald-600',
                    'subdomain' => 'ud-berkah-jaya.desa.begawi.id',
                    'products' => 18,
                    'visits' => 2310,
                    'orders' => 87,
                    'conversion' => 3.8,
                    'messages' => 4,
                    'last_update' => '3 jam lalu',
                    'created_at' => '12 Feb 2024',
                ],
            ]);
        }

        $totalUmkm = $umkmCollection->count();
        $activeUmkm = $umkmCollection->where('status', 'active')->count();
        $onboardingUmkm = $umkmCollection->where('status', 'onboarding')->count();
        $totalProducts = $umkmCollection->sum('products');
        $totalVisits = $umkmCollection->sum('visits');
        $totalOrders = $umkmCollection->sum('orders');

        $overviewCards = [
            [
                'label' => 'UMKM Aktif',
                'value' => number_format($activeUmkm),
                'description' => "{$totalUmkm} total terdaftar",
                'gradient' => 'from-emerald-500 via-emerald-600 to-teal-500',
                'icon' => 'storefront',
                'link' => route('admin.desa-management.umkm-management.list'),
                'link_label' => 'Kelola Direktori',
                'badge' => [
                    'label' => 'Onboarding',
                    'text' => $onboardingUmkm,
                ],
            ],
            [
                'label' => 'Produk Terdaftar',
                'value' => number_format($totalProducts),
                'description' => 'Jumlah produk aktif',
                'gradient' => 'from-indigo-500 via-indigo-600 to-purple-500',
                'icon' => 'category',
                'link' => route('admin.desa-management.umkm-management.monitoring'),
                'link_label' => 'Lihat Aktivitas',
                'badge' => [
                    'label' => 'Order 30 hari',
                    'text' => number_format($totalOrders),
                ],
            ],
            [
                'label' => 'Total Kunjungan',
                'value' => number_format($totalVisits),
                'description' => '30 hari terakhir',
                'gradient' => 'from-amber-500 via-orange-500 to-rose-500',
                'icon' => 'visitors',
                'link' => route('admin.desa-management.umkm-management.monitoring'),
                'link_label' => 'Detail Insight',
            ],
            [
                'label' => 'Pesan Baru',
                'value' => number_format($umkmCollection->sum('messages')),
                'description' => 'Masuk dari admin UMKM',
                'gradient' => 'from-sky-500 via-blue-500 to-indigo-500',
                'icon' => 'chat',
                'link' => route('admin.desa-management.umkm-management.validation'),
                'link_label' => 'Tinjau Pesan',
            ],
        ];

        $pendingValidations = UmkmContentValidation::query()
            ->whereIn('status', ['review', 'verification', 'draft'])
            ->count();

        $recentUmkm = $umkmCollection->take(5);
        $latestMessages = collect([
            [
                'umkm' => 'UD Berkah Jaya',
                'excerpt' => 'Mohon bantuan update stok produk menjelang event desa.',
                'time' => '5 menit lalu',
            ],
            [
                'umkm' => 'Madu Sari Desa',
                'excerpt' => 'Apakah bisa ditambahkan opsi pembayaran COD untuk pesanan lokal?',
                'time' => '45 menit lalu',
            ],
        ]);

        return view('admin.admin-desa.umkm-management.index', [
            'village' => $village,
            'overviewCards' => $overviewCards,
            'recentUmkm' => $recentUmkm,
            'latestMessages' => $latestMessages,
            'pendingValidations' => $pendingValidations,
        ]);
    }

    /**
     * List all UMKM
     */
    public function list(): View
    {
        $village = $this->getVillage();
        $umkmCollection = $this->getUmkmCollection();

        if ($umkmCollection->isEmpty()) {
            $umkmCollection = collect([
                [
                    'id' => 1,
                    'name' => 'UD Berkah Jaya',
                    'owner' => 'Ibu Siti Nurhaliza',
                    'category' => 'Makanan & Minuman',
                    'status' => 'active',
                    'status_label' => 'Aktif',
                    'status_badge' => 'bg-emerald-50 text-emerald-600',
                    'subdomain' => 'ud-berkah-jaya.desa.begawi.id',
                    'products' => 18,
                    'created_at' => '12 Feb 2024',
                ],
            ]);
        }

        return view('admin.admin-desa.umkm-management.list', [
            'village' => $village,
            'umkmList' => $umkmCollection,
        ]);
    }

    /**
     * Show create UMKM form
     */
    public function create(): View
    {
        $village = $this->getVillage();
        $categoryFilters = $this->getCategoryPool();

        return view('admin.admin-desa.umkm-management.create', [
            'village' => $village,
            'categoryFilters' => $categoryFilters,
            'domainSuffix' => 'desa.begawi.id',
        ]);
    }

    /**
     * Show monitoring page
     */
    public function monitoring(): View
    {
        $village = $this->getVillage();
        $umkmCollection = $this->getUmkmCollection();

        if ($umkmCollection->isEmpty()) {
            $umkmCollection = collect([
                [
                    'id' => 1,
                    'name' => 'UD Berkah Jaya',
                    'owner' => 'Ibu Siti Nurhaliza',
                    'status_label' => 'Aktif',
                    'status_badge' => 'bg-emerald-50 text-emerald-600',
                    'subdomain' => 'ud-berkah-jaya.desa.begawi.id',
                    'products' => 18,
                    'visits' => 2310,
                    'orders' => 87,
                    'conversion' => 3.8,
                    'last_update' => '3 jam lalu',
                ],
            ]);
        }

        $totalUmkm = $umkmCollection->count();
        $totalVisits = $umkmCollection->sum('visits');
        $totalOrders = $umkmCollection->sum('orders');
        $totalProducts = $umkmCollection->sum('products');

        $monitoringSummary = [
            [
                'label' => 'Rata-rata Kunjungan',
                'value' => number_format(round($totalVisits / max($totalUmkm, 1))),
                'delta' => '+12% dibanding bulan lalu',
                'badge' => 'bg-emerald-100 text-emerald-600',
            ],
            [
                'label' => 'Konversi Rata-rata',
                'value' => round($totalOrders / max($totalVisits, 1) * 100, 2) . '%',
                'delta' => 'Target 3% tercapai',
                'badge' => 'bg-indigo-100 text-indigo-600',
            ],
            [
                'label' => 'Produk / UMKM',
                'value' => round($totalProducts / max($totalUmkm, 1), 1),
                'delta' => "{$totalProducts} produk aktif",
                'badge' => 'bg-amber-100 text-amber-600',
            ],
        ];

        $monitoringDetails = $umkmCollection->map(function (array $item) {
            return [
                'name' => $item['name'],
                'owner' => $item['owner'],
                'status_label' => $item['status_label'],
                'status_badge' => $item['status_badge'],
                'products' => $item['products'],
                'visits' => $item['visits'],
                'orders' => $item['orders'],
                'conversion' => $item['conversion'],
                'last_update' => $item['last_update'],
                'subdomain' => $item['subdomain'],
            ];
        });

        $chart = [
            'visits' => [
                'labels' => ['Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb'],
                'dataset' => [1120, 1380, 1560, 1890, 2150, 2435],
            ],
            'conversion' => [
                'labels' => ['Sep', 'Okt', 'Nov', 'Des', 'Jan', 'Feb'],
                'dataset' => [2.3, 2.5, 2.7, 3.1, 3.4, 3.8],
            ],
        ];

        return view('admin.admin-desa.umkm-management.monitoring', [
            'village' => $village,
            'monitoringSummary' => $monitoringSummary,
            'monitoringDetails' => $monitoringDetails,
            'chart' => $chart,
        ]);
    }

    /**
     * Show validation page
     */
    public function validation(): View
    {
        $village = $this->getVillage();

        $validationQueue = UmkmContentValidation::query()
            ->with(['umkmBusiness', 'submitter'])
            ->whereIn('status', ['review', 'verification', 'draft'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function (UmkmContentValidation $validation) {
                return [
                    'id' => $validation->id,
                    'type' => $validation->content_type_label,
                    'umkm' => $validation->umkmBusiness->name ?? 'Unknown',
                    'submitted_by' => $validation->submitter->name ?? 'Unknown',
                    'status' => $validation->status,
                    'items' => [
                        $validation->title,
                        $validation->description ? Str::limit($validation->description, 100) : 'Tidak ada deskripsi',
                    ],
                ];
            });

        if ($validationQueue->isEmpty()) {
            $validationQueue = collect([
                [
                    'id' => 101,
                    'type' => 'Produk Baru',
                    'umkm' => 'UD Berkah Jaya',
                    'submitted_by' => 'Admin UMKM · 2 jam lalu',
                    'items' => [
                        'Keripik Singkong Rasa Balado',
                        'Foto produk & deskripsi',
                    ],
                    'status' => 'review',
                ],
            ]);
        }

        return view('admin.admin-desa.umkm-management.validation', [
            'village' => $village,
            'validationQueue' => $validationQueue,
        ]);
    }

    /**
     * Show guides page
     */
    public function guides(): View
    {
        $village = $this->getVillage();

        $digitalGuides = UmkmDigitalGuide::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get()
            ->map(function (UmkmDigitalGuide $guide) {
                $duration = $guide->duration_minutes 
                    ? "{$guide->duration_minutes} menit" 
                    : ($guide->file_type === 'video' ? 'Video' : '8 menit baca');
                
                return [
                    'title' => $guide->title,
                    'category' => $guide->category_label,
                    'duration' => $duration,
                    'updated_at' => optional($guide->updated_at)->translatedFormat('d M Y'),
                    'link' => '#',
                ];
            });

        if ($digitalGuides->isEmpty()) {
            $digitalGuides = collect([
                [
                    'title' => 'Panduan Foto Produk UMKM',
                    'category' => 'Tips Promosi',
                    'duration' => '8 menit baca',
                    'updated_at' => '10 Feb 2024',
                    'link' => '#',
                ],
                [
                    'title' => 'Template Media Sosial Gratis',
                    'category' => 'Materi Promosi',
                    'duration' => 'Canva & PowerPoint',
                    'updated_at' => '08 Feb 2024',
                    'link' => '#',
                ],
            ]);
        }

        $upcomingTrainings = collect([
            [
                'title' => 'Optimasi Toko UMKM',
                'date' => '20 Feb 2024',
                'time' => '19:30 WIB',
                'medium' => 'Zoom Meeting',
                'status' => 'Terbuka',
            ],
            [
                'title' => 'Kelas Copywriting Produk',
                'date' => '27 Feb 2024',
                'time' => '10:00 WIB',
                'medium' => 'Offline · Balai Desa',
                'status' => 'Terbatas',
            ],
        ]);

        return view('admin.admin-desa.umkm-management.guides', [
            'village' => $village,
            'digitalGuides' => $digitalGuides,
            'upcomingTrainings' => $upcomingTrainings,
        ]);
    }
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

            return redirect()->route('admin.desa-management.umkm-management.index')
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
            'reviewed_by' => Auth::id() ?? 1,
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
            'reviewed_by' => Auth::id() ?? 1,
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
            'reviewed_by' => Auth::id() ?? 1,
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
            'submitted_by' => Auth::id() ?? 1,
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
            'created_by' => Auth::id() ?? 1,
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

