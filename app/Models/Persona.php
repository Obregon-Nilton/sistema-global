<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Persona extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_persona';
    protected $table = 'personas';

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'telefono',
        'fecha_nacimiento',
        'rol_id'
    ];

    protected $casts = [
        'nombre' => 'string',
        'apellido' => 'string',
        'dni' => 'string',
        'telefono' => 'string'
    ];

    public function rol(){
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function musico(){
        return $this->hasOne(Musico::class, 'persona_id');
    }

    /**now() = Toma la fecha actual,
     * subYears(18) = resta o retrocede 18 años a la fecha actual, y queda en fecha exacta donde cae,
     * toDateString() = Quita la hora, devuelve solo la fecha*/
    public function scopePorEdad(Builder $query, bool $esMayor = true): Builder
    {
        $fechaLimite = Carbon::now()->subYears(18)->toDateString(); /** Guarda una fecha */
        return $esMayor /** Guardara true: si es mayor,  false: si es menor */
            ? $query->where('fecha_nacimiento', '<=', $fechaLimite)
            : $query->where('fecha_nacimiento', '>', $fechaLimite);
    }

}
