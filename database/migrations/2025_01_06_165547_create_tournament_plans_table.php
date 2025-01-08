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
        Schema::create('tournament_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('TournamentID');
            $table->foreign('TournamentID')->references('id')->on('tournaments')->cascadeOnDelete();
            $table->integer('Stage');
            $table->unsignedBigInteger('Player1ID');
            $table->foreign('Player1ID')->references('id')->on('telegram_users')->cascadeOnDelete();
            $table->unsignedBigInteger('Player2ID');
            $table->foreign('Player2ID')->references('id')->on('telegram_users')->cascadeOnDelete();
            $table->dateTime('Time');
            $table->unsignedBigInteger('WinnerID')->nullable();
            $table->foreign('WinnerID')->references('id')->on('telegram_users')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_plans');
    }
};
