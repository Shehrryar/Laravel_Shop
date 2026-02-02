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
        Schema::table('brands', function (Blueprint $table) {
            $table->json('name_translations')->nullable()->after('name');
        });

        // Optional: seed existing name into translations
        DB::table('brands')->get()->each(function ($brand) {
            DB::table('brands')
                ->where('id', $brand->id)
                ->update([
                    'name_translations' => json_encode([
                        'en' => $brand->name,
                    ])
                ]);
        });
    }
    
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('name_translations');
        });
    }
};
