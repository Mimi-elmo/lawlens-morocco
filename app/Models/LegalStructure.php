<?php

namespace App\Models;

use Database\Factories\LegalStructureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LegalStructure extends Model
{
    /** @use HasFactory<LegalStructureFactory> */
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'capital_information',
        'tax_information',
        'statut',
    ];

    public function legalRules(): BelongsToMany
    {
        return $this->belongsToMany(LegalRule::class, 'legal_structure_rule');
    }

    public function roadmaps(): HasMany
    {
        return $this->hasMany(Roadmap::class, 'forme_juridique_recommandee_id');
    }
}
