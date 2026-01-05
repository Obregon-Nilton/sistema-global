<?php
/**
 * aca va implementar al interface
 * Aca se define acceso a la base de datos
 * Define metodos para obtener, listar y filtrar registros
 * puede usar scopes y relaciones del model
 * pequeñas combinaciones de consultas complejas
 * No se valida, reglas de negocio, Exeptions, HTTP, JSON, front, cast
 */
namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\NotaMusical;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/** final: para que nadie herede y rompa el acceso a datos. */
final class NotaMusicalRepository implements CrudInterface{
    protected NotaMusical $model;
    private const ORDEN_NOTAS = "
        CASE nota
            WHEN 'DO' THEN 1
            WHEN 'RE' THEN 2
            WHEN 'MI' THEN 3
            WHEN 'FA' THEN 4
            WHEN 'SOL' THEN 5
            WHEN 'LA' THEN 6
            WHEN 'SI' THEN 7
        END
    ";

    public function __construct(NotaMusical $model){
        $this->model = $model;
    }

    public function agregar(array $datos): NotaMusical
    {
        return $this->model
            ->create($datos);
    }

    public function ver(int $id): ?NotaMusical{ /**devuelve NotaMusical o null */
        return $this->model->find($id);
    }

    public function editar(int $id, array $datos): ?NotaMusical{
        $nota = $this->ver($id);
        if(!$nota)return null;
        $nota->update($datos);
        return $nota;
        }

    public function eliminar(int $id): bool{
        $nota = $this->ver($id);
        return $nota ? (bool) $nota
            ->delete() : false;
    }

    /**Retorna paginador: dividido en partes pequeñas = 7*/
    public function listar(): LengthAwarePaginator{
        return $this->model
           ->orderByRaw(self::ORDEN_NOTAS) /** Ordena la nota musical segun las escalas, (Solo cuando necesitas orden personalizado o complejo:) */
           ->paginate(config('pagination.per_page')); /** Divide los resultados en paginas pequeñas, cada pag. tiene 7*/
    }

    /** Verificamos si existe los 2 datos y si es editar o agregar,
     *                                                      puede ser entero o null el ?int */
    public function verExistencia(string $nota, string $tipo, ?int $ignorarId = null): bool{
        /** pregunta si $tipo existe dentro del array que devuelve tiposPermitidos() */
        if(!in_array($tipo, NotaMusical::tiposPermitidos(), true)) {/** true: compara tipo y valor, false: solo valor */
            return false;
        }
         return $this->model
             ->where('nota', $nota) /** where nota = 'VALOR_NOTA' */
             ->where('tipo', $tipo) /** and tipo = 'VALOR_TIPO' si el $ignorarId es null ahi termina

             * “Si el ID es diferente al que quiero ignorar, cuenta ese registro.
             * Si coincide con el que quiero ignorar, no lo cuenta”.
             */
             /** $q es la consulta actual del objeto */
             ->when($ignorarId, fn($q) => $q->where('id_nota', '!=', $ignorarId)) /**sino sigue aca  and id_nota != 5 */
             /** es una funcion anonima tipo asi:
              * function($q) {
              * return $q->where('id_nota', '!=', $ignorarId);
              * }
              */
             ->exists();
    }

    /**Retorna paginador: dividido en partes pequeñas = 7*/
    public function buscadorGlobal(string $dato): LengthAwarePaginator{
                return $this->model
                    ->where(function ($q) use ($dato) {
                        $q->where('nota', 'like', "%{$dato}%")
                            ->orWhere('tipo', 'like', "%{$dato}%");
                    })
                    ->orderByRaw(self::ORDEN_NOTAS)
                    ->paginate(config('pagination.per_page'));
    }

    }


