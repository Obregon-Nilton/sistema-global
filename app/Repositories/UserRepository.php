<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements CrudInterface{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function agregar(array $datos): User
    {
        return $this->model->create([
            'email' => $datos['email'],
            'password' => $datos['password'],
            'persona_id' => $datos['persona_id'],
        ]);
    }

    public function ver(int $id): ?User
    {
        return $this->model
            ->with('persona.rol')
            ->find($id);
    }

    public function editar(int $id, array $datos): ?User
    {
        $usuario = $this->ver($id);
        if(!$usuario) return null;
        $usuario->update($datos);
        return $usuario;
    }

    public function eliminar(int $id): bool
    {
        $usuario = $this->ver($id);
        return $usuario ? (bool) $usuario
            ->delete() : false;
    }

    public function listar(): LengthAwarePaginator
    {
        return $this->model
            ->with('persona.rol')
            ->orderBy('id_user', 'desc')
            ->paginate(config('pagination.per_page'));
    }

}
