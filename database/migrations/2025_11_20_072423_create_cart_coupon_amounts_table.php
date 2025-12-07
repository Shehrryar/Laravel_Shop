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
        Schema::create('cart_coupon_amounts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cart_id');

            // total before coupon
            $table->decimal('original_total', 10, 2);

            // total after coupon applied
            $table->decimal('discounted_total', 10, 2);

            // coupon discount amount
            $table->decimal('coupon_amount', 10, 2);

            $table->string('coupon_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_coupon_amounts');
    }
};
