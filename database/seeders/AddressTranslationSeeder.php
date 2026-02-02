<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressTranslationSeeder extends Seeder
{
    public function run(): void
    {
        $addresses = DB::table('customer_addresses')->get();

        foreach ($addresses as $address) {

            DB::table('customer_addresses')
                ->where('id', $address->id)
                ->update([

                    // FIRST NAME
                    'firstname_translations' => $address->firstname
                        ? json_encode([
                            'en' => $address->firstname,
                            'ur' => $this->urduName($address->firstname),
                        ])
                        : null,

                    // LAST NAME
                    'lastname_translations' => $address->lastname
                        ? json_encode([
                            'en' => $address->lastname,
                            'ur' => $this->urduName($address->lastname),
                        ])
                        : null,

                    // ADDRESS
                    'address_translations' => $address->address
                        ? json_encode([
                            'en' => $address->address,
                            'ur' => $this->urduAddress($address->address),
                        ])
                        : null,

                    // CITY
                    'city_translations' => $address->city
                        ? json_encode([
                            'en' => $address->city,
                            'ur' => $this->urduCity($address->city),
                        ])
                        : null,

                    // STATE
                    'state_translations' => $address->state
                        ? json_encode([
                            'en' => $address->state,
                            'ur' => $this->urduState($address->state),
                        ])
                        : null,
                ]);
        }
    }

    /* ---------------- HELPERS ---------------- */

    private function urduName($name)
    {
        $map = [
            'Muhammad' => 'محمد',
            'Sheharyar' => 'شہریار',
            'Asif' => 'آصف',
            'Ali' => 'علی',
            'Usman' => 'عثمان',
        ];

        $words = explode(' ', $name);

        return implode(' ', array_map(fn($w) => $map[$w] ?? $w, $words));
    }

    private function urduCity($city)
    {
        return match (strtolower($city)) {
            'attock', 'attock city' => 'اٹک',
            'islamabad' => 'اسلام آباد',
            default => $city,
        };
    }

    private function urduState($state)
    {
        return match (strtolower($state)) {
            'punjab' => 'پنجاب',
            'alabama' => 'الاباما',
            default => $state,
        };
    }

    private function urduAddress($address)
    {
        if (!$address)
            return null;

        $translations = [
            'Road' => 'روڈ',
            'road' => 'روڈ',
            'Street' => 'اسٹریٹ',
            'street' => 'اسٹریٹ',
            'G-' => 'جی-',
            'Block' => 'بلاک',
            'block' => 'بلاک',
            'Sector' => 'سیکٹر',
            'sector' => 'سیکٹر',
            'Village' => 'گاؤں',
            'Post Office' => 'ڈاک خانہ',
            'Tehsil' => 'تحصیل',
            'City' => 'شہر',
            'Islamabad' => 'اسلام آباد',
            'Attock' => 'اٹک',
            'Punjab' => 'پنجاب',
            'Rawalpindi' => 'راولپنڈی',
            'Pakistan' => 'پاکستان',
            'VPO' => 'وی پی او',
        ];

        return str_replace(
            array_keys($translations),
            array_values($translations),
            $address
        );
    }

}
