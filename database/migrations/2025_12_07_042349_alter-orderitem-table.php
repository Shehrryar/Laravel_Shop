<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders_items', function (Blueprint $table) {
            $table->json(column: 'additional_attributes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders_items', function (Blueprint $table) {
            $table->string('product_attributes')->nullable()->after('product_id');

        });
    }
};
