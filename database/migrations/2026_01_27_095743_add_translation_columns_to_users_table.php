<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('en_name_translation')->nullable()->after('name');
            $table->string('ur_name_translation')->nullable()->after('en_name_translation');
            $table->string('en_first_name_translation')->nullable()->after('first_name');
            $table->string('ur_first_name_translation')->nullable()->after('en_first_name_translation');
            $table->string('en_last_name_translation')->nullable()->after('last_name');
            $table->string('ur_last_name_translation')->nullable()->after('en_last_name_translation');
            $table->string('en_gender_translation')->nullable()->after('gender');
            $table->string('ur_gender_translation')->nullable()->after('en_gender_translation');
        });
    }
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'en_name_translation',
                'ur_name_translation',
                'en_first_name_translation',
                'ur_first_name_translation',
                'en_last_name_translation',
                'ur_last_name_translation',
                'en_gender_translation',
                'ur_gender_translation',
            ]);
        });
    }
};