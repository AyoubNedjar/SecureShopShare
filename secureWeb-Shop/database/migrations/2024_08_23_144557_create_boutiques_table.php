<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoutiquesTable extends Migration
{
    public function up()
    {
        Schema::create('boutiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relie la boutique à l'utilisateur
            $table->string('name'); // Nom de la boutique
            $table->text('description')->nullable(); // Description optionnelle de la boutique
            $table->timestamps(); // Colonnes de timestamp pour created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('boutiques');
    }
}
