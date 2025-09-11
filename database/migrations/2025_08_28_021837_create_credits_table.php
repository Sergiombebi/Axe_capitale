<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            
            // Liaison avec le compte (OBLIGATOIRE)
            $table->foreignId('compte_id')->constrained('comptes')->onDelete('cascade');
            
            // Détails du crédit demandé
            $table->decimal('montant', 15, 2); // Montant souhaité en FCFA
            $table->integer('duree'); // Durée en mois
            $table->decimal('taux_interet', 5, 2); // Taux d'intérêt applicable (10% ou 20%)
            $table->text('objet_credit'); // Description de l'utilisation du crédit
            
            // Montants calculés
            $table->decimal('montant_epargne_requis', 15, 2); // 30% du montant demandé
            $table->decimal('montant_total_rembourser', 15, 2); // Montant + intérêts
            $table->decimal('montant_mensuel', 15, 2); // Montant à rembourser par mois
            
            // Avalistes (2 requis)
            $table->string('avaliste1_nom');
            $table->string('avaliste1_telephone');
            $table->string('avaliste1_cni');
            $table->string('avaliste2_nom');
            $table->string('avaliste2_telephone');
            $table->string('avaliste2_cni');
            
            // Situation professionnelle et familiale
            $table->enum('statut_professionnel', [
                'salarie', 'fonctionnaire', 'independant', 'commercant', 
                'etudiant', 'retraite', 'chomeur', 'autre'
            ]);
            $table->enum('situation_familiale', [
                'celibataire', 'marie', 'divorce', 'veuf', 'union_libre'
            ]);
            $table->decimal('revenus_mensuels', 15, 2);
            $table->integer('personnes_charge')->default(0);
            
            // Documents uploadés
            $table->string('demande_manuscrite'); // Chemin vers le fichier
            $table->string('photocopie_cni'); // Chemin vers le fichier
            $table->string('plan_localisation'); // Chemin vers le fichier
            $table->string('justificatifs_financiers'); // Chemin vers le fichier
            
            // Garanties proposées
            $table->text('garanties'); // Description des garanties
            
            // Statut de la demande
            $table->enum('status', [
                'en_attente',        // Demande soumise, en attente d'examen
                'en_etude',          // Dossier en cours d'étude
                'approuve',          // Crédit approuvé
                'rejete',            // Demande rejetée
                'debourse',          // Montant versé au client
                'en_remboursement',  // Crédit en cours de remboursement
                'rembourse',         // Crédit entièrement remboursé
                'en_retard',         // Retard de paiement
                'contentieux'        // En procédure de recouvrement
            ])->default('en_attente');
            
            // Informations sur le traitement
            $table->text('motif_rejet')->nullable(); // Si rejeté, pourquoi
            $table->foreignId('traite_par')->nullable()->constrained('users'); // Gestionnaire qui a traité
            $table->timestamp('date_traitement')->nullable(); // Date de traitement
            $table->timestamp('date_approbation')->nullable(); // Date d'approbation
            $table->timestamp('date_debours')->nullable(); // Date de versement
            $table->timestamp('date_echeance')->nullable(); // Date limite de remboursement
            
            // Frais et pénalités
            $table->decimal('frais_etude', 10, 2)->default(1000.00); // Frais d'étude (1000 FCFA)
            $table->boolean('frais_etude_paye')->default(false); // Si les frais ont été payés
            $table->decimal('penalites', 15, 2)->default(0.00); // Pénalités accumulées
            $table->integer('jours_retard')->default(0); // Nombre de jours de retard
            
            // Remboursement
            $table->decimal('montant_rembourse', 15, 2)->default(0.00); // Montant déjà remboursé
            $table->decimal('solde_restant', 15, 2)->default(0.00); // Solde à rembourser
            $table->integer('echeances_payees')->default(0); // Nombre d'échéances payées
            $table->integer('echeances_totales')->default(0); // Nombre total d'échéances
            
            // Métadonnées
            $table->text('observations')->nullable(); // Observations du gestionnaire
            $table->json('historique_status')->nullable(); // Historique des changements de statut
            
            // Index pour optimiser les requêtes
            $table->index(['compte_id', 'status']);
            $table->index('status');
            $table->index('date_echeance');
            $table->index(['status', 'date_echeance']); // Pour les crédits en retard
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};