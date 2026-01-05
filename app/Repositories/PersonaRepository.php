<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Persona;
use Illuminate\Pagination\LengthAwarePaginator;

class PersonaRepository implements CrudInterface{
    protected Persona $model;

    public function __construct(Persona $model){
        $this->model = $model;
    }

    public function agregar(array $datos): Persona
    {
        return $this->model
            ->create($datos);
    }

    public function ver(int $id): ?Persona
    {
        return $this->model
           ->with('rol', 'musico')
           ->find($id);
    }

    public function editar(int $id, array $datos): ?Persona
    {
         $musico = $this->ver($id);
         if(!$musico) return null;
         $musico->update($datos);
         return $musico;
    }

    public function eliminar(int $id): bool
    {
        $musico = $this->ver($id);
        return $musico ? (bool) $musico
           ->delete() : false;
    }

    public function listar(): LengthAwarePaginator
    {
        return $this->model
            ->with('rol', 'musico')
            ->paginate(config('pagination.per_page'));
    }

    //select * from personas where fecha_nacimiento
    //between '2000-12-12' and '2025-12-12';
    public function listarPorRangoFechaNacimiento($fechaInicio, $fechaFin){
        return $this->model
           ->whereBetween('fecha_nacimiento', [$fechaInicio, $fechaFin])
           ->get();
    }


}
