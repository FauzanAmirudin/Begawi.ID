<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Models\VillageAgenda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VillageAgendaController extends Controller
{
    public function index(): View
    {
        $village = $this->resolveVillage();
        
        $agendas = $village->agendas()
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return view('admin.admin-desa.desa.agendas', [
            'village' => $village,
            'agendas' => $agendas,
        ]);
    }

    public function edit(VillageAgenda $agenda): View
    {
        $village = $this->resolveVillage();
        
        return view('admin.admin-desa.desa.agendas', [
            'village' => $village,
            'agendas' => $village->agendas()->orderBy('date')->orderBy('time')->get(),
            'editingAgenda' => $agenda,
        ]);
    }

    protected function processAgendaData(array $validated): array
    {
        // Filter out empty timeline items
        if (isset($validated['timeline']) && is_array($validated['timeline'])) {
            $validated['timeline'] = array_filter($validated['timeline'], function($item) {
                return isset($item['time']) && !empty(trim($item['time'])) && 
                       isset($item['title']) && !empty(trim($item['title']));
            });
            $validated['timeline'] = array_values($validated['timeline']); // Re-index array
            if (empty($validated['timeline'])) {
                $validated['timeline'] = null;
            }
        }

        // Filter out empty checklist items
        if (isset($validated['checklist']) && is_array($validated['checklist'])) {
            $validated['checklist'] = array_filter($validated['checklist'], function($item) {
                return !empty(trim($item));
            });
            $validated['checklist'] = array_values($validated['checklist']); // Re-index array
            if (empty($validated['checklist'])) {
                $validated['checklist'] = null;
            }
        }

        // Filter out empty organizers items
        if (isset($validated['organizers']) && is_array($validated['organizers'])) {
            $validated['organizers'] = array_filter($validated['organizers'], function($item) {
                return isset($item['name']) && !empty(trim($item['name']));
            });
            $validated['organizers'] = array_values($validated['organizers']); // Re-index array
            if (empty($validated['organizers'])) {
                $validated['organizers'] = null;
            }
        }

        return $validated;
    }

    public function store(Request $request): RedirectResponse
    {
        $village = $this->resolveVillage();

        $validated = $request->validateWithBag('agenda', [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i'],
            'location' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:Rapat,Pelatihan,Acara,Kesehatan'],
            'is_published' => ['nullable', 'boolean'],
            'timeline' => ['nullable', 'array'],
            'timeline.*.time' => ['nullable', 'string'],
            'timeline.*.title' => ['nullable', 'string'],
            'timeline.*.desc' => ['nullable', 'string'],
            'checklist' => ['nullable', 'array'],
            'checklist.*' => ['nullable', 'string'],
            'organizers' => ['nullable', 'array'],
            'organizers.*.name' => ['nullable', 'string'],
            'organizers.*.contact' => ['nullable', 'string'],
            'organizers.*.phone' => ['nullable', 'string'],
        ]);

        $validated = $this->processAgendaData($validated);
        $validated['village_id'] = $village->id;
        $validated['is_published'] = $request->boolean('is_published', true);

        VillageAgenda::create($validated);

        return redirect()
            ->route('admin.desa-management.agendas')
            ->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function update(Request $request, VillageAgenda $agenda): RedirectResponse
    {
        $validated = $request->validateWithBag('agenda', [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i'],
            'location' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:Rapat,Pelatihan,Acara,Kesehatan'],
            'is_published' => ['nullable', 'boolean'],
            'timeline' => ['nullable', 'array'],
            'timeline.*.time' => ['nullable', 'string'],
            'timeline.*.title' => ['nullable', 'string'],
            'timeline.*.desc' => ['nullable', 'string'],
            'checklist' => ['nullable', 'array'],
            'checklist.*' => ['nullable', 'string'],
            'organizers' => ['nullable', 'array'],
            'organizers.*.name' => ['nullable', 'string'],
            'organizers.*.contact' => ['nullable', 'string'],
            'organizers.*.phone' => ['nullable', 'string'],
        ]);

        $validated = $this->processAgendaData($validated);
        $validated['is_published'] = $request->boolean('is_published', true);

        $agenda->update($validated);

        return redirect()
            ->route('admin.desa-management.agendas')
            ->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(VillageAgenda $agenda): RedirectResponse
    {
        $agenda->delete();

        return redirect()
            ->route('admin.desa-management.agendas')
            ->with('success', 'Agenda berhasil dihapus.');
    }

    protected function resolveVillage(): Village
    {
        return Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );
    }
}
