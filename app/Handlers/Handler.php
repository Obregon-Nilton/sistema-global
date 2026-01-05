<?php
/**
 * Centraliza el manejo de excepciones y errores de la aplicación
 * transformar Exceptios en respuesdta adecuada (JSON,  HTTP, logs, etc)
 * Centraliza el manejo de excepciones y errores de la aplicación
 * Excepciones de negocio (DomainException, custom exceptions)
 * Excepciones de validación
 * No va logica de negocio, acceso a BDD, manipulacion de vista
 */

/**
 * Si el Service falla osea lanza la excepción, ya no entra a controller
 * sino entra en Handler luego la recibe y la envía al front como JSON.
 * y ahi se ve como mensaje dinamico, y si service no falla entra directo a controller.
 * */
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use DomainException;
use Exception;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * el método ya existe en la clase padre, tú lo reemplazas con tu versión
     * personalizada para decirle a Laravel cómo manejar cada tipo de excepción.
     */
    public function register(): void 
    {
        /** ocurre cuando los datos que envía el usuario no cumplen reglas básicas, nombre vacio */
        $this->renderable(function (ValidationException $e) {
            Log::warning('ValidationException: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        });

        /** falla de negocio en el Service, crear notaMusical que ya existe */
        $this->renderable(function (DomainException $e) {
            Log::info('DomainException: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        });

        /** Errores inesperados, la BDD se cayó, etc */
        $this->renderable(function (Exception $e) {
            Log::error('Unexpected Exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        });
    }
}
