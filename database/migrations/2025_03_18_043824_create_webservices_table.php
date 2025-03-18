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
        Schema::create('webservices', function (Blueprint $table) {
            $table->id();
            $table->string('api_type');
            $table->string('api_url');
            $table->string('api_name');
            $table->text('api_description')->nullable();
            $table->json('api_payload')->nullable();
            $table->json('api_response')->nullable();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webservices');
    }
};
