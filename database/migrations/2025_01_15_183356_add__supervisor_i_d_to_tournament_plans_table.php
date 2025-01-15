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
            $table->unsignedBigInteger('SupervisorID')->nullable()->after('WinnerID');
            $table->foreign('SupervisorID')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournament_plans', function (Blueprint $table) {
            $table->dropForeign(['SupervisorID']);
            $table->dropColumn(['SupervisorID']);
        });
    }
};
