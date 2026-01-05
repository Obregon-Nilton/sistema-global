<?php

namespace App\Services;

use App\Models\Persona;
use App\Repositories\PersonaRepository;
use App\Repositories\RolRepository;
use App\Utils\Utilidad;
use DomainException;
use App\Helpers\Helper;

class PersonaService{
    protected PersonaRepository $repository;
    protected RolRepository $rolRepo;

    public function __construct(PersonaRepository $repository, RolRepository $rolRepo)
    {
        $this->repository = $repository;
        $this->rolRepo = $rolRepo;
    }

    public function validarIdPersona(int $idPersona): Persona
    {
        $id = Utilidad::validarId($idPersona);
        $persona = $this->repository->ver($id);
        if(!$persona){
            throw new DomainException("No existe la Persona");
        }
        return $persona;
    }

    public function obtenerIdRol(string $nombreRol): int
    {
        $idRol = $this->rolRepo->obtenerIdRol($nombreRol);
        if(!$idRol){
            throw new DomainException("El rol MUSICOS no existe en la base de datos");
        }
        return $idRol;
    }

    public function agregarPersona(array $datos): Persona
    {
        $data = Helper::mayuscula($datos);
        return $this->repository
            ->agregar($data);
    }

    public function editarPersona(int $idPersona, array $datos): Persona
    {
        $data = Helper::mayuscula($datos);
        return $this->repository
            ->editar($idPersona, $data);
    }

    public function eliminarPersona(int $idPersona): bool
    {
        return $this->repository
            ->eliminar($idPersona);
    }

}
