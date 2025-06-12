<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://wilayah.id/api/provinces.json');

        foreach (@$response->object()->data ?? [] as $province) {
            // dd($province->code);
            if (!Province::where('id', $province->code)->exists()) {
                // Jika email tidak ada, maka insert data
                $province = Province::create([
                    'id' => $province->code,
                    'name' => $province->name
                ]);
                $cities = Http::get("https://wilayah.id/api/regencies/{$province->id}.json");
                // return $cities->object()->data;
                foreach (@$cities->object()->data ?? [] as $city) {
                    // dd($city->code);
                    $id = str_replace('.', '', $city->code);
                    if (!City::where('id', $id)->exists()) {
                        // Jika email tidak ada, maka insert data
                        City::create([
                            'id' => $id,
                            'province_id' => $province->id,
                            'name' => $city->name
                        ]);
                    }
                }
            }
        }
    }
}
