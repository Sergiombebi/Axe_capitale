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
        Schema::create('import_exports', function (Blueprint $table) {
            $table->id();
            
            // Liaison avec l'etulisateur
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Informations sur la marchandise
            $table->string('nom_marchandise');
            $table->enum('categorie', [
                'electronique', 'vetements', 'chaussures', 'maroquinerie', 
                'bijoux', 'cosmetique', 'jouets', 'maison', 'sport', 'automobile', 'autre'
            ]);
            $table->text('description_marchandise');
            $table->json('photos_marchandise'); // Stockage des chemins des photos
            
            // Quantité et préférences
            $table->integer('quantite_souhaitee');
            $table->enum('unite_mesure', ['pieces', 'paires', 'lots', 'cartons', 'kg', 'metres']);
            $table->decimal('budget_approximatif', 15, 2)->nullable();
            $table->enum('mode_expedition', ['bateau', 'avion'])->nullable();
            $table->text('exigences_particulieres')->nullable();
            
            // Informations de livraison
            $table->enum('lieu_livraison', ['bureau', 'domicile', 'point_relais']);
            $table->text('adresse_livraison')->nullable();
            $table->string('ville_livraison');
            $table->string('telephone_livraison');
            
            // Informations complémentaires
            $table->enum('urgence', ['normale', 'rapide', 'tres_rapide'])->default('normale');
            $table->enum('usage_prevu', ['personnel', 'revente', 'cadeau', 'professionnel'])->nullable();
            $table->text('commentaires')->nullable();
            
            // Acceptation des conditions
            $table->boolean('accepte_contact')->default(false);
            $table->boolean('accepte_conditions')->default(false);
            
            // Statut de la demande
            $table->enum('status', [
                'en_attente',          // Demande reçue, en attente de traitement
                'recherche_en_cours',  // Recherche du produit chez les fournisseurs
                'devis_envoye',        // Devis envoyé au client
                'attente_confirmation', // En attente de confirmation du client
                'commande_confirmee',   // Client a confirmé la commande
                'paiement_recu',       // Paiement de la marchandise reçu
                'achat_en_cours',      // Achat en cours en Chine
                'expedition',          // Marchandise expédiée
                'en_transit',          // En transit vers le Cameroun
                'arrivee',             // Marchandise arrivée au port/aéroport
                'dedouanement',        // En cours de dédouanement
                'pret_livraison',      // Prêt pour livraison/récupération
                'livre',               // Livré au client
                'annule',              // Commande annulée
                'probleme'             // Problème rencontré
            ])->default('en_attente');
            
            // Informations sur le devis
            $table->decimal('prix_unitaire_propose', 15, 2)->nullable();
            $table->decimal('prix_total_marchandise', 15, 2)->nullable();
            $table->decimal('poids_estime_kg', 10, 2)->nullable();
            $table->decimal('frais_douane_estimes', 15, 2)->nullable(); // 10000 * poids
            $table->decimal('commission_axe_capital', 15, 2)->nullable(); // 1000 * poids
            $table->text('details_devis')->nullable();
            $table->timestamp('date_devis')->nullable();
            
            // Informations sur la commande confirmée
            $table->integer('quantite_finale')->nullable();
            $table->decimal('poids_final_kg', 10, 2)->nullable();
            $table->decimal('montant_paye_marchandise', 15, 2)->nullable();
            $table->timestamp('date_paiement_marchandise')->nullable();
            $table->enum('mode_expedition_final', ['bateau', 'avion'])->nullable();
            
            // Suivi de l'expédition
            $table->string('numero_commande_chine')->nullable();
            $table->timestamp('date_achat_chine')->nullable();
            $table->timestamp('date_expedition')->nullable();
            $table->timestamp('date_arrivee_prevue')->nullable();
            $table->timestamp('date_arrivee_effective')->nullable();
            $table->string('numero_suivi')->nullable();
            $table->text('informations_suivi')->nullable();
            
            // Dédouanement et frais finaux
            $table->decimal('frais_douane_reels', 15, 2)->nullable();
            $table->decimal('commission_finale', 15, 2)->nullable();
            $table->decimal('frais_livraison', 15, 2)->nullable();
            $table->boolean('frais_douane_payes')->default(false);
            $table->boolean('commission_payee')->default(false);
            $table->timestamp('date_paiement_frais')->nullable();
            
            // Livraison finale
            $table->timestamp('date_livraison')->nullable();
            $table->text('notes_livraison')->nullable();
            
            // Traitement et suivi
            $table->foreignId('traite_par')->nullable()->constrained('users');
            $table->timestamp('date_traitement')->nullable();
            $table->text('observations')->nullable();
            $table->json('historique_status')->nullable();
            
            // Index pour optimiser les requêtes
            $table->index('status');
            $table->index('categorie');
            $table->index('mode_expedition');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('import_exports');
    }
};
