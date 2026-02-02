<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCategory;

class SubCategoryTranslationsSeeder extends Seeder
{
    public function run(): void
    {
        $subCategories = SubCategory::all();

        foreach ($subCategories as $sub) {
            $sub->update([
                'name_translations' => [
                    'en' => $sub->name,
                    'ur' => 'مرد ', // Replace with actual Urdu translation
                ],
            ]);
        }
    }
}
