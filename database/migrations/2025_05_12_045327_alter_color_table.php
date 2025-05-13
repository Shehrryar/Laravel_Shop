<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('color', function (Blueprint $table) {
            $table->string('size_id')->nullable();   // Total quantity added
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('color', callback: function (Blueprint $table) {
            $table->dropColumn('size_id'); // Dropping the status column if the migration is rolled back
        });
    }
};