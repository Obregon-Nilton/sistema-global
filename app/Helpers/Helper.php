<?php
/**
 * Son pequeñas herramientas
 * Formatear textos
 * Formatear fechas o numeros
 * Generar string o ides rapidos
 * funciones matematias simples
 */
 namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

 final class Helper{

    public static function mayuscula(mixed $datos): mixed
    {
        /**Si es model Eloquent */
        if($datos instanceof Model){
            foreach($datos->getAttributes() as $key => $valor){
                if(is_string($valor)){
                    $datos->$key = mb_strtoupper($valor, 'UTF-8');
                }
            }
            return $datos;
        }

        /** Si es un array */
        if(is_array($datos)){
            foreach($datos as $key => $valor){
                $datos[$key] = self::mayuscula($valor);
            }
            return $datos;
        }

        /** Si es string */
        if(is_string($datos)){
            return mb_strtoupper($datos, 'UTF-8');
        }
        return $datos;
    }

 }
