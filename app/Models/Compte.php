<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'cni',
        'photo_cni',
        'sexe',
        'telephone',
        'pays',
        'ville',
        'quartier',
        'lieudit',
        'contact_urgence',
        'tel_urgence',
        'fait_le',
        'fait_a',
        'status',
    ];

    /**
     * Relation avec l'utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
