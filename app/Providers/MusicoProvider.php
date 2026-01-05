<?php

namespace App\Providers;

use App\Models\Musico;
use App\Repositories\MusicoRepository;
use App\Services\MusicoService;
use App\Services\PersonaService;
use Illuminate\Support\ServiceProvider;

class MusicoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MusicoRepository::class, function($app){
            return new MusicoRepository($app->make(Musico::class));
        });

        $this->app->singleton(MusicoService::class, function($app){
            return new MusicoService(
                $app->make(MusicoRepository::class),
                $app->make(PersonaService::class));
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
