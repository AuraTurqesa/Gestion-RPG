<?php

namespace App\Observers;

use App\Models\Character;
use App\Models\Log;

class CharacterObserver
{
    /**
     * Asignar valores por defecto antes de crear
     */
    public function creating(Character $character): void
    {
        if (empty($character->level)) {
            $character->level = 1;
        }

        if (empty($character->health)) {
            $character->health = 100;
        }
    }

    /**
     * Registrar log al crear un personaje
     */
    public function created(Character $character): void
    {
        Log::create([
            'action'      => 'character_created',
            'user_id'     => $character->user_id,
            'metadata'    => [
                'character_id'   => $character->id,
                'character_name' => $character->name,
                'level'          => $character->level,
                'health'         => $character->health,
            ],
            'executed_at' => now(),
        ]);
    }

    /**
     * Registrar log al eliminar un personaje
     */
    public function deleted(Character $character): void
    {
        Log::create([
            'action'      => 'character_deleted',
            'user_id'     => $character->user_id,
            'metadata'    => [
                'character_id'   => $character->id,
                'character_name' => $character->name,
            ],
            'executed_at' => now(),
        ]);
    }
}
