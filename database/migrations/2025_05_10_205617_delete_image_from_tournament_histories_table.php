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
        Schema::table('tournament_histories', function (Blueprint $table) {
            $table->dropColumn([ 'Image' , 'AwardsProof' ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournament_histories', function (Blueprint $table) {

            $table->json('AwardsProof')->after('Winners')->nullable();
            $table->string('Image')->nullable()->after('AwardsProof');

        });
    }
};
