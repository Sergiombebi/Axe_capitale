<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImportExport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom_marchandise',
        'categorie',
        'description_marchandise',
        'photos_marchandise',
        'quantite_souhaitee',
        'unite_mesure',
        'budget_approximatif',
        'mode_expedition',
        'exigences_particulieres',
        'lieu_livraison',
        'adresse_livraison',
        'ville_livraison',
        'telephone_livraison',
        'urgence',
        'usage_prevu',
        'commentaires',
        'accepte_contact',
        'accepte_conditions',
        'status',
        'prix_unitaire_propose',
        'prix_total_marchandise',
        'poids_estime_kg',
        'frais_douane_estimes',
        'commission_axe_capital',
        'details_devis',
        'date_devis',
        'quantite_finale',
        'poids_final_kg',
        'montant_paye_marchandise',
        'date_paiement_marchandise',
        'mode_expedition_final',
        'numero_commande_chine',
        'date_achat_chine',
        'date_expedition',
        'date_arrivee_prevue',
        'date_arrivee_effective',
        'numero_suivi',
        'informations_suivi',
        'frais_douane_reels',
        'commission_finale',
        'frais_livraison',
        'frais_douane_payes',
        'commission_payee',
        'date_paiement_frais',
        'date_livraison',
        'notes_livraison',
        'traite_par',
        'date_traitement',
        'observations',
        'historique_status'
    ];

    protected $casts = [
        'photos_marchandise' => 'array',
        'budget_approximatif' => 'decimal:2',
        'prix_unitaire_propose' => 'decimal:2',
        'prix_total_marchandise' => 'decimal:2',
        'poids_estime_kg' => 'decimal:2',
        'frais_douane_estimes' => 'decimal:2',
        'commission_axe_capital' => 'decimal:2',
        'poids_final_kg' => 'decimal:2',
        'montant_paye_marchandise' => 'decimal:2',
        'frais_douane_reels' => 'decimal:2',
        'commission_finale' => 'decimal:2',
        'frais_livraison' => 'decimal:2',
        'accepte_contact' => 'boolean',
        'accepte_conditions' => 'boolean',
        'frais_douane_payes' => 'boolean',
        'commission_payee' => 'boolean',
        'date_devis' => 'datetime',
        'date_paiement_marchandise' => 'datetime',
        'date_achat_chine' => 'datetime',
        'date_expedition' => 'datetime',
        'date_arrivee_prevue' => 'datetime',
        'date_arrivee_effective' => 'datetime',
        'date_paiement_frais' => 'datetime',
        'date_livraison' => 'datetime',
        'date_traitement' => 'datetime',
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
     * Relation avec l'utilisateur qui traite la demande
     */
    public function traitePar()
    {
        return $this->belongsTo(User::class, 'traite_par');
    }

    /**
     * Calculer les frais de douane estimés
     */
    public function calculerFraisDouane(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->poids_estime_kg ? $this->poids_estime_kg * 10000 : null
        );
    }

    /**
     * Calculer la commission AXE CAPITAL
     */
    public function calculerCommission(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->poids_estime_kg ? $this->poids_estime_kg * 1000 : null
        );
    }

    /**
     * Calculer le coût total estimé
     */
    public function coutTotalEstime(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->prix_total_marchandise ?? 0) + 
                         ($this->frais_douane_estimes ?? 0) + 
                         ($this->commission_axe_capital ?? 0) + 
                         ($this->frais_livraison ?? 0)
        );
    }

    /**
     * Générer le numéro de référence
     */
    public function numeroReference(): Attribute
    {
        return Attribute::make(
            get: fn () => 'IE-' . str_pad($this->id, 6, '0', STR_PAD_LEFT)
        );
    }

}
