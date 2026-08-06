<?php

namespace App\Services;

use App\DataTransferObjects\RoadmapResult;
use App\Models\LegalStructure;
use App\Models\Project;
use App\Models\Roadmap;
use App\Models\RoadmapDocument;
use App\Models\RoadmapStep;
use App\Models\TaxObligation;
use Exception;
use Illuminate\Support\Facades\DB;
use Laravel\Ai\AnonymousAgent;
use Laravel\Ai\Enums\Lab;

class RoadmapGenerator
{
    public function __construct(
        private readonly RoadmapContextBuilder $contextBuilder,
    ) {}

    public function generate(Project $project, ?Lab $provider = null): Roadmap
    {
        $prompt = $this->contextBuilder->buildPrompt($project);

        $agent = new AnonymousAgent(
            instructions: 'Tu génères des roadmaps juridiques pour entrepreneurs au Maroc. Réponds UNIQUEMENT avec un JSON valide.',
            messages: [],
            tools: [],
        );

        $response = $agent->prompt($prompt, provider: $provider);

        $result = $this->parseResponse($response->text);

        return $this->persist($project, $result);
    }

    public function parseResponse(string $text): RoadmapResult
    {
        $text = trim($text);

        $text = preg_replace('/^```(?:json)?\s*/i', '', $text);
        $text = preg_replace('/\s*```$/', '', $text);

        $data = json_decode($text, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Impossible de décoder la réponse IA : ' . json_last_error_msg());
        }

        return RoadmapResult::fromArray($data);
    }

    public function persist(Project $project, RoadmapResult $result): Roadmap
    {
        return DB::transaction(function () use ($project, $result) {
            $structure = LegalStructure::where('slug', $result->recommendedLegalStructure)
                ->orWhere('nom', $result->recommendedLegalStructure)
                ->first();

            $roadmap = Roadmap::create([
                'project_id' => $project->id,
                'forme_juridique_recommandee_id' => $structure?->id,
                'resume' => $result->summary,
                'statut' => 'pending',
                'progression' => 0,
                'date_generation' => now(),
            ]);

            foreach ($result->steps as $i => $step) {
                RoadmapStep::create([
                    'roadmap_id' => $roadmap->id,
                    'titre' => $step['titre'],
                    'description' => $step['description'],
                    'ordre' => $step['ordre'] ?: $i + 1,
                    'statut' => 'pending',
                ]);
            }

            foreach ($result->requiredDocuments as $doc) {
                RoadmapDocument::create([
                    'roadmap_id' => $roadmap->id,
                    'nom' => $doc['nom'],
                    'description' => $doc['description'],
                    'obligatoire' => $doc['obligatoire'] ?? true,
                    'statut' => 'pending',
                ]);
            }

            foreach ($result->taxObligations as $tax) {
                TaxObligation::create([
                    'roadmap_id' => $roadmap->id,
                    'nom' => $tax['nom'],
                    'description' => $tax['description'],
                    'frequence' => $tax['frequence'] ?? '',
                    'obligatoire' => $tax['obligatoire'] ?? true,
                ]);
            }

            return $roadmap->fresh();
        });
    }
}
