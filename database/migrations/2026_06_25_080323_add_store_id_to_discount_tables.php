<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('discount_coupons') && !Schema::hasColumn('discount_coupons', 'store_id')) {
            Schema::table('discount_coupons', function (Blueprint $table) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id')->index();
            });
        }

        if (Schema::hasTable('discounts') && !Schema::hasColumn('discounts', 'store_id')) {
            Schema::table('discounts', function (Blueprint $table) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id')->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('discount_coupons') && Schema::hasColumn('discount_coupons', 'store_id')) {
            Schema::table('discount_coupons', function (Blueprint $table) {
                $table->dropColumn('store_id');
            });
        }

        if (Schema::hasTable('discounts') && Schema::hasColumn('discounts', 'store_id')) {
            Schema::table('discounts', function (Blueprint $table) {
                $table->dropColumn('store_id');
            });
        }
    }
};