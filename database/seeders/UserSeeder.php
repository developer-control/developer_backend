<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user =  User::create([
            'name' => 'superadmin developer control',
            'email' => 'superadmin@developer.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('superadmin');
        $user =  User::create([
            'name' => 'user developer control',
            'email' => 'user@developer.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('user');
    }
}
