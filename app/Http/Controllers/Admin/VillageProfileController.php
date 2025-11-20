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

    /**
     * Store a new structure (perangkat desa).
     */
    public function storeStructure(Request $request): RedirectResponse
    {
        $village = Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'since' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $structures = $village->structures ?? [];
        
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('villages/structures', 'public');
        }

        $structures[] = [
            'name' => $validated['name'],
            'role' => $validated['role'],
            'since' => $validated['since'] ?? '',
            'photo' => $photoPath ? Storage::url($photoPath) : 'https://via.placeholder.com/200x200?text=No+Photo',
        ];

        $village->structures = $structures;
        $village->save();

        return redirect()
            ->route('admin.desa-management.profile')
            ->with('success', 'Perangkat desa berhasil ditambahkan.');
    }

    /**
     * Update an existing structure.
     */
    public function updateStructure(Request $request, int $index): RedirectResponse
    {
        $village = Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'since' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $structures = $village->structures ?? [];
        
        if (!isset($structures[$index])) {
            return redirect()
                ->route('admin.desa-management.profile')
                ->with('error', 'Data perangkat desa tidak ditemukan.');
        }

        // Handle photo update
        $photoPath = $structures[$index]['photo'] ?? null;
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($photoPath && !str_starts_with($photoPath, 'http')) {
                $oldPath = str_replace('/storage/', '', parse_url($photoPath, PHP_URL_PATH));
                Storage::disk('public')->delete($oldPath);
            }
            
            $photoPath = $request->file('photo')->store('villages/structures', 'public');
            $photoPath = Storage::url($photoPath);
        } elseif (empty($photoPath)) {
            $photoPath = 'https://via.placeholder.com/200x200?text=No+Photo';
        }

        $structures[$index] = [
            'name' => $validated['name'],
            'role' => $validated['role'],
            'since' => $validated['since'] ?? '',
            'photo' => $photoPath,
        ];

        $village->structures = $structures;
        $village->save();

        return redirect()
            ->route('admin.desa-management.profile')
            ->with('success', 'Perangkat desa berhasil diperbarui.');
    }

    /**
     * Delete a structure.
     */
    public function destroyStructure(int $index): RedirectResponse
    {
        $village = Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );

        $structures = $village->structures ?? [];
        
        if (!isset($structures[$index])) {
            return redirect()
                ->route('admin.desa-management.profile')
                ->with('error', 'Data perangkat desa tidak ditemukan.');
        }

        // Delete photo if exists
        $photoPath = $structures[$index]['photo'] ?? null;
        if ($photoPath && !str_starts_with($photoPath, 'http')) {
            $oldPath = str_replace('/storage/', '', parse_url($photoPath, PHP_URL_PATH));
            Storage::disk('public')->delete($oldPath);
        }

        // Remove structure from array
        unset($structures[$index]);
        $structures = array_values($structures); // Re-index array

        $village->structures = $structures;
        $village->save();

        return redirect()
            ->route('admin.desa-management.profile')
            ->with('success', 'Perangkat desa berhasil dihapus.');
    }
}
