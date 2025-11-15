<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterSubmission;
use App\Models\User;
use App\Models\Village;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LetterSubmissionController extends Controller
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
     * Display a listing of letter submissions
     */
    public function index(Request $request)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];

        if (!$village) {
            return view('admin.admin-desa.letters.index', [
                'submissions' => collect([])->paginate(15),
                'village' => null,
                'stats' => [
                    'total' => 0,
                    'pending' => 0,
                    'processed' => 0,
                    'completed' => 0,
                ],
                'filters' => $request->only(['search', 'status', 'letter_type']),
            ]);
        }

        $query = LetterSubmission::where('village_id', $village->id)
            ->with('processor');

        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('tracking_code', 'like', '%' . $search . '%')
                        ->orWhere('nama', 'like', '%' . $search . '%')
                        ->orWhere('nik', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Letter type filter
        if ($request->filled('letter_type')) {
            $query->where('letter_type', $request->letter_type);
        }

        $submissions = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Get statistics
        $stats = [
            'total' => LetterSubmission::where('village_id', $village->id)->count(),
            'pending' => LetterSubmission::where('village_id', $village->id)->where('status', 'pending')->count(),
            'processed' => LetterSubmission::where('village_id', $village->id)->whereIn('status', ['verified', 'processed'])->count(),
            'completed' => LetterSubmission::where('village_id', $village->id)->where('status', 'completed')->count(),
        ];

        return view('admin.admin-desa.letters.index', [
            'submissions' => $submissions,
            'village' => $village,
            'stats' => $stats,
            'filters' => $request->only(['search', 'status', 'letter_type']),
        ]);
    }

    /**
     * Show the specified letter submission
     */
    public function show($id)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];

        $submission = LetterSubmission::where('village_id', $village->id)
            ->with('processor')
            ->findOrFail($id);

        return view('admin.admin-desa.letters.show', [
            'submission' => $submission,
            'village' => $village,
        ]);
    }

    /**
     * Update submission status
     */
    public function updateStatus(Request $request, $id)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];

        $submission = LetterSubmission::where('village_id', $village->id)->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,verified,processed,completed,rejected',
            'admin_notes' => 'nullable|string',
            'rejection_reason' => 'required_if:status,rejected|nullable|string',
        ]);

        $submission->status = $request->status;
        $submission->admin_notes = $request->admin_notes;
        $submission->processed_by = Auth::id();

        // Set timestamps based on status
        if ($request->status === 'verified' && !$submission->verified_at) {
            $submission->verified_at = now();
        } elseif ($request->status === 'processed' && !$submission->processed_at) {
            $submission->processed_at = now();
        } elseif ($request->status === 'completed' && !$submission->completed_at) {
            $submission->completed_at = now();
        } elseif ($request->status === 'rejected') {
            $submission->rejected_at = now();
            $submission->rejection_reason = $request->rejection_reason;
        }

        $submission->save();

        return redirect()->route('admin.desa-management.letters.show', $id)
            ->with('success', 'Status permohonan berhasil diperbarui');
    }

    /**
     * Download requirement file
     */
    public function downloadRequirement($id, $index)
    {
        $villageData = $this->getUserVillageData();
        $village = $villageData['village'];

        $submission = LetterSubmission::where('village_id', $village->id)->findOrFail($id);
        
        $files = $submission->requirements_files ?? [];
        
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
