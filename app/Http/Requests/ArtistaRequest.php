<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtistaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // id_artista desde la ruta (null cuando es crear)
        $idArtista = $this->route('artista');

        $reglaNombre = 'required|string|min:3|max:100|unique:artistas,nombre';

        // Si es edición, ignorar su propio registro
        if ($idArtista) {
            $reglaNombre .= ",$idArtista,id_artista";
        }

        return [
            'nombre' => $reglaNombre,
            'nacionalidad' => 'required|string|min:3|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'No se permite nombre vacío',
            'nombre.string' => 'El campo nombre debe contener solo letras',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres',
            'nombre.unique' => 'El artista ingresado ya está registrado',

            'nacionalidad.required' => 'No se permite nacionalidad vacía',
            'nacionalidad.string' => 'El campo nacionalidad debe contener solo letras',
            'nacionalidad.min' => 'La nacionalidad debe tener al menos 3 caracteres',
            'nacionalidad.max' => 'La nacionalidad no puede superar los 50 caracteres',
        ];
    }
}
