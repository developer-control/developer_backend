<?php

namespace Database\Seeders;

use App\Models\OwnershipUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OwnershipUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'pemilik',
            'keluarga',
            'lainnya'
        ];
        foreach ($data as $value) {
            OwnershipUnit::create([
                'name' => $value,
            ]);
        }
    }
}
