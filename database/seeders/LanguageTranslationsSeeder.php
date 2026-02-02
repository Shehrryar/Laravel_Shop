<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageTranslationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('languages')->updateOrInsert(
            ['Isocode' => 'en'],
            [
                'name_translations' => json_encode([
                    'en' => 'English',
                    'ur' => 'انگریزی',
                ]),
            ]
        );

        DB::table('languages')->updateOrInsert(
            ['Isocode' => 'ur'],
            [
                'name_translations' => json_encode([
                    'en' => 'Urdu',
                    'ur' => 'اردو',
                ]),
            ]
        );
    }
}
