<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Request;

class MusicoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_musico' => $this->id_musico,
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
