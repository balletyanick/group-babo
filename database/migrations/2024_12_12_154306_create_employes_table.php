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
        Schema::create('employes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('user_id', 36);
            $table->char('agence_id', 36);
            $table->string('name_doc_client');
            $table->string('numero_piece');
            $table->string('mat_employe');
            $table->string('genre');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('common');
            $table->string('neighborhood');
            $table->date('date_start_doc')->nullable();
            $table->date('date_end_doc')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });

        Schema::table('employes', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('agence_id')->references('id')->on('agences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
