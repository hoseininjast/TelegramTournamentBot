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
            $table->enum('Status' , ['Pending' , 'Finished'])->default('Pending')->after('WinnerID');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournament_plans', function (Blueprint $table) {
            $table->dropColumn(['Status']);
        });
    }
};
