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
        Schema::create('demandes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->date('date_d');
            $table->string('adr_int');
            $table->double('total_prix')->nullable();

           
            

            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')
             ->references('id')
             ->on('users')->onDelete('cascade');
             
             $table->string('type_demande');

            $table->unsignedBigInteger('id_oep')->nullable();
           $table->foreign('id_oep')
            ->references('id')
            ->on('oeps');
            
            $table->unsignedBigInteger('id_contrat')->nullable();
           $table->foreign('id_contrat')
            ->references('id')
            ->on('contrats');

            $table->string('pdf_file')->nullable();

            $table->string('etat')->default('demande enregistrer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
