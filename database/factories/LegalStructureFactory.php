<?php

namespace Database\Factories;

use App\Models\LegalStructure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LegalStructureFactory extends Factory
{
    protected $model = LegalStructure::class;

    public function definition(): array
    {
        $structures = [
            'Auto-entrepreneur',
            'SARL',
            'SARL AU',
            'SA',
            'SAS',
            'SNC',
        ];

        $nom = fake()->randomElement($structures);

        return [
            'nom' => $nom,
            'slug' => Str::slug($nom) . '-' . Str::random(4),
            'description' => fake()->paragraph(),
            'capital_information' => fake()->sentence(),
            'tax_information' => fake()->sentence(),
            'statut' => 'active',
        ];
    }
}
