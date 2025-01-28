<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('UserID');
            $table->foreign('UserID')->references('id')->on('telegram_users')->cascadeOnDelete();
            $table->string('Description')->nullable();
            $table->float('Amount' , 15 ,8);
            $table->enum('Type' , ['In' ,'Out', 'Swap' , 'Transfer'])->default('In');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_payment_histories');
    }
};
