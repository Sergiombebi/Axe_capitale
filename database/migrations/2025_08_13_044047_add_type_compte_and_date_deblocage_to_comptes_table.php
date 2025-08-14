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
        Schema::table('comptes', function (Blueprint $table) {
            // Type de compte
            $table->enum('type_compte', ['epargne', 'bloque', 'terme', 'collectif'])
                  ->default('epargne')
                  ->after('user_id');
            
            // Solde du compte (pour tous les types)
            $table->decimal('solde', 15, 2)->default(0.00)->after('type_compte');
            
            // Date de déblocage
            $table->date('date_deblocage')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comptes', function (Blueprint $table) {
            $table->dropColumn(['type_compte', 'solde', 'date_deblocage']);
        });
    }
};