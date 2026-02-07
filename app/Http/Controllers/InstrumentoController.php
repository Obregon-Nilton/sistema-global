<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstrumentoRequest;
use App\Http\Resources\InstrumentoResource;
use App\Services\InstrumentoService;

class InstrumentoController extends Controller
{
    protected InstrumentoService $service;

    public function __construct(InstrumentoService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return view('pages.musica.instrumentos');
    }

    public function agregarInstrumento(InstrumentoRequest $request){
        $data = $this->service->agregarInstrumento(
            $request->only(['instrumento', 'nivel', 'categoria']));
        return InstrumentoResource::make($data)
           ->additional(['success' => true])
           ->response()
           ->setStatusCode(201);
    }

    public function editarInstrumento($id, InstrumentoRequest $request)
    {
        $data = $this->service->editarInstrumento($id, $request
           ->only(['instrumento', 'nivel', 'categoria']));
        return InstrumentoResource::make($data)
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(200);
    }

    public function verInstrumento($idInstrumento){
        $data = $this->service->verInstrumento($idInstrumento);
        return InstrumentoResource::make($data)
            ->additional(['success' => true])
            ->response();
    }

    public function listarInstrumentos(){
        $instrumentos = $this->service->listarInstrumentos();
        return InstrumentoResource::collection($instrumentos)
            ->additional(['success' => true])
            ->response();
    }

    public function eliminarInstrumento($idInstrumento){
        $this->service->eliminarInstrumento($idInstrumento);
        return response()->json(['success' => true]);
    }
}
