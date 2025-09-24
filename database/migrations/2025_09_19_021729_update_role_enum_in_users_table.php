<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users 
            MODIFY role ENUM(
                'user', 
                'admin', 
                'gestionnaire_compte', 
                'gestionnaire_credit', 
                'gest-import', 
                'gest-financement'
            ) NOT NULL DEFAULT 'user'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE users 
            MODIFY role ENUM(
                'user', 
                'admin', 
                'gestionnaire_compte', 
                'gestionnaire_credit'
            ) NOT NULL DEFAULT 'user'
        ");
    }
};

