<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('stocks') && !Schema::hasColumn('stocks', 'store_id')) {
            Schema::table('stocks', function (Blueprint $table) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id')->index();
            });
        }

        // Fill existing stock store_id from product store_id
        if (
            Schema::hasTable('stocks') &&
            Schema::hasTable('products') &&
            Schema::hasColumn('stocks', 'store_id') &&
            Schema::hasColumn('products', 'store_id')
        ) {
            DB::statement("
                UPDATE stocks
                INNER JOIN products ON products.id = stocks.product_id
                SET stocks.store_id = products.store_id
                WHERE stocks.store_id IS NULL
            ");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('stocks') && Schema::hasColumn('stocks', 'store_id')) {
            Schema::table('stocks', function (Blueprint $table) {
                $table->dropColumn('store_id');
            });
        }
    }
};