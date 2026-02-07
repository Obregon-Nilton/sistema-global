<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstrumentoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_instrumento' => $this->id_instrumento,
            'instrumento' => $this->instrumento,
            'nivel' => $this->nivel,
            'categoria' => $this->categoria
        ];
    }
}
