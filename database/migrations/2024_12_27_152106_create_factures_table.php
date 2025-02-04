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
        Schema::create('factures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('user_id', 36);
            $table->char('agence_id', 36);
            $table->char('product_id', 36);
            $table->char('contrat_id', 36);
            $table->string('chemin_file')->nullable();
            $table->date('date_day');
            $table->string('numero_facture');
            $table->timestamps(); 
        });

        Schema::table('factures', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('agence_id')->references('id')->on('agences')->onDelete('cascade');
            $table->foreign('contrat_id')->references('id')->on('contrats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
