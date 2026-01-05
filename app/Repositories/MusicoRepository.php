<?php
namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Musico;
use Illuminate\Pagination\LengthAwarePaginator;

class MusicoRepository implements CrudInterface{
    protected Musico $model;

    public function __construct(Musico $model){
        $this->model = $model;
    }

    public function agregar(array $datos): Musico
    {
        return $this->model
            ->create($datos);
    }

    public function ver($id): ?Musico
    {
        return $this->model
           ->with('persona.rol')
           ->find($id);
    }

    public function editar($id, array $datos): ?Musico
    {
        $musico = $this->ver($id);
        if(!$musico) return null;
        $musico->update($datos);
        return $musico;
    }

    public function eliminar($id): bool
    {
        $musico = $this->ver($id);
        return $musico ? (bool) $musico->delete() : false;
    }

    public function listar(): LengthAwarePaginator
    {
        return $this->model
           ->with('persona.rol')
           ->orderBy('id_musico', 'desc')
           ->paginate(config('pagination.per_page'));
    }

    public function buscadorGlobal(string $busqueda): LengthAwarePaginator
    {
        return $this->model
            ->with('persona.rol')
            /**where = Se usa cuando la columna pertenece a la MISMA entidad (tabla). */
            /**Cuando mezclas where con orWhere, DEBES agrupar, eso se hace con function anonima */
            ->whereHas('persona', function ($q) use ($busqueda) { /** use pasar dato externo al interno */
                $q->where('nombre', 'like', "%{$busqueda}%")
                     ->orWhere('apellido', 'like', "%{$busqueda}%")
                     ->orWhere('dni', 'like', "%{$busqueda}%")
                     ->orWhere('telefono', 'like', "%{$busqueda}%");
            })
            ->paginate(config('pagination.per_page'));
    }


    public function mostrarPorEdad(bool $esMayor = true): LengthAwarePaginator
    {
        return $this->model
            ->with('persona')
            /** whereHas = Se usa cuando la columna pertenece a OTRA entidad relacionada, (especifica la tabla)*/
            ->whereHas('persona', fn ($q) => $q->porEdad($esMayor)) //scope del model Persona
            ->orderByDesc('id_musico')
            ->paginate(config('pagination.per_page'));
    }

}
