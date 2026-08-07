<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', auth()->id())
            ->withCount('roadmaps')
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'activite' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'ville' => ['required', 'string', 'max:255'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'nombre_associes' => ['required', 'integer', 'min:1'],
            'type_activite' => ['required', 'string', 'in:individuelle,societe'],
        ]);

        $project = Project::create([
            ...$data,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Projet cr├⌐├⌐ avec succ├¿s.');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        $project->loadCount('roadmaps');

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $data = $request->validate([
            'nom' => ['sometimes', 'string', 'max:255'],
            'activite' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'ville' => ['sometimes', 'string', 'max:255'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'nombre_associes' => ['sometimes', 'integer', 'min:1'],
            'type_activite' => ['sometimes', 'string', 'in:individuelle,societe'],
            'statut' => ['sometimes', 'string', 'in:brouillon,en_cours,termine'],
        ]);

        $project->update($data);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Projet mis ├á jour avec succ├¿s.');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Projet supprim├⌐ avec succ├¿s.');
    }
}
