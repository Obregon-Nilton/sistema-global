<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Utils\Utilidad;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService{
    protected UserRepository $repository;
    protected PersonaService $personaServi;

    public function __construct(UserRepository $repository, PersonaService $personaServi)
    {
        $this->repository = $repository;
        $this->personaServi = $personaServi;
    }

    public function validarIdUser(int $idUser): User
    {
        $id = Utilidad::validarId($idUser);
        $user = $this->repository->ver($id);
        if(!$user){
            throw new DomainException("No existe el usuario");
        }
        return $user;
    }

    public function agregarUser(array $datos): User
    {
        return DB::transaction(function() use ($datos){
            $datos['rol_id'] = $this->personaServi->obtenerIdRol("USUARIOS");
            $personaActual = $this->personaServi
                ->agregarPersona($datos);

            $datos['persona_id'] = $personaActual->id_persona;
            return $this->repository
                ->agregar($datos);
        });
    }

    public function editarUser(int $idUser, array $datos): User
    {
        return DB::transaction(function() use ($datos, $idUser){
            $user = $this->validarIdUser($idUser);
            $this->personaServi->editarPersona($user->persona_id, $datos);

            return $this->repository->editar($user->id_user, $datos);
        });
    }

    public function verUser(int $idUser): User
    {
        return $this->validarIdUser($idUser);
    }

    public function eliminarUser(int $idUser):bool
    {
        $usuario = $this->validarIdUser($idUser);
        return $this->personaServi
            ->eliminarPersona($usuario->persona_id);
    }

    public function listarUsers(): LengthAwarePaginator
    {
        return $this->repository->listar();
    }
}
