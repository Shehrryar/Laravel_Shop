<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sub_sub_categories') && !Schema::hasColumn('sub_sub_categories', 'store_id')) {
            Schema::table('sub_sub_categories', function (Blueprint $table) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id')->index();
            });
        }

        if (
            Schema::hasTable('sub_sub_categories') &&
            Schema::hasTable('sub_categories') &&
            Schema::hasColumn('sub_sub_categories', 'store_id') &&
            Schema::hasColumn('sub_sub_categories', 'subcategory_id') &&
            Schema::hasColumn('sub_categories', 'store_id')
        ) {
            DB::statement("
                UPDATE sub_sub_categories
                INNER JOIN sub_categories ON sub_categories.id = sub_sub_categories.subcategory_id
                SET sub_sub_categories.store_id = sub_categories.store_id
                WHERE sub_sub_categories.store_id IS NULL
            ");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('sub_sub_categories') && Schema::hasColumn('sub_sub_categories', 'store_id')) {
            Schema::table('sub_sub_categories', function (Blueprint $table) {
                $table->dropColumn('store_id');
            });
        }
    }
};