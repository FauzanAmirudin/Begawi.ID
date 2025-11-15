<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitizenComplaint;
use App\Models\User;
use App\Models\Village;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CitizenComplaintController extends Controller
{
    /**
     * Get village and website for current user
     */
    protected function getUserVillageData()
    {
        $user = Auth::user();
        
        if ($user->role === User::ROLE_SUPER_ADMIN) {
            $website = Website::where('type', 'desa')->first();
        } else {
            $website = Website::where('user_id', $user->id)
                ->where('type', 'desa')
                ->first();
        }

        $village = $website ? Village::where('website_id', $website->id)->first() : null;

        return [
            'village' => $village,
            'website' => $website,
        ];
    }

    /**
     * Display a listing of citizen complaints
     */
    public function index(Request $request)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];

        if (!$village) {
            return view('admin.admin-desa.complaints.index', [
                'complaints' => collect([])->paginate(15),
                'village' => null,
                'stats' => [
                    'total' => 0,
                    'pending' => 0,
                    'in_progress' => 0,
                    'resolved' => 0,
                ],
                'filters' => $request->only(['search', 'status', 'kategori']),
            ]);
        }

        $query = CitizenComplaint::where('village_id', $village->id)
            ->with('processor');

        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('tracking_code', 'like', '%' . $search . '%')
                        ->orWhere('nama', 'like', '%' . $search . '%')
                        ->orWhere('judul', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $complaints = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Get statistics
        $stats = [
            'total' => CitizenComplaint::where('village_id', $village->id)->count(),
            'pending' => CitizenComplaint::where('village_id', $village->id)->where('status', 'pending')->count(),
            'in_progress' => CitizenComplaint::where('village_id', $village->id)->whereIn('status', ['reviewed', 'in_progress'])->count(),
            'resolved' => CitizenComplaint::where('village_id', $village->id)->where('status', 'resolved')->count(),
        ];

        return view('admin.admin-desa.complaints.index', [
            'complaints' => $complaints,
            'village' => $village,
            'stats' => $stats,
            'filters' => $request->only(['search', 'status', 'kategori']),
        ]);
    }

    /**
     * Show the specified citizen complaint
     */
    public function show($id)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];

        $complaint = CitizenComplaint::where('village_id', $village->id)
            ->with('processor')
            ->findOrFail($id);

        return view('admin.admin-desa.complaints.show', [
            'complaint' => $complaint,
            'village' => $village,
        ]);
    }

    /**
     * Update complaint status
     */
    public function updateStatus(Request $request, $id)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];

        $complaint = CitizenComplaint::where('village_id', $village->id)->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,reviewed,in_progress,resolved,rejected',
            'admin_notes' => 'nullable|string',
            'rejection_reason' => 'required_if:status,rejected|nullable|string',
        ]);

        $complaint->status = $request->status;
        $complaint->admin_notes = $request->admin_notes;
        $complaint->processed_by = Auth::id();

        // Set timestamps based on status
        if ($request->status === 'reviewed' && !$complaint->reviewed_at) {
            $complaint->reviewed_at = now();
        } elseif ($request->status === 'in_progress' && !$complaint->in_progress_at) {
            $complaint->in_progress_at = now();
        } elseif ($request->status === 'resolved' && !$complaint->resolved_at) {
            $complaint->resolved_at = now();
        } elseif ($request->status === 'rejected') {
            $complaint->rejected_at = now();
            $complaint->rejection_reason = $request->rejection_reason;
        }

        $complaint->save();

        return redirect()->route('admin.desa-management.complaints.show', $id)
            ->with('success', 'Status pengaduan berhasil diperbarui');
    }

    /**
     * Download evidence file
     */
    public function downloadEvidence($id, $index)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];

        $complaint = CitizenComplaint::where('village_id', $village->id)->findOrFail($id);
        
        $files = $complaint->bukti_files ?? [];
        
        if (!isset($files[$index])) {
            abort(404, 'File tidak ditemukan');
        }

        $filePath = $files[$index];
        
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download(Storage::disk('public')->path($filePath));
    }
}
