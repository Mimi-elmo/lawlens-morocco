<?php

namespace App\Jobs;

use App\Models\Project;
use App\Services\RoadmapGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateRoadmapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 10;
    public int $timeout = 300;

    public function __construct(
        public Project $project,
    ) {}

    public function handle(RoadmapGenerator $generator): void
    {
        $this->project->roadmaps()
            ->where('statut', 'pending')
            ->update(['statut' => 'generating']);

        $roadmap = $generator->generate($this->project);

        $roadmap->update(['statut' => 'completed']);
        $this->project->update(['statut' => 'active']);

        Log::info('Roadmap generated successfully', [
            'project_id' => $this->project->id,
            'roadmap_id' => $roadmap->id,
        ]);
    }

    public function retryUntil(): \DateTime
    {
        return now()->addMinutes(15);
    }

    public function failed(\Throwable $e): void
    {
        $this->project->roadmaps()
            ->whereIn('statut', ['pending', 'generating'])
            ->update(['statut' => 'failed']);

        $roadmap = $this->project->roadmaps()->where('statut', 'failed')->first();

        if (! $roadmap) {
            $roadmap = $this->project->roadmaps()->create([
                'resume' => 'Échec de la génération du roadmap.',
                'statut' => 'failed',
                'date_generation' => now(),
            ]);
        } else {
            $roadmap->update([
                'resume' => 'Échec de la génération du roadmap après plusieurs tentatives.',
            ]);
        }

        Log::error('Roadmap generation failed', [
            'project_id' => $this->project->id,
            'roadmap_id' => $roadmap->id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
}
