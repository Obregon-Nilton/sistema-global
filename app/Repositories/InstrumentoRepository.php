<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Instrumento;
use Illuminate\Pagination\LengthAwarePaginator;

class InstrumentoRepository implements CrudInterface
{
    protected Instrumento $model;

    public function __construct(Instrumento $model)
    {
        $this->model = $model;
    }

    public function agregar(array $datos): Instrumento
    {
        return $this->model
            ->create($datos);
    }

    public function ver(int $idInstrumento): ?Instrumento
    {
        return $this->model
            ->find($idInstrumento);
    }

    public function editar(int $idInstrumento, array $datos): ?Instrumento
    {
        $instrumento = $this
            ->ver($idInstrumento);
        if(!$instrumento){
            return null;
        }
        $instrumento->update($datos);
        return $instrumento;
    }

    public function eliminar(int $idInstrumento): bool
    {
        $instrumento = $this->ver($idInstrumento);
        return $instrumento ? (bool) $instrumento
            ->delete() : false;
    }

    public function listar(): LengthAwarePaginator
    {
        return $this->model
            ->orderBy("instrumento", "asc")
            ->paginate(config('pagination.per_page'));
    }
}
