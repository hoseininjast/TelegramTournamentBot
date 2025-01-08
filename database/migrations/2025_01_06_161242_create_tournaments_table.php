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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->string('Description');
            $table->integer('PlayerCount');
            $table->integer('TotalStage');
            $table->integer('LastStage')->default(0);
            $table->enum('Type' , [ 'Knockout' , 'WorldCup' , 'League' ]);
            $table->enum('Mode' , [ 'Free' , 'Paid' ]);
            $table->float('Price')->default(0);
            $table->integer('Time');
            $table->dateTime('Start');
            $table->dateTime('End');
            $table->unsignedBigInteger('GameID');
            $table->foreign('GameID')->references('id')->on('games')->cascadeOnDelete();
            $table->integer('Winners');
            $table->json('Awards');
            $table->enum('Status' , [ 'Pending' , 'Running' , 'Finished' ])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
