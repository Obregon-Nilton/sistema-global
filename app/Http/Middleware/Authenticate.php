<?php
/**
 * pa crear con todo carpeta y archivo a la vez
 * php artisan make:middleware Authenticate
 *
 * ORDEN DE CODIFICACION PARA LOGIN:
 * Authenticate
 * ↓
 * bootstrap
 * ↓
 * LoginController
 * ↓
 * RegisterController
 * ↓
 * AuthController
 */

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticos extends Middleware
{
    /**
     * Este metodo dice:
     * ¿A dónde mando al usuario cuando NO está logueado?
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        return route('login');
    }
}
