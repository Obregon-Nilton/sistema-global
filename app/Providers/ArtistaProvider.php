<?php

namespace App\Providers;

use App\Models\Artista;
use App\Repositories\ArtistaRepository;
use App\Services\ArtistaService;
use Illuminate\Support\ServiceProvider;

class ArtistaProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ArtistaRepository::class, function($app){
            return new ArtistaRepository($app->make(Artista::class));
        });

        $this->app->singleton(ArtistaService::class, function($app){
            return new ArtistaService($app->make(ArtistaRepository::class));
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
