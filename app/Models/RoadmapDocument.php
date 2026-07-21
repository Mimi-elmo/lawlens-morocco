<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoadmapDocument extends Model
{
    protected $fillable = [
        'roadmap_id',
        'nom',
        'description',
        'obligatoire',
        'statut',
    ];

    public function roadmap(): BelongsTo
    {
        return $this->belongsTo(Roadmap::class);
    }
}
