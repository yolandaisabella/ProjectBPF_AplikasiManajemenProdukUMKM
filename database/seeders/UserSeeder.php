<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin user
        User::create([
            'name' => 'Admin UMKM',
            'username' => 'admin',
            'email' => 'admin@umkm.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Staff user
        User::create([
            'name' => 'Staff UMKM',
            'username' => 'staff',
            'email' => 'staff@umkm.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // Create Guest user
        User::create([
            'name' => 'Guest UMKM',
            'username' => 'guest',
            'email' => 'guest@umkm.com',
            'password' => Hash::make('password'),
            'role' => 'guest',
        ]);
    }
}
