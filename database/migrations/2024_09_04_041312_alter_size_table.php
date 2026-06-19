<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('size', function (Blueprint $table) {
            $table->string('status')->after('name'); // Adding a status column after the name column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('size', function (Blueprint $table) {
            $table->dropColumn('status'); // Dropping the status column if the migration is rolled back
        });
    }
};
