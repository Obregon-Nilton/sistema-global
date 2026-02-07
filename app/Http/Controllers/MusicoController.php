<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaRequest;
use App\Http\Resources\MusicoResource;
use App\Services\MusicoService;
use Illuminate\Http\Request;

class MusicoController extends Controller
{
    protected MusicoService $service;

    public function __construct(MusicoService $service){
        $this->service = $service;
    }

    public function agregarMusico(PersonaRequest $request)
    {
        $musico = $this->service->agregarMusic($request->only([
            'nombre', 'apellido', 'dni', 'telefono', 'fecha_nacimiento']));
        return MusicoResource::make($musico)
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(201);
    }

    public function editarMusico(int $id, PersonaRequest $request){
        $musico = $this->service->editarMusic($id, $request->only([
            'nombre', 'apellido', 'dni', 'telefono', 'fecha_nacimiento']));
        return MusicoResource::make($musico)
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(200);
    }

    public function verMusico(int $id){
        $musico = $this->service->verMusic($id);
        return MusicoResource::make($musico)
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(200);
    }

    public function eliminarMusico(int $id){
        $this->service->eliminarMusic($id);
        return response()->json(['success' => true]);
    }

    public function listarMusicos(){
        $musicos = $this->service->listarMusic();
        return MusicoResource::collection($musicos)
            ->additional(['success' => true])
            ->response();
    }

    public function buscadorGlobal(?string $dato){
        $data = $this->service->buscadorGlobal($dato);
        return MusicoResource::collection($data)
            ->additional(['success' => true])
            ->response();
    }

    public function mostrarPorEdad(Request $request){ /** filtros, consultas, GETs simples. */
        $valor = $request->query('mostrarPorEdad');//es el name de html en select
       if ($valor === "" || $valor === null) {
           $datos = $this->service->listarMusic();
       } else {
           $esMayor = $valor == "1"; // si el valor es 1 se guarda true caso contrario false
           $datos = $this->service->clasificarEdad($esMayor);
        }
        return MusicoResource::collection($datos)
            ->additional(['success' => true])
            ->response();
    }

    public function index(){
        return view('pages.musica.musicos');
    }
}
