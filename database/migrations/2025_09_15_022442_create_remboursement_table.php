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
        Schema::create('remboursements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('credit_id');
            $table->decimal('montant', 8, 2);
            $table->string('type');
            $table->text('notes')->nullable();
            $table->date('date_remboursement');
            $table->unsignedBigInteger('enregistre_par');
            $table->timestamps();

            $table->foreign('credit_id')->references('id')->on('credits')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('remboursements');
    }
};
