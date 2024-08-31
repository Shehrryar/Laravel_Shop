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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('value', 8, 2); // Percentage or fixed value
            $table->enum('type', ['percentage', 'fixed']);
            $table->json('product_ids')->nullable(); // Store product IDs as JSON array
            $table->json('category_ids')->nullable(); // Store category IDs as JSON array
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
