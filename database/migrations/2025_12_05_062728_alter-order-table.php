<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Change ENUM to VARCHAR
            $table->string('payment_status', 50)->change();
            $table->string('status', 50)->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert back to ENUM if needed
            $table->enum('payment_status', ['paid', 'not paid'])->change();
            $table->enum('status', ['pending', 'shipped', 'delivered'])->change();
        });
    }
};
