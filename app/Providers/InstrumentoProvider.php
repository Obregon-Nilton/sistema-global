<?php

namespace App\Providers;

use App\Models\Instrumento;
use App\Repositories\InstrumentoRepository;
use App\Services\InstrumentoService;
use Illuminate\Support\ServiceProvider;

class InstrumentoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(InstrumentoRepository::class, function($app){
            return new InstrumentoRepository($app->make(Instrumento::class));
        });

        $this->app->singleton(InstrumentoService::class, function($app){
            return new InstrumentoService($app->make(InstrumentoRepository::class));
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
