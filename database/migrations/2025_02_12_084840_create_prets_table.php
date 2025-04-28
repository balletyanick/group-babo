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
        Schema::create('prets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('contrat_id', 36);
            $table->integer('amount');
            $table->integer('duration');
            $table->date('date_day');
            $table->integer('status');
            $table->string('note')->nullable();
            $table->timestamps(); 
        });

        
        Schema::table('prets', function (Blueprint $table) {
            $table->foreign('contrat_id')->references('id')->on('contrats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prets');
    }
};
