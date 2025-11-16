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
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->string('address_type')->nullable()->after('zip');
            $table->boolean('is_default')->default(0)->after('address_type');
            $table->string('landmark')->nullable()->after('apartment');
            $table->string('pin_code')->nullable()->after('zip');
            $table->string('flat')->nullable()->after('apartment');
            $table->string('area')->nullable()->after('flat');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->dropColumn([
                'address_type',
                'is_default',
                'landmark',
                'pin_code',
                'flat',
                'area',
            ]);
        });
    }
};