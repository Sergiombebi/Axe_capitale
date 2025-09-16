<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'verification_code',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function compte()
    {
        return $this->hasOne(Compte::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     public function compteEpargne()
    {
        return $this->hasOne(Compte::class)->where('type_compte', 'epargne');
    }
    public function estEligibleCredit()
    {
        $compteEpargne = $this->compteEpargne;
        
        // Pas de compte épargne
        if (!$compteEpargne) {
            return [
                'eligible' => false,
                'raison' => 'Aucun compte épargne trouvé'
            ];
        }
        
        // Compte non actif
        if ($compteEpargne->status !== 'actif') {
            return [
                'eligible' => false,
                'raison' => 'Compte épargne non actif'
            ];
        }
        
        // Vérifier l'ancienneté
        $dateCreation = Carbon::parse($compteEpargne->created_at);
        $ancienneteJours = $dateCreation->diffInDays(now());
        
        if ($ancienneteJours < 30) {
            $joursRestants = 30 - $ancienneteJours;
            $dateEligible = $dateCreation->addDays(30)->format('d/m/Y');
            
            return [
                'eligible' => false,
                'raison' => 'Ancienneté insuffisante',
                'jours_restants' => $joursRestants,
                'date_eligible' => $dateEligible,
                'anciennete_jours' => $ancienneteJours
            ];
        }
        
        return [
            'eligible' => true,
            'compte' => $compteEpargne,
            'anciennete_jours' => $ancienneteJours
        ];
    }
    /**
     * Vérifier si l'utilisateur a assez d'épargne (30% du montant)
     */
    public function aAssezEpargne($montantCredit)
    {
        $compteEpargne = $this->compteEpargne;
        
        if (!$compteEpargne) {
            return false;
        }
        
        $montantRequis = $montantCredit * 0.30; // 30%
        
        return $compteEpargne->solde >= $montantRequis;
    }
    public function credits()
    {
        return $this->hasMany(Credit::class, 'compte_id');
    }
   
}
