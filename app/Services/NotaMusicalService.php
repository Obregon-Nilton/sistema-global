<?php
/**
 * falta repasars zervise leer codigo
 * Reglas de negocio
 * Orquestacion de repositorio
 * Transformacion de datos
 * Exceptions de negocio
 * Prosamiento reusable
 * No se hace consulta directa de sql, front, validacionbasica de Laravel (FormRequest)
 * Manejo de http o json, redirect, response, casting, mutators de model
 */
namespace App\Services;

use App\Models\NotaMusical;
use App\Repositories\NotaMusicalRepository;
use App\Utils\Utilidad;
use DomainException;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Helper;

final class NotaMusicalService{
    protected NotaMusicalRepository $repository;

    private const SIMBOLOS = [
        NotaMusical::TIPO_NATURAL => '♮',
        NotaMusical::TIPO_SOSTENIDO => '♯',
        NotaMusical::TIPO_BEMOL => '♭',
    ];

    public function __construct(NotaMusicalRepository $repository){
        $this->repository = $repository;
    }

    /** validacion de negocio */
    public function validarIdNotaMusical(int $idNota): NotaMusical
    {
        $id = Utilidad::validarId($idNota);
        $nota = $this->repository->ver($id);
        if(!$nota){
            throw new DomainException("No existe la Nota Musical");
        }
        return $nota;
    }

/** este metodo se desarrollara en otra entidad llamada afinaciones */
    public function asignarNotacionAnglosajona(array $datos) {
        $mapaAfinacion = [
            'DO_natural'     => 'C D E F G A B',
            'DO_sostenido'   => 'C# D# F F# G# A# C',
            'RE_natural'     => 'D E F# G A B C#',
            'RE_sostenido'   => 'D# F G G# A# C D',
            'RE_bemol'       => 'D♭ E♭ F G♭ A♭ B♭ C',
            'MI_natural'     => 'E F# G# A B C# D#',
            'MI_bemol'       => 'E♭ F G A♭ B♭ C D',
            'FA_natural'     => 'F G A A# C D E',
            'FA_sostenido'   => 'F# G# A# B C# D# F',
            'SOL_natural'    => 'G A B C D E F#',
            'SOL_sostenido'  => 'G# A# C C# D# F G',
            'LA_natural'     => 'A B C D E F G',
            'LA_sostenido'   => 'A# C D D# F G A',
            'SI_natural'     => 'B C# D# E F# G# A#',
            'SI_bemol'       => 'B♭ C D E♭ F G A',
        ];
        $clave = $datos['nota'] . '_' . $datos['tipo'];
        if(isset($mapaAfinacion[$clave])){
            return $mapaAfinacion[$clave];
        }
        return '';
    }

    /** Si $tipo es “natural”, “sostenido” o “bemol” → lo devuelve tal cual.  */
    public function procesarTipoDeNota(string $tipo): string
    {
        return match($tipo){ /** Bienen de modelo estas constantes */
            NotaMusical::TIPO_NATURAL,
            NotaMusical::TIPO_SOSTENIDO,
            NotaMusical::TIPO_BEMOL => $tipo,
            default => throw new DomainException("Tipo de nota musical inválido"),
        };
    }

    /** logica de negocio */
    /** Aca como parametro entra o le pasamos un objeto de tipo NotaMusical*/
   public function asignarSimbolo(NotaMusical $notaMusical): string /** Sale un string osea la nota con su simbolo */
   {    /** Toma la nota del objeto   busca el simbolo correspondiente segun el tipo, sino devuelve '' */
        return $notaMusical->nota . (self::SIMBOLOS[$notaMusical->tipo] ?? '');
    }

    public function agregarNotaMusical(array $datos): NotaMusical
    {
          $datos['nota']  = Helper::mayuscula($datos['nota']);
          $datos['tipo'] = $this->procesarTipoDeNota($datos['tipo']);
          if($this->repository->verExistencia($datos['nota'], $datos['tipo'])){
            throw new DomainException("Ya existe el tipo de nota");
          }
          return $this->repository->agregar($datos);
    }

    public function editarNotaMusical(int $id, array $datos): NotaMusical
    {
        $datos['nota'] = Helper::mayuscula($datos['nota']);
        $notaMusical = $this->validarIdNotaMusical($id);
        $datos['tipo'] = $this->procesarTipoDeNota($datos['tipo']);

        if($this->repository->verExistencia(
            $datos['nota'],
            $datos['tipo'],
            $notaMusical->id_nota
        )){
            throw new DomainException("Ya existe el tipo de nota");
          }
        return $this->repository->editar($notaMusical->id_nota, $datos);
    }

    public function verNotaMusical(int $id): NotaMusical
    {
        return $this->validarIdNotaMusical($id);
    }

    public function eliminarNotaMusical(int $id): bool
    {
        $notaMusical = $this->validarIdNotaMusical($id);
        return $this->repository->eliminar($notaMusical->id_nota);
    }

    public function listarNotasMusicales(): LengthAwarePaginator
    {
        $paginador = $this->repository->listar();
        foreach ($paginador as $nota) {
            /** nota_formateada: Se crea dinámicamente en tiempo de ejecución dentro del foreach. */
            /** PHP o laravel permite agregar propiedad solo en tiemó de ejecucion, 'nuevo atributo' */
            $nota->nota_formateada = $this->asignarSimbolo($nota);
       }
        return $paginador;
    }

    public function buscar(?string $dato): LengthAwarePaginator
    {
        $data = Utilidad::buscadorIndividual($dato);
        $paginador = $this->repository->buscadorGlobal($data);
        foreach($paginador as $nota){
            $nota->nota_formateada = $this->asignarSimbolo($nota);
        }
        return $paginador;
    }

}
