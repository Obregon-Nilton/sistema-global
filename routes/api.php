<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\MusicoController;
use App\Http\Controllers\NotaMusicalController;
use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InstrumentoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API AUTHENTICATION
|--------------------------------------------------------------------------
| Rutas públicas de autenticación.
| NO llevan middleware porque aún no hay sesión iniciada.
| Prefijo final: /api/auth
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {

    // Iniciar sesión (login)
    Route::post('/login', [AuthController::class, 'iniciarSesion']);

    Route::post('/register', [RegisterController::class, 'registrar']);

    // Cerrar sesión (logout)
    Route::post('/logout', [AuthController::class, 'cerrarSesion']);

    // Obtener usuario autenticado (útil para frontend)
    Route::get('/usuario', [AuthController::class, 'usuarioAutenticado']);

});

/*
|--------------------------------------------------------------------------
| API SISTEMA GLOBAL (PROTEGIDO)
|--------------------------------------------------------------------------
| TODAS estas rutas requieren sesión activa.
| Middleware auth:web valida que el usuario esté logueado.
| Si no hay sesión → Laravel responde 401 automáticamente.
| Prefijo final: /api/inicio
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth:web'])->prefix('inicio')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | SISTEMA ROL
    |--------------------------------------------------------------------------
    */
    Route::prefix('roles')->group(function () {
        Route::get('/listar', [RolController::class, 'listarRoles']);
        Route::get('/buscar/{nombre}', [RolController::class, 'buscarPorNombre']);
        Route::get('/ver/{id}', [RolController::class, 'verRol']);
        Route::post('/agregar', [RolController::class, 'agregarRol']);
        Route::put('/editar/{id}', [RolController::class, 'editarRol']);
        Route::delete('/eliminar/{id}', [RolController::class, 'eliminarRol']);
    });

    /*
    |--------------------------------------------------------------------------
    | login USERS
    |--------------------------------------------------------------------------
    */
    Route::prefix('usuarios')->group(function(){
        Route::get('/listar', [UserController::class, 'listarUsers']);
        Route::get('/ver/{usuario}', [UserController::class, 'verUser']);
        Route::post('/agregar', [UserController::class, 'agregarUser']);
        Route::put('/editar/{idUser}', [UserController::class, 'editarUser']);
        Route::delete('/eliminar/{idUser}', [UserController::class, 'eliminarUser']);
    });
    /*
    |--------------------------------------------------------------------------
    | SISTEMA MUSICAL
    |--------------------------------------------------------------------------
    */
    Route::prefix('musicos')->group(function () {
        Route::get('/listar', [MusicoController::class, 'listarMusicos']);
        Route::get('/ver/{idMusico}', [MusicoController::class, 'verMusico']);
        Route::get('/buscar/{dato}', [MusicoController::class, 'buscadorGlobal']);
        Route::get('/filtrarPorEdad', [MusicoController::class, 'mostrarPorEdad']);
        Route::post('/agregar', [MusicoController::class, 'agregarMusico']);
        Route::put('/editar/{musico}', [MusicoController::class, 'editarMusico']);
        Route::delete('/eliminar/{id_persona}', [MusicoController::class, 'eliminarMusico']);
    });

    /*
    |--------------------------------------------------------------------------
    | SISTEMA NOTAS MUSICALES
    |--------------------------------------------------------------------------
    */
    Route::prefix('notasMusicales')->group(function () {
        Route::get('/listar', [NotaMusicalController::class, 'listarNotasMusicales']);
        Route::get('/ver/{id}', [NotaMusicalController::class, 'verNotaMusical']);
        Route::get('/buscar/{dato}', [NotaMusicalController::class, 'buscarNota']);
        Route::post('/agregar', [NotaMusicalController::class, 'agregarNotaMusical']);
        Route::put('/editar/{id}', [NotaMusicalController::class, 'editarNotaMusical']);
        Route::delete('/eliminar/{id}', [NotaMusicalController::class, 'eliminarNotaMusical']);
    });

    /*
    |--------------------------------------------------------------------------
    | SISTEMA ARTISTAS
    |--------------------------------------------------------------------------
    */
    Route::prefix('artistas')->group(function () {
        Route::get('/listar', [ArtistaController::class, 'listarArtistas']);
        Route::get('/ver/{artista}', [ArtistaController::class, 'verArtista']);
        Route::get('/buscar/{dato}', [ArtistaController::class, 'buscarArtista']);
        Route::post('/agregar', [ArtistaController::class, 'agregarArtista']);
        Route::put('/editar/{artista}', [ArtistaController::class, 'editarArtista']);
        Route::delete('/eliminar/{id}', [ArtistaController::class, 'eliminarArtista']);
    });

    Route::prefix('instrumentos')->group(function(){
       Route::get('/listar', [InstrumentoController::class, 'listarInstrumentos']);
       Route::get('/ver/{idInstrumento}', [InstrumentoController::class, 'verInstrumento']);
       Route::put('/editar/{idInstrumento}', [InstrumentoController::class, 'editarInstrumento']);
       Route::post('/agregar', [InstrumentoController::class, 'agregarInstrumento']);
       Route::delete('/eliminar/{idInstrumento}', [InstrumentoController::class, 'eliminarInstrumento']);
    });

    /*
    |--------------------------------------------------------------------------
    | SISTEMA INVENTARIO
    |--------------------------------------------------------------------------
    | Futuro módulo (misma estructura que música)
    */
    Route::prefix('inventario')->group(function () {
        // aquí irán instrumentos, categorías, stock, etc.
    });

});

Route::prefix('prueba')->group(function(){
//Aca es donde se hacen las pruebas de APIS en POSTMAN, asi para no complicarnos con login en POSTMAN
});
