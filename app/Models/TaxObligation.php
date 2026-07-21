<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxObligation extends Model
{
    protected $fillable = [
        'roadmap_id',
        'nom',
        'description',
        'frequence',
        'obligatoire',
    ];

    public function roadmap(): BelongsTo
    {
        return $this->belongsTo(Roadmap::class);
    }
}
