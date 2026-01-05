<?php
/**
 * Transforma los datos antes de enviar al front
 * selecciona que atributos de modelo se usara
 * formatea, renombra o agrega informacion derivada de los modelos
 * aplica despues de controller solo para salida
 * No validacion de datos, logica de negocio, consulta sql
 * No manejo de HTTP, JSON, response, redireccion
 */
namespace App\Http\Resources;
//SALIDA DE BACKEND
//Resource es la capa donde configuras qué datos viajan antes de salir
//Se aplica después del Controller
//El dato que ENTRA desde afuera NO pasa por el Resource.
//El Resource SOLO se usa para la SALIDA.

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotaMusicalResource extends JsonResource //tiene metodos statics
{

    public function toArray(Request $request): array //request de  salida
    {
        /**
         * El Model / Service pueden tener 100 cosas…
         * pero el frontend solo recibe lo que el Resource devuelve.
        */
        return [
            'id' => $this->id_nota,
            'nota' => $this->nota,
            'tipo' => $this->tipo,
            'nota_formateada' => $this->nota_formateada, /**Agregamos Exk el Resource decide QUÉ ve el frontend */
        ];
    }
}
