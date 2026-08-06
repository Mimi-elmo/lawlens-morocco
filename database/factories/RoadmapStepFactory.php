<?php

namespace Database\Factories;

use App\Models\RoadmapStep;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoadmapStep>
 */
class RoadmapStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'roadmap_id' => \App\Models\Roadmap::factory(),
            'titre' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'ordre' => fake()->numberBetween(1, 10),
            'statut' => fake()->randomElement(['pending', 'in_progress', 'completed']),
        ];
    }
}
