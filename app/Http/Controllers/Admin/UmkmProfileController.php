<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UmkmProfileController extends Controller
{
    /**
     * Display the UMKM business profile page.
     */
    public function index(): View
    {
        $user = Auth::user();
        $umkmBusiness = UmkmBusiness::where('user_id', $user->id)->firstOrFail();

        return view('admin.admin-umkm.profile.index', [
            'umkmBusiness' => $umkmBusiness,
        ]);
    }

    /**
     * Update the UMKM business profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $umkmBusiness = UmkmBusiness::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            // Informasi Umum
            'name' => ['required', 'string', 'max:255'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'maps_embed_url' => ['nullable', 'string', 'max:1000'],
            
            // Tentang Usaha
            'description' => ['nullable', 'string'],
            'about_business' => ['nullable', 'string'],
            
            // Identitas Visual
            'logo' => ['nullable', 'image', 'max:2048'],
            'banner' => ['nullable', 'image', 'max:2048'],
            'branding_color' => ['nullable', 'string', 'max:7'],
            'branding_color_text' => ['nullable', 'string', 'max:7'],
            
            // Jam Operasional
            'operating_hours' => ['nullable', 'array'],
            'operating_hours.*.day' => ['required_with:operating_hours', 'string'],
            'operating_hours.*.open_time' => ['nullable', 'string'],
            'operating_hours.*.close_time' => ['nullable', 'string'],
            'operating_hours.*.is_closed' => ['nullable', 'boolean'],
            
            // Sosial Media
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_facebook' => ['nullable', 'url', 'max:255'],
            'social_tiktok' => ['nullable', 'url', 'max:255'],
            'social_youtube' => ['nullable', 'url', 'max:255'],
        ]);

        // Handle file uploads
        if ($request->hasFile('logo')) {
            if ($umkmBusiness->logo_path && !str_starts_with($umkmBusiness->logo_path, 'http')) {
                Storage::disk('public')->delete($umkmBusiness->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('umkm/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($umkmBusiness->banner_path && !str_starts_with($umkmBusiness->banner_path, 'http')) {
                Storage::disk('public')->delete($umkmBusiness->banner_path);
            }
            $validated['banner_path'] = $request->file('banner')->store('umkm/banners', 'public');
        }

        // Prepare operating hours
        if (isset($validated['operating_hours'])) {
            $operatingHours = [];
            foreach ($validated['operating_hours'] as $hour) {
                if (isset($hour['is_closed']) && $hour['is_closed']) {
                    $operatingHours[] = [
                        'day' => $hour['day'],
                        'is_closed' => true,
                    ];
                } else {
                    $operatingHours[] = [
                        'day' => $hour['day'],
                        'open_time' => $hour['open_time'] ?? null,
                        'close_time' => $hour['close_time'] ?? null,
                        'is_closed' => false,
                    ];
                }
            }
            $validated['operating_hours'] = $operatingHours;
        }

        // Prepare social media
        $socialMedia = [];
        if (!empty($validated['social_instagram'])) {
            $socialMedia['instagram'] = $validated['social_instagram'];
        }
        if (!empty($validated['social_facebook'])) {
            $socialMedia['facebook'] = $validated['social_facebook'];
        }
        if (!empty($validated['social_tiktok'])) {
            $socialMedia['tiktok'] = $validated['social_tiktok'];
        }
        if (!empty($validated['social_youtube'])) {
            $socialMedia['youtube'] = $validated['social_youtube'];
        }
        $validated['social_media'] = !empty($socialMedia) ? $socialMedia : null;

        // Handle branding color
        if (isset($validated['branding_color_text']) && !empty($validated['branding_color_text'])) {
            $validated['branding_color'] = $validated['branding_color_text'];
        }
        unset($validated['branding_color_text']);

        // Remove temporary fields
        unset(
            $validated['logo'],
            $validated['banner'],
            $validated['social_instagram'],
            $validated['social_facebook'],
            $validated['social_tiktok'],
            $validated['social_youtube']
        );

        $umkmBusiness->update($validated);

        return redirect()
            ->route('admin.umkm.profile.index')
            ->with('success', 'Profil usaha berhasil diperbarui.');
    }
}
