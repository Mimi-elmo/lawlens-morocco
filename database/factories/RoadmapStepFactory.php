<?php

namespace Database\Factories;

use App\Models\Roadmap;
use App\Models\RoadmapStep;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoadmapStepFactory extends Factory
{
    protected $model = RoadmapStep::class;

    public function definition(): array
    {
        return [
            'roadmap_id' => Roadmap::factory(),
            'titre' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'ordre' => fake()->numberBetween(1, 10),
            'statut' => fake()->randomElement(['pending', 'in_progress', 'completed']),
        ];
    }
}
