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
        Schema::table('orders', function (Blueprint $table) {
            $table->double('coupon_discount_amount', 10, 2)
                ->nullable()
                ->after('coupon_code');

            // Total discount applied from product (regular discount)
            $table->double('product_discount_amount', 10, 2)
                ->nullable()
                ->after('discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('coupon_discount_amount');
            $table->dropColumn('product_discount_amount');
        });
    }
};
