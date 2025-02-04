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
        Schema::create('contrats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('user_id', 36);
            $table->char('agence_id', 36);
            $table->char('product_id', 36);
            $table->string('numero_contrat');
            $table->date('date_day');
            $table->date('date_firt_payment');
            $table->date('date_end_payment');
            $table->string('type_contrat');
            $table->string('chemin_file')->nullable();
            $table->string('chemin_file_promo')->nullable();
            $table->string('resiliation_file')->nullable();
            $table->string('method_versement');
            $table->string('status');
            $table->integer('quantite');
            $table->string('score_one')->nullable();
            $table->string('score')->nullable();
            $table->string('note')->nullable();
            $table->string('premier_pay')->nullable();
            $table->timestamps();
        });

        Schema::table('contrats', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('agence_id')->references('id')->on('agences')->onDelete('cascade');
        });
    }
   
    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
