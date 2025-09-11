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
            $telInverse = strrev($compte->telephone);
            $compte->numero_compte = 'AXC01' . $telInverse;

            // --- Code secret 4 chiffres ---
            do {
                $plainCode = mt_rand(1000, 9999);
            } while (Compte::where('code_secret', Hash::make($plainCode))->exists());

            // --- Stockage hashé ---
            $compte->code_secret = Hash::make($plainCode);

            // --- Stockage visible pour l’utilisateur ---
            $compte->code_secret = $plainCode;
        });
    }

    
}
