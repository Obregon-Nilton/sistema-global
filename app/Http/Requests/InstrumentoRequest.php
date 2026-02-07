<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstrumentoRequest extends FormRequest
{
    public function authorize(): bool{
        return true;
    }

    public function rules(): array
    {
        $idInstrumento = $this->route('idInstrumento');
        $reglaInstrumento = "required|string|min:3|max:50|unique:instrumentos,instrumento";
        if($idInstrumento){
            $reglaInstrumento .= ",$idInstrumento,id_instrumento";
        }
        return [
            'instrumento' => $reglaInstrumento,
            'nivel' => 'required',
            'categoria' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'instrumento.required' => 'No se permite instrumento vacío',
            'instrumento.string' => 'El campo instrumento debe contener solo letras',
            'instrumento.min' => 'El instrumento debe tener al menos 3 caracteres',
            'instrumento.max' => 'El instrumento no puede superar los 50 caracteres',
            'instrumento.unique' => 'El instrumento ingresado ya está registrado',

            'nivel.required' => 'No se permite nivel vacío',

            'categoria.required' => 'No se permite categoria vacío'
        ];
    }
}
