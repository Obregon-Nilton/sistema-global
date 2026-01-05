<?php

namespace App\Providers;

use App\Models\NotaMusical;
use App\Repositories\NotaMusicalRepository;
use App\Services\NotaMusicalService;
use Illuminate\Support\ServiceProvider;

class NotaMusicalProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(NotaMusicalRepository::class, function($app){
            return new NotaMusicalRepository($app->make(NotaMusical::class));
        });

        $this->app->singleton(NotaMusicalService::class, function($app){
            return new NotaMusicalService($app->make(NotaMusicalRepository::class));
        });
    }
}
