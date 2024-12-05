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
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->integer('remaning_quantity')->default(0);   // Total quantity added
            $table->integer('sold_quantity')->default(0); // Total sold quantity
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->dropColumn('remaning_quantity'); // Dropping the status column if the migration is rolled back
            $table->dropColumn('sold_quantity'); // Dropping the status column if the migration is rolled back

        });
    }
};