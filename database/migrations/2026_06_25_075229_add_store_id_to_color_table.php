<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('color') && !Schema::hasColumn('color', 'store_id')) {
            Schema::table('color', function (Blueprint $table) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id')->index();
            });
        }

        if (
            Schema::hasTable('color') &&
            Schema::hasTable('products') &&
            Schema::hasColumn('color', 'store_id') &&
            Schema::hasColumn('color', 'product_id') &&
            Schema::hasColumn('products', 'store_id')
        ) {
            DB::statement("
                UPDATE color
                INNER JOIN products ON products.id = color.product_id
                SET color.store_id = products.store_id
                WHERE color.store_id IS NULL
            ");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('color') && Schema::hasColumn('color', 'store_id')) {
            Schema::table('color', function (Blueprint $table) {
                $table->dropColumn('store_id');
            });
        }
    }
};