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
        Schema::table('size', function (Blueprint $table) {
            $table->string('price')->after('status'); // Adding a status column after the name column
            $table->string('product_id')->after('price'); // Adding a status column after the name column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('size', function (Blueprint $table) {
            $table->dropColumn('price'); // Dropping the status column if the migration is rolled back
            $table->dropColumn('product_id'); // Dropping the status column if the migration is rolled back
        });
    }
};
