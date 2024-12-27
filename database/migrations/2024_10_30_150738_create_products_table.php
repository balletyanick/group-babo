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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('libelle');
            $table->string('description')->nullable();
            $table->integer('duration_contrat'); 
            $table->integer('frais_gestion'); 
            $table->integer('amout_global'); 
            $table->integer('pay_mensuel'); 
            $table->integer('pay_day'); 
            $table->string('note')->nullable();
            $table->string('type');
            $table->string('moto_restitue');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
