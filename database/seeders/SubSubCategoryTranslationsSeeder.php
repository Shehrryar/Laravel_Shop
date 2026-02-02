<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubSubCategoryTranslationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example: Shirts subsubcategory
        DB::table('sub_sub_categories')->updateOrInsert(
            ['id' => 2], // ID of the subsubcategory
            [
                'name_translations' => json_encode([
                    'en' => 'Shirts',
                    'ur' => 'شرٹس',
                ]),
            ]
        );

        // Example: Shoes subsubcategory
        DB::table('sub_sub_categories')->updateOrInsert(
            ['id' => 3],
            [
                'name_translations' => json_encode([
                    'en' => 'Shoes',
                    'ur' => 'جوتے',
                ]),
            ]
        );
    }
}
