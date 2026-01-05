<?php

namespace App\Services;

use App\Repositories\ArtistaRepository;
use App\Utils\Utilidad;
use DomainException;

class ArtistaService{
    protected $repository;

    public function __construct(ArtistaRepository $repository){
        $this->repository = $repository;
    }

    public function validarIdArtista($idArtista){
        $id = Utilidad::validarId($idArtista);
        if(!$id){
            throw new DomainException("No existe el Artista");
        }
        return $this->repository->ver($id);
    }

    public function validarDatosArtista(array $datos, $idArtista = null){
        $reglaNombre = 'required|min:3|max:100';
        if($idArtista){
            $reglaNombre = "required|string|min:3|max:100|unique:artistas,nombre,$idArtista,id_artista";
        }
        $reglas = [
            'nombre' => $reglaNombre,
            'nacionalidad' => 'required|string|min:3|max:50'
        ];
        $mensajes = [
            'nombre.required' => 'No se permite nombre vacío',
            'nombre.string' => 'El campo nombre debe contener solo letras',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres',
            'nombre.unique' => 'El artista ingresado ya está registrado',
            'nacionalidad.required' => 'No se permite nacionalidad vacío',
            'nacionalidad.string' => 'El campo nacionalidad debe contener solo letras',
            'nacionalidad.min' => 'El nombre debe tener al menos 3 caracteres',
            'nacionalidad.max' => 'La nacionalidad no puede superar los 50 caracteres'
        ];
        return Utilidad::validator($datos, $reglas, $mensajes, true);
    }

    public function agregarArtist(array $datos){
        $artista = $this->validarDatosArtista($datos);
        return $this->repository->agregar($artista);
    }

    public function editarArtist($idArtista, array $datos){
        $artista = $this->validarIdArtista($idArtista);
        $dataArtista = $this->validarDatosArtista($datos, $artista->id_artista);
        return $this->repository->editar($artista->id_artista, $dataArtista);
    }

    public function verArtist($idArtista){
        return $this->validarIdArtista($idArtista);
    }

    public function eliminarArtist($idArtista){
        $artista = $this->validarIdArtista($idArtista);
        return $this->repository->eliminar($artista->id_artista);
    }

    public function listarArtists(){
        return $this->repository->listar();
    }
}
