<?php

namespace App\Services;

use App\Models\LegalRule;
use App\Models\LegalStructure;
use App\Models\Project;

class RoadmapContextBuilder
{
    public function build(Project $project): array
    {
        $structures = LegalStructure::where('statut', 'active')->get();
        $rules = LegalRule::where('statut', 'active')->get()->groupBy('categorie');

        return [
            'project' => [
                'nom' => $project->nom,
                'activite' => $project->activite,
                'description' => $project->description,
                'ville' => $project->ville,
                'budget' => $project->budget,
                'nombre_associes' => $project->nombre_associes,
                'type_activite' => $project->type_activite,
            ],
            'legal_structures' => $structures->map(fn (LegalStructure $s) => [
                'nom' => $s->nom,
                'slug' => $s->slug,
                'description' => $s->description,
                'capital_information' => $s->capital_information,
                'tax_information' => $s->tax_information,
            ])->values()->all(),
            'legal_rules' => [
                'legal' => $this->formatRules($rules->get('legal', collect())),
                'administrative' => $this->formatRules($rules->get('administrative', collect())),
                'fiscal' => $this->formatRules($rules->get('fiscal', collect())),
                'document' => $this->formatRules($rules->get('document', collect())),
            ],
        ];
    }

    public function buildPrompt(Project $project): string
    {
        $context = $this->build($project);

        $prompt = "Tu es un expert juridique spécialisé dans le droit des affaires au Maroc.\n\n";
        $prompt .= "## Projet de l'entrepreneur\n\n";
        $prompt .= "- Nom du projet : {$context['project']['nom']}\n";
        $prompt .= "- Activité : {$context['project']['activite']}\n";
        $prompt .= "- Description : {$context['project']['description']}\n";
        $prompt .= "- Ville : {$context['project']['ville']}\n";
        $prompt .= "- Budget : {$context['project']['budget']} MAD\n";
        $prompt .= "- Nombre d'associés : {$context['project']['nombre_associes']}\n";
        $prompt .= "- Type d'activité : {$context['project']['type_activite']}\n\n";

        $prompt .= "## Structures juridiques disponibles\n\n";
        foreach ($context['legal_structures'] as $structure) {
            $prompt .= "- **{$structure['nom']}** ({$structure['slug']})\n";
            if ($structure['description']) {
                $prompt .= "  Description : {$structure['description']}\n";
            }
            if ($structure['capital_information']) {
                $prompt .= "  Capital : {$structure['capital_information']}\n";
            }
            if ($structure['tax_information']) {
                $prompt .= "  Fiscalité : {$structure['tax_information']}\n";
            }
        }

        $prompt .= "\n## Règles juridiques applicables\n\n";
        foreach ($context['legal_rules'] as $categorie => $rules) {
            if (count($rules) > 0) {
                $prompt .= "### " . ucfirst($categorie) . "\n";
                foreach ($rules as $rule) {
                    $prompt .= "- {$rule['titre']}" . ($rule['description'] ? " : {$rule['description']}" : '') . "\n";
                }
                $prompt .= "\n";
            }
        }

        $prompt .= "---\n\n";
        $prompt .= "Sur la base de ces informations, génère un roadmap personnalisé pour cet entrepreneur.\n";
        $prompt .= "Tu dois répondre UNIQUEMENT avec un objet JSON valide, sans texte avant ni après.\n";

        return $prompt;
    }

    private function formatRules($rules): array
    {
        return $rules->map(fn (LegalRule $r) => [
            'titre' => $r->titre,
            'description' => $r->description,
            'source' => $r->source,
        ])->values()->all();
    }
}
