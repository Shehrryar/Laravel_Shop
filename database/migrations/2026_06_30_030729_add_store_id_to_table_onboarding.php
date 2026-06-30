<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('table_onboarding') && !Schema::hasColumn('table_onboarding', 'store_id')) {
            Schema::table('table_onboarding', function (Blueprint $table) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id')->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('table_onboarding') && Schema::hasColumn('table_onboarding', 'store_id')) {
            Schema::table('table_onboarding', function (Blueprint $table) {
                $table->dropColumn('store_id');
            });
        }
    }
};