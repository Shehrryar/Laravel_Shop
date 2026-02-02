<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Currency::insert([
            [
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'exchange_rate' => 1.0000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pakistani Rupee',
                'code' => 'PKR',
                'symbol' => '₨',
                'exchange_rate' => 280.0000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
                'exchange_rate' => 0.9200,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'British Pound',
                'code' => 'GBP',
                'symbol' => '£',
                'exchange_rate' => 0.7900,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
