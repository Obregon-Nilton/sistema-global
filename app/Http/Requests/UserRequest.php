<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Obtener el ID del usuario desde la ruta
        $idUser = $this->route('usuario');

        // Inicializamos id_user
        $idUserReal = null;

        // Si es edición, buscamos el usuario
        if ($idUser) {
            $user = User::find($idUser);
            $idUserReal = $user ? $user->id_user : null;
        }

        // Regla para el email
        $reglaEmail = 'required|email|min:10|max:100|unique:users,email';
        if ($idUserReal) {
            $reglaEmail .= ",$idUserReal,id_user";
        }

        return [
            'email' => $reglaEmail,
            'password' => $this->route('usuario') /** */
                ? 'nullable|min:8|max:300' /**Si hay usuario en la ruta (editar) → la contraseña es opcional (nullable) */
                : 'required|min:8|max:300', /**Si NO hay usuario en la ruta (crear) → la contraseña es obligatoria (required) */
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'No se permite Email vacío',
            'email.email' => 'Ingrese un Email válido',
            'email.unique' => 'El usuario ya existe',
            'email.min' => 'Su Email debe tener al menos 10 caracteres',
            'email.max' => 'Su Email no puede superar los 100 caracteres',

            'password.required' => 'No se permite contraseña vacía',
            'password.min' => 'Su contraseña debe tener al menos 8 caracteres',
            'password.max' => 'Su contraseña no puede superar los 300 caracteres',
        ];
    }
}
