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
        Schema::create('contrats_employes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('employe_id', 36);
            $table->string('poste');
            $table->date('date_start')->nullable();
            $table->integer('salaire');
            $table->integer('time_contrat');
            $table->integer('status');
            $table->string('note')->nullable();
            $table->timestamps(); 
        });

        Schema::table('contrats_employes', function (Blueprint $table) {
            $table->foreign('employe_id')->references('id')->on('employes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats_employes');
    }
};
