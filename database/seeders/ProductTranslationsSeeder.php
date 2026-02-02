<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductTranslationsSeeder extends Seeder
{
    public function run(): void
    {
        $translations = [
            1 => [
                'title' => ['en' => 'Laptop', 'ur' => 'لیپ ٹاپ'],
                'description' => ['en' => 'High performance laptop', 'ur' => 'اعلی کارکردگی کا لیپ ٹاپ'],
            ],
            2 => [
                'title' => ['en' => 'T - Shirt', 'ur' => 'ٹی شرٹ'],
                'description' => ['en' => 'Comfortable cotton t-shirt', 'ur' => 'آرام دہ کاٹن ٹی شرٹ'],
            ],
            3 => [
                'title' => ['en' => 'Shoes Jogger', 'ur' => 'جگر جوتے'],
                'description' => ['en' => 'Stylish jogging shoes', 'ur' => 'اسٹائلش جاگنگ کے جوتے'],
            ],
            4 => [
                'title' => ['en' => 'Shoes', 'ur' => 'جوتے'],
                'description' => ['en' => 'Casual shoes', 'ur' => 'عام جوتے'],
            ],
            5 => [
                'title' => ['en' => 'Paint Horse', 'ur' => 'پینٹ ہارس'],
                'description' => ['en' => 'Decorative paint horse', 'ur' => 'سجاوٹی پینٹ ہارس'],
            ],
            6 => [
                'title' => ['en' => 'Dr. Katrina Kutch V', 'ur' => 'ڈاکٹر کیٹرینا کچ وی'],
                'description' => ['en' => 'Product description for Dr. Katrina', 'ur' => 'ڈاکٹر کیٹرینا کے لئے مصنوع کی تفصیل'],
            ],
            7 => [
                'title' => ['en' => 'Miss Annie Blick III', 'ur' => 'مس اینی بلیک تھری'],
                'description' => ['en' => 'Product description for Miss Annie', 'ur' => 'مس اینی کے لئے مصنوع کی تفصیل'],
            ],
            8 => [
                'title' => ['en' => 'Timothy Howe Jr.', 'ur' => 'ٹموتھی ہاؤ جونیئر'],
                'description' => ['en' => 'Product description for Timothy Howe', 'ur' => 'ٹموتھی ہاؤ کے لئے مصنوع کی تفصیل'],
            ],
            9 => [
                'title' => ['en' => 'Ervin Emmerich', 'ur' => 'اروین ایمیرچ'],
                'description' => ['en' => 'Product description for Ervin Emmerich', 'ur' => 'اروین ایمیرچ کے لئے مصنوع کی تفصیل'],
            ],
            10 => [
                'title' => ['en' => 'Dr. Hassan Leffler II', 'ur' => 'ڈاکٹر حسن لیفلر II'],
                'description' => ['en' => 'Product description for Dr. Hassan', 'ur' => 'ڈاکٹر حسن کے لئے مصنوع کی تفصیل'],
            ],
            11 => [
                'title' => ['en' => 'Mr. Stephan Hirthe', 'ur' => 'مسٹر اسٹیفن ہرتھے'],
                'description' => ['en' => 'Product description for Stephan', 'ur' => 'اسٹیفن کے لئے مصنوع کی تفصیل'],
            ],
            12 => [
                'title' => ['en' => 'Alexandria Keebler', 'ur' => 'الیگزینڈریا کیبلر'],
                'description' => ['en' => 'Product description for Alexandria', 'ur' => 'الیگزینڈریا کے لئے مصنوع کی تفصیل'],
            ],
            13 => [
                'title' => ['en' => 'Josiah Brown', 'ur' => 'جوسایا براؤن'],
                'description' => ['en' => 'Product description for Josiah', 'ur' => 'جوسایا کے لئے مصنوع کی تفصیل'],
            ],
            14 => [
                'title' => ['en' => 'Chelsey Nader', 'ur' => 'چیلسی نادر'],
                'description' => ['en' => 'Product description for Chelsey', 'ur' => 'چیلسی کے لئے مصنوع کی تفصیل'],
            ],
            15 => [
                'title' => ['en' => 'Horace Larson Sr.', 'ur' => 'ہوریس لارسن سینئر'],
                'description' => ['en' => 'Product description for Horace Larson', 'ur' => 'ہوریس لارسن کے لئے مصنوع کی تفصیل'],
            ],
            16 => [
                'title' => ['en' => 'Althea Wunsch V', 'ur' => 'التھیہ ونش وی'],
                'description' => ['en' => 'Product description for Althea', 'ur' => 'التھیہ کے لئے مصنوع کی تفصیل'],
            ],
            17 => [
                'title' => ['en' => 'Alysa Olson', 'ur' => 'الیسا اولسن'],
                'description' => ['en' => 'Product description for Alysa', 'ur' => 'الیسا کے لئے مصنوع کی تفصیل'],
            ],
            18 => [
                'title' => ['en' => 'Kelvin Windler', 'ur' => 'کیلون ونڈلر'],
                'description' => ['en' => 'Product description for Kelvin', 'ur' => 'کیلون کے لئے مصنوع کی تفصیل'],
            ],
            19 => [
                'title' => ['en' => 'Darion Lockman DVM', 'ur' => 'داریون لاک مین DVM'],
                'description' => ['en' => 'Product description for Darion', 'ur' => 'داریون کے لئے مصنوع کی تفصیل'],
            ],
            20 => [
                'title' => ['en' => 'Prof. Mable Quitzon', 'ur' => 'پروفیسر میبل کوئٹزون'],
                'description' => ['en' => 'Product description for Mable', 'ur' => 'میبل کے لئے مصنوع کی تفصیل'],
            ],
            21 => [
                'title' => ['en' => 'Virginia Brakus', 'ur' => 'ورجینیا بریکس'],
                'description' => ['en' => 'Product description for Virginia', 'ur' => 'ورجینیا کے لئے مصنوع کی تفصیل'],
            ],
            22 => [
                'title' => ['en' => 'Jarret Bruen', 'ur' => 'جیریٹ برون'],
                'description' => ['en' => 'Product description for Jarret', 'ur' => 'جیریٹ کے لئے مصنوع کی تفصیل'],
            ],
            23 => [
                'title' => ['en' => 'Alanis Dach', 'ur' => 'الانِس ڈاچ'],
                'description' => ['en' => 'Product description for Alanis', 'ur' => 'الانِس کے لئے مصنوع کی تفصیل'],
            ],
            24 => [
                'title' => ['en' => 'Abbigail Dicki', 'ur' => 'ابیگل ڈکی'],
                'description' => ['en' => 'Product description for Abbigail', 'ur' => 'ابیگل کے لئے مصنوع کی تفصیل'],
            ],
            25 => [
                'title' => ['en' => 'Astrid Ratke', 'ur' => 'اسٹرڈ ریٹکے'],
                'description' => ['en' => 'Product description for Astrid', 'ur' => 'اسٹرڈ کے لئے مصنوع کی تفصیل'],
            ],
            26 => [
                'title' => ['en' => 'Giovanny Dach', 'ur' => 'جیووانی ڈاچ'],
                'description' => ['en' => 'Product description for Giovanny', 'ur' => 'جیووانی کے لئے مصنوع کی تفصیل'],
            ],
        ];

        foreach ($translations as $id => $data) {
            $product = Product::find($id);
            if ($product) {
                $product->update([
                    'title_translations' => $data['title'],
                    'description_translations' => $data['description'],
                ]);
            }
        }
    }
}
