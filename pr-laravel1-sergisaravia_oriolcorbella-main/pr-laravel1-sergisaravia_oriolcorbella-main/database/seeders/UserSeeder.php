<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $admin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('Admin1234!'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Sergi',
            'email' => 'sergi754575@gmail.com',
            'password' => Hash::make('Aur@3456'),
            'role' => 'player',
        ]);

        $players = User::factory()->count(3)->create(['role' => 'player']);
    }
}
