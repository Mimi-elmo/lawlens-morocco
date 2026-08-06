<?php

namespace App\Services;

use App\Models\LegalRule;
use App\Models\LegalStructure;
use App\Models\Project;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AiService
{
    public function generateRoadmap(Project $project): array
    {
        $prompt = $this->buildPrompt($project);

        $response = $this->callGrokApi($prompt);

        return $this->parseResponse($response, $project);
    }

    private function buildPrompt(Project $project): string
    {
        $structures = LegalStructure::where('statut', 'active')->get();
        $rules = LegalRule::where('statut', 'active')->get();

        $structuresText = $structures->map(fn ($s) => "- {$s->nom}: {$s->description} (Capital: {$s->capital_information}, Fiscal: {$s->tax_information})")->implode("\n");

        $rulesText = $rules->map(fn ($r) => "- [{$r->categorie}] {$r->titre}: {$r->description}")->implode("\n");

        return <<<PROMPT
Tu es un expert juridique marocain spécialisé dans l'accompagnement des entrepreneurs.

Voici les détails du projet :
- Nom : {$project->nom}
- Activité : {$project->activite}
- Description : {$project->description}
- Ville : {$project->ville}
- Budget : {$project->budget} MAD
- Nombre d'associés : {$project->nombre_associes}
- Type d'activité : {$project->type_activite}

Structures juridiques disponibles au Maroc :
{$structuresText}

Règles juridiques applicables :
{$rulesText}

Tu dois répondre UNIQUEMENT avec un objet JSON valide (sans balises markdown, sans commentaires) au format suivant :
{
  "forme_juridique_recommandee_id": <ID de la structure recommandée>,
  "resume": "<Résumé de la recommandation en 2-3 phrases en français>",
  "etapes": [
    { "titre": "<Titre de l'étape>", "description": "<Description détaillée>", "ordre": <numéro> }
  ],
  "documents": [
    { "nom": "<Nom du document>", "description": "<Description>", "obligatoire": true/false }
  ],
  "obligations_fiscales": [
    { "nom": "<Nom de l'obligation>", "description": "<Description>", "frequence": "<mensuelle/trimestrielle/annuelle>", "obligatoire": true/false }
  ]
}

Assure-toi que les étapes sont ordonnées logiquement (1, 2, 3...).
PROMPT;
    }

    private function callGrokApi(string $prompt): string
    {
        $response = Http::timeout(120)
            ->withHeaders([
                'Authorization' => 'Bearer '.config('services.grok.api_key'),
                'Content-Type' => 'application/json',
            ])
            ->post(config('services.grok.base_url').'/chat/completions', [
                'model' => 'grok-2-latest',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.3,
                'max_tokens' => 4000,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Erreur API Grok : '.$response->body()
            );
        }

        return $response->json('choices.0.message.content');
    }

    private function parseResponse(string $content, Project $project): array
    {
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        $structureId = $data['forme_juridique_recommandee_id'] ?? null;

        if ($structureId && ! LegalStructure::where('id', $structureId)->exists()) {
            $structureId = null;
        }

        return [
            'forme_juridique_recommandee_id' => $structureId,
            'resume' => $data['resume'] ?? null,
            'reponse_IA' => $content,
            'etapes' => collect($data['etapes'] ?? [])->map(fn ($e) => [
                'titre' => $e['titre'],
                'description' => $e['description'] ?? null,
                'ordre' => $e['ordre'],
            ])->toArray(),
            'documents' => collect($data['documents'] ?? [])->map(fn ($d) => [
                'nom' => $d['nom'],
                'description' => $d['description'] ?? null,
                'obligatoire' => $d['obligatoire'] ?? false,
            ])->toArray(),
            'obligations_fiscales' => collect($data['obligations_fiscales'] ?? [])->map(fn ($o) => [
                'nom' => $o['nom'],
                'description' => $o['description'] ?? null,
                'frequence' => $o['frequence'] ?? null,
                'obligatoire' => $o['obligatoire'] ?? false,
            ])->toArray(),
        ];
    }
}
