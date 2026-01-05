<?php
namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Rol;

class RolRepository implements CrudInterface{
    protected $model;

    public function __construct(Rol $model){
        $this->model = $model;
    }

    public function agregar(array $datos){
        return $this->model->create($datos);
    }

    public function ver($id)
    {
        return $this->model->with('personas')->find($id);
    }

    public function editar($id, array $datos)
    {
        $rol = $this->ver($id);
        if($rol){
            $rol->update($datos);
            return $rol;
        }
        return false;
    }

    public function eliminar($id)
    {
        $rol = $this->ver($id);
        return $rol ? $rol->delete() : false;
    }

    public function listar(){
        return $this->model->with('personas')
           ->orderBy('id_rol','desc')
           ->get();
    }

    public function buscar($nombre){
        return $this->model->where('nombre','LIKE', "%$nombre%")->get();
    }

    //select id_rol from rols where nombre = 'MUSICOS';
    public function obtenerIdRol($nombreRol){
        return $this->model
           ->where('nombre', $nombreRol)
           ->value('id_rol');
    }


}


