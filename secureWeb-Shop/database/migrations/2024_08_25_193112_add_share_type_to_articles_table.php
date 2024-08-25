<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->enum('share_type', ['public', 'private'])->default('public');
            $table->unsignedBigInteger('shared_with_user_id')->nullable();
            
            // Add a foreign key constraint if needed
            $table->foreign('shared_with_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['shared_with_user_id']);
            $table->dropColumn(['share_type', 'shared_with_user_id']);
        });
    }
};

