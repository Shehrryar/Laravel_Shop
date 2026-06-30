<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('brands') && !Schema::hasColumn('brands', 'image')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->string('image')->nullable()->after('slug');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('brands') && Schema::hasColumn('brands', 'image')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }
    }
};