<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBoutiquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->string('name', 255)->change(); // Augmente la longueur à 255 caractères
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->string('name', 50)->change(); // Réduit la longueur à 50 caractères
        });
    }
}
