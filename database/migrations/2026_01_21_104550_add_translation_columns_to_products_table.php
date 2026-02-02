<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            // Title translations
            $table->string('en_title_translation')->nullable()->after('title');
            $table->string('ur_title_translation')->nullable()->after('en_title_translation');

            // Description translations
            $table->text('en_description_translation')->nullable()->after('description');
            $table->text('ur_description_translation')->nullable()->after('en_description_translation');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropColumn([
                'en_title_translation',
                'ur_title_translation',
                'en_description_translation',
                'ur_description_translation',
            ]);
        });
    }
};
