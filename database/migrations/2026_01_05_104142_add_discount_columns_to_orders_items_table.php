<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders_items', function (Blueprint $table) {
            $table->double('discounted_price', 10, 2)->nullable()->after('price');
            $table->double('discounted_value', 10, 2)->nullable()->after('discounted_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders_items', function (Blueprint $table) {
            $table->dropColumn(['discounted_price', 'discounted_value']);
        });
    }
};
