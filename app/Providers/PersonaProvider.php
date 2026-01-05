<?php

namespace App\Providers;

use App\Models\Persona;
use App\Repositories\PersonaRepository;
use App\Repositories\RolRepository;
use App\Services\PersonaService;
use Illuminate\Support\ServiceProvider;

class PersonaProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PersonaRepository::class, function($app){
            return new PersonaRepository($app->make(Persona::class));
        });

        $this->app->singleton(PersonaService::class, function($app){
            return new PersonaService(
                $app->make(PersonaRepository::class),
                $app->make(RolRepository::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
