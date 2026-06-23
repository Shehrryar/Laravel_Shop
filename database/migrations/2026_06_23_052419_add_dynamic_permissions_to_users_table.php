<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'permissions')) {
                $table->json('permissions')->nullable()->after('status');
            }
        });

        // Default permissions for existing vendors
        DB::table('users')
            ->where('role', 3)
            ->whereNull('permissions')
            ->update([
                'permissions' => json_encode([
                    'dashboard' => true,
                    'category' => false,
                    'sub_category_level_2' => false,
                    'sub_category_level_3' => false,
                    'brands' => false,
                    'products' => true,
                    'colors' => false,
                    'themes' => false,
                    'sizes' => false,
                    'stock' => true,
                    'shipping' => false,
                    'orders' => true,
                    'discount' => false,
                    'users' => false,
                    'currencies' => false,
                    'language' => false,
                    'promotions' => false,
                    'chat' => true,
                    'sockets_chat' => false,
                    'web_services' => false,
                    'onboarding' => false,
                    'homepage_labels' => false,
                ]),
            ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'permissions')) {
                $table->dropColumn('permissions');
            }
        });
    }
};