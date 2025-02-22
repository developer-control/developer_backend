<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'key' => 'project_unit',
                'name' => 'Unitku',
                'type' => 'free',
                'group' => 'api'
            ],
            [
                'key' => 'access_card',
                'name' => 'kartu tamu',
                'type' => 'free',
                'group' => 'api'
            ],
            [
                'key' => 'bill',
                'name' => 'Tagihan',
                'type' => 'free',
                'group' => 'api'
            ],
            [
                'key' => 'facility',
                'name' => 'Fasilitas',
                'type' => 'premium',
                'group' => 'api'
            ],
            [
                'key' => 'support',
                'name' => 'Bantuan',
                'type' => 'free',
                'group' => 'api'
            ],
            [
                'key' => 'complain',
                'name' => 'Komplain',
                'type' => 'free',
                'group' => 'api'
            ],
            [
                'key' => 'article',
                'name' => 'Berita',
                'type' => 'free',
                'group' => 'api'
            ],
            [
                'key' => 'promotion',
                'name' => 'Promo',
                'type' => 'free',
                'group' => 'api'
            ],
            [
                'key' => 'emergency',
                'name' => 'Darurat',
                'type' => 'free',
                'group' => 'api'
            ],
        ];
        foreach ($data as $item) {
            $subscriptions = Subscription::pluck('id')->all();
            $feature = Feature::create($item);
            if ($feature->type == 'free') {
                if (count($subscriptions)) {
                    $feature->subscriptions()->attach($subscriptions);
                }
            }
        }
    }
}
