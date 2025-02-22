<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\PaymentMaster;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            OwnershipUnitSeeder::class,
            ProjectSeeder::class,
            BillTypeSeeder::class,
            PaymentMasterSeeder::class,
            SubscriptionSeeder::class,
            FeatureSeeder::class
        ]);

        Storage::deleteDirectory(storage_path('app/public/articles'));
        Storage::deleteDirectory(storage_path('app/public/contents'));
        Storage::deleteDirectory(storage_path('app/public/facilities'));
        Storage::deleteDirectory(storage_path('app/public/developer-banks'));
        Storage::deleteDirectory(storage_path('app/public/promotions'));
    }
}
