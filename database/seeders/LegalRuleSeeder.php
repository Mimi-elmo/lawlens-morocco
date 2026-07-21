<?php

namespace Database\Seeders;

use App\Models\LegalRule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegalRuleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $rules = [
            // Legal rules
            [
                'titre' => 'Obligation d\'immatriculation au Registre du Commerce',
                'description' => 'Toute personne physique ou morale exerçant une activité commerciale doit s\'immatriculer au Registre du Commerce dans les 30 jours suivant le début d\'activité.',
                'categorie' => 'legal',
                'source' => 'Code du Commerce - Article 38',
                'date_entree_vigueur' => '1996-08-01',
            ],
            [
                'titre' => 'Obtention de la patente',
                'description' => 'Toute personne exerçant une activité professionnelle au Maroc doit obtenir une patente auprès de la commune territorialement compétente.',
                'categorie' => 'legal',
                'source' => 'Code général des impôts - Articles 216 à 235',
                'date_entree_vigueur' => '2007-01-01',
            ],
            // Administrative rules
            [
                'titre' => 'Déclaration d\'existence à la CNSS',
                'description' => 'Tout employeur doit déclarer son existence à la CNSS dans les 30 jours suivant le début de son activité et immatriculer ses salariés.',
                'categorie' => 'administrative',
                'source' => 'Dahir n° 1-72-184 du 15 juillet 1972',
                'date_entree_vigueur' => '1972-07-15',
            ],
            [
                'titre' => 'Adhésion à la CNOPS ou assurance maladie',
                'description' => 'Tout employeur doit obligatoirement affilier ses salariés à un régime d\'assurance maladie obligatoire (AMO).',
                'categorie' => 'administrative',
                'source' => 'Loi n° 65-00',
                'date_entree_vigueur' => '2002-10-03',
            ],
            // Fiscal rules
            [
                'titre' => 'Déclaration et paiement de l\'IS',
                'description' => 'Les sociétés soumises à l\'IS doivent déposer leur déclaration annuelle dans les 3 mois suivant la clôture de l\'exercice social.',
                'categorie' => 'fiscal',
                'source' => 'Code général des impôts - Article 19',
                'date_entree_vigueur' => '2007-01-01',
            ],
            [
                'titre' => 'Déclaration de la TVA',
                'description' => 'Les assujettis à la TVA doivent déposer une déclaration mensuelle ou trimestrielle selon le régime d\'imposition.',
                'categorie' => 'fiscal',
                'source' => 'Code général des impôts - Articles 87 à 101',
                'date_entree_vigueur' => '2007-01-01',
            ],
            [
                'titre' => 'Tenue de la comptabilité',
                'description' => 'Toute entreprise est tenue de tenir une comptabilité régulière et sincère selon les normes comptables marocaines.',
                'categorie' => 'fiscal',
                'source' => 'Code général des impôts - Article 146',
                'date_entree_vigueur' => '2007-01-01',
            ],
            // Document rules
            [
                'titre' => 'Contrat de société',
                'description' => 'La constitution d\'une société nécessite la rédaction d\'un contrat de société (statuts) devant notaire ou sous seing privé.',
                'categorie' => 'document',
                'source' => 'Code du Commerce - Article 4',
                'date_entree_vigueur' => '1996-08-01',
            ],
            [
                'titre' => 'Attestation de dépôt de capital',
                'description' => 'Le capital social doit être déposé auprès d\'une banque et attesté par une attestation de dépôt avant l\'immatriculation.',
                'categorie' => 'document',
                'source' => 'Code du Commerce - Article 6',
                'date_entree_vigueur' => '1996-08-01',
            ],
            [
                'titre' => 'Pièce d\'identité et casier judiciaire',
                'description' => 'Les associés et gérants doivent fournir une copie de leur pièce d\'identité nationale et un extrait de casier judiciaire.',
                'categorie' => 'document',
                'source' => 'Code du Commerce',
                'date_entree_vigueur' => '1996-08-01',
            ],
        ];

        foreach ($rules as $rule) {
            LegalRule::firstOrCreate(
                ['titre' => $rule['titre']],
                $rule
            );
        }
    }
}
