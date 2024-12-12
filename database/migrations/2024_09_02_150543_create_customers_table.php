<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.  
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) { 
            $table->uuid('id')->primary();
            $table->char('user_id', 36);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('genre');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('neighborhood');
            $table->string('common');
            $table->string('numero_cni');
            $table->date('date_start_cni')->nullable();
            $table->date('date_end_cni')->nullable();
            $table->string('etat_matrimonial');
            $table->string('work');
            $table->string('name_doc_client');
            $table->string('email');
            $table->string('phone');
            $table->string('note_second')->nullable();
            $table->string('note_first')->nullable();

            $table->string('first_name_death');
            $table->string('last_name_death');
            $table->string('numero_piece_death');
            $table->string('name_doc');
            $table->date('date_start_doc_death')->nullable();;
            $table->date('date_end_doc_death')->nullable();;
            $table->date('date_of_birth_death');
            $table->string('place_of_birth_death');
            $table->string('place_death');
            $table->string('phone_number_death')->nullable();
            $table->string('genre_death');

            $table->timestamps();
        }); 

        Schema::table('customers', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
