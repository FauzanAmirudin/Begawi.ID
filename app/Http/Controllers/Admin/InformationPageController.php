<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformationPage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InformationPageController extends Controller
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
        
        $pages = InformationPage::with('creator')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.content.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->checkSuperAdmin();
        
        $pageTypes = InformationPage::getPageTypes();
        
        return view('admin.content.pages.create', compact('pageTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'page_type' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = Auth::id();
        $validated['is_published'] = $request->has('is_published');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('information-pages', 'public');
        }

        if ($validated['is_published'] && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        InformationPage::create($validated);

        return redirect()
            ->route('admin.content.pages.index')
            ->with('success', 'Halaman informasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InformationPage $page): View
    {
        $this->checkSuperAdmin();
        
        $page->load('creator');
        
        return view('admin.content.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InformationPage $page): View
    {
        $this->checkSuperAdmin();
        
        $pageTypes = InformationPage::getPageTypes();
        
        return view('admin.content.pages.edit', compact('page', 'pageTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformationPage $page): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'page_type' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');
        $validated['is_featured'] = $request->has('is_featured');
        
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('information-pages', 'public');
        }

        if ($validated['is_published'] && !$page->published_at && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $page->update($validated);

        return redirect()
            ->route('admin.content.pages.index')
            ->with('success', 'Halaman informasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InformationPage $page): RedirectResponse
    {
        $this->checkSuperAdmin();
        
        // Delete featured image if exists
        if ($page->featured_image) {
            Storage::disk('public')->delete($page->featured_image);
        }

        $page->delete();

        return redirect()
            ->route('admin.content.pages.index')
            ->with('success', 'Halaman informasi berhasil dihapus.');
    }
}
