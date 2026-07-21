<?php

namespace Database\Factories;

use App\Models\LegalRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class LegalRuleFactory extends Factory
{
    protected $model = LegalRule::class;

    public function definition(): array
    {
        return [
            'titre' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'categorie' => fake()->randomElement(['legal', 'administrative', 'fiscal', 'document']),
            'source' => fake()->randomElement(['Dahir n° 1-', 'Loi n° ', 'Code du commerce', 'Code général des impôts']),
            'date_entree_vigueur' => fake()->date(),
            'statut' => 'active',
        ];
    }
}
