<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('github_id')->nullable()->after('phone');
            $table->string('facebook_id')->nullable()->after('github_id');
            $table->string('google_id')->nullable()->after('facebook_id');        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->removeColumn('phone');
            $table->removeColumn('github_id');
            $table->removeColumn('facebook_id');
            $table->removeColumn('google_id');

        });
    }
};
