<?php

namespace App\Models;

use Database\Factories\LegalRuleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LegalRule extends Model
{
    /** @use HasFactory<LegalRuleFactory> */
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'categorie',
        'source',
        'date_entree_vigueur',
        'statut',
    ];

    public function legalStructures(): BelongsToMany
    {
        return $this->belongsToMany(LegalStructure::class, 'legal_structure_rule');
    }
}
