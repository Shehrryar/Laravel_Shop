<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTranslationSeeder extends Seeder
{
    public function run(): void
    {
        $users = DB::table('users')->get();

        foreach ($users as $user) {

            DB::table('users')
                ->where('id', $user->id)
                ->update([

                    // NAME
                    'name_translations' => $user->name
                        ? json_encode([
                            'en' => $user->name,
                            'ur' => $this->urduName($user->name),
                        ])
                        : null,

                    // FIRST NAME
                    'first_name_translations' => $user->first_name
                        ? json_encode([
                            'en' => $user->first_name,
                            'ur' => $this->urduName($user->first_name),
                        ])
                        : null,

                    // LAST NAME
                    'last_name_translations' => $user->last_name
                        ? json_encode([
                            'en' => $user->last_name,
                            'ur' => $this->urduName($user->last_name),
                        ])
                        : null,

                    // GENDER
                    'gender_translations' => $user->gender
                        ? json_encode([
                            'en' => ucfirst($user->gender),
                            'ur' => $user->gender === 'male' ? 'مرد' : 'عورت',
                        ])
                        : null,
                ]);
        }
    }

    /**
     * Basic Urdu name mapping (extend later if needed)
     */
    private function urduName($name)
    {
        $map = [
            'Muhammad' => 'محمد',
            'Sheharyar' => 'شہریار',
            'Asif' => 'آصف',
            'Usman' => 'عثمان',
            'Ali' => 'علی',
            'Awais' => 'اویس',
            'Shah' => 'شاہ',
            'Admin User' => 'ایڈمن صارف',
        ];

        $words = explode(' ', $name);

        $urduWords = array_map(function ($word) use ($map) {
            return $map[$word] ?? $word;
        }, $words);

        return implode(' ', $urduWords);
    }
}
