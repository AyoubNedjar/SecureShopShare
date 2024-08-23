<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->onDelete('cascade'); // Relie l'article à une boutique
            $table->string('title'); // Nom de l'article
            $table->text('description')->nullable(); // Description optionnelle de l'article
            $table->decimal('price', 8, 2); // Prix de l'article (ex : 9999.99)
            $table->timestamps(); // Colonnes de timestamp pour created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}