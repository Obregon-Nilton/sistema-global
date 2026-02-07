<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Artista extends Model
{
    protected $table = 'artistas';
    protected $primaryKey = 'id_artista';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'nacionalidad'
    ];

    protected $casts = [
        'nombre' => 'string',
        'nacionalidad' => 'string'
    ];

    public function notasMusicales(){ //M:M con notaMusical
         return $this->belongsToMany(NotaMusical::class, 'interpretaciones', 'artista_id', 'nota_id');
    }

    /** Este metodo ira en interpretaciones, ademas las erntidades tendrab su propio
     * logica yse agregaran o m odificaran por separado
     * y en entidad interpretaciones se agregara un interpretacion con datos ya existentes
     * al eñliminar eso no afecta a los demas entidades
     */
    public function scopeFiltrarPorArtista(Builder $query, string $artista): Builder
    {
        return $query->where('tipo', $artista);
    }

}
