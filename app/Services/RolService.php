<?php

namespace App\Services;

use App\Repositories\RolRepository;
use App\Utils\Utilidad;
use DomainException;

class RolService{
    protected $repository;

    public function __construct(RolRepository $repository){
        $this->repository = $repository;
    }

    public function validarIdRol($idRol){
        $id = Utilidad::validarId($idRol);
        if(!$id){
            throw new DomainException("No existe el Rol");
        }
        return $this->repository->ver($id);
    }

    public function validarDatosRol(array $datosRol){
        $reglas = ['nombre' => 'required|string|min:3|max:80|unique:rols,nombre'];

        $mensajes = [
            'nombre.required' => 'El campo Rol, no puede ir vacío',
            'nombre.string' => 'En el campo Rol, solo se permite letras',
            'nombre.min' => 'El campo Rol, mínimo debe de tener 3 caracteres',
            'nombre.max' => 'El campo Rol, maxímo debe de tener 80 caracteres',
            'nombre.unique' => 'El Rol que ingresaste ya exíste, ingrese un Rol nuevo'
        ];
        return Utilidad::validator($datosRol, $reglas, $mensajes, true);
    }

    public function agregarRole($datos){
        $rol = $this->validarDatosRol($datos);
        return $this->repository->agregar($rol);
    }

    public function editarRole($id, $datos){
        $rol = $this->validarIdRol($id);
        $datos = $this->validarDatosRol($datos);
        return $this->repository->editar($rol->id_rol, $datos);
    }

    public function verRole($id){
        return $this->validarIdRol($id);
    }

    public function eliminarRole($id){
        $rol = $this->validarIdRol($id);
        return $this->repository->eliminar($rol->id_rol);
    }

    public function listarRole(){
        return $this->repository->listar();
    }

    public function buscarRole($nombre){
        $dato = Utilidad::buscadorIndividual($nombre);
        return $this->repository->buscar($dato);
    }

}
