<?php

namespace Database\Factories;

use App\Models\LegalStructure;
use App\Models\Project;
use App\Models\Roadmap;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoadmapFactory extends Factory
{
    protected $model = Roadmap::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'forme_juridique_recommandee_id' => LegalStructure::factory(),
            'resume' => fake()->paragraph(),
            'reponse_IA' => json_encode(['test' => true]),
            'statut' => fake()->randomElement(['pending', 'generating', 'completed', 'failed']),
            'progression' => fake()->numberBetween(0, 100),
            'date_generation' => fake()->dateTime(),
        ];
    }
}
