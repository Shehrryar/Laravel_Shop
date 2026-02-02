<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {


            // First name
            $table->string('en_firstname_translation')->nullable()->after('firstname');
            $table->string('ur_firstname_translation')->nullable()->after('en_firstname_translation');

            // Last name
            $table->string('en_lastname_translation')->nullable()->after('lastname');
            $table->string('ur_lastname_translation')->nullable()->after('en_lastname_translation');



            // Apartment
            $table->string('en_apartment_translation')->nullable()->after('apartment');
            $table->string('ur_apartment_translation')->nullable()->after('en_apartment_translation');

            // Address
            $table->text('en_address_translation')->nullable()->after('address');
            $table->text('ur_address_translation')->nullable()->after('en_address_translation');

            // City
            $table->string('en_city_translation')->nullable()->after('city');
            $table->string('ur_city_translation')->nullable()->after('en_city_translation');

            // State
            $table->string('en_state_translation')->nullable()->after('state');
            $table->string('ur_state_translation')->nullable()->after('en_state_translation');



            // Notes
            $table->text('en_notes_translation')->nullable()->after('notes');
            $table->text('ur_notes_translation')->nullable()->after('en_notes_translation');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'en_firstname_translation',
                'ur_firstname_translation',
                'en_lastname_translation',
                'ur_lastname_translation',
                'en_apartment_translation',
                'ur_apartment_translation',
                'en_address_translation',
                'ur_address_translation',
                'en_city_translation',
                'ur_city_translation',
                'en_state_translation',
                'ur_state_translation',
                'en_notes_translation',
                'ur_notes_translation',
            ]);
        });
    }
};
