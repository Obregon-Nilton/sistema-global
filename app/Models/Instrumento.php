<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrumento extends Model
{
    protected $table = 'instrumentos';
    protected $primaryKey = 'id_instrumento';
    public $timestamps = false;

    protected $fillable = [
        'instrumento',
        'nivel',
        'categoria'
        ];

    protected $casts = [
        'instrumento' => 'string',
        'nivel' => 'string',
        'categoria' => 'string'
    ];

    /**Valores dentro del atributo nivel */
    public const TIPO_INICIO = 'inicio';
    public const TIPO_INTERMEDIO = 'intermedio';
    public const TIPO_AVANZADO = 'avanzado';

    public const NIVELES = [
        self::TIPO_INICIO,
        self::TIPO_INTERMEDIO,
        self::TIPO_AVANZADO
    ];

    public static function nivelesPermitidos(): array
    {
        return self::NIVELES;
    }

    /**Valores dentro del atributo categoria */
    public const TIPO_PRINCIPIANTE = 'principiante';
    public const TIPO_PROFESIONAL = 'profesional';
    public const TIPO_ESCENARIO = 'escenario';

    public const CATEGORIAS = [
        self::TIPO_PRINCIPIANTE,
        self::TIPO_PROFESIONAL,
        self::TIPO_ESCENARIO
    ];

    public static function categoriasPermitidos(): array
    {
        return self::CATEGORIAS;
    }

    public function interpretaciones(){
        return $this->hasMany(Interpretacion::class, 'instrumento_id');
    }
}
