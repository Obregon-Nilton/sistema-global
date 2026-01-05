<?php

namespace App\Http\Controllers;

use App\Services\ArtistaService;
use Illuminate\Http\Request;

class ArtistaController extends Controller
{
    protected $service;

    public function __construct(ArtistaService $service){
        $this->service = $service;
    }

    public function index(){
        return view('pages.musica.artista');
    }

    public function agregarArtista(Request $request){
        $artista = $this->service->agregarArtist($request->only(['nombre', 'nacionalidad']));
        return response()->json(['success' => true, 'data' => $artista]);
    }

    public function editarArtista($idArtista, Request $request){
        $artista = $this->service->editarArtist($idArtista, $request->only(['nombre', 'nacionalidad']));
        return response()->json(['success' => true, 'data' => $artista]);
    }

    public function verArtista($idArtista){
        $artista = $this->service->verArtist($idArtista);
        return response()->json(['success' => true, 'data' => $artista]);
    }

    public function eliminarAtista($idArtista){
        $this->service->eliminarArtist($idArtista);
        return response()->json(['success' => true]);
    }

    public function listarArtistas(){
        $artistas = $this->service->listarArtists();
        return response()->json(['success' => true, 'data' => $artistas]);
    }

}
