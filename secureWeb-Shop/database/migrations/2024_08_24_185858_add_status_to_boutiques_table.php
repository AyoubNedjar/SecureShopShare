<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToBoutiquesTable extends Migration
{
    public function up()
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->string('status')->default('pending'); // Vous pouvez définir la valeur par défaut que vous souhaitez
        });
    }

    public function down()
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}