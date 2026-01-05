<?php

namespace App\Http\Controllers;

use App\Services\PersonaService;

class PersonaController extends Controller
{
    protected $service;

    public function __construct(PersonaService $service){
        $this->service = $service;
    }

    // public function buscadorGeneral($dato){
    //     $data = $this->service->buscadorGlobal($dato);
    //     return response()->json(['success' => true, 'data' => $data]);
    // }
}
