<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UpdateUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing admin user to have admin role
        $admin = User::where('email', 'admin@lightgrace.com')->first();
        if ($admin) {
            $admin->update(['role' => 'admin']);
        } else {
            // Create admin if doesn't exist
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@lightgrace.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]);
        }

        // Create or update manager user
        $manager = User::where('email', 'manager@lightgrace.com')->first();
        if ($manager) {
            $manager->update(['role' => 'manager']);
        } else {
            User::create([
                'name' => 'Manager User',
                'email' => 'manager@lightgrace.com',
                'password' => Hash::make('password123'),
                'role' => 'manager',
            ]);
        }

        // Create or update recipient user
        $recipient = User::where('email', 'recipient@lightgrace.com')->first();
        if ($recipient) {
            $recipient->update(['role' => 'recipient']);
        } else {
            User::create([
                'name' => 'Recipient User',
                'email' => 'recipient@lightgrace.com',
                'password' => Hash::make('password123'),
                'role' => 'recipient',
            ]);
        }

        $this->command->info('User roles updated successfully.');
    }
}
