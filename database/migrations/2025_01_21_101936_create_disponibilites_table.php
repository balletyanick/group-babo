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
        Schema::create('disponibilites', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('user_id', 36);
            $table->char('client_id', 36);
            $table->char('product_id', 36);
            $table->char('contrat_id', 36);
            $table->date('date_day');
            $table->date('date_payment');
            $table->integer('amount');
            $table->integer('compter')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });

        Schema::table('disponibilites', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('contrat_id')->references('id')->on('contrats')->onDelete('cascade');
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disponibilites');
    }
};
