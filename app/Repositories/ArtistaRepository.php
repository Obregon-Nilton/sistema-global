<?php
namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Artista;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArtistaRepository implements CrudInterface{
    protected Artista $model;

    public function __construct(Artista $model)
    {
        $this->model = $model;
    }

    public function agregar(array $datos): Artista
    {
        return $this->model
            ->create($datos);
    }

    public function ver(int $id): ?Artista
    {
        return $this->model
            ->find($id);
    }

    public function editar(int $id, array $datos): ?Artista
    {
        $artista = $this->ver($id);
        if(!$artista) return null;
        $artista->update($datos);
        return $artista;
    }

    public function eliminar(int $id): bool
    {
        $artista = $this->ver($id);
        return $artista ? (bool) $artista
            ->delete() : false;
    }

    public function listar(): LengthAwarePaginator
    {
        return $this->model
            ->orderBy('nombre', 'asc')
            ->paginate(config('pagination.per_page'));
    }

    public function buscar(string $busqueda): LengthAwarePaginator
    {
        return $this->model
            ->where(function ($q) use ($busqueda){
                $q->where('nombre', 'like', "%{$busqueda}%")
                  ->orWhere('nacionalidad', 'like', "%{$busqueda}%");
            })
            ->paginate(config('pagination.per_page'));
    }

}
