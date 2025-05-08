<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_payment_histories', function (Blueprint $table) {
            $table->enum('Currency' , ['KAC' , 'KAT' , 'USDT' , 'Polygon'])->after('Amount')->default('KAC');
        });
    }
};
