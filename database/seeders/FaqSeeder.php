<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            Faq::create([
                'title' => $faker->sentence(6), // Random kalimat 6 kata untuk judul
                'description' => $faker->paragraph(3), // Random 3 paragraf
            ]);
        }
    }
}
