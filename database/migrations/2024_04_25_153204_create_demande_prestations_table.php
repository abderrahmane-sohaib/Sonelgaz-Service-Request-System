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
        Schema::create('demande_prestations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            // Définir les clés étrangères
            $table->unsignedBigInteger('id_pres');
            $table->foreign('id_pres')
            ->references('id')
            ->on('prestations');
            
            
            $table->unsignedBigInteger('id_demande');
            $table->foreign('id_demande')
                  ->references('id')
                  ->on('demandes');
                  $table->integer('quantite');
        
            // Définir la clé primaire composite
            // $table->primary(['id_pre', 'id_demande']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_prestations');
    }
};
