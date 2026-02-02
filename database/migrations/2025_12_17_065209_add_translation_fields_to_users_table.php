<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('name_translations')->nullable()->after('name');
            $table->json('first_name_translations')->nullable()->after('first_name');
            $table->json('last_name_translations')->nullable()->after('last_name');
            $table->json('gender_translations')->nullable()->after('gender');
        });
    }
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'name_translations',
                'first_name_translations',
                'last_name_translations',
                'gender_translations',
            ]);
        });
    }
};
