<?php
/**
 * Valida datos de entrada
 * Define reglas de validacion
 * personaliza mensajes de error
 * autoriza si el usuario puede hacer peticion
 * td eso ocurre antes de llega a controller
 * No hay reglas de negocio, llamada de repository, models,
 * manejo de HTTP, JSON, redireccion, responses, logica de front, casting
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaMusicalRequest extends FormRequest{

    /** Sirve para decidir si el usuario puede usar este request, ose
     * cualquier usuario puede enviar datos
    */
    public function authorize(): bool
    {
        return true;
    }

    /** reglas de validación */
    public function rules(): array
    {
        return [
            'nota' =>  'required|string|min:2|max:5',
            'tipo' => 'required|in:natural,sostenido,bemol'
        ];
    }

    /** Mensajes de error */
    public function messages(): array
    {
        return [
            'nota.required' => 'No se permite nota vacía',
            'nota.string' => 'El campo nota debe contener solo letras',
            'nota.min' => 'La nota debe de tener almenos 2 caracteres',

            'nota.max' => 'La nota no puede superar los 5 caracteres',
            
            'tipo.required' => 'No se permite vacio en el campo tipo',
            'tipo.in' => 'El tipo seleccionado no es válido'
        ];
    }
}
