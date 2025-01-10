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
        Schema::table('tournament_plans', function (Blueprint $table) {
            $table->string('Group')->after('Stage');
            $table->integer('Player1Score')->after('Player1ID')->nullable();
            $table->integer('Player2Score')->after('Player2ID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournament_plans', function (Blueprint $table) {
            $table->dropColumn(['Group' ,'Player1Score','Player2Score']);
        });
    }
};
