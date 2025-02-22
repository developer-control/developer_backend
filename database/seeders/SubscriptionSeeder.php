<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscription = Subscription::create([
            'name' => 'paket 1',
            'price' => 150000,
            'duration' => 6,
        ]);
        $expired_at = Carbon::now()->addMonths($subscription->duration)->toDateString();
        $subscription->developerSubscriptions()->create([
            'developer_id' => 1,
            'expired_at' => $expired_at,
            'paid_at' => now(),
            'status' => 'active',
        ]);
    }
}
