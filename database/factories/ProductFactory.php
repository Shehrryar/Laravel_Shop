<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->name();
        $slug = Str::slug($title);
        $subcategory = [5,6];
        $subcatrandkey = array_rand($subcategory);

        $brands = [2,6,7,8];
        $brandsrandkey = array_rand($brands);
        return [
            'title' => $title,
            'slug' => $slug,
            'categories_id'=> 53,
            'sub_category_id'=>$subcategory[$subcatrandkey],
            'brands_id'=>$brands[$brandsrandkey],
            'price'=>rand(10, 1000),
            'sku'=>rand(1000,10000),
            'track_qty'=>'Yes',
            'qty'=>10,
            'is_featured'=>'Yes',
            'status'=>1
        ];
    }
}
