<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'store_id')) {
                $table->unsignedBigInteger('store_id')->nullable()->after('id');

                $table->foreign('store_id')
                    ->references('id')
                    ->on('stores')
                    ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'store_id')) {
                try {
                    $table->dropForeign(['store_id']);
                } catch (\Throwable $e) {
                    // Ignore if foreign key already removed
                }

                $table->dropColumn('store_id');
            }
        });
    }
};