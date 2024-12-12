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
        Schema::create('agences_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('agence_id', 36);
            $table->char('user_id', 36);
            $table->string('note')->nullable();
            $table->timestamps();
        });

        Schema::table('agences_user', function (Blueprint $table) {
            $table->foreign('agence_id')->references('id')->on('agences')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agences_user');
    }
};
