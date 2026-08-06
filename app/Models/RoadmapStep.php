<?php

namespace App\Models;

use Database\Factories\RoadmapStepFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoadmapStep extends Model
{
    /** @use HasFactory<RoadmapStepFactory> */
    use HasFactory;

    protected $fillable = [
        'roadmap_id',
        'titre',
        'description',
        'ordre',
        'statut',
    ];

    public function roadmap(): BelongsTo
    {
        return $this->belongsTo(Roadmap::class);
    }
}
