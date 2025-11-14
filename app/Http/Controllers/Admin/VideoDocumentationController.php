<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VideoDocumentation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VideoDocumentationController extends Controller
{
    /**
     * Check if current user is super admin
     */
    protected function checkSuperAdmin(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user || $user->role !== User::ROLE_SUPER_ADMIN) {
            abort(403, 'Akses ditolak. Hanya Super Admin yang dapat mengakses halaman ini.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->checkSuperAdmin();
        
        $videos = VideoDocumentation::with('creator')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.super-admin.content.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->checkSuperAdmin();
        
        return view('admin.super-admin.content.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:youtube,pdf',
            'youtube_url' => 'required_if:type,youtube|nullable|url',
            'pdf_file' => 'required_if:type,pdf|nullable|file|mimes:pdf|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = Auth::id();
        $validated['is_published'] = $request->has('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        
        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('documentations', 'public');
        }
        
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('documentations', 'public');
        }

        if ($validated['is_published'] && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        VideoDocumentation::create($validated);

        return redirect()
            ->route('admin.content.videos.index')
            ->with('success', 'Video/Dokumentasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VideoDocumentation $video): View
    {
        $this->checkSuperAdmin();
        
        $video->load('creator');
        
        return view('admin.super-admin.content.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VideoDocumentation $video): View
    {
        $this->checkSuperAdmin();
        
        return view('admin.super-admin.content.videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoDocumentation $video): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:youtube,pdf',
            'youtube_url' => 'required_if:type,youtube|nullable|url',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');
        
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF if exists
            if ($video->pdf_file) {
                Storage::disk('public')->delete($video->pdf_file);
            }
            $validated['pdf_file'] = $request->file('pdf_file')->store('documentations', 'public');
        }
        
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('documentations', 'public');
        }

        if ($validated['is_published'] && !$video->published_at && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $video->update($validated);

        return redirect()
            ->route('admin.content.videos.index')
            ->with('success', 'Video/Dokumentasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VideoDocumentation $video): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        // Delete files if exists
        if ($video->pdf_file) {
            Storage::disk('public')->delete($video->pdf_file);
        }
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        return redirect()
            ->route('admin.content.videos.index')
            ->with('success', 'Video/Dokumentasi berhasil dihapus.');
    }
}
