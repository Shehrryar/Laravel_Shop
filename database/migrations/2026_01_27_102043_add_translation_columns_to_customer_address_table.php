<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customer_addresses', function (Blueprint $table) {

            // Firstname translations
            $table->string('en_firstname_translation')->nullable()->after('firstname');
            $table->string('ur_firstname_translation')->nullable()->after('en_firstname_translation');

            // Lastname translations
            $table->string('en_lastname_translation')->nullable()->after('lastname');
            $table->string('ur_lastname_translation')->nullable()->after('en_lastname_translation');

            // Address translations
            $table->string('en_address_translation')->nullable()->after('address');
            $table->string('ur_address_translation')->nullable()->after('en_address_translation');

            // City translations
            $table->string('en_city_translation')->nullable()->after('city');
            $table->string('ur_city_translation')->nullable()->after('en_city_translation');

            // State translations
            $table->string('en_state_translation')->nullable()->after('state');
            $table->string('ur_state_translation')->nullable()->after('en_state_translation');
        });
    }

    public function down(): void
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->dropColumn([
                'en_firstname_translation',
                'ur_firstname_translation',
                'en_lastname_translation',
                'ur_lastname_translation',
                'en_address_translation',
                'ur_address_translation',
                'en_city_translation',
                'ur_city_translation',
                'en_state_translation',
                'ur_state_translation',
            ]);
        });
    }
};

