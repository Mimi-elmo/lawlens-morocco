<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\Roadmap;
use App\Services\AiService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class GenerateRoadmap implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        public Project $project
    ) {}

    public function handle(AiService $aiService): void
    {
        try {
            $roadmap = Roadmap::create([
                'project_id' => $this->project->id,
                'statut' => 'generating',
                'progression' => 10,
            ]);

            $roadmap->update(['progression' => 30]);

            $result = $aiService->generateRoadmap($this->project);

            $roadmap->update(['progression' => 70]);

            DB::transaction(function () use ($roadmap, $result) {
                $roadmap->update([
                    'forme_juridique_recommandee_id' => $result['forme_juridique_recommandee_id'],
                    'resume' => $result['resume'],
                    'reponse_IA' => $result['reponse_IA'],
                    'statut' => 'completed',
                    'progression' => 100,
                    'date_generation' => now(),
                ]);

                foreach ($result['etapes'] as $etape) {
                    $roadmap->steps()->create($etape);
                }

                foreach ($result['documents'] as $document) {
                    $roadmap->documents()->create($document);
                }

                foreach ($result['obligations_fiscales'] as $obligation) {
                    $roadmap->taxObligations()->create($obligation);
                }
            });
        } catch (RuntimeException $e) {
            if (isset($roadmap)) {
                $roadmap->update([
                    'statut' => 'failed',
                    'reponse_IA' => $e->getMessage(),
                ]);
            }

            throw $e;
        } catch (\Exception $e) {
            if (isset($roadmap)) {
                $roadmap->update([
                    'statut' => 'failed',
                    'reponse_IA' => $e->getMessage(),
                ]);
            }

            throw $e;
        }
    }
}
