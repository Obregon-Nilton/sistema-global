<?php
/**
 * Se declaran metdos staticos
 * Para evitar repetir misma logica
 * Podemos usar directamente sin instaciar
 * Para cambios a futuro
 */
namespace App\Utils;

use DomainException;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

final class Utilidad{

    private function __construct(){}

    public static function validarId(mixed $id): int
    {
        if(!is_numeric($id) || empty($id)){
            throw new DomainException("El ID es invalido");
        }
        return (int) $id;
    }

    public static function validator($datos, $reglas, $mensajes, $mayuscula = true): array
    {
         $validator = Validator::make($datos, $reglas, $mensajes);
         if($validator->fails()){
            throw new ValidationException($validator);
         }
         $resultado = $validator->validated();
         return $mayuscula ? Helper::mayuscula($resultado) : $resultado;
    }

    public static function buscadorIndividual($dato): ?string
    {
        if(!$dato) return null;
        return mb_strtolower((string) $dato, 'UTF-8');

    }

    public function validarAtributos(array $datos){ // aun no esta siendo usado, no se considera
        foreach($datos as &$dato){
            if(is_null($dato)){
                throw new DomainException("El campo no puede ir vacio");
            }
        }
        return $datos;
    }

}
