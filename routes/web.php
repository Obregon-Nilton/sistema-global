<?php

use App\Http\Controllers\Inicio;
use App\Http\Controllers\MusicoController;
use App\Http\Controllers\NotaMusicalController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\Welcome;
use Illuminate\Support\Facades\Route;

///rutas publicas
Route::get('/', [Welcome::class, 'welcome'])->name('welcome');
Route::get('/roles', [RolController::class, 'index'])->name('roles.index');//Roles
Route::get('/musicos', [MusicoController::class, 'index'])->name('musicos.index');//Musicos
Route::get('/notasMusicales', [NotaMusicalController::class, 'index'])->name('notasMusicales.index');


Route::prefix('inicio')->name('inicio.')->group(function(){//pagina de vienvenida
    Route::get('/', [Inicio::class, 'index'])->name('index');

    //-----------------------------------------SISTEMA ROL-----------------------------------------------------
    Route::prefix('roles')->name('roles.')->group(function(){//Entidad roles
        Route::get('/listar', [RolController::class, 'listarRoles'])->name('listar');
        Route::get('/buscar/{nombre}', [RolController::class, 'buscarPorNombre'])->name('buscar');
        Route::get('/ver/{id}', [RolController::class, 'verRol'])->name('ver');
        Route::post('/agregar', [RolController::class, 'agregarRol'])->name('agregar');
        Route::put('/editar/{id}', [RolController::class, 'editarRol'])->name('editar');
        Route::delete('/eliminar/{id}', [RolController::class, 'eliminarRol'])->name('eliminar');
    });

    //-----------------------------------------SISTEMA MUSICAL-----------------------------------------------------
    Route::prefix('musicos')->name('musicos.')->group(function(){//Entidad musicos
        Route::get('/listar', [MusicoController::class, 'listarMusicos'])->name('listar');
        Route::get('/ver/{idMusico}', [MusicoController::class, 'verMusico'])->name('ver');
        Route::get('/buscar/{dato}', [MusicoController::class, 'buscadorGlobal'])->name('buscar');
        Route::get('/filtrarPorEdad', [MusicoController::class, 'mostrarPorEdad'])->name('mostrarPorEdades');
        Route::post('/agregar', [MusicoController::class, 'agregarMusico'])->name('agregar');
        Route::put('/editar/{musico}', [MusicoController::class, 'editarMusico'])->name('editar');
        Route::delete('/eliminar/{id_persona}', [MusicoController::class, 'eliminarMusico'])->name('eliminar');
    });

    Route::prefix('notasMusicales')->name('notasMusicales.')->group(function(){
        Route::get('/listar', [NotaMusicalController::class, 'listarNotasMusicales'])->name('listar');
        Route::get('/ver/{id}', [NotaMusicalController::class, 'verNotaMusical'])->name('ver');
        Route::get('/buscar/{dato}', [NotaMusicalController::class, 'buscarNota'])->name('buscar');
        Route::post('/agregar', [NotaMusicalController::class, 'agregarNotaMusical'])->name('agregar');
        Route::put('/editar/{id}', [NotaMusicalController::class, 'editarNotaMusical'])->name('editar');
        Route::delete('/eliminar/{id}', [NotaMusicalController::class, 'eliminarNotaMusical'])->name('eliminar');
    });

    //-----------------------------------------SISTEMA INVENTARIO-----------------------------------------------------
    Route::prefix('imventario')->name('imventario.')->group(function(){ //Sistema inventario
        //la misma que musicas ebntidades y metodos
    });

});
