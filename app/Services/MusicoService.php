<?php
namespace App\Services;

use App\Models\Musico;
use App\Repositories\MusicoRepository;
use Illuminate\Support\Facades\DB;
use App\Utils\Utilidad;
use DomainException;
use Illuminate\Pagination\LengthAwarePaginator;

class MusicoService{
    protected MusicoRepository $repository;
    protected PersonaService $personaServi;

    public function __construct(MusicoRepository $repository, PersonaService $personaServi)
    {
        $this->repository = $repository;
        $this->personaServi = $personaServi;
    }

    public function validarIdMusico(int $idMusico): Musico
    {
        $id = Utilidad::validarId($idMusico);
        $musico = $this->repository->ver($id);
        if(!$musico){
            throw new DomainException("No existe el Músico");
        }
        return $musico;
    }

    public function agregarMusic(array $datos): Musico
    {
        return DB::transaction(function() use($datos){
            $datos['rol_id'] = $this->personaServi->obtenerIdRol("MUSICOS");
            $personaActual = $this->personaServi->agregarPersona($datos);

            $datos['persona_id'] = $personaActual->id_persona;
            return $this->repository->agregar($datos);
        });
    }

    public function editarMusic(int $id, array $datos): Musico
    {
        return DB::transaction(function() use($id, $datos){
            $musico = $this->validarIdMusico($id);
            $persona = $this->personaServi->validarIdPersona($musico->persona_id);
            $this->personaServi->editarPersona($persona->id_persona, $datos);

            return $this->validarIdMusico($id);
        });
    }

    public function verMusic(int $idMusico): Musico
    {
        return $this->validarIdMusico($idMusico);
    }

    public function eliminarMusic(int $idMusico): bool
    {
        $musico = $this->validarIdMusico($idMusico);
        return $this->personaServi
            ->eliminarPersona($musico->persona_id);
    }

    public function listarMusic(): LengthAwarePaginator
    {
        return $this->repository->listar();
    }

    public function buscadorGlobal(?string $dato): LengthAwarePaginator
    {
        $data = Utilidad::buscadorIndividual($dato);
        return $this->repository->buscadorGlobal($data);
    }

    public function clasificarEdad(bool $esMayor): LengthAwarePaginator
    {
    return $this->repository->mostrarPorEdad($esMayor);
}



}
