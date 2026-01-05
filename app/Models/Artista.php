<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    protected $table = 'artistas';
    protected $primaryKey = 'id_artista';
    public $timestamps = false;
    protected $fillable = ['nombre', 'nacionalidad'];

    public function notasMusicales(){ //M:M con notaMusical
         return $this->belongsToMany(NotaMusical::class, 'interpretaciones', 'artista_id', 'nota_id');
    }
}
