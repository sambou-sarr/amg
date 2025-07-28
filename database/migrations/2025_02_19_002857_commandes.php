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
        Schema::create('commandes',function(Blueprint $table){
            $table->id();
            $table->string('email')->nullable(); 
            $table->string('nom');
            $table->string('adresse');
            $table->integer('telephone');
            $table->enum('statut', ['en_attente', 'en_cours', 'livree', 'annulee'])->default('en_attente');
            $table->integer('id_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
