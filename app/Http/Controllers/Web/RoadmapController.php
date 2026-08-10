<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateRoadmap;
use App\Models\Project;
use App\Models\Roadmap;
use Throwable;

class RoadmapController extends Controller
{
    public function index()
    {
        $roadmaps = Roadmap::whereIn('project_id', function ($q) {
            $q->select('id')->from('projects')->where('user_id', auth()->id());
        })
            ->with('project:id,nom', 'formeJuridiqueRecommendee:id,nom')
            ->withCount('steps')
            ->latest('date_generation')
            ->get();

        return view('roadmaps.index', compact('roadmaps'));
    }

    public function show(Roadmap $roadmap)
    {
        $this->authorize('view', $roadmap);

        $roadmap->load([
            'project:id,nom',
            'formeJuridiqueRecommendee:id,nom',
            'steps' => fn ($q) => $q->orderBy('ordre'),
            'documents',
            'taxObligations',
        ]);

        return view('roadmaps.show', compact('roadmap'));
    }

    public function generate(Project $project)
    {
        $this->authorize('view', $project);

        try {
            GenerateRoadmap::dispatchSync($project);
        } catch (Throwable $e) {
            return redirect()->route('projects.show', $project)
                ->with('error', 'Échec de la génération de la feuille de route : '.$e->getMessage());
        }

        $roadmap = $project->roadmaps()->latest('id')->first();

        return redirect()->route('roadmaps.show', $roadmap)
            ->with('success', 'Feuille de route générée avec succès.');
    }
}
