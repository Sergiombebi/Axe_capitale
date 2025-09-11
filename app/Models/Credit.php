<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Credit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'compte_id',
        'montant',
        'duree',
        'taux_interet',
        'objet_credit',
        'montant_epargne_requis',
        'montant_total_rembourser',
        'montant_mensuel',
        'avaliste1_nom',
        'avaliste1_telephone',
        'avaliste1_cni',
        'avaliste2_nom',
        'avaliste2_telephone',
        'avaliste2_cni',
        'statut_professionnel',
        'situation_familiale',
        'revenus_mensuels',
        'personnes_charge',
        'demande_manuscrite',
        'photocopie_cni',
        'plan_localisation',
        'justificatifs_financiers',
        'garanties',
        'status',
        'motif_rejet',
        'traite_par',
        'date_traitement',
        'date_approbation',
        'date_debours',
        'date_echeance',
        'frais_etude',
        'frais_etude_paye',
        'penalites',
        'jours_retard',
        'montant_rembourse',
        'solde_restant',
        'echeances_payees',
        'echeances_totales',
        'observations',
        'historique_status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'montant' => 'decimal:2',
        'taux_interet' => 'decimal:2',
        'montant_epargne_requis' => 'decimal:2',
        'montant_total_rembourser' => 'decimal:2',
        'montant_mensuel' => 'decimal:2',
        'revenus_mensuels' => 'decimal:2',
        'frais_etude' => 'decimal:2',
        'penalites' => 'decimal:2',
        'montant_rembourse' => 'decimal:2',
        'solde_restant' => 'decimal:2',
        'personnes_charge' => 'integer',
        'jours_retard' => 'integer',
        'echeances_payees' => 'integer',
        'echeances_totales' => 'integer',
        'frais_etude_paye' => 'boolean',
        'date_traitement' => 'datetime',
        'date_approbation' => 'datetime',
        'date_debours' => 'datetime',
        'date_echeance' => 'datetime',
        'historique_status' => 'array',
    ];

    /**
     * Constants pour les statuts
     */
    const STATUS_EN_ATTENTE = 'en_attente';
    const STATUS_EN_ETUDE = 'en_etude';
    const STATUS_APPROUVE = 'approuve';
    const STATUS_REJETE = 'rejete';
    const STATUS_DEBOURSE = 'debourse';
    const STATUS_EN_REMBOURSEMENT = 'en_remboursement';
    const STATUS_REMBOURSE = 'rembourse';
    const STATUS_EN_RETARD = 'en_retard';
    const STATUS_CONTENTIEUX = 'contentieux';

    /**
     * Constants pour les statuts professionnels
     */
    const STATUT_PROFESSIONNEL = [
        'salarie' => 'Salarié',
        'fonctionnaire' => 'Fonctionnaire',
        'independant' => 'Travailleur indépendant',
        'commercant' => 'Commerçant',
        'etudiant' => 'Étudiant',
        'retraite' => 'Retraité',
        'chomeur' => 'Sans emploi',
        'autre' => 'Autre'
    ];

    /**
     * Constants pour les situations familiales
     */
    const SITUATION_FAMILIALE = [
        'celibataire' => 'Célibataire',
        'marie' => 'Marié(e)',
        'divorce' => 'Divorcé(e)',
        'veuf' => 'Veuf/Veuve',
        'union_libre' => 'Union libre'
    ];

    /**
     * Relations
     */
    public function compte()
    {
        return $this->belongsTo(Compte::class);
    }

    public function traitePar()
    {
        return $this->belongsTo(User::class, 'traite_par');
    }

    // public function remboursements()
    // {
    //     return $this->hasMany(Remboursement::class);
    // }

    /**
     * Scopes
     */
    public function scopeEnAttente($query)
    {
        return $query->where('status', self::STATUS_EN_ATTENTE);
    }

    public function scopeApprouve($query)
    {
        return $query->where('status', self::STATUS_APPROUVE);
    }

    public function scopeEnRemboursement($query)
    {
        return $query->where('status', self::STATUS_EN_REMBOURSEMENT);
    }

    public function scopeEnRetard($query)
    {
        return $query->where('status', self::STATUS_EN_RETARD);
    }

    public function scopeParCompte($query, $compteId)
    {
        return $query->where('compte_id', $compteId);
    }

    /**
     * Accessors
     */
    public function getMontantFormatAttribute()
    {
        return number_format($this->montant, 0, ',', ' ') . ' FCFA';
    }

    public function getMontantTotalRemboursersFormatAttribute()
    {
        return number_format($this->montant_total_rembourser, 0, ',', ' ') . ' FCFA';
    }

    public function getMontantMensuelFormatAttribute()
    {
        return number_format($this->montant_mensuel, 0, ',', ' ') . ' FCFA';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            self::STATUS_EN_ATTENTE => 'En attente',
            self::STATUS_EN_ETUDE => 'En étude',
            self::STATUS_APPROUVE => 'Approuvé',
            self::STATUS_REJETE => 'Rejeté',
            self::STATUS_DEBOURSE => 'Déboursé',
            self::STATUS_EN_REMBOURSEMENT => 'En remboursement',
            self::STATUS_REMBOURSE => 'Remboursé',
            self::STATUS_EN_RETARD => 'En retard',
            self::STATUS_CONTENTIEUX => 'Contentieux'
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_EN_ATTENTE => '#ffc107',
            self::STATUS_EN_ETUDE => '#17a2b8',
            self::STATUS_APPROUVE => '#28a745',
            self::STATUS_REJETE => '#dc3545',
            self::STATUS_DEBOURSE => '#007bff',
            self::STATUS_EN_REMBOURSEMENT => '#20c997',
            self::STATUS_REMBOURSE => '#6f42c1',
            self::STATUS_EN_RETARD => '#fd7e14',
            self::STATUS_CONTENTIEUX => '#e83e8c'
        ];

        return $colors[$this->status] ?? '#6c757d';
    }

    public function getStatutProfessionnelLabelAttribute()
    {
        return self::STATUT_PROFESSIONNEL[$this->statut_professionnel] ?? $this->statut_professionnel;
    }

    public function getSituationFamilialeLabelAttribute()
    {
        return self::SITUATION_FAMILIALE[$this->situation_familiale] ?? $this->situation_familiale;
    }

    public function getPourcentageRemboursementAttribute()
    {
        if ($this->montant_total_rembourser <= 0) {
            return 0;
        }

        return round(($this->montant_rembourse / $this->montant_total_rembourser) * 100, 2);
    }

    /**
     * Méthodes métier
     */

    /**
     * Calculer les montants du crédit
     */
    public function calculerMontants()
    {
        // Montant épargne requis (30%)
        $this->montant_epargne_requis = $this->montant * 0.30;

        // Calculer les intérêts
        $interets = $this->montant * ($this->taux_interet / 100);
        
        // Montant total à rembourser
        $this->montant_total_rembourser = $this->montant + $interets;

        // Montant mensuel
        $this->montant_mensuel = $this->montant_total_rembourser / $this->duree;

        // Nombre d'échéances
        $this->echeances_totales = $this->duree;

        // Solde restant initial
        $this->solde_restant = $this->montant_total_rembourser;
    }

    /**
     * Déterminer le taux d'intérêt selon la durée
     */
    public function determinerTauxInteret()
    {
        $this->taux_interet = $this->duree <= 3 ? 10.00 : 20.00;
    }

    /**
     * Changer le statut et enregistrer l'historique
     */
    public function changerStatut($nouveauStatut, $motif = null, $utilisateurId = null)
    {
        $ancienStatut = $this->status;
        
        // Mettre à jour le statut
        $this->status = $nouveauStatut;
        $this->date_traitement = now();
        
        if ($utilisateurId) {
            $this->traite_par = $utilisateurId;
        }

        if ($motif && $nouveauStatut === self::STATUS_REJETE) {
            $this->motif_rejet = $motif;
        }

        // Dates spécifiques selon le statut
        switch ($nouveauStatut) {
            case self::STATUS_APPROUVE:
                $this->date_approbation = now();
                break;
            case self::STATUS_DEBOURSE:
                $this->date_debours = now();
                $this->date_echeance = now()->addMonths($this->duree);
                break;
        }

        // Ajouter à l'historique
        $historique = $this->historique_status ?? [];
        $historique[] = [
            'ancien_statut' => $ancienStatut,
            'nouveau_statut' => $nouveauStatut,
            'date' => now()->toDateTimeString(),
            'utilisateur_id' => $utilisateurId,
            'motif' => $motif
        ];
        $this->historique_status = $historique;

        $this->save();
    }

    /**
     * Vérifier si le crédit est en retard
     */
    public function verifierRetard()
    {
        if (!$this->date_echeance || $this->status === self::STATUS_REMBOURSE) {
            return false;
        }

        $now = now();
        $dateEcheance = Carbon::parse($this->date_echeance);

        if ($now->gt($dateEcheance)) {
            $this->jours_retard = $now->diffInDays($dateEcheance);
            
            // Calculer les pénalités (1000 FCFA par jour, max 30 jours)
            $joursFactures = min($this->jours_retard, 30);
            $this->penalites = $joursFactures * 1000;

            // Changer le statut si nécessaire
            if ($this->status === self::STATUS_EN_REMBOURSEMENT) {
                $this->status = self::STATUS_EN_RETARD;
            }

            $this->save();
            return true;
        }

        return false;
    }

    /**
     * Effectuer un remboursement
     */
    public function effectuerRemboursement($montant)
    {
        $this->montant_rembourse += $montant;
        $this->solde_restant = $this->montant_total_rembourser + $this->penalites - $this->montant_rembourse;

        // Calculer les échéances payées
        $this->echeances_payees = floor($this->montant_rembourse / $this->montant_mensuel);

        // Vérifier si entièrement remboursé
        if ($this->solde_restant <= 0) {
            $this->status = self::STATUS_REMBOURSE;
            $this->jours_retard = 0;
            $this->penalites = 0;
            $this->solde_restant = 0;
        } else {
            // Si c'était en retard et maintenant à jour
            if ($this->status === self::STATUS_EN_RETARD && $this->jours_retard === 0) {
                $this->status = self::STATUS_EN_REMBOURSEMENT;
            }
        }

        $this->save();
    }

    /**
     * Vérifier l'éligibilité du compte pour ce montant
     */
    public function verifierEligibilite()
    {
        $compte = $this->compte;
        
        if (!$compte) {
            return ['eligible' => false, 'raison' => 'Compte introuvable'];
        }

        // Vérifier le solde épargne (30% minimum)
        if ($compte->solde < $this->montant_epargne_requis) {
            return [
                'eligible' => false,
                'raison' => 'Épargne insuffisante',
                'requis' => $this->montant_epargne_requis,
                'disponible' => $compte->solde
            ];
        }

        return ['eligible' => true];
    }

    /**
     * Générer le numéro de crédit
     */
    public function genererNumeroCredit()
    {
        $annee = date('Y');
        $mois = date('m');
        $numero = str_pad($this->id, 4, '0', STR_PAD_LEFT);
        
        return "CR{$annee}{$mois}{$numero}";
    }

    /**
     * Boot method pour les événements du modèle
     */
    protected static function boot()
    {
        parent::boot();

        // Calculer automatiquement les montants avant la création
        static::creating(function ($credit) {
            $credit->determinerTauxInteret();
            $credit->calculerMontants();
        });

        // Calculer automatiquement les montants avant la mise à jour
        static::updating(function ($credit) {
            if ($credit->isDirty(['montant', 'duree'])) {
                $credit->determinerTauxInteret();
                $credit->calculerMontants();
            }
        });
    }

    /**
     * Obtenir les documents du crédit
     */
    public function getDocuments()
    {
        return [
            'demande_manuscrite' => $this->demande_manuscrite,
            'photocopie_cni' => $this->photocopie_cni,
            'plan_localisation' => $this->plan_localisation,
            'justificatifs_financiers' => $this->justificatifs_financiers,
        ];
    }

    /**
     * Vérifier si tous les documents sont présents
     */
    public function documentsComplets()
    {
        $documents = $this->getDocuments();
        
        foreach ($documents as $document) {
            if (empty($document)) {
                return false;
            }
        }
        
        return true;
    }
}