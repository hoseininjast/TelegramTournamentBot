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
        Schema::table('telegram_users', function (Blueprint $table) {
            $table->unsignedBigInteger('ReferralID')->nullable()->after('TelegramChatID');
            $table->foreign('ReferralID')->references('id')->on('telegram_users')->cascadeOnDelete();
            $table->float('Charge')->default(0)->after('WalletAddress');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('telegram_users', function (Blueprint $table) {
            //
        });
    }
};
