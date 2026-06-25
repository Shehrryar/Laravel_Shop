<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('brands') && !Schema::hasColumn('brands', 'store_id')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id')->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('brands') && Schema::hasColumn('brands', 'store_id')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->dropColumn('store_id');
            });
        }
    }
};