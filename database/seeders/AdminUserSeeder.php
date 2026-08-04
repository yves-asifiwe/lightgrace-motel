<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'yvesasifiwe00@gmail.com',
            ],
            [
                'name' => 'Yves Asifiwe',
                'password' => Hash::make('10/3/2009'),
                'role' => 'manager',
            ]
        );
    }
}
