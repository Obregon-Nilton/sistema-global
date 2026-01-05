<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Request;

class PersonaResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_persona,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'dni' => $this->dni,
            'telefono' => $this->telefono,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'rol_id' => $this->rol_id
        ];
    }
}
