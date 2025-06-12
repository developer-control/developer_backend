<?php

namespace Database\Seeders;

use App\Models\DeveloperBank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BankDeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($d = 1; $d <= 3; $d++) {
            # code...
            for ($b = 1; $b <= 2; $b++) {
                DeveloperBank::create([
                    'developer_id' => $d,
                    'name' => $faker->randomElement(['BCA', 'Mandiri', 'BNI', 'BRI', 'CIMB Niaga', 'Danamon']),
                    'account_name' => $faker->name,
                    'account_number' => $faker->bankAccountNumber,
                ]);
            }
        }
    }
}
