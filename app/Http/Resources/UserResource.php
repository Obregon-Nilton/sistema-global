<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id_user' => $this->id_user,
            'email' => $this->email,
            'persona' => [
                'id' => $this->persona->id_persona,
                'nombre' => $this->persona->nombre,
                'apellido' => $this->persona->apellido,
                'dni' => $this->persona->dni,
                'telefono' => $this->persona->telefono,
                'fecha_nacimiento' => $this->persona->fecha_nacimiento,
                'rol_id' => $this->persona->rol_id
            ]
        ];
    }
}
