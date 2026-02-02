<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customer_addresses', function (Blueprint $table) {

            $table->json('firstname_translations')->nullable()->after('firstname');
            $table->json('lastname_translations')->nullable()->after('lastname');
            $table->json('address_translations')->nullable()->after('address');
            $table->json('city_translations')->nullable()->after('city');
            $table->json('state_translations')->nullable()->after('state');

        });
    }

    public function down(): void
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->dropColumn([
                'firstname_translations',
                'lastname_translations',
                'address_translations',
                'city_translations',
                'state_translations',
            ]);
        });
    }
};
