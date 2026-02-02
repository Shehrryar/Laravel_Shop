<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategoryTranslationSeeder extends Seeder
{
    public function run(): void
    {
        // Array of category translations
        $translations = [
            1 => ['en' => 'Clothes', 'ur' => 'کپڑے'],
            4 => ['en' => 'Women', 'ur' => 'خواتین'],
            // Add other categories here with their IDs
        ];
        foreach ($translations as $id => $translation) {
            $category = Category::find($id);
            if ($category) {
                $category->update([
                    'name_translations' => $translation,
                ]);
            }
        }
        $this->command->info('Category translations added successfully.');
    }
}