<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArtistaRequest;
use App\Http\Resources\ArtistaResource;
use App\Services\ArtistaService;
class ArtistaController extends Controller
{
    protected ArtistaService $service;

    public function __construct(ArtistaService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return view('pages.musica.artistas');
    }

    public function agregarArtista(ArtistaRequest $request)
    {
        $data = $this->service->agregarArtist(
            $request->only(['nombre', 'nacionalidad']));
        return ArtistaResource::make($data)
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(201);
    }

    public function editarArtista($id, ArtistaRequest $request)
    {
        $data = $this->service->editarArtist($id, $request
            ->only(['nombre', 'nacionalidad']));
        return ArtistaResource::make($data)
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(200);
    }

    public function verArtista($id){
        $artista = $this->service->verArtist($id);
        return ArtistaResource::make($artista)
            ->additional(['success', true])
            ->response();
    }

    public function listarArtistas(){
        $artistas = $this->service->listarArtists();
        return ArtistaResource::collection($artistas)
            ->additional(['success' => true])
            ->response();
    }

    public function buscarArtista($dato){
        $data = $this->service->buscarArtista($dato);
        return ArtistaResource::collection($data)
           ->additional(['success' => true])
           ->response();
    }

    public function eliminarArtista($id){
        $this->service->eliminarArtist($id);
        return response()->json(['success' => true]);
    }
}
