<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Models\VillageProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VillageProgramController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $village = $this->resolveVillage();

        $validated = $request->validateWithBag('program', [
            'title' => ['required', 'string', 'max:255'],
            'period' => ['nullable', 'string', 'max:150'],
            'lead' => ['nullable', 'string', 'max:150'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'status' => ['required', 'in:Aktif,Selesai,Ditangguhkan'],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $validated['village_id'] = $village->id;

        VillageProgram::create($validated);

        return redirect()
            ->route('admin.desa-management.index')
            ->with('success', 'Program desa berhasil ditambahkan.');
    }

    public function update(Request $request, VillageProgram $program): RedirectResponse
    {
        $validated = $request->validateWithBag('program', [
            'title' => ['required', 'string', 'max:255'],
            'period' => ['nullable', 'string', 'max:150'],
            'lead' => ['nullable', 'string', 'max:150'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'status' => ['required', 'in:Aktif,Selesai,Ditangguhkan'],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $program->update($validated);

        return redirect()
            ->route('admin.desa-management.index')
            ->with('success', 'Program desa berhasil diperbarui.');
    }

    public function destroy(VillageProgram $program): RedirectResponse
    {
        $program->delete();

        return redirect()
            ->route('admin.desa-management.index')
            ->with('success', 'Program desa berhasil dihapus.');
    }

    protected function resolveVillage(): Village
    {
        return Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );
    }
}
