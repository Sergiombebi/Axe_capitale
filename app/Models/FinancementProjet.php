<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancementProjet extends Model
{
    use HasFactory;

    protected $fillable = [
        'compte_id',
        'nom_projet',
        'secteur_activite',
        'description_projet',
        'montant_total_projet',
        'montant_financement_demande',
        'apport_personnel',
        'duree_remboursement',
        'nature_apport',
        'business_plan',
        'photocopie_cni',
        'plan_localisation',
        'attestation_niu',
        'experience_domaine',
        'employes_prevus',
        'objectifs_court_terme',
        'objectifs_long_terme',
        'accepte_frais_etude',
        'accepte_conditions',
        'frais_etude',
        'frais_etude_paye',
        'date_paiement_frais',
        'status',
        'motif_rejet',
        'observations',
        'traite_par',
        'date_traitement',
        'date_approbation',
        'montant_finance',
        'ratio_remboursement',
        'duree_remboursement_accordee',
        'conditions_remboursement',
        'montant_rembourse',
        'solde_restant',
        'date_debut_remboursement',
        'date_fin_remboursement',
        'historique_status'
    ];

    protected $casts = [
        'montant_total_projet' => 'decimal:2',
        'montant_financement_demande' => 'decimal:2',
        'apport_personnel' => 'decimal:2',
        'frais_etude' => 'decimal:2',
        'montant_finance' => 'decimal:2',
        'ratio_remboursement' => 'decimal:2',
        'montant_rembourse' => 'decimal:2',
        'solde_restant' => 'decimal:2',
        'accepte_frais_etude' => 'boolean',
        'accepte_conditions' => 'boolean',
        'frais_etude_paye' => 'boolean',
        'date_paiement_frais' => 'datetime',
        'date_traitement' => 'datetime',
        'date_approbation' => 'datetime',
        'date_debut_remboursement' => 'datetime',
        'date_fin_remboursement' => 'datetime',
        'historique_status' => 'array',
    ];

    /**
     * Relation avec le compte
     */
    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }

    /**
     * Relation avec l'utilisateur qui a traité le projet
     */
    public function traitePar()
    {
        return $this->belongsTo(User::class, 'traite_par');
    }

    /**
     * Calculer le pourcentage de financement demandé
     */
    // public function pourcentageFinancement(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => $this->montant_total_projet > 0 
    //             ? round(($this->montant_financement_demande / $this->montant_total_projet) * 100, 2)
    //             : 0
    //     );
    // }

    /**
     * Calculer le pourcentage d'apport personnel
     */
    // public function pourcentageApport(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => $this->montant_total_projet > 0 
    //             ? round(($this->apport_personnel / $this->montant_total_projet) * 100, 2)
    //             : 0
    //     );
    // }
}
