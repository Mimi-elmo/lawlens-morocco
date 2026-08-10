<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\StoreLegalStructureWebRequest;
use App\Http\Requests\Web\Admin\UpdateLegalStructureWebRequest;
use App\Models\LegalStructure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LegalStructureController extends Controller
{
    private function makeUniqueSlug(string $nom, ?int $ignoreId = null): string
    {
        $base = Str::slug($nom);
        $slug = $base;
        $suffix = 1;

        while (LegalStructure::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.($suffix++);
        }

        return $slug;
    }

    public function index(): View
    {
        $structures = LegalStructure::withCount('legalRules')->latest()->get();

        return view('admin.legal-structures.index', compact('structures'));
    }

    public function create(): View
    {
        return view('admin.legal-structures.create');
    }

    public function store(StoreLegalStructureWebRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->makeUniqueSlug($data['nom']);

        LegalStructure::create($data);

        return redirect()->route('admin.structures.index')
            ->with('success', 'Structure juridique créée avec succès.');
    }

    public function edit(LegalStructure $structure): View
    {
        return view('admin.legal-structures.edit', compact('structure'));
    }

    public function update(UpdateLegalStructureWebRequest $request, LegalStructure $structure): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['nom'])) {
            $data['slug'] = $this->makeUniqueSlug($data['nom'], $structure->id);
        }

        $structure->update($data);

        return redirect()->route('admin.structures.index')
            ->with('success', 'Structure juridique mise à jour avec succès.');
    }

    public function destroy(LegalStructure $structure): RedirectResponse
    {
        $structure->delete();

        return redirect()->route('admin.structures.index')
            ->with('success', 'Structure juridique supprimée avec succès.');
    }
}