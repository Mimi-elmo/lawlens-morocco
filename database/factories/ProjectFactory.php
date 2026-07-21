<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nom' => fake()->company(),
            'activite' => fake()->randomElement([
                'Commerce électronique',
                'Consulting',
                'Restauration',
                'Agence digitale',
                'Artisanat',
                'Transport',
                'Agriculture',
                'Immobilier',
            ]),
            'description' => fake()->paragraph(),
            'ville' => fake()->randomElement([
                'Casablanca',
                'Rabat',
                'Marrakech',
                'Fès',
                'Tanger',
                'Agadir',
                'Meknès',
                'Oujda',
            ]),
            'budget' => fake()->randomFloat(2, 10000, 1000000),
            'nombre_associes' => fake()->numberBetween(1, 5),
            'type_activite' => fake()->randomElement(['individuelle', 'societe', 'cooperative']),
            'statut' => 'draft',
        ];
    }
}
