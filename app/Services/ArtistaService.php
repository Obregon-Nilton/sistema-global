<?php

namespace App\Services;

use App\Models\Artista;
use App\Repositories\ArtistaRepository;
use App\Utils\Utilidad;
use DomainException;
use App\Helpers\Helper;
use Illuminate\Pagination\LengthAwarePaginator;

class ArtistaService{
    protected ArtistaRepository $repository;

    public function __construct(ArtistaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validarIdArtista($idArtista){
        $id = Utilidad::validarId($idArtista);
        $artista = $this->repository->ver($id);
        if(!$artista){
            throw new DomainException("No existe el Artista");
        }
        return $artista;
    }

    public function agregarArtist(array $datos): Artista
    {
        $datos = Helper::mayuscula($datos);
        return $this->repository->agregar($datos);
    }

    public function editarArtist(int $idArtista, array $datos): Artista
    {
        $artista = $this->validarIdArtista($idArtista);
        $datos = Helper::mayuscula($datos);
        return $this->repository->editar($artista->id_artista, $datos);
    }
    public function verArtist(int $idArtista): Artista
    {
        return $this->validarIdArtista($idArtista);
    }

    public function eliminarArtist(int $idArtista): bool
    {
        $artista = $this->validarIdArtista($idArtista);
        return $this->repository->eliminar($artista->id_artista);
    }

    public function listarArtists(): LengthAwarePaginator
    {
        return $this->repository->listar();
    }

    public function buscarArtista(?string $dato): LengthAwarePaginator
    {
        return $this->repository->buscar($dato);
    }
}
