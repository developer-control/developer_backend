<?php

namespace Database\Seeders;

use App\Utils\PermissionDictionary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = PermissionDictionary::allPermissions();

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                [
                    "name" => $perm["name"],
                    "guard_name" => "web",
                ],
                [
                    "menu" => $perm["menu"],
                    "group" => $perm["group"],
                    "type" => $perm["type"],
                ]
            );
        }
    }
}
