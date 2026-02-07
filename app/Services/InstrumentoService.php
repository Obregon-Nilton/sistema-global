<?php

namespace App\Services;

use App\Models\Instrumento;
use App\Repositories\InstrumentoRepository;
use App\Utils\Utilidad;
use DomainException;
use App\Helpers\Helper;
use Illuminate\Pagination\LengthAwarePaginator;

class InstrumentoService
{
    protected InstrumentoRepository $repository;

    public function __construct(InstrumentoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validarIdInstrumento(int $idInstrumento)
    {
        $id = Utilidad::validarId($idInstrumento);
        $instrumento = $this->repository->ver($id);
        if(!$instrumento){
            throw new DomainException("No existe");
        }
        return $instrumento;
    }

    public function agregarInstrumento(array $datos): Instrumento
    {
        $datos = Helper::mayuscula($datos);
        return $this->repository->agregar($datos);
    }

    public function verInstrumento(int $idInstrumento): Instrumento
    {
        return $this->validarIdInstrumento($idInstrumento);
    }

    public function editarInstrumento(int $idInstrumento, array $datos): Instrumento
    {
        $instrumento = $this->validarIdInstrumento($idInstrumento);
        $datos = Helper::mayuscula($datos);
        return $this->repository->editar($instrumento->id_instrumento, $datos);
    }

    public function eliminarInstrumento(int $idInstrumento): bool
    {
        $instrumento = $this->validarIdInstrumento($idInstrumento);
        return $this->repository->eliminar($instrumento->id_instrumento);
    }

    public function listarInstrumentos(): LengthAwarePaginator
    {
        return $this->repository->listar();
    }
}
