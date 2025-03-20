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
        Schema::create('referral_plan_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ReferralPlanID');
            $table->foreign('ReferralPlanID')->references('id')->on('referral_plans')->cascadeOnDelete();
            $table->unsignedBigInteger('UserID');
            $table->foreign('UserID')->references('id')->on('telegram_users')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_plan_histories');
    }
};
