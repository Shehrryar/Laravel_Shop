<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sub_categories') && !Schema::hasColumn('sub_categories', 'store_id')) {
            Schema::table('sub_categories', function (Blueprint $table) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id')->index();
            });
        }

        if (
            Schema::hasTable('sub_categories') &&
            Schema::hasTable('categories') &&
            Schema::hasColumn('sub_categories', 'store_id') &&
            Schema::hasColumn('sub_categories', 'category_id') &&
            Schema::hasColumn('categories', 'store_id')
        ) {
            DB::statement("
                UPDATE sub_categories
                INNER JOIN categories ON categories.id = sub_categories.category_id
                SET sub_categories.store_id = categories.store_id
                WHERE sub_categories.store_id IS NULL
            ");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('sub_categories') && Schema::hasColumn('sub_categories', 'store_id')) {
            Schema::table('sub_categories', function (Blueprint $table) {
                $table->dropColumn('store_id');
            });
        }
    }
};