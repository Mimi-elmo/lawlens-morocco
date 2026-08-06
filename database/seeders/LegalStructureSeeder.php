<?php

namespace Database\Seeders;

use App\Models\LegalStructure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegalStructureSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $structures = [
            [
                'nom' => 'Auto-entrepreneur',
                'slug' => 'auto-entrepreneur',
                'description' => 'Régime simplifié destiné aux personnes physiques exerçant une activité professionnelle indépendante. Plafond de chiffre d\'affaires annuel : 500 000 DH pour le commerce et 200 000 DH pour les services.',
                'capital_information' => 'Aucun capital minimum requis.',
                'tax_information' => 'Régime fiscal simplifié basé sur le chiffre d\'affaires. Taux variable selon l\'activité.',
            ],
            [
                'nom' => 'SARL',
                'slug' => 'sarl',
                'description' => 'Société à Responsabilité Limitée. La responsabilité des associés est limitée à leurs apports. Gérée par un ou plusieurs gérants.',
                'capital_information' => 'Capital minimum : 10 000 DH. Divisé en parts sociales.',
                'tax_information' => 'Soumise à l\'IS (Impôt sur les Sociétés) au taux de 20% à 31% selon le bénéfice.',
            ],
            [
                'nom' => 'SARL AU',
                'slug' => 'sarl-au',
                'description' => 'SARL à Associé Unique. Variante de la SARL avec un seul associé qui détient la totalité des parts.',
                'capital_information' => 'Capital minimum : 10 000 DH. Un seul associé.',
                'tax_information' => 'Soumise à l\'IS. Option possible pour l\'IR sous conditions.',
            ],
            [
                'nom' => 'SA',
                'slug' => 'sa',
                'description' => 'Société Anonyme. Société de capitaux destinée aux grandes entreprises. Conseil d\'administration ou directoire obligatoire.',
                'capital_information' => 'Capital minimum : 300 000 DH pour les SA non cotées, 3 000 000 DH pour les SA cotées.',
                'tax_information' => 'Soumise à l\'IS. Obligations comptables renforcées.',
            ],
            [
                'nom' => 'SAS',
                'slug' => 'sas',
                'description' => 'Société par Actions Simplifiée. Structure flexible adaptée aux projets innovants et aux levées de fonds.',
                'capital_information' => 'Capital minimum : 10 000 DH. Liberté statutaire importante.',
                'tax_information' => 'Soumise à l\'IS. Possibilité d\'opter pour l\'IR pendant 5 ans.',
            ],
            [
                'nom' => 'SNC',
                'slug' => 'snc',
                'description' => 'Société en Nom Collectif. Société de personnes où les associés sont indéfiniment et solidairement responsables des dettes sociales.',
                'capital_information' => 'Pas de capital minimum légal.',
                'tax_information' => 'Imposée par défaut à l\'IR (nom des associés). Option possible pour l\'IS.',
            ],
        ];

        foreach ($structures as $structure) {
            LegalStructure::firstOrCreate(
                ['slug' => $structure['slug']],
                $structure
            );
        }
    }
}
