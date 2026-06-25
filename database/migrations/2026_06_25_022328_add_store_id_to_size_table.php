<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('size') && !Schema::hasColumn('size', 'store_id')) {
            Schema::table('size', function (Blueprint $table) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id')->index();
            });
        }

        // Fill old size records with product store_id
        if (
            Schema::hasTable('size') &&
            Schema::hasTable('products') &&
            Schema::hasColumn('size', 'store_id') &&
            Schema::hasColumn('size', 'product_id') &&
            Schema::hasColumn('products', 'store_id')
        ) {
            DB::statement("
                UPDATE size
                INNER JOIN products ON products.id = size.product_id
                SET size.store_id = products.store_id
                WHERE size.store_id IS NULL
            ");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('size') && Schema::hasColumn('size', 'store_id')) {
            Schema::table('size', function (Blueprint $table) {
                $table->dropColumn('store_id');
            });
        }
    }
};