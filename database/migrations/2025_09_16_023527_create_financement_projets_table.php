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
        Schema::create('financement_projets', function (Blueprint $table) {
            $table->id();
            
            // Liaison avec le compte
            $table->foreignId('compte_id')->constrained('comptes')->onDelete('cascade');
            
            // Informations sur le projet
            $table->string('nom_projet');
            $table->enum('secteur_activite', [
                'agriculture', 'commerce', 'artisanat', 'services', 
                'technologie', 'tourisme', 'education', 'sante', 'transport', 'autre'
            ]);
            $table->text('description_projet');
            $table->decimal('montant_total_projet', 15, 2);
            $table->decimal('montant_financement_demande', 15, 2);
            
            // Apport personnel
            $table->decimal('apport_personnel', 15, 2);
            $table->integer('duree_remboursement'); // en mois
            $table->text('nature_apport');
            
            // Documents
            $table->string('business_plan'); // Chemin vers le fichier
            $table->string('photocopie_cni'); // Chemin vers le fichier
            $table->string('plan_localisation'); // Chemin vers le fichier
            $table->string('attestation_niu'); // Chemin vers le fichier
            
            // Informations complémentaires
            $table->enum('experience_domaine', [
                'aucune', 'moins_1_an', '1_3_ans', '3_5_ans', 'plus_5_ans'
            ])->nullable();
            $table->integer('employes_prevus')->nullable();
            $table->text('objectifs_court_terme')->nullable();
            $table->text('objectifs_long_terme')->nullable();
            
            // Acceptation des conditions
            $table->boolean('accepte_frais_etude')->default(false);
            $table->boolean('accepte_conditions')->default(false);
            
            // Frais et paiements
            $table->decimal('frais_etude', 10, 2)->default(5000.00);
            $table->boolean('frais_etude_paye')->default(false);
            $table->timestamp('date_paiement_frais')->nullable();
            
            // Statut de la demande
            $table->enum('status', [
                'en_attente',           // Demande soumise
                'frais_en_attente',     // En attente du paiement des frais
                'en_etude',             // Business plan en cours d'analyse
                'approuve',             // Projet approuvé
                'rejete',               // Projet rejeté
                'finance',              // Financement accordé
                'en_cours',             // Projet en cours d'exécution
                'termine',              // Projet terminé
                'suspendu'              // Projet suspendu
            ])->default('frais_en_attente');
            
            // Informations sur le traitement
            $table->text('motif_rejet')->nullable();
            $table->text('observations')->nullable();
            $table->foreignId('traite_par')->nullable()->constrained('users');
            $table->timestamp('date_traitement')->nullable();
            $table->timestamp('date_approbation')->nullable();
            
            // Financement accordé
            $table->decimal('montant_finance', 15, 2)->nullable();
            $table->decimal('ratio_remboursement', 5, 2)->nullable(); // Pourcentage
            $table->integer('duree_remboursement_accordee')->nullable();
            $table->text('conditions_remboursement')->nullable();
            
            // Suivi du projet
            $table->decimal('montant_rembourse', 15, 2)->default(0.00);
            $table->decimal('solde_restant', 15, 2)->default(0.00);
            $table->timestamp('date_debut_remboursement')->nullable();
            $table->timestamp('date_fin_remboursement')->nullable();
            
            // Historique
            $table->json('historique_status')->nullable();
            
            // Index
            $table->index(['compte_id', 'status']);
            $table->index('status');
            $table->index('secteur_activite');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financement_projets');
    }

};
