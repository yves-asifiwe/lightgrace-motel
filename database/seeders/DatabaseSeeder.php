<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create manager user with known credentials
        User::create([
            'name' => 'Manager User',
            'email' => 'manager@lightgrace.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
        ]);

        // Create admin user with known credentials
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@lightgrace.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create recipient user with known credentials
        User::create([
            'name' => 'Recipient User',
            'email' => 'recipient@lightgrace.com',
            'password' => Hash::make('password123'),
            'role' => 'recipient',
        ]);

        // User::factory(10)->create();
    }
}
