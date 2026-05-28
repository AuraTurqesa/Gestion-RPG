<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Character;
use App\Models\User;

class CharacterSeeder extends Seeder
{
    public function run(): void
    {
        // Recuperamos los usuarios que tienen el rol de 'player'
        $players = User::where('role', 'player')->get();

        foreach ($players as $player) {
            $chars = Character::factory()->count(2)->create([
                'user_id' => $player->id
            ]);
        }

        // Asignamos 5 personajes al usuario 5 (si existe)
        $user5 = User::find(5);
        if ($user5) {
            Character::factory()->count(5)->create([
                'user_id' => $user5->id,
            ]);
        }
    }
}