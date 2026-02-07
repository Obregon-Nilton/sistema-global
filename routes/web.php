<?php

use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Inicio;
use App\Http\Controllers\InstrumentoController;
use App\Http\Controllers\MusicoController;
use App\Http\Controllers\NotaMusicalController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
| Solo login y registro
|--------------------------------------------------------------------------
*/

// Raíz → SIEMPRE al login (profesional)
Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| AUTH WEB
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [LoginController::class, 'mostrarFormulario'])
    ->name('login');

Route::post('/login', [LoginController::class, 'iniciarSesion'])
    ->name('login.procesar');

// Registro
Route::get('/register', [RegisterController::class, 'mostrarFormulario'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'registrar'])
    ->name('register.procesar');

// Logout
Route::post('/logout', [LoginController::class, 'cerrarSesion'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (REQUIEREN LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::prefix('inicio')->name('inicio.')->group(function () {

        Route::get('/', [Inicio::class, 'index'])
            ->name('index');
    });

    /*
    |--------------------------------------------------------------------------
    | VISTAS DEL SISTEMA
    |--------------------------------------------------------------------------
    | SOLO vistas
    | Los datos vienen desde /api
    |--------------------------------------------------------------------------
    */

    Route::get('/roles', [RolController::class, 'index'])
        ->name('roles.index');

    Route::get('/usuarios', [UserController::class, 'index'])
        ->name('usuarios.index');

    Route::get('/musicos', [MusicoController::class, 'index'])
        ->name('musicos.index');

    Route::get('/notasMusicales', [NotaMusicalController::class, 'index'])
        ->name('notasMusicales.index');

    Route::get('/artistas', [ArtistaController::class, 'index'])
        ->name('artistas.index');

    Route::get('/instrumentos', [InstrumentoController::class, 'index'])
       ->name('instrumentos.index');
});
