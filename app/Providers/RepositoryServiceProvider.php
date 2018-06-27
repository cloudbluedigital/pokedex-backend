<?php

namespace App\Providers;

use App\Repositories\PokemonRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('pokemonfacade', function ($app) {
            return new PokemonRepository();
        });
    }
}
