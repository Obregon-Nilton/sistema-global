<?php
namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Artista;

class ArtistaRepository implements CrudInterface{
    protected $model;

    public function __construct(Artista $model){
        $this->model = $model;
    }

    public function agregar(array $datos){
        return $this->model->create($datos);
    }

    public function ver($id){
        return $this->model->find($id);
    }

    public function editar($id, array $datos){
        $artista = $this->ver($id);
        if($artista){
            $artista->update($datos);
            return $artista;
        }
        return false;
    }

    public function eliminar($id){
        $artista = $this->ver($id);
        return $artista ? $artista->delete() : false;
    }

    public function listar(){
        return $this->model->get();
    }
}
