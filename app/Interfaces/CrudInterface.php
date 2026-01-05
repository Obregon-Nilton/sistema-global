<?php
namespace App\Interfaces;

interface CrudInterface{

    public function eliminar(int $id);

    public function ver(int $id);

    public function editar(int $id, array $datos);

}
