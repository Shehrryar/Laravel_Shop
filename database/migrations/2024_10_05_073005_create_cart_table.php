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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();                           // Auto-incrementing ID
            $table->unsignedBigInteger('product_id'); // ID of the product
            $table->unsignedBigInteger('size_id'); // ID of the product
            $table->unsignedBigInteger('color_id'); // ID of the product
            $table->unsignedBigInteger('user_id'); // ID of the product
            $table->unsignedBigInteger('product_attribute_id'); // ID of the product attribute
            $table->string('title');                 // Product title
            $table->integer('quantity')->default(1); // Quantity (default is 1)
            $table->decimal('price', 10, 2);         // Price of the product
            $table->decimal('discounted_price', 10, 2);         // Price of the product
            $table->string('discounted_value');         // Price of the product
            $table->string('product_image')->nullable(); // Product image (nullable in case there’s no image)
            $table->json(column: 'additional_attributes')->nullable(); // Additional attributes as JSON array
            $table->timestamps();                    // Created_at and updated_at
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};