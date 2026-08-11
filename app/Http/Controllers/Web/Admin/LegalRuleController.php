<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLegalRuleRequest;
use App\Http\Requests\Admin\UpdateLegalRuleRequest;
use App\Models\LegalRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LegalRuleController extends Controller
{
    public function index(): View
    {
        $rules = LegalRule::withCount('legalStructures')->latest()->get();

        return view('admin.legal-rules.index', compact('rules'));
    }

    public function create(): View
    {
        return view('admin.legal-rules.create');
    }

    public function store(StoreLegalRuleRequest $request): RedirectResponse
    {
        LegalRule::create($request->validated());

        return redirect()->route('admin.rules.index')
            ->with('success', 'Règle juridique créée avec succès.');
    }

    public function edit(LegalRule $rule): View
    {
        return view('admin.legal-rules.edit', compact('rule'));
    }

    public function update(UpdateLegalRuleRequest $request, LegalRule $rule): RedirectResponse
    {
        $rule->update($request->validated());

        return redirect()->route('admin.rules.index')
            ->with('success', 'Règle juridique mise à jour avec succès.');
    }

    public function destroy(LegalRule $rule): RedirectResponse
    {
        $rule->delete();

        return redirect()->route('admin.rules.index')
            ->with('success', 'Règle juridique supprimée avec succès.');
    }
}