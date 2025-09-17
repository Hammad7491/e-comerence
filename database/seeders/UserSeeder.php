<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'a@a'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('a'), // change in production
                'role'     => 'admin',
            ]
        );

        // Normal users
        for ($i = 1; $i <= 3; $i++) {
            User::updateOrCreate(
                ['email' => "user{$i}@example.com"],
                [
                    'name'     => "User {$i}",
                    'password' => Hash::make('password'),
                    'role'     => 'user',
                ]
            );
        }
    }
}
