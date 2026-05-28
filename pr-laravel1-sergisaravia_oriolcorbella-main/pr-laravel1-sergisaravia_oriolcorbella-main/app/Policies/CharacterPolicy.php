<?php

namespace App\App\Policies;

use App\Models\Character;
use App\Models\User;

class CharacterPolicy
{
    /**
     * L'admin (segons el camp role) té accés total;
     * un usuari normal només als seus propis personatges.
     */
    public function view(User $user, Character $character): bool
    {
        return $user->role === 'admin' || $user->id === $character->user_id;
    }

    public function update(User $user, Character $character): bool
    {
        return $user->role === 'admin' || $user->id === $character->user_id;
    }

    public function delete(User $user, Character $character): bool
    {
        return $user->role === 'admin' || $user->id === $character->user_id;
    }
}
