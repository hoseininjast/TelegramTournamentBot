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
        Schema::create('telegram_users', function (Blueprint $table) {
            $table->id();
            $table->string('TelegramUserID');
            $table->string('TelegramChatID');
            $table->string('FirstName')->nullable();
            $table->string('LastName')->nullable();
            $table->string('UserName')->nullable();
            $table->string('PlatoID')->nullable();
            $table->text('PlatoScreenShot')->nullable();
            $table->enum('Status' , [ 'Pending' , 'Verified'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_users');
    }
};
