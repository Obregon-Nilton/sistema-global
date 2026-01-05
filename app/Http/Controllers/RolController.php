<?php

namespace App\Http\Controllers;

use App\Services\RolService;
use Illuminate\Http\Request;

class RolController extends Controller
{
    protected $service;

    public function __construct(RolService $service){
        $this->service = $service;
    }

    public function index(){
        return view('pages.roles');
    }

    public function agregarRol(Request $request){
        $rol = $this->service->agregarRole($request->only(['nombre']));
        return response()->json(['success' => true, 'data' => $rol]);
    }

    public function editarRol($id, Request $request){
        $rol = $this->service->editarRole($id, $request->only(['nombre']));
        return response()->json(['success' => true, 'data' => $rol]);
    }

    public function buscarPorNombre($nombre){
        $resultado = $this->service->buscarRole($nombre);
        return response()->json(['success' => true, 'data' => $resultado]);
    }

    public function verRol($id){
        $rol = $this->service->verRole($id);
        return response()->json(['success' => true, 'data' => $rol]);
    }

    public function eliminarRol($id){
        $this->service->eliminarRole($id);
        return response()->json(['success' => true]);
    }

    public function listarRoles(){
        $roles = $this->service->listarRole();
        return response()->json(['success' => true, 'data' => $roles]);
    }

}
