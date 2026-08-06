<?php

namespace App\Models;

use Database\Factories\RoadmapFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Roadmap extends Model
{
    /** @use HasFactory<RoadmapFactory> */
    use HasFactory;

    protected $fillable = [
        'project_id',
        'forme_juridique_recommandee_id',
        'resume',
        'reponse_IA',
        'statut',
        'progression',
        'date_generation',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function formeJuridiqueRecommendee(): BelongsTo
    {
        return $this->belongsTo(LegalStructure::class, 'forme_juridique_recommandee_id');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(RoadmapStep::class, 'roadmap_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(RoadmapDocument::class, 'roadmap_id');
    }

    public function taxObligations(): HasMany
    {
        return $this->hasMany(TaxObligation::class, 'roadmap_id');
    }

    public function updateProgress(): void
    {
        $total = $this->steps()->count();
        $completed = $this->steps()->where('statut', 'completed')->count();
        $progression = $total > 0 ? round($completed / $total * 100) : 0;

        $this->update(['progression' => $progression]);

        if ($progression === 100) {
            $this->update(['statut' => 'completed']);
        }
    }
}
