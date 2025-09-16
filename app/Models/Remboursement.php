<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remboursement extends Model
{
    protected $fillable = [
        'credit_id',
        'montant',
        'type',
        'notes',
        'date_remboursement',
        'enregistre_par'
    ];

    public function credit()
    {
        return $this->belongsTo(Credit::class);
    }
}
