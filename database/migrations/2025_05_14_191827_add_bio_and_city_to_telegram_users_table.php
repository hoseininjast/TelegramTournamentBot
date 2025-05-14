<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('telegram_users', function (Blueprint $table) {
            $table->string('KryptoArenaID')->nullable()->after('UserName')->unique();
            $table->text('Bio')->nullable()->after('Image');
            $table->string('Country')->nullable()->after('Bio');
            $table->string('City')->nullable()->after('Country');
            $table->dropColumn(['PlatoScreenShot' , 'TonWalletAddress']);
        });

    }
};
