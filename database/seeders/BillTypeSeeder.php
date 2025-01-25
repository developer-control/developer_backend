<?php

namespace Database\Seeders;

use App\Models\BillType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'IPL/SC',
                'premium_type' => null,
                'is_edit' => 0,
                'with_start_value' => 0,
                'is_premium' => 0,
            ],
            [
                'name' => 'Listrik',
                'premium_type' => 'premium',
                'is_edit' => 0,
                'with_start_value' => 1,
                'is_premium' => 1,
            ],
            [
                'name' => 'Air',
                'premium_type' => 'premium',
                'is_edit' => 0,
                'with_start_value' => 1,
                'is_premium' => 1,
            ],
            [
                'name' => 'Keamanan',
                'premium_type' => null,
                'is_edit' => 0,
                'with_start_value' => 0,
                'is_premium' => 0,
            ],
            [
                'name' => 'Kebersihan',
                'premium_type' => null,
                'is_edit' => 0,
                'with_start_value' => 0,
                'is_premium' => 0,
            ],
            [
                'name' => 'Lainnya',
                'premium_type' => null,
                'is_edit' => 1,
                'with_start_value' => 0,
                'is_premium' => 0,
            ]
        ];
        foreach ($data as $item) {
            BillType::create($item);
        }
    }
}
