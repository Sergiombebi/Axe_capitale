<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

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
        'type_compte',
        'date_deblocage',
        'numero_compte',
        'code_secret',
    ];

    /**
     * Relation avec l'utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function credits()
    {
        return $this->hasMany(Credit::class);
    }
    protected static function boot()
{
    parent::boot();

    static::creating(function ($compte) {

        // --- Numéro de compte ---
        // Récupérer le dernier ID inséré et ajouter +1
        $lastId = Compte::max('id') ?? 0;
        $increment = str_pad($lastId + 1, 2, '0', STR_PAD_LEFT); // 01, 02, 03...

        // Téléphone inversé
        $telInverse = strrev($compte->telephone);

        // Génération du numéro de compte
        $compte->numero_compte = 'AXC' . $increment . $telInverse;

        // --- Code secret 4 chiffres ---
        $plainCode = mt_rand(1000, 9999);

        // Stockage hashé en base
        $compte->code_secret = Hash::make($plainCode);

        // Si tu veux garder le code en clair pour l’utilisateur → crée une autre colonne
        $compte->code_secret_visible = $plainCode;
    });
}

}
