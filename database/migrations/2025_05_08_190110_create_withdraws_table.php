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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->string('WithdrawID');
            $table->integer('Amount' );
            $table->string('PayingAddress');
            $table->string('UserTransactionHash')->nullable();
            $table->enum('Status' , [ 'Pending' ,'Paid', 'Canceled'])->default('Pending');
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
        Schema::dropIfExists('withdraws');
    }
};
