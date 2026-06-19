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
        Schema::table('discounts', function (Blueprint $table) {
            $table->timestamp('start_at')->nullable()->after('category_ids');
            $table->timestamp('expires_at')->nullable()->after('start_at');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('discounts', function (Blueprint $table) {
            $table->dropColumn('start_at');
            $table->dropColumn('expires_at');
        });
    }
};
