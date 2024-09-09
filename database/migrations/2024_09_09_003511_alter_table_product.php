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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('color_id')->nullable()->after('brands_id');
            $table->unsignedBigInteger('size_id')->nullable()->after('color_id');
            $table->unsignedBigInteger('stock_id')->nullable()->after('size_id');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('color_id'); 
            $table->dropColumn('size_id'); 
            $table->dropColumn('stock_id'); 
        });
    }
};
