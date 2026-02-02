<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            // Add separate columns for translations
            $table->string('en_name_translation')->nullable()->after('name');
            $table->string('ur_name_translation')->nullable()->after('en_name_translation');
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['en_name_translation', 'ur_name_translation']);
        });
    }
};
