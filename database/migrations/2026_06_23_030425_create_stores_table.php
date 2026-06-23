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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();

            // Store basic information
            $table->string('store_name');
            $table->string('slug')->unique();
            $table->string('owner_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Store design/images
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();

            // Store address
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            // Store business settings
            $table->decimal('commission_rate', 8, 2)->default(0);
            $table->tinyInteger('status')->default(1);
            // 0 = pending, 1 = active, 2 = blocked

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};