<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('phone')->nullable()->after('name');
        $table->string('verification_code')->nullable();
        $table->enum('role', ['user', 'admin', 'gestionnaire_compte', 'gestionnaire_credit'])->default('user');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['phone', 'verification_code', 'role']);
    });
}
};
