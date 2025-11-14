<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class VillageProfileController extends Controller
{
    /**
     * Update village profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $village = Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );

        $validated = $request->validateWithBag('profile', [
            'name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'head' => ['nullable', 'string', 'max:255'],
            'head_title' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:500'],
            'code' => ['nullable', 'string', 'max:50'],
            'population' => ['nullable', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:100'],
            'density' => ['nullable', 'string', 'max:100'],
            'vision' => ['nullable', 'string'],
            'vision_period' => ['nullable', 'string', 'max:255'],
            'missions' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            if ($village->logo_path && ! str_starts_with($village->logo_path, 'http')) {
                Storage::disk('public')->delete($village->logo_path);
            }

            $validated['logo_path'] = $request->file('logo')->store('villages/logos', 'public');
        }

        $missions = collect(preg_split("/\r\n|\n|\r/", $validated['missions'] ?? ''))
            ->filter(fn ($mission) => filled(trim($mission)))
            ->map(fn ($mission) => trim($mission))
            ->values()
            ->all();

        unset($validated['missions'], $validated['logo']);

        $village->fill(array_merge($validated, [
            'missions' => $missions,
        ]));

        $village->save();

        return redirect()
            ->route('admin.desa-management.profile')
            ->with('success', 'Profil desa berhasil diperbarui.');
    }
}
