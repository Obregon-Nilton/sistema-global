<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Musico;

class PersonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Obtener el ID del musico desde la ruta (puede ser null si es agregar)
        $idMusico = $this->route('musico');

        // Inicializamos persona_id
        $idPersona = null;

        // Si es edición, buscamos el musico y su persona_id
        if ($idMusico) {
            $musico = Musico::find($idMusico);
            $idPersona = $musico ? $musico->persona_id : null;
        }

        // Regla para el DNI
        $reglaDni = 'required|min:8|max:10|unique:personas,dni';
        if ($idPersona) {
            $reglaDni .= ",$idPersona,id_persona";
        }

        return [
            'nombre' => 'required|string|min:3|max:100',
            'apellido' => 'required|string|min:3|max:100',
            'dni' => $reglaDni,
            'telefono' => 'nullable|min:9|max:15',
            'fecha_nacimiento' => 'required|date|before:today',
            'mostrarPorEdad' => 'nullable|in:0,1'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'No se permite nombre vacío',
            'nombre.string' => 'El campo nombre debe contener solo letras',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres',

            'apellido.required' => 'No se permite apellido vacío',
            'apellido.string' => 'El campo apellido debe contener solo letras',
            'apellido.min' => 'El apellido debe tener al menos 3 caracteres',
            'apellido.max' => 'El apellido no puede superar los 100 caracteres',

            'dni.required' => 'No se permite DNI vacío',
            'dni.unique' => 'El DNI ingresado ya está registrado',
            'dni.min' => 'El DNI debe tener al menos 8 dígitos',
            'dni.max' => 'El DNI no puede superar los 10 dígitos',

            'telefono.min' => 'El teléfono debe tener al menos 9 dígitos',
            'telefono.max' => 'El teléfono no puede superar los 15 dígitos',

            'fecha_nacimiento.required' => 'No se permite fecha de nacimiento vacía',
            'fecha_nacimiento.date' => 'Ingrese una fecha válida',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy',

            'mostrarPorEdad.in' => 'El valor de mostrarPorEdad no es válido. Solo se permite 0 o 1.'
        ];
    }
}
