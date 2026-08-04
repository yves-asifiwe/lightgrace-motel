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
            'name' => 'yves asifiwe',
            'email' => 'yvesasifiwe00@gmail.com',
            'password' => Hash::make('10/3/2009'),
            'role' => 'manager',
        ]);


        // User::factory(10)->create();
    }
}
