<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Character;
use App\Observers\CharacterObserver;
use App\Policies\CharacterPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Observer
        Character::observe(CharacterObserver::class);

        // Policy
        Gate::policy(Character::class, CharacterPolicy::class);
    }
}
