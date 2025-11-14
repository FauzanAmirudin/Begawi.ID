<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Models\VillageAchievement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillageAchievementController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $village = $this->resolveVillage();

        $validated = $request->validateWithBag('achievement', [
            'title' => ['required', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:' . (now()->year + 1)],
            'category' => ['nullable', 'string', 'max:150'],
            'organizer' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment_path'] = $request->file('attachment')->store('villages/achievements', 'public');
        }

        $validated['village_id'] = $village->id;

        VillageAchievement::create($validated);

        return redirect()
            ->route('admin.desa-management.achievements')
            ->with('success', 'Prestasi desa berhasil ditambahkan.');
    }

    public function update(Request $request, VillageAchievement $achievement): RedirectResponse
    {
        $validated = $request->validateWithBag('achievement', [
            'title' => ['required', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:' . (now()->year + 1)],
            'category' => ['nullable', 'string', 'max:150'],
            'organizer' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($request->hasFile('attachment')) {
            if ($achievement->attachment_path) {
                Storage::disk('public')->delete($achievement->attachment_path);
            }

            $validated['attachment_path'] = $request->file('attachment')->store('villages/achievements', 'public');
        }

        $achievement->update($validated);

        return redirect()
            ->route('admin.desa-management.achievements')
            ->with('success', 'Prestasi desa berhasil diperbarui.');
    }

    public function destroy(VillageAchievement $achievement): RedirectResponse
    {
        if ($achievement->attachment_path) {
            Storage::disk('public')->delete($achievement->attachment_path);
        }

        $achievement->delete();

        return redirect()
            ->route('admin.desa-management.achievements')
            ->with('success', 'Prestasi desa berhasil dihapus.');
    }

    protected function resolveVillage(): Village
    {
        return Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );
    }
}
