<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Albert Garcia',
                'email' => 'albert.garcia@example.com',
                'role' => 1, // Admin
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Default password
            ],
            [
                'name' => 'Rodnie Delgado',
                'email' => 'rodnie.delgado@example.com',
                'role' => 1, // Admin
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Default password
            ],
            [
                'name' => 'System Administrator',
                'email' => 'system.admin@example.com',
                'role' => 1, // Admin
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Default password
            ],
            [
                'name' => 'System Moderator',
                'email' => 'system.moderator@example.com',
                'role' => 2, // Moderator
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Default password
            ],
        ];

        // Insert the data into the users table
        DB::table('users')->insert($users);
    }
}
