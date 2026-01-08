<?php
/**
 * Aca se define Reglas y Scopes
 * Representa la tabla
 * define la relacion
 * define casts
 * define constantes propias del dato
 * define scopes(formas de consultar)
 * pequeñas reglas del dato (no del usuario)
 * No se valida, Exceptions, logica, respuesta http y front
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

/** No a la herencia: Puede cambiar reglas del Model y romper las reglas sin que te des cuenta */
final class NotaMusical extends Model
{
    /** protected permite que el propio Model y Eloquent lo usen */
    protected $table = 'notas_musicales';
    protected $primaryKey = 'id_nota';
    public $timestamps = false;

    protected $fillable = [
        'nota',
        'tipo'
    ];

    /** $casts sirve para que Laravel trate esos campos siempre como ese tipo de dato */
    protected $casts = [
        'nota' => 'string',
        'tipo' => 'string'
    ];

    /**
     * Las constantes se usan sobre todo cuando un campo tiene varias opciones
     * son los valores que estan dentro del atributo tipos
     * */
    public const TIPO_NATURAL = 'natural';
    public const TIPO_SOSTENIDO = 'sostenido';
    public const TIPO_BEMOL = 'bemol';

    /** Encerramos todos esos valores constantes en una sola constante llamada TIPOS
     * Es array Porque contiene más de un valor
    */
    private const TIPOS = [
         self::TIPO_NATURAL,
         self::TIPO_SOSTENIDO,
         self::TIPO_BEMOL
    ];

    /** Ese constante TIPOS le metemols dentro de una funcion statica publica
     * para usar desde afuera sin romper las relgas, retornara un array
     * ['natural', 'sostenido', 'bemol'], se ujsara si queremos lista completa
     */
    public static function tiposPermitidos(): array
    {
        return self::TIPOS;
    }

    /** belongsToMany se usa cuando la tabla hija no tiene atributo extra, ahi si se conecta padrea padre */
    public function interpretaciones(): HasMany
    {
        return $this->hasMany(
            Interpretacion::class,
            'nota_id',
            'id_nota'
        );
    }

    /**Un scope se usa cuando quieres MOSTRAR registros q cumplen con una característica.*/
    /** Ejemplo de llamada: NotaMusical::porTipo(NotaMusical::TIPO_NATURAL)->get();*/

    /**Tú SOLO te encargas de pasar UN parámetro ($tipo). */
    /**Del primer parámetro ($query) NO te preocupas, Laravel lo maneja solo */

    /**Builder:
     * devuelve una consulta pero escojido una parte solo de ese tipo en este caso tipo de notas_musicales
     * En este caso es como un generico no se a especificado el tipo real
     * Este metodo sirve para usar uno de estos valore especificos, consulta a la bdd
     */
    public function scopePorTipo(Builder $query, string $tipo): Builder
    {
        /** SELECT * FROM notas_musicales WHERE tipo = 'natural'; */
        return $query->where('tipo', $tipo);
    }
    
}
