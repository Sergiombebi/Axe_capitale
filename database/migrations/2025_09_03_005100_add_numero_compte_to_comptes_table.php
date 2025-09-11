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
            if (!Schema::hasColumn('comptes', 'numero_compte')) {
                $table->string('numero_compte')->nullable()->after('id');
            }
            if (!Schema::hasColumn('comptes', 'code_secret')) {
                $table->string('code_secret')->nullable()->after('numero_compte');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comptes', function (Blueprint $table) {
            if (Schema::hasColumn('comptes', 'numero_compte')) {
                $table->dropColumn('numero_compte');
            }
            if (Schema::hasColumn('comptes', 'code_secret')) {
                $table->dropColumn('code_secret');
            }
        });
    }
};
