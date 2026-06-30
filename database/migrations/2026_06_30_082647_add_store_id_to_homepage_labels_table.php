<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('homepage_labels') && !Schema::hasColumn('homepage_labels', 'store_id')) {
            Schema::table('homepage_labels', function (Blueprint $table) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id')->index();
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Important
        |--------------------------------------------------------------------------
        | Old table has label_key as globally unique.
        | For vendor system, vendor1 and vendor2 should be able to use same label_key
        | inside their own stores, so we remove the old global unique index.
        */
        try {
            DB::statement('ALTER TABLE homepage_labels DROP INDEX homepage_labels_label_key_unique');
        } catch (\Throwable $e) {
            // Index may already be removed. Ignore.
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('homepage_labels') && Schema::hasColumn('homepage_labels', 'store_id')) {
            Schema::table('homepage_labels', function (Blueprint $table) {
                $table->dropColumn('store_id');
            });
        }
    }
};