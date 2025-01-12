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
        Schema::create('tournament_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('TournamentID');
            $table->foreign('TournamentID')->references('id')->on('tournaments')->cascadeOnDelete();
            $table->json('Winners');
            $table->json('AwardsProof')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_histories');
    }
};
