<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArticlesColumns extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Changer `title` et `price` en `text` pour stocker des données cryptées
            $table->text('title')->change();
            $table->longText('description')->change(); // `description` est déjà en `text`, donc pas de changement nécessaire ici.
            $table->text('price')->change(); // Changer `price` en `text`
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Revenir aux types originaux si nécessaire
            $table->string('title', 255)->change();
            $table->text('description')->change();
            $table->decimal('price', 8, 2)->change();
        });
    }
}
