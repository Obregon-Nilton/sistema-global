<?php

namespace App\Providers;

use App\Models\Rol;
use App\Repositories\RolRepository;
use App\Services\RolService;
use Illuminate\Support\ServiceProvider;

class RolProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(RolRepository::class, function($app){
            return new RolRepository($app->make(Rol::class));
        });

        $this->app->singleton(RolService::class, function($app){
            return new RolService($app->make(RolRepository::class));
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
