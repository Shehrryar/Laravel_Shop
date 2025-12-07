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
            // Add new columns
            $table->string('Shipping_status')->nullable()->after('status');
            $table->string('payment_method')->nullable()->after('Shipping_status');
            $table->string('payment_currency', 10)->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Remove added columns
            $table->dropColumn('Shipping_status');
            $table->dropColumn('payment_method');
            $table->dropColumn('payment_currency');
        });
    }

};
