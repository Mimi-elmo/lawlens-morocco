<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Roadmap;
use App\Models\RoadmapStep;
use Illuminate\Http\Request;

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
}
