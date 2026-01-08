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

    public function scopePorArtista(Builder $query, string $artista): Builder
    {
        return $query->where('tipo', $artista);
    }

}
