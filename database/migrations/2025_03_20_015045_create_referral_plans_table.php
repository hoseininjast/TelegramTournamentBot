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
        Schema::create('referral_plans', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->text('Description');
            $table->text('Image');
            $table->integer('Level')->default(1);
            $table->integer('Count');
            $table->float('Award');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_plans');
    }
};
