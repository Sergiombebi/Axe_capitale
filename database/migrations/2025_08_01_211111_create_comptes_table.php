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
        Schema::create('comptes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Informations d'identité
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('cni')->unique();
            $table->string('photo_cni'); // Stockage du chemin de l'image
            $table->enum('sexe', ['Homme', 'Femme']);
            
            // Coordonnées
            $table->string('telephone');
            $table->string('pays');
            $table->string('ville');
            $table->string('quartier');
            $table->string('lieudit')->nullable();
            
            // Contact d'urgence
            $table->string('contact_urgence');
            $table->string('tel_urgence');
            $table->date('fait_le');
            $table->string('fait_a');
            
            // Informations du compte
            $table->enum('status', ['inactif', 'actif'])->default('inactif');
           
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comptes');
    }
};