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
            LocationSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            SubscriptionSeeder::class,
            FeatureSeeder::class,
            OwnershipUnitSeeder::class,
            BillTypeSeeder::class,
            PaymentMasterSeeder::class,
            ProjectSeeder::class,
            ArticleSeeder::class,
            BannerSeeder::class,
            PromotionSeeder::class,
            BankDeveloperSeeder::class,
            FaqSeeder::class,
        ]);

        Storage::disk('public')->deleteDirectory('articles');
        Storage::disk('public')->deleteDirectory('contents');
        Storage::disk('public')->deleteDirectory('facilities');
        Storage::disk('public')->deleteDirectory('developer-banks');
        Storage::disk('public')->deleteDirectory('promotions');
    }
}
