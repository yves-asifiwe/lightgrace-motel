<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'yvesasifiwe00@gmail.com'],
            [
                'name' => 'asifiwe',
                'password' => bcrypt('10/3/2009'),
                'role' => 'manager',
            ]
        );
    }
}
