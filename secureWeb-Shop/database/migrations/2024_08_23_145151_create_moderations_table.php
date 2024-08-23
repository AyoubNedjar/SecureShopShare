<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModerationsTable extends Migration
{
    public function up()
    {
        Schema::create('moderations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Utilisateur qui propose la modification ou l'ajout
            $table->morphs('item'); // Colonne pour stocker l'ID et le type de l'élément à modérer (ex : boutique, article)
            $table->string('status')->default('pending'); // Statut de la modération (pending, approved, rejected)
            $table->timestamps(); // Colonnes pour created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('moderations');
    }
}